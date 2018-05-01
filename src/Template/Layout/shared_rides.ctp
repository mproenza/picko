<?php use Cake\Core\Configure; use \Cake\I18n\I18n?>

<!DOCTYPE html>
<html>
    <head>
        <?php if (ROOT != 'C:\xampp\htdocs\pickocar'): ?>
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
        
        <?php if(is_callable($page_title)) $page_title = $page_title($this->viewVars, $this->request->query);?>
        <title><?php echo $page_title.' | '.'PickoCar'?></title>
        
        <?php if(is_callable($page_description)) $page_description = $page_description($this->viewVars, $this->request->query);?>
        <meta name="description" content="<?php echo $page_description;?>"/>

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
        
        echo $this->Html->script('jquery');
        echo $this->Html->script('popper');
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('bootbox');
        
        $this->fetch('meta');
        $this->fetch('css');
        $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="navbar">
                <a class="navbar-brand white" href="#">PickoCar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php echo $this->Html->lang(I18n::getLocale(), $this->request) ?>
                        <?php echo $this->Html->link(__d('shared_travels', 'IR AL INICIO'), ['_name'=>'homepage'], array('class' => 'nav-link', 'escape' => false)); ?>
                        <?php echo $this->Html->link('<button type="button" class="btn btn-info navbar-btn">' . __d('shared_travels', 'VER RUTAS DISPONIBLES') . '</button>', ['_name'=>'homepage', '#'=>'transfers-available'], array('escape' => false, 'style' => 'padding:0px;padding-right:10px')) ?>
                        <?php echo $this->User->logout();?>
                    </div>
                </div>
            </nav>

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

                    bootbox.dialog({title:$(this).data('title'), message:$( '#' + $(this).data('modal') ).html(), size:'large'});

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