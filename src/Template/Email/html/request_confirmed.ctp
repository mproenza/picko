<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
use Cake\Core\Configure;

$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>

<?php $assistant = Configure::read('customer_assistant');?>

<p>Hola <?php echo $request['SharedTravel']['name_id']?>,</p>

<p>
    <?php echo __d('shared_travels', 'Buenas noticias: su viaje desde {0} hasta {1} el día {2} ya fue gestionado y confirmado.', '<b>'.$modality['origin'].'</b>', '<b>'.$modality['destination'].'</b>', '<b>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</b>')?> 
</p>

<p>
    
    
    <?php echo __d('shared_travels', 'El chofer le recogerá en esa fecha a las {0} en {1}.', '<b>'.$modality['time'].'</b>', '<b>'.$request['SharedTravel']['address_origin'].'</b>')?>
    <?php if($request['SharedTravel']['people_count'] < 4):?>
        <?php echo __d('shared_travels', 'Usted compartirá un auto moderno de 4 plazas con aire acondicionado con otros {0} viajeros.', 4 - $request['SharedTravel']['people_count'])?>
    <?php endif?>
</p>

<?php if(count($all_requests) <= 1):?>
<p>
    <?php echo __d('shared_travels', 'Recuerde que puede ver los datos de su solicitud en este enlace')?>:
</p>

<p><?php echo $this->Html->link(__d('shared_travels', 'Ver datos de esta solicitud'), array('language'=>$request['SharedTravel']['lang'], 'controller' => 'shared-rides', 'action' => 'view', $request['SharedTravel']['id_token']/*, '_full'=>true*/), ['fullBase'=>true] )?></p>

<?php else:?>
<p>
    <?php echo __d('shared_travels', 'Hasta ahora este es su plan de viajes')?>:
</p>
<?php echo $this->element('requests_summary', array('requests'=>$all_requests))?>

<?php endif?>

<p>
    <?php echo __d('shared_travels', 'Siéntase libre de contactarme en cualquier momento que necesite ayuda.')?>
</p>

<p>
    <?php echo __d('shared_travels', 'Le deseo un feliz viaje a Cuba y un cómodo recorrido hasta {0}', $modality['destination'])?>,
</p>

<p>
    <?php echo __d('shared_travels', '{0} y el equipo de', $assistant['name'])?> <a href="http://pickocar.com">PickoCar</a>.
</p>