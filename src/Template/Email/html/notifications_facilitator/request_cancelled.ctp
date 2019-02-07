<?php 
use App\Util\TimeUtil;
use Cake\ORM\TableRegistry;
?>
<?php
$STTable = TableRegistry::get('SharedTravels');
$request= $STTable->newEntity($request, ['fixDate'=>false]);
?>
<div><b>CANCELADO > PickoCar #<?= $request->id?></b></div>
<div><?= TimeUtil::prettyDate($request->date, false)?></div>