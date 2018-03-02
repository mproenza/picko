<div>  
    <span id="date-change-set-<?php echo $request['SharedTravel']['id']?>" style="display: inline-block">
        <a href="#!" class="open-form edit-date-change-<?php echo $request['SharedTravel']['id']?>" data-form="date-change-form-<?php echo $request['SharedTravel']['id']?>">&ndash; <?php echo __('cambiar fecha')?></a>
    </span>
    <span id="date-change-cancel-<?php echo $request['SharedTravel']['id']?>" style="display:none">
        <a href="#!" class="cancel-edit-date-change-<?php echo $request['SharedTravel']['id']?>">&ndash; <?php echo __('cancelar')?></a>
    </span>
    <div id='date-change-form-<?php echo $request['SharedTravel']['id']?>' style="display:none">
        <?php echo $this->Form->create('SharedTravel', array('url' => array('controller' => 'shared_travels', 'action' => 'changeDate/'.$request['SharedTravel']['id'])));?>
        <fieldset>
            <?php echo $this->Form->custom_date('date', array('label' => false, 'dateFormat' => 'dd/mm/yyyy', 'class'=>'input-sm'))?>
            <br/>
            <?php echo $this->Form->submit('Cambiar fecha')?>
        </fieldset>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php
echo $this->Html->css('datepicker.css');
echo $this->Html->script('datepicker');
?>

<script type="text/javascript">
    
    function openForm(event) {
        bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('form') ).html()});
        
        form = $('.bootbox form');
        datepicker = form.find('.datepicker');

        datepicker.datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo 'es'?>',
            //startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });

        form.validate({
            wrapper: 'div',
            errorClass: 'text-danger',
            errorElement: 'div'
        });

        $('.bootbox .datepicker').datepicker({
            format: "dd/mm/yyyy",
            language: '<?php echo 'es'?>',
            //startDate: 'today',
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
        
        event.preventDefault();
    }
            

    $(document).ready(function(){
        $( ".open-form" ).click(openForm);
    });
 </script>