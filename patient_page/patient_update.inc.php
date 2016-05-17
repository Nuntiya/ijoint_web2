<?php
/**
 * Created by PhpStorm.
 * User: niceinkeaw
 * Date: 15/5/2559
 * Time: 21:04
 */

$id = getIsset("pid");
$cmd = getIsset("__cmd");
$alert_message = '';

if ($cmd == "update") {
    $firstname = getIsset("firstname");
    $lastname = getIsset("lastname");

    $email = getIsset("email");
    $gender = getIsset("gender");
    $dob = getIsset("dob");



    $value = array(
        "firstname" => $firstname
    , "lastname" => $lastname
    , "email" => $email
    , "gender" => $gender
    , "dob" => $dob

    );

    $update_result = $conn->update("patient", $value,array("pid"=>$id));
    if($update_result){
        $alert_message = '<div class="alert alert-success alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <h4><i class="icon fa fa-check"></i> Update Patient Profile successfully!</h4>
           </div>';

    }

}

$select = $conn->select("patient", array('pid' => $id), true);
?>


<section class="content-header">
    <h1>
        Update Patient
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
                    <h3 class="box-title">Patient Information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="" name="form_data">
                    <input id="__cmd" name="__cmd" type="hidden" value="">
                    <input id="__id" name="__id" type="hidden" value="<?php echo $id; ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">First Name :</label>
                            <div class="col-sm-9">


                                <input type="text" name="firstname" id="firstname" class="form-control"
                                       value="<?php echo $select["firstname"]; ?>"
                                       required="true">


                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label"> Last Name :</label>
                            <div class="col-sm-9">
                                <input type="text" name="lastname" id="lastname" class="form-control"
                                       value="<?php echo $select["lastname"]; ?>"
                                       onblur="trimValue(this);" required="true">
                            </div>
                        </div>
                        <div class="form-group">

                                <label for="inputPassword3" class="col-sm-3 control-label">  E-mail :</label>
                            <div class="col-sm-9">
                                <input type="text" name="email" id="email" class="form-control"
                                       value="<?php echo $select["email"]; ?>"
                                       onblur="trimValue(this);chkEmail(this);" >
                            </div>
                        </div>

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">   Date of Birth :</label>
                                <div class="col-sm-9">
                                    <input type="text" name="dob" id="datepicker" class="form-control"
                                           value="<?php echo date('Y/m/d',strtotime($select["dob"])); ?>"
                                           required="true">
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">   Gender :</label>
                            <div class="col-sm-9">

                                <label class="radio-inline"><input type="radio" name="gender" id="male"
                                                                   value="m" <? if ($select["gender"] == "m") {
                                        echo " checked ";
                                    } ?>>Male</label>
                                <label class="radio-inline"><input type="radio" name="gender" id="female"
                                                                   value="f" <? if ($select["gender"] == "f") {
                                        echo " checked ";
                                    } ?>>Female</label>

                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="patient.php?pid=<?php echo $pid; ?>">
                            <button type="button" class="btn btn-default">Cancel</button>
                        </a>
                        <button type="submit" class="btn btn-info pull-right" onclick="goSave();">Update</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
</section>
<script src="js/jquery.datetimepicker.js"></script>
<script>
    $(function () {
        $('#datepicker').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y/m/d'
        });
    });
    function chk() {

        with (document.form_data) {

            var Rtn = true;

            if (firstname.value == "" || lastname.value == "" || dob.value == "" || !checkSelection("gender")
               ) {
                Rtn = false;
            }
            if (!Rtn) {
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            }

            return Rtn;

        }
    }
    function goSave() {
        with (document.form_data) {
            if (chk()) {
                var a = new Date(dob.value);
                var b = new Date();
                    if(fn_DateCompare(a,b) != 1){
                        __cmd.value = "update";
                        submit();
                    }else{
                        alert("Birth date is more than date Now!!");
                    }


            }

        }
    }


    function checkSelection(field) {
        var test = document.getElementsByName(field);
        var sizes = test;
        for (var i = 0; i < sizes.length; i++) {
            if (sizes[i].checked == true) {

                return true;
            }
        }
        return false;
    }

    function fn_DateCompare(DateA, DateB) {
        var a = new Date(DateA);
        var b = new Date(DateB);

        var msDateA = Date.UTC(a.getFullYear(), a.getMonth()+1, a.getDate());
        var msDateB = Date.UTC(b.getFullYear(), b.getMonth()+1, b.getDate());

        if (parseFloat(msDateA) < parseFloat(msDateB))
            return -1;  // less than
        else if (parseFloat(msDateA) == parseFloat(msDateB))
            return 0;  // equal
        else if (parseFloat(msDateA) > parseFloat(msDateB))
            return 1;  // greater than
        else
            return null;  // error
    }



</script>
