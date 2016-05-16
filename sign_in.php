<?
session_start();
include('dbconnect.php');




$username = getIsset('username');
$password = md5(getIsset('password'));

$sql = "select * from admin_user where username = '" . $username . "' and password = '" . $password . "'";
$result = $conn->queryRaw($sql,true);

if ($result != null){
	$_SESSION["uprofile"] = $result;

	header('Location: select_patient.php');
	exit();
}
else{
	header('Location: index.php');
	exit();
}
?>