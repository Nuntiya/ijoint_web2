<?php
/**
 * Created by PhpStorm.
 * User: niceinkeaw
 * Date: 15/5/2559
 * Time: 14:10
 */
$sql_task = "select * from task where pid = $pid and status <> 'x' order by date desc, tid desc";
$tasks = $conn->queryRaw($sql_task);

?>
<section class="content-header">
    <h1>
        All Task
        <small>Represent by exercise type</small>
    </h1>
</section>
<br/>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Flexion</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Horizontal Flexion</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Extension</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php
                        $exercise_type = "f";
                        include 'tasks_each_type.inc.php';
                        ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <?php
                        $exercise_type = "h";
                        include 'tasks_each_type.inc.php';
                        ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <?php
                        $exercise_type = "e";
                        include 'tasks_each_type.inc.php';
                        ?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>
</section>
<script type="text/javascript">
    function deleteTask(id){
        if (confirm("Are you sure you want to delete this task?"))
            window.location = 'delete_task.php?pid=<?=$pid?>&tid=' + id;
    }
</script>
