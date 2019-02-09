<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;

class OpEventsController extends AppController {
    
    public function initialize() {
        parent::initialize();
        
        $this->setModelType('ApiSync.OpEvents');
    }

    
    public function sync($batchId) {
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
                            if($entity->descriptor == null) $entity->descriptor = '{}';
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
            'data' => $events
        ]);
    }
    
    /**
     * Esta funcion envia los eventos que han sucedido a partir de una cantidad de dias hacia atras a partir de hoy,
     * 
     * @param fromDaysAgo: un número que indica la cantidad de días hacia atrás contando desde hoy que es 
     * la fecha limite superior para los eventos que enviará la funcion
     * @param countDays: la cantidad de dias hacia atras a partir de {hoy - $fromDaysAgo} que indica 
     * la fecha limite inferior para los eventos que enviará la funcion
     * 
     * O sea, esta funcion envia los eventos que estan en el siguiente rango de fechas:
     * Desde: {hoy - $fromDaysAgo - $countDays}
     * Hasta: {hoy - $fromDaysAgo}
     * 
     * Mira los siguientes ejemplos:
     * 
     * getEventsByFullDays(0, 3) retorna los eventos de hace 3 dias atras hasta hoy
     * getEventsByFullDays(3, 5) retorna los eventos desde 8 dias atras a 3 dias atras     
     */
    public function getEventsByFullDays($fromDaysAgo, $countDays) {
        
        $lastDay = $fromDaysAgo + $countDays;
        
        $startDate = new \Cake\I18n\FrozenTime("$lastDay days ago");
        $endDate = new \Cake\I18n\FrozenTime("$fromDaysAgo days ago");
        
        $conditions = ["created BETWEEN '". $startDate->format('Y-m-d'). "' AND '". $endDate->format('Y-m-d')."'"];
        
        // TODO: Poner una condicion para restringir solo a los eventos DE ESTE USUARIO que YA HAN SIDO SINCRONIZADOS
        
        $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
        $events = $OpEventsTable->find()
                ->where($conditions)
                ->order(['id DESC'])
                ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                    return $results->map(function ($entity) {
                        // Esto es para el ORM de la app movil
                        $entity->object_final_state = json_decode($entity->object_final_state);
                        $entity->descriptor = json_decode($entity->descriptor);

                        return $entity;
                    });
                })
                ->toArray();
                    
        $this->set([
            'success' => true,
            'data' => $events
        ]);
    }
    
    /*public function getEventsItems($limit = 5) {
        $this->paginate = ['order'=>['id'=>'ASC'], 'limit'=>$limit];
        
        $events = $this->_paginate();
                    
        $this->set([
            'success' => true,
            'data' => $events
        ]);
                
    }
    
    public function getEventsSinceDate($date) {
                
    }
    
    
    private function _paginate() {
        $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
        return $this->paginate(
            $OpEventsTable->find()
                ->order(['id ASC'])
                ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                    return $results->map(function ($entity) {
                        // Esto es para el ORM de la app movil
                        $entity->object_final_state = json_decode($entity->object_final_state);
                        $entity->descriptor = json_decode($entity->descriptor);

                        return $entity;
                    });
                }))

                ->toArray();
    }*/

}