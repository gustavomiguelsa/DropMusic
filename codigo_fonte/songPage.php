<?php
	session_start();
?>

<script type="text/javascript">

	function musicianFunction(par){ $('#midNav').load('musicianPage.php?muid=' + par); }

	function albumFunction(par){ $('#midNav').load('albumPage.php?aid=' + par); }

	function composerFunction(par){ $('#midNav').load('composerPage.php?cid=' + par); }

	function playlistFunction(par){ $('#midNav').load('playlistPage.php?pid=' + par); }
	
	$('#share-button').on('click', function() {
		var user_id=document.getElementById("usr-Select").value;
		var song_id=document.getElementById("mid").value;
		
		$('#midNav').load('shareSong.php?receiver=' + user_id + '&song=' + song_id);

        	return false;
    	});

	function removeSong(mid) {
		
		$('#midNav').load('removeItem.php?type=' + 'musica' + '&song=' + mid);
        	return false;
    	}

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get search term from html
	$mid = $_GET["mid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	//BASIC SONG INFO AND MUSICIAN OWNER INFO
	$incrementer=1;
	$query = "SELECT m.nome mnome, m.genero mgenero, m.link mlink, m.data_lancamento mdata, m.letra mletra, mu.nome munome, mu.musico_id muid
		  FROM musica m, musico mu, musico_musica mum
		  WHERE m.musica_id=mum.musica_musica_id AND mum.musico_musico_id=mu.musico_id
		  AND musica_id=$mid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$muid = $row['muid'];
			if($incrementer==1){
				echo "<div class='row' style='position: absolute; top: 200px; left: 100px;'>
 					<div class='column' style='width: 600px; height: 1000px;'>";

				echo "<br><h1>" . $row["mnome"] . "</h1>";
				echo "<td> Genre: " . $row["mgenero"] . "</td><br>";
				echo "<td> Download Link: " . $row["mlink"] . "</td><br>";
				echo "<td> Release Date: " . $row["mdata"] . "</td><br>";
				echo "<td> Lyrics: " . $row["mletra"] . "</td><br>";

				echo "<br><h2> Musician Owners: </h2>";
				$incrementer = 2;
			}
			
			echo "<td><a href='#goMusician' id='sel_musician' onclick='musicianFunction($muid)'>" . $row["munome"] . "</a></td><br>";
		}
	}
	
	//ALBUMS INFO
	$incrementer=1;
	$query = "SELECT a.album_id aid, a.nome anome
		  FROM album a, album_musica am
		  WHERE a.album_id=am.album_album_id AND am.musica_musica_id=$mid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$aid = $row["aid"];
			if($incrementer==1){
				echo "<br><h2> Albums: </h2>";
				$incrementer = 2;
			}
			
			echo "<td><a href='#goAlbum' id='sel_album' onclick='albumFunction($aid)'>" . $row["anome"] . "</a></td><br>";
		}
	}

	//COMPOSERS INFO
	$incrementer=1;
	$query = "SELECT c.compositor_id cid, c.nome cnome
		  FROM compositor c, compositor_musica cm
		  WHERE c.compositor_id=cm.compositor_compositor_id AND cm.musica_musica_id=$mid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$cid = $row["cid"];
			if($incrementer==1){
				echo "<br><h2> Composers: </h2>";
				$incrementer = 2;
			}
			
			echo "<td><a href='#goComposer' id='sel_composer' onclick='composerFunction($cid)'>" . $row["cnome"] . "</a></td><br>";
		}
	}

	//PLAYLIST INFO
	$incrementer=1;
	$query = "SELECT p.playlist_id pid, p.nome pnome, p.pub_priv ppp
		  FROM playlist p, playlist_musica pm
		  WHERE p.playlist_id=pm.playlist_playlist_id AND pm.musica_musica_id=$mid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$pid = $row["pid"];
			if($incrementer==1){
				echo "<br><h2> Playlists: </h2>";
				$incrementer = 2;
			}
			if($row["ppp"] == 1){	//If pub_priv=1, then playlist is public. Otherwise it is private
				echo "<td><a href='#goPlaylist' id='sel_playlist' onclick='playlistFunction($pid)'>" . $row["pnome"] . "</a></td><br>";
			}
		}
	}

	echo "</div>";

	if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

		if($_SESSION['logged_in'] == 'YES'){
	
			$uid = $_SESSION['user_id'];
			$unome = $_SESSION['username'];
			echo "<div class='column' style='width: 600px; position: absolute; top:25px; left: 600px;'>";
				echo "<h1> Share with a friend! </h1>";
				echo "<form>";
					
					echo "<select id='usr-Select' style='position:absolute; left:16px; width:300px; color: white; background-color: #3E77EA;'  oninput='mid.value = $mid'>";
						
					$query = "SELECT u.user_id uid, u.nome unome FROM utilizador u WHERE u.nome <> '$unome'";
					if ($result = $mysqli->query($query)) {
						while($row = $result->fetch_assoc()) {
							$aux = $row['unome'];
							$aux2 = $row['uid'];
							echo "<option value='$aux2'>$aux</option>";
						}
					}
					echo "</select>";

					echo "<output name='song_id' id='mid' style='visibility:hidden;'>$mid</output>";

					echo "<button class='btn btn-primary btn-marginl' type='submit' id='share-button' style='position:absolute; left: 120px; top:90px;'>Submit!</button>";
				echo "</form>";

					
			echo "</div>";

			if($_SESSION["is_editor"] == 1){		
				echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:70px;' onclick='removeSong($mid)'>Delete Song</button>";
			}
		}
	}
			
	echo "</div>";

	//Close MySQL Database connection
	$mysqli->close();
?>




