<?php
use App\Model\Entity\SharedTravel;

$doBootbox = true;
if(!isset ($doBootbox)) $doBootbox = false;

$route = SharedTravel::_routeFull($route);
?>
<div class="card">
    <div class="card-body">
        <?php if(isset($route['new']) && $route['new']):?>
            <span class="badge badge-success"><?php echo __('NUEVO')?></span>
        <?php endif?>
        
        <h6 class="card-title">
            <?php echo __d('shared_travels', '{0} > {1}', '<span style="display:inline-block"><code>'.$route['origin'].'</code></span>', '<span style="display:inline-block"><code><big><big><big><b>'.$route['destination'].'</b></big></big></big></code></span>')?>
        </h6>
        
        <div><?php echo __d('shared_travels', 'Hora de recogida')?>: 
            <span class="inline-block">
                <?php $sep = ''?>
                <?php foreach ($route['departure_times_desc'] as $time):?>
                    <?php echo $sep?><code><big><big><?php echo $time?></big></big></code>
                    <?php $sep = ', '?>
                <?php endforeach;?>
            </span>
        </div>
        <br/>
        
        <div><?php echo __d('shared_travels', '{0} por persona', '<code><span class="fa-2x">'.$route['price_x_seat'].' cuc'.'</span></code>')?></div>
        <div><?php echo __d('shared_travels', '<span class="text-muted"><small>mejor que</small></span> <s>{0}</s> <span class="text-muted"><small>por taxi privado</small></span>', '<code><big>$'.(4*$route['price_x_seat']).'</big></code>')?></div>
        <br/>

        <?php if(!$doBootbox):?>
            <div><?php echo $this->Html->link(__d('shared_travels', '<big>Compartir este viaje</big> <div>y pagar sólo <b>{0}</b> por persona</div>', $route['price_x_seat']. ' cuc'), array('controller'=>'shared-rides', 'action'=>'book', $route['slug']), array('class'=>'btn btn-block btn-info', 'style'=>'white-space: normal;', 'escape'=>false))?></div>
        <?php else:?>
            <div>
                <?php echo $this->Html->link(__d('shared_travels', '<big>Reservar taxi <div><span class="inline-block">{0} - {1}</span></div></big> <div>y pagar sólo <b>{2}</b> por persona</div>', $route['origin'], $route['destination'], $route['price_x_seat']. ' cuc'), 
                        ['controller'=>'shared-rides', 'action'=>'book', $route['slug']], 
                        array('data-modal'=>'info-'.$route['slug'], 'class'=>'btn btn-block btn-info open-request-form', 'style'=>'white-space: normal;', 'escape'=>false))?>
            </div>
            <div style="display: none" id="info-<?php echo $route['slug']?>">
                <?php echo $this->element('shared_travel_book_prompt', compact('route'))?>
            </div>
        <?php endif;?>
            
        <?php $info = App\Model\Entity\SharedTravel::_routeInfo($route['origin_id'], $route['destination_id'])?>
        <?php if($info != null):?> 
            <br/>
            <div><small><i class="fa fa-road"></i> <?php echo $info['kms']?> kms | <?php echo $info['hrs']?> hrs</small></div>
        <?php endif;?>
    </div>
</div>

<?php 
if($doBootbox) {
    $this->Html->css('datepicker', ['block'=>'css_top']);
    $this->Html->script('datepicker', ['block'=>'script_bottom']);
    $this->Html->script('datepicker-locale', ['block'=>'script_bottom']);
}
?>