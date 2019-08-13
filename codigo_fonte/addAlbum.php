<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get info introduced by the user concerning the album
	$albumName = $_POST["albumName"];
	$albumDate = $_POST["albumDate"];
	$by = $_POST["albumBy"];

	$songs = json_decode($_POST['psongs']);	//songs is now an array with the ids of the chosen songs

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	$counter = 0;	//Count the number of non-null elements in $songs
	for($i = 0; $i < 49; $i++){
		if($songs[$i] != null){
			$counter++;

		}
	}
	// If the album belongs to a musician:
	if (strpos($by, 'mid') !== false) {
		// Parse the string by removing the marker mid that corresponds to a musician's id
		$by = str_replace("mid", "", $by);
		/* Set a null variable grupo_musical_grupo_id for biding parameters */
		$gr=null;
		$incrementer = 0;
		// Prepare and bind
		$stmt = "";
		if(!($stmt = $mysqli->prepare("INSERT INTO album (nome, data_lancamento, musico_musico_id, gr_musical_grupo_id) VALUES (?, ?, ?, ?)"))){
		    die( "Error preparing: (" .$mysqli->errno . ") " . $mysqli->error);
		}
		if(!($stmt->bind_param("ssss", $albumName, $albumDate, $by, $gr))){
		    die( "Error in bind_param: (" .$mysqli->errno . ") " . $mysqli->error);
		}
		if (!($stmt->execute())) { 
		   // it worked
			die( "Error in execute: (" .$mysqli->errno . ") " . $mysqli->error);
		}
		$stmt->close();

		// Find out the latest album's id
		$album_id = 0;
		$inner_query = "SELECT MAX(album_id) novo FROM album";
		if ($inner_result = $mysqli->query($inner_query)) {
			while($inner_row = $inner_result->fetch_assoc()) {
				$album_id = $inner_row["novo"];
			}
		}
		// Insert the relationship between the song i and the album on the database
		for($i = 0; $i < 49; $i++){
			$current_song = $songs[$i];
			$inner_query = "INSERT INTO album_musica VALUES ($album_id,$current_song)";
			$inner_result = $mysqli->query($inner_query);
			if ($inner_result != null) {
				$incrementer++;
			}
		}	

	}
	// If the album belongs to a band:
	if (strpos($by, 'grid') !== false) {
		// Parse the string by removing the marker grid that corresponds to a band's id
		$by = str_replace("grid", "", $by);
		$incrementer = 0;
		$mid=null;
		$incrementer = 0;
		// Prepare and bind
		$stmt = "";
		if(!($stmt = $mysqli->prepare("INSERT INTO album (nome, data_lancamento, musico_musico_id, gr_musical_grupo_id) VALUES (?, ?, ?, ?)"))){
		    die( "Error preparing: (" .$mysqli->errno . ") " . $mysqli->error);
		}
		if(!($stmt->bind_param("ssss", $albumName, $albumDate, $mid, $by))){
		    die( "Error in bind_param: (" .$mysqli->errno . ") " . $mysqli->error);
		}
		if (!($stmt->execute())) { 
		   // it worked
			die( "Error in execute: (" .$mysqli->errno . ") " . $mysqli->error);
		}
		$stmt->close();
		// Find out the latest album's id
		$album_id = 0;
		$inner_query = "SELECT MAX(album_id) novo FROM album";
		if ($inner_result = $mysqli->query($inner_query)) {
			while($inner_row = $inner_result->fetch_assoc()) {
				$album_id = $inner_row["novo"];
			}
		}
		// Insert the relationship between the song i and the album on the database
		for($i = 0; $i < 49; $i++){

			$current_song = $songs[$i];
			$inner_query = "INSERT INTO album_musica VALUES ($album_id,$current_song)";
			$inner_result = $mysqli->query($inner_query);
			if ($inner_result != null) {
				$incrementer++;

			}
		}
	}
	
	echo "<h1> Album successfully created! </h1>";

	
	//Close MySQL Database connection
	$mysqli->close();

?>
