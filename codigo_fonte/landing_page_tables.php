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

</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	/* Funtion responsible for building the table on the landing page concerning the existing shows within this week.*/
	function build_table_shows($array, $array1){
	    // Start table
	    $html = '<table class="table table-hover"';
	    $html .= '<thead>';
	    // Header row
	    $html .= '<tr>';

 	    $html .= '<th>' . "Expected Duration" . '</th>';
	    $html .= '<th>' . "On" . '</th>';
	    $html .= '<th>' . "Maximum Occupancy" . '</th>';	
	    $html .= '<th>' . "Located at" . '</th>';
	    $html .= '<th>' . "By" . '</th>';
	    
	    $html .= '</tr>';
	    
	    $html .= '</thead>';
	
	    // Data rows
	    $html .= '<tbody>';

	    $increment = 0;

	    /* For each row of the array*/
	    foreach( $array as $key=>$value){
		$html .= '<tr>';
		/* For each column of the array*/
		foreach($value as $key2=>$value2){
		    /* Expected Duration */
		    if ($key2 == "coduracao"){
			$html .= '<td>' . htmlspecialchars($value2) . " min" .'</td>';
		    }
		    /* Either the name of the musician or the band is written into the By column */
		    if ($key2 == "cogrid" && $value2 != ""){
			$html .= "<td><a href='#goBand' onclick='bandFunction($value2)'>" . htmlspecialchars($array1[$increment]) . "</a></td>";
		    }
		    if ($key2 == "comuid" && $value2 != ""){
			$html .= "<td ><a href='#goMusician' onclick='musicianFunction($value2)'>" . htmlspecialchars($array1[$increment]) . "</a></td>";
		    }
		    /* For the other columns (On, Maximum Occupancy, Located at) */
		    if ($key2 == "codata" || $key2 == "colotacao" || $key2 == "colocal") {
			$html .= '<td>' . htmlspecialchars($value2) . '</td>';
		    } 
		}
		// End of the columns
		$html .= '</tr>';
		$increment = $increment + 1;
	    }
	    // End of the rows
	    // Finish table
	    $html .= '</tbody>';
	    $html .= '</table>';
	    /* Return table */
	    return $html;
	}
	
	/* Funtion responsible for building the table on the landing page concerning the recently added playlists.*/
	function build_table_recently_added($array){
	    // Start table
	    $html = '<table class="table table-hover"';
	    
            // Header row
	    $html .= '<thead>';
	    
	    $html .= '<tr>';
	    $html .= '<th>' . "Playlist name" . '</th>';
	    $html .= '<th>' . "Date" . '</th>';
	    $html .= '<th>' . "User" . '</th>';
	    $html .= '</tr>';
	    
	    $html .= '</thead>';

	    $html .= '<tbody>';
	    /* For each row of the array */
	    foreach( $array as $key=>$value){
		$html .= '<tr>';
		/* For each column of the array */
		foreach($value as $key2=>$value2){
		    /* There is no required parsing here because the array is perfectly aligned with the table's columns */
		    $html .= '<td>' . htmlspecialchars($value2) . '</td>';
		}
		// End of the columns
		$html .= '</tr>';
	    }
	    
	    // Finish table
	    $html .= '</tbody>';
	    $html .= '</table>';
	    // Return the table
	    return $html;
	}

	/**/
	function build_table_born_today($array, $array1, $array2) {
	// Start table
	    //$html = '<table class="table table-hover"';
	    echo '<table class="table table-hover"';
	    echo "<thead>";
	    echo "<tr>";
	    echo "<th>User</th>";
	    echo "<th>Musician</th>";
	    echo "<th>Composer</th>";
	    echo "</tr>";

	    echo "</thead>";
	    echo "<tbody>";
															//($users,$composers,$musicians);
	   	if(sizeof($array) >= sizeof($array1)){
		   if(sizeof($array) >= sizeof($array2)) {
			//echo "Array is the biggest <br>";
			$size = sizeof($array);
			
			for($row = 0; $row < $size; $row++){
				//echo $array[$row] . "<br>";
				//$html .= '<tr>';
				echo "<tr>";
				echo "<td>" . htmlspecialchars($array[$row]) . "</td>";
				//$html .= '<td>' . htmlspecialchars($array[$row]) . '</td>';
				if($row < sizeof($array2)){
					echo "<td>" . htmlspecialchars($array2[$row]) . "</td>";
					//$html .= '<td>' . htmlspecialchars($array2[$row]) . '</td>';
				}
				else{
					echo "<td></td>";
				}
				if($row < sizeof($array1)){
					echo "<td>" . htmlspecialchars($array1[$row]) . "</td>";
					//$html .= '<td>' . htmlspecialchars($array1[$row]) . '</td>';
				}
				else{
					echo "<td></td>";
				}
				
				//$html .= '</tr>';
				echo "</tr>";
			}
		    }
		    else {
			$size = sizeof($array2);
			for($row = 0; $row < $size; $row++){
				//echo $array[$row] . "<br>";
				//$html .= '<tr>';
				echo "<tr>";
				if($row < sizeof($array)){
					echo "<td>" . htmlspecialchars($array[$row]) . "</td>";
					//$html .= '<td>' . htmlspecialchars($array1[$row]) . '</td>';
				}
				else{
					echo "<td></td>";
				}
				echo "<td>" . htmlspecialchars($array2[$row]) . "</td>";
				//$html .= '<td>' . htmlspecialchars($array[$row]) . '</td>';
				if($row < sizeof($array1)){
					echo "<td>" . htmlspecialchars($array1[$row]) . "</td>";
					//$html .= '<td>' . htmlspecialchars($array2[$row]) . '</td>';
				}
				else{
					echo "<td></td>";
				}
				//$html .= '</tr>';
				echo "</tr>";
			}

		    }
		}
		else{
			if(sizeof($array1) >= sizeof($array2)) {
			//echo "Array is the biggest <br>";
			$size = sizeof($array1);
			
			for($row = 0; $row < $size; $row++){
				//echo $array[$row] . "<br>";
				//$html .= '<tr>';
				echo "<tr>";
				if($row < sizeof($array)){
					echo "<td>" . htmlspecialchars($array[$row]) . "</td>";
					//$html .= '<td>' . htmlspecialchars($array1[$row]) . '</td>';
				}
				else{
					echo "<td></td>";
				}
				if($row < sizeof($array2)){
					echo "<td>" . htmlspecialchars($array2[$row]) . "</td>";
					//$html .= '<td>' . htmlspecialchars($array2[$row]) . '</td>';
				}
				else{
					echo "<td></td>";
				}
				echo "<td>" . htmlspecialchars($array1[$row]) . "</td>";
				//$html .= '<td>' . htmlspecialchars($array[$row]) . '</td>';
				//$html .= '</tr>';
				echo "</tr>";
			   }
		        }
			else {
				//echo "Array is the biggest <br>";
				$size = sizeof($array2);
				
				for($row = 0; $row < $size; $row++){
					//echo $array[$row] . "<br>";
					//$html .= '<tr>';
					echo "<tr>";
					if($row < sizeof($array)){
						echo "<td>" . htmlspecialchars($array[$row]) . "</td>";
						//$html .= '<td>' . htmlspecialchars($array1[$row]) . '</td>';
					}
					else{
						echo "<td></td>";
					}
					echo "<td>" . htmlspecialchars($array2[$row]) . "</td>";
					//$html .= '<td>' . htmlspecialchars($array[$row]) . '</td>';
					if($row < sizeof($array1)){
						echo "<td>" . htmlspecialchars($array1[$row]) . "</td>";
						//$html .= '<td>' . htmlspecialchars($array2[$row]) . '</td>';
					}
					else{
						echo "<td></td>";
					}
					//$html .= '</tr>';
					echo "</tr>";
				}
			}
		}
	    echo "</tbody>";

		echo "</table>";
	}

	function build_table_playlists($array){
	    // Start table
	    echo '<table class="table table-hover"';
	    
            // Header row
	    echo '<thead>';
	    
	    echo'<tr>';
	    echo '<th>' . "Playlist name" . '</th>';
	    echo '<th>' . "Owner" . '</th>';
	    echo '<th>' . "# of Followers" . '</th>';
	    echo '</tr>';
	    
	    echo '</thead>';

	    echo '<tbody>';
	    /* For each row of the array */
	    foreach( $array as $key=>$value){
		echo '<tr>';
		/* For each column of the array */
		foreach($value as $key2=>$value2){
		    /* There is no required parsing here because the array is perfectly aligned with the table's columns */
		    echo '<td>' . htmlspecialchars($value2) . '</td>';
		}
		// End of the columns
		echo '</tr>';
	    }
	    
	    // Finish table
	    echo '</tbody>';
	    echo '</table>';
	    // Return the table
		//return $html;
	}

	/* Connect to the used database */
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");

	echo "<h1>Recently Added:</h1>";

	
	$playlists = array(); // this will store the information about the playlists
	
	/* Prepare the query */
	$query = "SELECT p.nome pnome, p.data_criacao pdata, u.nome unome 
		FROM playlist p, utilizador u
		WHERE u.user_id=p.utilizador_user_id AND p.pub_priv=1 ORDER BY p.playlist_id DESC LIMIT 10";
	
	if ($result = $mysqli->query($query)) {
		/* For each row returned from the database */
		while($row = $result->fetch_assoc()) {
			$playlists[] = $row;
		}
	}
	
	/* Having the information we need about the playlists, it's time to build the table within the html page */
	echo build_table_recently_added($playlists);

	
	echo "<h1>Shows Playing This Week:</h1>";

	$shows = array(); /* This will store the information about the shows */
	$shows_by = array(); /* This will store the information about the bands perfoming on those shows */
	
	$query = "SELECT co.duracao_min coduracao, co.data codata, co.lotacao colotacao, co.local colocal, co.musico_musico_id comuid, co.gr_musical_grupo_id cogrid FROM concerto co WHERE co.data >= CURDATE() AND YEARWEEK(co.data, 1) = YEARWEEK(CURDATE(), 1) ORDER BY co.data ASC LIMIT 10";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			
			if($row["comuid"] != NULL){	//If musician Id not NULL, then concert belongs to musician

				
				$inner_query = "SELECT mu.nome munome, mu.musico_id muid FROM musico mu, concerto co 
						WHERE co.musico_musico_id=mu.musico_id";
				if ($inner_result = $mysqli->query($inner_query)) {
					while($inner_row = $inner_result->fetch_assoc()) {
						$muid = $inner_row["muid"];
						
					}
				}

			} else {			//Otherwise it belongs to a band

				$inner_query = "SELECT gr.nome grnome, gr.grupo_id grid FROM gr_musical gr, concerto co 
						WHERE co.gr_musical_grupo_id=gr.grupo_id";
				if ($inner_result = $mysqli->query($inner_query)) {
					while($inner_row = $inner_result->fetch_assoc()) {
						$grid = $inner_row["grid"];
					}
				}
			}
			/* If it is a musician that will perform on the show, we need his/her name */
			if($row["comuid"] != "" && $row["cogrid"] == ""){
				$idmu = $row["comuid"];

				$query1 = "SELECT nome FROM musico WHERE musico_id =$idmu";
				if ($result1 = $mysqli->query($query1)) {
					while($row1 = $result1->fetch_assoc()) {
						$shows_by[] = $row1["nome"];
					}
				}
			}
			/* If it is a band that will perform on the show, we need its name */
			if($row["comuid"] == "" && $row["cogrid"] != ""){
				$idgr = $row["cogrid"];

				$query2 = "SELECT nome FROM gr_musical WHERE grupo_id =$idgr";
				if ($result2 = $mysqli->query($query2)) {
					while($row2 = $result2->fetch_assoc()) {
						$shows_by[] = $row2["nome"];
					}
				}
			}
			$shows[] = $row;
		}
	}
	
	echo build_table_shows($shows, $shows_by);

	echo "<h1> Born Today: </h1>";

	$users = array();
	$musicians = array();
	$composers = array();

	/*$query = "SELECT m.nome mnome, c.nome cnome, u.nome unome
			FROM utilizador u, compositor c, musico m
			WHERE m.ddn = CURDATE() OR c.ddn = CURDATE() OR u.ddn = CURDATE() LIMIT 10";*/

	$query = "SELECT nome FROM utilizador WHERE MONTH(ddn) = MONTH(CURDATE()) AND DAY(ddn) = DAY(CURDATE()) LIMIT 10";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			//echo "User : " . $row["nome"] . "<br>";
			//echo "Composer : " . $row["cnome"] . "<br>";
			//echo "Musician : " . $row["mnome"] . "<br>";
			$users[] = $row["nome"];
		}
	}
	$query = "SELECT nome FROM compositor WHERE MONTH(ddn) = MONTH(CURDATE()) AND DAY(ddn) = DAY(CURDATE()) LIMIT 10";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			//echo "User : " . $row["nome"] . "<br>";
			//echo "Composer : " . $row["cnome"] . "<br>";
			//echo "Musician : " . $row["mnome"] . "<br>";
			$composers[] = $row["nome"];
		}
	}
	$query = "SELECT nome FROM musico WHERE MONTH(ddn) = MONTH(CURDATE()) AND DAY(ddn) = DAY(CURDATE()) LIMIT 10";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			//echo "User : " . $row["nome"] . "<br>";
			//echo "Composer : " . $row["cnome"] . "<br>";
			//echo "Musician : " . $row["mnome"] . "<br>";
			$musicians[] = $row["nome"];
		}
	}
	build_table_born_today($users,$composers,$musicians);
	
	
	echo "<h1>Most Popular Playlists</h1>";
	$playlists = array();
	$final = array();
	$query = "SELECT pa.item_id paid, count(*) soma
		FROM partilha pa
		WHERE pa.item_type = 'playlist' 
		GROUP BY pa.item_id
		ORDER BY pa.item_id DESC LIMIT 10";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			//$soma[] = $row["soma"];
			$pid = $row["paid"];
			$soma = $row["soma"];
			$inner_query = "SELECT p.nome pnome, u.nome unome
					FROM playlist p, utilizador u
					WHERE p.playlist_id = $pid AND p.pub_priv = 1 AND u.user_id = p.utilizador_user_id";
			if($inner_result = $mysqli->query($inner_query)){
				while($inner_row = $inner_result->fetch_assoc()) {
					$final[] = array("pnome"=>$inner_row["pnome"], "unome"=>$inner_row["unome"], "soma"=>$soma);
				}
			}
		}
	}
	build_table_playlists($final);
	
	//Close MySQL Database connection
	$mysqli->close();

	
?>


