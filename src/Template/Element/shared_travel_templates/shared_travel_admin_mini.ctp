<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;

if(!isset($showEmail)) $showEmail = true;
if(!isset($showDetails)) $showDetails = false;
if(!isset($admin)) $admin = false;
?>
<div>PickoCar #<b><?php echo $request['SharedTravel']['id']?></b></div>
<div><b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></b> | <b><?php echo $request['SharedTravel']['origin_short']?></b> - <b><?php echo $request['SharedTravel']['destination_short']?></b> | <b><?php echo $request['SharedTravel']['departure_time_desc']?></b> | <b><?php echo $request['SharedTravel']['people_count']?> pax</b>: <?php echo $request['SharedTravel']['name_id']?></div>
<?php if($request['SharedTravel']['contacts'] != null):?>
    <div>Contactos: <b><?php echo $request['SharedTravel']['contacts']?></b></div>
<?php endif?>
<div>Recoger en: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_origin'])?></div>
<div>Llevar a: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_destination'])?></div>
<div>Total a pagar: <?php echo $request['SharedTravel']['people_count']?> x <?php echo $request['SharedTravel']['price_x_seat']?> = <b><?php echo $request['SharedTravel']['people_count']*$request['SharedTravel']['price_x_seat']?> cuc</b></div>

<?php $st = SharedTravel::getStateDesc($request['SharedTravel']['state'])?>
<p><span class="text-muted"><b><?php echo __d('shared_travels', 'Estado')?>:</b></span> <big><abbr class="info" title="<?php echo $st['description']?>" style="text-decoration: none"><span class="<?php echo $st['class']?>"><?php echo $st['title'] ?></span></abbr></big></p>
<?php if($showDetails):?>
    <hr/>
    <div>
        <small class="text-muted">
            (creado <?php 
        echo TimeUtil::prettyDate($request['SharedTravel']['created'], false);
        $time = new \Cake\I18n\Time($request['SharedTravel']['created']);
        echo ' / '.$time->timeAgoInWords([
            //'format' => ['month'=>'month'],
            'accuracy' => ['month'=>'month', 'day'=>'day'],
            'end' => '1 year'
            ]);
        ?>)
        </small>
    </div>
    <?php if($showEmail):?><div><span class="text-muted"><?php echo __d('shared_travels', 'Correo')?>:</span> <?php echo $request['SharedTravel']['email']?></div><?php endif?>
    <div><span class="text-muted"><?php echo __d('shared_travels', 'Idioma')?>:</span> <?php echo $request['SharedTravel']['lang']?></div>
    <div><span class="text-muted">IP:</span> <?php echo $request['SharedTravel']['from_ip']?></div>
    <div><span class="text-muted">
        <?php echo $this->Html->link('Permalink', array('controller'=>'shared-rides', 'action' => 'view', $request['SharedTravel']['id_token']))?>
        <?php if($admin):?>
            | <?php echo $this->Html->link('admin', array('controller'=>'shared-rides', 'action' => 'admin', $request['SharedTravel']['id']))?>
        <?php endif?>
    </div>
<?php endif?>