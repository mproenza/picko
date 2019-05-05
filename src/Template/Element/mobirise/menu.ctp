<?php use Cake\Core\Configure; use \Cake\I18n\I18n;?>

<?php Configure::write('App.imageBaseUrl', 'assets/images/');?>

<?php
if(!isset($isHome)) $isHome = false;
?>

<section class="menu cid-qTkzRZLJNu" once="menu" id="menu1-0">
    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm bg-color <?php if($isHome):?>transparent<?php endif?>">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <?php echo $this->Html->link($this->Html->image('logo43.png', ['alt'=>'Logo PickoCar', 'style'=>'2.8rem;']), ['_name'=>'homepage'], ['escape' => false]); ?>
                </span>
                <span class="navbar-caption-wrap">
                  <?php echo $this->Html->link('PickoCar', ['_name'=>'homepage'], ['class' => 'navbar-caption text-white display-4']); ?>
                </span>

                <ul class="navbar-nav">
                    <li class="nav-item">
                      <?php echo $this->Html->lang(I18n::getLocale(), $this->request, ['class'=>'nav-link link text-white display-4']) ?>
                    </li>
                </ul>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                <li class="nav-item">
                    <?= $this->Html->link( __d('shared_travels', 'Debes saber'), ['_name'=>'homepage', '#'=>__d('meta', 'debes-saber')], ['class' => 'nav-link link text-white display-4']) ?>
                </li>
                <!--<li class="nav-item">
                  <?= $this->Html->link('FAQ', ['plugin'=>null, 'controller'=>'pages', 'action'=>'display', 'faq'], ['class' => 'nav-link link text-white display-4']); ?>
                </li>-->
                <li class="nav-item">
                  <?= $this->Html->link(__d('shared_travels', 'Sobre Nosotros'), ['plugin'=>null, 'controller'=>'pages', 'action'=>'display', 'about'], ['class' => 'nav-link link text-white display-4']); ?>
                </li>
                <li class="nav-item">
                  <?= $this->Html->link(__d('shared_travels', 'Contactar'), ['plugin'=>null, 'controller'=>'contact'], ['class' => 'nav-link link text-white display-4']); ?>
                </li>
                <li class="nav-item">
                  <?= $this->Html->link(__d('shared_travels', 'Flota'), ['plugin'=>null, 'controller'=>'pages', 'action'=>'display', 'taxi-fleet'], ['class' => 'nav-link link text-white display-4']); ?>
                </li>
            </ul>
            <div class="navbar-buttons mbr-section-btn">
                <?php echo $this->Html->link('<b>'.__d('/mobirise/home', 'VER RUTAS DE TAXI Y PRECIOS').'</b>', ['_name'=>'homepage', '#'=>__d('meta', 'rutas-y-precios')], array('class' => 'btn btn-sm btn-success display-4', 'escape'=>false)) ?>
            </div>
        </div>
    </nav>
</section>