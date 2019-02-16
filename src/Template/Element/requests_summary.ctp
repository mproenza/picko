<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
use Cake\ORM\TableRegistry;
?>
<?php
$STTable = TableRegistry::get('SharedTravels');
?>
<?php foreach ($requests as $r):?>
    <?php $r = $STTable->newEntity($r, ['fixDate'=>false]);?>
    <div style="margin-bottom: 20px">
        <div><?php echo __d('shared_travels', '{0} personas desde {1} hasta {2} el día {3} con recogida a las {4}.', '<b>'.$r->people_count.'</b>', '<b>'.$r->getOriginName().'</b>', '<b>'.$r->getDestinationName().'</b>', '<b>'.TimeUtil::prettyDate($r->date, false).'</b>', '<b>'.$r->getDepartureTimeDesc().'</b>')?></div>
        <?php $st = SharedTravel::getStateDesc($r->state)?>
        <div><?php echo strtoupper($st['title'])?></div>
        <div><?php echo $this->Html->link(__d('shared_travels', 'Ver datos de esta solicitud'), array('language'=>$r->lang, 'controller' => 'shared-rides', 'action' => 'view', $r->id_token), ['fullBase'=>true] )?></div>
    </div>
<?php endforeach?>