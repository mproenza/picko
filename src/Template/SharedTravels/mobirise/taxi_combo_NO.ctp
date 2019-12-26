<?php use App\Model\Entity\SharedTravel;?>

<?php
$route1 = SharedTravel::_routeFull(
        SharedTravel::_routeFromOriginDestination(
                $combo['route1']['origin_id'], 
                $combo['route1']['destination_id']));

$route2 = SharedTravel::_routeFull(
        SharedTravel::_routeFromOriginDestination(
                $combo['route2']['origin_id'], 
                $combo['route2']['destination_id']));

$peopleCount = 2;
$priceRoute1 = $route1['price_x_seat']*$peopleCount;
$priceRoute2 = $route2['price_x_seat']*$peopleCount;
$totalPriceCombo = $priceRoute1 + $priceRoute2;
?>


<?= $this->element('/mobirise/menu', ['isHome'=>true])?>

<section class="cid-rLoPVsPKTH mbr-fullscreen mbr-parallax-background" id="header2-3o">

    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);"></div>

    <div class="container align-center">
        <div class="row justify-content-md-center">
            <div class="mbr-white col-md-10">
                <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-2">
                    <br>
                    <span class="text-uppercase"><?= __d('/mobirise/combos', 'Traslado económico de {0} a {1}', '<br>'.$route1['origin'], $route2['destination'])?></span>
                    <br>
                    via <?= $route1['destination']?>
                </h1>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                    <strong><?= __d('/mobirise/combos', 'Precio: {0} total para {1} pasajeros', $totalPriceCombo, 2)?></strong>
                    <br>
                    <strong><?= __d('/mobirise/combos', 'Traslados en taxi colectivo')?></strong>
                </h3>
                <p class="mbr-text pb-3 mbr-fonts-style display-5">
                    &gt; <?= __d('/mobirise/combos', 'Salida {0} de {1} hacia {2}', $route1['departure_times_desc_string'], $route1['origin'], $route1['destination'])?>
                    <br>
                    &gt; <?= __d('/mobirise/combos', 'Haces estancia en {0} una noche', $route1['destination'])?>
                    <br>
                    &gt; <?= __d('/mobirise/combos', 'Continúas a {0} al próximo día saliendo {1}', $route2['destination'], $route2['departure_times_desc_string'])?>
                    <br><br>
                </p>
                <div class="mbr-section-btn">
                    <a class="btn btn-md btn-success display-4" href="#<?= __('reservar')?>">
                        <?= __d('/mobirise/combos', 'RESERVAR TRASLADO ECONÓMICO')?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="mbr-arrow hidden-sm-down" aria-hidden="true">
        <a href="#next">
            <i class="mbri-down mbr-iconfont"></i>
        </a>
    </div>
</section>

<section class="mbr-section content4 cid-rLoRKj4DVf" id="content4-3t">
    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center pb-3 mbr-fonts-style display-5">
                    <?= __d('/mobirise/combos', '¿Por qué hacer estancia en {0}?', $route1['destination'])?> <?= __d('/mobirise/combos', '¿Por qué no ir directo a {0}?', $route2['destination'])?></h2>
                <div class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-5">
                    <p><?= __d('/mobirise/combos', 'Si llevas un tiempo investigando para tu viaje a Cuba, debes haber notado que ir directo de {0} a {1} no es muy fácil lograrlo de manera económica.', $route1['origin'], $route2['destination'])?>
                    </p>
                    <p><?= __d('/mobirise/combos', 'Hay pocas opciones:')?></p>
                    <ul>
                        <li><?= __d('/mobirise/combos', 'Un taxi privado cuesta {0} como mínimo. Esta alternativa NO es económica.', '$'.$combo['private_taxi_price'])?></li>
                        <li><?= __d('/mobirise/combos', 'Puedes ir en {6} hasta {0} (cada asiento cuesta {1}), y luego tomar un taxi privado por {2} desde ahí. Esta alternativa es económica, pero el bus demora en llegar y el horario más temprano de arribo a {0} es {3}. Luego hay que seguir a {4} por {5} más, y además tienes que gestionar la combinación con un taxi privado.', 
                                $combo['viazul']['destination'], 
                                '$'.$combo['viazul']['price_x_seat'],
                                '$'.$combo['viazul']['private_taxi_price_to_final_destination'],
                                $combo['viazul']['earlier_arrival_time'],
                                $route2['destination'],
                                $combo['viazul']['private_taxi_ride_time'],
                                __('bus Viazul'))?></li>
                    </ul> 
                    <p><?= __d('/mobirise/combos', 'En PickoCar proponemos una alternativa diferente para hacerlo económico:')?>
                    </p>
                    <p><?= __d('/mobirise/combos', '<strong>Combinar 2 traslados en taxi colectivo</strong>: uno de <b>{0} a {1}</b> y otro de <b>{1} a {2}</b>. Esta opción tiene el inconveniente de que NO se puede hacer el mismo día, pero resulta económico y {1} es uno de los destinos más atractivos de la isla.', $route1['origin'], $route1['destination'], $route2['destination'])?>
                    </p>
                    <p><?= __d('/mobirise/combos', 'Lo haríamos de la siguiente manera:')?></p>
                    </div>
                
            </div>
        </div>
    </div>
</section>

