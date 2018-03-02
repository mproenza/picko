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

class SharedTravelsController extends AppController {

    public function home() {
        $this->viewBuilder()->setLayout('shared_rides');
    }
    
    public function index() {
        $this->paginate = ['order'=>['SharedTravel.date'=>'ASC', 'SharedTravel.id'=>'ASC'], 'limit'=>100];
        $this->set('travels', $this->paginate($this->SharedTravels, ['conditions'=> ['email !=' => 'martin@yotellevocuba.com'] ]));
        
        $this->viewBuilder()->setLayout('shared_rides');
    }

    public function create() {
        if ($this->request->is('post') || $this->request->is('put')) {

            // Generar los token
            $idToken = StringsUtil::getWeirdString();
            $activationToken = StringsUtil::getWeirdString();
            
            // Poner datos iniciales a la solicitud
            $this->request->data('id_token', $idToken);
            $this->request->data('activation_token', $activationToken);
            $this->request->data('lang', ini_get('intl.default_locale'));
            $this->request->data('state', SharedTravel::$STATE_PENDING);
            $this->request->data('original_date', $this->request->getData('date'));

            $STTable = TableRegistry::get('SharedTravels');
            $STEntity = $STTable->newEntity($this->request->getData());

            // Salvar la solicitud
            $OK = $STTable->save($STEntity);

            if ($OK) {

                // Ver si se debe enviar el correo de verificacion
                $mustVerify = true;// TODO: Por ahora vamos siempre a enviar un correo de activacion de la solicitud

                if ($mustVerify) {
                    // Obtener la solicitud para que los datos vengan formateados (ej. la fecha)
                    $request = $STTable->findByToken($idToken);

                    $OK = EmailsUtil::email(
                        $request['SharedTravel']['email'],
                        __d('shared_travels', 'Confirma tu solicitud de viaje compartido'),
                        array('request' => $request),
                        'no_responder',
                        'activate_request',
                        array('lang'=>Configure::read('Config.language'), 'enqueue'=>false)
                    );
                    
                    // Email para mi
                    $Email = new Email('no_responder');
                    $Email->to('martin@yotellevocuba.com')->subject('Nueva solicitud')->send('Hay una nueva solicitud...');
                } else {
                    return $this->redirect(array('action' => 'activate/' . $activationToken));
                }
            }


            if($OK) return $this->redirect(['controller'=>'shared-rides', 'action' => 'thanks?t=' . $idToken]);

            $this->setErrorMessage(__('Ocurrió un error realizando la solicitud.'));
        }

        if (!isset($this->request->query['s'])) throw new NotFoundException ();
        if (!array_key_exists($this->request->query['s'], SharedTravel::$modalities)) throw new NotFoundException();
    }

    public function thanks() {// Esta es una action que no hace ningun procesamiento, solamente es una thank you page
        if (!isset($this->request->query['t'])) throw new NotFoundException ();

        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findByToken($this->request->query['t']);

        if ($request == null || empty($request)) throw new NotFoundException();


        $this->viewBuilder()->setLayout('shared_rides');
        $this->set('request', $request);
    }
    
    
    
    public function activate($activationToken) {
        $this->viewBuilder()->setLayout('shared_rides');
        
        $STTable = TableRegistry::get('SharedTravels');
        
        $request = $STTable->findByActivationToken($activationToken);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        //if($request['SharedTravel']['activated']) throw new ExpiredLinkException();
        // TODO: Verificar que la solicitud no este expirada
        
        $datasource = ConnectionManager::get('default');
        $datasource->begin();
        
        $result = $this->doActivate($request); // Aqui es donde se hace todo el procesamiento!!!
        $OK = $result['success'];
        
        if($OK) {
            $datasource->commit();
            $this->set('request', $request);
            
            // Si se confirmo el viaje (ej. se emparejo con otro solicitud), mostrar otra vista
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
        
        $OK = $STTable->updateAll(['activated'=>true, 'state'=>SharedTravel::$STATE_ACTIVATED], ['id' => $request['SharedTravel']['id']]);
        
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
                    'shared_travel', 
                    'new_full_ride'
                );
                
                $confirmed = true;
                $confirmedReason = __d('shared_travels', 'llena uno de nuestros autos de 4 plazas');
                
            } else {
                // Intentar emparejar con otras solicitudes
                $couplings = $this->findCouplings($request);
                
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
                        'shared_travel', 
                        'new_requests_coupled'
                    );
                    
