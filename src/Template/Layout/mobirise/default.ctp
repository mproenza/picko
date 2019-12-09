<?php use Cake\Core\Configure; use \Cake\I18n\I18n;?>

<?php
Configure::write('App.cssBaseUrl', 'assets/');
Configure::write('App.jsBaseUrl', 'assets/');
Configure::write('App.imageBaseUrl', 'assets/images/');
?>

<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <?php if (ROOT != 'C:\xampp\htdocs\pickocar' && !$Auth->user()): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116001622-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-116001622-1');
        </script>
    <?php endif; ?> 

    <?= $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <?= $this->Html->meta('icon', 'favicon.png');?>
        
    <?= $this->Html->metaCanonical($this->request);?>

    <?php if(is_callable($meta['title'])) $meta['title'] = $meta['title']($this->viewVars, $this->request);?>
    <title><?php echo $meta['title'].' | '.'PickoCar'?></title>

    <?php if(is_callable($meta['description'])) $meta['description'] = $meta['description']($this->viewVars, $this->request);?>
    <meta name="description" content="<?php echo $meta['description'];?>"/>
    
    <!-- TWITTER SHARE -->   
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo substr($meta['title'], 0, 70)?>">
    <meta name="twitter:description" content="<?php echo $meta['description']?>">
    <meta name="twitter:site" content="@pickocar">
    <!--<meta name="twitter:creator" content="@yotellevocuba">-->
    <meta name="twitter:image" content="<?= Configure::read('App.fullBaseUrl')?>/assets/images/main-header-twitter-card.jpg">

    <!-- FACEBOOK SHARE -->        
    <meta property="og:title" content="<?php echo substr($meta['title'], 0, 90)?>">
    <meta property="og:description" content="<?php echo $meta['description']?>">
    <meta property="og:image" content="<?= Configure::read('App.fullBaseUrl')?>/assets/images/main-header-1-1630x955.jpg">
  
    <?php if(isset($meta['hreflang']) && $meta['hreflang']) echo $this->Html->hreflang($this->request)?>
    
    <?php
    // CSS
    echo $this->Html->css('web/assets/mobirise-icons/mobirise-icons');
    echo $this->Html->css('tether/tether.min');
    //echo $this->Html->css('bootstrap/css/bootstrap.min');
    echo $this->Html->css('bootstrap/4.3.1/css/bootstrap.min');
    echo $this->Html->css('bootstrap/css/bootstrap-grid.min');
    echo $this->Html->css('bootstrap/css/bootstrap-reboot.min');
    echo $this->Html->css('dropdown/css/style');
    echo $this->Html->css('socicon/css/styles');
    echo $this->Html->css('theme/css/style');
    echo $this->Html->css('mobirise/css/mbr-additional');
    
    echo $this->Html->css('font-awesome/css/font-awesome.min.css');
    ?>
    
<?php 
$this->fetch('css');
echo $this->fetch('css_top');
?>
  
</head>
<body>

    <?php echo $this->fetch('content'); ?>
    
    <?php
    echo $this->Html->script('web/assets/jquery/jquery.min');
    echo $this->Html->script('popper/popper.min');
    echo $this->Html->script('tether/tether.min');
    //echo $this->Html->script('bootstrap/js/bootstrap.min');
    echo $this->Html->script('bootstrap/4.3.1/js/bootstrap.min');
    //echo $this->Html->script('smoothscroll/smooth-scroll');
    echo $this->Html->script('dropdown/js/script.min');
    echo $this->Html->script('touchswipe/jquery.touch-swipe.min');
    echo $this->Html->script('masonry/masonry.pkgd.min');
    echo $this->Html->script('theme/js/script');
    ?>
  
    <?= $this->fetch('script');?>
    <?= $this->fetch('script_bottom');?>
    <?= $this->fetch('script_internal');?>
  
</body>
</html>