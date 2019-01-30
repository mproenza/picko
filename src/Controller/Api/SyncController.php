<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;

class SyncController extends AppController {
    
    public function sync($batchId = null) {
        $userId = $this->Auth->user('id');
        
        // Obtener las entadas de la cola que no se han sincronizado
        $SyncQueueTable = TableRegistry::get('ApiSync.SyncQueue');
        $queueEntries = $SyncQueueTable->find()
                ->where([
                    'user_id'=>$userId, 'sync_date IS NULL'
                ])
                ->toArray();
        
        $events = [];        
        if(!empty($queueEntries)) {
            
            // Obtener los eventos que no se han sincronizado
            $eventsIds = array_column($queueEntries, 'event_id');
            $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
            $events = $OpEventsTable->find()
                    ->where([
                        'id IN'=>$eventsIds
                    ])
                    ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                        return $results->map(function ($entity) {
                            // Esto es para el ORM de la app movil
                            $entity->data = json_decode($entity->data);

                            return $entity;
                        });
                    })
                    ->toArray();
            
            // Actualizar como sincronizados en la cola
            $queueIds = array_column($queueEntries, 'id');
            $SyncQueueTable->updateAll(['sync_date' => new \Cake\I18n\Time()], ['id IN' => $queueIds]);
        }
        
        // Enviar sync        
        $this->set([
            'success' => true,
            'data' => $events,
            'user' => $userId
        ]);
    }
    
}