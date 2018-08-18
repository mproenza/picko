<?php
if(!isset ($doBootbox)) $doBootbox = false;
?>
<div class="card">
    <div class="card-body">
        <h6 class="card-title">
            <?php echo __d('shared_travels', '{0} > {1}', '<span style="display:inline-block"><code>'.$modality['origin'].'</code></span>', '<span style="display:inline-block"><code><big><big><big><b>'.$modality['destination'].'</b></big></big></big></code></span>')?>
        </h6>
        
        <div><?php echo __d('shared_travels', 'Hora de recogida {0}', '<code><big><big><big>'.$modality['time'].'</big></big></big></code>')?></div>
        <div><?php echo __d('shared_travels', '{0} por persona', '<code><big><big>'.$modality['price'].' cuc'.'</big></big></code>')?></div>
        <div><?php echo __d('shared_travels', '<span class="text-muted"><small>- mejor que</small></span> <s>{0}</s> <span class="text-muted"><small>por taxi privado -</small></span>', '<code><big><big>$'.(4*$modality['price']).'</big></big></code>')?></div>

        <br/>

        <?php if(!$doBootbox):?>
            <div><?php echo $this->Html->link(__d('shared_travels', '<big>Compartir este viaje</big> <div>y pagar sólo <b>{0}</b> por persona</div>', $modality['price']. ' cuc'), array('controller'=>'shared-rides', 'action'=>'book', '?'=>['s'=>$code.'#request-ride']), array('class'=>'btn btn-block btn-info', 'style'=>'white-space: normal;', 'escape'=>false))?></div>
        <?php else:?>
            <div>
                <?php echo $this->Html->link(__d('shared_travels', '<big>Compartir taxi <div><span class="inline-block">{0} - {1}</span></div></big> <div>y pagar sólo <b>{2}</b> por persona</div>', $modality['origin'], $modality['destination'], $modality['price']. ' cuc'), 
                        ['controller'=>'shared-rides', 'action'=>'book', $code], 
                        array('data-modal'=>'info-'.$code, 'class'=>'btn btn-block btn-info open-request-form', 'style'=>'white-space: normal;', 'escape'=>false))?>
            </div>
            <div style="display: none" id="info-<?php echo $code?>">
                <?php echo $this->element('shared_travel_book_prompt', compact('modality') + compact('code'))?>
            </div>
        <?php endif;?>
            
        <?php $info = App\Model\Entity\SharedTravel::_routeInfo($modality['origin_id'], $modality['destination_id'])?>
        <?php if($info != null):?> 
            <br/>
            <div class="text-muted"><small><i class="fa fa-road"></i> <?php echo $info['kms']?> kms | <?php echo $info['hrs']?> hrs</small></div>
        <?php endif;?>
    </div>
</div>