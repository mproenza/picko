<?php use App\Model\Entity\SharedTravel;?>

<?php
$emailValue = null;
$peopleCountValue = 1;
$nameIdValue = null;
if($this->Session->read('SharedTravels.email')) $emailValue = $this->Session->read('SharedTravels.email');
//else if($userLoggedIn) $emailValue = AuthComponent::user('username');
if($this->Session->read('SharedTravels.people_count')) $peopleCountValue = $this->Session->read('SharedTravels.people_count');
if($this->Session->read('SharedTravels.name_id')) $nameIdValue = $this->Session->read('SharedTravels.name_id');
?>

<div>
    <?php 
    echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared_travels', 'action' => 'create'), 'id'=>'SharedTravelForm'));?>
    <fieldset>
        <div class="row" style="margin: 0px;padding: 0px">
            <div class="col-md-6">
                <div><small><b><?php echo __d('shared_travels', 'DATOS DEL TRANSFER')?></b></small></div><hr/>
                <?php echo $this->Form->input('modality_code', array('type' => 'hidden', 'value'=>$code));?>

                <?php echo $this->Form->custom_date('date', array('label' => __d('shared_travels', 'Fecha en que necesitas el servicio'), 'dateFormat' => 'dd/mm/yyyy'));?>
                <?php echo $this->Form->input('people_count', array('label' => __d('shared_travels', 'Cantidad de personas'), 'value'=>$peopleCountValue, 'default' => 1, 'min' => 1, 'max' => 4));?>
                <br/>
                <div class="form-group required">
                    <label for="AddressOrigin"><?php echo __d('shared_travels', 'Dirección de recogida en {0}', '<code><big>'.$modality['origin'].'</big></code>')?></label>
                    <textarea name="address_origin" class="form-control" placeholder="<?php echo __d('shared_travels', 'Dirección exacta de la casa o nombre del hotel donde debemos recogerle')?>" rows="2" id="AddressOrigin" required="required"></textarea>
                </div>
                <div class="form-group required">
                    <label for="AddressDestination"><?php echo __d('shared_travels', 'Dirección de destino en {0}', '<code><big>'.$modality['destination'].'</big></code>')?></label>
                    <textarea name="address_destination" class="form-control" placeholder="<?php echo __d('shared_travels', 'Dirección de la casa o nombre del hotel')?>" rows="2" id="AddressDestination" required="required"></textarea>
                </div>
            </div>
            
            <div class="col-md-6">
                <div><small><b><?php echo __d('shared_travels', 'DATOS DE CONTACTO')?></b></small></div><hr/>
                <?php echo $this->Form->input('email', array('label' => __d('shared_travels', 'Tu correo electrónico'), 'value'=>$emailValue, 'type' => 'email', 'required'=>'required'));?>
                <?php echo $this->Form->input('name_id', array('label' => __d('shared_travels', 'Tu nombre completo para fácil identificación'),'value'=>$nameIdValue, 'type' => 'text', 'required'=>'required'));?>
            </div>
            
        </div>
        
        <br/>
        <div class="row">
            <div class="submit col-md-12" style="text-align: center">
                <?php 
                $submitOptions = array('class'=>'btn btn-block btn-primary', 'style' => 'font-size:14pt;white-space: normal;', 'id'=>'SharedTravelSubmit', 'escape'=>false, 'rel'=>'nofollow');
                echo $this->Form->submit(__d('shared_travels', 'Solicitar este transfer {0} - {1}', $modality['origin'], $modality['destination']), $submitOptions);
                ?>
            </div> 
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>