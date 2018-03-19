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

<p style="text-align: center"><b><?php echo __d('shared_travels', 'SOLICITA OTROS TRANSFERS PARA EL RESTO DE TU VIAJE')?></b></p><hr/>
<ul class="list-unstyled">
    <?php foreach (SharedTravel::$modalities as $code=>$mod):?>
        <?php if($mod['origin_id'] == $modality['destination_id'] && ( !isset($mod['active']) || $mod['active'] )):?>
            <li style="padding-top: 5px">
                <?php echo $this->Html->link(__d('shared_travels', '{0} - {1}, {2}','<b>'.$mod['origin'].'</b>', '<b>'.$mod['destination'].'</b>', '<b>'.$mod['time'].'</b>'), 
                array('controller'=>'shared-rides', 'action'=>'create', '?'=>['s'=>$code], '#'=>'request-ride'), 
                array('data-modal'=>'info-'.$code, 'data-title'=>__d('shared_travels', 'Solicita un transfer de {0} a {1}', '<code><big>'.$mod['origin'].'</big></code>','<code><big>'.$mod['destination'].'</big></code>'), 'class'=>'open-request-form', 'style'=>'white-space: normal;color:inherit', 'escape'=>false))?>
                <?php //echo $this->Html->link(__d('shared_travels', '{0} - {1}, {2}','<b>'.$mod['origin'].'</b>', '<b>'.$mod['destination'].'</b>', '<b>'.$mod['time'].'</b>'), array('action'=>'create', '?'=>['s'=>$code]), array('escape'=>false, 'style'=>'color:inherit'))?>
                <div style="display: none" id="info-<?php echo $code?>">
                    <?php echo $this->element('shared_travel_book_bootbox', ['modality'=>$mod] + compact('code'))?>
                </div>
            </li>
        <?php endif;?>
    <?php endforeach;?>
</ul>
<hr/>
<?php echo $this->Html->link(__d('shared_travels', 'VER RUTAS DISPONIBLES'), array('_name'=>'homepage', '#'=>'transfers-available'), array('class'=>'btn btn-block btn-info'))?>
<?php endif;?>
<?php
    echo $this->Html->css('datepicker');
    echo $this->Html->script('datepicker');
    echo $this->Html->script('datepicker-locale');
?>