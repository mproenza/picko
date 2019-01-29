<?php

namespace ApiSync\Model\Table;

use Cake\ORM\Table;

class SyncQueueTable extends Table {

    public function initialize(array $config) {
        $this->setTable('sync_events_queue');
        
        $this->addBehavior('Timestamp');
    }
}