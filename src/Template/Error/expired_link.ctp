<?php $this->layout = 'shared_rides';?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1><?php echo $message; ?></h1>
            <p class="error">
                <?php
                printf(__d('errors', 'Ocurrió un error usando este enlace. Puede ser que esté caducado, ya haya sido usado o es incorrecto.'));
                ?>
            </p>
        </div>
    </div>
</div>
    