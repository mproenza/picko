<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;

$modality = SharedTravel::$modalities[$request['SharedTravel']['modality_code']]
?>
<div>PickoCar #<b><?php echo $request['SharedTravel']['id']?></b></div>
<div><b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></b> / <b><?php echo $modality['origin']?></b> - <b><?php echo $modality['destination']?></b> / <b><?php echo $modality['time']?></b> / <b><?php echo $request['SharedTravel']['people_count']?> pax</b>: <?php echo $request['SharedTravel']['name_id']?></div>
<div>Recoger en: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_origin'])?></div>
<div>Llevar a: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_destination'])?></div>