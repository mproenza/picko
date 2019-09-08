<?php
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php 
            echo $this->element('shared_travel_templates/shared_travel_admin_mini', compact('request') + ['showDetails'=>true]);
            //echo $this->element('shared_travel', compact('request') + array('showDetails'=>true))
            ?>
        <hr/>
        </div>
        
        <div class="col-md-6">
            <div><?php echo $this->Html->link(
                    'Activar', 
                    ['controller'=>'shared-rides', 'action'=>'activate', $request['SharedTravel']['activation_token']],
                    ['class'=>'btn btn-info', 'confirm'=>'¿Está seguro que quiere ACTIVAR esta solicitud?'])?></div>
            <br/>
            <div><?php echo $this->Html->link(
                    'Confirmar', 
                    array('controller'=>'shared-rides', 'action'=>'confirm', $request['SharedTravel']['id_token']),
                    array('class'=>'btn btn-primary', 'confirm'=>'¿Está seguro que quiere ConFIRMAR esta solicitud?'))?></div>
            <br/>
            <div><?php echo $this->Html->link(
                    'Cancelar', 
                    array('controller'=>'shared-rides', 'action'=>'cancel', $request['SharedTravel']['id_token']),
                    array('class'=>'btn btn-danger', 'confirm'=>'¿Está seguro que quiere CAnCELAR esta solicitud?'))?></div>
            <br/>
            <br/>
            <?php $fechaCambiada = $request['SharedTravel']['original_date'] != $request['SharedTravel']['date']?>
            <div class="alert alert-success" style="display: inline-block;">
                <b><?php echo TimeUtil::prettyDate($request['SharedTravel']['date'])?></b>
                <?php if($fechaCambiada):?><span class="badge badge-secondary"><b>Fecha original: <?php echo TimeUtil::prettyDate($request['SharedTravel']['original_date'])?></b></span><?php endif?>
                <?php echo $this->element('form_shared_travel_date_controls', ['request'=>$request])?>
            </div>
            
            <!-- EDIT PICKUP ADDRESS -->
            <br/>
            <br/>
            <div>
                <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changePickupAddress/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <div class="form-group required">
                        <label for="AddressOrigin">Nueva dirección de recogida</label>
                        <textarea name="address_origin" class="form-control" value="<?= $request['SharedTravel']['address_origin']?>" rows="2" id="AddressOrigin" required="required"><?= trim($request['SharedTravel']['address_origin']) ?></textarea>
                        <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de recogida es obligatoria')?></div>
                    </div>
                    <?php echo $this->Form->submit('Actualizar Dirección Recogida')?>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
            
            <!-- EDIT DROPOFF ADDRESS -->
            <br/>
            <br/>
            <div>
                <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeDropoffAddress/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <div class="form-group required">
                        <label for="AddressDestination">Nueva dirección de destino</label>
                        <textarea name="address_destination" class="form-control" value="<?= $request['SharedTravel']['address_destination']?>" placeholder="Dirección de la casa o nombre del hotel" rows="2" id="AddressDestination" required="required"><?= $request['SharedTravel']['address_destination']?></textarea>
                        <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de destino es obligatoria')?></div>
                    </div>
                    <?php echo $this->Form->submit('Actualizar Dirección Destino')?>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
            
            <!-- EDIT CONTACTS -->
            <br/>
            <br/>
            <div>
                <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeContactInfo/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <div class="form-group required">
                        <label for="Contacts">Contactos</label>
                        <textarea name="contacts" class="form-control" value="<?= $request['SharedTravel']['contacts']?>" placeholder="Contactos personales y/o de estancia" rows="2" id="Contacts" required="required"><?= $request['SharedTravel']['contacts']?></textarea>
                        <div class="invalid-feedback"><?php echo __d('errors', 'El contacto es obligatorio')?></div>
                    </div>
                    <?php echo $this->Form->submit('Actualizar Contactos')?>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
            
            <!-- Name -->
            <br/>
            <br/>
            <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeName/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?php echo $this->Form->input('name_id', array('label' => 'Nuevo nombre', 'value'=>$request['SharedTravel']['name_id'],'type'=>'text', 'required', 'invalid-feedback'=>'El nombre es obligatorio'));?>
                    <?php echo $this->Form->submit('Actualizar Nombre')?>
                </fieldset>
            <?php echo $this->Form->end(); ?>
            
            <!-- Discount -->
            <br/>
            <br/>
            <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'discount/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?php echo $this->Form->input('discount_total', array('label' => 'Descuento', 'value'=>$request['SharedTravel']['discount_total'],'type'=>'number', 'required', 'invalid-feedback'=>'El descuento debe ser un número entero'));?>
                    <?php echo $this->Form->submit('Aplicar Descuento')?>
                </fieldset>
            <?php echo $this->Form->end(); ?>
            
            <!-- Fee -->
            <br/>
            <br/>
            <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'fee/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?php echo $this->Form->input('fee_total', array('label' => 'Recargo', 'value'=>$request['SharedTravel']['fee_total'],'type'=>'number', 'required', 'invalid-feedback'=>'El recargo debe ser un número entero'));?>
                    <?php echo $this->Form->submit('Aplicar Recargo')?>
                </fieldset>
            <?php echo $this->Form->end(); ?>
            
            
            
            <!-- FINAL STATE -->
            <br/>
            <br/>
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
                    <?php echo $this->Form->submit('Actualizar Estado Final')?>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>