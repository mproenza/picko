<?php use Cake\Core\Configure;?>

<section class="cid-rmpfxwRsqp" id="footer1-h">

    <div class="container">
        <div class="media-container-row content text-white">
            <div class="col-12 col-md-3">
                <div class="media-wrap">
                    <?= $this->Html->link($this->Html->image('logo43.png', ['alt'=>'Logo PickoCar']), ['_name'=>'homepage'], ['escape' => false]); ?>
                </div>
            </div>
            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    <?= __d('shared_travels', 'Sobre Nosotros')?>
                </h5>
                <p class="mbr-text">
                    <?= __d('/mobirise/home', 'PickoCar es un <b>servicio de taxi en Cuba</b>, con excelentes precios y rutas que conectan muchos de los destinos mas importantes en la isla.')?>
                </p>
                <p class="mbr-text">
                    <?= __d('/mobirise/home', 'También somos los creadores de {0}', '<a href="https://yotellevocuba.com">YoTeLlevoCuba.com</a>')?>
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
                    <br>
                    <?php echo $this->Html->link(__d('shared_travels', 'Flota'), ['plugin'=>null, 'controller'=>'pages', 'action'=>'display', 'taxi-fleet'], ['class' => 'text-primary']); ?>
                </p>
            </div>

            <div class="col-12 col-md-3 mbr-fonts-style display-7">
                <h5 class="pb-3">
                    <?= __d('/mobirise/home', 'Contacto')?>
                </h5>
                <p class="mbr-text">
                    <i class="fa fa-whatsapp"></i> WhatsApp:
                    </br>
                    <big><?= Configure::read('whatsapp_contact_number')[ini_get('intl.default_locale')]?></big>
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