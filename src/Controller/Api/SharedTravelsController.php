<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\ORM\TableRegistry;

class SharedTravelsController extends AppController {
    
    public function iniFetch() {
        $STTable = TableRegistry::get('SharedTravels');
        $sharedTravels = 
            $STTable->find()
                ->where([
                    'date >'=>date('Y-m-d', strtotime('January 1, 2019')) // Que no esten expiradas
                ])->toArray();
        
        $this->set([
            'success' => true,
            'data' => $sharedTravels,
            '_serialize' => ['success', 'data']
        ]);
    }
    
}