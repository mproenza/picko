<?php use App\Model\Entity\SharedTravel;?>

<nav id="nav-routes" class="navbar navbar-light bg-light" data-toggle="sticky-onscroll">
    <a class="navbar-brand" href="#"><b><?php echo __d('home', 'Reservar un taxi saliendo desde:')?></b></a>
    <ul class="nav nav-pills">
        <?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
            <?php if(!isset($locality['use_as_origin']) || $locality['use_as_origin']):?>
            <li class="nav-item">
                <a class="dropdown-item show-routes" href="#taxi-from-<?php echo str_replace(' ', '-', $locality['name'])?>"><?php echo $locality['name']?></a>
            </li>
            <?php endif;?>
        <?php endforeach?>
    </ul>
</nav>

<?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
    <?php if(!isset($locality['use_as_origin']) || $locality['use_as_origin']):?>
    <div class="row" style="margin-top: 60px;">
        <div id="taxi-from-<?php echo str_replace(' ', '-', $locality['name'])?>" style="padding: 10px" class="col-md-12">
            <big><?php echo __d('home', 'Rutas de taxi desde {0}', '<code><big><big>'.$locality['name'].'</big></big></code>')?></big>
        </div>
        <br/>

        <?php foreach (SharedTravel::$routes as $route):?>
            <?php if($route['origin_id'] == $locality_id && ( !isset($route['active']) || $route['active'] )):?>
                <div class="col-md-4 col-sm-6" style="padding: 20px"><?php echo $this->element('widgets/route_info', compact('route') + compact('doBootbox'))?></div>
            <?php endif?>
        <?php endforeach?>
    </div>

    <br/>
    <br/>
    <?php endif;?>
<?php endforeach?>