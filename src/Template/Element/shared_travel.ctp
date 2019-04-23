<?php 
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;

if(!isset($fromEmail)) $fromEmail = false;
if(!isset($showEmail)) $showEmail = true;
if(!isset($showDetails)) $showDetails = false;
if(!isset($admin)) $admin = false;
?>

<div class="row">
    
    <?php if($fromEmail):?><hr/><?php endif?>
    
    <div class="col-md-6">
        <p><b><?php echo __d('shared_travels', 'DATOS DEL TRANSFER')?></b></p><hr/>
        <?php $st = SharedTravel::getStateDesc($request['SharedTravel']['state'])?>
        <p><span class="text-muted"><b><?php echo __d('shared_travels', 'Estado')?>:</b></span> <big><abbr class="info" title="<?php echo $st['description']?>" style="text-decoration: none"><span class="<?php echo $st['class']?>"><?php echo $st['title'] ?></span></abbr></big></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Ruta')?>:</span> <code><big><?php echo $request['SharedTravel']['origin']?></big></code> > <code><big><?php echo $request['SharedTravel']['destination']?></big></code></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Fecha')?>:</span> <?php echo  TimeUtil::prettyDate($request['SharedTravel']['date'], false)?></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Hora de recogida')?>:</span> <?php echo $request['SharedTravel']['departure_time_desc']?></p>
        
        <!--<p><span class="text-muted"><?php echo __d('shared_travels', 'Referencia')?>:</span> <code><big><?php echo $request['SharedTravel']['modality_code'].$request['SharedTravel']['id']?></big></code></p>-->
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Cantidad de personas')?>:</span> <?php echo $request['SharedTravel']['people_count']?></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Lugar de recogida en {0}', $request['SharedTravel']['origin'])?>:</span> <div><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_origin'])?></div></p>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Lugar de destino en {0}', $request['SharedTravel']['destination'])?>:</span> <div><?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $request['SharedTravel']['address_destination'])?></div></p>
    </div>
    
    <?php if($fromEmail):?><hr/><?php endif?>
    
    <div class="col-md-6">
        <p><b><?php echo __d('shared_travels', 'DATOS DE CONTACTO')?></b></p><hr/>
        <p><span class="text-muted"><?php echo __d('shared_travels', 'Nombre')?>:</span> <?php echo $request['SharedTravel']['name_id']?></p>
        <?php if($showEmail):?><p><span class="text-muted"><?php echo __d('shared_travels', 'Correo')?>:</span> <?php echo $request['SharedTravel']['email']?></p><?php endif?>
        
        <?php if($request['SharedTravel']['contacts'] != null):?>
            <p><span class="text-muted"><?php echo __d('shared_travels', 'Contactos')?>:</span> <?php echo $request['SharedTravel']['contacts']?></p>
        <?php endif?>
        
        <hr/>
        <p><b><?php echo __d('shared_travels', 'DATOS DEL PAGO')?></b></p><hr/>
        
        <?php if($request['SharedTravel']['fee_total'] > 0):?>
            <p><span class="text-muted"><?php echo __d('shared_travels', 'Recargo')?>:</span> <code><big><b><?= $request['SharedTravel']['fee_total']?> cuc</b></big></code></p>
        <?php endif?>
            
        <?php if($request['SharedTravel']['discount_total'] > 0):?>
            <p><span class="text-muted"><?php echo __d('shared_travels', 'Descuento')?>:</span> <code><big><b><?= $request['SharedTravel']['discount_total']?> cuc</b></big></code></p>
        <?php endif?>
            
        <div>
            <span class="text-muted">
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
            </span> = <code><big><big><b><?= $total?> cuc</b></big></big></code>
        </div>
            
        <?php if($showDetails):?>
            <hr/>
            <p><span class="text-muted">IP:</span> <?php echo $request['SharedTravel']['from_ip']?></p>
            <p>
                <?php echo TimeUtil::prettyDate($request['SharedTravel']['created'], false)?>
                <?php 
                $time = new \Cake\I18n\Time($request['SharedTravel']['created']);
                echo $time->timeAgoInWords([
                    //'format' => ['month'=>'month'],
                    'accuracy' => ['month'=>'month', 'day'=>'day'],
                    'end' => '1 year'
                    ]);
                ?>
            </p>
            <p><span class="text-muted"><?php echo __d('shared_travels', 'Idioma')?>:</span> <?php echo $request['SharedTravel']['lang']?></p>
            <p><span class="text-muted">#</span><big><?php echo $request['SharedTravel']['id']?></big>
                <?php echo $this->Html->link('Permalink', array('controller'=>'shared-rides', 'action' => 'view', $request['SharedTravel']['id_token']))?>
                <?php if($admin):?>
                    | <?php echo $this->Html->link('admin', array('controller'=>'shared-rides', 'action' => 'admin', $request['SharedTravel']['id']))?>
                <?php endif?>
            </p>
        <?php endif?>
    </div>
</div>