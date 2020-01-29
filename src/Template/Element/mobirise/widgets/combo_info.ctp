<?php
use App\Model\Entity\SharedTravel;

$doBootbox = true;
if(!isset ($doBootbox)) $doBootbox = false;

$peopleCount = 2;
$priceRoute1 = $route1['price_x_seat']*$peopleCount;
$priceRoute2 = $route2['price_x_seat']*$peopleCount;
$totalPriceCombo = $priceRoute1 + $priceRoute2;
?>
<div class="plan-header text-center pt-5">
    <h3 class="plan-title mbr-fonts-style display-5">
        <?= $route1['origin'].' - '. '<b>'.$route2['destination'].'</b>'?>
        <br>
        <small>via <?= $route1['destination']?></small>
    </h3>
    <span class="badge badge-warning align-left"><?= __d('/mobirise/combos', 'Combina 2 traslados')?></span>
        
    <div class="plan-price">
        <span class="price-value mbr-fonts-style display-5">$</span>
        <span class="price-figure mbr-fonts-style display-2">
              <?= $totalPriceCombo / $peopleCount ?></span>
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
                <?php foreach ($route1['departure_times_desc'] as $time):?>
                    <?= $sep?><strong><big><?= $time?></big></strong>
                    <?php $sep = ' / '?>
                <?php endforeach;?>
            </li>
        </ul>
    </div>
    
    <div class="mbr-section-btn text-center pt-4">
        <?= $this->Html->link(__d('/mobirise/combos', 'Ver detalles de taxi {0}'.'<br/>via '.$route1['destination'], '<br>'.$route1['origin'].' - '.$route2['destination']), 
        ['controller' => 'Pages', 'action' => 'display', 'taxi-combo', $comboSlug],
        ['class'=>'btn btn-primary display-4', 'escape'=>false, 'target'=>'_blank'])?>
    </div>
</div>

<?php
$this->Html->css('datepicker', ['block'=>'css_top']);
$this->Html->script('datepicker', ['block'=>'script_bottom']);
$this->Html->script('datepicker-locale', ['block'=>'script_bottom']);
?>