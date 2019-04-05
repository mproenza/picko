<?php

use App\Model\Entity\SharedTravel;?>
<?php use Cake\I18n\I18n;?>

<?php $doBootbox = true?>

<?php foreach (SharedTravel::$routes as $route):?>
    <?php $route = SharedTravel::_routeFull($route);?>
    <?php if(!isset($route['active']) || $route['active'] ):?>
        <div style="display: none" id="form-<?= $route['slug']?>">
            <?= $this->element('shared_travel_book_prompt', compact('route'))?>
        </div>
    <?php endif?>
<?php endforeach?>

<section class="menu cid-qTkzRZLJNu" once="menu" id="menu1-0">
    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm bg-color transparent">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <?php echo $this->Html->link('<img src="assets/images/logo43.png" alt="PickoCar" style="height: 2.8rem;">', ['_name'=>'homepage'], ['escape' => false]); ?>
                </span>
                <span class="navbar-caption-wrap">
                  <?php echo $this->Html->link('PickoCar', ['_name'=>'homepage'], ['class' => 'navbar-caption text-white display-4']); ?>
                </span>

                <ul class="navbar-nav">
                    <li class="nav-item">
                      <?php echo $this->Html->lang(I18n::getLocale(), $this->request, ['class'=>'nav-link link text-white display-4']) ?>
                    </li>
                </ul>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                <li class="nav-item">
                  <?php echo $this->Html->link(__d('shared_travels', 'Sobre Nosotros'), ['plugin'=>null, 'controller'=>'pages', 'action'=>'display', 'about'], ['class' => 'nav-link link text-white display-4']); ?>
                </li>
                <li class="nav-item">
                  <?php echo $this->Html->link(__d('shared_travels', 'Contactar'), ['plugin'=>null, 'controller'=>'contact'], ['class' => 'nav-link link text-white display-4']); ?>
                </li>
            </ul>
            <div class="navbar-buttons mbr-section-btn"><a class="btn btn-sm btn-success display-4" href="#<?php echo __d('meta', 'rutas-y-precios')?>">
                    <b><?= __d('/mobirise/home', 'VER RUTAS DE TAXI Y PRECIOS')?></b>
                </a></div>
        </div>
    </nav>
</section>

