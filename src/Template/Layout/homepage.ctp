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
        echo $this->Html->meta('icon');

        echo $this->Html->css('default');
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('font-awesome/css/font-awesome.min.css');
        echo $this->Html->css('home');        
        echo $this->Html->css('sticky');
        
        // META HREFLANG
        if(isset($meta['hreflang']) && $meta['hreflang']) echo $this->Html->hreflang($this->request);
        
        $this->fetch('meta');
        $this->fetch('css');
        echo $this->fetch('css_top');
        ?>
    </head>
    <body body data-spy="scroll" data-target="#nav-routes" data-offset="250">
        <?php echo $this->fetch('content'); ?>
        
        <?php
        echo $this->Html->script('jquery');
        echo $this->Html->script('popper');
        echo $this->Html->script('bootstrap');
        echo $this->Html->script('bootbox');
        echo $this->Html->script('sticky');
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
        
    </body>
</html>