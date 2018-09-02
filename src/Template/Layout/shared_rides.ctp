<?php use Cake\Core\Configure; use \Cake\I18n\I18n?>

<!DOCTYPE html>
<html>
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php if(is_callable($meta['title'])) $meta['title'] = $meta['title']($this->viewVars, $this->request);?>
        <title><?php echo $meta['title'].' | '.'PickoCar'?></title>
        
        <?php if(is_callable($meta['description'])) $meta['description'] = $meta['description']($this->viewVars, $this->request);?>
        <meta name="description" content="<?php echo $meta['description'];?>"/>
        
        <?php
        // ROBOTS NOINDEX
        if(isset($meta['robots-index']) && !$meta['robots-index']) echo '<meta name="robots" content="noindex"/>';
        ?>

        <style type="text/css">
            
            #navbar {
                background-color: #003f54 !important;
            }
            
            .navbar-nav a.nav-link {
                color:white !important;
                text-transform:uppercase
            }
            .navbar-nav a.nav-link:hover,#navbar #nav a.nav-link:focus{
                background-color:transparent;
                text-decoration:none
            }
        </style>

        <?php
        // META
        echo $this->Html->meta('icon');

        echo $this->Html->css('default');
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('font-awesome/css/font-awesome.min.css');
        
        // META HREFLANG
        if(isset($meta['hreflang']) && $meta['hreflang']) echo $this->Html->hreflang($this->request);
        
        $this->fetch('meta');
        $this->fetch('css');
        echo $this->fetch('css_top');
        ?>
    </head>
    <body>
        <div id="container">
            <?php echo $this->element('menu')?>

            <div id="content">
                
                <div style="height: 90px;clear: both"></div>
                <?php echo $this->fetch('content'); ?>
                
                
                <div style="height: 90px;clear: both"></div>
                <hr/>
                <footer class="footer white" style="background-color: #003f54 !important">
                    <div class="col-md-12">
                        <?php echo $this->element('footer') ?>
                    </div>
                </footer>
            </div>
        </div>
        
        <?php
        echo $this->Html->script('jquery');
        echo $this->Html->script('popper');
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('bootbox');
        ?>
        <?= $this->fetch('script');?>
        <?= $this->fetch('script_bottom');?>
        <?= $this->fetch('script_internal');?>
        <script type="text/javascript">
            function goTo(id, time, offset) {
                $('html, body').animate({
                    scrollTop: $('#' + id).offset().top + offset
                }, time);
            };
            
            $(document).ready(function() {
                
                $.each($('.info'), function(pos, obj) {
                    var placement = 'bottom';
                    if($(obj).attr('data-placement') !== undefined) placement = $(obj).attr('data-placement');
                    $(obj).tooltip({placement:placement, html:true});
                });
                
                <?php if (isset($this->request->query['highlight'])): ?>
                    goTo('<?php echo $this->request->query['highlight'] ?>', 500, -70);  
                <?php endif ?>
                    
                // Hacer que el formulario de solicitud se abra
                $( ".open-request-form" ).click(function( event ) {
                    event.preventDefault();

                    bootbox.dialog({
                        title:$(this).data('title'), 
                        message:$( '#' + $(this).data('modal') ).html(), 
                        size:'large',
                        onEscape:true
                    });

                    form = $('.bootbox form');
                    
                    datepicker = form.find('.datepicker');
                    datepicker.datepicker({
                        format: "dd/mm/yyyy",
                        language: '<?php echo I18n::getLocale()?>',
                        startDate: '+2d',
                        todayBtn: "linked",
                        autoclose: true,
                        todayHighlight: false
                    });

                    form.submit(function(event) {
                        if (this.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        this.classList.add('was-validated');
                    });

                });
            });
        </script>

    </body>
</html>