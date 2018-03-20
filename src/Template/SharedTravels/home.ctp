<?php 
use App\Model\Entity\SharedTravel;
use Cake\I18n\I18n;
?>

<?php $doBootbox = true?>

<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <br/>
            <h1 style="text-align: center">
                <?php echo __d('home', 'PAGA MENOS PARA LLEGAR A TUS DESTINOS EN CUBA') ?>
            </h1>
            <br/>
            <h4 style="text-align: center"><?php echo __d('home', 'Comparte un taxi cómodo con otros viajeros que van al mismo destino que tú y paga sólo por los asientos que ocupes') ?></h4>
          
            <hr/>
            
            <ul>
                <p><b><?php echo __d('home', 'Ofrecemos') ?>:</b></p>
                <li><?php echo __d('home', 'Una amplia red de taxis que conectan destinos como {0} y muchos otros', 'La Habana, Viñales, Trinidad, Varadero, Cayo Guillermo') ?></li>
                <li><?php echo __d('home', 'Sólo 4 pasajeros en un auto, todos yendo al mismo destino en un viaje confortable en auto moderno con aire acondicionado') ?></li>
                <li><?php echo __d('home', 'Servicio puerta a puerta: el taxi te recoge en tu casa de estancia u hotel y te lleva hasta tu próxima estancia') ?></li>
                <li><?php echo __d('home', 'Precios muy convenientes si viajas solo, en pareja o son tres personas y no quieren pagar el viaje completo en un taxi privado como si fueran cuatro personas') ?></li>
            </ul>
        </div> 
    </div>
    
    <div class="row" style="margin-top: 20px">
        <div class="col-md-6 offset-md-3">
            <a class="btn btn-block btn-info" href="#transfers-available" style="white-space: normal;"><big><big><big><?php echo __d('home', 'Ver rutas y precios disponibles')?></big></big></big></a>
            <div style="padding-top:10px;text-align: center"><code><big>La Habana</big></code> • <code><big>Viñales</big></code> • <code><big>Trinidad</big></code> • <code><big>Varadero</big></code></div>
            <div style="text-align: center">... <?php echo __d('home', 'y otros destinos')?></div>
        </div>
    </div>
    
    <div class="row" style="margin-top: 60px;text-align: center">
        <div class="col-md-4 center" style="padding-bottom: 30px">
            <h3><?php echo __d('home', 'Gasta menos para llegar a tus destinos')?></h3>
            <p><big><?php echo __d('home', 'Paga sólo por los asientos que ocupes en el taxi y no por el viaje completo. Si ustedes son menos de 4 personas, es conveniente compartir los asientos sobrantes con otros pasajeros para que ellos paguen parte del viaje. Lo bueno es que todos pagan menos.')?></big></p>
        </div>
        <div class="col-md-4 center" style="padding-bottom: 30px">
            <h3><?php echo __d('home', 'Llega cómodo y rápido')?></h3>
            <p><big><?php echo __d('home', 'Te buscamos donde te estás hospedando (casa, hotel u otro) y te llevamos exactamente hasta el lugar donde te hospedarás en tu destino. Junto a tus compañeros harás un recorrido muy cómodo y rápido hasta tu destino en un auto moderno con mucho confort.')?></big></p>
        </div>
        <div class="col-md-4 center" style="padding-bottom: 30px">
            <h3><?php echo __d('home', 'Reserva, y listo!')?></h3>
            <p><big><?php echo __d('home', 'En cuanto reservas, nosotros arreglamos todo de manera que compartas el viaje con otros viajeros que van al mismo destino en la misma fecha y horario. De esta manera no tienes que encontrar tú a otros pasajeros que quieran unirse y no hay que esperar a que el taxi se llene a la hora de partir.')?></big></p>
        </div>
    </div>
    
</div>

