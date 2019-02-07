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
            'Model.SharedTravel.afterDateChange' => 'changeDateSharedTravel',
            'Model.SharedTravel.afterActivated' => 'activateSharedTravel'
            ];
    }
    
    public function createSharedTravel($event, $owner, array $notifyTo = null) {
        if(!is_array($event->subject()->origin_id))
            $event->subject()->origin_id = ['id'=>$event->subject()->origin_id];
        if(!is_array($event->subject()->destination_id))
            $event->subject()->destination_id = ['id'=>$event->subject()->destination_id];
        
        unset($event->subject()->modified);
        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_CREATED,
                $owner,
                $notifyTo);
    }
    
    public function activateSharedTravel($event, $owner, array $notifyTo = null) {
        if(!is_array($event->subject()->origin_id))
            $event->subject()->origin_id = ['id'=>$event->subject()->origin_id];
        if(!is_array($event->subject()->destination_id))
            $event->subject()->destination_id = ['id'=>$event->subject()->destination_id];
        
        unset($event->subject()->modified);
        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_ACTIVATED,
                $owner,
                $notifyTo);
    }
    
    public function confirmSharedTravel($event, $owner, array $notifyTo = null) {
        if(!is_array($event->subject()->origin_id))
            $event->subject()->origin_id = ['id'=>$event->subject()->origin_id];
        if(!is_array($event->subject()->destination_id))
            $event->subject()->destination_id = ['id'=>$event->subject()->destination_id];
        
        unset($event->subject()->modified);
        unset($event->subject()->old_state);
        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_CONFIRMED,
                $owner,
                $notifyTo);
    }
    
    public function cancelSharedTravel($event, $owner, array $notifyTo = null) {  
        if(!is_array($event->subject()->origin_id))
            $event->subject()->origin_id = ['id'=>$event->subject()->origin_id];
        if(!is_array($event->subject()->destination_id))
            $event->subject()->destination_id = ['id'=>$event->subject()->destination_id];
        
        unset($event->subject()->modified);
        unset($event->subject()->old_state);
        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_CANCELLED,
                $owner,
                $notifyTo);
    }
    
    public function changeDateSharedTravel($event, $owner, $notifyTo = null) {
        // Flush
        if(!is_array($event->subject()->origin_id))
            $event->subject()->origin_id = ['id'=>$event->subject()->origin_id];
        if(!is_array($event->subject()->destination_id))
            $event->subject()->destination_id = ['id'=>$event->subject()->destination_id];
        
        unset($event->subject()->modified);
        
        $oldDate = $event->subject()->old_date;
        unset($event->subject()->old_date);
        
        return parent::saveEvent(
                $event, 
                \App\Model\Entity\SharedTravel::$EVENT_TYPE_INFO_EDITED,
                $owner,
                $notifyTo,
                [
                    'field_edited'=>'date',
                    'old_value'=>$oldDate,
                    'new_value'=>$event->subject()->date,
                ]
            );
    }

}