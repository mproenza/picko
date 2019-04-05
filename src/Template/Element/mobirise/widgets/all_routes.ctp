<?php use App\Model\Entity\SharedTravel;?>

<?php foreach (SharedTravel::$localities as $locality_id => $locality):?>
    <?php if(!isset($locality['use_as_origin']) || $locality['use_as_origin']):?>
        <div class="card">
            <div class="card-header" role="tab" id="heading-<?= $locality['slug']?>">
                <a role="button" class="panel-title collapsed text-black" data-toggle="collapse" data-core="" href="#taxi-from-<?= $locality['slug']?>" aria-expanded="false" aria-controls="collapse1">
                    <h4 class="mbr-fonts-style display-5">
                        <span class="sign mbr-iconfont fa fa-caret-down inactive"></span>
                        <?= __d('/mobirise/home', 'Taxi <b>desde {0}</b> hasta ...', $locality['name'])?>
                        <?php if(isset($locality['new']) && $locality['new']):?>
                            <small><span class="badge badge-success align-top pull-right"><?php echo __d('/mobirise/default', 'NUEVA RUTA')?></span></small>
                        <?php endif?>
                    </h4>
                </a>
            </div>
            <div id="taxi-from-<?= $locality['slug']?>" class="panel-collapse noScroll collapse " role="tabpanel" aria-labelledby="heading-<?= $locality['slug']?>">
                <div class="panel-body p-4">
                    <div class="media-container-row">
                        
                        <div style="padding:10px !important" class="row cid-rmpjJdkBhF justify-content-center">
                        <?php foreach (SharedTravel::$routes as $route):?>
                            <?php if($route['origin_id'] == $locality_id && ( !isset($route['active']) || $route['active'] )):?>
                                <div class="plan col-12 mx-2 my-2 justify-content-center col-lg-4"><?php echo $this->element('mobirise/widgets/route_info', compact('route') + compact('doBootbox'))?></div>
                            <?php endif?>
                        <?php endforeach?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
<?php endforeach?>