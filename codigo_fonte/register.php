<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$exists = 0;
	
	if(isset($_POST['b']) and isset($_POST['u']) and isset($_POST['g'])){

		// Info from the form
		$b=$_POST["b"];
		$u=$_POST["u"];
		$g=$_POST["g"];


		$conn1 = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");	
		// check connection 
		if ($conn1->connect_error) {
		    die("Connection failed: " . $conn1->connect_error);
		}
		//Build MySQL string
		$query1 = "SELECT nome n FROM utilizador";
		//Send query string to MySQL database
		if ($result1 = $conn1->query($query1)) {	
			while($row = $result1->fetch_assoc()) {
				$nome = $row["n"];
				if($nome == $u){
					$exists = 1;
				}
			}

		}
		// Close connection
		$conn1->close();

		// If the username already exists do nothing!
		if($exists == 1){
			
			echo "<h1>Username already exists!</h1>";
		}
		else{
			
			$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
			// check connection 
			if ($mysqli->connect_error) {
			    die("Connection failed: " . $mysqli->connect_error);
			}
			//Build MySQL string
			$query = "INSERT INTO utilizador (user_id,nome,is_editor,sexo,ddn) VALUES (DEFAULT, '$u', 0, '$g', '$b')";
		
			$result = $mysqli->query($query) or die($mysqli->error);
			echo "<h1>User successfully registered!</h1>";
			// Close connection
			$mysqli->close();
		}
	

			
	}
?>	
