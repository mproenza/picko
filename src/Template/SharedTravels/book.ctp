<?= $this->element('mobirise/menu', ['isHome'=>true])?>

<section class="mbr-section content5 cid-rL8vfauSOA mbr-parallax-background" id="content5-3i">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center mbr-bold mbr-white pb-3 mbr-fonts-style display-2">
                    <br>
                    <?= __d('/mobirise/book', 'Taxi económico de {0} a {1}', '<br>'.$route['origin'], $route['destination'])?>
                    <br>
                    <?= __d('/mobirise/book', '{0} por asiento', '$'.$route['price_x_seat'])?>
                </h2>
                <h3 class="mbr-section-subtitle align-center mbr-light mbr-white pb-3 mbr-fonts-style display-5">
                    <?php echo __d('home', 'Sólo 4 pasajeros en un taxi')?> • <?php echo __d('home', 'Recogida en tu estancia u hotel')?> • <?php echo __d('home', 'Autos muy confortables')?>
                </h3>
                
                <div class="mbr-section-btn align-center"><a class="btn btn-success display-4" href="#<?= __('reservar')?>"><?= __d('/mobirise/book', 'RESERVAR TAXI COMPARTIDO')?></a></div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section contacts2 cid-rL8xSEDcUF" id="contacts2-3j">    
    <div class="container">
        <div class="row">
            <!--Titles-->
            <div class="title col-12">
                <h2 class="align-left mbr-fonts-style display-5">
                    <strong><?php echo __d('shared_travels', 'INFO DE ESTE SERVICIO')?>:</strong>
                    <br><br>
                    <?php echo __d('shared_travels', 'Taxi compartido de {0} a {1}', $route['origin'], $route['destination'])?>
                    <br><br>
                </h2>
                <h3 class="mbr-section-subtitle mbr-light mbr-fonts-style display-5">
                    <small>
                    <?= __d('/mobirise/book', 'Compartirás este taxi con otros pasajeros. El taxi acomoda a 4 pasajeros.')?> 
                    <br>
                    <?= __d('/mobirise/book', 'Ej. Si reservas 2 asientos, compartes el taxi con otros 2 pasajeros y ahorras 50% = {0}', 2*$route['price_x_seat'].' cuc')?> 
                    </small>
                </h3>
            </div>
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-4">
                        <div class="b b-adress">
                            <h5 class="align-left mbr-fonts-style m-0 display-5">
                                <?= __d('shared_travels', 'Precio por asiento')?>:</h5>
                            <p class="mbr-text align-left mbr-fonts-style display-5"><strong><?= $route['price_x_seat']?> cuc</strong></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="b b-phone">
                            <h5 class="align-left mbr-fonts-style m-0 display-5">
                                <?=  __d('/mobirise/book', 'Horarios disponibles')?>:</h5>
                            <p class="mbr-text align-left mbr-fonts-style display-5">
                                <?php $sep = ''?>
                                <?php foreach ($route['departure_times_desc'] as $time):?>
                                    <?= $sep.'<strong>'.$time.'</strong>'?>
                                    <?php $sep = ' | '?>
                                <?php endforeach;?>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="b b-mail">
                            <h5 class="align-left mbr-fonts-style m-0 display-5">
                                <?=  __d('/mobirise/book', 'Ruta')?>:
                            </h5>
                            <p class="mbr-text align-left mbr-fonts-style display-5">
                                <?php $info = App\Model\Entity\SharedTravel::_routeInfo($route['origin_id'], $route['destination_id'])?>
                                <strong><?= __d('shared_travels', 'Distancia')?>:</strong> <?php echo $info['kms']?> km
                                <br><strong><?=  __d('/mobirise/book', 'Tiempo')?>:</strong> <?php echo $info['hrs']?> hrs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section form1 cid-rL8z9XDEUV" id="<?= __('reservar')?>">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-10">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">
                    <?= __d('/mobirise/book', 'Reservar taxi')?></h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                    <?= __d('/mobirise/book', 'Reserva tus asientos para la fecha que desees {0} Nosotros coordinamos el traslado', '<strong>></strong>')?>
                </h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-10" data-form-type="formoid">
                <?= $this->element('form_shared_travel', compact('route'))?>
            </div>
        </div>
    </div>
</section>

<?= $this->element('/mobirise/footer')?>

<?php
$this->Html->css('datepicker', ['block'=>'css_top']);
$this->Html->script('datepicker', ['block'=>'script_bottom']);
$this->Html->script('datepicker-locale', ['block'=>'script_bottom']);
?>
<?php $this->append('script_internal', $this->element('js/shared_travels/book/script1'));?>