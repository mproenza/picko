<?php 
use App\Util\TimeUtil;
use Cake\ORM\TableRegistry;
?>

<?php
$STTable = TableRegistry::get('SharedTravels');
$request= $STTable->newEntity($request, ['fixDate'=>false]);
?>
<div><b>PickoCar #<?= $request->id?></b></div>
<div>Fecha vieja: <?= TimeUtil::prettyDate($params['old_date'], false)?></div>
<div>Fecha nueva: <b><?= TimeUtil::prettyDate($request->date, false)?></b></div>