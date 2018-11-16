<?php
	header("refresh:1;url=main.html");

	

	// Create connection
	$conn = new mysqli("titan.isr.uc.pt", "gustavomiguelsa", "G9_u7-s2", "dropmusic_db");
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT id, nome, genero, link FROM musica";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
		echo "id: " . $row["id"]. " - Name: " . $row["nome"]. " " . $row["genero"]." " . $row["link"]. "<br>";
	    }
	} else {
	    echo "0 results";
	}
	$conn->close();
?>
