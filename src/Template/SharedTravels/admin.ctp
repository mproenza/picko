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
            <div><?= $this->Html->link(
                    'Activar', 
                    ['controller'=>'shared-rides', 'action'=>'activate', $request['SharedTravel']['activation_token']],
                    ['class'=>'btn btn-info', 'confirm'=>'¿Está seguro que quiere ACTIVAR esta solicitud?'])?>
            </div>
            <br/>
            <div><?= $this->Html->link(
                    'Confirmar', 
                    array('controller'=>'shared-rides', 'action'=>'confirm', $request['SharedTravel']['id_token']),
                    array('class'=>'btn btn-primary', 'confirm'=>'¿Está seguro que quiere CONFIRMAR esta solicitud?'))?>
            </div>
            <br/>
            <div><?= $this->Html->link(
                    'Cancelar', 
                    array('controller'=>'shared-rides', 'action'=>'cancel', $request['SharedTravel']['id_token']),
                    array('class'=>'btn btn-danger', 'confirm'=>'¿Está seguro que quiere CANCELAR esta solicitud?'))?>
            </div>
            <br/>
            <br/>
            <?php $fechaCambiada = $request['SharedTravel']['original_date'] != $request['SharedTravel']['date']?>
            <div class="alert alert-success" style="display: inline-block;">
                <b><?= TimeUtil::prettyDate($request['SharedTravel']['date'])?></b>
                <?php if($fechaCambiada):?><span class="badge badge-secondary"><b>Fecha original: <?= TimeUtil::prettyDate($request['SharedTravel']['original_date'])?></b></span><?php endif?>
                <?= $this->element('form_shared_travel_date_controls', ['request'=>$request])?>
            </div>
            
            <!-- EDIT DEPARTURE TIME -->
            <br/>
            <br/>
            <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeDepartureTime', $request['SharedTravel']['id'])));?>
                <fieldset>
                    <select name="departure_time">
                        <?php for($i=1;$i<=24;$i++):?>
                        <option value="<?= $i?>" <?= $request['SharedTravel']['departure_time'] == $i?'selected':''?>><?=TimeUtil::getTimeAmPM($i)?></option>
                        <?php endfor;?>
                    </select>
                    <br><br>
                    <?= $this->Form->submit('Actualizar Horario Salida')?>
                </fieldset>
            <?= $this->Form->end(); ?>
            
            <!-- EDIT PICKUP ADDRESS -->
            <br/>
            <br/>
            <div>
                <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changePickupAddress/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <div class="form-group required">
                        <label for="AddressOrigin">Nueva dirección de recogida</label>
                        <textarea name="address_origin" class="form-control" value="<?= $request['SharedTravel']['address_origin']?>" rows="2" id="AddressOrigin" required="required"><?= trim($request['SharedTravel']['address_origin']) ?></textarea>
                        <div class="invalid-feedback"><?= __d('errors', 'La dirección de recogida es obligatoria')?></div>
                    </div>
                    <?= $this->Form->submit('Actualizar Dirección Recogida')?>
                </fieldset>
                <?= $this->Form->end(); ?>
            </div>
            
            <!-- EDIT DROPOFF ADDRESS -->
            <br/>
            <br/>
            <div>
                <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeDropoffAddress/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <div class="form-group required">
                        <label for="AddressDestination">Nueva dirección de destino</label>
                        <textarea name="address_destination" class="form-control" value="<?= $request['SharedTravel']['address_destination']?>" placeholder="Dirección de la casa o nombre del hotel" rows="2" id="AddressDestination" required="required"><?= $request['SharedTravel']['address_destination']?></textarea>
                        <div class="invalid-feedback"><?= __d('errors', 'La dirección de destino es obligatoria')?></div>
                    </div>
                    <?= $this->Form->submit('Actualizar Dirección Destino')?>
                </fieldset>
                <?= $this->Form->end(); ?>
            </div>
            
            <!-- EDIT CONTACTS -->
            <br/>
            <br/>
            <div>
                <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeContactInfo/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <div class="form-group required">
                        <label for="Contacts">Contactos</label>
                        <textarea name="contacts" class="form-control" value="<?= $request['SharedTravel']['contacts']?>" placeholder="Contactos personales y/o de estancia" rows="2" id="Contacts" required="required"><?= $request['SharedTravel']['contacts']?></textarea>
                        <div class="invalid-feedback"><?= __d('errors', 'El contacto es obligatorio')?></div>
                    </div>
                    <?= $this->Form->submit('Actualizar Contactos')?>
                </fieldset>
                <?= $this->Form->end(); ?>
            </div>
            
            <!-- Name -->
            <br/>
            <br/>
            <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeName/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?= $this->Form->input('name_id', array('label' => 'Nuevo nombre', 'value'=>$request['SharedTravel']['name_id'],'type'=>'text', 'required', 'invalid-feedback'=>'El nombre es obligatorio'));?>
                    <?= $this->Form->submit('Actualizar Nombre')?>
                </fieldset>
            <?= $this->Form->end(); ?>
            
            <!-- EDIT PAX -->
            <br/>
            <br/>
            <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changePax/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?= $this->Form->input('people_count', array('label' =>'Nueva cant. personas', 'value'=>$request['SharedTravel']['people_count'], 'type'=>'number', 'min' => 1, 'max' => 4, 'required', 'invalid-feedback'=>__d('errors', 'La cantidad de personas debe ser un número entre {0} y {1}', 1, 4)));?>
                    <?= $this->Form->submit('Actualizar PAX')?>
                </fieldset>
            <?= $this->Form->end(); ?>
            
            <!-- Discount -->
            <br/>
            <br/>
            <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'discount/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?= $this->Form->input('discount_total', array('label' => 'Descuento', 'value'=>$request['SharedTravel']['discount_total'],'type'=>'number', 'required', 'invalid-feedback'=>'El descuento debe ser un número entero'));?>
                    <?= $this->Form->submit('Aplicar Descuento')?>
                </fieldset>
            <?= $this->Form->end(); ?>
            
            <!-- Fee -->
            <br/>
            <br/>
            <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'fee/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?= $this->Form->input('fee_total', array('label' => 'Recargo', 'value'=>$request['SharedTravel']['fee_total'],'type'=>'number', 'required', 'invalid-feedback'=>'El recargo debe ser un número entero'));?>
                    <?= $this->Form->submit('Aplicar Recargo')?>
                </fieldset>
            <?= $this->Form->end(); ?>
            
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
                
                <?= $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'setFinalState/'.$request['SharedTravel']['id'])));?>
                <fieldset>
                    <?php
                    
                    echo $this->Form->control('final_state', ['options' => $states, 'label'=>false]);
                    ?>
                    <?= $this->Form->submit('Actualizar Estado Final')?>
                </fieldset>
                <?= $this->Form->end(); ?>
            </div>
            
            <!-- CORREOS (RECONFIRMACION, NO AEROPUERTO, ...) -->
            <br/>
            <br/>
            <legend>CORREOS</legend>
            <div>
                <div><?= $this->Html->link(
                    'Reconfirmar con el Cliente', 
                    ['controller'=>'shared-rides', 'action'=>'send-reconfirmation-email', $request['SharedTravel']['id_token']],
                    ['class'=>'btn btn-warning', 'confirm'=>'¿Está seguro que quiere ENVIAR AL CLIENTE EL CORREO DE RECONFIRMACIÓN de esta solicitud?'])?>
                </div>
                <!--<br/>
                <div><?= $this->Html->link(
                        'Confirmar', 
                        array('controller'=>'shared-rides', 'action'=>'confirm', $request['SharedTravel']['id_token']),
                        array('class'=>'btn btn-primary', 'confirm'=>'¿Está seguro que quiere ConFIRMAR esta solicitud?'))?>
                </div>
                <br/>
                <div><?= $this->Html->link(
                        'Cancelar', 
                        array('controller'=>'shared-rides', 'action'=>'cancel', $request['SharedTravel']['id_token']),
                        array('class'=>'btn btn-danger', 'confirm'=>'¿Está seguro que quiere CAnCELAR esta solicitud?'))?>
                </div>-->
            </div>
        </div>
    </div>
</div>