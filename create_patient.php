<?php
session_start();


require_once "dbconnect.php";
$cuss_date = Date('Y/m/d');
$cmd = getIsset("__cmd");

$firstname = getIsset("firstname");
$lastname = getIsset("lastname");
$username = getIsset("username");
$password = getIsset("password");
$email = getIsset("email");
$gender = getIsset("gender");
$side = getIsset("side");
$dob = getIsset("dob");
$error = false;

if ($cmd == "create") {

    $value = array(
        "firstname" => $firstname
    , "lastname" => $lastname
    , "username" => $username
    , "password" => md5($password)
    , "email" => $email
    , "gender" => $gender
    , "dob" => $dob
    );

    $chk_insert = $conn->select('patient', array('username' => $username));
    if ($chk_insert == null) {
        $create_result = $conn->create("patient", $value);
        if ($create_result) {
            $angles = array('90', '120', '150');
            $pid = $conn->getLastInsertId();
            foreach ($angles as $angle) {

                $value_1 = array(
                    "pid" => $pid
                , "date" => $cuss_date
                , "side" => $side
                , "target_angle" => $angle
                , "number_of_round" => '10'
                , "is_abf" => 'n'
                , "status" => 'c'
                );

                $value_2 = array(
                    "pid" => $pid
                , "date" => $cuss_date
                , "side" => $side
                , "target_angle" => $angle
                , "number_of_round" => '10'
                , "is_abf" => 'y'
                , "status" => 'c'
                );
                $create_result_task1 = $conn->create("task", $value_1);
                $create_result_task2 = $conn->create("task", $value_2);
                if (!$create_result_task1 || !$create_result_task2) {
                    $error = true;
                }

            }

        } else {
            $error = true;
        }


        if (!$error) {
            header('Location: select_patient.php');
            exit();
        } else {
            echo "<script>alert('Error for Create Patient!! ');</script>";
        }


    } else {
        echo "<script>alert('Username is Duplicate!! ');</script>";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="dist/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <!--    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.css" rel="stylesheet" type="text/css"/>
    <link href="Styles/pagerStyle.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="dist/css/skins/_all-skins.css" rel="stylesheet" type="text/css"/>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="css/select_patient.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css">


</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "navbar.php" ?>
    <?php include "sidebar.php" ?>

    <div class="content-wrapper  skin-blue ">
        <form id="form_data" name="form_data" method="post" action="create_patient.php" class="form-horizontal">

            <input id="__cmd" name="__cmd" type="hidden" value="">


            <section class="content-header">
                <h1>
                    Create Patient
                </h1>
            </section>
            <section class="content">

                <div class="col-sm-6">

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create New Patient</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group">

                                <label for="inputPassword3" class="col-sm-3 control-label">First Name :</label>

                                <div class="col-sm-9">


                                    <input type="text" name="firstname" id="firstname" class="form-control" value=""
                                           required="true">


                                </div>
                            </div>

                            <div class="form-group">

                                    <label for="inputPassword3" class="col-sm-3 control-label"> Last Name :</label>


                                <div class="col-sm-9">
                                    <input type="text" name="lastname" id="lastname" class="form-control" value=""
                                           onblur="trimValue(this);" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">  E-mail :</label>

                                <div class="col-sm-9">
                                    <input type="text" name="email" id="email" class="form-control" value=""
                                           onblur="trimValue(this);chkEmail(this);" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">   Date of Birth :</label>

                                <div class="col-sm-9">
                                    <input type="text" name="dob" id="datepicker" class="form-control"
                                           value=""
                                           onblur="trimValue(this);" required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">   Gender :</label>

                                <div class="col-sm-9">

                                    <label class="radio-inline"><input type="radio" name="gender" id="male"
                                                                       value="m">Male</label>
                                    <label class="radio-inline"><input type="radio" name="gender" id="female"
                                                                       value="f">Female</label>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">   Side :</label>

                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" name="side" id="side_l"
                                                                       value="l">Left</label>
                                    <label class="radio-inline"><input type="radio" name="side" id="side_r"
                                                                       value="r">Right</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">   Username :</label>

                                <div class="col-sm-9">
                                    <input type="text" name="username" id="username" class="form-control" value=""
                                           onblur="trimValue(this);" onkeypress="chkNotThaiChaOnly(event);"
                                           required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">   Password :</label>

                                <div class="col-sm-9">
                                    <input type="password" name="password" id="password" class="form-control" value=""
                                           onblur="trimValue(this);" onkeypress="chkNotThaiChaOnly(event);"
                                           required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">   Confirm Password :</label>

                                <div class="col-sm-9">
                                    <input type="password" name="confirm_password" id="confirm_password"
                                           class="form-control"
                                           value=""
                                           onblur="trimValue(this);" onkeypress="chkNotThaiChaOnly(event);"
                                           required="true">
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">

                            <a class="btn btn-warning " href="javascript:goClear()">Clear</a>
                            <a class="btn btn-info pull-right" href="javascript:goSave();">Create</a>
                        </div>
                    </div>

            </section>
            <?php include "pageindex.php"; ?>
        </form>
    </div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="js/screen.js"></script>

<script src="js/jquery.datetimepicker.js"></script>
<!-- Page script -->
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

            if (firstname.value == "" || lastname.value == "" || dob.value == "" || username.value == "" || password.value == "" || confirm_password.value == "" || !checkSelection("gender")
                || !checkSelection("side")) {
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
                if (confirm_password.value == password.value) {

                    var a = new Date(dob.value);
                    var b = new Date();
                    if (fn_DateCompare(a, b) != 1) {
                        __cmd.value = "create";
                        submit();
                    } else {
                        alert("Birth date is more than date Now!!");
                    }


                } else {
                    alert("รหัสผ่านไม่ตรงกัน กรุณากรอกใหม่!!");
                    confirm_password.onfocus = true;

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

        var msDateA = Date.UTC(a.getFullYear(), a.getMonth() + 1, a.getDate());
        var msDateB = Date.UTC(b.getFullYear(), b.getMonth() + 1, b.getDate());

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
</body>
</html>


