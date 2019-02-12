<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;

class SharedTravelsController extends AppController {
    
    public function iniFetch() {
        
        // Eliminar de la queue de eventos a sincronizar todo lo de este usuario
        $userId = $this->Auth->user('id');
        if($userId) {
            $SyncQueueTable = TableRegistry::get('ApiSync.SyncQueue');
            $SyncQueueTable->deleteAll(['user_id'=>$userId]);
        }
        
        $STTable = TableRegistry::get('SharedTravels');
        $sharedTravels = 
            $STTable->find()
                ->where([
                    'date >'=>date('Y-m-d', strtotime('January 1, 2019')) // Que no esten expiradas
                ])->toArray();
        
        $this->set([
            'success' => true,
            'data' => $sharedTravels
        ]);
    }
    
}