<?php use App\Model\Entity\SharedTravel;?>

<?php $doBootbox = true?>

<?php foreach (SharedTravel::$routes as $route):?>
    <?php $route = SharedTravel::_routeFull($route);?>
    <?php if(!isset($route['active']) || $route['active'] ):?>
        <div style="display: none" id="form-<?= $route['slug']?>" class="container">
            <?= $this->element('shared_travel_book_prompt', compact('route'))?>
        </div>
    <?php endif?>
<?php endforeach?>

<?= $this->element('mobirise/menu', ['isHome'=>true])?>

<section class="header12 cid-rmoXljlUVD mbr-fullscreen mbr-parallax-background" id="header12-3">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container  ">
        <div class="media-container">
            <div class="col-md-12 align-center">
                <h1 class="mbr-section-title pb-3 mbr-white mbr-bold mbr-fonts-style display-2">
                    <span style="font-weight: normal;"><br></span><br>
                      <?= __d('/mobirise/taxi_for_2', 'Taxi en Cuba')?>
                </h1>
                <p class="mbr-text pb-3 mbr-white mbr-fonts-style display-5">
                    <?= __d('/mobirise/taxi_for_2', '¿Necesitas traslados económicos en Cuba para dos personas?')?>
                    <br>            
                    <?= __d('/mobirise/taxi_for_2', 'Comparte tu taxi con otros 2 pasajeros')?>
                    <br>
                    <strong><big><?= __d('/mobirise/taxi_for_2', 'Paga sólo la mitad del precio total en cada traslado')?></big></strong>
                    <br>
                </p>
                <div class="mbr-section-btn align-center py-2">
                    <a class="btn btn-md btn-success display-7" href="#<?php echo __d('meta', 'rutas-y-precios')?>">
                        <b><?= __d('/mobirise/taxi_for_2', 'VER RUTAS Y PRECIOS POR ASIENTO')?></b>
                    </a>
                </div>

                <div class="icons-media-container mbr-white">
                    <div class="card col-12 col-md-6 col-lg-4">
                        <div class="icon-block">
                            <span class="mbr-iconfont mbri-users" style="font-size: 60px"></span>
                        </div>
                        <h5 class="mbr-fonts-style display-5"><?= __d('/mobirise/taxi_for_2', 'Sólo 4 pasajeros en un taxi')?></h5>
                    </div>

                    <div class="card col-12 col-md-6 col-lg-4">
                        <div class="icon-block">
                            <span class="mbr-iconfont mbri-map-pin" style="font-size: 60px"></span>
                        </div>
                        <h5 class="mbr-fonts-style display-5"><?= __d('/mobirise/taxi_for_2', 'Recogida en tu estancia u hotel')?></h5>
                    </div>

                    <div class="card col-12 col-md-6 col-lg-4">
                        <div class="icon-block">
                            <span class="mbr-iconfont mbri-like" style="font-size: 60px"></span>
                        </div>
                        <h5 class="mbr-fonts-style display-5"><?= __d('/mobirise/taxi_for_2', 'Autos muy confortables')?></h5>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

