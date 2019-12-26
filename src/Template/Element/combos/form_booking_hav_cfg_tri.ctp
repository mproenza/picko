<?php use App\Model\Entity\SharedTravel;?>

<?php
$emailValue = null;
$peopleCountValue = 2;
$nameIdValue = null;
if($this->request->session()->read('user_email')) $emailValue = $this->request->session()->read('user_email');
if($this->request->session()->read('user_people_count')) $peopleCountValue = $this->request->session()->read('user_people_count');
if($this->request->session()->read('user_name_id')) $nameIdValue = $this->request->session()->read('user_name_id');
?>

<div>
    <?php 
    echo $this->Form->create('SharedTravel', array('url' => ['controller' => 'shared-rides', 'action' => 'book_hav_cfg_tri'], 'id'=>'SharedTravelForm', 'novalidate'));?>
    <?php echo $this->Flash->render('form')?>
    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->custom_date('date', array('label' => __d('shared_travels', 'Fecha en que necesitas el servicio'), 'autocomplete'=>'off', 'dateFormat' => 'dd/mm/yyyy', 'required', 'invalid-feedback'=>__d('errors', 'Escriba una fecha válida: 2 días después de hoy como mínimo y en formato dd/mm/aaaa')));?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="margin-top: 40px">
                <div><b><?php echo __d('/mobirise/hav_cfg_tri', 'TAXI {0} > {1}', 'LA HABANA', 'CIENFUEGOS')?></b></div>
                <br>
                <small>* <?= __d('/mobirise/hav_cfg_tri', '{0} asientos', 2)?> > <b>$69</b></small>
                <br>
                <small>* <?= __d('/mobirise/hav_cfg_tri', 'Recogida {0}', '8 am')?></small>
                <hr/>
                <div class="form-group required">
                    <label for="AddressOriginHavana"><?php echo __d('shared_travels', 'Dirección de recogida en {0}', '<b>'.__('La Habana').'</b>')?></label>
                    <textarea name="address_origin_havana" class="form-control" rows="2" id="AddressOriginHavana" required="required"></textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de recogida es obligatoria')?></div>
                </div>
                <div class="form-group required">
                    <label for="AddressDestinationCienfuegos"><?php echo __d('shared_travels', 'Dirección de destino en {0}', '<b>Cienfuegos</b>')?></label>
                    <textarea name="address_destination_cienfuegos" class="form-control" rows="2" id="AddressDestinationCienfuegos" required="required">Parque José Martí</textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de destino es obligatoria')?></div>
                </div>
            </div>
            
            <div class="col-md-6" style="margin-top: 40px">
                <div><b><?php echo __d('/mobirise/hav_cfg_tri', 'TAXI {0} > {1}', 'CIENFUEGOS', 'TRINIDAD')?></b></div>
                <br>
                <small>* <?= __d('/mobirise/hav_cfg_tri', '{0} asientos', 2)?> > <b>$30</b></small>
                <br>
                <small>* <?= __d('/mobirise/hav_cfg_tri', 'Recogida {0}', '5 pm')?></small>
                <hr/>
                <div class="form-group required">
                    <label for="AddressOriginCienfuegos"><?php echo __d('shared_travels', 'Dirección de recogida en {0}', '<b>Cienfuegos</b>')?></label>
                    <textarea name="address_origin_cienfuegos" class="form-control" rows="2" id="AddressOriginCienfuegos" required="required">Palacio de Valle</textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de recogida es obligatoria')?></div>
                </div>
                <div class="form-group required">
                    <label for="AddressDestinationTrinidad"><?php echo __d('shared_travels', 'Dirección de destino en {0}', '<b>Trinidad</b>')?></label>
                    <textarea name="address_destination_trinidad" class="form-control" rows="2" id="AddressDestinationTrinidad" required="required"></textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de destino es obligatoria')?></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="margin-top: 30px">
                <div><small><b><?php echo __d('shared_travels', 'DATOS DE CONTACTO')?></b></small></div><hr/>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('email', array('label' => __d('shared_travels', 'Tu correo electrónico'), 'value'=>$emailValue, 'type' => 'email', 'required', 'invalid-feedback'=>__d('errors', 'Escriba una dirección de correo válida')));?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('name_id', array('label' => __d('shared_travels', 'Tu nombre completo para fácil identificación'),'value'=>$nameIdValue, 'type' => 'text', 'required', 'invalid-feedback'=>__d('errors', 'Su nombre es necesario para la identificación. Por favor escríbalo.')));?>
            </div>                
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <label for="Contacts"><?php echo __d('shared_travels', 'Teléfono de hospedaje, hotel y/o personal')?></label>
                    <textarea name="contacts" class="form-control" placeholder="<?php echo __d('shared_travels', 'Adicione números de contactos útiles')?>" rows="2" id="Contacts"></textarea>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">            
            <div class="submit col-md-12" style="text-align: center;margin-left: 0px;padding-left: 0px"">
                <?php 
                $submitOptions = ['class'=>'btn btn-block btn-success', 'style' => 'font-size:14pt;white-space: normal;', 'id'=>'SharedTravelSubmit', 'escape'=>false, 'rel'=>'nofollow'];
                echo $this->Form->submit(__d('/mobirise/hav_cfg_tri', 'Reservar ruta {0} por {1}', __('La Habana').' > Cienfuegos > Trinidad', '$99').' ('.__d('/mobirise/hav_cfg_tri', '{0} asientos', 2).')', $submitOptions);
                ?>
            </div> 
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>

<?php
$this->Html->css('datepicker.css', ['block'=>'css_top']);
$this->Html->script('datepicker', ['block'=>'script_bottom']);
?>