<?php
	$mysqli = new mysqli("localhost", "root", "u2288f", "tsunami_v7");
	
	if (mysqli_connect_errno()) {
	   printf("Connect failed: %s\n", mysqli_connect_error());
	   exit();
	}
	
	/* turn autocommit on */
	$mysqli->autocommit(TRUE);
	
	if ($result = $mysqli->query("SELECT @@autocommit")) {
	   $row = $result->fetch_row();
	   printf("Autocommit is %s\n", $row[0]);
	   $result->free();
	}
	
	/* close connection */
	$mysqli->close();
?>
