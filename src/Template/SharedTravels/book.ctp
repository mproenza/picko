<?php 
use App\Model\Entity\SharedTravel;
use Cake\I18n\I18n;

$modalityCode =  $this->request->getParam('pass')[0];
$modality = SharedTravel::$modalities[$modalityCode];
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
                        <big><?php echo __d('shared_travels', 'Comparte un taxi de {0} a {1} y paga sólo ${2} por asiento', $modality['origin'], $modality['destination'], $modality['price'])?></big>
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
            <div class="col-md-3 card" style="padding: 30px">
                <b><?php echo __d('shared_travels', 'INFO DE ESTE SERVICIO')?></b>
                <div><?php echo __d('shared_travels', 'Taxi compartido de {0} a {1}', $modality['origin'], $modality['destination'])?></div>
                <hr/>
                <div><div><b><?php echo __d('shared_travels', 'Precio por asiento')?>:</b></div> <div class="fa-2x"><?php echo $modality['price']?> cuc</div></div>
                <br/>
                <div><div><b><?php echo __d('shared_travels', 'Hora de recogida en estancia')?>:</b></div> <div class="lead"><b><?php echo $modality['time']?></b></div></div>
                <br/>
                <?php $info = App\Model\Entity\SharedTravel::_routeInfo($modality['origin_id'], $modality['destination_id'])?>
                <div><div class="float-left"><b><?php echo __d('shared_travels', 'Distancia')?>:</b></div> <div class="float-right"><?php echo $info['kms']?> km</div></div>
                <div><div class="float-left"><b><?php echo __d('shared_travels', 'Tiempo de recorrido')?>:</b></div> <div class="float-right"><?php echo $info['hrs']?> hrs</div></div>
                
            </div>
            <div class="col-md-8 offset-md-1 card bg-light" style="padding: 30px">
                <?php echo $this->element('shared_travel_book_prompt', compact('modality') + ['code'=>$modalityCode])?>
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
echo $this->Html->css('datepicker');
echo $this->Html->script('datepicker');
echo $this->Html->script('datepicker-locale');
?>

<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: '<?php echo I18n::getLocale()?>',
        startDate: '+2d',
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: false
    });
    
    var form = $('form');
    form.submit(function(event) {
        if (this.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.classList.add('was-validated');
    });
</script>