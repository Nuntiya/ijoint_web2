<?
include('include/chk_auth.php');
//include('../include/stcnn.php');
include('dbconnect.php');

$pid = $_GET['pid'];
$tid = $_GET['tid'];
session_start();
$_SESSION['tid']=$tid;
$sql = "select * from patient where pid = $pid";
$query = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($query)){
	$gender = (($row['gender']=='f')?'fe':'') . 'male';
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$age = date_diff(date_create($row['dob']), date_create('today'))->y;
}

$sql = "select * from task where tid = $tid";
$query = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array($query)){
	$task_date 				= $row['date'];
	$task_side 				= $row['side'];
	$task_target_angle 		= $row['target_angle'];
	$task_number_of_round 	= $row['number_of_round'];
	$task_perform_datetime	= $row['perform_datetime'];
	$task_isABF				= $row['is_abf'];
	$task_score				= $row['score'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>iJoint - Result</title>
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/result.css">
</head>

<body>
	<div class="container">
		<? include('include/header.php'); ?>
		<? include('get_tid?tid=<?=$tid?>');?>
		<a href="sign_out.php" id="sign_out_btn" class="btn">
			Sign Out
		</a>

		<div id="body">
			<div id="change_patient">
				<a href="tasks.php?pid=<?=$pid?>">&lt;&lt; Go back to Task List</a> | <a href="result_peek.php?pid=<?=$pid?>&tid=<?=$tid?>" target="_blank">Show Peek</a>
			</div>

			<div id="patient" class="element box">
				<div class="patient_info">
					<div class="patient_gender">
						<img src="images/icon-<?=$gender?>.png" class="circle" />
					</div>
					<div class="patient_name"><?=$firstname . ' ' . $lastname?> <span class="age"><?=$age?> yrs old</span></div>
				</div>
			</div>

			<div id="task_info" class="element">
				<?=($task_isABF == 'y')?'<div class="abf_bg"></div><div class="abf">ABF</div>':''?>

				<div class="date"><?=strtoupper(date('d M Y', strtotime($task_date)))?></div>
				
				<div class="side">
					<div class="label">ARM SIDE</div>
					<div class="value"><?=($task_side=='l')?'Left':'Right'?></div>
				</div>

				<div class="target_angle">
					<div class="label">TARGET ANGLE</div>
					<div class="value"><?=$task_target_angle?>&deg;</div>
				</div>

				<div class="num_of_round">
					<div class="label">ROUND</div>
					<div class="value"><?=$task_score?> <span class="small">/ <?=$task_number_of_round?></span></div>
				</div>

				<div class="perform_datetime">
					<div class="label">PERFORM DATETIME</div>
					<div class="value"><?=strtoupper(date('d M Y | H:i', strtotime($task_perform_datetime)))?></div>
				</div>
			</div>
			<div align="center" width="840" height="500">
					 <object id="UnityObject" classid="clsid:444785F1-DE89-4295-863A-D46C3A781394"
					        width="840" height="450"
					        codebase="http://webplayer.unity3d.com/download_webplayer/UnityWebPlayer.cab#version=2,0,0,0">
						 <param name="unity3d" value=<?=($task_side=='l')?"WebPlayer_16042016_1.unity3d":"WebPlayer_16042016_2.unity3d" ?> />
						 <embed id="UnityEmbed" src=<?=($task_side=='l')?"WebPlayer_16042016_1.unity3d":"WebPlayer_16042016_2.unity3d" ?> width="840" height="450"
					  type="application/vnd.unity" pluginspage="http://www.unity3d.com/unity-web-player-2.x" />
					 </object>
			 </div>

			<div id="chartContainer"></div>

			<table id="item_table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>#</td>
						<td>Time (s)</td>
						<td>Angle</td>
					</tr>
				</thead>

				<tbody>
					<?
					$time_list = array();
					$angle_list = array();
					$angle_list_txt = "";

					$SQL = "SELECT * FROM result_item WHERE tid = $tid ORDER BY iid ASC";
					$query = mysqli_query($conn,$SQL);
					$i = 1;
					while ($row = mysqli_fetch_array($query)){
						$time_list[] = number_format( ($row['time']/1000), 1);
						$angle_list[] = $row['angle'];
						if($angle_list_txt != ""){
							$angle_list_txt = $angle_list_txt."|".$row['angle'];
						} else {
							$angle_list_txt = $row['angle'];
						}
					?>
					<tr>
						<td><?=$i?></td>
						<td><?=number_format( ($row['time']/1000), 1)?></td>
						<td><?=$row['angle']?></td>
					</tr>
					<tr>
						<td><?=$i?></td>
						<td><?=number_format( ($row['time']/1000), 1)?></td>
						<td><?=$row['angle']?></td>
					</tr>
					<? $i++; } ?>
				</tbody>
			</table>
		</div>

		

		<? include('include/footer.php'); ?>
	</div>
	<script src="js/jquery.js"></script>
	<script src="js/fusioncharts.js"></script>
	<script src="js/fusioncharts.charts.js"></script>
	<script src="js/themes/fusioncharts.theme.fint.js"></script>
	<script>
	$(function(){
		$('.del').on('click', function(e){
			e.preventDefault();
			tid = $(this).attr('data-tid');

			if (confirm("Are you sure you want to delete this task?"))
				window.location = 'delete_task.php?pid=<?=$pid?>&tid=' + tid;
		});
	});
	</script>
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
		<script type="text/javascript">
			<script type="text/javascript">

			function calledFromActionScript()
			{
			    alert("ActionScript called Javascript function")

			    var obj = swfobject.getObjectById("unityPlayer");
			    if (obj)
			    {
			        obj.callFromJavascript();
			    }
			}

</script> 
		</script>
</body>
</html>