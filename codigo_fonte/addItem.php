<?php
	session_start();
?>

<script type="text/javascript">

	$('#submit-button').on('click', function() {
		var ptitle = document.getElementById("playlist-title").value;
		var ptitle_clean = ptitle.replace(/ /g, "+");
		var ppubpriv = $('#pub-priv').is(":checked");
	
		var psongs = [];
		var aux = 0;
		for( var i = 1; i < 16; i++ ) {
			
			psongs[i-1] = document.getElementById("song-Select-" + i).value;
			aux += psongs[i-1];
		}

		if(ptitle == "" || aux == "0"){
			alert("Please fill the title field and choose at least 1 song!");
		} else {
			var songstring = JSON.stringify(psongs);
			$('#midNav').load('createPlaylist.php?title=' + ptitle_clean + '&pubpriv=' + ppubpriv + '&psongs=' + songstring);
		}

        	return false; 
    	});
	/* Function responsible for adding a show */
	//function addConcert(){
	$('#submit-show').on('click', function() {	
		var cdate=document.getElementById("cdate").value;
		var coccupancy=document.getElementById("coccupancy").value;
		var cduration=document.getElementById("cduration").value;
		var cby = document.getElementById("select_name_c").value;
		var clocal = document.getElementById("clocal").value;

		if(cdate == "" || coccupancy == "" || cduration == "" || cby == "" || clocal=="") {
			alert("You didn't fill all the required fields!");
			cleanConcert();
		}
		else{
			$("#midNav").load('addConcert.php', {'date': cdate, 'o': coccupancy, 'dura': cduration, 'b': cby, 'l': clocal});
		}
	});
	
	/* To clean the input values */
	function cleanConcert(){
		document.getElementById("cdate").value= "";
		document.getElementById("coccupancy").value= "";
		document.getElementById("cduration").value= "";
		document.getElementById("select_name_c").value= "";
		document.getElementById("clocal").value="";
	}
	
	/* Function responsible for adding an album */
	function addAlbum(){
		var albumName=document.getElementById("albumName").value;
		var albumDate=document.getElementById("albumDate").value;
		var albumBy = document.getElementById("select_name_album").value;
		var psongs = [];
		var aux = 0;
		var song_selected = 0;
		for( var i = 1; i < 51; i++ ) {
			
			psongs[i-1] = document.getElementById("song-Select-" + i).value;
			aux += psongs[i-1];
		}

		if(albumName == "" || albumDate == "" || albumBy == "" ) {
			alert("You didn't fill all the required fields!");
			cleanAlbum();
		}
		else{
			var songstring = JSON.stringify(psongs);
			//$('#midNav').load('addAlbum.php?albumName=' + albumName + '&albumDate=' + albumDate + '&albumBy=' + albumBy + '&psongs=' + songstring);
			$("#midNav").load('addAlbum.php', {'albumName': albumName, 'albumDate': albumDate, 'albumBy': albumBy, 'psongs': songstring});
		}
	}
	/* To clean the input values */
	function cleanAlbum(){
		document.getElementById("albumName").value= "";
		document.getElementById("albumDate").value= "";
		document.getElementById("select_name_c").value= "";
		for( var i = 1; i < 51; i++ ) {
			document.getElementById("song-Select-" + i).value = "";
		}
	}
	
	function cleanSong(){
		document.getElementById("songName").value="";
		document.getElementById("songGenre").value="";
		document.getElementById("songLink").value="";
		document.getElementById("songDate").value="";
		document.getElementById("songLyrics").value="";
	}
	
	$('#submit-song').on('click', function() {
		var songName=document.getElementById("songName").value;
		var songGenre=document.getElementById("songGenre").value;
		var songLink = document.getElementById("songLink").value;
		var songDate = document.getElementById("songDate").value;
		var songLyrics = document.getElementById("songLyrics").value;
		var pmusicians = [];
		var pcomposers = [];
		var aux1 = 0;
		var aux2 = 0;
		var musician_selected = 0;
		var composer_selected = 0;
		for( var i = 1; i < 46; i++ ) {
			
			pmusicians[i-1] = document.getElementById("musician-Select-" + i).value;
			
			aux1 += pmusicians[i-1];
		}
		for( var i = 1; i < 21; i++ ) {
			
			pcomposers[i-1] = document.getElementById("composer-Select-" + i).value;
			aux2 += pcomposers[i-1];
		}
		if(songName == "" || songGenre == "" || songLink == "" || songDate=="" || songLyrics=="" || (aux1<1 && aux2<1)) {
			alert("You didn't fill all the required fields!");
			cleanSong();
		}
		else{
			var musicianstring = JSON.stringify(pmusicians);	
			var composerstring = JSON.stringify(pcomposers);
			//$('#midNav').load('addAlbum.php?albumName=' + albumName + '&albumDate=' + albumDate + '&albumBy=' + albumBy + '&psongs=' + songstring);
			$("#midNav").load('addSong.php', {'songName': songName, 'songGenre': songGenre, 'songLink': songLink, 'songDate':songDate, 'songLyrics': songLyrics, 'pmusicians': musicianstring, 'pcomposers': composerstring});
		}
	});

	$('#submit-band').on('click', function() {
		var bandName=document.getElementById("bandName").value;
		var bandHistory=document.getElementById("bandHistory").value;
		var recordC= document.getElementById("select_name_e").value;
		var pmusicians = [];
		var aux1 = 0;
		var conta_datas = 0;
		var erradas = 0;
		for( var i = 1; i < 21; i++ ) {
			
			pmusicians[i-1] = document.getElementById("musician-Select-" + i).value;
			aux1 += pmusicians[i-1];
		}
		var datebegin1 = document.getElementById("datebegin1").value;
		var dateend1 = document.getElementById("dateend1").value;
		var datebegin2 = document.getElementById("datebegin2").value;
		var dateend2 = document.getElementById("dateend2").value;
		var datebegin3 = document.getElementById("datebegin3").value;
		var dateend3 = document.getElementById("dateend3").value;
		var datebegin4 = document.getElementById("datebegin4").value;
		var dateend4 = document.getElementById("dateend4").value;
		var datebegin5 = document.getElementById("datebegin5").value;
		var dateend5 = document.getElementById("dateend5").value;
		
		if(datebegin1 != "" && dateend1 != ""){
			conta_datas++;
			if(datebegin1 > dateend1){
				erradas++;
			}
		}
		else if(datebegin2 != "" && dateend2 != ""){
			conta_datas++;
			if(datebegin2 > dateend2){
				erradas++;
			}
		}
		else if(datebegin3 != "" && dateend3 != ""){
			conta_datas++;
			if(datebegin3 > dateend3){
				erradas++;
			}
		}
		else if(datebegin4 != "" && dateend4 != ""){
			conta_datas++;
			if(datebegin4 > dateend4){
				erradas++;
			}
		}
		else if(datebegin5 != "" && dateend5 != ""){
			conta_datas++;
			if(datebegin5 > dateend5){
				erradas++;
			}
		}
		if(bandName == "" || bandHistory == "" || recordC == "" || aux1 < 1 || conta_datas < 1 || erradas>0) {
			alert("You didn't fill all the required fields!");
			cleanSong();
		}
		else{
			var musicianstring = JSON.stringify(pmusicians);	
			//$('#midNav').load('addAlbum.php?albumName=' + albumName + '&albumDate=' + albumDate + '&albumBy=' + albumBy + '&psongs=' + songstring);
			$("#midNav").load('addBand.php', {'bandName': bandName, 'bandHistory': bandHistory, 'recordC': recordC, 'datebegin1':datebegin1, 'dateend1': dateend1, 'datebegin2': datebegin2, 'dateend2': dateend2, 'datebegin3': datebegin3, 'dateend3': dateend3, 'datebegin4': datebegin4, 'dateend4': dateend4, 'datebegin5': datebegin5, 'dateend5': dateend5, 'pmusicians': musicianstring});
		}
		
	});
	
	function cleanBand(){
		document.getElementById("bandName").value="";
		document.getElementById("bandHistory").value="";
		document.getElementById("select_name_e").value="";
		document.getElementById("datebegin1").value="";
		document.getElementById("dateend1").value="";
		document.getElementById("datebegin2").value="";
		document.getElementById("dateend2").value="";
		document.getElementById("datebegin3").value="";
		document.getElementById("dateend3").value="";
		document.getElementById("datebegin4").value="";
		document.getElementById("dateend4").value="";
		document.getElementById("datebegin5").value="";
		document.getElementById("dateend5").value="";
	}

	$('#submit-musician').on('click', function() {
		var musicianName=document.getElementById("musicianName").value;
		var musicianDOB=document.getElementById("musicianDOB").value;
		var musicianBio=document.getElementById("musicianBio").value;
		var recordC= document.getElementById("select_name_e").value;
		var composer = 0;

		var dtToday = new Date();
		/* Obtain the current date which will be the maximum date input */
	        var month = dtToday.getMonth() + 1;
	        var day = dtToday.getDate();
	        var year = dtToday.getFullYear();

	        if(month < 10)
			month = '0' + month.toString();
	        if(day < 10)
			day = '0' + day.toString();
	        var maxDate = year + '-' + month + '-' + day;


		if(document.getElementById('yesCheck').checked) {
		  // This musician is a composer
			composer = 1;
		}
		else if(document.getElementById('noCheck').checked) {
		  //This musician isn't a composer
			composer = 0;
		}
		if(musicianName == "" || musicianDOB == "" || musicianBio == "" || musicianDOB>maxDate) {
			alert("You didn't fill all the required fields!");
			cleanSong();
		}
		else{	
			$("#midNav").load('addMusician.php', {'musicianName': musicianName, 'musicianDOB': musicianDOB, 'recordC': recordC, 'musicianBio':musicianBio, 'composer': composer});
		}
	
	});

	function cleanMusician(){
		document.getElementById("musicianName").value="";
		document.getElementById("musicianDOB").value="";
		document.getElementById("musicianBio").value="";
		document.getElementById('yesCheck').checked=false;
		document.getElementById('noCheck').checked=false;
		
	}

	$('#submit-composer').on('click', function() {
		var composerName=document.getElementById("composerName").value;
		var composerDOB=document.getElementById("composerDOB").value;
		var composerBio=document.getElementById("composerBio").value;

		var dtToday = new Date();
		/* Obtain the current date which will be the maximum date input */
	        var month = dtToday.getMonth() + 1;
	        var day = dtToday.getDate();
	        var year = dtToday.getFullYear();

	        if(month < 10)
			month = '0' + month.toString();
	        if(day < 10)
			day = '0' + day.toString();
	        var maxDate = year + '-' + month + '-' + day;

		if(composerName == "" || composerDOB == "" || composerBio == "" || composerDOB>maxDate) {
			alert("You didn't fill all the required fields!");
			cleanSong();
		}
		else{	
			$("#midNav").load('addComposer.php', {'composerName': composerName, 'composerDOB': composerDOB, 'composerBio': composerBio});
		}
	});

	function cleanComposer(){
		document.getElementById("composerName").value="";
		document.getElementById("composerDOB").value="";
		document.getElementById("composerBio").value="";
	}
		
	$('#submit-records').on('click', function() {
		var reccomAddress=document.getElementById("reccomAddress").value;
		var reccomName=document.getElementById("reccomName").value;
		
		if(reccomAddress == "" || reccomName == "") {
			alert("You didn't fill all the required fields!");
			cleanSong();
		}
		else{	
			$("#midNav").load('addRecordsCompany.php', {'reccomAddress': reccomAddress, 'reccomName': reccomName});
		}
	});
	
	function cleanRecord(){
		document.getElementById("reccomAddress").value="";
		document.getElementById("reccomName").value="";
	}

