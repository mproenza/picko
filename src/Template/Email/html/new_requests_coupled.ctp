<p>Viaje completo de 4 pax formado por <?php echo count($requests) - 1?> solicitudes pendientes y una que acabamos de recibir:</p>
<hr/>

<?php for ($i=0;$i<count($requests);$i++):?>
    <?php $request = $requests[$i]?>
    <div>
        <b><?php echo $i + 1?>.</b>
        <?php echo $this->element('shared_travel_templates/shared_travel_facilitator', compact('request'))?>
    </div>
    <br/>
    <br/>
<?php endfor;?>

<hr/>
<p><b>NOTA: Este es un viaje completo y por tanto ya fueron confirmados a los clientes.</b></p>