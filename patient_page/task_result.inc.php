<?php
/**
 * Created by PhpStorm.
 * User: niceinkeaw
 * Date: 15/5/2559
 * Time: 19:38
 */
$tid = getIsset('tid');
$pid = getIsset('pid');
$task = $conn->select('task', array('tid' => $tid), true);


$time_list = array();
$angle_list = array();

$SQL = "SELECT * FROM result_item WHERE tid = ".$tid." ORDER BY iid ";
$query = $conn->queryRaw($SQL);

foreach($query as $row) {
    $time_list[] = number_format(($row['time'] / 1000), 1);
    $angle_list[] = $row['angle'];
}
?>



<link rel="stylesheet" type="text/css" href="css/result.css">
<section class="content-header">
    <h1>
        Task Result
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-8">

            <div id="task_info" class="element">
                <?= ($task['is_abf'] == 'y') ? '<div class="abf_bg"></div><div class="abf">ABF</div>' : '' ?>

                <div class="date"><?= strtoupper(date('d M Y', strtotime($task_date))) ?></div>

                <div class="side">
                    <div class="label">ARM SIDE</div>
                    <div class="value"><?= ($task['side'] == 'l') ? 'Left' : 'Right' ?></div>
                </div>

                <div class="target_angle">
                    <div class="label">TARGET ANGLE</div>
                    <div class="value"><?= $task['target_angle'] ?>&deg;</div>
                </div>

                <div class="num_of_round">
                    <div class="label">ROUND</div>
                    <div class="value"><?= $task['score'] ?> <span
                            class="small">/ <?= $task['number_of_round'] ?></span></div>
                </div>

                <div class="perform_datetime">
                    <div class="label">PERFORM DATETIME</div>
                    <div
                        class="value"><?= strtoupper(date('d M Y | H:i', strtotime($task['perform_datetime']))) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div id="chartContainer"></div>
        </div>
    </div>
</section>
<script src="js/fusioncharts.js"></script>
<script src="js/fusioncharts.charts.js"></script>
<script src="js/themes/fusioncharts.theme.fint.js"></script>
<script>
    FusionCharts.ready(function(){
        var revenueChart = new FusionCharts({
            "type": "msline",
            "renderAt": "chartContainer",
            "width": "100%",
            "height": "550",
            "dataFormat": "json",
            "dataSource": {
                "chart": {
                    "xAxisName": "Time (second)",
                    "yAxisName": "Angle (degrees)",
                    "theme": "fint",
                    "showValues": "0"
                },
                "categories": [
                    {
                        "category": [
                            <?
                            foreach ($time_list as $k => $time){
                            ?>
                            {
                                "label": "<?=$time?>"
                            }
                            <?
                            if ($k != count($time_list) - 1)
                                echo ',';
                            }
                            ?>
                        ]
                    }
                ],
                "dataset": [
                    {
                        "data": [
                            <?
                            foreach ($angle_list as $k => $angle){
                            ?>
                            {
                                "value": "<?=$angle?>"
                            }
                            <?
                            if ($k != count($angle_list) - 1)
                                echo ',';
                            }
                            ?>
                        ]
                    }
                ]
            }
        });

        revenueChart.render();
    })
</script>
