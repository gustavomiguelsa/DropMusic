<?php
	session_start();
?>

<script type="text/javascript">

	function musicianFunction(par){
	
		$('#midNav').load('musicianPage.php?muid=' + par);
	}

	function bandFunction(par){
	
		$('#midNav').load('bandPage.php?grid=' + par);
	}

	function songFunction(par){
	
		$('#midNav').load('songPage.php?mid=' + par);
	}

	$('#review-button').on('click', function() {
		var review_title=document.getElementById("review-title").value;
		var review_why=document.getElementById("review-why").value;
		var review_title_clean = review_title.replace(/ /g, "+");
		var review_why_clean = review_why.replace(/ /g, "+");
		var review_score=document.getElementById("score").value;
		var review_aid=document.getElementById("aid").value;

		if(review_title=="" || review_score==""){
			alert("Please fill all fields!");
			return;
		}
		
		$('#midNav').load('addReview.php?title=' + review_title_clean + '&why=' + review_why_clean + '&score=' + review_score + '&aid=' + review_aid);

        	return false;
    	});

	function removeAlbum(aid) {
		
		$('#midNav').load('removeItem.php?type=' + 'album' + '&album=' + aid);
        	return false;
    	}

	
</script>

<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	//Get musician id from previous php
	$aid = $_GET["aid"];

	//Initiate connection to MySQL Database
	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	} 

	//Get Album Info
	$query = "SELECT a.nome anome, a.data_lancamento adata, a.gr_musical_grupo_id agrid, a.musico_musico_id amuid
		  FROM album a
		  WHERE a.album_id=$aid";

	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			
			echo "<div class='row' style='position: absolute; top: 200px; left: 100px;'>
 			<div class='column' style='width: 600px;'>";
			echo "<br><h1>" . $row["anome"] . "</h1>";
			echo "<td> Release Date: " . $row["adata"] . "</td><br>";
			
			if($row["agrid"] == NULL){	//If band's ID is NULL, then the album belongs to a solo musician

				$muid = $row["amuid"];
				$inner_query = "SELECT nome FROM musico WHERE musico_id=$muid";
				if ($inner_result = $mysqli->query($inner_query)) {
					while($inner_row = $inner_result->fetch_assoc()) {

						echo "<td>By: <a href='#goMusician' id='sel_musician' onclick='musicianFunction($muid)'>" . $inner_row["nome"] . "</a></td><br>";					
					}
				}

			} else {			//If band's ID is NOT NULL, then the album belongs to a band

				$grid = $row["agrid"];
				$inner_query = "SELECT nome FROM gr_musical WHERE grupo_id=$grid";
				if ($inner_result = $mysqli->query($inner_query)) {
					while($inner_row = $inner_result->fetch_assoc()) {

						echo "<td>By: <a href='#goBand' id='sel_band' onclick='bandFunction($grid)'>" . $inner_row["nome"] . "</a></td><br>";					
					}
				}
			}

			echo "<h2> Songs: </h2>";
			$inner_query = "SELECT m.nome mnome, m.genero mgenero, m.musica_id mid FROM musica m, album_musica am WHERE m.musica_id=am.musica_musica_id AND am.album_album_id=$aid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$mid=$inner_row["mid"];
					echo "<td><a href='#goSong' id='sel_song' onclick='songFunction($mid)'>" . $inner_row["mnome"] . "</a></td>";
					echo "<td> - " . $inner_row["mgenero"] . "</td><br>";
				}
			}

			echo "<h2> Reviews: </h2>";
			$inner_query = "SELECT titulo,justificacao,pontuacao,utilizador_user_id FROM critica WHERE album_album_id=$aid";
			if ($inner_result = $mysqli->query($inner_query)) {
				while($inner_row = $inner_result->fetch_assoc()) {
					$titulo=$inner_row["titulo"];
					echo "<h3>-" . $inner_row["titulo"] . "-</h3><br>";				
					echo "<td>Why: " . $inner_row["justificacao"] . "</td><br>";
					echo "<td>Score: " . $inner_row["pontuacao"] . "/10</td><br>";
					echo "<td>By User #: " . $inner_row["utilizador_user_id"] . "</td><br>";
				}
				echo "<br><br>";
			}


			echo "</div>";

			if( session_status() != PHP_SESSION_NONE && isset($_SESSION['logged_in'])){

				if($_SESSION['logged_in'] == 'YES'){
					$uid = $_SESSION['user_id'];
					echo "<div class='column' style='width: 600px; position: absolute; top:25px; left: 600px;'>";
						echo "<h1> Write Review! </h1>";
						echo "<form >
							<input class='form-control srch-marginl' type='text' placeholder='Title' id='review-title' style='position:absolute; left: -300px; width:300px;'>

							<input type='range' min='1' max='10' value='5' id='score' style='position:absolute; left:200px; top:60px;' oninput='scoreOutput.value = score.value'>
							<output name='scoreName' id='scoreOutput' style='position:absolute; left:350px;'>5</output>

							
							<input class='form-control srch-marginl' type='text' placeholder='Give us a reason...' id='review-why' style='position:absolute; left: -300px; top: 100px;' size='80' oninput='aid.value = $aid'>

							<output name='album_id' id='aid' style='visibility:hidden;'>0</output>

							<button class='btn btn-primary btn-marginl' type='submit' id='review-button' style='position:absolute; left: -130px; top:145px;'>Submit!</button>
							</form>";

					echo "</div>";

					if($_SESSION["is_editor"] == 1){
						echo "<button class='btn btn-primary btn-marginl' type='submit' id='remove-button' style='background-color: red; position:absolute; left: 980px; top:70px;' onclick='removeAlbum($aid)'>Delete Album</button>";
					}
				}
			}
			

			echo "</div>";
		}
	}

	//Close MySQL Database connection
	$mysqli->close();
?>



