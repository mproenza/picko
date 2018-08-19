<?php
use App\Model\Entity\SharedTravel;
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <div class="row">
                <p class="lead"><?php echo __d('shared_travels', 'Muchas gracias {0}', $request['SharedTravel']['name_id'])?>!</p> 
                <p class="lead"><?php echo __d('shared_travels', 'Nuestros operadores acaban de recibir los datos de tu solicitud y enseguida empiezan a organizar todo. En menos de 24 horas recibirás la confirmación.')?></p> 
                <p><?php echo __d('shared_travels', 'En cuanto todo esté listo recibirás un correo de tu operador asistente, con quien quedarás en contacto mientras llega la fecha del servicio.')?></p>
                <p><?php echo __d('shared_travels', 'Estos son todos los datos de tu solicitud')?>:</p>
                
                <hr/>
                <?php echo $this->element('shared_travel', compact('request'))?>
            </div>
        </div>
        
        <div class="col-md-3">
            <?php echo $this->element('suggest_transfers', ['route'=>$request['SharedTravel']])?>
        </div>
        
    </div>
</div>