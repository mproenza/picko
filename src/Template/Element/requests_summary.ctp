<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
?>
<?php foreach ($requests as $r):?>
    <?php
    $modCode = $r['SharedTravel']['modality_code'];
    $mod = SharedTravel::$modalities[$modCode];
    ?>
    <div style="margin-bottom: 20px">
        <div><?php echo __d('shared_travels', '{0} personas desde {1} hasta {2} el día {3} con recogida a las {4}.', '<b>'.$r['SharedTravel']['people_count'].'</b>', '<b>'.$mod['origin'].'</b>', '<b>'.$mod['destination'].'</b>', '<b>'.TimeUtil::prettyDate($r['SharedTravel']['date'], false).'</b>', '<b>'.$mod['time'].'</b>')?></div>
        <?php $st = SharedTravel::getStateDesc($r['SharedTravel']['state'])?>
        <div><?php echo strtoupper($st['title'])?></div>
        <div><?php echo $this->Html->link(__d('shared_travels', 'Ver datos de esta solicitud'), array('language'=>$r['SharedTravel']['lang'], 'controller' => 'shared-rides', 'action' => 'view/' . $r['SharedTravel']['id_token'], '_full'=>true) )?></div>
    </div>
<?php endforeach?>