<?php
use App\Model\Entity\SharedTravel;

// Verificar si hay transfers desde el destino
$suggestTransfers = false;
foreach (SharedTravel::$routes as $r)
    if($r['origin_id'] == $route['destination_id'] && ( !isset($r['active']) || $r['active'] )) {
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
            <?php foreach (SharedTravel::$routes as $r):?>
                <?php if($r['origin_id'] == $route['destination_id'] && ( !isset($r['active']) || $r['active'] )):?>
                    <?php $r = SharedTravel::_routeFull($r)?>
                    <li style="padding-top: 5px">
                        <?php echo $this->Html->link(__d('shared_travels', '{0} > {1}','<b>'.$r['origin'].'</b>', '<b>'.$r['destination'].'</b>'),
                        array('controller'=>'shared-rides', 'action'=>'book', $r['slug']),
                        array('data-modal'=>'info-'.$r['slug'], 'class'=>'open-request-form', 'style'=>'white-space: normal;color:inherit', 'escape'=>false))?>
                        <div style="display: none" id="info-<?php echo $r['slug']?>">
                            <?php echo $this->element('shared_travel_book_prompt', ['route'=>$r])?>
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
    $this->Html->css('datepicker', ['block'=>'css_top']);
    $this->Html->script('datepicker', ['block'=>'script_bottom']);
    $this->Html->script('datepicker-locale', ['block'=>'script_bottom']);
?>