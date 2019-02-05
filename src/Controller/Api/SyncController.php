<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;

class SyncController extends AppController {

    public function sync($batchId = null) {
        $userId = $this->Auth->user('id');
        
        $SyncQueueTable = TableRegistry::get('ApiSync.SyncQueue');
        $queueEntries = [];
        
        // Tratar de encontrar eventos con el batchId
        if($batchId != null) {
            $queueEntries = $SyncQueueTable->find()
                ->where(['user_id' => $userId, 'sync_batch' =>$batchId])
                ->toArray();
        }
        
        // Si no hay eventos, intentar encontrar los eventos que no se han sincronizado con este usuario
        if(empty($queueEntries)) {
            $queueEntries = $SyncQueueTable->find()
                ->where(['user_id' => $userId, 'sync_date IS NULL'])
                ->toArray();
        }
        
        $events = [];
        if (!empty($queueEntries)) {
            $eventsIds = array_column($queueEntries, 'event_id');
            $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
            $events = $OpEventsTable->find()
                    ->where([
                        'id IN' => $eventsIds
                    ])
                    ->order(['id ASC'])
                    ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                        return $results->map(function ($entity) {
                            // Esto es para el ORM de la app movil
                            $entity->object_final_state = json_decode($entity->object_final_state);
                            $entity->descriptor = json_decode($entity->descriptor);

                            return $entity;
                        });
                    })
                    ->toArray();

            // Actualizar como sincronizados en la cola
            $queueIds = array_column($queueEntries, 'id');
            $SyncQueueTable->updateAll(['sync_date' => new \Cake\I18n\Time(), 'sync_batch'=>$batchId], ['id IN' => $queueIds]);
        }

        // Enviar sync        
        $this->set([
            'success' => true,
            'data' => $events,
            'batch' => $batchId
        ]);
    }

}