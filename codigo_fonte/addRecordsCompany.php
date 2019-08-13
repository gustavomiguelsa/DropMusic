<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//$uid = $_SESSION["user_id"];
	$reccomAddress = $_POST["reccomAddress"];
	$reccomName = $_POST["reccomName"];

	
	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	// prepare and bind
	$stmt = $mysqli->prepare("INSERT INTO editora (nome, morada) VALUES (?, ?)");
	$stmt->bind_param("ss", $reccomName, $reccomAddress);
	$stmt->execute();
	$stmt->close();
	/*$query = "INSERT INTO editora VALUES (default,'$reccomName', '$reccomAddress')";
	$result = $mysqli->query($query);*/
	
	echo "<h1> Record Company successfully added! </h1>";

	//Close MySQL Database connection
	$mysqli->close();

?>
