<?php use Cake\Core\Configure;?>

<!DOCTYPE html>
<html>
    <head>        
        <?php echo $this->Html->charset(); ?>
        <title><?php echo $page_title.' | '.'PickoCar'?></title>
        <meta name="description" content="<?php echo $page_description?>"/>

        <style type="text/css">

            #navbar #nav a.nav-link{
                /*color:white;*/
                font-family:'Montserrat', sans-serif;
                font-size:13px;
                /*margin-top:4px;*/
                text-transform:uppercase
            }
            #navbar #nav a.nav-link:hover,#navbar #nav a.nav-link:focus{
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
        ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>

        <script type="text/javascript">
            $(document).ready(function() {
                
                $.each($('.info'), function(pos, obj) {
                    var placement = 'bottom';
                    if($(obj).attr('data-placement') !== undefined) placement = $(obj).attr('data-placement');
                    $(obj).tooltip({placement:placement, html:true});
                });
                
                //$('.info').tooltip({placement:'bottom', html:true});
            })
        </script>
    </head>
    <body>
        <div id="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <a class="navbar-brand" href="#">PickoCar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php echo $this->Html->lang(Configure::read('App.language'), $this->request) ?>
                        <?php echo $this->Html->link(__d('shared_travels', 'IR AL INICIO'), ['_name'=>'homepage'], array('class' => 'nav-link', 'escape' => false)); ?>
                        <?php echo $this->Html->link('<button type="button" class="btn btn-info navbar-btn">' . __d('shared_travels', 'VER RUTAS DISPONIBLES') . '</button>', ['_name'=>'homepage'], array('escape' => false, 'style' => 'padding:0px;padding-right:10px')) ?>
                        <?php echo $this->User->logout();?>
                    </div>
                </div>
            </nav>

            <div id="content" class="container-fluid">
                
                <div style="height: 90px;clear: both"></div>
                <?php echo $this->fetch('content'); ?>
                
                <footer class="footer bg-light">
                    <hr/>
                    <div class="container">
                        <?php echo $this->element('footer') ?>
                    </div>
                </footer>
            </div>
        </div>

<!--<div id="features-terms" style="display: none"><?php /* echo $this->element('terms_of_service') */ ?></div>
<script type="text/javascript">
    $('#menu-features-terms').click(function(event) {
        event.preventDefault();
    
        bootbox.dialog({title:'<?php echo __d('shared_travels', 'CARACTERÍSTICAS Y TÉRMINOS DEL SERVICIO') ?>', message:$( '#' + $(this).data('modal') ).html(), size:'large'});
    });
    
 </script>-->
<!--
        <?php if (ROOT != 'C:\xamp\htdocs\pickocar' /* && (!$userLoggedIn || $userRole === 'regular') */): ?>
            
            <script language="JavaScript">
                var data = '&r=' + escape(document.referrer)
                    + '&n=' + escape(navigator.userAgent)
                    + '&p=' + escape(navigator.userAgent)
                    + '&g=' + escape(document.location.href);

                if (navigator.userAgent.substring(0,1)>'3')
                    data = data + '&sd=' + screen.colorDepth 
                    + '&sw=' + escape(screen.width+'x'+screen.height);

                document.write('<a href="http://www.1freecounter.com/stats.php?i=109722" target=\"_blank\" >');
                document.write('<img alt="Free Counter" border=0 hspace=0 '+'vspace=0 src="http://www.1freecounter.com/counter.php?i=109722' + data + '">');
                document.write('</a>');
            </script>

            
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-60694533-1', 'auto');
                ga('send', 'pageview');
            </script>

        <?php endif; ?> 
            -->

        <script type="text/javascript">
            function goTo(id, time, offset) {
                $('html, body').animate({
                    scrollTop: $('#' + id).offset().top + offset
                }, time);
            };
            
            <?php if (isset($this->request->query['highlight'])): ?>
                $(document).ready(function() {
                    goTo('<?php echo $this->request->query['highlight'] ?>', 500, -70);
                });
            <?php endif ?>
        </script>

    </body>
</html>