<?php
namespace ApiSync\Listener;

use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Cake\Core\InstanceConfigTrait;

abstract class BaseOpEventListener implements EventListenerInterface {
    
    use InstanceConfigTrait;
    
    protected $_defaultConfig = [
        'object_id_field' => 'object_id'
    ];
    
    /**
     * 
     */
    protected function saveEvent($event, $type, $owner, $notifyTo) {
        
        $created_by_role = 'user';
        $created_by_id = null;
        if($owner != null) {
            $created_by_role = $owner['role'];
            $created_by_id = $owner['id'];
        }
        
        // Crear el evento
        $e = [
            'object_id' => $event->subject()->id,
            'type' => $type,
            'created_by_role' => $created_by_role,
            'created_by_id' => $created_by_id,
            'data' => json_encode($event->subject()->toArray())
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