<section class="services5 cid-rLoPVxA4A6" id="services5-3p">
    <!---->
    
    <!---->
    <!--Overlay-->
    
    <!--Container-->
    <div class="container">
        <div class="row">
            <!--Titles-->
            <div class="title pb-5 col-12">
                
                
            </div>
            <!--Card-1-->
            <div class="card px-3 col-12">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="top-line pb-3">
                            <h4 class="card-title mbr-fonts-style display-5"><?= __d('/mobirise/combos', 'Taxi {0} > {1} con salida {2}', $route1['origin'], $route1['destination'], $route1['departure_times_desc_string'])?></h4>
                            <p class="mbr-text cost mbr-fonts-style m-0 display-5"><strong>
                                $<?= $priceRoute1?></strong><strong><br></strong><br></p>
                        </div>
                        <div class="bottom-line">
                            <p class="mbr-text mbr-fonts-style m-0 b-descr display-7">
                                <?= __d('/mobirise/combos', 'Recogida en <strong>taxi colectivo</strong> en tu estancia u hotel en {0}.', $route1['origin'])?>
                                <strong><?= __d('/mobirise/combos', 'Compartirás el taxi con otros {0} pasajeros.', 2)?></strong>
                                <br>
                                <strong><?= __d('/mobirise/combos', 'Precio: {0} por asiento', '$'.$route1['price_x_seat'])?></strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!--Card-2-->
            <div class="card px-3 col-12">
                <div class="card-wrapper media-container-row media-container-row">
                    <div class="card-box">
                        <div class="top-line pb-3">
                            <h4 class="card-title mbr-fonts-style display-5"><?= __d('/mobirise/combos', 'Taxi {0} > {1} con salida {2} al siguiente día', $route2['origin'], $route2['destination'], $route2['departure_times_desc_string'])?></h4>
                            <p class="mbr-text cost mbr-fonts-style m-0 display-5"><strong>
                                $<?= $priceRoute2?></strong></p>
                        </div>
                        <div class="bottom-line">
                            <p class="mbr-text mbr-fonts-style m-0 b-descr display-7">
                                <?= __d('/mobirise/combos', 'Recogida en <strong>taxi colectivo</strong> en tu estancia u hotel en {0}.', $route2['origin'])?>
                                <strong><?= __d('/mobirise/combos', 'Compartirás el taxi con otros {0} pasajeros.', 2)?></strong>
                                <br>
                                <strong><?= __d('/mobirise/combos', 'Precio: {0} por asiento', '$'.$route2['price_x_seat'])?></strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="mbr-section form1 cid-rLoPVJnm1l" id="<?= __('reservar')?>">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">
                    <?= __d('/mobirise/combos', 'Reserva taxi de {0} a {1}', '<br>'.$route1['origin'], $route2['destination'])?>
                </h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                    <?= __d('/mobirise/combos', 'Combina 2 traslados en taxi colectivo para hacerlo de manera ECONÓMICA')?>
                </h3>
                <p>
                    <strong>* <?= __d('/mobirise/combos', 'Estas reservaciones sólo están disponibles para {0} personas', 2)?></strong>
                    <br>
                    <strong>* <?= __d('/mobirise/combos', 'El precio total es {0}', $totalPriceCombo.' cuc')?></strong>
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-8" data-form-type="formoid">
                <?= $this->element('combos/form_booking_combo_different_dates', ['route1'=>$route1, 'route2'=>$route2]);?>
            </div>
        </div>
    </div>
</section>

<!--<section class="accordion2 cid-rLoPVMOdvl" id="accordion2-3s">
    
    <div class="container">
        <div class="media-container-row pt-5">
            <div class="accordion-content">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">Sugerencias para tu estancia en Trinidad</h2>
                
                <div id="bootstrap-accordion_55" class="panel-group accordionStyles accordion pt-5 mt-3" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <a role="button" class="collapsed panel-title text-black" data-toggle="collapse" data-core="" href="#collapse1_55" aria-expanded="false" aria-controls="collapse1">
                                    <h4 class="mbr-fonts-style display-5">¿Qué hacer?</h4>
                                </a>
                            </div>
                            <div id="collapse1_55" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#bootstrap-accordion_55">
                                <div class="panel-body p-4">
                                    <p class="mbr-fonts-style panel-text display-7">A Cienfuegos llegarás sobre las 12 del mediodía, por lo que seguro deberás comer algo. Nuestra sugerencia es:
<br>
<br><strong>Evita emplear 1 hora o más haciendo un almuerzo en un restaurante.
</strong><br>
<br>En el mismo centro histórico (Boulevard de Cienfuegos) hay múltiples ofertas locales; hay locales de pizzas, pastas, sandwiches y bebidas . Muchas ofertas son en CUP (Pesos Cubanos, NO CUC), que salen más baratas.
<br>
<br>Usar estas opciones locales de cafetería te dará más tiempo para disfrutar Cienfuegos y te será mucho más económico.</p>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="mbr-figure" style="width: 105%;">
                    <img src="assets/images/palacio-del-valle-cienfuegos-640x442.jpg" alt="Mobirise" title="">
            </div>
        </div>
    </div>
</section>-->

<section class="cid-rLp5fSgo9R" id="social-buttons1-3u">

    <div class="container">
        <div class="media-container-row">
            <div class="col-md-8 align-center">
                <h2 class="pb-3 mbr-section-title mbr-fonts-style display-7">
                    MAYBE A FRIEND WANTS TO SAVE MONEY AND DO THIS? SHARE THIS PAGE WITH THEM AND MAKE THEIR DAY!</h2>
                <div>
                    <div class="mbr-social-likes" data-counters="false">
                        <span class="btn btn-social facebook mx-2" title="Share link on Facebook">
                            <i class="socicon socicon-facebook"></i>
                        </span>
                        <span class="btn btn-social twitter mx-2" title="Share link on Twitter">
                            <i class="socicon socicon-twitter"></i>
                        </span>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->element('//mobirise/footer')?>