<?php
/**
 * Created by PhpStorm.
 * User: niceinkeaw
 * Date: 15/5/2559
 * Time: 17:31
 */
?>

<div id="task">
    <div class="list">
        <?
        foreach ($tasks as $task) {
            $side = ($task['side'] == 'l') ? 'Left' : 'Right';
            $status = $task['status'];
            $status_icon = ($task['status'] == 'd') ? 'complete' : 'progress';
            if($task['exercise_type'] != $exercise_type)
                continue;
            ?>
            <div class="element<?= ($status == 'd') ? ' complete' : '' ?>">
                <?= ($task['is_abf'] == 'y') ? '<div class="abf_bg"></div><div class="abf">ABF</div>' : '' ?>
                <div
                    class="date"><?= strtoupper(date('d M Y', strtotime($task['date']))) ?></div>

                <div class="side">
                    <div class="label">ARM SIDE</div>
                    <div class="value"><?= $side ?></div>
                </div>

                <div class="target_angle">
                    <div class="label">TARGET ANGLE</div>
                    <div class="value"><?= $task['target_angle'] ?>&deg;</div>
                </div>

                <div class="num_of_round">
                    <div class="label">NUMBER OF ROUND</div>
                    <div class="value"><?= $task['number_of_round'] ?></div>
                </div>

                <div class="check">
                    <img src="images/icon-<?= $status_icon ?>.png"/>
                </div>

                <div class="row-option">
                    <a type="button" class="btn btn-block btn-success <?= ($status != 'd') ? ' disabled' : ' result' ?>" href="patient.php?pageId=task_result&pid=<?= $pid ?>&tid=<?= $task['tid'] ?>">Result</a>
                    <a type="button" class="btn btn-block btn-warning <?= ($status == 'd') ? ' disabled' : '' ?>" href="patient.php?pageId=task_edit&pid=<?= $pid ?>&tid=<?= $task['tid'] ?>">Edit</a>
                    <a type="button" class="btn btn-block btn-danger" onclick="javascript:deleteTask('<?php echo $task['tid']; ?>')">Delete</a>
                </div>


            </div>
        <? } ?>

        <? if (count($tasks) == 0) { ?>
            <div class="element notask">
                Don't have any task yet
            </div>
        <? } ?>
    </div>
</div>
