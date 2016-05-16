<!--<? include('../include/stcnn.php'); ?>-->
<?
session_start();

if($_SESSION['uprofile'] != null){
	header('Location: select_patient.php');
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>iJoint</title>
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/sign_in.css">
</head>

<body>
	<? include('include/header.php'); ?>
	<form action="sign_in.php" method="POST" class="box">
		<input type="text" name="username" id="username" placeholder="Username" class="input" />
		<input type="password" name="password" id="password" placeholder="Password" class="input" />
		<input type="submit" name="submit" value="Sign In" class="btn" />
	</form>

	<? include('include/footer.php'); ?>
</body>
</html>