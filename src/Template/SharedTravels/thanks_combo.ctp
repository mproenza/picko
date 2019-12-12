<?php
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p class="lead"><?php echo __d('shared_travels', 'Muchísimas gracias').'! '.__d('/mobirise/hav_cfg_tri', 'Ya tenemos tus solicitudes de taxi compartido.')?></p> 
            <p class="lead"><?php echo __d('/mobirise/hav_cfg_tri', '{0} personas para hacer la ruta {1} > {2}  > {3} el {4}.', '<code><big>'.$request1['SharedTravel']['people_count'].'</big></code>', '<code><big>'.$request1['SharedTravel']['origin'].'</big></code>', '<code><big>'.$request1['SharedTravel']['destination'].'</big></code>', '<code><big>'.$request2['SharedTravel']['destination'].'</big></code>', '<code><big>'.TimeUtil::prettyDate($request1['SharedTravel']['date'], false).'</big></code>')?></p>
            <p><?php echo __d('/mobirise/hav_cfg_tri', 'Precio total: {0}', '<code><big>'. (SharedTravel::getTotalPrice($request1['SharedTravel']) + SharedTravel::getTotalPrice($request2['SharedTravel'])).' cuc</big></code>')?></p>
            <p><?php echo __d('/mobirise/hav_cfg_tri', '<b>Te enviamos 2 correos por separado a {0}</b> con un enlace para confirmar cada solicitud.', $request1['SharedTravel']['email']).' '.__d('/mobirise/hav_cfg_tri', 'Por favor asegúrate de activar ambas solicitudes para nosotros comenzar a coordinar todo.')?></p>
            <p><?php echo __d('/mobirise/hav_cfg_tri', 'Estos son los datos de las solicitudes')?>:</p>
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-5 offset-md-1 alert alert-info">
            <strong>Taxi <?= $request1['SharedTravel']['origin']?> > <?= $request1['SharedTravel']['destination']?></strong>
            <hr/>
            <?php echo $this->element('shared_travel', ['request'=>$request1])?>
        </div>
        <div class="col-md-5 offset-md-1 alert alert-info">
            <strong>Taxi <?= $request2['SharedTravel']['origin']?> > <?= $request2['SharedTravel']['destination']?></strong>
            <hr/>
            <?php echo $this->element('shared_travel', ['request'=>$request2])?>
        </div>
    </div>
</div>