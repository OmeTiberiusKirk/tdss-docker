<?php
	session_start();
	require_once('../../library/connectdb.inc.php');
	
	// select id from default parameter
	$sql = "SELECT `name` FROM `sim_profile` WHERE `name` LIKE '".$_SESSION['name']."' ";
	$result = mysql_query($sql, $connection);
	if(mysql_num_rows($result) == 0){
		$redirect_url = $_SESSION['sim_type']."/p1-global1.php?section=1";
		echo "<script language=\"javascript\">document.location.href = '".$redirect_url."';</script>";	
	}else{
		echo "<script language=\"javascript\">document.location.href = 'index.php?section=1&detect=true';</script>";
	}

?>