<?php
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;

$modalityCode = $request['SharedTravel']['modality_code'];
$modality = SharedTravel::$modalities[$modalityCode];
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <p class="lead"><?php echo __d('shared_travels', 'Muchísimas gracias').'! '.__d('shared_travels', 'Ya tenemos tu solicitud de transfer.')?></p> 
            <p class="lead"><?php echo __d('shared_travels', '{0} personas desde {1} hasta {2} el {3} a las {4}.', '<code><big>'.$request['SharedTravel']['people_count'].'</big></code>', '<code><big>'.$modality['origin'].'</big></code>', '<code><big>'.$modality['destination'].'</big></code>', '<code><big>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</big></code>', '<code><big>'.$modality['time'].'</big></code>')?></p> 
            <p><?php echo __d('shared_travels', 'Te enviamos un correo a {0} con un enlace para confirmar la solicitud.', '<b>'.$request['SharedTravel']['email'].'</b>').' '.__d('shared_travels', 'Debes confirmarla para nosotros comenzar a arreglar todo.')?></p>
            <p class="alert alert-warning" role="alert"><?php echo __d('shared_travels', 'Si no ves el correo en tu bandeja de entrada, revisa la carpeta de spams.')?></p>
            <p><?php echo __d('shared_travels', 'Estos son todos los datos de tu solicitud')?>:</p>
        </div>
        
        <div class="col-md-8 offset-md-2">
            <hr/>
            <?php echo $this->element('shared_travel', compact('request'))?>
        </div>
    </div>
</div>