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
    <?php echo __d('shared_travels', 'Acabamos de recibir los datos de su solicitud de viaje compartido desde {0} hasta {1} para el día {2}.', '<b>'.$modality['origin'].'</b>', '<b>'.$modality['destination'].'</b>', '<b>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</b>')?> 
</p>

<p>
    <?php echo __d('shared_travels', 'Ahora usted tiene {0} solicitudes', count($all_requests))?>:
</p>
<?php echo $this->element('requests_summary', array('requests'=>$all_requests))?>

<p>
    <?php echo __d('shared_travels', 'Saludos', $modality['destination'])?>,
</p>

<p>
    <?php echo __d('shared_travels', '{0} y el equipo de', $assistant['name'])?> <a href="http://pickocar.com">PickoCar</a>.
</p>