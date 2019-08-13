<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$uid = $_SESSION["user_id"];
	$songName = $_POST["songName"];
	$songGenre = $_POST["songGenre"];
	$songLink = $_POST["songLink"];
	$songDate = $_POST["songDate"];
	$songLyrics = $_POST["songLyrics"];

	/*$data = [
	    'id' => default,
	    'name' => $songName,
	    'genre' => $songGenre,
	    'link' => $songLink,
	    'date' => $songDate,
	    'lyrics' => $songLyrics,
	];*/

	$pmusicians = json_decode($_POST['pmusicians']);	//songs is now an array with the ids of the chosen songs
	$pcomposers = json_decode($_POST['pcomposers']);
	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	$counter_m = 0;	//Count the number of non-null elements in $songs
	for($i = 0; $i < 44; $i++){
		if($pmusicians[$i] != null){
			$counter_m++;

		}
	}
	$counter_c = 0;	//Count the number of non-null elements in $songs
	for($i = 0; $i < 19; $i++){
		if($pcomposers[$i] != null){
			$counter_c++;

		}
	}
	
	
	// prepare and bind
	$stmt = $mysqli->prepare("INSERT INTO musica (nome, genero, link, data_lancamento, letra) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("sssss", $songName, $songGenre, $songLink,$songDate,$songLyrics);
	$stmt->execute();
	
	
	if ($counter_m>0) {
		$incrementer = 0;

		$musica_id = 0;
		$inner_query = "SELECT MAX(musica_id) novo FROM musica";
		if ($inner_result = $mysqli->query($inner_query)) {
			while($inner_row = $inner_result->fetch_assoc()) {
				$musica_id = $inner_row["novo"];
			}
		}

		for($i = 0; $i < 44; $i++){

			$current_musician = $pmusicians[$i];
			$inner_query = "INSERT INTO musico_musica VALUES ($current_musician,$musica_id)";
			$inner_result = $mysqli->query($inner_query);
			if ($inner_result != null) {
				$incrementer++;

			}
		}

	}
	if ($counter_c>0) {
		$incrementer = 0;

		$musica_id = 0;
		$inner_query = "SELECT MAX(musica_id) novo FROM musica";
		if ($inner_result = $mysqli->query($inner_query)) {
			while($inner_row = $inner_result->fetch_assoc()) {
				$musica_id = $inner_row["novo"];
			}
		}

		for($i = 0; $i < 19; $i++){

			$current_composer = $pcomposers[$i];
			$inner_query = "INSERT INTO compositor_musica VALUES ($current_composer,$musica_id)";
			$inner_result = $mysqli->query($inner_query);
			if ($inner_result != null) {
				$incrementer++;

			}
		}
	}
	$query = "INSERT INTO utilizador_musica VALUES ($uid, $musica_id)";
	$result = $mysqli->query($query);
	

	
	echo "<h1> Song successfully added! </h1>";

	$stmt->close();

	//Close MySQL Database connection
	$mysqli->close();

?>
