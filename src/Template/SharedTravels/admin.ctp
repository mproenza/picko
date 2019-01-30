<?php
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php echo __d('shared_travels', 'Transfer desde {0} hasta {1} el {2}', '<code><big>'.$request['SharedTravel']['origin'].'</big></code>', '<code><big>'.$request['SharedTravel']['destination'].'</big></code>', '<code><big>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</big></code>')?>
            <hr/>
        </div>
        <div class="col-md-8 offset-md-2">
            <?php echo $this->element('shared_travel', compact('request') + array('showDetails'=>true))?>
            
            <hr/>
            <div><?php echo $this->Html->link(
                    'Cancelar', 
                    array('controller'=>'shared-rides', 'action'=>'cancel/'.$request['SharedTravel']['id_token']),
                    array('class'=>'btn btn-danger', 'confirm'=>'¿Está seguro que quiere cancelar esta solicitud?'))?></div>
            <br/>
            <div>
                <b>Código Activación:</b> <?php echo $request['SharedTravel']['activation_token']?>:
                <?php echo $this->Html->link(
                    'Activar', 
                    ['controller'=>'shared-rides', 'action'=>'activate/'.$request['SharedTravel']['activation_token']],
                    ['confirm'=>'¿Está seguro que quiere activar esta solicitud?', 'target'=>'_blank'])?>
            </div>
            <br/>
            <?php $fechaCambiada = $request['SharedTravel']['original_date'] != $request['SharedTravel']['date']?>
            <div class="alert alert-success" style="display: inline-block;">
                <b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'])?></b>
                <?php if($fechaCambiada):?><span class="badge badge-secondary"><b>Fecha original: <?php echo TimeUtil::prettyDate($request['SharedTravel']['original_date'])?></b></span><?php endif?>
                <?php echo $this->element('form_shared_travel_date_controls', ['request'=>$request])?>
            </div>
            
            <!-- FINAL STATE -->
            <div>
                <?php $states = App\Model\Entity\SharedTravel::$finalStates;?>
                <?php
                if($request['SharedTravel']['final_state'] != null) {
                    echo $states[$request['SharedTravel']['final_state']];
                }
                ?>
                
                <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'setFinalState/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?php
                    
                    echo $this->Form->control('final_state', ['options' => $states, 'label'=>false]);
                    ?>
                    <br/>
                    <?php echo $this->Form->submit('Actualizar Estado Final')?>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
            
        </div>
    </div>
</div>