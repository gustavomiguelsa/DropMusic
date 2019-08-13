<?php
	session_start();

?>
<script type="text/javascript">

	function bandFunction(par){
	
		$('#midNav').load('bandPage.php?grid=' + par);
	}

	function musicianFunction(par){
	
		$('#midNav').load('musicianPage.php?muid=' + par);
	}

	function removeConcert(coid) {
		
		$('#midNav').load('removeItem.php?type=' + 'concerto' + '&concert=' + coid);
        	return false;
    	}

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$coid = $_GET["coid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	} 

	//Get Concert Info
	$query = "SELECT co.duracao_min coduracao, co.data codata, co.lotacao colotacao, co.local colocal, co.musico_musico_id comuid, co.gr_musical_grupo_id cogrid FROM concerto co WHERE co.concerto_id=$coid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			
			if($row["comuid"] != NULL){	//If musician Id not NULL, then concert belongs to musician

				
				$inner_query = "SELECT mu.nome munome, mu.musico_id muid FROM musico mu, concerto co 
						WHERE co.musico_musico_id=mu.musico_id AND co.concerto_id=$coid";
				if ($inner_result = $mysqli->query($inner_query)) {
					while($inner_row = $inner_result->fetch_assoc()) {
						$muid = $inner_row["muid"];
						echo "<h1>Concert by <a href='#goMusician' id='sel_musician' onclick='musicianFunction($muid)'>" . $inner_row["munome"] . "</a></h1><br>";
					}
				}

			} else {			//Otherwise it belongs to a band

				$inner_query = "SELECT gr.nome grnome, gr.grupo_id grid FROM gr_musical gr, concerto co 
						WHERE co.gr_musical_grupo_id=gr.grupo_id AND co.concerto_id=$coid";
				if ($inner_result = $mysqli->query($inner_query)) {
					while($inner_row = $inner_result->fetch_assoc()) {
						$grid = $inner_row["grid"];
						echo "<h1>Concert by <a href='#goBand' id='sel_band' onclick='bandFunction($grid)'>" . $inner_row["grnome"] . "</a></h1><br>";
					}
				}
			}

			echo "<td> Located at: " . $row["colocal"] . "</td><br>";
			echo "<td> On: " . $row["codata"] . "</td><br>";
			echo "<td> Expected Duration: " . $row["coduracao"] . "</td><br>";
			echo "<td> Maximum Occupancy: " . $row["colotacao"] . "</td><br>";

		}
	}

	if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

		if($_SESSION['logged_in'] == 'YES' && $_SESSION["is_editor"] == 1){	
				echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:270px;' onclick='removeConcert($coid)'>Delete Concert</button>";
		}
	}

	//Close MySQL Database connection
	$mysqli->close();
?>
