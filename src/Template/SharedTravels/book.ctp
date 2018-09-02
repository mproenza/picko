<?php 
use App\Model\Entity\SharedTravel;
?>

<div id="container">
    <div id="front-page-bg">
        <?php echo $this->element('menu', ['isHome'=>true])?>
            
        <div style="height: 100px;clear: both"></div>

        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 value-proposition">
                    <br/>
                    <h1 style="text-align: center">
                        <big><?php echo __d('shared_travels', 'Comparte un taxi de {0} a {1} y paga sólo ${2} por asiento', $route['origin'], $route['destination'], $route['price_x_seat'])?></big>
                    </h1>
                    <hr/>
                    <p class="lead"><b><?php echo __d('home', 'Sólo 4 pasajeros en un taxi')?> • <?php echo __d('home', 'Recogida en tu estancia u hotel')?> • <?php echo __d('home', 'Autos muy confortables')?></b></p>
                    <div class="scroll_icon_wrap" style="text-align: center">
                        <a href="#<?php echo __d('meta', 'reservar')?>" class="scroll_link">
                            <span class="scroll_icon"><i class="fa fa-angle-down fa-2x" style="color: #D33C44"></i></span>
                        </a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    
    <div id="<?php echo __d('meta', 'reservar')?>" style="height: 40px;clear: both"></div>
    
    <div class="container">
        
        <div class="row">
            
            <div class="col-md-12 pb-3">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb" style="background-color: inherit !important;">
                        <li class="breadcrumb-item"><?php echo $this->Html->link(__d('shared_travels', 'Todas las rutas'), ['_name'=>'homepage', '#'=>__d('meta', 'rutas-y-precios')]); ?></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= __d('shared_travels', 'Ruta {0} > {1}', $route['origin'], $route['destination'])?></li>
                    </ol>
                </nav>
            </div>
            
            <div class="col-md-3" style="padding: 30px;border-left: #efefef solid 1px;">
                <b><?php echo __d('shared_travels', 'INFO DE ESTE SERVICIO')?></b>
                <div><?php echo __d('shared_travels', 'Taxi compartido de {0} a {1}', $route['origin'], $route['destination'])?></div>
                <hr/>
                <div><div><b><?php echo __d('shared_travels', 'Precio por asiento')?>:</b></div> <div class="fa-2x"><?php echo $route['price_x_seat']?> cuc</div></div>
                <br/>
                <div><div><b><?php echo __d('shared_travels', 'Hora de recogida en estancia')?>:
                    </b></div> <div class="lead"><b>
                        <?php $sep = ''?>
                        <?php foreach ($route['departure_times_desc'] as $time):?>
                            <?php echo $sep.$time?>
                            <?php $sep = ' | '?>
                        <?php endforeach;?>
                    </b></div>
                </div>
                <br/>
                <?php $info = App\Model\Entity\SharedTravel::_routeInfo($route['origin_id'], $route['destination_id'])?>
                <div><div class="float-left"><b><?php echo __d('shared_travels', 'Distancia')?>:</b></div> <div class="float-right"><?php echo $info['kms']?> km</div></div>
                <div><div class="float-left"><b><?php echo __d('shared_travels', 'Tiempo de recorrido')?>:</b></div> <div class="float-right"><?php echo $info['hrs']?> hrs</div></div>
                
            </div>
            <div class="col-md-8 offset-md-1 card bg-light" style="padding: 30px">
                <?php echo $this->element('shared_travel_book_prompt', compact('route'))?>
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

<?php
$this->Html->css('datepicker', ['block'=>'css_top']);
$this->Html->script('datepicker', ['block'=>'script_bottom']);
$this->Html->script('datepicker-locale', ['block'=>'script_bottom']);
?>

<?php
$this->start('script_internal');
echo $this->element('js/shared_travels/book/script1');
$this->end();
?>