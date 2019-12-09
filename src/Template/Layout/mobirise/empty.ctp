<?php use Cake\Core\Configure; use \Cake\I18n\I18n;?>

<?php
Configure::write('App.cssBaseUrl', 'assets/');
Configure::write('App.jsBaseUrl', 'assets/');
Configure::write('App.imageBaseUrl', 'assets/images/');
?>

<!DOCTYPE html>
<html  >
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
<style type="text/css">            
    .shake {
        -webkit-animation-name: spacedshake;
        -webkit-animation-duration: 5s;
        -webkit-transform-origin:50% 50%;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: linear;
    }
    @-webkit-keyframes spacedshake {
        0% { -webkit-transform: translate(2px, 1px) rotate(0deg); }
        2% { -webkit-transform: translate(-1px, -2px) rotate(-1deg); }
        4% { -webkit-transform: translate(-3px, 0px) rotate(1deg); }
        6% { -webkit-transform: translate(0px, 2px) rotate(0deg); }
        8% { -webkit-transform: translate(1px, -1px) rotate(1deg); }
        10% { -webkit-transform: translate(-1px, 2px) rotate(-1deg); }
        12% { -webkit-transform: translate(-3px, 1px) rotate(0deg); }
        14% { -webkit-transform: translate(2px, 1px) rotate(-1deg); }
        16% { -webkit-transform: translate(-1px, -1px) rotate(1deg); }
        18% { -webkit-transform: translate(2px, 2px) rotate(0deg); }
        20% { -webkit-transform: translate(1px, -2px) rotate(-1deg); }
        22% { -webkit-transform: translate(2px, 1px) rotate(0deg); }
    }
</style>
  
  
  
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
    echo $this->Html->script('parallax/jarallax.min');
    echo $this->Html->script('viewportchecker/jquery.viewportchecker');
    echo $this->Html->script('mbr-switch-arrow/mbr-switch-arrow-martin');
    echo $this->Html->script('touchswipe/jquery.touch-swipe.min.js');
    echo $this->Html->script('theme/js/script');
    ?>
    
    <?= $this->Html->script('bootbox/5.1.1/bootbox.min');?>
  
    <?= $this->fetch('script');?>
    <?= $this->fetch('script_bottom');?>
    <?= $this->fetch('script_internal');?>

<script type="text/javascript">
    $(document).ready(function() {

        // Hacer que el formulario de solicitud se abra
        $( ".open-request-form" ).click(function( event ) {
            event.preventDefault();

            bootbox.dialog({
                title:$(this).data('title'), 
                message:$( '#' + $(this).data('open-form') ).html(), 
                size:'large',
                onEscape:true,
                size: 'lg',
                show: false
            })
            .off("shown.bs.modal")
            .modal("show");

            form = $('.bootbox form');

            datepicker = form.find('.datepicker');
            datepicker.datepicker({
                format: "dd/mm/yyyy",
                language: '<?php echo I18n::getLocale()?>',
                startDate: '<?php if(!$Auth->user()):?>+2d<?php else:?>today<?php endif;?>',
                //todayBtn: "linked",
                autoclose: true,
                todayHighlight: false,
                datesDisabled:['31/12/2019', '01/01/2020', '31/12/2020', '01/01/2021']
            });

            form.submit(function(event) {
                if (this.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    var submit = $(this).find('input[type=submit]');
                    submit.attr('disabled', true);
                    submit.val('<?= __('Enviando solicitud')?> ...');
                }

                this.classList.add('was-validated');
            });

        });
    });

</script>
  
</body>
</html>