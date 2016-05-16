<?php
$gender_image_src = $patient['gender'] == 'm'?'People-Patient-Male-icon.jpg':'People-Patient-Female-icon.jpg';
$date_of_birth = $patient['dob'];
$date_of_birth = DateTime::createFromFormat('Y-m-d',$date_of_birth)->format('d/m/Y');
$age = date_diff(date_create($patient['dob']), date_create('today'))->y;

?>
<aside class="main-sidebar " >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/<?php echo $gender_image_src;?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $patient['firstname'].' '.$patient['lastname'];?></p>
                <a href="#"><i class="fa fa-circle text-info"></i> <?php echo $age;?> years old</a>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li id="menu-patient-dashboard">
                <a  href="patient.php?pid=<?php echo $patient['pid'];?>">
                    <i class="fa fa-dashboard"></i>
                    <span >Dashboard</span>

                </a>
            </li>
            <li class="treeview" id="menu-patient-tasks">
                <a href="#">
                    <i class="fa fa-tasks"></i>
                    <span>Task</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu menu-open" style="display: block;">
                    <li id="menu-create-task"><a href="patient.php?pid=<?php echo $pid?>&pageId=task_create"><i class="fa fa-plus"></i> Create Task</a></li>
                    <li id="menu-all-task"><a href="patient.php?pid=<?php echo $pid?>&pageId=tasks"><i class="fa fa-list"></i> All Task</a></li>
                </ul>
            </li>
            <li id="menu-patient-update">
                <a  href="patient.php?pid=<?php echo $patient['pid'];?>&pageId=update">
                    <i class="fa fa-edit"></i>
                    <span data-toggle="tooltip"  title="Update Profile">Update Profile</span>
                </a>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>