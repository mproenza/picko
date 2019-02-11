<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use App\Model\Entity\SharedTravel;
use App\Util\EmailsUtil;
use Cake\Event\Event;
use Cake\ORM\Query;
use ArrayObject;
use App\Util\TimeUtil;
use Cake\Mailer\Email;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class SharedTravelsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        $this->addBehavior('TrackHistory');
    }
    
    public function validationDefault(Validator $validator) {
        $validator
            ->requirePresence([
                'modality_code',
                'origin_id',
                'destination_id',
                'price_x_seat',
                'date',
                'departure_time',
                'people_count',
                'address_origin',
                'address_destination',
                'email',
                'name_id'],
            'create')
                
            ->notEmpty('modality_code', __d('errors', 'Inválido'))
            ->notEmpty('origin_id', __d('errors', 'Inválido'))
            ->notEmpty('destination_id', __d('errors', 'Inválido'))
            ->notEmpty('price_x_seat', __d('errors', 'Inválido'))
               
            ->notEmpty('date', __d('errors', 'Fecha inválida'))
                
            ->notEmpty('people_count', __d('errors', 'Cantidad inválida'))
            ->range('people_count', [2, 4], __d('errors', 'La cantidad de personas debe ser un número entre {0} y {1}', 2, 4))
                
            ->notEmpty('email', __d('errors', 'Email inválido'))
            ->notEmpty('name', __d('errors', 'Nombre inválido'))
            ->notEmpty('address_origin', __d('errors', 'Dirección de recogida inválida'))
            ->notEmpty('address_destination', __d('errors', 'Dirección de destino inválida'))
        ;
        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if(!isset($options['fixDate']) || $options['fixDate']) {
            if (isset($data['date']) && is_string($data['date'])) {
                // Guardar como YYYY/mm/dd, se asume que la fecha viene como dd-mm-YYYY
                $data['date'] = new \Cake\I18n\Date(str_replace('-', '/', TimeUtil::dmY_to_Ymd($data['date'])));
            }
        }
        

        if (isset($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }
    }
    
    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary) {
        
        // Si no se esta haciendo una llamada a la API
        if(!Configure::read('App.calling_api')) {
            if(!isset($options['hydrate']) || !$options['hydrate']) {
                // Hacer que se devuelvan resultados a la Cakephp 2
                $query->hydrate(false); //para que devuelva arrays, no objetos
                $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                    return $results->map(function ($row) {

                        $rowFull = SharedTravel::_routeFull($row);

                        $formatted = ['SharedTravel'=>$rowFull];

                        return $formatted;
                    });
                });
            }/* else {
                $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                    return $results->map(function ($entity) {                       
                        
                        // Esto es para el ORM de la app movil
                        $entity->origin_id = ['id'=>$entity->origin_id];
                        $entity->destination_id = ['id'=>$entity->destination_id];

                        return $entity;
                        
                    });
                });
            }*/            
        }
        
        // API
        else {
            $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                return $results->map(function ($entity) {
                    // Esto es para el ORM de la app movil
                    $entity->origin_id = ['id'=>$entity->origin_id];
                    $entity->destination_id = ['id'=>$entity->destination_id];

                    return $entity;
                });
            });
        }
        
    }

    public function findByToken($token, array $options = []) {
        $request = $this->find('all', $options)
        ->where(['id_token' => $token])
        ->first();

        return $request;
    }
    
    public function findByActivationToken($token, array $options = []) {
        $request = $this->find('all', $options)
        ->where(['activation_token' => $token])
        ->first();

        return $request;	
    }
    
    public function findById($id, array $options = []) {
        $request = $this->find('all', $options)
        ->where(['id' => $id])
        ->first();

        return $request;
    }

    //Encuentra las solicitudes activas de un usuario
    public function findActiveRequests($userEmail) {
        $today = date('Y-m-d', strtotime('today'));

        return $this->find()
        ->where([
            'email'=>$userEmail, // Que sean de este usuario
            'activated'=>true, // Que esten activadas
            'state !='=>SharedTravel::$STATE_CANCELLED, // Que NO esten canceladas
            'date >'=>$today // Que no esten expiradas
                ])
        ->order('date ASC, id ASC');
    }
    
    public function findCouplings($request) {
        // Buscar posibles emparejamiento para esta solicitud
        $candidates = $this->findCoupligCandidates($request);
        
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
    
    public function findCoupligCandidates($request) {
        //$today = date('Y-m-d', strtotime('today'));

        $candidates = $this->find()
        ->where(
        [
            'modality_code'=>$request['SharedTravel']['modality_code'], // Que coincidan en la ruta y hora
            'date'=> $request['SharedTravel']['date'], // Que coincidan en la fecha
            'people_count <='=> 4 - $request['SharedTravel']['people_count'], // Que sumen NO mas de 4 personas
            'email !='=>$request['SharedTravel']['email'], // Que no sea de este mismo cliente
            'activated'=>true, // Que este activada la solicitud
            'coupling_id IS NULL', // Que no haya sido emparejado antes
            'state !='=>SharedTravel::$STATE_CONFIRMED // Que no este confirmado (por si el facilitador lo confirmo dirctamente).
        ])
        ->order('people_count DESC') // Obtener las de mayor cantidad de personas primero, para tener que hacer menos recorridos al recoger. TODO: sera mejor priorizar a las mas antiguas???
        ;
        
        return $candidates;
    }
    

    public function confirmRequest($request) {
        
        $entity = $this->updateField(['state' => SharedTravel::$STATE_CONFIRMED], $request['SharedTravel']['id']);
        $OK = $this->save($entity, 
                ['track_history' =>
                    [
                        'event_type' => SharedTravel::$EVENT_TYPE_CONFIRMED,
                        'notify_to' =>  self::getUsersToSync()
                    ]
                ]);
        //$OK = $this->updateAll(['state'=>SharedTravel::$STATE_CONFIRMED], ['id' => $request['SharedTravel']['id']]);
        
        /*// Eventos
        $entity = $this->findById($request['SharedTravel']['id'], ['hydrate'=>true]);
        $opEventListener = new \App\Listener\SharedTravelEventListener(); 
        $this->eventManager()->on($opEventListener);
        $event = new Event('Model.SharedTravel.afterCreate', 
                $entity,
                [$this->Auth->user(), $this->_getUsersToSync()]
            );
        $this->eventManager()->dispatch($event);*/

        if ($OK) {
            $lang = $request['SharedTravel']['lang'];

            $subject = 'Viaje compartido confirmado!';
            if ($lang == 'en')
                $subject = 'Shared ride confirmed!';

            // Buscar todas las solicitudes activadas para mostrarle al cliente el resumen
            $all_requests = $this->findActiveRequests($request['SharedTravel']['email']);

            // Email de parte del customer assistant
            $OK = EmailsUtil::email(
                $request['SharedTravel']['email'],
                $subject,
                array('request' => $request, 'all_requests'=>$all_requests),
                'customer_assistant',
                'request_confirmed',
                array('lang'=>$lang)
            );

              // Email para mi
            $Email = new Email('hola');
            $Email->to('martin@yotellevocuba.com')->subject('CONFIRMADA: PickoCar #'.$request['SharedTravel']['id'])->send('http://pickocar.com/shared-rides/view/'.$request['SharedTravel']['id_token']);
        }

        return $OK;
    }
    
    public function updateField($fields, $id, $options = []) {
        $_defaults = ['keep_old_value'=>false];
        
        $options = $options + $_defaults;
        
        $searchByField = 'id';
        $searchByValue = $id;
        if(is_array($id)) {
            $searchByField = array_keys($id)[0];
            $searchByValue = array_values($id)[0];
        }

        $func = 'findBy'. \Cake\Utility\Inflector::camelize($searchByField);

        $request = $this->$func($searchByValue, ['hydrate'=>true]);

        // Sanity checks
        if($request == null || empty ($request)) throw new \Cake\Network\Exception\NotFoundException();
        
        
        // Actualizar todos los campos
        foreach ($fields as $key => $value) {
            // Salvar el valor anterior
            if($options['keep_old_value']) {
                $oldFieldName = 'old_'.$key;
                $request->$oldFieldName = $request->$key;
            }

            $request->$key = $value;
        }
        
        return $request;
    }
    
    public static function getUsersToSync($eventType = null) {
        
        $UsersTable = \Cake\ORM\TableRegistry::get('CakeDC/Users.Users');
        
        $users = $UsersTable->find()
                    ->where([
                        'role IN'=>['admin', 'operator']
                    ])
                    ->toArray();
        
        return array_column($users, 'id');
    }

}