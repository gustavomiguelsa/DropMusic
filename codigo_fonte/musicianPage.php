<?php
	session_start();

?>

<script type="text/javascript">

	function concertFunction(par){
	
		$('#midNav').load('concertPage.php?coid=' + par);
	}

	function composerFunction(par){
	
		$('#midNav').load('composerPage.php?cid=' + par);
	}

	function removeMusician(muid) {
		
		$('#midNav').load('removeItem.php?type=' + 'musico' + '&musician=' + muid);
        	return false;
    	}

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$muid = $_GET["muid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	} 

	//Get Musician Info
	$query = "SELECT mu.nome munome, mu.ddn muddn, mu.bio mubio
		  FROM musico mu
		  WHERE mu.musico_id=$muid";

	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			
			echo "<br><h1>Musician: " . $row["munome"] . "</h1>";
			echo "<td> Date of Birth: " . $row["muddn"] . "</td><br>";

			$inner_query = "SELECT cm.compositor_compositor_id cmcid FROM compositor_musico cm WHERE cm.musico_musico_id=$muid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$cmcid = $inner_row["cmcid"];
					echo "<td>This musician is also a <a href='#goComposer' id='sel_composer' onclick='composerFunction($cmcid)'>composer</a>!</td>";
				}
			}

			echo "<br><h2> Short Bio: </h2><td>" . $row["mubio"] . "</td><br>";

		}
	}

	echo "<h2> Concerts: </h2>";
	$query = "SELECT co.concerto_id coid, co.data codata, co.local colocal FROM concerto co WHERE co.musico_musico_id=$muid";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$coid = $row["coid"];
			echo "<td><a href='#goConcert' id='sel_concert' onclick='concertFunction($coid)'>" . $row["codata"] . "</a></td>";
			echo "<td> in " . $row["colocal"] . "</td><br>";
		}
	}

	if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

		if($_SESSION['logged_in'] == 'YES' && $_SESSION["is_editor"] == 1){	
						echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:270px;' onclick='removeMusician($muid)'>Delete Musician</button>";
		}
	}	

	//Close MySQL Database connection
	$mysqli->close();
?>


