<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
static $username = null;
/* Change when wanted. Has effect on connections*/
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

if( isset($_POST['submit']) )
{
	$counter = 0;
	$post_found = false;
	$picked_user = (isset($_POST['mys']) ? $_POST['mys'] : null);
	
	$mysqli = new mysqli("mysql.eecs.ku.edu", "g111s401", "gah9moMa", "g111s401");
	// check connection 
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	//Build MySQL string
	$query = "SELECT author_id,content FROM Posts;";
	//Send query string to MySQL database
	if ($result = $mysqli->query($query)) {
		
		echo "<table>";
		echo "<th> POST VIEW </th>";
		// fetch associative array 
		while($row = $result->fetch_assoc()) {
			if($row["author_id"] == $picked_user)
			{	$counter++;
				echo "<tr>";
				echo "<td> Post " . $counter . ": " . $row["content"] . "</td>";
				echo "</tr>";
				$post_found = true;
			}
		}	
		
		if($post_found == false)
		{
			echo "<tr>";
			echo "<td>This user has no posts to show yet...</td>";
			echo "<tr>";
		}
		echo "</table>";
	}
}
else 
{
	$mysqli = new mysqli("mysql.eecs.ku.edu", "g111s401", "gah9moMa", "g111s401");
	// check connection 
	if ($mysqli->connect_errno) {
	    printf("Connect failed: %s\n", $mysqli->connect_error);
	    exit();
	}
	//Build MySQL string
	$query = "SELECT user_id FROM Users;";
	//Send query string to MySQL database
	if ($result = $mysqli->query($query)) {
		// fetch associative array 
		while($row = $result->fetch_assoc()) {
			$username = $row["user_id"];
			echo "<option value='$username'> " .$username. "</option>";
			echo "<br>";
		}
	}
}
/**************************************************************************************************/
/* For LOGIN: */
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$conn->close();
?>
