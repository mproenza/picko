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

        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('default');
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('font-awesome/css/font-awesome.min.css');
        echo $this->Html->css('home');
        
        echo $this->Html->css('sticky');
        //echo $this->Html->css('sticky.ini');
        
        echo $this->Html->script('jquery');
        echo $this->Html->script('popper');
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('bootbox');
        
        $this->fetch('meta');
        $this->fetch('css');
        $this->fetch('script');
        ?>
    </head>
    <body body data-spy="scroll" data-target="#nav-routes" data-offset="250">
        <?php echo $this->fetch('content'); ?>
        
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
            
            $(document).ready(function(){
                var offset = 20;
            
                var scrollTop = $(window).scrollTop();
                if (scrollTop >= offset) {
                    $('#navbar').addClass('scrolled');
                } else if (scrollTop < offset) {
                    $('#navbar').removeClass('scrolled');
                }
                
                $(window).scroll(function(){
                    scrollTop = $(window).scrollTop();
                        $('.counter').html(scrollTop);

                    if (scrollTop >= offset) {
                        $('#navbar').addClass('scrolled');
                    } else if (scrollTop < offset) {
                        $('#navbar').removeClass('scrolled');
                    } 
                });
            });
            
            // Hacer que el scrollspy se mueva con un offset segun lo definido en el body cuando se le da click al nav item de una ruta
            $('.navbar li a.show-routes').click(function(event) {
                //window.location.hash = $(this).attr('href');
                event.preventDefault();
                $($(this).attr('href'))[0].scrollIntoView();
                scrollBy(0, -170);
            });
            
        </script>

        <?php echo $this->Html->script('sticky');?>
        
    </body>
</html>