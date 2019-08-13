<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$uid = $_SESSION["user_id"];
	$title = $_GET["title"];
	$date = date("Y-m-d");

	if( $_GET["pubpriv"] == "false" ){
		$pubpriv = 1;	//PUBLIC
	} else {
		$pubpriv = 0;	//PRIVATE
	}
	$songs = json_decode($_GET['psongs']);	//songs is now an array with the ids of the chosen songs


	$counter = 0;	//Count the number of non-null elements in $songs
	for($i = 0; $i < 15; $i++){
		if($songs[$i] != null){
			$counter++;

		}
	}

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	$incrementer = 0;
	$query = "INSERT INTO playlist VALUES (default,'$title',$pubpriv,$uid,'$date')";
	$result = $mysqli->query($query);
	if($result != null){

		$playlist_id = 0;
		$inner_query = "SELECT MAX(playlist_id) novo FROM playlist";
		if ($inner_result = $mysqli->query($inner_query)) {
			while($inner_row = $inner_result->fetch_assoc()) {
				$playlist_id = $inner_row["novo"];
			}
		}

		for($i = 0; $i < 15; $i++){

			$current_song = $songs[$i];
			$inner_query = "INSERT INTO playlist_musica VALUES ($playlist_id,$current_song)";
			$inner_result = $mysqli->query($inner_query);
			if ($inner_result != null) {
				$incrementer++;

			}
		}
		
	}

	if($incrementer == $counter){
		echo "<h1> Playlist successfully created! </h1>";
	}

	//Close MySQL Database connection
	$mysqli->close();
?>



