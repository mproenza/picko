<?php
use App\Util\TimeUtil;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
?>
<?php
$STTable = TableRegistry::get('SharedTravels');
$request = $STTable->newEntity($request, ['fixDate'=>false]);

$assistant = Configure::read('customer_assistant_'.$request->lang);
?>
<p>
    <?php $st = \App\Model\Entity\SharedTravel::getStateDesc($request->state)?>
    <small>
        <em><?= __d('emails2traveler', 'Este es un correo automático a nombre de su Asistente de PickoCar (servicio de taxi compartido en Cuba) sobre un servicio que usted tiene reservado y <b>CONFIRMADO</b> en nuestra agenda. Puede responder el correo directamente para comunicarse con su asistente.')?></em>
    </small>
    <hr style="color:#efefef; background-color:#efefef; height:1px; max-height: 1px; border:none; margin-bottom: 10px;"/>
</p>

<p>
    Hola <?php echo $request->name_id?>, 
</p>

<p>
    <?= __d('emails2traveler', 'Le escribe {0} de PickoCar acá en Cuba.', $assistant['name'])?> <?= __d('emails2traveler', 'Espero estén teniendo excelentes días aquí en la isla!')?>
</p>

<p><?= __d('emails2traveler', 'Le escribo rápidamente sólo para <b>reconfirmar el servicio de taxi compartido</b> que usted reservó con nosotros para la fecha {0} a las {1} para ir de {2} a {3}, {4} personas.',
        '<b>'.TimeUtil::prettyDate($request->date, false).'</b>',
        '<b>'.$request->getDepartureTimeDesc().'</b>',
        '<b>'.$request->getOriginName().'</b>',
        '<b>'.$request->getDestinationName().'</b>',
        '<b>'.$request->people_count.'</b>')?>
</p>

<p><?= __d('emails2traveler', 'Aquí puede ver los detalles de su solicitud:')?></p>

<p><?php echo $this->Html->link(__d('shared_travels', 'Ver datos de esta solicitud'), array('language'=>$request->lang, 'controller' => 'shared-rides', 'action' => 'view', $request->id_token/*, '_full'=>true*/), ['fullBase'=>true] )?></p>

<p><?= __d('emails2traveler', 'Todo está listo y el taxi les recogerá sobre esa hora en la dirección indicada:')?></p>

<p><b><?= $request->address_origin?></b></p>

<p><?= __d('emails2traveler', 'Por favor déjeme saber si hubiera algún cambio de planes, si hay que hacer algún ajuste a la reservación o si puedo ayudar en algo más.')?></p>

<p><?= __d('emails2traveler', 'Tengan un agradable traslado y que disfruten {0}!', $request->getDestinationName())?></p>

<p>
    <?= $assistant['name']?>
</p>