<?php
/**
 * Created by PhpStorm.
 * User: niceinkeaw
 * Date: 15/5/2559
 * Time: 19:38
 */
$tid = getIsset('tid');
$task = $conn->select('task',array('tid'=>$tid),true);

?>

<section class="content-header">
    <h1>
        Task Result
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div id="task_info" class="element">
                <?=($task['is_abf'] == 'y')?'<div class="abf_bg"></div><div class="abf">ABF</div>':''?>

                <div class="date"><?=strtoupper(date('d M Y', strtotime($task_date)))?></div>

                <div class="side">
                    <div class="label">ARM SIDE</div>
                    <div class="value"><?=($task['side']=='l')?'Left':'Right'?></div>
                </div>

                <div class="target_angle">
                    <div class="label">TARGET ANGLE</div>
                    <div class="value"><?=$task['target_angle']?>&deg;</div>
                </div>

                <div class="num_of_round">
                    <div class="label">ROUND</div>
                    <div class="value"><?=$task['score']?> <span class="small">/ <?=$task['number_of_round']?></span></div>
                </div>

                <div class="perform_datetime">
                    <div class="label">PERFORM DATETIME</div>
                    <div class="value"><?=strtoupper(date('d M Y | H:i', strtotime($task['perform_datetime'])))?></div>
                </div>
            </div>
        </div>
    </div>
</section>
