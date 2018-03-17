<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use App\Model\Entity\SharedTravel;
use App\Util\EmailsUtil;
use Cake\Event\Event;
use Cake\ORM\Query;
use ArrayObject;
use App\Util\TimeUtil;
use \Cake\Mailer\Email;

class SharedTravelsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['date'])) {
            // Guardar como YYYY/mm/dd, se asume que la fecha viene como dd-mm-YYYY
            $data['date'] = str_replace('-', '/', TimeUtil::dmY_to_Ymd($data['date']));
        }

        if (isset($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }
    }
    
    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary) {
        // Hacer que se devuelvan resultados a la Cakephp 2 
        $query->hydrate(false); //arrays, no objetos
        $query->formatResults(function (\Cake\Collection\CollectionInterface $results) {
            return $results->map(function ($row) {
                $formatted = ['SharedTravel'=>$row];
                return $formatted;
            });
        });
    }

    public function findByToken($token) {
        $request = $this->find()
        ->where(['id_token' => $token])
        ->first();

        return $request;
    }
    
    public function findByActivationToken($token) {
        $request = $this->find()
        ->where(['activation_token' => $token])
        ->first();

        return $request;	
    }
    
    public function findById($id) {
        $request = $this->find()
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
        ->order('people_count DESC') // Obtener las de mas personas primero, para tener que hacer menos recorridos al recoger. TODO: sera mejor priorizar a las mas antiguas???
        ;
        
        return $candidates;
    }
    

    public function confirmRequest($request) {
        $OK = $this->updateAll(['state'=>SharedTravel::$STATE_CONFIRMED], ['id' => $request['SharedTravel']['id']]);

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
            $Email->to('martin@yotellevocuba.com')->subject('Viaje compartido confirmado')->send('http://pickocar.com/shared-rides/view/'.$request['SharedTravel']['id_token']);
        }

        return $OK;
    }

}

?>