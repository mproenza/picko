<div>  
    <span id="date-change-set-<?php echo $request['SharedTravel']['id']?>" style="display: inline-block">
        <a href="#!" class="open-form edit-date-change-<?php echo $request['SharedTravel']['id']?>" data-form="date-change-form-<?php echo $request['SharedTravel']['id']?>">&ndash; <?php echo __('cambiar fecha')?></a>
    </span>
    <span id="date-change-cancel-<?php echo $request['SharedTravel']['id']?>" style="display:none">
        <a href="#!" class="cancel-edit-date-change-<?php echo $request['SharedTravel']['id']?>">&ndash; <?php echo __('cancelar')?></a>
    </span>
    <div id='date-change-form-<?php echo $request['SharedTravel']['id']?>' style="display:none">
        <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared-rides', 'action' => 'changeDate/'.$request['SharedTravel']['id'])));?>
        <fieldset>
            <?php echo $this->Form->custom_date('date', array('label' => false, 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'))?>
            <br/>
            <?php echo $this->Form->submit('Cambiar fecha')?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
$this->Html->css('datepicker.css', ['block'=>'css_top']);
$this->Html->script('datepicker', ['block'=>'script_bottom']);
?>
<?php
$this->append('script_internal',$this->element('js/elements/form_shared_travel_date_controls'));
?>