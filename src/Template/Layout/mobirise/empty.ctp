<?php use Cake\Core\Configure; use \Cake\I18n\I18n;?>

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

    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    

    <?php if(is_callable($meta['title'])) $meta['title'] = $meta['title']($this->viewVars, $this->request);?>
    <title><?php echo $meta['title'].' | '.'PickoCar'?></title>

    <?php if(is_callable($meta['description'])) $meta['description'] = $meta['description']($this->viewVars, $this->request);?>
    <meta name="description" content="<?php echo $meta['description'];?>"/>
  
  
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
  <link rel="stylesheet" href="assets/tether/tether.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/socicon/css/styles.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <?= $this->Html->css('font-awesome/css/font-awesome.min.css');?>
    
<?php 
$this->fetch('meta');
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

  <script src="assets/web/assets/jquery/jquery.min.js"></script>
  <script src="assets/popper/popper.min.js"></script>
  <script src="assets/tether/tether.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/smoothscroll/smooth-scroll.js"></script>
  <script src="assets/dropdown/js/script.min.js"></script>
  <!--<script src="assets/vimeoplayer/jquery.mb.vimeo_player.js"></script>-->
  <script src="assets/parallax/jarallax.min.js"></script>
  <script src="assets/viewportchecker/jquery.viewportchecker.js"></script>
  <script src="assets/mbr-switch-arrow/mbr-switch-arrow-martin.js"></script>
  <script src="assets/touchswipe/jquery.touch-swipe.min.js"></script>
  <script src="assets/theme/js/script.js"></script>
    
    <?= $this->Html->script('bootbox');?>
  
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
                onEscape:true
            });

            form = $('.bootbox form');

            datepicker = form.find('.datepicker');
            datepicker.datepicker({
                format: "dd/mm/yyyy",
                language: '<?php echo I18n::getLocale()?>',
                startDate: '<?php if(!$Auth->user()):?>+2d<?php else:?>today<?php endif;?>',
                todayBtn: "linked",
                autoclose: true,
                todayHighlight: false
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