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
            'Model.SharedTravel.afterCancel' => 'cancelSharedTravel'
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

}