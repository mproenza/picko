<div class="row" style="margin: 0px">
    <div class="col bg-light">
        <div>
            <?php echo __d('shared_travels', 'Precio').': '.__d('shared_travels', '{0} por persona', '<code><big><big>'.$modality['price'].' CUC'.'</big></big></code>')?>
        </div>
        <div>
            <?php echo __d('shared_travels', 'Recogida a las {0} en el lugar y fecha que indiques','<code><big><big>'.$modality['time'].'</big></big></code>')?>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
        <?php echo $this->element('shared_travel_form_bootbox', compact('modality') + compact('code'))?>
    </div>
</div>