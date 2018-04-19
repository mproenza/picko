<?php

namespace Calendar\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class CalendarsController extends AppController {
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        
        //$this->viewBuilder()->setLayout('shared_rides');
    }
    
    public function index() {
        // Just show the view
    }
}