<section class="header12 cid-rmoXljlUVD mbr-fullscreen mbr-parallax-background" id="header12-3">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container  ">
        <div class="media-container">
            <div class="col-md-12 align-center">
                <h1 class="mbr-section-title pb-3 mbr-white mbr-bold mbr-fonts-style display-2">
                    <span style="font-weight: normal;"><br></span><br>
                      <?= __d('/mobirise/home', 'Comparte tu taxi en {0}. Gasta menos para llegar a cada destino', 'Cuba')?>
                </h1>
                <p class="mbr-text pb-3 mbr-white mbr-fonts-style display-5">
                    <?= __d('/mobirise/home', 'Llega desde / hasta {0} y otros. Haz cada traslado junto a otros viajeros que reservaron tu misma ruta. <strong>Paga sólo por tus asientos.</strong>', 'La Habana, Trinidad, Viñales, Varadero, Cayo Guillermo')?>
                </p>
                <div class="mbr-section-btn align-center py-2">
                    <a class="btn btn-md btn-success display-7" href="#<?php echo __d('meta', 'rutas-y-precios')?>">
                        <b><?= __d('/mobirise/home', 'VER RUTAS DE TAXI Y PRECIOS')?></b>
                        <br>
                    </a>
                </div>

                <div class="icons-media-container mbr-white">
                    <div class="card col-12 col-md-6 col-lg-4">
                        <div class="icon-block">
                            <span class="mbr-iconfont mbri-users"></span>
                        </div>
                        <h5 class="mbr-fonts-style display-5"><?= __d('/mobirise/home', 'Sólo 4 pasajeros en un taxi')?></h5>
                    </div>

                    <div class="card col-12 col-md-6 col-lg-4">
                        <div class="icon-block">
                            <span class="mbr-iconfont mbri-map-pin"></span>
                        </div>
                        <h5 class="mbr-fonts-style display-5"><?= __d('/mobirise/home', 'Recogida en tu estancia u hotel')?></h5>
                    </div>

                    <div class="card col-12 col-md-6 col-lg-4">
                        <div class="icon-block">
                            <span class="mbr-iconfont mbri-like"></span>
                        </div>
                        <h5 class="mbr-fonts-style display-5"><?= __d('/mobirise/home', 'Autos muy confortables')?></h5>
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
                    <?= __d('/mobirise/home', 'En PickoCar organizamos viajes compartidos en taxi hacia diferentes destinos en {0} todos los días', 'Cuba')?>!
                </h2>
                <h3 class="mbr-section-subtitle mbr-fonts-style display-5">
                    <?= __d('/mobirise/home', 'Con sólo reservar, arreglamos todo de manera que compartas el taxi con otros viajeros que van al mismo destino que tú y que también han reservado con nosotros para la misma fecha y horario.')?>
                    <br/><br/>
                    <div>* <?= __d('/mobirise/home', 'Cada taxi acomoda a <strong>{0} pasajeros</strong>', 4)?> *</div>
                </h3>
            </div>
            
            <div class="col-md-4">
                <div class="card shake text-center">
                        <div class="card-body" style="padding-top: 0px">
                            <div class="card-title">
                                <b><?php echo __d('/mobirise/home', 'Algunos de nuestros precios <span style="display: inline-block">(por asiento)</span>')?></b>
                            </div>
                            <ul class="list-unstyled">
                                <li>La Habana > Trinidad: &nbsp;<big>$35</big></li>
                                <li>Viñales > La Habana: &nbsp;<big>$25</big></li>
                                <li>La Habana > Varadero: &nbsp;<big>$25</big></li>
                                <li>La Habana > Cayo Sta. María: &nbsp;<big>$50</big></li>
                                <li>Cayo Guillermo > La Habana: &nbsp;<big>$65</big></li>
                            </ul>
                            <div class="small"><?php echo __d('/mobirise/home', 'También {0} y otros', 'Cienfuegos, Santa Clara, Playa Larga, Cayo Coco')?></div>
                            <hr/>
                            <div>
                                <a class="btn btn-block btn-success" href="#<?php echo __d('meta', 'rutas-y-precios')?>">
                                    <?php echo __d('/mobirise/home', 'Mira todas las rutas y precios')?>
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
                            <span class="mbr-iconfont mbri-cash"></span>
                        </div>

                        <div class="card-text">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/home', 'Ahorra dinero')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                                  <?= __d('/mobirise/home', 'Si viajas solo, en pareja o son tres personas y <strong>no quieren pagar el viaje completo en un taxi privado</strong> como si fueran cuatro personas.')?>
                            </big>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 align-center col-12 col-md-6 col-lg-3">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-pin"></span>
                        </div>
                        <div class="card-text">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/home', 'Puerta a puerta')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                                  <?= __d('/mobirise/home', 'El taxi <strong>te recoge en tu casa de estancia u hotel</strong> y <strong>te lleva hasta tu próxima estancia</strong>. No es necesario salir a buscar un taxi o atrapar tu bus yendo a la estación.')?>
                            </big>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 align-center col-12 col-md-6 col-lg-3">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-sun"></span>
                        </div>
                        <div class="card-text">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/home', 'Viaja rápido')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                              <?= __d('/mobirise/home', 'En un <strong>auto moderno con aire acondicionado</strong> y con <strong>sólo 4 pasajeros</strong> dentro, todos yendo al mismo destino y con reservación de antemano.')?>
                            </big>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card p-3 align-center col-12 col-md-6 col-lg-3">
                    <div class="panel-item p-3">
                        <div class="card-img pb-3">
                            <span class="mbr-iconfont mbri-image-slider"></span>
                        </div>

                        <div class="card-texts">
                            <h3 class="pt-3 pb-3 mbr-fonts-style display-5"><?= __d('/mobirise/home', 'Muchos destinos')?></h3>

                            <p class="mbr-content-text mbr-fonts-style display-7">
                            <big>
                                  <?= __d('/mobirise/home', 'Usa nuestra amplia red de taxis que conectan lugares favoritos como {0} y otros.', '<strong>La Habana</strong>, <strong>Viñales</strong>, <strong>Varadero</strong>, <strong>Trinidad</strong>, <strong>Cayo Guillermo</strong>, <strong>Cayo Santa María</strong>')?>
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
              <?= __d('/mobirise/home', 'Comenzar a reservar mis traslados')?></a></div>
            </div>
            <div class="media-container-column title col-12 col-lg-7 col-md-6">
                <h2 class="align-right mbr-bold mbr-white pb-3 mbr-fonts-style display-2">
                  <?= __d('/mobirise/home', 'La magia de compartir taxi y ahorrar dinero en tu viaje a Cuba')?></h2>
                <h3 class="mbr-section-subtitle align-right mbr-light mbr-white mbr-fonts-style display-5">
                    <?php echo __d('/mobirise/home', 'En un traslado de <b>La Habana a Trinidad</b> en que se pagarían <b>{0} - {1} a un taxi privado</b> -sin importar cuántas personas sean-<b> a 2 personas les costaría en PickoCar {2} en total ({3} por asiento)</b>, ahorrándose entre {4} y {5}.', '<big>$130</big>', '<big>$160</big>', '$70', '$35', '$60', '$90')?>
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
                  <?= __d('/mobirise/home', 'Estas son las rutas, precios y horarios de nuestros taxis en Cuba')?>
                    </h2>
                    <h3><?= __d('/mobirise/home', 'Reserva tus asientos en un taxi a tu destino:')?></h3>
                    <br/>
                    <div><?= __d('/mobirise/home', 'Cada taxi acomoda a <strong>{0} pasajeros</strong>', 4)?></div>
                    <div><?= __d('/mobirise/home', 'El taxi te recoge en tu estacia u hotel')?></div>
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



