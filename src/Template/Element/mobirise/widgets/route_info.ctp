<?php
use App\Model\Entity\SharedTravel;

$doBootbox = true;
if(!isset ($doBootbox)) $doBootbox = false;

$route = SharedTravel::_routeFull($route);
?>
<div class="plan-header text-center pt-5">
    <?php if(isset($route['new']) && $route['new']):?>
        <span class="badge badge-success align-left"><?= __d('/mobirise/default', 'NUEVA')?></span>
    <?php endif?>
    <h3 class="plan-title mbr-fonts-style display-5">
        <?= $route['origin'].' - '. '<b>'.$route['destination'].'</b>'?>
    </h3>
    <div class="plan-price">
        <span class="price-value mbr-fonts-style display-5">$</span>
        <span class="price-figure mbr-fonts-style display-2">
              <?= $route['price_x_seat']?></span>
        <small class="price-term mbr-fonts-style display-7"><strong>CUC</strong>
            <?= __d('/mobirise/shared_travels', 'por asiento')?>
        </small>
    </div>
</div>
<div class="plan-body pb-5" style="padding-bottom: 10px !important">
    <div class="plan-list align-center">
        <ul class="list-group list-group-flush mbr-fonts-style display-7">
            <li class="list-group-item"><span style="font-size: 1rem;">
                <br><?= __d('/mobirise/shared_travels', 'Hora de recogida')?></span>
            </li>
            <li class="list-group-item">
                <?php $sep = ''?>
                <?php foreach ($route['departure_times_desc'] as $time):?>
                    <?= $sep?><strong><big><?= $time?></big></strong>
                    <?php $sep = ' / '?>
                <?php endforeach;?>
            </li>
        </ul>
    </div>
    
    <div class="mbr-section-btn text-center pt-4">
        <?= $this->Html->link(__d('/mobirise/shared_travels', 'Reservar taxi de {0} a {1}', $route['origin'], $route['destination']), 
        ['controller'=>'shared-rides', 'action'=>'book', $route['slug']], 
        array('data-open-form'=>'form-'.$route['slug'], 'class'=>'btn btn-primary display-4 open-request-form'))?>
    </div>
    
    <?php $info = App\Model\Entity\SharedTravel::_routeInfo($route['origin_id'], $route['destination_id'])?>
    <?php if($info != null):?>
            <br/>
            <div class="text-center">
                <small><i class="fa fa-road"></i> <?php echo $info['kms']?> kms | <?php echo $info['hrs']?> hrs</small>
            </div>
    <?php endif;?>
</div>

<?php
$this->Html->css('datepicker', ['block'=>'css_top']);
$this->Html->script('datepicker', ['block'=>'script_bottom']);
$this->Html->script('datepicker-locale', ['block'=>'script_bottom']);
?>