<div class="row" style="margin: 0px">
    <div>
        <div class="h5"><?php echo __d('shared_travels', 'Reserva un taxi compartido para ir de {0} a {1}', '<code><big>'.$route['origin'].'</big></code>','<code><big>'.$route['destination'].'</big></code>')?></div>
        <div>
            <?php echo __d('shared_travels', 'Precio').': '.__d('shared_travels', '{0} por persona', '<code><big><big>'.$route['price_x_seat'].' cuc'.'</big></big></code>')?>
        </div>
        <!--<div>
            <?php echo __d('shared_travels', 'Recogida a las {0} en el lugar y fecha que indiques','<code><big><big>'.$route['time'].'</big></big></code>')?>
        </div>-->
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <?php echo $this->element('form_shared_travel', compact('route'))?>
    </div>
</div>