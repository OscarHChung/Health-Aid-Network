<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Donate</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
	<?php
	$i = 0;
	define("DB_HOST", "localhost");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "");
	define("DB_NAME", "request");

	$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if(!$con) {
		die("Connection failed: ".mysqli_connect_error());
	}

	$query = "SELECT * FROM marker";
	$result = mysqli_query($con, $query);
	$locations = array();
	$hname = array();
	$blooddrive = array();
	$gloves = array();
	$nonlatex = array();
	$masks = array();
	$ventilators = array();
	$food = array();
	$gowns = array();
	$caps = array();
	$other = array();
	$addresses = array();
	while($row = mysqli_fetch_array($result)) {
		array_push($hname, $row['hname']);
		array_push($blooddrive, $row['blooddrive']);
		array_push($nonlatex, $row['nonlatex']);
		array_push($food, $row['food']);
		array_push($gowns, $row['gowns']);
		array_push($caps, $row['caps']);
		array_push($gloves, $row['gloves']);
		array_push($masks, $row['masks']);
		array_push($ventilators, $row['ventilators']);
		array_push($other, $row['other']);
		array_push($addresses, $row['address']);
	}
	$length = count($addresses);

	mysqli_close($con);
	?>

	<script>
		var hname = <?php echo json_encode($hname); ?>;
		var blooddrive = <?php echo json_encode($blooddrive); ?>;
		var nonlatex = <?php echo json_encode($nonlatex); ?>;
		var food = <?php echo json_encode($food); ?>;
		var gowns = <?php echo json_encode($gowns); ?>;
		var caps = <?php echo json_encode($caps); ?>;
		var gloves = <?php echo json_encode($gloves); ?>;
		var masks = <?php echo json_encode($masks); ?>;
		var ventilators = <?php echo json_encode($ventilators); ?>;
		var other = <?php echo json_encode($other); ?>;
		var addresses = <?php echo json_encode($addresses); ?>;
	</script>
	<div class="topnav">
		<a id="logolink" href="index.html"><img  id="logo" border="0" alt="Health Aid Network" src="logo.png"></a>
		<a id="title" href="index.html"><h3>Health Aid Network</h3></a>
		<div class="topnav-right">
	  		<a href="contact.html">Contact Us</a>
	   	 	<a href="request.html">Request</a>
	   	 	<a class="active" href="donate.php">Donate</a>
	    	<a href="index.html">Home</a>
	    </div>
	</div>

	<div class="container">

		<div class="header">
			<h1>Donate</h1>
		</div>

		<div id="content">

			<div id="map"></div>
			<script type="text/javascript" src="scripts/donate.js"></script>
			<script type="text/javascript" data-main="scripts/donate.js" src="./node_modules/requirejs/require.js"></script>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOMKo4f38-5wpqt-SpWoffA4ZGDCsTr60&callback=initMap"/></script>

			<button id="closest-location">Find Nearest Location</button>

		</div>

		<div id="footer">
			<p id="copyright">&copy; Oscar Chung</p>
			<a href="#">Back to top</a>
		</div>

	</div>
	
</body>

</html>
