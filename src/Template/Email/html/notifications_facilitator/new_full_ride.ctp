<?php use App\Model\Entity\SharedTravel;?>
<p>Solicitud de 4 pax:</p>
<div><?php echo $this->element('shared_travel_templates/shared_travel_facilitator', compact('request'))?></div>
<p><b>NOTA: Este viaje ya fue confirmado al cliente.</b></p>