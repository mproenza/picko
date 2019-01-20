<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
?>
<div>PickoCar #<b><?php echo $request['SharedTravel']['id']?></b></div>
<div><b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></b> | <b><?php echo $request['SharedTravel']['origin']?></b> - <b><?php echo $request['SharedTravel']['destination']?></b> | <b><?php echo $request['SharedTravel']['departure_time_desc']?></b> | <b><?php echo $request['SharedTravel']['people_count']?> pax</b>: <?php echo $request['SharedTravel']['name_id']?></div>
<?php if($request['SharedTravel']['contacts'] != null):?>
    <div>Contactos: <b><?php echo $request['SharedTravel']['contacts']?></b></div>
<?php endif?>
<div>Recoger en: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_origin'])?></div>
<div>Llevar a: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_destination'])?></div>
<div>Total a pagar: <?php echo $request['SharedTravel']['people_count']?> x <?php echo $request['SharedTravel']['price_x_seat']?> = <b><?php echo $request['SharedTravel']['people_count']*$request['SharedTravel']['price_x_seat']?> cuc</b></div>