<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use App\Model\Entity\SharedTravel;
use Cake\Mailer\Email;
use App\Util\EmailsUtil;

class SharedTravelActionsComponent extends Component {
    
    public function confirm($idToken) {
        
        $STTable = TableRegistry::get('SharedTravels');
                
        $entity = $STTable->findByToken($idToken, ['hydrate'=>true]);
        
        // Sanity checks
        if($entity == null || empty($entity)) {
            throw new \Cake\Network\Exception\NotFoundException('Esta solicitud no se encuentra en el servidor');
        }

        // TODO: Verificar que la solicitud no este expirada?
        if($entity->state == SharedTravel::$STATE_CONFIRMED) { // No permitir confirmar de nuevo
            throw new \Cake\Network\Exception\GoneException('La solicitud ya está confirmada: estado -> '.$entity->state);
        } else if($entity->state != SharedTravel::$STATE_ACTIVATED && $entity->state != SharedTravel::$STATE_CANCELLED) { // Solo se puede confirmar cuando esta en estado ACTIVATED o CANCELLED
            throw new \Cake\Network\Exception\NotAcceptableException('La solicitud no se ha activado todavía: estado -> '.$entity->state);
        }

        $entity->updateField(['state' => SharedTravel::$STATE_CONFIRMED]);
        
        $OK = $STTable->save($entity, 
                ['track_history' =>
                    [
                        'event_type' => SharedTravel::$EVENT_TYPE_CONFIRMED,
                        'notify_to' => \App\Model\Table\SharedTravelsTable::getUsersToSync()
                    ]
                ]);

        if ($OK) {
            $lang = $entity->lang;

            $subject = 'Viaje compartido confirmado!';
            if ($lang == 'en')
                $subject = 'Shared ride confirmed!';

            // Buscar todas las solicitudes activadas para mostrarle al cliente el resumen
            $all_requests = $STTable->findActiveRequests($entity->email, ['hydrate'=>true]);
            
            // Email de parte del customer assistant
            $customer_assistant = 'customer_assistant_'.$entity->lang;
            $OK = EmailsUtil::email(
                $entity->email,
                $subject,
                array('request' => $entity, 'all_requests'=>$all_requests),
                $customer_assistant,
                'request_confirmed',
                array('lang'=>$lang)
            );

              // Email para mi
            $Email = new Email('hola');
            $Email->to('martin@yotellevocuba.com')->subject('CONFIRMADA: PickoCar #'.$entity->id)->send('http://pickocar.com/shared-rides/view/'.$entity->id);
        }

        return $OK;
    }
    
    
    // TRANSACTIONAL EMAILS
    public function sendReconfirmationEmail($idToken) {
        
        $STTable = TableRegistry::get('SharedTravels');
                
        $entity = $STTable->findByToken($idToken, ['hydrate'=>true]);
        
        // Sanity checks
        if($entity == null || empty($entity)) {
            throw new \Cake\Network\Exception\NotFoundException('Esta solicitud no se encuentra en el servidor');
        }

        // TODO: Verificar que la solicitud no este expirada?
        
        if($entity->state != SharedTravel::$STATE_CONFIRMED) { // No permitir enviar correo
            throw new \Cake\Network\Exception\GoneException('La solicitud NO ESTÁ CONFIRMADA: estado -> '.$entity->state);
        }
        
        $OK = true;

        if ($OK) {
            $lang = $entity->lang;

            $origin = $entity->getOriginName();
            $destination = $entity->getDestinationName();
            
            $subject = 'Taxi '.$origin.' - '.$destination.' con PickoCar';
            if ($lang == 'en')
                $subject = 'Taxi '.$origin.' - '.$destination.' with PickoCar';

            /*// Buscar todas las solicitudes activadas para mostrarle al cliente el resumen
            $all_requests = $STTable->findActiveRequests($entity->email, ['hydrate'=>true]);*/
            
            // Email de parte del customer assistant
            $customer_assistant = 'customer_assistant_'.$entity->lang;
            $OK = EmailsUtil::email(
                $entity->email,
                $subject,
                array('request' => $entity),
                $customer_assistant,
                'email2traveler/request_reconfirmation',
                array('lang'=>$lang, 'enqueue'=>true)
            );

             // Email para mi
            $Email = new Email('hola');
            $Email->to('martin@yotellevocuba.com')->subject('ENVIADO EMAIL RECONFIRMACION: PickoCar #'.$entity->id)->send('http://pickocar.com/shared-rides/admin/'.$entity->id);
        }

        return $OK;
    }
    
}