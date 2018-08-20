<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'shared_rides';

if (Configure::read('debug')) :
    $this->layout = 'shared_rides';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

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
<?php if ($error instanceof Error) : ?>
        <strong>Error in: </strong>
        <?= sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine()) ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

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
                <?= __d('errors', 'Ha ocurrido un error interno.') ?>
            </p>
        </div>
    </div>
</div>
