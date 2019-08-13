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

	function removeReccom(eid) {
		
		$('#midNav').load('removeItem.php?type=' + 'editora' + '&reccom=' + eid);
        	return false;
    	}

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$eid = $_GET["eid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	} 

	//Get Reccord Company Info
	$query = "SELECT e.nome enome, e.morada emorada FROM editora e WHERE e.editora_id=$eid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			
			echo "<br><h1>" . $row["enome"] . "™ </h1>";
			echo "<td> Located at: " . $row["emorada"] . "</td>";

		}
	}	
	
	echo "<h2> Signed Musicians: </h2>";
	$query = "SELECT mu.nome munome, mu.ddn muddn, mu.musico_id muid FROM musico mu, musico_editora me WHERE mu.musico_id=me.musico_musico_id AND me.editora_editora_id=$eid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$muid = $row["muid"];
			echo "<td><a href='#goMusician' id='sel_musician' onclick='musicianFunction($muid)'>" . $row["munome"] . "</a>, born on " . $row["muddn"] . "</td><br>";
		}
	}	
	
	echo "<h2> Signed Bands: </h2>";
	$query = "SELECT gr.nome grnome, gr.grupo_id grid FROM gr_musical gr, gr_musical_editora ge WHERE gr.grupo_id=ge.gr_musical_grupo_id AND ge.editora_editora_id=$eid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$grid = $row["grid"];
			echo "<td><a href='#goBand' id='sel_band' onclick='bandFunction($grid)'>" . $row["grnome"] . "</a></td><br>";
		}
	}	

	if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

		if($_SESSION['logged_in'] == 'YES' && $_SESSION["is_editor"] == 1){	
						echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:270px;' onclick='removeReccom($eid)'>Delete Record Company</button>";
		}
	}

	//Close MySQL Database connection
	$mysqli->close();
?>




