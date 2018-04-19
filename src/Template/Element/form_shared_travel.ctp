<?php use App\Model\Entity\SharedTravel;?>

<?php
$emailValue = null;
$peopleCountValue = 1;
$nameIdValue = null;
if($this->request->session()->read('SharedTravels.email')) $emailValue = $this->request->session()->read('SharedTravels.email');
//else if($userLoggedIn) $emailValue = AuthComponent::user('username');
if($this->request->session()->read('SharedTravels.people_count')) $peopleCountValue = $this->request->session()->read('SharedTravels.people_count');
if($this->request->session()->read('SharedTravels.name_id')) $nameIdValue = $this->request->session()->read('SharedTravels.name_id');
?>

<div>
    <?php 
    echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'book', '?'=>['s'=>$code]), 'id'=>'SharedTravelForm'.$code, 'novalidate'));?>
    <?php echo $this->Flash->render('form')?>
    <fieldset>
        <div class="row" style="margin: 0px;padding: 0px">
            <div class="col-md-6">
                <div><small><b><?php echo __d('shared_travels', 'DATOS DEL TRANSFER')?></b></small></div><hr/>
                <?php echo $this->Form->input('modality_code', array('type' => 'hidden', 'value'=>$code));?>

                <?php echo $this->Form->custom_date('date', array('label' => __d('shared_travels', 'Fecha en que necesitas el servicio'), 'dateFormat' => 'dd/mm/yyyy', 'required', 'invalid-feedback'=>__d('errors', 'Escriba una fecha válida: 2 días después de hoy como mínimo y en formato dd/mm/aaaa')));?>
                <br/>
                <?php echo $this->Form->input('people_count', array('label' => __d('shared_travels', 'Cantidad de personas (4 pasajeros máx.)'), 'value'=>$peopleCountValue,'type'=>'number', 'default' => 1, 'min' => 1, 'max' => 4, 'required', 'invalid-feedback'=>__d('errors', 'La cantidad de personas debe ser un número entre 1 y 4')));?>
                <br/>
                <div class="form-group required">
                    <label for="AddressOrigin"><?php echo __d('shared_travels', 'Dirección de recogida en {0}', '<code><big>'.$modality['origin'].'</big></code>')?></label>
                    <textarea name="address_origin" class="form-control" placeholder="<?php echo __d('shared_travels', 'Dirección de la casa o nombre del hotel')?>" rows="2" id="AddressOrigin" required="required"></textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de recogida es obligatoria')?></div>
                </div>
                <div class="form-group required">
                    <label for="AddressDestination"><?php echo __d('shared_travels', 'Dirección de destino en {0}', '<code><big>'.$modality['destination'].'</big></code>')?></label>
                    <textarea name="address_destination" class="form-control" placeholder="<?php echo __d('shared_travels', 'Dirección de la casa o nombre del hotel')?>" rows="2" id="AddressDestination" required="required"></textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de destino es obligatoria')?></div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div><small><b><?php echo __d('shared_travels', 'DATOS DE CONTACTO')?></b></small></div><hr/>
                <?php echo $this->Form->input('email', array('label' => __d('shared_travels', 'Tu correo electrónico'), 'value'=>$emailValue, 'type' => 'email', 'required', 'invalid-feedback'=>__d('errors', 'Escriba una dirección de correo válida')));?>
                <br/>
                <?php echo $this->Form->input('name_id', array('label' => __d('shared_travels', 'Tu nombre completo para fácil identificación'),'value'=>$nameIdValue, 'type' => 'text', 'required', 'invalid-feedback'=>__d('errors', 'Su nombre es necesario para la identificación. Por favor escríbalo.')));?>
            </div>
            
        </div>
        
        <br/>
        <div class="row">
            <div class="submit col-md-12" style="text-align: center">
                <?php 
                $submitOptions = ['class'=>'btn btn-block btn-primary', 'style' => 'font-size:14pt;white-space: normal;', 'id'=>'SharedTravelSubmit', 'escape'=>false, 'rel'=>'nofollow'];
                echo $this->Form->submit(__d('shared_travels', 'Compartir este viaje de {0} a {1} y pagar sólo {2} por persona', $modality['origin'], $modality['destination'], $modality['price']. ' cuc'), $submitOptions);
                ?>
            </div> 
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>