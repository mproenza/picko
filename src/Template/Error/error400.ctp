<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'shared_rides';

if (Configure::read('debug')) :
    $this->layout = 'shared_rides';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
if (extension_loaded('xdebug')) :
    xdebug_print_function_stack();
endif;

$this->end();
endif;
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1><?php echo $message; ?></h1>
            <p class="error">
                <strong><?= __d('error', 'Página no encontrada') ?>: </strong>
                <?= __d('errors', 'La dirección requerida {0} no se encuentra en este servidor.', "<strong>'{$url}'</strong>") ?>
            </p>
        </div>
    </div>
</div>
