<?php use App\Util\TimeUtil;?>
<?php use App\Model\Entity\SharedTravel;?>

<p>Hola <?= $request['SharedTravel']['name_id']?>,</p>

<p><?= __d('shared_travels', 'Usted solicitó un transfer de {0} personas desde {1} hasta {2} el día {3} con recogida a las {4}.', '<b>'.$request['SharedTravel']['people_count'].'</b>', '<b>'.$request['SharedTravel']['origin'].'</b>', '<b>'.$request['SharedTravel']['destination'].'</b>', '<b>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</b>', '<b>'.$request['SharedTravel']['departure_time_desc'].'</b>')?></p>

<p><?= __d('shared_travels', 'Precio total por las {0} personas: {1}', $request['SharedTravel']['people_count'], '<b>'. SharedTravel::getTotalPrice($request['SharedTravel']).' cuc</b>')?></p>

<p><?= __d('shared_travels', 'Por favor revisa la solicitud y luego actívala haciendo click en el siguiente enlace. Activarla es necesario para nosotros comenzar a organizar el traslado.')?></p>

<p><?= $this->Html->link(__d('shared_travels', 'Activar y aprobar esta solicitud'), array('language'=>$request['SharedTravel']['lang'], 'controller' => 'shared-rides', 'action' => 'activate', $request['SharedTravel']['activation_token']/*, '_full'=>true*/), ['fullBase'=>true] )?></p>

<p>--- <b><?= __d('shared_travels', 'DATOS DE TU SOLICITUD')?></b> ---</p>

<div><?= $this->element('shared_travel_templates/shared_travel_customer_email', compact('request'))?></div>
<p>---</p>

<p>Gracias!</p>

<p><?= __d('shared_travels', 'El equipo de')?> <a href="https://pickocar.com">PickoCar</a></p>