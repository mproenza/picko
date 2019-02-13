<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
use Cake\Core\Configure;
?>

<?php $assistant = Configure::read('customer_assistant_'.$request['SharedTravel']['lang']);?>

<p>Hola <?php echo $request['SharedTravel']['name_id']?>,</p>

<p>
    <?php echo __d('shared_travels', 'Le quiero informar que recibimos su solicitud de viaje compartido desde {0} hasta {1} para el día {2}', '<b>'.$request['SharedTravel']['origin'].'</b>', '<b>'.$request['SharedTravel']['destination'].'</b>', '<b>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</b>')?> 
</p>

<p>
    <?php echo __d('shared_travels', 'Mi nombre es {0} y voy a ser su asistente mientras llega la fecha de la recogida, para este viaje y cualquier otro que usted solicite.', $assistant['name'])?> 
</p>

<p>
    <?php echo __d('shared_travels', 'Como asistente voy a estar a cargo de resolver cualquier problema que pueda surgir, problemas con el sitio y cualquier duda que usted pueda tener.')?>
</p>

<p>
    <?php echo __d('shared_travels', 'Por ahora <b>este viaje está sin confirmar</b> porque recién comenzamos a gestionarlo. Yo voy a estar al tanto de la confirmación de su viaje y le haré saber enseguida.')?>
</p>

<p>
    <?php echo __d('shared_travels', 'En cualquier momento puede ver los datos de su solicitud en el siguiente enlace')?>:
</p>

<p><?php echo $this->Html->link(__d('shared_travels', 'Ver datos de esta solicitud'), array('language'=>$request['SharedTravel']['lang'], 'controller' => 'shared-rides', 'action' => 'view', $request['SharedTravel']['id_token']/*, '_full'=>true*/), ['fullBase'=>true] )?></p>

<p>
    <?php echo __d('shared_travels', 'Un cordial saludo desde Cuba', $request['SharedTravel']['destination'])?>,
</p>

<p>
    <?php echo __d('shared_travels', '{0} y el equipo de', $assistant['name'])?> <a href="http://pickocar.com">PickoCar</a>.
</p>