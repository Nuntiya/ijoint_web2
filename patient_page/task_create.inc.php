<?php
/**
 * Created by PhpStorm.
 * User: niceinkeaw
 * Date: 15/5/2559
 * Time: 20:01
 */
$tid = getIsset('tid');
$cmd = getIsset('__cmd');
$alert_message = '';
if($cmd == 'save'){
    $values = array('pid'=>getIsset('pid'),
        'date'=>getIsset('date'),
        'side'=>getIsset('side'),
        'exercise_type'=>getIsset('exercise_type'),
        'target_angle'=>getIsset('target_angle'),
        'number_of_round'=>getIsset('number_of_round'),
        'status'=>'c',
        'is_abf'=>getIsset('is_abf'));
    $conn->create('task',$values);

    $alert_message = '<div class="alert alert-success alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <h4><i class="icon fa fa-check"></i> Create task successfully!</h4>
           </div>';
}

$task = $conn->select('task', array('tid' => $tid), true);
?>

<section class="content-header">
    <h1>
        Create Task
    </h1>
</section>
<section class="content">
   <div class="row">
       <div class="col-md-6">
           <?php echo $alert_message;?>
       </div>
   </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Task Detail</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="">
                    <input type="hidden" name="__cmd" value="save"/>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Date</label>

                            <div class="col-sm-8">
                                <input type="text" name="date" class="form-control" id="datepicker" placeholder="Date" autocomplete="off" value="<?php echo date('Y/m/d', strtotime('+1 day'))?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Arm Side</label>

                            <div class="col-sm-8">
                                <select name="side" class="form-control">
                                    <option value="l">Left</option>
                                    <option value="r">Right</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Exercise Type</label>

                            <div class="col-sm-8">
                                <select name="exercise_type" class="form-control">
                                    <option value="f">Flexion</option>
                                    <option value="h">Horizontal
                                        Flexion
                                    </option>
                                    <option value="e">Extension
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Target Angle</label>

                            <div class="col-sm-8">
                                <input type="number" name="target_angle" class="form-control num" id="date" placeholder="Target Angle"
                                       autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Number of Round</label>

                            <div class="col-sm-8">
                                <input type="number" name="number_of_round" class="form-control num" id="date" placeholder="Number of Round"
                                       autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">ABF</label>

                            <div class="col-sm-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="is_abf" id="optionsRadios2" value="y" >
                                        Yes
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="is_abf" id="optionsRadios2" value="n" checked="checked">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">

                        <button type="submit" class="btn btn-info pull-right">Create</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>

    </div>
</section>
<script src="js/jquery.datetimepicker.js"></script>
<script>
    $(function(){
        $('#datepicker').datetimepicker({
            datepicker: true,
            timepicker:false,
            format: 'Y/m/d',
            defaultDate: '<?php echo date("Y/m/d", strtotime($task['date']))?>',
            minDate:'0'
        });
    });
</script>
