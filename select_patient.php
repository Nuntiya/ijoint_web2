<?php
session_start();


require_once "dbconnect.php";

if (!isset($_GET['start'])) {
    $start = 0;
} else {
    $start = $_GET['start'];
}
if (!isset($_GET['page'])) {
    $page_con = 1;
} else {
    $page_con = $_GET['page'];
}
$limit = '20';
$for_end = $limit;
$for_start = $start * $limit;

$filterDefault = " where 1=1 ";

$keyword = getIsset("keyword");
if ($keyword != "") {
    $filterDefault .= " and (firstname like '%" . $keyword . "%' or lastname like '%" . $keyword . "%') ";
}
$sql_data = "select * from patient ";
$result_row = $conn->queryRaw($sql_data . $filterDefault . " order by pid  " );//คิวรี่ คำสั่ง
$total = sizeof($result_row);

$select_all = $conn->queryRaw($sql_data . $filterDefault . " order by pid  limit " . $for_start . "," . $for_end);
$total_num = sizeof($select_all);
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


</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "navbar.php" ?>
    <?php include "sidebar.php" ?>
    <div class="content-wrapper skin-blue">
        <form id="form_data" name="form_data" method="post" action="select_patient.php">

            <input id="__cmd" name="__cmd" type="hidden" value="">
            <section class="content-header">
                <div class="col-sm-12">
                    <div class="col-md-12">
                        <h3 class="box-title text-center">Patient List</h3>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="col-md-4">
                        <h4 class="box-title text-right">Search</h4>
                    </div>
                    <div class="col-md-4 ">
                        <div class="input-group">
                            <input type="text" name="keyword" id="keyword" class="form-control" value="<?php echo $keyword;?>"
                                   >
                            <a href="javascript:goSearch();" class="input-group-addon"><i class="fa fa-search"></i> </a>
                        </div>
                    </div>

                </div>

                <div class="col-sm-12">
                    <div class="col-md-12">
                        <h5 class="box-title text-center"> Found <?php echo $total_num; ?> Data of <?php echo $total; ?> items.</h5>
                    </div>


                </div>
            </section>
            <section class="content">
                <div id="body">
                    <div id="patient_list">

                        <?
                        //$sql = "select * from patient order by pid asc";

                        foreach ($select_all as $row) {
                            $pid = $row['pid'];
                            $gender = (($row['gender'] == 'f') ? 'fe' : '') . 'male';
                            $firstname = $row['firstname'];
                            $lastname = $row['lastname'];
                            $age = date_diff(date_create($row['dob']), date_create('today'))->y;

                            $num_complete_task = 0;

                            $query_task = $conn->queryRaw("select * from task where pid = $pid and status <> 'x'");
                            $num_all_task = 0;
                            foreach ($query_task as $row_task) {
                                if ($row_task['status'] == 'd') {
                                    $num_complete_task++;
                                }
                                $num_all_task++;
                            }

                            $stat = number_format($num_complete_task * 100 / $num_all_task);
                            ?>
                            <a href="patient.php?pid=<?= $pid ?>" class="element ">
                                <div class="patient_info">
                                    <div class="patient_gender">
                                        <img src="images/icon-<?= $gender ?>.png" class="circle"/>
                                    </div>
                                    <div class="patient_name"><?= $firstname . ' ' . $lastname ?> <span
                                            class="age"><?= $age ?> yrs old</span></div>
                                </div>
                                <div class="patient_stat">
                                    <div class="">Progress</div>
                                    <div class="bar">
                                        <div class="grey_bar">
                                            <div class="complete_bar" style="width: <?= $stat ?>%;"></div>
                                        </div>
                                    </div>
                                    <div class="stat"><?= $stat ?>%</div>
                                </div>
                            </a>
                        <? } ?>
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
<!-- Page script -->
<script>

</script>
</body>
</html>


