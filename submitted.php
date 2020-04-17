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
define("DB_NAME", "contact");

$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$con) {
	die("Connection failed: ".mysqli_connect_error());
}

if(isset($_POST['submit'])) {
	$fname = $_POST['firstname'];
	$lname = $_POST['lastname'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	$sql = "INSERT INTO info (first_name, last_name, email, subject, message) VALUES ('$fname', '$lname', '$email', '$subject', '$message')";

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
