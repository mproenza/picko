<?php 
use App\Model\Entity\SharedTravel;
?>

<?php $doBootbox = true?>

<div id="container">
    <div id="front-page-bg">
        <?php echo $this->element('menu', ['isHome'=>true])?>
            
        <div style="height: 100px;clear: both"></div>

        <div class="container">
            
            <div class="row value-proposition">
                
                <div class="col-md-8">
                    <h1>
                        <?php echo __d('home', 'Comparte tu taxi en {0} y gasta menos para llegar a cada destino', '<code><big><b>Cuba</b></big></code>')?>
                    </h1>
                    <br/>
                    <br/>
                    <h2 class="h4"><?php echo __d('home', 'En PickoCar reservas un taxi a tu destino, haces el recorrido junto a otros viajeros que reservaron tu misma ruta y <span style="display: inline-block"><b>pagas sólo por tus asientos</b></span>')?></h2>
                    <br/>
                    <hr/>
                    <p class="lead"><b><?php echo __d('home', 'Sólo 4 pasajeros en un taxi')?> • <?php echo __d('home', 'Recogida en tu estancia u hotel')?> • <?php echo __d('home', 'Autos muy confortables')?></b></p>
                    <div class="scroll_icon_wrap" style="text-align: center">
                        <a href="#offer" class="scroll_link">
                            <span class="scroll_icon"><i class="fa fa-angle-down fa-2x" style="color: #D33C44"></i></span>
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shake">
                        <div class="card-body">
                            <div class="card-title">
                                <b><?php echo __d('home', 'Algunos de nuestros precios <span style="display: inline-block">(por asiento)</span>')?></b>
                            </div>
                            <div>La Habana > Trinidad: <big>$35</big></div>
                            <div>Viñales > La Habana: <big>$25</big></div>
                            <div>La Habana > Varadero: <big>$25</big></div>
                            <div>Viñales > Trinidad: <big>$50</big></div>
                            <div>Cayo Guillermo > La Habana: <big>$55</big></div>
                            <br/>
                            <div>* <?php echo __d('home', 'También {0} y otros', 'Cienfuegos, Santa Clara, Playa Larga, Cayo Coco')?></div>
                            <hr/>
                            <div>
                                <a class="btn btn-block btn-info" href="#<?php echo __d('meta', 'rutas-y-precios')?>" style="white-space: normal;">
                                    <big><?php echo __d('home', 'Mira todas las rutas y precios')?></big>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <div id="offer" style="height: 40px;clear: both"></div>
    
    <div class="container">
        
        <div class="row">
            <div class="col-md-10 offset-md-1 we-offer">
                <h3 class="lead center"><big><b><?php echo __d('home', 'En PickoCar organizamos viajes compartidos en taxi hacia diferentes destinos en la isla todos los días')?>!</b></big></h3>
                <p class="lead"><b><?php echo __d('home', 'Con sólo reservar, arreglamos todo de manera que compartas el taxi con otros viajeros que van al mismo destino que tú y que han reservado con nosotros para la misma fecha y horario -sólo viajan 4 pasajeros en cada taxi.')?></b></p>
                <p class="lead"><b><?php echo __d('home', 'Esto es lo que ganas:')?></b></p>
                <br/>
                <ul class="fa-ul">
                    <li><i class="fa-li fa fa-check"></i>
                        <big><?php echo __d('home', '<b>Ahorras dinero</b> si viajas solo, en pareja o son tres personas y no quieren pagar el viaje completo en un taxi privado como si fueran cuatro personas.') ?></big>
                        <p class="card" style="padding: 10px;margin-top: 20px;margin-bottom: 20px"><em><?php echo __d('home', 'En un viaje de <b>La Habana a Trinidad</b> en que se pagarían {0} - {1} a un chofer privado -sin importar cuántas personas sean-, <b>a 2 personas les costaría en PickoCar {2} en total ({3} por asiento)</b>, ahorrándose entre {4} y {5}.', '<big>$130</big>', '<big>$160</big>', '$70', '$35', '$60', '$90')?></em></p>
                    </li>
                    <li class="mt-3"><i class="fa-li fa fa-check"></i><big><?php echo __d('home', '<b>Viajas cómodo</b> en un auto moderno con aire acondicionado y con <b>sólo 4 pasajeros</b> dentro, todos yendo al mismo destino y con reservación de antemano.') ?></big></li>
                    <li class="mt-3"><i class="fa-li fa fa-check"></i><big><?php echo __d('home', '<b>Recibes un servicio puerta a puerta</b> en el cual <b>el taxi te recoge en tu casa de estancia u hotel</b> y te lleva hasta tu próxima estancia.') ?></big></li>
                    <li class="mt-3"><i class="fa-li fa fa-check"></i><big><?php echo __d('home', '<b>Llegas a muchos de tus destinos</b> en Cuba usando nuestra amplia red de taxis que conectan lugares favoritos como {0} y otros.', '<code><b>La Habana</b></code>, <code><b>Viñales</b></code>, <code><b>Varadero</b></code>, <code><b>Trinidad</b></code>, <code><b>Cayo Guillermo</b></code>') ?></big></li>
                </ul>
                
                <div class="col-md-8 offset-md-2" style="margin-top: 60px">
                    <a class="btn btn-block btn-info" href="#<?php echo __d('meta', 'rutas-y-precios')?>" style="white-space: normal;">
                        <span class="fa-2x"><?php echo __d('home', 'Mira las rutas y precios disponibles')?></span>
                    </a>
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
    
    <div id="<?php echo __d('meta', 'rutas-y-precios')?>" data-h-offset="0" class="row arrow_box arrow_box_bottom" style="margin-top: 60px"></div>
    <div class="row" style="background-color: #ebebeb;padding-bottom: 80px">
        <div class="container">
            <div class="row" style="padding-top: 80px;padding-bottom: 40px">
                <div class="col-md-10 offset-md-1">
                    <h3 style="text-align: center">
                        <?php echo __d('home', 'Estas son las rutas, precios y horarios de nuestros taxis')?>
                    </h3>
                    <h4 style="text-align: center">
                        <?php echo __d('home', 'Reserva nuestros servicios aquí:')?>
                    </h4>
                </div>        
            </div>            
            
            <nav id="nav-routes" class="navbar navbar-light bg-light" data-toggle="sticky-onscroll">
                <a class="navbar-brand" href="#"><b><?php echo __d('home', 'Rutas saliendo desde:')?></b></a>
                <ul class="nav nav-pills">
                    <?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
                        <?php if(!isset($locality['active']) || $locality['active']):?>
                        <li class="nav-item">
                            <a class="dropdown-item show-routes" href="#taxi-from-<?php echo str_replace(' ', '-', $locality['name'])?>"><?php echo $locality['name']?></a>
                        </li>
                        <?php endif;?>
                    <?php endforeach?>
                </ul>
            </nav>

            <?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
                <?php if(!isset($locality['active']) || $locality['active']):?>
                <div class="row" style="margin-top: 60px;">
                    <div id="taxi-from-<?php echo str_replace(' ', '-', $locality['name'])?>" style="padding: 10px" class="col-md-12">
                        <big><?php echo __d('home', 'Rutas saliendo desde {0}', '<code><big><big>'.$locality['name'].'</big></big></code>')?></big>
                    </div>
                    <br/>

                    <?php foreach (SharedTravel::$modalities as $code=>$modality):?>
                        <?php if($modality['origin_id'] == $locality_id && ( !isset($modality['active']) || $modality['active'] )):?>
                            <div class="col-md-4 col-sm-6" style="padding: 20px"><?php echo $this->element('modality_info', compact('modality') + compact('code') + compact('doBootbox'))?></div>
                        <?php endif?>
                    <?php endforeach?>
                </div>
            
                <br/>
                <br/>
                <?php endif;?>
            <?php endforeach?>
            

        </div>
    </div>
    <div class="row arrow_box arrow_box_top" style=""></div>

    <div id="<?php echo __d('meta', 'debes-saber')?>" style="height: 120px;clear: both"></div>
    
    <div class="row" style="padding-top: 80px">
        <div class="container">
            <div class="col-md-8 offset-md-2">
                <?php echo $this->element('you_must_know')?>
                <br/>            
                <br/>
                <a href="#<?php echo __d('meta', 'rutas-y-precios')?>" class="btn btn-block btn-info"><big><?php echo __d('home', 'Ver las rutas y horarios disponibles')?></big></a>
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