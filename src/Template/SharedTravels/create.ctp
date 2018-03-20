<?php
use App\Model\Entity\SharedTravel;
use Cake\I18n\I18n;

$modalityCode =  $this->request->query['s'];
$modality = SharedTravel::$modalities[$modalityCode];
?>

<div class="row">

    <div class="col-md-8 offset-md-2">
        <?php echo $this->element('shared_travel_book_prompt', compact('modality') + ['code'=>$modalityCode])?>
    </div>
    <!--<div class="col-md-3 col-md-offset-1 alert alert-warning" style="display: inline-block">
        <p style="text-align: center"><b><?php echo __d('shared_travels', 'TÉRMINOS DEL SERVICIO')?></b></p><hr/>
        <ul>
           <li><?php echo __d('shared_travels', 'Servicio <b>compartido</b> en <b>auto moderno</b> de <b>4 plazas</b> con <b>aire acondicionado</b> y excelente confort.')?></li>
           <br/>
           <li><?php echo __d('shared_travels', 'Servicio <b>puerta a puerta</b> (recogida en casa u hotel y se deja en casa u hotel del destino).')?></li>
           <br/>
           <li><?php echo __d('shared_travels', 'La <b>recogida puede demorar hasta 30 minutos</b> después de la hora establecida para el servicio, pues el chofer planifica su recorrido para recoger a los 4 viajeros.')?></li>
           <br/>
           <li><?php echo __d('shared_travels', 'El <b>pago es en efectivo y en CUC</b> directamente al chofer al efectuarse la recogida.')?></li>
        </ul>
    </div>-->
</div>
<?php
echo $this->Html->css('datepicker');
echo $this->Html->script('datepicker');
echo $this->Html->script('datepicker-locale');
?>

<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: '<?php echo I18n::getLocale()?>',
        startDate: '+2d',
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: false
    });
</script>