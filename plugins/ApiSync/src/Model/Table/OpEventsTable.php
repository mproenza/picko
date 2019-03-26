<?php

namespace ApiSync\Model\Table;

use Cake\ORM\Table;

class OpEventsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        
         //$this->hasMany('ApiSync.SyncQueue')->setForeignKey('event_id');
    }
}