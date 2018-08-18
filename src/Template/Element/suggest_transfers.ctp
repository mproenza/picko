<?php
use App\Model\Entity\SharedTravel;

// Verificar si hay transfers desde el destino
$suggestTransfers = false;
foreach (SharedTravel::$modalities as $code=>$mod)
    if($mod['origin_id'] == $modality['destination_id'] && ( !isset($mod['active']) || $mod['active'] )) {
        $suggestTransfers = true; break;
    }
?>

<?php if($suggestTransfers):?>

<div class="card">
    <div class="card-body">
        <div class="card-title">
            <p class="center"><b><?php echo __d('shared_travels', 'SOLICITA OTROS TRANSFERS PARA EL RESTO DE TU VIAJE')?></b></p><hr/>
        </div>
        <ul class="list-unstyled">
            <?php foreach (SharedTravel::$modalities as $code=>$mod):?>
                <?php if($mod['origin_id'] == $modality['destination_id'] && ( !isset($mod['active']) || $mod['active'] )):?>
                    <li style="padding-top: 5px">
                        <?php echo $this->Html->link(__d('shared_travels', '{0} - {1}, {2}','<b>'.$mod['origin'].'</b>', '<b>'.$mod['destination'].'</b>', '<b>'.$mod['time'].'</b>'),
                        array('controller'=>'shared-rides', 'action'=>'book', $code),
                        array('data-modal'=>'info-'.$code, 'class'=>'open-request-form', 'style'=>'white-space: normal;color:inherit', 'escape'=>false))?>
                        <div style="display: none" id="info-<?php echo $code?>">
                            <?php echo $this->element('shared_travel_book_prompt', ['modality'=>$mod] + compact('code'))?>
                        </div>
                    </li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
        <hr/>
        <?php echo $this->Html->link(__d('shared_travels', 'VER OTRAS RUTAS DISPONIBLES'), array('_name'=>'homepage', '#'=>__d('meta', 'rutas-y-precios')), array('class'=>'btn btn-block btn-info'))?>
    </div>
</div>
<?php endif;?>
<?php
    echo $this->Html->css('datepicker');
    echo $this->Html->script('datepicker');
    echo $this->Html->script('datepicker-locale');
?>