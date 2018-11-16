<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$mysqli = new mysqli("titan.isr.uc.pt", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	// check connection 
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	echo "<h2>PHP is Fun!</h2>";

	//Build MySQL string
	$query = "SELECT nome,genero FROM musica;";

	if ($result = $mysqli->query($query)) {
		
		// fetch associative array 
		while($row = $result->fetch_assoc()) {
			echo $row["nome"] . $row["genero"];
		}	
	}

	$mysqli->close();

?>
