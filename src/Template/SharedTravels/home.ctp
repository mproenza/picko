<?php 
use App\Model\Entity\SharedTravel;
?>

<?php $doBootbox = true?>

<div id="container">
    <div id="front-page-bg">
        <?php echo $this->element('menu', ['isHome'=>true])?>
            
        <div style="height: 100px;clear: both"></div>

        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 value-proposition">
                    <br/>
                    <h1 style="text-align: center">
                        <big><?php echo __d('home', 'Llega a cada uno de tus destinos en {0} gastando menos dinero', '<code style="background-color:inherit"><big><b>Cuba</b></big></code>')?></big>
                    </h1>
                    <br/>
                    <h2 class="h4" style="text-align: center"><?php echo __d('home', 'Comparte un taxi cómodo con otros viajeros que van al mismo destino que tú y paga sólo por los asientos que ocupes') ?></h2>
                    <hr/>
                    <h6><?php echo __d('home', 'Sólo 4 pasajeros en un taxi')?> • <?php echo __d('home', 'Recogida en tu estancia u hotel')?> • <?php echo __d('home', 'Autos muy confortables')?></h6>
                    <div class="scroll_icon_wrap" style="text-align: center">
                        <a href="#offer" class="scroll_link">
                            <span class="scroll_icon"><i class="fa fa-angle-down fa-2x" style="color: #D33C44"></i></span>
                        </a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    
    <div id="offer" style="height: 40px;clear: both"></div>
    
    <div class="container">
        
        <div class="row">
            <div class="col-md-10 offset-md-1 we-offer">
                <ul class="fa-ul">
                    <p class="lead"><?php echo __d('home', 'Con PickoCar podrás') ?>:</p>
                    <li><i class="fa-li fa fa-check"></i><big><?php echo __d('home', '<b>Ahorrar dinero</b> si viajas solo, en pareja o son tres personas y no quieren pagar el viaje completo en un taxi privado como si fueran cuatro personas.') ?></big></li>
                    <li class="mt-3"><i class="fa-li fa fa-check"></i><big><?php echo __d('home', 'Viajar cómodo en un auto moderno con aire acondicionado y con <b>sólo 4 pasajeros</b> dentro, todos yendo al mismo destino y con reservación de antemano.') ?></big></li>
                    <li class="mt-3"><i class="fa-li fa fa-check"></i><big><?php echo __d('home', 'Recibir un <b>servicio puerta a puerta</b> en el cual el taxi te recoge en tu casa de estancia u hotel y te lleva hasta tu próxima estancia.') ?></big></li>
                    <li class="mt-3"><i class="fa-li fa fa-check"></i><big><?php echo __d('home', 'Llegar a muchos de tus destinos en Cuba usando nuestra <b>amplia red de taxis</b> que conectan lugares favoritos como {0} y otros.', '<code><b>La Habana</b></code>, <code><b>Viñales</b></code>, <code><b>Varadero</b></code>, <code><b>Trinidad</b></code>, <code><b>Cayo Guillermo</b></code>') ?></big></li>
                    </ul>
                
                <div class="col-md-8 offset-md-2" style="margin-top: 40px">
                    <a class="btn btn-block btn-info" href="#routes-and-prices" style="white-space: normal;"><big><big><big><?php echo __d('home', 'Ver rutas y precios disponibles')?></big></big></big></a>
                    <div style="padding-top:10px;text-align: center"><code><big>La Habana</big></code> • <code><big>Viñales</big></code> • <code><big>Trinidad</big></code> • <code><big>Varadero</big></code></div>
                    <div style="text-align: center">... <?php echo __d('home', 'y otros destinos')?></div>
                </div>
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
                <h3><?php echo __d('home', 'Reserva y listo!')?></h3>
                <p><big><?php echo __d('home', 'En cuanto reservas, nosotros arreglamos todo de manera que compartas el viaje con otros viajeros que van al mismo destino en la misma fecha y horario. De esta manera no tienes que encontrar tú a otros pasajeros que quieran unirse y no hay que esperar a que el taxi se llene a la hora de partir.')?></big></p>
            </div>
        </div>

    </div>
    
    <div id="routes-and-prices" data-h-offset="0" class="row arrow_box arrow_box_bottom" style="margin-top: 60px"></div>
    <div class="row" style="background-color: #ebebeb;padding-bottom: 80px">
        <div class="container">
            <div class="row" style="padding-top: 80px;padding-bottom: 40px">
                <div class="col-md-10 offset-md-1">
                    <h3 style="text-align: center">
                        <?php echo __d('home', 'Selecciona tus rutas y horarios para reservar un taxi')?>
                    </h3>
                    
                    <!--<div class="col-md-10 offset-md-1">
                        <ul class="fa-ul">
                            <li><i class="fa-li fa fa-check"></i><?php echo __d('home', 'Al reservar estarás en contacto por email con uno de nuestros asistentes mientras llega la fecha del viaje, quien atenderá cualquier duda o petición que tengas, incluyendo cancelaciones.')?></li>
                        </ul>
                    </div>-->
                </div>        
            </div>            
            
            <nav id="nav-routes" class="navbar navbar-light bg-light" data-toggle="sticky-onscroll">
                <a class="navbar-brand" href="#"><b><?php echo __d('home', 'Rutas saliendo desde:')?></b></a>
                <ul class="nav nav-pills">
                    <?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
                    <li class="nav-item">
                        <a class="dropdown-item show-routes" href="#taxi-from-<?php echo str_replace(' ', '-', $locality)?>"><?php echo $locality?></a>
                    </li>
                    <?php endforeach?>
                </ul>
            </nav>

            <?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
                <div class="row" style="margin-top: 60px;">
                    <div id="taxi-from-<?php echo str_replace(' ', '-', $locality)?>" style="padding: 20px;" class="col-md-12"><big><?php echo __d('home', 'Rutas saliendo desde {0}', '<code><big><big>'.$locality.'</big></big></code>')?></big></div>
                    <br/>

                    <?php foreach (SharedTravel::$modalities as $code=>$modality):?>
                        <?php if($modality['origin_id'] == $locality_id && ( !isset($modality['active']) || $modality['active'] )):?>
                            <div class="col-md-4 col-sm-6" style="padding: 20px"><?php echo $this->element('modality_info', compact('modality') + compact('code') + compact('doBootbox'))?></div>
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
                <a href="#routes-and-prices" class="btn btn-block btn-info"><big><?php echo __d('home', 'Ver las rutas y horarios disponibles')?></big></a>
            </div>
        </div>
    </div>

    <div style="height: 90px;clear: both"></div>
    <hr/>
    <footer class="footer white" style="background-color: #003f54 !important">    
        <div class="col-md-12">
            <?php echo $this->element('footer') ?>
        </div>
    </footer>
 
</div>



<?php if($doBootbox):?>
    <?php
    echo $this->Html->css('datepicker');
    echo $this->Html->script('datepicker');
    echo $this->Html->script('datepicker-locale');
    ?>
<?php endif?>