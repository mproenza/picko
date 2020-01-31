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
    private static $NOTIFICATION_TYPE_DROPOFF_ADDRESS_CHANGED = 3;
    private static $NOTIFICATION_TYPE_CONTACTS_CHANGED = 4;
    private static $NOTIFICATION_TYPE_NAME_CHANGED = 5;
    private static $NOTIFICATION_TYPE_DEPARTURE_TIME_CHANGED = 6;
    private static $NOTIFICATION_TYPE_PAX_CHANGED = 7;
    
    private $ip_blacklist = [''];
    
    public function initialize() {
        parent::initialize();
        
        $this->loadComponent('SharedTravelActions');
    }
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['home', 'book', 'thanks', 'activate', 'view', 'bookHavCfgTri', 'bookTaxiCombo' /*'index230216', 'admin', 'cancel', 'changeDate'*/]);
        
        $this->viewBuilder()->setLayout('shared_rides');
    }

    public function home() {
        $this->viewBuilder()->setLayout('mobirise/empty');
        $this->render('mobirise/home');
        
    }
    
    public function index() {
        // Hago la paginacion aqui con una query porque es la unica forma en que se obtienen bien los resultados ordenados como quiero, no se por que...
        $this->paginate = ['limit'=>100];        
        $query = $this->SharedTravels->find()
                ->where(['email !=' => 'martin@yotellevocuba.com'])
                ->order([
                    'SharedTravels.date', 
                    "FIELD(state, 'C', 'A', 'X', 'P')", // Ordenar por estado para que salgan agrupados
                    'SharedTravels.departure_time', 
                    '1000 * SharedTravels.origin_id + SharedTravels.destination_id' // Esto es para ordenar por pares origen-destino
                    ]);
        $results = $this->paginate($query);
        
        $this->set('travels', $results);
    }

    public function book($routeSlug = null) {
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!$this->_checkSecurity()) throw new \Cake\Network\Exception\ForbiddenException();
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            $result = $this->_doBook($this->request->getData());
            $OK = $result['success'];
            $request = $result['request'];

            if($OK) {
                
                $datasource->commit();
                
                // Guardar algunos datos en la session para si el cliente quiere crear mas solicitudes que no tenga que repetirlas
                // TODO: Guardarlos en una Cookie???
                $session = $this->request->session();
                $session->write('user_email', $request['SharedTravel']['email']);
                $session->write('user_people_count', $request['SharedTravel']['people_count']);
                $session->write('user_name_id', $request['SharedTravel']['name_id']);
                
                return $this->redirect(['controller'=>'shared-rides', 'action' => 'thanks', '?'=>['t'=>$request['SharedTravel']['id_token']]]);
            } else {
                $datasource->rollback();
                $this->Flash->error(__('Ocurrió un error realizando la solicitud.'), ['key'=>'form']);
            }
        }
        
        // DATOS PARA /shared-rides/book
        $route = SharedTravel::_routeFromSlug($routeSlug);
        if($route == null) throw new NotFoundException ();
        
        $this->set('route', SharedTravel::_routeFull($route));
        $this->viewBuilder()->setLayout('mobirise/empty');
    }
    
    public function bookHavCfgTri() {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if(!$this->_checkSecurity()) throw new \Cake\Network\Exception\ForbiddenException();
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            $havOrigin = $this->request->getData('address_origin_havana');
            $cfgDestination = $this->request->getData('address_destination_cienfuegos');
            $cfgOrigin = $this->request->getData('address_origin_cienfuegos');
            $triDestination = $this->request->getData('address_destination_trinidad');
            
            // HAV - CFG
            $requestHavCfg = $this->request->getData();
            $requestHavCfg['address_origin'] = $havOrigin;
            $requestHavCfg['address_destination'] = $cfgDestination;
            $requestHavCfg['people_count'] = 2;
            $requestHavCfg['departure_time'] = 8;
            $requestHavCfg['discount_total'] = 1;
            $requestHavCfg['modality_code'] = 'HABCFG';
            $requestHavCfg = array_merge($requestHavCfg, SharedTravel::_routeFromSlug('taxi-habana--cienfuegos'));
            
            // CFG - TRI
            $requestCfgTri = $this->request->getData();
            $requestCfgTri['address_origin'] = $cfgOrigin;
            $requestCfgTri['address_destination'] = $triDestination;
            $requestCfgTri['people_count'] = 2;
            $requestCfgTri['departure_time'] = 17;
            $requestCfgTri['discount_total'] = 10;
            $requestCfgTri['modality_code'] = 'CFGTRI';
            $requestCfgTri = array_merge($requestCfgTri, SharedTravel::_routeFromSlug('taxi-cienfuegos--trinidad'));
            
            
            $result = $this->_doBook($requestHavCfg);
            $OK = $result['success'];
            $request1 = $result['request'];
            if(!$OK) {
                $datasource->rollback();
                $this->Flash->error(__('Ocurrió un error realizando la solicitud.'), ['key'=>'form']);
            }
            
            $result = $this->_doBook($requestCfgTri);
            $OK = $result['success'];
            $request2 = $result['request'];
            if(!$OK) {
                $datasource->rollback();
                $this->Flash->error(__('Ocurrió un error realizando la solicitud.'), ['key'=>'form']);
            }            
                
            if($OK) {
                $datasource->commit();
                /*// Guardar algunos datos en la session para si el cliente quiere crear mas solicitudes que no tenga que repetirlas
                // TODO: Guardarlos en una Cookie???
                $session = $this->request->session();
                $session->write('user_email', $request['SharedTravel']['email']);
                $session->write('user_people_count', $request['SharedTravel']['people_count']);
                $session->write('user_name_id', $request['SharedTravel']['name_id']);*/

                return $this->redirect(['controller'=>'shared-rides', 'action' => 'thanks', 
                    '?'=>[
                        't1'=>$request1['SharedTravel']['id_token'], 
                        't2'=>$request2['SharedTravel']['id_token']]]);
            }
            
            return $this->redirect($this->referer());
            
        }
    }
    
    public function bookTaxiCombo() {
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $localityId1 = $this->request->getData('origin_id_1');
            $localityId2 = $this->request->getData('destination_id_1');
            $localityId3 = $this->request->getData('destination_id_2');
            
            if(!$this->_checkSecurity()) throw new \Cake\Network\Exception\ForbiddenException();
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
        
            $request1 = $this->request->getData();
            $request1['address_origin'] = $this->request->getData('address_origin_1');
            $request1['address_destination'] = $this->request->getData('address_destination_1');
            $request1['date'] = $this->request->getData('date_route_1') != null?
                    $this->request->getData('date_route_1')
                    :$this->request->getData('date');
            $request1['departure_time'] = $this->request->getData('departure_time_route_1');
            $request1['people_count'] = 2;
            $request1['modality_code'] = SharedTravel::$localities[$localityId1]['code'].SharedTravel::$localities[$localityId2]['code'];
            $request1 = array_merge($request1, SharedTravel::_routeFromOriginDestination($localityId1, $localityId2));

            $request2 = $this->request->getData();
            $request2['address_origin'] = $this->request->getData('address_origin_2');
            $request2['address_destination'] = $this->request->getData('address_destination_2');
            $request2['date'] = $this->request->getData('date_route_2') != null?
                    $this->request->getData('date_route_2')
                    :$this->request->getData('date');
            $request2['departure_time'] = $this->request->getData('departure_time_route_2');
            $request2['people_count'] = 2;
            $request2['modality_code'] = SharedTravel::$localities[$localityId2]['code'].SharedTravel::$localities[$localityId3]['code'];
            $request2 = array_merge($request2, SharedTravel::_routeFromOriginDestination($localityId2, $localityId3));

            $result = $this->_doBook($request1);
            $OK = $result['success'];
            $route1 = $result['request'];
            if(!$OK) {
                $datasource->rollback();
                $this->Flash->error(__('Ocurrió un error realizando la solicitud.'), ['key'=>'form']);
            }

            $result = $this->_doBook($request2);
            $OK = $result['success'];
            $route2 = $result['request'];
            if(!$OK) {
                $datasource->rollback();
                $this->Flash->error(__('Ocurrió un error realizando la solicitud.'), ['key'=>'form']);
            }            

            if($OK) {
                $datasource->commit();
                /*// Guardar algunos datos en la session para si el cliente quiere crear mas solicitudes que no tenga que repetirlas
                // TODO: Guardarlos en una Cookie???
                $session = $this->request->session();
                $session->write('user_email', $request['SharedTravel']['email']);
                $session->write('user_people_count', $request['SharedTravel']['people_count']);
                $session->write('user_name_id', $request['SharedTravel']['name_id']);*/

                return $this->redirect(['controller'=>'shared-rides', 'action' => 'thanks', 
                    '?'=>[
                        't1'=>$route1['SharedTravel']['id_token'], 
                        't2'=>$route2['SharedTravel']['id_token']]]);
            }
        }
        
        // Cualquier metodo que no sea POST o PUT -> ERROR
        throw new \Cake\Network\Exception\MethodNotAllowedException();
    }
    
    private function _checkSecurity() {
        $OK = true;
        
        if(in_array($this->request->clientIp(), $this->ip_blacklist) || $this->request->clientIp() == null || empty($this->request->clientIp()) ) 
            $OK = false;

        // Proteccion contra ataque en Noviembre 2018
        $emailName = strstr($this->request->getData('email'), '@', true);
        if(strtolower($emailName) == strtolower($this->request->getData('name_id')))
            $OK = false;
        
        return $OK;
    }
    
    private function _doBook(array $request) {
        // Generar los token
        $idToken = StringsUtil::getWeirdString();
        $activationToken = StringsUtil::getWeirdString();

        // Poner datos iniciales a la solicitud
        $request['id_token'] = $idToken;
        $request['activation_token'] =  $activationToken;
        $request['lang'] =  ini_get('intl.default_locale');
        $request['state'] =  SharedTravel::$STATE_PENDING;
        $request['activated'] =  false;
        $request['final_state'] =  null;
        $request['coupling_id'] =  null;
        $request['original_date'] =  $this->request->getData('date');
        $request['from_ip'] =  $this->request->clientIp();

        $STTable = TableRegistry::get('SharedTravels');
        $STEntity = $STTable->newEntity($request);

        $errors = $STEntity->errors();
        if ($errors) {
            // TODO: Do work to show error messages.
        }

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
        
        return ['success'=>$OK, 'request'=>$request];
    }

    public function thanks() {// Esta es una action que no hace ningun procesamiento, solamente es una thank you page
        if (!isset($this->request->query['t'])) {
            // Si no tiene t, entonces debe tener t1 y t2 (combo)
            if(!isset($this->request->query['t1']) || !isset($this->request->query['t2']))
                throw new NotFoundException ();
        }
        
        $STTable = TableRegistry::get('SharedTravels');
        if(isset($this->request->query['t'])) {
            $request = $STTable->findByToken($this->request->query['t']);

            if ($request == null || empty($request)) throw new NotFoundException();

            $this->set('request', $request);
            
        } else { // Deben estar t1 y t2
            $request1 = $STTable->findByToken($this->request->query['t1']);
            $request2 = $STTable->findByToken($this->request->query['t2']);
            
            if ($request1 == null || empty($request1) ||
                $request2 == null || empty($request2)) throw new NotFoundException();
            
            $this->set('request1', $request1);
            $this->set('request2', $request2);
            
            $this->render('thanks-combo');
        }
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
                $OK = $STTable->confirmRequest($entity);
                
                // Correo a facilitador con el viaje completo
                $facilitator = Configure::read('shared_rides_facilitator');
                if($OK) $OK = EmailsUtil::email(
                    $facilitator['email'],
                    'Viaje de 4 pax completo',
                    ['request' => $request], 
                    'compartido', 
                    'notifications_facilitator/new_full_ride',
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
                            'notifications_facilitator/new_request',
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
        
        return $this->redirect($this->referer());
    }
    
    public function changeDate($id) {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            $request = $this->_editField($id, ['date' => new \Cake\I18n\FrozenTime(str_replace('-', '/', TimeUtil::dmY_to_Ymd($this->request->getData('date'))))]);
            
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
    
    public function changeName($id) {
        return $this->changeFieldValue($id, 'name_id', SharedTravelsController::$NOTIFICATION_TYPE_NAME_CHANGED);
    }
    public function changePax($id) {
        return $this->changeFieldValue($id, 'people_count', SharedTravelsController::$NOTIFICATION_TYPE_PAX_CHANGED);
    }
    public function changeDepartureTime($id) {
        return $this->changeFieldValue($id, 'departure_time', SharedTravelsController::$NOTIFICATION_TYPE_DEPARTURE_TIME_CHANGED);
    }
    public function changePickupAddress($id) {
        return $this->changeFieldValue($id, 'address_origin', SharedTravelsController::$NOTIFICATION_TYPE_PICKUP_ADDRESS_CHANGED);
    }
    public function changeDropoffAddress($id) {
        return $this->changeFieldValue($id, 'address_destination', SharedTravelsController::$NOTIFICATION_TYPE_DROPOFF_ADDRESS_CHANGED);
    }
    public function changeContactInfo($id) {
        return $this->changeFieldValue($id, 'contacts', SharedTravelsController::$NOTIFICATION_TYPE_CONTACTS_CHANGED);
    }
    public function discount($id) {
        return $this->changeFieldValue($id, 'discount_total');
    }
    public function fee($id) {
        return $this->changeFieldValue($id, 'fee_total');
    }
    private function changeFieldValue($id, $fieldName, $notificationType = -1) {
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $datasource = ConnectionManager::get('default');
            $datasource->begin();
            
            $request = $this->_editField($id, [$fieldName => $this->request->getData($fieldName)]);
            
            if(!$request) {
                $datasource->rollback();
                throw new Exception('Error actualizando la solicitud.');
            }
            
            // Notificar al coordinador
            $this->_notify($notificationType, $request);
            
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
            
            $request = $this->_editField($id, ['final_state'=>$this->request->getData('final_state')]);
            
            if(!$request) {
                $datasource->rollback();
                $this->setErrorMessage ('Error actualizando el estado final.');
            }
            
            $datasource->commit();
            
            return $this->redirect($this->referer());
            
        } else throw new MethodNotAllowedException();
    }
    
    private function _editField($id, array $field) {
        
        $fieldName = array_keys($field)[0];
        $oldFieldName = 'old_'.$fieldName;
        $fieldValue = $field[$fieldName];

        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->updateField($field, $id);
        $STTable->save($request,
                ['track_history' =>
                    [
                        'event_type' => SharedTravel::$EVENT_TYPE_INFO_EDITED,
                        'notify_to' =>  $this->_getUsersToSync(),
                        'descriptor' => [
                            'field_edited'=>$fieldName,
                            'old_value'=>$request->$oldFieldName,
                            'new_value'=>$fieldValue,
                        ]
                    ]
                ]);
        
        return $request;
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
                        'role IN'=>['admin', 'operator', 'coordinator']
                    ])
                    ->toArray();
        
        return array_column($users, 'id');
    }
    
    
    
    // TRANSACTIONAL EMAILS
    public function sendReconfirmationEmail($idToken) {
        
        $datasource = \Cake\Datasource\ConnectionManager::get('default');
        $datasource->begin();
        
        $OK = $this->SharedTravelActions->sendReconfirmationEmail($idToken);

        if(!$OK) {
            // TODO: Enviar notificacion de fallo?
            $datasource->rollback();
            throw new \Cake\Network\Exception\InternalErrorException('Ocurrió un error enviando el correo de reconfirmación de la solicitud');
        } 
        
        $datasource->commit();
        
        return $this->redirect($this->referer());
    }

}