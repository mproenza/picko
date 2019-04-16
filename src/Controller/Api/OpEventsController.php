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
                            return $this->preprocessEntityEvent($entity);
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
        
    public function index() {
        $userId = $this->Auth->user('id');
        
        $this->paginate = ['limit'=>10];
        $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
        
        $query = $OpEventsTable->find()
                
                // Buscar sl ls evets que ya se sicrizar
                ->select($OpEventsTable)->select(['SyncQueue.sync_batch'/*, 'SyncQueue.sync_date'*/])
                ->join([
                    'SyncQueue' => [
                        'table' => 'sync_events_queue',
                        'type' => 'INNER',
                        'conditions' => ['SyncQueue.event_id = OpEvents.id', 'SyncQueue.user_id'=>$userId, 'SyncQueue.sync_batch IS NOT NULL']
                    ]
                ])
                /*->contain(['SyncQueue' => function ($q) use ($userId) {
                    return $q->select(['event_id', 'sync_batch', 'sync_date'])->where(['user_id'=>$userId, 'sync_batch IS NOT NULL']);
                }])*/
                
                ->order([ 'OpEvents.id DESC' ])
                ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                    return $results->map(function ($entity) {
                        return $this->preprocessEntityEvent($entity);
                    });
                });
                
        $events = $this->paginate($query);
        
        $this->set([
            'success' => true,
            'data' => $events->toArray()
        ]);
    }
    
    public function hasPendingSync($objectId) {
        
        $userId = $this->Auth->user('id');
        
        $SyncQueueTable = TableRegistry::get('ApiSync.SyncQueue');
        
        // Elementos en la cola que no se han sincronizado con ese usuario y que pertenecen al objeto con id = objectId
        $queueEntries = $SyncQueueTable->find()
            ->innerJoinWith('OpEvents')
            ->where(['user_id' => $userId, 'sync_date IS NULL', 'object_id' =>$objectId])
            ->toArray();
        
        $hasPendingSync = !empty($queueEntries);
        
        $events = [];
        if ($hasPendingSync) {
            $eventsIds = array_column($queueEntries, 'event_id');
            $events = $this->getEvents($eventsIds);
        }
        
        $this->set([
            'hasPendingSync' => $hasPendingSync,
            'data' => $events
        ]);
    }
    
    public function getEventsByPages($page, $countDays = 3) {
        
        $startDay = $page * $countDays - 1;
        $lastDay = ($page - 1) * $countDays;
        
        $startDate = new \DateTime("$startDay days ago");
        $startDate->setTime(0, 0);
        $endDate = new \DateTime("$lastDay days ago");
        $endDate->setTime(23, 59, 59);
        
        $conditions = ["created BETWEEN '". $startDate->format('Y-m-d H:i:s'). "' AND '". $endDate->format('Y-m-d H:i:s')."'"];
        
        // TODO: Poner una condicion para restringir solo a los eventos DE ESTE USUARIO que YA HAN SIDO SINCRONIZADOS
        
        $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
        $events = $OpEventsTable->find()
                ->where($conditions)
                ->order(['id DESC'])
                ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                    return $results->map(function ($entity) {
                        return $this->preprocessEntityEvent($entity);
                    });
                })
                ->toArray();
                    
        $this->set([
            'start'=>$startDate->format('Y-m-d H:i:s'),
            'end'=>$endDate->format('Y-m-d H:i:s'),
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
    /*public function getEventsByFullDays($fromDaysAgo, $countDays) {
        
        $lastDay = $fromDaysAgo + $countDays - 1;
        
        $startDate = new \DateTime("$lastDay days ago");
        $startDate->setTime(0, 0);
        $endDate = new \DateTime("$fromDaysAgo days ago");
        $endDate->setTime(23, 59, 59);
        
        $conditions = ["created BETWEEN '". $startDate->format('Y-m-d H:i:s'). "' AND '". $endDate->format('Y-m-d H:i:s')."'"];
        
        // TODO: Poner una condicion para restringir solo a los eventos DE ESTE USUARIO que YA HAN SIDO SINCRONIZADOS
        
        $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
        $events = $OpEventsTable->find()
                ->where($conditions)
                ->order(['id DESC'])
                ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                    return $results->map(function ($entity) {
                        return $this->preprocessEntityEvent($entity);
                    });
                })
                ->toArray();
                    
        $this->set([
            'success' => true,
            'data' => $events
        ]);
    }*/
    
    private function getEvents(array $ids) {
        $OpEventsTable = TableRegistry::get('ApiSync.OpEvents');
            $events = $OpEventsTable->find()
                    ->where([
                        'id IN' => $ids
                    ])
                    ->order(['id ASC'])
                    ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                        return $results->map(function ($entity) {
                            return $this->preprocessEntityEvent($entity);
                        });
                    })
                    ->toArray();
        
        return $events;
    }
    
    private function preprocessEntityEvent(\Cake\ORM\Entity $entity) {
        // Preprocesar para la app movil
        $entity->created_by_name = null;
        if($entity->created_by_id != null) {
            $UsersTable = TableRegistry::get('CakeDC/Users.Users');
            $user = $UsersTable->findById($this->Auth->user('id'))
                    ->first()
                    ->toArray();
            $entity->created_by_name = $user['first_name'];
        }

        if($entity->descriptor == null) $entity->descriptor = new \stdClass();
        else $entity->descriptor = json_decode($entity->descriptor);
        
        // Cambiar 'SyncQueue' por 'sync'
        if(isset($entity->SyncQueue)) {
            $entity->sync = $entity->SyncQueue;
            unset($entity->SyncQueue);
        } else $entity->sync = new \stdClass();

        $entity->object_final_state = \App\Model\Entity\SharedTravel::preprocessForApi(json_decode($entity->object_final_state));
        
        return $entity;
    }

}