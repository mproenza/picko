<?php use Cake\Core\Configure;?>

<?= $this->element('mobirise/menu')?>

<section class="mbr-section form1 cid-rqzkKYWpht" id="form1-2y">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">
                    <?= __d('/mobirise/contact', 'Contáctanos')?>
                </h2>
                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                    <?= __d('/mobirise/contact', 'Estamos disponibles para cualquier pregunta o solicitud. Escríbenos un mensaje en el siguiente formulario:')?>
                </h3>
                <h3 class="mbr-section-subtitle align-center pb-3 mbr-fonts-style display-6">
                    <?= __d('/mobirise/contact', 'También puedes contactarnos por WhatsApp')?>:
                    <br/>
                    <a href="https://wa.me/<?= Configure::read('whatsapp_contact_number_short')[ini_get('intl.default_locale')]?>?text=<?= __('Hola')?> PickoCar!" target="_blank" style="color: #25d366">
                        <span style="display: inline-block"><i class="fa fa-whatsapp"></i> <b><?= Configure::read('whatsapp_contact_number')[ini_get('intl.default_locale')]?></b></span>
                    </a>
                </h3>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="media-container-column col-lg-8">
                <?php echo $this->Flash->render()?>
                
                <?= $this->Form->create($contact);?>
                <div class="dragArea row row-sm-offset">
                    <div class="col-md-6  form-group" data-for="name">
                        <?= $this->Form->input('name', ['label'=>__d('shared_travels', 'Tu nombre')])?>
                    </div>
                    <div class="col-md-6  form-group" data-for="email">
                        <?= $this->Form->input('email', ['label'=>__d('shared_travels', 'Tu correo')])?>
                    </div>

                    <div data-for="message" class="col-md-12 form-group">
                        <label for="Body"><?php echo __d('shared_travels', 'Mensaje')?></label>
                        <textarea name="body" class="form-control" placeholder="" rows="3" id="Body" required="required"></textarea>
                    </div>
                    <div class="col-md-12 input-group-btn align-center">
                        <?= $this->Form->submit(__d('shared_travels', 'Enviar mensaje'), ['class'=>'btn btn-primary btn-form display-4']);?>
                    </div>
                </div>
                <?= $this->Form->end();?>
                
            </div>
        </div>
    </div>
</section>

<?= $this->element('/mobirise/footer')?>