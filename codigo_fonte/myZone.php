<?php
	session_start();
?>

<script type="text/javascript">

	function playlistFunction(par){ 

		$('#midNav').load('playlistPage.php?pid=' + par); 
	}
	function songFunction(par){
	
		$('#midNav').load('songPage.php?mid=' + par);
	}
	
</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	/* Funtion responsible for building the table on the My Zone page concerning the musics that are associated to the user. */
	function build_table_musics($array, $yn){
	    // Start table
	    echo '<table class="table table-hover">';
	    
            // Header row
	    echo '<thead>';
	  
	    echo '<tr>';
	    echo '<th>' . "Music Name" . '</th>';
	    echo '<th>' . "Genre" . '</th>';
	    echo '<th>' . "Release Date" . '</th>';
	    echo '<th>' . "Link" . '</th>';
	    if($yn == 'Y'){
		echo '<th>' . "Sent By" . '</th>';
	    }
	    echo '<th>' . "View" . '</th>';
	    echo '</tr>';
	    
	    echo '</thead>';

	    echo '<tbody>';
	    /* For each row of the array */
	    foreach( $array as $key=>$value){
		echo '<tr>';
		/* For each column of the array */
		foreach($value as $key2=>$value2){
		    /* There is no required parsing here because the array is perfectly aligned with the table's columns */
		    if($key2 == "mlink"){
			if($value2 == "none" || $value2 == NULL){
				echo '<td>' . htmlspecialchars($value2) . '</td>';
			}
			else{
				echo '<td><a href=' . htmlspecialchars($value2) . ' target="_blank" >Click Here!</a></td>';
			}
		    }
		    else if($key2 == "mid"){
			$mid = $value2;
		    }
//		    else if($key2 == "unome"){
//			if($yn == 'Y'){
//			    echo '<td>' . $value2 . '</td>';
//			}
//		    }
		    else {
		    	echo '<td>' . htmlspecialchars($value2) . '</td>';
		    }
		}
		echo "<td><a href='#goSong' id='sel_song' onclick='songFunction($mid)'>Let's go!</a></td>";
		// End of the columns
		echo '</tr>';
	    }
	    
	    // Finish table
	    echo '</tbody>';
	    echo '</table>';
	    // Return the table
	    //return $html;
	}

	/* Funtion responsible for building the table on the landing page concerning the recently added playlists.*/
	function build_table_playlists($array,$yn){
	    // Start table
	    echo '<table class="table table-hover">';
	    
            // Header row
	    echo '<thead>';
	  
	    echo '<tr>';
	    echo '<th>' . "Playlist Name" . '</th>';
	    echo '<th>' . "Public?" . '</th>';
	    if($yn == 'Y'){
		echo '<th>' . "Sent By" . '</th>';
	    }
	    echo '<th>' . "View" . '</th>';
	    echo '</tr>';
	    
	    echo '</thead>';

	    echo '<tbody>';
	    /* For each row of the array */
	    foreach( $array as $key=>$value){
		echo '<tr>';
		/* For each column of the array */
		foreach($value as $key2=>$value2){
		    /* There is no required parsing here because the array is perfectly aligned with the table's columns */
		    if($key2 == "ppub"){
			if($value2 == 1){
				echo '<td>Yes</td>';
			}
			else{
				echo '<td>No</td>';
			}

		    }
		    else if($key2 == "pid"){
			$pid = $value2;
		    }
		    else if($key2 == "pnome"){
			    echo '<td>' . htmlspecialchars($value2) . '</td>';
		    }
		    else {
			if($yn == 'Y'){
			    echo '<td>' . $value2 . '</td>';
			}
		    }
		    
		}
		echo "<td><a href='#goPlaylist' id='sel_playlist' onclick='playlistFunction($pid)'>Let's go!</a></td>";
		// End of the columns
		echo '</tr>';
	    }
	    
	    // Finish table
	    echo '</tbody>';
	    echo '</table>';
	    // Return the table
	    //return $html;
	}


	$user_id = $_SESSION["user_id"];
	$user = $_SESSION["username"];
	//echo '<div class="justify-content-center">';
	//echo "<h2>" . $_SESSION["username"] . "</h1>";
	//echo "<h2>" . $_SESSION["user_id"] . "</h2>";
	/* Connect to the used database */
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	
	/* Prepare the query */
	$query = "SELECT u.is_editor ueditor, u.sexo ugender, u.ddn uddn 
		FROM utilizador u
		WHERE u.user_id=$user_id";
	
	if ($result = $mysqli->query($query)) {
		/* For each row returned from the database */
		while($row = $result->fetch_assoc()) {
			$gender = $row["ugender"];
			$ddn = $row["uddn"];
			$editor = $row["ueditor"];
			//echo "Info: " . $gender . " -- " . $ddn . " -- " . $editor . "<br>";
		}
	}

	echo '<center>';
	
	echo "<h1> Hello, " . $user . ". Nice to have you here again!</h1>";
	if($gender == 'M'){
		$gender = "Male";
		echo '<img src="male.png" class="rounded-circle">';
	}
	else if($gender == 'F') {
		$gender = "Female";
		echo '<img src="female.png" height="227" width="222" class="rounded-circle">';
	}
	else if($gender == 'O') {
		$gender = "Other";
		echo '<img src="user.png" height="227" width="222" class="rounded-circle">';
	}
	if($editor == 1){
		$editor = "Yes";
		echo "<h4>You are an editor! Feel free to write reviews, add items or view all your private and public playlists.</h4>";
	}
	else if($editor == 0) {
		$editor = "No";
		echo "<h4>Unfortunately, you are not an editor... But you can still write reviews and view all your private and public playlists!</h4>";
	}
	
	
	
	$musicas = array();
	/* Prepare the query */
	$query = "SELECT um.musica_musica_id umid
		FROM utilizador_musica um
		WHERE um.utilizador_user_id=$user_id";

	if ($result = $mysqli->query($query)) {
		/* For each row returned from the database */
		while($row = $result->fetch_assoc()) {
			$mid = $row["umid"];
			$inner_query = "SELECT m.musica_id mid, m.nome mnome, m.genero mgenero, m.data_lancamento mdata, m.link mlink
					FROM musica m
					WHERE m.musica_id = $mid";
			if($inner_result = $mysqli->query($inner_query)){
				while($inner_row = $inner_result->fetch_assoc()){
					$musicas[] = $inner_row;
					//print_r($inner_row);
				}
			}			
		}
	}
	echo "<h1>Your songs:</h1>";
	//print_r($inner_row);
	//Close MySQL Database connection
	build_table_musics($musicas,'N');


	
	$music_shares = array();	
	// Prepare the query 
	$query = "SELECT m.musica_id mid, m.nome mnome, m.genero mgenero, m.data_lancamento mdata, m.link mlink, u.nome unome
		FROM musica m, partilha pa, utilizador u
		WHERE pa.item_type='musica' AND pa.item_id=m.musica_id AND u.user_id=pa.utilizador_user_id AND pa.receptor_id=$user_id;";
	if($result = $mysqli->query($query)){
		while($row = $result->fetch_assoc()){
			$music_shares[] = $row;	
		}
	}
	echo "<h1> Received Songs: </h1>";
	build_table_musics($music_shares,'Y');



	$playlists = array();	
	/* Prepare the query */
	$query = "SELECT p.playlist_id pid
		FROM playlist p
		WHERE p.utilizador_user_id=$user_id";

	if ($result = $mysqli->query($query)) {
		/* For each row returned from the database */
		while($row = $result->fetch_assoc()) {
			$pid = $row["pid"];
			$inner_query = "SELECT p.playlist_id pid, p.nome pnome, p.pub_priv ppub
					FROM playlist p
					WHERE p.playlist_id=$pid";
			if($inner_result = $mysqli->query($inner_query)){
				while($inner_row = $inner_result->fetch_assoc()){
					$playlists[] = $inner_row;	
				}
			}		
		}
	}
	echo "<h1>Your playlists:</h1>";
	build_table_playlists($playlists,'N');




	$playlist_shares = array();	
	// Prepare the query 
	$query = "SELECT p.playlist_id pid, p.nome pnome, p.pub_priv ppub, u.nome unome
		FROM playlist p, partilha pa, utilizador u
		WHERE pa.item_type='playlist' AND pa.item_id=p.playlist_id AND u.user_id=pa.utilizador_user_id AND pa.receptor_id=$user_id;";
	if($result = $mysqli->query($query)){
		while($row = $result->fetch_assoc()){
			$playlist_shares[] = $row;	
		}
	}
	echo "<h1> Received Playlists: </h1>";
	build_table_playlists($playlist_shares,'Y');




	echo '</center>';

	$mysqli->close();
?>

