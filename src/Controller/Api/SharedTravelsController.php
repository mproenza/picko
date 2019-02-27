<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use App\Model\Entity\SharedTravel;
use Cake\Collection\CollectionInterface;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Exception\InternalErrorException;
use Cake\ORM\TableRegistry;

class SharedTravelsController extends AppController {
    
    public function initialize() {
        parent::initialize();
        
        $this->loadComponent('SharedTravelActions');
    }
    
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
                    'date >'=>date('Y-m-d', strtotime('January 1, 2019')) // A partir de 1 Ene 2019
                ])->formatResults(function (CollectionInterface $results) {
                    return $results->map(function ($entity) {
                        return SharedTravel::preprocessForApi($entity);
                    });
                })->toArray();
        
        $this->set([
            'success' => true,
            'data' => $sharedTravels
        ]);
    }
    
    public function confirmRequest($idToken) {
        
        $datasource = ConnectionManager::get('default');
        $datasource->begin();
        
        $OK = $this->SharedTravelActions->confirm($idToken);

        if(!$OK) {
            // TODO: Enviar notificacion de fallo?
            $datasource->rollback();
            throw new InternalErrorException('Ocurrió un error confirmando la solicitud');
        } 
        
        $datasource->commit();
        $this->set([
            'success' => true
        ]); 
    }
    
}