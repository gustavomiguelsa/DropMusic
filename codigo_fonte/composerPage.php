<?php
	session_start();

?>

<script type="text/javascript">

	function musicianFunction(par){
	
		$('#midNav').load('musicianPage.php?muid=' + par);
	}

	function removeComposer(cid) {
		
		$('#midNav').load('removeItem.php?type=' + 'compositor' + '&composer=' + cid);
        	return false;
    	}

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$cid = $_GET["cid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	} 

	//Get Composer Info
	$query = "SELECT c.nome cnome, c.ddn cddn, c.bio cbio
		  FROM compositor c
		  WHERE c.compositor_id=$cid";


	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			
			echo "<br><h1>Composer: " . $row["cnome"] . "</h1>";
			echo "<td> Date of Birth: " . $row["cddn"] . "</td><br>";

			$inner_query = "SELECT cm.musico_musico_id cmmuid FROM compositor_musico cm WHERE cm.compositor_compositor_id=$cid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$cmmuid = $inner_row["cmmuid"];
					echo "<td>This composer is also a <a href='#goMusician' id='sel_musician' onclick='musicianFunction($cmmuid)'>musician</a>!</td>";
				}
			}
			

			echo "<br><h2> Short Bio: </h2><td>" . $row["cbio"] . "</td><br>";

		}
	}

	if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

		if($_SESSION['logged_in'] == 'YES' && $_SESSION["is_editor"] == 1){	
						echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:270px;' onclick='removeComposer($cid)'>Delete Composer</button>";
		}
	}	

	//Close MySQL Database connection
	$mysqli->close();
?>




