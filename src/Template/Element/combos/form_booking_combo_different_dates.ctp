<?php use App\Model\Entity\SharedTravel;?>

<?php
$peopleCount = 2;
$priceRoute1 = $route1['price_x_seat']*$peopleCount;
$priceRoute2 = $route2['price_x_seat']*$peopleCount;
$totalPriceCombo = $priceRoute1 + $priceRoute2;

$emailValue = null;
$nameIdValue = null;
if($this->request->session()->read('user_email')) $emailValue = $this->request->session()->read('user_email');
//if($this->request->session()->read('user_people_count')) $peopleCountValue = $this->request->session()->read('user_people_count');
if($this->request->session()->read('user_name_id')) $nameIdValue = $this->request->session()->read('user_name_id');
?>

<div>
    <?php
    echo $this->Form->create('SharedTravel', array('url' => ['controller' => 'shared-rides', 'action' => 'book_taxi_combo'], 'id'=>'SharedTravelForm', 'novalidate'));?>
    <?php echo $this->Flash->render('form')?>
    <fieldset>
        <div class="row">
            <div class="col-md-6" style="margin-top: 40px">
                <div><b class="text-uppercase"><?php echo __d('/mobirise/hav_cfg_tri', 'Taxi {0} > {1}', $route1['origin'], $route1['destination'])?></b></div>
                <br>
                <small>* <?= __d('/mobirise/hav_cfg_tri', '{0} asientos', 2)?> > <b>$<?= $priceRoute1 ?></b></small>
                <hr/>
                
                <?php
                echo $this->Form->input('origin_id_1', array('type' => 'hidden', 'value'=>$route1['origin_id']));
                echo $this->Form->input('destination_id_1', array('type' => 'hidden', 'value'=>$route1['destination_id']));
                ?>
                
                <?php echo $this->Form->custom_date('date_route_1', array('label' => __d('shared_travels', 'Fecha en que necesitas el servicio'), 'autocomplete'=>'off', 'dateFormat' => 'dd/mm/yyyy', 'required', 'invalid-feedback'=>__d('errors', 'Escriba una fecha válida: 2 días después de hoy como mínimo y en formato dd/mm/aaaa')));?>
                <br/>
                
                <?php $radios = []?>
                <?php 
                foreach ($route1['departure_times'] as $i=>$time)
                    $radios[$i] = ['value'=>$time, 'text'=>'<big>'.$route1['departure_times_desc'][$i].'</big>', 'style'=>'margin-right:10px'];
                    if($i > 0) $radios[$i]['style'] = 'margin-left:20px;margin-right:10px';
                ?>
                <div>
                    <b><?php echo __d('shared_travels', 'Hora de recogida')?></b>
                    <div style="margin-top: 10px"><?php echo $this->Form->radio('departure_time_route_1', $radios, ['default'=>$route1['departure_times'][0], 'escape'=>false])?></div>
                </div>
                <br/>
                <div class="form-group required">
                    <label for="AddressOrigin1"><?php echo __d('shared_travels', 'Dirección de recogida en {0}', '<b>'.__($route1['origin']).'</b>')?></label>
                    <textarea name="address_origin_1" class="form-control" rows="2" id="AddressOrigin1" required="required"></textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de recogida es obligatoria')?></div>
                </div>
                <div class="form-group required">
                    <label for="AddressDestination1"><?php echo __d('shared_travels', 'Dirección de destino en {0}', '<b>'.__($route1['destination']).'</b>')?></label>
                    <textarea name="address_destination_1" class="form-control" rows="2" id="AddressDestination1" required="required"></textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de destino es obligatoria')?></div>
                </div>
            </div>
            
            <div class="col-md-6" style="margin-top: 40px">
                <div><b class="text-uppercase"><?php echo __d('/mobirise/hav_cfg_tri', 'Taxi {0} > {1}', __($route2['origin']), __($route2['destination']))?></b></div>
                <br>
                <small>* <?= __d('/mobirise/hav_cfg_tri', '{0} asientos', 2)?> > <b>$<?= $priceRoute2?></b></small>
                <hr/>
                
                <?php
                echo $this->Form->input('origin_id_2', array('type' => 'hidden', 'value'=>$route2['origin_id']));
                echo $this->Form->input('destination_id_2', array('type' => 'hidden', 'value'=>$route2['destination_id']));
                ?>
                
                <?php echo $this->Form->custom_date('date_route_2', array('label' => __d('shared_travels', 'Fecha en que necesitas el servicio'), 'autocomplete'=>'off', 'dateFormat' => 'dd/mm/yyyy', 'required', 'invalid-feedback'=>__d('errors', 'Escriba una fecha válida: 2 días después de hoy como mínimo y en formato dd/mm/aaaa')));?>
                <br/>
                
                <?php $radios = []?>
                <?php 
                foreach ($route2['departure_times'] as $i=>$time)
                    $radios[$i] = ['value'=>$time, 'text'=>'<big>'.$route2['departure_times_desc'][$i].'</big>', 'style'=>'margin-right:10px'];
                    if($i > 0) $radios[$i]['style'] = 'margin-left:20px;margin-right:10px';
                ?>
                <div>
                    <b><?php echo __d('shared_travels', 'Hora de recogida')?></b>
                    <div style="margin-top: 10px"><?php echo $this->Form->radio('departure_time_route_2', $radios, ['default'=>$route2['departure_times'][0], 'escape'=>false])?></div>
                </div>
                <br/>
                <div class="form-group required">
                    <label for="AddressOrigin2"><?php echo __d('shared_travels', 'Dirección de recogida en {0}', '<b>'.__($route2['origin']).'</b>')?></label>
                    <textarea name="address_origin_2" class="form-control" rows="2" id="AddressOrigin2" required="required"></textarea>
                    <div class="invalid-feedback"><?php echo __d('errors', 'La dirección de recogida es obligatoria')?></div>
                </div>
                <div class="form-group required">
                    <label for="AddressDestination2"><?php echo __d('shared_travels', 'Dirección de destino en {0}', '<b>'.__($route2['destination']).'</b>')?></label>
                    <textarea name="address_destination_2" class="form-control" rows="2" id="AddressDestination2" required="required"></textarea>
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
                echo $this->Form->submit(__d('/mobirise/hav_cfg_tri', 'Reservar ruta {0} por {1}', __($route1['origin']).' > '.__($route1['destination']).' > '.__($route2['destination']).'', '$'.$totalPriceCombo).' ('.__d('/mobirise/hav_cfg_tri', '{0} asientos', 2).')', $submitOptions);
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