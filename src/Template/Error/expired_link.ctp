<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2><?php echo $message; ?></h2>
        <p class="error">
            <?php
            printf(__d('error', 'Ocurrió un error usando este enlace. Puede ser que esté caducado, ya haya sido usado o es incorrecto.'));
            ?>
        </p>
    </div>
</div>
