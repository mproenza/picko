<?php
namespace App\Controller\Api;

class InfoController extends AppController
{
    public function initialize() {
        parent::initialize();
    }
    
    public function localities() {
        $this->set([
            'success' => true,
            'data' => \App\Model\Entity\SharedTravel::getLocalitiesForApi()
        ]);
    }
    
    public function routes() {
        $this->set([
            'success' => true,
            'data' => \App\Model\Entity\SharedTravel::getRoutesForApi()
        ]);
    }
}