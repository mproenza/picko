<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\SharedTravel;
use Cake\ORM\TableRegistry;
use App\Util\StringsUtil;
use App\Util\EmailsUtil;
use App\Util\TimeUtil;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Exception\InternalErrorException;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Exception\NotFoundException;
use App\Error\ExpiredLinkException;

class SharedTravelsController extends AppController {
    
    private static $NOTIFICATION_TYPE_DATE_CHANGED = 0;
    private static $NOTIFICATION_TYPE_CANCELLED = 1;
    private static $NOTIFICATION_TYPE_PICKUP_ADDRESS_CHANGED = 2;
    
    private $ip_blacklist = [''];
    
    public function initialize() {
        parent::initialize();
        
        $this->loadComponent('SharedTravelActions');
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['home', 'book', 'thanks', 'activate', 'view', /*'index230216', 'admin', 'cancel', 'changeDate'*/]);
        
        $this->viewBuilder()->setLayout('shared_rides');
    }

    public function home() {$this->viewBuilder()->setLayout('homepage');}
    
    public function index() {
        $this->paginate = ['order'=>['date'=>'ASC', 'departure_time'=>'ASC', 'id'=>'ASC'], 'limit'=>100];
        $this->set('travels', $this->paginate($this->SharedTravels, ['conditions'=> ['email !=' => 'martin@yotellevocuba.com'] ]));
    }

    public function book($routeSlug = null) {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            // Sanity checks
            if(in_array($this->request->clientIp(), $this->ip_blacklist) || $this->request->clientIp() == null || empty($this->request->clientIp()) ) 
                throw new \Cake\Network\Exception\ForbiddenException();
            
            // Proteccion contra ataque en Noviembre 2018
            $emailName = strstr($this->request->getData('email'), '@', true);
            if(strtolower($emailName) == strtolower($this->request->getData('name_id')))
                throw new \Cake\Network\Exception\ForbiddenException();
            // End of Sanity checks
                    
                    
            // Generar los token
            $idToken = StringsUtil::getWeirdString();
            $activationToken = StringsUtil::getWeirdString();
            
            // Poner datos iniciales a la solicitud
            $this->request->data('id_token', $idToken);
            $this->request->data('activation_token', $activationToken);
            $this->request->data('lang', ini_get('intl.default_locale'));
            $this->request->data('state', SharedTravel::$STATE_PENDING);
            $this->request->data('activated', false);
            $this->request->data('final_state', null);
            $this->request->data('coupling_id', null);
            $this->request->data('original_date', $this->request->getData('date'));
            $this->request->data('from_ip', $this->request->clientIp());

            $STTable = TableRegistry::get('SharedTravels');
            $STEntity = $STTable->newEntity($this->request->getData());
            
            $errors = $STEntity->errors();
            if ($errors) {
                // TODO: Do work to show error messages.
            }
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            // Salvar la solicitud
            $OK = $STTable->save($STEntity,
                    ['track_history' =>
                        [
                            'owner' => $this->Auth->user(),
                            'event_type' => SharedTravel::$EVENT_TYPE_CREATED,
                            'notify_to' =>  $this->_getUsersToSync()
                        ]
                    ]);
            
            if ($OK) {

                // TODO: Ver si se debe enviar el correo de verificacion
                
                // Obtener la solicitud para que los datos vengan formateados (ej. la fecha)
                $request = $STTable->findByToken($idToken);

                // Correo con link de activacion
                $OK = EmailsUtil::email(
                    $request['SharedTravel']['email'],
                    __d('shared_travels', 'Confirma tu solicitud de viaje compartido'),
                    array('request' => $request),
                    'hola',
                    'activate_request',
                    array('lang'=>ini_get('intl.default_locale'), 'enqueue'=>false)
                );

                // Email de 'Nueva solicitud' para mi
                $Email = new Email('hola');
                $Email->to('martin@yotellevocuba.com')
                        ->subject('Nueva solicitud: PickoCar #'.$request['SharedTravel']['id'])
                        ->send('http://pickocar.com/shared-rides/view/'.$request['SharedTravel']['id_token']);
                
            }

            if($OK) {
                
                $datasource->commit();
                
                // Guardar algunos datos en la session para si el cliente quiere crear mas solicitudes que no tenga que repetirlas
                // TODO: Guardarlos en una Cookie???
                $session = $this->request->session();
                $session->write('user_email', $request['SharedTravel']['email']);
                $session->write('user_people_count', $request['SharedTravel']['people_count']);
                $session->write('user_name_id', $request['SharedTravel']['name_id']);
                
                return $this->redirect(['controller'=>'shared-rides', 'action' => 'thanks', '?'=>['t'=>$idToken]]);
            } else {
                $datasource->rollback();
                $this->Flash->error(__('Ocurrió un error realizando la solicitud.'), ['key'=>'form']);
            }
            
        }
        
        // DATOS PARA /shared-rides/book            
        $route = SharedTravel::_routeFromSlug($routeSlug);
        if($route == null) throw new NotFoundException ();
        
        $this->set('route', SharedTravel::_routeFull($route));
        $this->viewBuilder()->setLayout('homepage');
    }

    public function thanks() {// Esta es una action que no hace ningun procesamiento, solamente es una thank you page
        if (!isset($this->request->query['t'])) throw new NotFoundException ();

        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findByToken($this->request->query['t']);

        if ($request == null || empty($request)) throw new NotFoundException();

        $this->set('request', $request);
    }
    
    
    public function activate($activationToken) {
        $STTable = TableRegistry::get('SharedTravels');
        
        $request = $STTable->findByActivationToken($activationToken);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        if($request['SharedTravel']['activated']) throw new ExpiredLinkException();
        // TODO: Verificar que la solicitud no este expirada
        
        $datasource = ConnectionManager::get('default');
        $datasource->begin();
        
        $result = $this->doActivate($request); // Aqui es donde se hace todo el procesamiento!!!
        $OK = $result['success'];
        
        if($OK) {
            // Email de 'Solicitud activada' para mi
            $Email = new Email('compartido');
            $Email->to('martin@yotellevocuba.com')
            ->subject('ACTIVADA: PickoCar #'.$request['SharedTravel']['id'].' - [['.$request['SharedTravel']['id_token'].']]')
            ->send('http://pickocar.com/shared-rides/view/'.$request['SharedTravel']['id_token']);
            
            $datasource->commit();
            $this->set('request', $request);
            
            // Si se confirmo el viaje automaticamente (ej. se emparejo con otro solicitud, o es de 4 pax), mostrar otra vista
            if($result['confirmed']) {
                $this->set('confirmed_reason', $result['confirmed_reason']);
                $this->render('activate_confirmed');
            }
        } else {
            $datasource->rollback();
            throw new InternalErrorException();
        }
    }
    
    private function doActivate(&$request) {
        $STTable = TableRegistry::get('SharedTravels');
        
        // Actualizar estado de la solicitud
        //$OK = $STTable->updateAll(['activated'=>true, 'state'=>SharedTravel::$STATE_ACTIVATED], ['id' => $request['SharedTravel']['id']]);
        $entity = $STTable->updateField(['activated'=>true, 'state'=>SharedTravel::$STATE_ACTIVATED], $request['SharedTravel']['id']);
        $OK = $STTable->save($entity, 
                ['track_history' =>
                    [
                        'owner' => $this->Auth->user(),
                        'event_type' => SharedTravel::$EVENT_TYPE_ACTIVATED,
                        'notify_to' =>  $this->_getUsersToSync()
                    ]
                ]);        
        
        $confirmed = false;
        $confirmedReason = null;
        $coupled = null; // default: no hay emparejamientos
        
        if($OK) {
            
            // Si la solicitud es de 4 personas, confirmarla directamente
            if($request['SharedTravel']['people_count'] == 4) {
                $OK = $STTable->confirmRequest($request);
                
                // Correo a facilitador con el viaje completo
                $facilitator = Configure::read('shared_rides_facilitator');
                if($OK) $OK = EmailsUtil::email(
                    $facilitator['email'],
                    'Viaje de 4 pax completo',
                    ['request' => $request], 
                    'compartido', 
                    'new_full_ride',
                    ['lang'=>'es']
                );
                
                $confirmed = true;
                $confirmedReason = __d('shared_travels', 'llena uno de nuestros autos de 4 plazas');
                
            } else {
                /*// Intentar emparejar con otras solicitudes
                $couplings = $STTable->findCouplings($request);
                
                if($couplings != null) {// Se encontro coupling!
                    $coupled = array_merge ($couplings, array($request));

                    // Crear un nuevo id para el emparejamiento
                    $connection = ConnectionManager::get('default');
                    $couplingId = $connection->execute('select coalesce(max(coupling_id) + 1, 1) as new_id from shared_travels')->fetchAll('assoc');
                    
                    // Crear emparejamientos y confirmar todas las solicitudes emparejadas
                    foreach ($coupled as $c) {
                        $OK = $STTable->updateAll(['coupling_id'=>$couplingId[0]['new_id']], ['id'=>$c['SharedTravel']['id']]);

                        if($OK) $OK = $STTable->confirmRequest($c);

                        if(!$OK) break;
                    }

                    // Correo a facilitador con el viaje completo
                    $facilitator = Configure::read('shared_rides_facilitator');
                    if($OK) $OK = EmailsUtil::email(
                        $facilitator['email'],
                        'Solicitudes emparejadas (4 pax completo)',
                        array('requests' => $coupled ), 
                        'compartido',
                        'new_requests_coupled',
                        ['lang'=>'es']
                    );
                    
                    $confirmed = true;
                    $confirmedReason = __d('shared_travels', 'fue emparejada con otras solicitudes para llenar las 4 plazas de uno de nuestros autos');

                } else { // No se encontraron couplings*/
                    
                    // Buscar si este cliente tiene otras solicitudes activadas
                    $all_requests = $STTable->findActiveRequests($request['SharedTravel']['email'], ['hydrate'=>true]);

                    // Buscar si tiene otras solicitudes activadas que no sean esta
                    $countOther = 0;
                    foreach ($all_requests as $r) {
                        if($r->id == $request['SharedTravel']['id']) continue;
                        $countOther++;
                    }
                    
                    // Escoger el asistente que va a atender esta solicitud
                    $customer_assistant = 'customer_assistant_'.$request['SharedTravel']['lang'];
                    
                    // Enviar email del asistente segun sea el caso
                    if($countOther == 0) {// Si es la primera solicitud (no tiene otras solicitudes), enviarle el correo de bienvenida del operador
                        $OK = EmailsUtil::email(
                                $request['SharedTravel']['email'], 
                                __d('shared_travels', 'Tenemos los datos de su solicitud'),
                                array('request' => $request), 
                                $customer_assistant, 
                                'assistant_intro',
                                array('lang'=>$request['SharedTravel']['lang'])
                            );
                    } else { // Si tiene otras solicitudes, enviarle el correo de resumen
                        $OK = EmailsUtil::email(
                                $request['SharedTravel']['email'], 
                                __d('shared_travels', 'Tenemos los datos de su nueva solicitud'),
                                array('request' => $request, 'all_requests'=>$all_requests),
                                $customer_assistant,
                                'requests_summary',
                                array('lang'=>$request['SharedTravel']['lang'])
                            );
                    }

                    // Correo a cordinador para que confirme la solicitud
                    if($OK) {
                        $facilitator = Configure::read('shared_rides_facilitator');
                        $OK = EmailsUtil::email(
                            $facilitator['email'],
                            '#'.$request['SharedTravel']['id'].' '.$request['SharedTravel']['origin'].'-'.$request['SharedTravel']['destination'].' [['.$request['SharedTravel']['id_token'].']]',
                            array('request' => $request), 
                            'compartido', 
                            'new_request',
                            ['lang'=>'es']
                            );
                    }
                //}
            }
        }
        
        // Ponerle algunos datos a la solicitud para que en la vista salga bien
        if($OK) {
            if($confirmed) $request['SharedTravel']['state'] = SharedTravel::$STATE_CONFIRMED;
            else $request['SharedTravel']['state'] = SharedTravel::$STATE_ACTIVATED;
        }
        
        return array('success'=>$OK, 'confirmed'=>$confirmed, 'confirmed_reason'=>$confirmedReason, 'coupled'=>$coupled);
    }
    
    public function view($token) {
        
        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findByToken($token);

        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        if(!$request['SharedTravel']['activated']) throw new NotFoundException();
        
        $this->set('request', $request);
    }
    
    
    public function admin($id) {
        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findById($id);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        
        $this->set('request', $request);
    }
    
    public function confirm($idToken) {
        
        $datasource = \Cake\Datasource\ConnectionManager::get('default');
        $datasource->begin();
        
        $OK = $this->SharedTravelActions->confirm($idToken);

        if(!$OK) {
            // TODO: Enviar notificacion de fallo?
            $datasource->rollback();
            throw new \Cake\Network\Exception\InternalErrorException('Ocurrió un error confirmando la solicitud');
        } 
        
        $datasource->commit();
        $this->set([
            'success' => true
        ]); 
    }
    
    public function changeDate($id) {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            $STTable = TableRegistry::get('SharedTravels');
            
            $request = $STTable->updateField(
                    ['date' => new \Cake\I18n\FrozenTime(str_replace('-', '/', TimeUtil::dmY_to_Ymd($this->request->getData('date'))))],
                    $id,
                    ['keep_old_value'=>true]);
            
            $OK = $STTable->save($request, 
                ['track_history' =>
                    [
                        'event_type' => SharedTravel::$EVENT_TYPE_INFO_EDITED,
                        'notify_to' =>  $this->_getUsersToSync(),
                        'descriptor' => [
                            'field_edited'=>'date',
                            'old_value'=>$request->old_date,
                            'new_value'=>$request->date,
                        ]
                    ]
                ]);
            
            if(!$request) {
                $datasource->rollback();
                throw new Exception('Error actualizando la fecha.');
            }
            
            // Notificar al coordinador
            $this->_notify(SharedTravelsController::$NOTIFICATION_TYPE_DATE_CHANGED, $request);
            
            $datasource->commit();
            
            return $this->redirect($this->referer());
            
        } else throw new MethodNotAllowedException();
    }
    
    public function changePickupAddress($id) {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            $STTable = TableRegistry::get('SharedTravels');
            
            $request = $STTable->updateField(
                    ['address_origin' => $this->request->getData('address_origin')],
                    $id,
                    ['keep_old_value'=>true]);
            
            $OK = $STTable->save($request, 
                ['track_history' =>
                    [
                        'event_type' => SharedTravel::$EVENT_TYPE_INFO_EDITED,
                        'notify_to' =>  $this->_getUsersToSync(),
                        'descriptor' => [
                            'field_edited'=>'address_origin',
                            'old_value'=>$request->old_address_origin,
                            'new_value'=>$request->address_origin,
                        ]
                    ]
                ]);
            
            if(!$request) {
                $datasource->rollback();
                throw new Exception('Error actualizando la direccion de recogida.');
            }
            
            // Notificar al coordinador
            $this->_notify(SharedTravelsController::$NOTIFICATION_TYPE_PICKUP_ADDRESS_CHANGED, $request);
            
            $datasource->commit();
            
            return $this->redirect($this->referer());
            
        } else throw new MethodNotAllowedException();
    }
    
    public function cancel($token) {
        
        $datasource = ConnectionManager::get('default');
        $datasource->begin();
        
        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->updateField(['state'=>SharedTravel::$STATE_CANCELLED], ['token'=>$token]);
        $OK = $STTable->save($request, 
                ['track_history' =>
                    [
                        'event_type' => SharedTravel::$EVENT_TYPE_CANCELLED,
                        'notify_to' =>  $this->_getUsersToSync()
                    ]
                ]);
        
        if(!$request) {
            $datasource->rollback();
            throw new Exception('Error cancelando la solicitud.');
        }

        // Avisar al coordinador solo si la solicitud no ha expirado y esta activada
        if(!$request->date->isPast() && $request->activated) {
            $this->_notify(SharedTravelsController::$NOTIFICATION_TYPE_CANCELLED, $request);
        }
        
        $datasource->commit();
        
        return $this->redirect($this->referer());
    }
    
    public function setFinalState($id) {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            $STTable = TableRegistry::get('SharedTravels');
            $request = $STTable->updateField(['final_state'=>$this->request->getData('final_state')], $id);
            $OK = $STTable->save($request);
            
            if(!$request) {
                $datasource->rollback();
                $this->setErrorMessage ('Error actualizando el estado final.');
            }
            
            $datasource->commit();
            
            return $this->redirect($this->referer());
            
        } else throw new MethodNotAllowedException();
    }
    
    private function _notify($notificationType, SharedTravel $request) {
        
        $facilitator = Configure::read('shared_rides_facilitator');
        
        if($notificationType == SharedTravelsController::$NOTIFICATION_TYPE_DATE_CHANGED) {
            $notice = 'CAMBIO FECHA > PickoCar #'.$request->id.' | '.$request->getOriginName().' - '.$request->getDestinationName();
            EmailsUtil::email(
                $facilitator['email'],
                $notice,
                ['request' => $request],
                'aviso', 
                'notifications_facilitator/request_change_date',
                ['lang'=>'es']
            );
        } 
        
        else if($notificationType == SharedTravelsController::$NOTIFICATION_TYPE_CANCELLED) {
            $notice = 'CANCELADO > PickoCar #'.$request->id. ' | '.TimeUtil::prettyDate($request->date, false).' | '.$request->getOriginName().' - '.$request->getDestinationName();
            EmailsUtil::email(
                $facilitator['email'],
                $notice,
                array('request' => $request),
                'aviso', 
                'notifications_facilitator/request_cancelled',
                ['lang'=>'es']
            );
        }
    }
    
    private function _getUsersToSync($eventType = null) {
        
        $UsersTable = TableRegistry::get('CakeDC/Users.Users');
        
        $users = $UsersTable->find()
                    ->where([
                        'role IN'=>['admin', 'operator']
                    ])
                    ->toArray();
        
        return array_column($users, 'id');
    }

}