                    $confirmed = true;
                    $confirmedReason = __d('shared_travels', 'fue emparejada con otras solicitudes para llenar las 4 plazas de uno de nuestros autos');

                } else { // No se encontraron couplings
                    
                    // Buscar si este cliente tiene otras solicitudes activadas
                    $all_requests = $STTable->findActiveRequests($request['SharedTravel']['email']);

                    // Buscar si tiene otras solicitudes activadas que no sean esta
                    $countOther = 0;
                    foreach ($all_requests as $r) {
                        if($r['SharedTravel']['id'] == $request['SharedTravel']['id']) continue;

                        $countOther++;
                    }

                    if($countOther == 0) {// Si es la primera solicitud (no tiene otras solicitudes), enviarle el correo de presentacion del operador
                        $OK = EmailsUtil::email(
                                $request['SharedTravel']['email'], 
                                __d('shared_travels', 'Tenemos los datos de su solicitud'),
                                array('request' => $request), 
                                'customer_assistant_shr', 
                                'assistant_intro',
                                array('lang'=>$request['SharedTravel']['lang'])
                            );
                    } else { // Si tiene otras solicitudes, enviarle el correo de resumen
                        $OK = EmailsUtil::email(
                                $request['SharedTravel']['email'], 
                                __d('shared_travels', 'Tenemos los datos de su nueva solicitud'),
                                array('request' => $request, 'all_requests'=>$all_requests),
                                'customer_assistant_shr', 
                                'requests_summary',
                                array('lang'=>$request['SharedTravel']['lang'])
                            );
                    }

                    // Correo a gestor para que confirme la solicitud
                    if($OK) {
                        $facilitator = Configure::read('shared_rides_facilitator');
                        $modality = SharedTravel::$modalities[$request['SharedTravel']['modality_code']];
                        $OK = EmailsUtil::email(
                            $facilitator['email']/*'martin@yotellevocuba.com'*/,
                            '#'.$request['SharedTravel']['id'].' '.$modality['origin'].'-'.$modality['destination'].' [['.$request['SharedTravel']['id_token'].']]',
                            array('request' => $request), 
                            'shared_travel', 
                            'SharedTravels.new_request'
                            );
                    }
                }
            }
        }
        
        // Ponerle algunos datos a la solicitud para que en la vista salga bien
        if($OK) {
            $request['SharedTravel']['state'] = SharedTravel::$STATE_ACTIVATED;
        }
        
        // Guardar algunos datos en la session para si el cliente quiere crear mas solicitudes que no tenga que repetirlas
        // TODO: Guardarlos en una Cookie???
        $session = $this->request->session();
        $session->write('SharedTravels.email', $request['SharedTravel']['email']);
        $session->write('SharedTravels.people_count', $request['SharedTravel']['people_count']);
        $session->write('SharedTravels.name_id', $request['SharedTravel']['name_id']);
        
        return array('success'=>$OK, 'confirmed'=>$confirmed, 'confirmed_reason'=>$confirmedReason, 'coupled'=>$coupled);
    }
    
    
    private function findCouplings($request) {
        
        $STTable = TableRegistry::get('SharedTravels');
        
        // Buscar posibles emparejamiento para esta solicitud
        $candidates = $STTable->findCoupligCandidates($request);       
        
        // Armar los emparejamientos
        $count = $request['SharedTravel']['people_count'];
        $couplings = array();
        foreach ($candidates as $r) {
            if($count + $r['SharedTravel']['people_count'] > 4) continue;
            
            $couplings[] = $r;
            $count += $r['SharedTravel']['people_count'];
        }
        if($count == 4) { // Emparejamiento exitoso
            return $couplings;
        } 
        
        return null;
    }
    
    
    public function view($token) {
        
        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findByToken($token);

        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        if(!$request['SharedTravel']['activated']) throw new NotFoundException();


        $this->viewBuilder()->setLayout('shared_rides');
        $this->set('request', $request);
    }
    
    
    public function admin($id) {
        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findById($id);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        
        $this->viewBuilder()->setLayout('shared_rides');
        $this->set('request', $request);
    }
    
    public function changeDate($id) {
        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findById($id);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $OK = $STTable->updateAll(['date' => TimeUtil::dmY_to_Ymd($this->request->getData('date'))], ['id' => $request['SharedTravel']['id']]);
            if(!$OK) $this->setErrorMessage ('Error actualizando la fecha.');
            
            return $this->redirect($this->referer());
            
        } else throw new MethodNotAllowedException();
    }
    
    public function cancel($token) {
        $STTable = TableRegistry::get('SharedTravels');
        $request = $STTable->findByToken($token);
        
        // Sanity checks
        if($request == null || empty ($request)) throw new NotFoundException();
        
        $OK = $STTable->updateAll(['state' => SharedTravel::$STATE_CANCELLED], ['id' => $request['SharedTravel']['id']]);
        if(!$OK) $this->setErrorMessage ('Error cancelando la solicitud.');
        
        return $this->redirect($this->referer());
    }

}

?>