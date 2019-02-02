<?php use App\Util\TimeUtil?>

<div><b>PickoCar #<?= $request->id?></b></div>
<div>Fecha vieja: <?= TimeUtil::prettyDate($request->old_date, false)?></div>
<div>Fecha nueva: <b><?= TimeUtil::prettyDate($request->date, false)?></b></div>