<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>Submitted!</title>
</head>
<body>

<?php

define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "request");

$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$con) {
	die("Connection failed: ".mysqli_connect_error());
}

if(isset($_POST['submit'])) {
	$arr = array("'","\"","&quot;");
	$hname = str_replace($arr, "", htmlspecialchars($_POST['hospitalname']));
	$address = str_replace($arr, "", htmlspecialchars($_POST['address']));
	$blooddrive = 0;
	$nonlatex = 0;
	$food = 0;
	$gowns = 0;
	$caps = 0;
	$gloves = 0;
	$masks = 0;
	$ventilators = 0;
	$other = null;

	if(isset($_POST['blood-drive'])) {
		$blooddrive = 1;
	}
	if(isset($_POST['nonlatex'])) {
		$nonlatex = 1;
	}
	if(isset($_POST['food'])) {
		$food = 1;
	}
	if(isset($_POST['gowns'])) {
		$gowns = 1;
	}
	if(isset($_POST['caps'])) {
		$caps = 1;
	}
	if(isset($_POST['gloves'])) {
		$gloves = 1;
	}
	if(isset($_POST['masks'])) {
		$masks = 1;
	}
	if(isset($_POST['ventilators'])) {
		$ventilators = 1;
	}
	if(isset($_POST['other'])) {
		$other = str_replace($arr, "", htmlspecialchars($_POST['other']));
	}

	$sql = "INSERT INTO marker (hname, blooddrive, gloves, nonlatex, masks, ventilators, food, gowns, caps, other, address) VALUES ('$hname', '$blooddrive', '$gloves', '$nonlatex', '$masks', '$ventilators', '$food', '$gowns', '$caps', '$other', '$address')";

	if(mysqli_query($con, $sql)) {
		header('Location:truesubmit.html');
	}
	else {
		echo "Error: ".$sql."<br>".mysqli_error($con);
	}
	mysqli_close($con);
}



?>

</body>
</html>
