<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get info from previous php
	$sender_id = $_SESSION["user_id"];
	$receiver_id = $_GET["receiver"];
	$song_id = $_GET["song"];
	$share_type = "musica";

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	$query1 = "INSERT INTO partilha VALUES (default,$receiver_id,$song_id,$sender_id,'$share_type')";
	$query2 = "INSERT INTO utilizador_musica VALUES ($receiver_id,$song_id)";

//echo "<h1>" . $sender_id . $receiver_id . $song_id . $share_type . "</h1>";
	$result1 = $mysqli->query($query1);
	$result2 = $mysqli->query($query2);

	if ( ($result1 != NULL) && ($result2 != NULL) ) {
		echo "<h1> Song successfully shared! </h1>";
	}

	//Close MySQL Database connection
	$mysqli->close();
?>
