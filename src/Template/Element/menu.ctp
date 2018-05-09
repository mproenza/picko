<?php use Cake\I18n\I18n;?>

<?php
if(!isset($isHome)) $isHome = false;
?>

<nav class="navbar navbar-expand-md fixed-top" id="navbar">
    <a class="navbar-brand white" href="#">PickoCar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" id='nav-toggler'></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav">
            <li><?php echo $this->Html->lang(I18n::getLocale(), $this->request) ?></li>
            <?php if(!$isHome):?><li><?php echo $this->Html->link(__d('shared_travels', 'IR AL INICIO'), ['_name'=>'homepage'], ['class' => 'nav-link']); ?></li><?php endif?>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li><?php echo $this->Html->link('<button type="button" class="btn btn-info navbar-btn">' . __d('shared_travels', 'VER RUTAS DISPONIBLES') . '</button>', ['_name'=>'homepage', '#'=>'transfers-available'], array('class'=>'mx-3', 'escape' => false, 'style' => 'padding:0px;padding-right:10px')) ?></li>
            <li><?php echo $this->Html->link(__d('shared_travels', 'Sobre Nosotros'), ['controller'=>'pages', 'action'=>'display', 'about'], ['class' => 'nav-link']); ?></li>
            <li><?php echo $this->User->logout();?></li>
        </ul>
    </div>
</nav>