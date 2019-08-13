<?php
	session_start();

?>

<script type="text/javascript">

	function songFunction(par){ $('#midNav').load('songPage.php?mid=' + par); }

	function albumFunction(par){ $('#midNav').load('albumPage.php?aid=' + par); }

	function playlistFunction(par){ $('#midNav').load('playlistPage.php?pid=' + par); }

	function bandFunction(par){ $('#midNav').load('bandPage.php?grid=' + par); }

	function musicianFunction(par){ $('#midNav').load('musicianPage.php?muid=' + par); }

	function composerFunction(par){ $('#midNav').load('composerPage.php?cid=' + par); }

	function reccomFunction(par){ $('#midNav').load('reccomPage.php?eid=' + par); }
	
	function concertFunction(par){ $('#midNav').load('concertPage.php?coid=' + par); }

	function addItem(type){
		var aux = "";
		if(type == 2) aux = "musica"; else if(type == 3) aux = "album"; else if(type == 4) aux = "gr_musical"; else if(type == 5) aux = "musico";
		else if(type == 6) aux = "compositor"; else if(type == 7) aux = "concerto"; else if(type == 8) aux = "editora";
		//alert(aux);
		//$('#midNav').load('addItem.php?&choice=' + aux);
		$('#midNav').load('addItem.php?&choice=' + type);
	}

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$identifier = $_GET["identifier"];
	$query_srch_term = "nome qst";

	$id = 0;
	$adder = "";

	switch($identifier){

		case 'musica':
			echo "<h1> Songs </h1>";
			$query_srch_term .= ",musica_id";
			$function = "song";
			$adder = 2;
			break;
		case 'album':
			echo "<h1> Albums </h1>";
			$query_srch_term .= ",album_id";
			$function = "album";
			$adder = 3;
			break;
		case 'critica':
			echo "<h1> Reviews </h1>";
			$query_srch_term = "cr.titulo qst, a.nome anome";
			$identifier .= ' cr, album a WHERE cr.album_album_id=a.album_id';
			$function = "";
			break;
		case 'playlist':
			echo "<h1> Playlists </h1>";
			$query_srch_term .= ",playlist_id, pub_priv";
			$function = "playlist";
			break;
		case 'gr_musical':
			echo "<h1> Bands </h1>";
			$query_srch_term .= ",grupo_id";
			$function = "band";
			$adder = 4;
			break;
		case 'musico':
			echo "<h1> Musicians </h1>";
			$query_srch_term .= ",musico_id";
			$function = "musician";
			$adder = 5;
			break;
		case 'compositor':
			echo "<h1> Composers </h1>";
			$query_srch_term .= ",compositor_id";
			$function = "composer";
			$adder = 6;
			break;
		case 'concerto':
			echo "<h1> Concerts </h1>";
			$query_srch_term = "data qst, musico_musico_id comuid, gr_musical_grupo_id cogrid, concerto_id";
			$function = "concert";
			$adder = 7;
			break;
		case 'editora':
			echo "<h1> Record Companies </h1>";
			$query_srch_term .= ",editora_id";
			$function = "reccom";
			$adder = 8;
			break;
	}

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	$aux_save = $function;	//To save function string for next loop iteration
	$query = "SELECT $query_srch_term FROM $identifier";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			if($identifier != 'critica cr, album a WHERE cr.album_album_id=a.album_id' && $identifier != 'playlist'){
				if($identifier == 'gr_musical'){
					$id = $row["grupo"."_id"];
				} else { 
					$id = $row["$identifier"."_id"];

				}
					
				$function .= "Function($id)";

				
				echo "<td><a href='#goItem' id='sel_item' onclick='$function'>" . $row["qst"] . "</a></td>";
		

				/******************IF DEALING WITH CONCERTS***************************************/
				if($identifier == 'concerto'){
						
					if($row["comuid"] != NULL){	//If musician Id not NULL, then concert belongs to musician

				
						$inner_query = "SELECT mu.nome munome, mu.musico_id muid FROM musico mu, concerto co 
								WHERE co.musico_musico_id=mu.musico_id AND co.concerto_id=$id";
						if ($inner_result = $mysqli->query($inner_query)) {
							while($inner_row = $inner_result->fetch_assoc()) {
								$muid = $inner_row["muid"];
								echo "<td> by <a href='#goMusician' id='sel_musician' onclick='musicianFunction($muid)'>" . $inner_row["munome"] . "</a></td>";
							}
						}

					} else {			//Otherwise it belongs to a band

						$inner_query = "SELECT gr.nome grnome, gr.grupo_id grid FROM gr_musical gr, concerto co 
								WHERE co.gr_musical_grupo_id=gr.grupo_id AND co.concerto_id=$id";
						if ($inner_result = $mysqli->query($inner_query)) {
							while($inner_row = $inner_result->fetch_assoc()) {
								$grid = $inner_row["grid"];
								echo "<td> by <a href='#goBand' id='sel_band' onclick='bandFunction($grid)'>" . $inner_row["grnome"] . "</a></td>";
							}
						}
					}
				}
				/*********************************************************************************/
				echo "<br>";

			} else if ($identifier == 'critica cr, album a WHERE cr.album_album_id=a.album_id') {

				echo "<td>" . $row["qst"] . " - " . $row["anome"] . "</td><br>";
			} else {

				if($row["pub_priv"] == 1){
					$id = $row["$identifier"."_id"];
					$function .= "Function($id)";		
					echo "<td><a href='#goItem' id='sel_item' onclick='$function'>" . $row["qst"] . "</a></td>";
					echo "<br>";
				} 
			}
			
			$function = $aux_save;
		}
	}

	if( session_status() != PHP_SESSION_NONE  && $adder != "" && isset($_SESSION['logged_in'])){
		if($_SESSION['logged_in'] == 'YES' && $_SESSION["is_editor"] == 1){		
			echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: green; position:absolute; left: 980px; top:270px;' onclick='addItem($adder)'>Add Item</button>";
		}
	}
	
	
	//Close MySQL Database connection
	$mysqli->close();
?>






