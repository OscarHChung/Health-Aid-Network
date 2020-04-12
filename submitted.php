<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title>Submitted!</title>
</head>
<body>

<?php

if(isset($_POST['submit'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$subject = $_POST['subject'];
	

	$mailTo = "oscar.hansuh.chung@outlook.com";
	$headers = "From: ".$email;
	$finalmessage = "You have received an email from".$firstname." ".$lastname.".\n\n".$message;

	mail($mailTo, $subject, $finalmessage, $headers);
	header("Location: contact.html?mailsend");
}

echo "Success!";

?>

</body>
</html>