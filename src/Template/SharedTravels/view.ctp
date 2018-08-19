<?php
use App\Model\Entity\SharedTravel;
use App\Util\TimeUtil;
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <?php echo __d('shared_travels', 'Transfer desde {0} hasta {1} el {2}', '<code><big>'.$request['SharedTravel']['origin'].'</big></code>', '<code><big>'.$request['SharedTravel']['destination'].'</big></code>', '<code><big>'.TimeUtil::prettyDate($request['SharedTravel']['date'], false).'</big></code>')?>
            <hr/>
        </div>
        <div class="col-md-8 col-md-offset-1">
            <?php echo $this->element('shared_travel', compact('request'))?>
        </div>

        <div class="col-md-3">
            <?php echo $this->element('suggest_transfers', ['route'=>$request['SharedTravel']])?>
        </div>
    </div>
</div>