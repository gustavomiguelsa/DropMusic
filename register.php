<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	if(isset($_POST['register_ok'])) {
		$mysqli = new mysqli("titan.isr.uc.pt", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
		// check connection 
		if ($mysqli->connect_errno) {
		    printf("Connect failed: %s\n", $mysqli->connect_error);
		    exit();
		}
		//Build MySQL string
		$query = "INSERT INTO utilizador (user_id,nome,is_editor,sexo,ddn) VALUES (DEFAULT,'".$_POST["in_username_reg"]."','TRUE','MALE','".$_POST["in_ddn_reg"]."')";
	
		$result = mysqli_query($conn,$query);

		$mysqli->close();

		}

?>
