<?php
	session_start();
?>

<script type="text/javascript">

	function songFunction(par){
	
		$('#midNav').load('songPage.php?mid=' + par);
	}
	
</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get search term from html
	$srch_term = $_GET["srch-term"];
	$srch_option = $_GET['srch-Select'];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	switch($srch_option){

		case 'musica':
			$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  FROM musica m 
				  WHERE (";
			$specify = "m.nome";
			break;

		case 'musico':
			$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  FROM musica m, musico mu, musico_musica mum
				  WHERE m.musica_id=mum.musica_musica_id AND mum.musico_musico_id=mu.musico_id AND (";
			$specify = "mu.nome";
			break;

		case 'gr_musical':
			$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  FROM musica m, album_musica am, album a, gr_musical gr
				  WHERE m.musica_id=am.musica_musica_id AND am.album_album_id=a.album_id AND a.gr_musical_grupo_id=gr.grupo_id AND (";
			$specify = "gr.nome";
			break;

		case 'album':
			$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  FROM musica m, album_musica am, album a
				  WHERE m.musica_id=am.musica_musica_id AND am.album_album_id=a.album_id AND (";
			$specify = "a.nome";
			break;

		case 'genero':
			$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  FROM musica m 
				  WHERE (";
			$specify = "m.genero";
			break;

		case 'Y':
			$regex = '/^[0-9]{4}$/';	
			if(strlen($srch_term) != 4 or !preg_match($regex, $srch_term)){
				echo "<script type='text/javascript'>alert('Invalid Format YYYY!');</script>";
				$query = "";
				$specify = "";
			} else {
				$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  	  FROM musica m 
				  	  WHERE (";
				$specify = "m.data_lancamento";
			}
			break;

		case 'YM':
			$regex = '/^([0-9]{4})-(0[1-9]|1[012])$/';	
			if(strlen($srch_term) != 7 or !preg_match($regex, $srch_term)){
				echo "<script type='text/javascript'>alert('Invalid Format YYYY-MM!');</script>";
				$query = "";
				$specify = "";
			} else {
				$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  	  FROM musica m 
				  	  WHERE (";
				$specify = "m.data_lancamento";
			}
			break;

		case 'YMD':
			$parts = explode('-', $srch_term);
			$regex = '/^([0-9]{4})-(0[1-9]|1[012])-([12][0-9]|3[01]|0[1-9])$/';
			if(strlen($srch_term) != 10 or !preg_match($regex, $srch_term)){
				echo "<script type='text/javascript'>alert('Invalid Format YYYY-MM-DD!');</script>";
				$query = "";
				$specify = "";
			} else if( $parts[1] == 2 && ( $parts[2] == 29 || $parts[2] == 30 || $parts[2] == 31 ) ) {
				echo "<script type='text/javascript'>alert('Invalid February Date!');</script>";
				$query = "";
				$specify = "";
				
			} else {

				$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
				  	  FROM musica m 
				  	  WHERE (";
				$specify = "m.data_lancamento";
			}
			break;

		case 'pontuacao':
			$regex = '/^([1-9]|10)$/';
			if( (strlen($srch_term) != 1 && strlen($srch_term) != 2) || !preg_match($regex, $srch_term)){
				echo "<script type='text/javascript'>alert('Scores range from 1 to 10!');</script>";
				$query = "";
				$specify = "";
			} else {

				$query = "SELECT DISTINCT m.musica_id mid, m.nome mnome
					  FROM musica m, album_musica am, album a, critica cr
					  WHERE m.musica_id=am.musica_musica_id AND am.album_album_id=a.album_id AND a.album_id=cr.album_album_id AND (";
				$specify = "cr.pontuacao";
			}			
			break;
	}






	//Get and print Songs belonging to musicians search results
	echo "<h2>Songs:</h2>";

	$c = false;
	foreach(explode(" ", $srch_term) as $b){

		if ($c){
			$query .= " OR";
		}
		$query .= " $specify LIKE " . "'%$b%'";
		$c = true;
	}
	$query .= ")";
 
	//echo "<h2>" . $query . "</h2>";

	$incrementer=1;
	$current_song="ajsfn3ugdfb";
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$mid = $row["mid"];
			if($mid != $current_song){
				$incrementer = 1;
			}
			if($incrementer==1){
				$current_song = $row["mid"];
				echo "<br><td><a href='#goSong' id='sel_song' onclick='songFunction($mid)'>" . $row["mnome"] . "</a>, by musician(s) "; 
				$incrementer = 2;
			}

			$inner_query = "SELECT DISTINCT mu.nome munome 
					FROM musica m, musico mu, musico_musica mum 
					WHERE m.musica_id=mum.musica_musica_id AND mum.musico_musico_id=mu.musico_id AND m.musica_id=$mid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					echo "<td>" . $inner_row["munome"] . "&nbsp&nbsp&nbsp</td>";
				}
			}
		}
	}
	


	//Close MySQL Database connection
	$mysqli->close();
?>



