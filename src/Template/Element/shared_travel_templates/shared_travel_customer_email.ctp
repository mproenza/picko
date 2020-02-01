<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
?>
<div style="margin-bottom: 10px">PickoCar #<b><?php echo $request['SharedTravel']['id']?></b></div>
<div style="margin-bottom: 10px">
    <b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></b>
    <br/>
    <b><?php echo $request['SharedTravel']['origin']?></b> - <b><?php echo $request['SharedTravel']['destination']?></b> | <b><?php echo $request['SharedTravel']['departure_time_desc']?></b>
    <br/>
    <b><?php echo $request['SharedTravel']['people_count']?> pax</b>: <?php echo $request['SharedTravel']['name_id']?>
</div>
<?php if($request['SharedTravel']['contacts'] != null):?>
    <div style="margin-bottom: 10px"><?= __d('shared_travels', 'Contactos')?>: <b><?php echo $request['SharedTravel']['contacts']?></b></div>
<?php endif?>
<div style="margin-bottom: 10px"><?= __d('shared_travels', 'Lugar de recogida en {0}', $request['SharedTravel']['origin'])?>: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_origin'])?></div>
<div style="margin-bottom: 10px"><?= __d('shared_travels', 'Lugar de destino en {0}', $request['SharedTravel']['destination'])?>: <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_destination'])?></div>

<div><b><?= __d('shared_travels', 'DATOS DEL PAGO')?></b></div>
<div>
    
    <?php if($request['SharedTravel']['fee_total'] > 0):?>
            <div><?php echo __d('shared_travels', 'Recargo')?>: <b><?= $request['SharedTravel']['fee_total']?> cuc</b></div>
    <?php endif?>

    <?php if($request['SharedTravel']['discount_total'] > 0):?>
        <div><?php echo __d('shared_travels', 'Descuento')?>: <b><?= $request['SharedTravel']['discount_total']?> cuc</b></div>
    <?php endif?>

    <div>
        <?php $total = $request['SharedTravel']['people_count'] * $request['SharedTravel']['price_x_seat']?>
        
            <?= __d('shared_travels', 'Precio <b>{0} personas</b> x <b>{1}</b>', $request['SharedTravel']['people_count'], $request['SharedTravel']['price_x_seat'])?>

            <?php if($request['SharedTravel']['fee_total'] > 0) {
                $total += $request['SharedTravel']['fee_total'];
                echo '+ <b>'.$request['SharedTravel']['fee_total'].'</b>';
            }
            ?>
            <?php if($request['SharedTravel']['discount_total'] > 0) {
                $total -= $request['SharedTravel']['discount_total'];
                echo '- <b>'.$request['SharedTravel']['discount_total'].'</b>';
            }
            ?>
        = <b><?= $total?> cuc</b>
    </div>
        
</div>