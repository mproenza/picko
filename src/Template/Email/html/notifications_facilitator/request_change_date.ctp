<?php use App\Util\TimeUtil?>

<div><b>PickoCar #<?= $request['SharedTravel']['id']?></b></div>
<div>Fecha actual: <?= TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></div>
<div>Fecha nueva: <b><?= TimeUtil::prettyDate($request['SharedTravel']['new_date'], false)?></b></div>