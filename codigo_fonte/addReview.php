<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get info from previous php
	$uid = $_SESSION["user_id"];
	$title = $_GET["title"];
	$why = $_GET["why"];
	$score = $_GET["score"];
	$aid = $_GET["aid"];
	
	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	$query = "INSERT INTO critica VALUES ('$title','$why',$score,$uid,$aid)";
	if ($result = $mysqli->query($query)) {
		echo "<h1> Review successfully submitted! </h1>";
	}

	//Close MySQL Database connection
	$mysqli->close();
?>
