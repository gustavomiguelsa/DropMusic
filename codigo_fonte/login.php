<?php
	session_start();
	error_reporting(E_ALL);
	ini_set("display_errors", 1);


	if(isset($_GET['unome']) ){

		$unome=$_GET["unome"];

		$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");	 
		if ($mysqli->connect_errno) {
		    printf("Connect failed: %s\n", $mysqli->connect_error);
		    exit();
		}

		$query = "SELECT u.nome unome, u.user_id uid, u.is_editor uie FROM utilizador u WHERE u.nome='$unome'";

		if ($result = $mysqli->query($query)) { // If result matched $username and $password
			
			if($row = $result->fetch_assoc()) {
			
				$_SESSION['logged_in'] = 'YES'; // put session value here 	
				$_SESSION['username'] = $unome;	
				$_SESSION['user_id'] = $row["uid"];
				$_SESSION['is_editor'] = $row["uie"];
				//echo "<script type='text/javascript'> $('#lg_button').hide(); $('#rg_button').hide(); $('#logout_button').show(); $('#zone_button').show() </script>";
				
				echo "<div style='position: relative; top: 7px; left: -220px;'><i><b> Logged in as: $unome </b></i></div>";
				//echo "<button type='button' class='btn btn-primary btn-marginl' id='zone_button' onclick='zoneFunction()'> My Zone </button>";


				echo "<li class='nav-item dropdown'>
					  <a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>
						Go!
					  </a>
					  <div class='dropdown-menu' id='drpdwn-elem'>
						<a class='dropdown-item' href='#myZone' onclick='zoneFunction()'>My Zone</a>";
						echo "<a class='dropdown-item' href='#createPlaylist' onclick='addFunction(1)'>Create Playlist</a>";

				echo "	  </div>
					</li>";

				echo "<button type='button' class='btn btn-primary btn-marginl' id='logout_button' onclick='logoutFunction()'>Logout</button>";
				echo "<script type='text/javascript'> clearMain(); </script>";
				
			} else {
			
				$_SESSION['logged_in'] = 'NO';
				$_SESSION['username'] = '';
				$_SESSION['user_id'] = -1;
				$_SESSION['is_editor'] = -1;
				$error = "Your Login Username is invalid!";
				echo "<script type='text/javascript'>alert('$error');</script>";
				echo "<button type='button' class='btn btn-primary' data-toggle='modal' id='rg_button' data-target='#RegisterModal'>Register</button>";
				echo "<button type='button' class='btn btn-primary btn-marginl' id='lg_button' data-toggle='modal' data-target='#LoginModal'>Login</button>";
				echo "<script type='text/javascript'> clearMain(); </script>";
			}
		
		} 

		
		// Close connection
		$mysqli->close();
	}
	
?>
