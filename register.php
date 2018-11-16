<?php
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	echo "Hello";

	if(isset($_POST['b']) and isset($_POST['u']) and isset($_POST['g'])){

		$b=$_POST["b"];
		$u=$_POST["u"];
		$g=$_POST["g"];
		$mysqli = new mysqli("titan.isr.uc.pt", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
		// check connection 
		if ($mysqli->connect_errno) {
		    printf("Connect failed: %s\n", $mysqli->connect_error);
		    exit();
		}
		//Build MySQL string
		$query = "INSERT INTO utilizador (user_id,nome,is_editor,sexo,ddn) VALUES (DEFAULT, '$u', 1, '$g', '$b')";
	
		$result = $mysqli->query($query) or die($mysqli->error);
		$mysqli->close();
		echo "<label>'$u'</label>";
	}
?>	
