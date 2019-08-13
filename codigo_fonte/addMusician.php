<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//$uid = $_SESSION["user_id"];
	$musicianName = $_POST["musicianName"];
	$musicianDOB = $_POST["musicianDOB"];
	$recordC = $_POST["recordC"];
	$musicianBio = $_POST["musicianBio"];
	$composer = $_POST["composer"];
	
	$compositor_id = -1;

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	if($composer == 1){
		$query = "SELECT c.compositor_id cid FROM compositor c WHERE c.nome='$musicianName'";
		if ($result = $mysqli->query($query)) {
			while($row = $result->fetch_assoc()) {
				$compositor_id = $row["cid"];
			}
		}
		if ($compositor_id == -1){
			echo "<h1> This musician is not a composer yet! First you need to add it as a composer!</h1>";
		}
		else {
			// prepare and bind
			$stmt = $mysqli->prepare("INSERT INTO musico (nome, ddn, bio) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $musicianName, $musicianDOB, $musicianBio);
			$stmt->execute();
			$stmt->close();

			/*$query = "INSERT INTO musico VALUES (default,'$musicianName', '$musicianDOB', '$musicianBio')";
			$result = $mysqli->query($query);*/
			
			$inner_query = "SELECT MAX(musico_id) novo FROM musico";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$musico_id = $inner_row["novo"];
				}
			}
			$query = "INSERT INTO musico_editora VALUES ($musico_id, $recordC)";
			$result = $mysqli->query($query);
			
			$query = "INSERT INTO compositor_musico VALUES ($compositor_id,$musico_id)";
			$result = $mysqli->query($query);

			echo "<h1> Musician successfully added! </h1>";

		}
	}
	else {
		/*$query = "INSERT INTO musico VALUES (default,'$musicianName', '$musicianDOB', '$musicianBio')";
		$result = $mysqli->query($query);
		*/
		// prepare and bind
		$stmt = $mysqli->prepare("INSERT INTO musico (nome, ddn, bio) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $musicianName, $musicianDOB, $musicianBio);
		$stmt->execute();
		$stmt->close();
		$inner_query = "SELECT MAX(musico_id) novo FROM musico";
		if ($inner_result = $mysqli->query($inner_query)) {
			while($inner_row = $inner_result->fetch_assoc()) {
				$musico_id = $inner_row["novo"];
			}
		}
		$query = "INSERT INTO musico_editora VALUES ($musico_id, $recordC)";
		$result = $mysqli->query($query);
		echo "<h1> Musician successfully added! </h1>";
	}

	
	

	
	//Close MySQL Database connection
	$mysqli->close();

?>
