<?php
$sql = 'select count(*) as task_count_side from task
where pid = %s and side = "%s"';

$right_count = $conn->queryRaw(sprintf($sql, $pid, 'r'), true)['task_count_side'];
$left_count = $conn->queryRaw(sprintf($sql, $pid, 'l'), true)['task_count_side'];
?>
<section class="content-header">
    <h1>
        Dashboard
        <small>Overview all about patient</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-arrow-left-a"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Left Hand</span>
                    <span class="info-box-number"><?php echo $left_count; ?>
                        <small> of tasks</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-arrow-right-a"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Right Hand</span>
                    <span class="info-box-number"><?php echo $right_count; ?>
                        <small> of tasks</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Tasks overall progress</h3>
                </div>

                <form role="form" lpformnum="1">
                    <div id="progressContainer"></div>
                </form>
                <br/>
            </div>
        </div>


    </div>
</section>

<script src="js/progressbar.min.js"></script>
<script type="text/javascript">

    $(function () {
       var bar = new ProgressBar.Circle(progressContainer, {
            color: '#aaa',
            // This has to be the same size as the maximum width to
            // prevent clipping
            strokeWidth: 15,
            trailWidth: 15,
            easing: 'easeInOut',
            duration: 1400,
            text: {
                autoStyleContainer: false
            },
            from: {color: '#aaa', width: 15},
            to: {color: '#1CABF7', width: 15},
            // Set default step function for all animate calls
            step: function (state, circle) {
                circle.path.setAttribute('stroke', state.color);
                circle.path.setAttribute('stroke-width', state.width);

                var value = Math.round(circle.value() * 100);
                if (value === 0) {
                    circle.setText('');
                } else {
                    circle.setText(value + "%");
                }

            }
        });
        bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
        bar.text.style.fontSize = '2rem';

        //bar.animate(0.821);  // Number from 0.0 to 1.0
        loadTaskProgress(bar);
    });

    function loadTaskProgress(bar) {
        $.ajax(
            {
                url : "app/patient_api.php",
                method : "POST",
                data : {"action":"get_patient_overall_progress","pid":"<?php echo $pid;?>"},
                success : function(result){
                    var obj = JSON.parse(result);
                    bar.animate(obj.progress*0.01);
                }
            }
        );
    }
</script>
