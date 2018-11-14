<?php
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	echo "Hello";
	$d=$_POST["data"];
	if(isset($_POST['data'])) {
		$mysqli = new mysqli("titan.isr.uc.pt", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
		// check connection 
		if ($mysqli->connect_errno) {
		    printf("Connect failed: %s\n", $mysqli->connect_error);
		    exit();
		}
		//Build MySQL string
		$query = "INSERT INTO utilizador (user_id,nome,is_editor,sexo,ddn) VALUES (DEFAULT, '$d[u]', 'TRUE', 'M', '$d[b]')";
	
		$result = $mysqli->query($query);
		echo $result->fetch_assoc();
		$mysqli->close();

		}

?>	
