<?php
	session_start();
?>

<script type="text/javascript">

	function songFunction(par){
	
		$('#midNav').load('songPage.php?mid=' + par);
	}

	$('#share-button').on('click', function() {
		var user_id=document.getElementById("usr-Select").value;
		var playlist_id=document.getElementById("pid").value;
		
		$('#midNav').load('sharePlaylist.php?receiver=' + user_id + '&playlist=' + playlist_id);

        	return false;
    	});
	
	function removePlaylist(pid) {
		
		$('#midNav').load('removeItem.php?type=' + 'playlist' + '&playlist=' + pid);
        	return false;
    	}
	
</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$pid = $_GET["pid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	} 

	echo "<div class='row' style='position: absolute; top: 200px; left: 100px;'>";

	$incrementer=1;
	//Get Playlist Info
	$query = "SELECT p.nome pnome, u.nome unome, m.nome mnome, m.musica_id mid
		  FROM playlist p, playlist_musica pm, musica m, utilizador u
		  WHERE u.user_id=p.utilizador_user_id AND p.playlist_id=pm.playlist_playlist_id AND pm.musica_musica_id=m.musica_id AND p.playlist_id=$pid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$mid = $row["mid"];
			if($incrementer==1){
				echo "<div class='column' style='width: 600px; height: 1000px;'>";

				echo "<br><h1>" . $row["pnome"] . "</h1>";
				echo "<td>By User: " . $row["unome"] . "</td><br>";	
				echo "<h2>Songs: </h2>";		
				$incrementer = 2;
			}
			
			echo "<td><a href='#goSong' id='sel_song' onclick='songFunction($mid)'>" . $row["mnome"] . "</a></td><br>";
		
		}	

		echo "</div>";
	
	}

	if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

		if($_SESSION['logged_in'] == 'YES'){
	
			$uid = $_SESSION['user_id'];
			$unome = $_SESSION['username'];
			echo "<div class='column' style='width: 600px; position: absolute; top:25px; left: 600px;'>";
				echo "<h1> Share with a friend! </h1>";
				echo "<form>";
					
					echo "<select id='usr-Select' style='position:absolute; left:16px; width:300px; color: white; background-color: #3E77EA;'  oninput='pid.value = $pid'>";
						
					$query = "SELECT u.user_id uid, u.nome unome FROM utilizador u WHERE u.nome <> '$unome'";
					if ($result = $mysqli->query($query)) {
						while($row = $result->fetch_assoc()) {
							$aux = $row['unome'];
							$aux2 = $row['uid'];
							echo "<option value='$aux2'>$aux</option>";
						}
					}
					echo "</select>";

					echo "<output name='playlist_id' id='pid' style='visibility:hidden;'>$pid</output>";

					echo "<button class='btn btn-primary btn-marginl' type='submit' id='share-button' style='position:absolute; left: 120px; top:90px;'>Submit!</button>";
				echo "</form>";

					
			echo "</div>";


			if($_SESSION["is_editor"] == 1){
						echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:70px;' onclick='removePlaylist($pid)'>Delete Playlist</button>";
			}
		}
	}		


	echo "</div>";

	//Close MySQL Database connection
	$mysqli->close();
?>