</script>

<?php	//Opção 1 -> Criar Playlist
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$mysqli = new mysqli("192.168.1.89", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}

	$choice = $_GET['choice'];

	if($choice == 1){	//Choice 1 is playlists

		echo "<h1> Creating a Playlist! </h1>";
		echo "<h4> - Please pick up to 15 songs - </h4>";
		echo "<form style='margin: 0 auto; width:1150px;'>";
			echo "<input class='form-control srch-marginl' type='text' placeholder='Playlist Title' id='playlist-title' style='position:absolute; left: 218px; top: 268px; width:287px;'>";
			
			echo "<div style='position: absolute; left: 700px; top: 275px;'><b> Private? </b></div>";
			echo "<input type='checkbox' id='pub-priv' style='position:absolute; left: 770px; top: 279px;'>";	

			for($i = 1; $i < 16; $i++){
				echo "<select id='song-Select-$i' style='width:300px; color: white; background-color: #3E77EA;'>";
					echo "<option disabled selected value> -- Select a song -- </option>";
				$query = "SELECT m.musica_id mid, m.nome mnome FROM musica m";
					if ($result = $mysqli->query($query)) {
						while($row = $result->fetch_assoc()) {
							$aux = $row['mnome'];
							$aux2 = $row['mid'];

							echo "<option value='$aux2'>$aux</option>";
						}
					}
					echo "</select>";
			}
			
			echo "<button class='btn btn-primary btn-marginl' type='submit' id='submit-button' style='position:absolute; left: 120px; top:440px; width: 150px;'>Submit!</button>";
		echo "</form>";

	}
	else if($choice == 2) {		//Choice 2 is Song
		echo "<h1> Adding a Song! </h1>";
		echo '<h4>Name: <input type="text" id="songName" name="songName" maxlength="30"><br></h4>';
		echo '<h4>Genre: <input type="text" id="songGenre" name="songGenre" maxlength="15"><br></h4>';
		echo '<h4>Link: <input type="text" id="songLink" name="songLink" maxlength="40"><br></h4>';
		echo '<h4>Release Date: <input type="date" id="songDate" name="songDate" min="1000-01-01"><br></h4>';
		echo '<h4>Lyrics: <input type="text" id="songLyrics" name="songLyrics" size="512"><br></h4>';
		echo "<h4> - Please pick up to 45 Musicians - </h4>";
		for($i = 1; $i < 46; $i++){
			echo "<select id='musician-Select-$i' style='width:300px; color: white; background-color: #3E77EA;'>";
				echo "<option disabled selected value> -- Select a musician -- </option>";
			$query = "SELECT mu.musico_id muid, mu.nome munome FROM musico mu";
				if ($result = $mysqli->query($query)) {
					while($row = $result->fetch_assoc()) {
						$aux = $row['munome'];
						$aux2 = $row['muid'];

						echo "<option value='$aux2'>$aux</option>";
					}
				}
				echo "</select>";
		}
		echo "<br>";
		echo "<h4> - Please pick up to 20 Composers - </h4>";
		for($i = 1; $i < 21; $i++){
			echo "<select id='composer-Select-$i' style='width:300px; color: white; background-color: #3E77EA;'>";
				echo "<option disabled selected value> -- Select a composer -- </option>";
			$query = "SELECT co.compositor_id coid, co.nome conome FROM compositor co";
			if ($result = $mysqli->query($query)) {
				while($row = $result->fetch_assoc()) {
					$aux = $row['conome'];
					$aux2 = $row['coid'];

					echo "<option value='$aux2'>$aux</option>";
				}
			}
			echo "</select>";
		}
		echo "<br>";
		echo'<button class="btn btn-primary btn-marginl" type="submit" id="submit-song" style="margin-top: 10px">Ok!</button>';
		echo '<button onclick="cleanSong()" type="button" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Reset!</button>';
		//echo '<h4>Artist: <input type="text" id="songArtist" name="songArtist"><br></h4>';
		//echo '<h4>Composer: <input type="text" id="songComposer" name="songComposer"><br></h4>';
	}
	else if($choice == 3) {		//Choice 3 is Album
		echo '<h1> Adding an Album! </h1>';
		echo '<h4>Name: <input type="text" id="albumName" name="albumName" maxlength="50"><br></h4>';
		echo '<h4>Release Date: <input type="date" id="albumDate" name="albumDate min="1000-01-01""><br></h4>';
		echo '<h4>Musician/Band: </h4><br>';
		$query = "SELECT gr.grupo_id grid, gr.nome grnome
			FROM gr_musical gr";
		echo '<select id="select_name_album" name="select_name_album_query">';
		if ($result = $mysqli->query($query)) {
			while($row = $result->fetch_assoc()) {
				echo '<option value="'. 'grid' . $row['grid'].'">'.$row['grnome'].'</option>';
			}
		}
		$query = "SELECT m.musico_id mid, m.nome mnome
			FROM musico m";
		if ($result = $mysqli->query($query)) {
			while($row = $result->fetch_assoc()) {
				echo '<option value="'. 'mid' . $row['mid'].'">'.$row['mnome'].'</option>';
			}
		}
		echo '</select>';
		echo "<h3 - Please pick up to 50 songs - </h3>";
		for($i = 1; $i < 51; $i++){
			echo "<select id='song-Select-$i' style='width:300px; color: white; background-color: #3E77EA;'>";
				echo "<option disabled selected value> -- Select a song -- </option>";
				$query = "SELECT m.musica_id mid, m.nome mnome FROM musica m";
				if ($result = $mysqli->query($query)) {
					while($row = $result->fetch_assoc()) {
						$aux = $row['mnome'];
						$aux2 = $row['mid'];

						echo "<option value='$aux2'>$aux</option>";
					}
				}
				echo "</select>";
		}

		echo'<button onclick="addAlbum()" type="submit" id="submit-album" class="btn btn-danger" data-dismiss="modal" style="margin-top: 10px">Ok!</button>';
		echo '<button onclick="cleanAlbum()" type="button" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Reset!</button>';
		//Songs: <input type="text" id="albumSongs" name="albumSongs"><br>
	}
	else if($choice == 4) {		//Choice 4 is Band
		echo '<h1> Adding a Band </h1>';
		echo '<h4>Name: <input type="text" id="bandName" name="bandName" maxlength="30"><br></h4>';
		echo '<h4>History: <input type="text" id="bandHistory" name="bandHistory" maxlength="512"><br></h4>';
		echo "<h3 - Please pick up to 20 Musicians - </h3>";
		for($i = 1; $i < 21; $i++){
			echo "<select id='musician-Select-$i' style='width:300px; color: white; background-color: #3E77EA;'>";
				echo "<option disabled selected value> -- Select a musician -- </option>";
				$query = "SELECT mu.musico_id muid, mu.nome munome FROM musico mu";
				if ($result = $mysqli->query($query)) {
					while($row = $result->fetch_assoc()) {
						$aux = $row['munome'];
						$aux2 = $row['muid'];

						echo "<option value='$aux2'>$aux</option>";
					}
				}
				echo "</select>";
		}
		echo '<h3>Activity Periods: <br></h3>';
		echo '<h4>Period 1: <input type="date" id="datebegin1" name="1datebegin" min="1000-01-01">      -      <input type="date" id="dateend1" name="1dateend" min="1000-01-01"></h4><br>';
		echo '<h4>Period 2: <input type="date" id="datebegin2" name="2datebegin" min="1000-01-01">      -      <input type="date" id="dateend2" name="2dateend" min="1000-01-01"></h4><br>';
		echo '<h4>Period 3: <input type="date" id="datebegin3" name="3datebegin" min="1000-01-01">      -      <input type="date" id="dateend3" name="3dateend" min="1000-01-01"></h4><br>';
		echo '<h4>Period 4: <input type="date" id="datebegin4" name="4datebegin" min="1000-01-01">      -      <input type="date" id="dateend4" name="4dateend" min="1000-01-01"></h4><br>';
		echo '<h4>Period 5: <input type="date" id="datebegin5" name="5datebegin" min="1000-01-01">      -      <input type="date" id="dateend5" name="5dateend" min="1000-01-01"></h4><br>';
		
		$query = "SELECT e.editora_id eid, e.nome enome
			FROM editora e";
		echo '<select id="select_name_e" name="select_name_e_query">';
		if ($result = $mysqli->query($query)) {
			while($row = $result->fetch_assoc()) {
				echo '<option value="'.$row['eid'].'">'.$row['enome'].'</option>';
			}
		}
		echo '</select>';
		echo '<br>';
		echo '<button type="button" id="submit-band" class="btn btn-danger" style="margin-top: 10px">Ok!</button>';
		echo '<button onclick="cleanBand()" type="button" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Reset!</button>';
	}
	else if($choice == 5) {		//Choice 5 is Musician
		echo '<h1> Adding a Musician </h3><br>';
		echo '<h4> Name: <input type="text" id="musicianName" name="musicianName" maxlength="20"><br></h4>';
		echo '<h4> Date of Birth: <input type="date" id="musicianDOB" name="musicianDOB" min="1900-01-01"><br></h4>';
		echo '<h4>Bio: <input type="text" id="musicianBio" name="musicianBio" maxlength="512"><br></h4>';
		echo '<h4>Record Company:<br></h4>';
		$query = "SELECT e.editora_id eid, e.nome enome
			FROM editora e";
		echo '<select id="select_name_e" name="select_name_e_query">';
		if ($result = $mysqli->query($query)) {
			while($row = $result->fetch_assoc()) {
				echo '<option value="'.$row['eid'].'">'.$row['enome'].'</option>';
			}
		}
		echo '</select>';
		echo '<br>';
		echo '<h4>Composer? Yes <input type="radio" name="yesno" id="yesCheck"> No <input type="radio" name="yesno" id="noCheck"><br></h4>';
		echo '<button type="button" id="submit-musician" class="btn btn-danger" style="margin-top: 10px">Ok!</button>';
		echo '<button onclick="cleanMusician()" type="button" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Reset!</button>';
	}
	else if($choice == 6) {		//Choice 3 is Composer
		echo '<h1> Adding a Composer </h1><br>';
		echo '<h4> Name: <input type="text" id="composerName" name="composerName" maxlength="30"><br></h4>';
		echo '<h4>Date of Birth: <input type="date" id="composerDOB" name="composerDOB min="1900-01-01""><br></h4>';
		echo '<h4>Bio: <input type="text" id="composerBio" name="composerBio" maxlength="512"><br></h4>';
		
		echo '<button type="button" id="submit-composer" class="btn btn-danger" style="margin-top: 10px">Ok!</button>';
		echo '<button onclick="cleanComposer()" type="button" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Reset!</button>';
	}
	else if($choice == 7) {
		echo '<h1>Adding a Show! </h1>';
		echo '<h4>Expected duration in minutes: <input id="cduration" type="number" min="1" max="300"></h4></br>';
		echo '<h4>Date: <input type="date" id="cdate" name="bday" min="1000-01-01"></h4></br>';
		echo '<h4>Maximum Occupancy: <input type="number" id="coccupancy" min="1" max="999999"></h4></br>';
		echo "<h4>At: <input type='text' id='clocal' size='50'></h4></br>";
		echo '<h4>By: </h4>';
		$query = "SELECT gr.grupo_id grid, gr.nome grnome
			FROM gr_musical gr";
		echo '<select id="select_name_c" name="select_name_c_query">';
		if ($result = $mysqli->query($query)) {
			while($row = $result->fetch_assoc()) {
				echo '<option value="'. 'grid' . $row['grid'].'">'.$row['grnome'].'</option>';
			}
		}
		$query = "SELECT m.musico_id mid, m.nome mnome
			FROM musico m";
		if ($result = $mysqli->query($query)) {
			while($row = $result->fetch_assoc()) {
				echo '<option value="'. 'mid' . $row['mid'].'">'.$row['mnome'].'</option>';
			}
		}
		echo '</select>';
		echo "<br>";
		echo'<button type="button" id="submit-show" class="btn btn-danger" data-dismiss="modal" style="margin-top: 10px">Ok!</button>';
		echo '<button onclick="cleanConcert()" type="button" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Reset!</button>';
	}
	else if($choice == 8) {		//Choice 8 is Records Company
		echo '<h1> Adding a Record Company </h1><br>';
		echo '<h4>Name: <input type="text" id="reccomName" name="reccomName" maxlength="30"><br></h4>';
		echo '<h4>Address: <input type="text" id="reccomAddress" name="reccomAddress" maxlength="50"><br></h4>';
		echo'<button type="button" id="submit-records" class="btn btn-danger" data-dismiss="modal" style="margin-top: 10px">Ok!</button>';
		echo '<button onclick="cleanRecord()" type="button" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px">Reset!</button>';
	}
	//Close MySQL Database connection
	$mysqli->close();
?>










