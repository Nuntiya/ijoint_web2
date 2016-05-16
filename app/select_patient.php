<?
//include('include/chk_auth.php');
//include('../include/stcnn.php');

include('dbconnect.php');#nui
?>
<!DOCTYPE html>
<html>
<head>
	<title>iJoint - Select Patient</title>
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/select_patient.css">
</head>

<body>
	<div class="container">
		<? include('include/header.php'); ?>


		<a href="sign_out.php" id="sign_out_btn" class="btn">
			Sign Out
		</a>

		<div id="body">
			<div class="instruction">
				Please select the patient below, or <a href="create_patient.php">create patient</a>
			</div>

			<div id="patient_list">
				<?
				//$sql = "select * from patient order by pid asc";
				$sql = "select * from patient order by pid asc";
				$query = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_array($query)){
					$pid = $row['pid'];
					$gender = (($row['gender']=='f')?'fe':'') . 'male';
					$firstname = $row['firstname'];
					$lastname = $row['lastname'];
					$age = date_diff(date_create($row['dob']), date_create('today'))->y;

					$num_complete_task = 0;
					$sql_task = "select * from task where pid = $pid and status <> 'x'";
					$query_task = mysqli_query($conn, $sql_task);
					$num_all_task = mysqli_num_rows($query_task);
					$query_task = mysqli_query($conn, $sql_task);
					while ($row_task = mysqli_fetch_array($query_task)){
						if ($row_task['status'] == 'd')
							$num_complete_task++;
					}

					$stat = number_format($num_complete_task*100/$num_all_task);
				?>
				<a href="tasks.php?pid=<?=$pid?>" class="element box">
					<div class="patient_info">
						<div class="patient_gender">
							<img src="images/icon-<?=$gender?>.png" class="circle" />
						</div>
						<div class="patient_name"><?=$firstname . ' ' . $lastname?> <span class="age"><?=$age?> yrs old</span></div>
					</div>
					<div class="patient_stat">
						<div class="label">Progress</div>
						<div class="bar"><div class="grey_bar"><div class="complete_bar" style="width: <?=$stat?>%;"></div></div></div>
						<div class="stat"><?=$stat?>%</div>
					</div>
				</a>
				<? } ?>
			</div>
		</div>

		<? include('include/footer.php'); ?>
	</div>
</body>
</html>