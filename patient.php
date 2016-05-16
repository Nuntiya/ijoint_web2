<?php
session_start();
require_once "dbconnect.php";
$pid = getIsset('pid');
$pageId = getIsset('pageId');
$patient = $conn->select('patient', array('pid' => $pid), true);
$pageInclude = 'patient_page/patient_dashboard.inc.php';

if ($pageId == 'tasks')
    $pageInclude = 'patient_page/patient_tasks.inc.php';
if($pageId == 'task_result')
    $pageInclude = 'patient_page/task_result.inc.php';
if($pageId == 'task_edit')
    $pageInclude = 'patient_page/task_edit.inc.php';
if($pageId == 'update')
    $pageInclude = 'patient_page/patient_update.inc.php';
if($pageId == 'task_create')
    $pageInclude = 'patient_page/task_create.inc.php';


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
    <link rel="stylesheet" type="text/css" href="css/tasks.css">
    <link rel="stylesheet" type="text/css" href="css/result.css">
    <link rel="stylesheet" type="text/css" href="css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css">

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "navbar.php" ?>
    <?php include "include/patient_sidebar.php" ?>
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
    <div class="content-wrapper skin-blue">
        <?php require_once $pageInclude; ?>
    </div>
</div>

<script type="text/javascript">
    var pageId = '<?php echo $pageId?>';
    $(function () {
        if (pageId == 'tasks' || pageId == 'task_result' || pageId == 'task_edit' || pageId == 'task_create'){
            activeMenu('menu-patient-tasks');
            if(pageId == 'task_create')
                activeMenu('menu-create-task');
            if(pageId != 'task_create')
                activeMenu('menu-all-task');
        }
        if (pageId == 'update')
            activeMenu('menu-patient-update');
        if (pageId == '')
            activeMenu('menu-patient-dashboard');
    });

    function activeMenu(liMenuId) {
        $('#' + liMenuId).addClass('active')
    }
</script>
</body>
</html>
