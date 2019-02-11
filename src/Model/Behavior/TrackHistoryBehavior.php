<?php

namespace App\Model\Behavior;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;
use Cake\Core\InstanceConfigTrait;

class TrackHistoryBehavior extends Behavior {
    
    use InstanceConfigTrait;
    
    protected $_defaultConfig = [
        'object_id_field' => 'object_id'
    ];
    
    public function afterSave(\Cake\Event\Event $event, \Cake\Datasource\EntityInterface $entity, \ArrayObject $options) {
        
        if(isset($options['track_history'])) {
            $type = $options['track_history']['event_type'];
            $notifyTo = $options['track_history']['notify_to'];

            $descriptor = null;
            if(isset($options['track_history']['descriptor'])) $descriptor = $options['track_history']['descriptor'];

            $owner = null;
            if(isset($options['track_history']['owner'])) $owner = $options['track_history']['owner']; 
            else if(isset($options['_footprint']))$owner = $options['_footprint'];

            $this->saveEvent($entity, $type, $owner, $notifyTo, $descriptor);
        }
        
    }
    
    private function saveEvent(\Cake\Datasource\EntityInterface $entity, $type, $owner, $notifyTo, $descriptor = null) {
        
        $created_by_role = 'user';
        $created_by_id = null;
        if($owner != null) {
            if(is_array($owner)) {
                $created_by_role = $owner['role'];
                $created_by_id = $owner['id'];
            } else {
                $created_by_role = $owner->role;
                $created_by_id = $owner->id;
            }
        }
        
        if(is_callable($descriptor)) $descriptor = $descriptor($entity);
        if(is_array($descriptor)) $descriptor = json_encode($descriptor);
        
        // Crear el evento
        $e = [
            'object_id' => $entity->id,
            'type' => $type,
            'created_by_role' => $created_by_role,
            'created_by_id' => $created_by_id,
            'object_final_state' => json_encode($entity->toArray()),
            'descriptor' => $descriptor
        ];
        
        $EventsTable = TableRegistry::get('ApiSync.OpEvents');
        $EventEntity = $EventsTable->newEntity($e);
        
        // Salvar la solicitud
        $OK = $EventsTable->save($EventEntity);
        
        if($OK) {
            
            if($notifyTo != null && !empty($notifyTo)) {
                
                foreach ($notifyTo as $to) {
                    
                    $entry = [
                        'event_id' => $EventEntity->id,
                        'user_id' => $to
                    ];

                    $SyncTable = TableRegistry::get('ApiSync.SyncQueue');
                    $SyncEntryEntity = $SyncTable->newEntity($entry);
                    
                    if(!$SyncTable->save($SyncEntryEntity)) return false;
                }
                
            }
            
        }
        
        return $OK;
    }
    
}