<section class="cid-rmpfxwRsqp" id="footer1-h">

    <div class="container">
        <div class="media-container-row content text-white">
            <div class="col-12 col-md-3">
                <div class="media-wrap">
                    <?= $this->Html->link('<img src="assets/images/logo43.png" alt="PickoCar">', ['_name'=>'homepage'], ['escape' => false]); ?>
                </div>
            </div>
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    <?= __d('shared_travels', 'Sobre Nosotros')?>
                </h5>
                <p class="mbr-text">
                    <?= __d('/mobirise/home', 'PickoCar es un <b>servicio de taxi en Cuba</b>, con excelentes precios y rutas que conectan muchos de los destinos mas importantes en la isla.')?>
                </p>
            </div>
            <!--<div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    Contacts
                </h5>
                <p class="mbr-text">
                    Email: support@mobirise.com
                    <br>Phone: +1 (0) 000 0000 001
                    <br>Fax: +1 (0) 000 0000 002
                </p>
            </div>-->
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    <?= __d('/mobirise/home', 'Enlaces')?>
                </h5>
                <p class="mbr-text">
                    <?php echo $this->Html->link(__d('shared_travels', 'Sobre Nosotros'), ['plugin'=>null, 'controller'=>'pages', 'action'=>'display', 'about'], ['class' => 'text-primary']); ?>
                    <br>
                    <?php echo $this->Html->link(__d('shared_travels', 'Contactar'), ['plugin'=>null, 'controller'=>'contact'], ['class' => 'text-primary']); ?>
                </p>
            </div>
        </div>
        <div class="footer-lower">
            <div class="media-container-row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
            <div class="media-container-row mbr-white">
                <div class="col-sm-6 copyright">
                    <p class="mbr-text mbr-fonts-style display-7">
                        © Copyright 2019 PickoCar
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="social-list align-right">
                        <!--<div class="soc-item">
                            <a href="https://twitter.com/mobirise" target="_blank">
                                <span class="socicon-twitter socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>-->
                        <div class="soc-item">
                            <a href="https://www.facebook.com/pickocar" target="_blank">
                                <span class="socicon-facebook socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                        <!--<div class="soc-item">
                            <a href="https://www.youtube.com/c/mobirise" target="_blank">
                                <span class="socicon-youtube socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                        <div class="soc-item">
                            <a href="https://instagram.com/mobirise" target="_blank">
                                <span class="socicon-instagram socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                        <div class="soc-item">
                            <a href="https://plus.google.com/u/0/+Mobirise" target="_blank">
                                <span class="socicon-googleplus socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>
                        <div class="soc-item">
                            <a href="https://www.behance.net/Mobirise" target="_blank">
                                <span class="socicon-behance socicon mbr-iconfont mbr-iconfont-social"></span>
                            </a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>