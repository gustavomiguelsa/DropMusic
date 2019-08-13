<?php
	session_start();
?>

<script type="text/javascript">

	//function playlistFunction(par){ $('#midNav').load('playlistPage.php?pid=' + par); }

	function removeAlbum(aid) {
		
		$('#midNav').load('removeItem.php?type=' + 'album' + '&album=' + aid);
        	return false;
    	}
	
</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$choice = $_GET["type"];
	$aux = 0;
	$query_number = 0;

	//Initiate database connection
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	if($choice == "musica"){
	
		$mid = $_GET["song"];
		$delete[1] = "DELETE FROM utilizador_musica WHERE musica_musica_id=$mid";
		$delete[2] = "DELETE FROM playlist_musica WHERE musica_musica_id=$mid";
		$delete[3] = "DELETE FROM compositor_musica WHERE musica_musica_id=$mid";
		$delete[4] = "DELETE FROM musico_musica WHERE musica_musica_id=$mid";
		$delete[5] = "DELETE FROM album_musica WHERE musica_musica_id=$mid";
		$delete[6] = "DELETE FROM partilha WHERE item_id=$mid AND item_type='musica'";
		$delete[7] = "DELETE FROM musica WHERE musica_id=$mid";

		$query_number = 7;


	} else if($choice == "album"){
		$aux = 0;
		$aid = $_GET["album"];
		$delete[1] = "DELETE FROM critica WHERE album_album_id=$aid";
		$delete[2] = "DELETE FROM album_musica WHERE album_album_id=$aid";
		$delete[3] = "DELETE FROM album WHERE album_id=$aid";

		$query_number = 3;
	
	} else if($choice == "playlist"){
		$aux = 0;
		$pid = $_GET["playlist"];
		$delete[1] = "DELETE FROM playlist_musica WHERE playlist_playlist_id=$pid";
		$delete[2] = "DELETE FROM partilha WHERE item_id=$pid AND item_type='playlist'";
		$delete[3] = "DELETE FROM playlist WHERE playlist_id=$pid";

		$query_number = 3;
		
	} else if($choice == "gr_musical"){
		$aux = 0;
		$grid = $_GET["band"];
		
		$inner_query = "SELECT album_id aid FROM album WHERE gr_musical_grupo_id=$grid";
		if ($inner_result = $mysqli->query($inner_query)) {
			for($i=1; $inner_row = $inner_result->fetch_assoc(); $i++) {
				$aid = $inner_row["aid"];
				echo "<script type='text/javascript'> removeAlbum($aid); </script>";
			}
		}

		$delete[1] = "DELETE FROM periodo WHERE gr_musical_grupo_id=$grid";
		$delete[2] = "DELETE FROM gr_musical_editora WHERE gr_musical_grupo_id=$grid";
		$delete[3] = "DELETE FROM concerto WHERE gr_musical_grupo_id=$grid";
		$delete[4] = "DELETE FROM musico_gr_musical WHERE gr_musical_grupo_id=$grid";
		$delete[5] = "DELETE FROM gr_musical WHERE grupo_id=$grid";
		
		$query_number = 5;

	} else if($choice == "musico"){
		$aux = 0;
		$muid = $_GET["musician"];
		
		$inner_query = "SELECT album_id aid FROM album WHERE musico_musico_id=$muid";
		if ($inner_result = $mysqli->query($inner_query)) {
			for($i=1; $inner_row = $inner_result->fetch_assoc(); $i++) {
				$aid = $inner_row["aid"];
				echo "<script type='text/javascript'> removeAlbum($aid); </script>";
			}
		}

		$delete[1] = "DELETE FROM musico_musica WHERE musico_musico_id=$muid";
		$delete[2] = "DELETE FROM compositor_musico WHERE musico_musico_id=$muid";
		$delete[3] = "DELETE FROM musico_editora WHERE musico_musico_id=$muid";
		$delete[4] = "DELETE FROM concerto WHERE musico_musico_id=$muid";
		$delete[5] = "DELETE FROM musico_gr_musical WHERE musico_musico_id=$muid";
		$delete[6] = "DELETE FROM musico WHERE musico_id=$muid";

		$query_number = 6;

	} else if($choice == "compositor"){
		$aux = 0;
		$cid = $_GET["composer"];

		$delete[1] = "DELETE FROM compositor_musica WHERE compositor_compositor_id=$cid";
		$delete[2] = "DELETE FROM compositor_musico WHERE compositor_compositor_id=$cid";
		$delete[3] = "DELETE FROM compositor WHERE compositor_id=$cid";

		$query_number = 3;

	} else if($choice == "concerto"){
		$aux = 0;
		$coid = $_GET["concert"];

		$delete[1] = "DELETE FROM concerto WHERE concerto_id=$coid";

		$query_number = 1;

	} else if($choice == "editora"){
		$aux = 0;
		$eid = $_GET["reccom"];

		$delete[1] = "DELETE FROM musico_editora WHERE editora_editora_id=$eid";
		$delete[2] = "DELETE FROM gr_musical_editora WHERE editora_editora_id=$eid";
		$delete[3] = "DELETE FROM editora WHERE editora_id=$eid";

		$query_number = 3;
	}

	for($i = 1; $i <= $query_number; $i++){

		$result[$i] = $mysqli->query($delete[$i]);
		if( $result[$i] == NULL){ echo "<h1>There was an issue with your request!</h1>"; $aux=1; break; }
	}

	if($aux == 0){ echo "<h1>Item successfully removed!</h1>"; }

	//Close MySQL Database connection
	$mysqli->close();

?>





