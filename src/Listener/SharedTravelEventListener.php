<?php
namespace App\Listener;

class SharedTravelEventListener extends \ApiSync\Listener\BaseOpEventListener {
    
    public function initialize() {
        $this->setConfig('object_id_field', 'shared_travel_id');
    }
    
    public function implementedEvents() {
        return [ 
            'Model.SharedTravel.afterCreate' => 'createSharedTravel',
            'Model.SharedTravel.afterConfirm' => 'confirmSharedTravel',
            'Model.SharedTravel.afterCancel' => 'cancelSharedTravel',
            'Model.SharedTravel.afterDateChange' => 'changeDateSharedTravel'
            ];
    }
    
    public function createSharedTravel($event, $owner, array $notifyTo = null) {        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_CREATED,
                $owner,
                $notifyTo);
    }
    
    public function confirmSharedTravel($event, $owner, array $notifyTo = null) {        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_CONFIRMED,
                $owner,
                $notifyTo);
    }
    
    public function cancelSharedTravel($event, $owner, array $notifyTo = null) {        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_CANCELLED,
                $owner,
                $notifyTo);
    }
    
    public function changeDateSharedTravel($event, $owner, $notifyTo = null) {        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_INFO_EDITED,
                $owner,
                $notifyTo,
                [
                    'field_edited'=>'date',
                    'old_value'=>$event->subject()->old_date,
                    'new_value'=>$event->subject()->date,
                ]
            );
    }

}