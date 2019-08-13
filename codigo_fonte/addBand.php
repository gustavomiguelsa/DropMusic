<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//$uid = $_SESSION["user_id"];
	$bandName = $_POST["bandName"];
	$bandHistory = $_POST["bandHistory"];
	$recordC = $_POST["recordC"];
	$datebegin1 = $_POST["datebegin1"];
	$dateend1 = $_POST["dateend1"];
	$datebegin2 = $_POST["datebegin2"];
	$dateend2 = $_POST["dateend2"];
	$datebegin3 = $_POST["datebegin3"];
	$dateend3 = $_POST["dateend3"];
	$datebegin4 = $_POST["datebegin4"];
	$dateend4 = $_POST["dateend4"];
	$datebegin5 = $_POST["datebegin5"];
	$dateend5 = $_POST["dateend5"];

	$pmusicians = json_decode($_POST['pmusicians']);	//songs is now an array with the ids of the chosen songs

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	$counter = 0;	//Count the number of non-null elements in $songs
	for($i = 0; $i < 20; $i++){
		if($pmusicians[$i] != null){
			$counter++;

		}
	}

	/*$query = "INSERT INTO gr_musical VALUES (default,'$bandName','$bandHistory')";
	$result = $mysqli->query($query);*/

	// prepare and bind
	$stmt = $mysqli->prepare("INSERT INTO gr_musical (nome, historia) VALUES (?, ?)");
	$stmt->bind_param("ss", $bandName, $bandHistory);
	$stmt->execute();
	$stmt->close();
	
	if ($counter>0) {
		$incrementer = 0;

		$musica_id = 0;
		$inner_query = "SELECT MAX(grupo_id) novo FROM gr_musical";
		if ($inner_result = $mysqli->query($inner_query)) {
			while($inner_row = $inner_result->fetch_assoc()) {
				$grupo_id = $inner_row["novo"];
			}
		}

		for($i = 0; $i < 20; $i++){

			$current_musician = $pmusicians[$i];
			$inner_query = "INSERT INTO musico_gr_musical VALUES ($current_musician,$grupo_id)";
			$inner_result = $mysqli->query($inner_query);
			if ($inner_result != null) {
				$incrementer++;

			}
		}

	}
	
	$query = "INSERT INTO gr_musical_editora VALUES ('$grupo_id', '$recordC')";
	$result = $mysqli->query($query);

	if($datebegin1 != "" && $dateend1 != ""){
		$query = "INSERT INTO periodo VALUES ('$datebegin1', '$dateend1', '$grupo_id')";
		$result = $mysqli->query($query);
	}
	else if($datebegin2 != "" && $dateend2 != ""){
		$query = "INSERT INTO periodo VALUES ('$datebegin2', '$dateend2', '$grupo_id')";
		$result = $mysqli->query($query);
	}
	else if($datebegin3 != "" && $dateend3 != ""){
		$query = "INSERT INTO periodo VALUES ('$datebegin3', '$dateend3', '$grupo_id')";
		$result = $mysqli->query($query);
	}
	else if($datebegin4 != "" && $dateend4 != ""){
		$query = "INSERT INTO periodo VALUES ('$datebegin4', '$dateend4', '$grupo_id')";
		$result = $mysqli->query($query);
	}
	else if($datebegin5 != "" && $dateend5 != ""){
		$query = "INSERT INTO periodo VALUES ('$datebegin5', '$dateend5', '$grupo_id')";
		$result = $mysqli->query($query);
	}

	echo "<h1> Band successfully added! </h1>";

	
	//Close MySQL Database connection
	$mysqli->close();

?>
