<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//$uid = $_SESSION["user_id"];
	$composerName = $_POST["composerName"];
	$composerDOB = $_POST["composerDOB"];
	$composerBio = $_POST["composerBio"];
	
	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	// prepare and bind
	$stmt = $mysqli->prepare("INSERT INTO compositor (nome, ddn, bio) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $composerName, $composerDOB, $composerBio);
	$stmt->execute();
	$stmt->close();
	/*$query = "INSERT INTO compositor VALUES (default,'$composerName', '$composerDOB', '$composerBio')";
	$result = $mysqli->query($query);
	*/
	echo "<h1> Composer successfully added! </h1>";

	//Close MySQL Database connection
	$mysqli->close();

?>
