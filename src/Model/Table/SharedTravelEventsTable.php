<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use App\Model\Entity\SharedTravel;
use App\Util\EmailsUtil;
use Cake\Event\Event;
use Cake\ORM\Query;
use ArrayObject;
use App\Util\TimeUtil;
use Cake\Mailer\Email;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class SharedTravelsTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
    }
    
    /**
     * @param $owner: el usuario que genero el evento. Si es un usuario logueado,
     * esta variable debe tener al menos la estructura: ['id'=>id, 'role'=>role]
     */
    public function addEvent($type, $request, $owner = null) {
        $event = [
            'type'=>$type,
            'shared_travel_id'=>$request['SharedTravel']['id'],
            'created_by_role'=>$owner == null?'user':$owner['role'],
            'created_by_role'=>$owner == null?null:$owner['id'],
        ];
    }
}