<section class="counters1 counters cid-rmp3EpvjUY" id="counters1-7">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mbr-section-title pb-3 align-center mbr-fonts-style display-2">
                    <?= __d('/mobirise/taxi_for_2', 'En PickoCar organizamos viajes compartidos en taxi hacia diferentes destinos en {0} todos los días', 'Cuba')?>!
                </h2>
                <h3 class="mbr-section-subtitle mbr-fonts-style display-5">
                    <?= __d('/mobirise/taxi_for_2', 'Con sólo reservar, arreglamos todo de manera que compartas el taxi con otros viajeros que van al mismo destino que tú y que también han reservado con nosotros para la misma fecha y horario.')?>
                    <br/><br/>
                    <div>* <?= __d('/mobirise/taxi_for_2', 'Cada taxi acomoda a <strong>{0} pasajeros</strong>', 4)?> *</div>
                </h3>
            </div>
            
            <div class="col-md-4">
                <div class="card shake text-center">
                        <div class="card-body" style="padding-top: 0px">
                            <div class="card-title">
                                <b><?php echo __d('/mobirise/taxi_for_2', 'Algunos de nuestros precios <span style="display: inline-block">(por asiento)</span>')?></b>
                            </div>
                            <ul class="list-unstyled">
                                <li>La Habana > Trinidad: &nbsp;<big>$35</big></li>
                                <li>Viñales > La Habana: &nbsp;<big>$25</big></li>
                                <li>La Habana > Varadero: &nbsp;<big>$25</big></li>
                                <li>La Habana > Cayo Sta. María: &nbsp;<big>$50</big></li>
                                <li>Cayo Guillermo > La Habana: &nbsp;<big>$65</big></li>
                            </ul>
                            <div class="small"><?php echo __d('/mobirise/taxi_for_2', 'También {0} y otros', 'Cienfuegos, Santa Clara, Playa Larga, Cayo Coco')?></div>
                            <hr/>
                            <div>
                                <a class="btn btn-block btn-success" href="#<?php echo __d('meta', 'rutas-y-precios')?>">
                                    <?php echo __d('/mobirise/taxi_for_2', 'Mira todas las rutas y precios')?>
                                </a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        
        <div class="container pt-5 mt-2">
            <div class="media-container-row">
                <div class="card p-3 align-center col-12 col-md-6 col-lg-3">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-cash" style="font-size: 60px"></span>
                        </div>

                        <div class="card-text">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/taxi_for_2', 'Ahorra dinero')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                                  <?= __d('/mobirise/taxi_for_2', '<strong>Ahorra el 50% de los costos de transportación en Cuba</strong> compartiendo el taxi con otros 2 pasajeros en cada traslado. Nosotros hacemos todos los arreglos.')?>
                            </big>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 align-center col-12 col-md-6 col-lg-3">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-pin" style="font-size: 60px"></span>
                        </div>
                        <div class="card-text">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/taxi_for_2', 'Puerta a puerta')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                                  <?= __d('/mobirise/taxi_for_2', 'El taxi <strong>les recoge en su casa de estancia u hotel</strong> y <strong>les lleva hasta su próxima estancia</strong>. No es necesario salir a buscar un taxi o agarrar tu bus yendo a la estación.')?>
                            </big>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 align-center col-12 col-md-6 col-lg-3">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-sun" style="font-size: 60px"></span>
                        </div>
                        <div class="card-text">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/taxi_for_2', 'Viaja rápido')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                              <?= __d('/mobirise/taxi_for_2', 'En un <strong>auto cómodo con aire acondicionado</strong> y con <strong>sólo 4 pasajeros</strong> dentro, todos yendo al mismo destino y con reservación de antemano.')?>
                            </big>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 align-center col-12 col-md-6 col-lg-3">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-image-slider" style="font-size: 60px"></span>
                        </div>

                        <div class="card-texts">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/taxi_for_2', 'Muchos destinos')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                                  <?= __d('/mobirise/taxi_for_2', 'Ahorra en todos tus traslados en Cuba. Conectamos destinos como {0} y otros.', '<strong>La Habana</strong>, <strong>Viñales</strong>, <strong>Varadero</strong>, <strong>Trinidad</strong>, <strong>Cayo Guillermo</strong>, <strong>Cayo Santa María</strong>')?>
                            </big>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section info2 cid-rmp8Fbk1ML" id="info2-8">
    <div class="container">
        <div class="row main justify-content-center">
            <div class="media-container-column col-12 col-lg-3 col-md-4">
                <div class="mbr-section-btn align-left py-4"><a class="btn btn-success display-7" href="#<?php echo __d('meta', 'rutas-y-precios')?>">
              <?= __d('/mobirise/taxi_for_2', 'Comenzar a reservar mis traslados')?></a></div>
            </div>
            <div class="media-container-column title col-12 col-lg-7 col-md-6">
                <h2 class="align-right mbr-bold mbr-white pb-3 mbr-fonts-style display-2">
                  <?= __d('/mobirise/taxi_for_2', 'La magia de compartir taxi y ahorrar dinero en tu viaje a Cuba')?></h2>
                <h3 class="mbr-section-subtitle align-right mbr-light mbr-white mbr-fonts-style display-5">
                    <?php echo __d('/mobirise/taxi_for_2', 'En un traslado de <b>La Habana a Trinidad</b> en que se pagarían <b>{0} - {1} a un taxi privado</b> -sin importar cuántas personas sean-<b> a 2 personas les costaría en PickoCar {2} en total ({3} por asiento)</b>, ahorrándose entre {4} y {5}.', '<big>$130</big>', '<big>$160</big>', '$70', '$35', '$60', '$90')?>
                </h3>
            </div>
        </div>
    </div>
</section>

<section class="toggle1 cid-rmACGoAqAT" id="<?= __d('meta', 'rutas-y-precios')?>">
    <div class="container">
        <div class="media-container-row">
            <div class="col-12">

                <div class="section-head text-center space30">
                    <h2 class="mbr-section-title pb-5 mbr-fonts-style display-2">
                    <small><?= __d('/mobirise/taxi_for_2', 'Rutas, precios y horarios de nuestros taxis en Cuba')?></small>
                    </h2>
                    <h3><?= __d('/mobirise/taxi_for_2', 'Reserva tus asientos > Nosotros coordinamos los traslados > El taxi te recoge en la fecha indicada junto a los otros pasajeros')?></h3>
                    <br/>
                    <div style="color: salmon"><big><?= __d('/mobirise/taxi_for_2', 'Cancela en cualquier momento si tus planes cambian')?></big></div>
                    <div><?= __d('/mobirise/taxi_for_2', 'Quedas en contacto con un Asistente a Clientes para cualquier trámite')?></div>
                    <div><?= __d('/mobirise/taxi_for_2', 'El pago se realiza en efectivo directamente al chofer el día de cada servicio')?></div>
                    <br/>
                </div>

                <div class="clearfix"></div>

                <div id="bootstrap-toggle" class="toggle-panel accordionStyles tab-content">
                  <?= $this->element('mobirise/widgets/all_routes')?>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="counters5 counters cid-rnfgdix17n" id="<?= __d('meta', 'debes-saber')?>">
    <div class="container pt-4 mt-2">
        <?= $this->element('/mobirise/you_must_know')?>
        <div class="mbr-section-btn align-center py-2">
            <a class="btn btn-md btn-success display-7" href="#<?php echo __d('meta', 'rutas-y-precios')?>">
                <b><?= __d('/mobirise/taxi_for_2', 'VER RUTAS DE TAXI Y PRECIOS')?></b>
            </a>
        </div>
    </div>
</section>

<?= $this->element('/mobirise/footer')?>