<div id="transfers-available" data-h-offset="0" class="row arrow_box arrow_box_bottom" style="margin-top: 60px"></div>
<div class="row" style="background-color: #ebebeb;padding-bottom: 80px">
    <div class="container">
        <div class="row" style="padding-top: 80px;">
            <div class="col-md-10 offset-md-1" style="text-align: center">
                <p class="lead">
                    <big><?php echo __d('home', 'Selecciona una de nuestras rutas y horarios para reservar un taxi')?></big>
                </p>
                <p>
                    <?php echo __d('home', 'Uno de nuestros choferes te recogerá en el lugar y fecha que indiques')?>
                </p>
            </div>        
        </div>
        
        <div class="row alert alert-warning" style="margin-top: 50px;text-align: center">
			<div class="col-md-4 center">
				<div style="float:left;width:20%;font-size:40px"><i class="fa fa-drivers-license-o"></i></div>
				<div style="float:left;width:80%"><p><big><?php echo __d('home', 'Choferes y autos registrados y con licencia para realizar este servicio')?></big></p></div>
			</div>
			<div class="col-md-4 center">
				<div style="float:left;width:20%;font-size:40px"><i class="fa fa-money"></i></div>
				<div style="float:left;width:80%"><p><big><?php echo __d('home', 'Pago en efectivo directamente al chofer en el momento de la recogida')?></big></p></div>
			</div>
			<div class="col-md-4 center">
				<div style="float:left;width:20%;font-size:40px"><i class="fa fa-check-square-o"></i></div>
				<div style="float:left;width:80%"><p><big><?php echo __d('home', 'Cada viaje confirmado queda en nuestra agenda para su realización')?></big></p></div>
			</div>
        </div>
        
        <?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
            <div class="row" style="margin-top: 60px;">
                <div style="padding: 20px;" class="col-md-12"><big><?php echo __d('home', 'Rutas disponibles desde {0}', '<b><code><big><big>'.$locality.'</big></big></code></b>')?></big></div>
                <br/>
                <?php $i=0?>
                <?php foreach (SharedTravel::$modalities as $code=>$modality):?>
                    <?php if($modality['origin_id'] == $locality_id && ( !isset($modality['active']) || $modality['active'] )):?>
                        <div class="col-md-4 col-sm-6" style="padding: 20px"><?php echo $this->element('modality_info', compact('modality') + compact('code') + compact('doBootbox'))?></div>
                        <?php $i++?>
                        <?php if($i == 3):?><?php $i = 0?><br/><br/><?php endif?>
                    <?php endif?>
                <?php endforeach?>
            </div>
            
            <br/>
            <hr/>
        <?php endforeach?>
        
    </div>
</div>
<div class="row arrow_box arrow_box_top" style=""></div>

<div class="row" style="padding-top: 80px">
    <div class="container">
        <div class="col-md-8 offset-md-2">
            <p class="lead"><big><?php echo __d('home', 'Preguntas frecuentes')?></big></p>
            <hr/>
            <p class="lead">1. <?php echo __d('home', '¿Cuánto demoran en confirmarme la realización del viaje?')?></p>
            <p><?php echo __d('home', 'Usualmente confirmamos instantáneamente porque tenemos otras solicitudes pendientes que se pueden emparejar en el mismo viaje con usted.')?></p>
            <p><?php echo __d('home', 'Cuando esto no ocurre entonces usamos otras vías para recibir solicitudes, por lo cual lo normal es que confirmemos  en las primeras 24 horas.')?></p>
            <p><?php echo __d('home', 'Una vez que le confirmamos, ya su viaje queda en nuestra agenda y el viaje se realizará sin problemas.')?></p>
            <br/>
            <p class="lead">2. <?php echo __d('home', '¿Puedo llevar mucho equipaje?')?></p>
            <p><?php echo __d('home', 'Siempre sugerimos considerar NO solicitar nuestro servicio si se lleva mucho equipaje. Esto se debe a que el auto va a ser compartido, y por tanto también el espacio del maletero.')?></p>
            <p><?php echo __d('home', 'Una maleta mediana por cada persona es aceptable, pero si las maletas son demasiado grandes entonces es mejor considerar viajar en bus.')?></p>
            <br/>
            <p class="lead">3. <?php echo __d('home', '¿Puedo hacer paradas para hacer fotos en lugares que me interesen dentro del recorrido?')?></p>
            <p><?php echo __d('home', 'NO realizamos paradas de tipo excursionistas porque el auto debe llegar a su destino a una hora adecuada para prestar otro servicio.')?></p>
            <p><?php echo __d('home', 'En los tramos largos (ej. La Habana - Trinidad) realizamos una parada en cafetería para merendar e ir al baño, y además se pueden solicitar otras paradas para cualquier otra necesidad.')?></p>
            <br/>            
            <br/>
            <a href="#transfers-available" class="btn btn-block btn-info"><big><?php echo __d('home', 'Ver las rutas y horarios disponibles')?></big></a>
        </div>
    </div>
</div>

<?php if($doBootbox):?>
    <?php
    echo $this->Html->css('datepicker');
    echo $this->Html->script('datepicker');
    echo $this->Html->script('datepicker-locale');
    ?>
<?php endif?>