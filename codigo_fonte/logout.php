<?php
	session_start();
?>

<script type="text/javascript">

	function clearMain(){
		//$('#log').load('login.php');
		$('#midNav').load('landing_page_tables.php');	
		return false;
	}

</script>

<?php

	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	echo "<button type='button' class='btn btn-primary' data-toggle='modal' id='rg_button' data-target='#RegisterModal'>Register</button>";
	echo "<button type='button' class='btn btn-primary btn-marginl' id='lg_button' data-toggle='modal' data-target='#LoginModal'>Login</button>";

	// remove all session variables
	//session_unset(); 
	$_SESSION['logged_in'] = "NO";
	$_SESSION['username'] = '';
	$_SESSION['user_id'] = -1;

	// destroy the session 
	//session_destroy(); 

	echo "<script type='text/javascript'> clearMain(); </script>";
?>
