<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php echo $this->Flash->render()?>
            <legend><?php echo __d('shared_travels', 'Contáctanos')?></legend>
            <hr/>
            <?php
            echo $this->Form->create($contact);
            echo $this->Form->input('name', ['label'=>__d('shared_travels', 'Tu nombre')]).'<br/>';
            echo $this->Form->input('email', ['label'=>__d('shared_travels', 'Tu correo')]).'<br/>';
            ?>
            <div class="form-group required">
                <label for="Body"><?php echo __d('shared_travels', 'Mensaje')?></label>
                <textarea name="body" class="form-control" placeholder="" rows="3" id="Body" required="required"></textarea>
            </div>
            <?php
            echo $this->Form->submit(__d('shared_travels', 'Enviar mensaje'));
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>