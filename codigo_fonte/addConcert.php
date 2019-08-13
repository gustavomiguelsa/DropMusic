<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$exists = 0;
	if(isset($_POST['b']) and isset($_POST['dura']) and isset($_POST['date']) and isset($_POST['o']) and isset($_POST['l'])){

		// Info from the form
		$by=$_POST["b"];
		$duration=$_POST["dura"];
		$occu=$_POST["o"];
		$date=$_POST["date"];
		$local=$_POST["l"];
		$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
		// check connection 
		if ($mysqli->connect_error) {
		    die("Connection failed: " . $mysqli->connect_error);
		}
		//Find out if it the concert is associated to either a group or a musician
		if (strpos($by, 'mid') !== false) {
			//It is a musician
			$by = str_replace("mid", "", $by);
			echo "<br>";
			//echo $by . "<br>";
			//echo "It is a musician!";
			//Build MySQL string
			$query = "INSERT INTO concerto (concerto_id,duracao_min,data,lotacao,musico_musico_id, gr_musical_grupo_id,local) VALUES (DEFAULT, '$duration', '$date', '$occu', '$by', NULL, '$local')";
		
			$result = $mysqli->query($query) or die($mysqli->error);
			echo '<h1>Concert successfully inserted!</h1>';
		}
		if (strpos($by, 'grid') !== false) {
			//It is a band
			$by = str_replace("grid", "", $by);
			echo "<br>";
			//echo $by . "<br>";
			//echo "It is a band!";
			//Build MySQL string
			$query = "INSERT INTO concerto (concerto_id,duracao_min,data,lotacao,musico_musico_id, gr_musical_grupo_id,local) VALUES (DEFAULT, '$duration', '$date', '$occu', NULL, '$by', '$local')";
		
			$result = $mysqli->query($query) or die($mysqli->error);
			echo '<h1>Concert successfully inserted!</h1>';
		}
		
		// Close connection
		$mysqli->close();
	}

?>
