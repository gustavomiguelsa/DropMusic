<?php
	session_start();

?>

<script type="text/javascript">

	function reccomFunction(par){
	
		$('#midNav').load('reccomPage.php?eid=' + par);
	}
	
	function musicianFunction(par){
	
		$('#midNav').load('musicianPage.php?muid=' + par);
	}

	function concertFunction(par){
	
		$('#midNav').load('concertPage.php?coid=' + par);
	}

	function removeBand(grid) {
		
		$('#midNav').load('removeItem.php?type=' + 'gr_musical' + '&band=' + grid);
        	return false;
    	}

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$grid = $_GET["grid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	} 

	//Get Band Info
	$query = "SELECT gr.grupo_id grid, gr.nome grnome, gr.historia hist 
		  FROM gr_musical gr
		  WHERE gr.grupo_id=$grid";

	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			
			echo "<br><h1>" . $row["grnome"] . "</h1>";
			
			$inner_query = "SELECT e.nome enome, e.editora_id eid FROM editora e, gr_musical_editora gre
					WHERE gre.gr_musical_grupo_id=$grid AND gre.editora_editora_id=e.editora_id";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$eid = $inner_row["eid"];
					echo "<td> Signed with: <a href='#goReccom' id='sel_reccom' onclick='reccomFunction($eid)'>" . $inner_row["enome"] . "™</a></td><br>";
				}
			}

			echo "<h2> Members: </h2>";
			$inner_query = "SELECT mu.nome munome, mu.musico_id muid FROM musico mu, musico_gr_musical mgm WHERE mgm.musico_musico_id=mu.musico_id AND mgm.gr_musical_grupo_id=$grid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$muid = $inner_row["muid"];
					echo "<td><a href='#goMusician' id='sel_musician' onclick='musicianFunction($muid)'>" . $inner_row["munome"] . "</a></td><br>";
				}
			}	


			echo "<h2> Active during: </h2>";

			$inner_query = "SELECT inicio, fim FROM periodo WHERE gr_musical_grupo_id=$grid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					
					echo "<td>" . $inner_row["inicio"] . " until " . $inner_row["fim"] . "</td><br>";
				}
			}

			echo "<h2> History: </h2><td>" . $row["hist"] . "</td><br>";

			echo "<h2> Concerts: </h2>";
			$inner_query = "SELECT co.concerto_id coid, co.data codata, co.local colocal FROM concerto co WHERE co.gr_musical_grupo_id=$grid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$coid = $inner_row["coid"];
					echo "<td><a href='#goConcert' id='sel_concert' onclick='concertFunction($coid)'>" . $inner_row["codata"] . "</a></td>";
					echo "<td> in " . $inner_row["colocal"] . "</td><br>";
				}
			}
			
		}
	}

	if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

		if($_SESSION['logged_in'] == 'YES' && $_SESSION["is_editor"] == 1){
						echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:270px;' onclick='removeBand($grid)'>Delete Band</button>";
		}
	}	


	//Close MySQL Database connection
	$mysqli->close();
?>

