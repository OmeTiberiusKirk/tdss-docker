<?php
	session_start();
	if(!isset($_SESSION['username'])) {
		echo "<script language=\"javascript\">location.href='../../';</script>";
	}
	
	
	/* job submission */ 
	/*
		echo "<a href=".$_SERVER['HTTP_REFERER'].">back</a>";
	*/
	
	require_once("../../library/connectdb.inc.php");
	
	echo "<pre>";
	$compressor_cmd = "\"C:\\Program Files\\WinRAR\\rar.exe\"";
	
	$job_id = $_REQUEST['id'];
	$sql = "SELECT * FROM `job_profile`, `sim_result` WHERE ";
	$sql .= "`job_profile`.`sim_result_id` = `sim_result`.`id` AND `job_profile`.`id` = ".$job_id;
	$result = mysql_query($sql, $connection) or die("! Job id `".$job_id."` could not be found.");
	if(mysql_num_rows($result) == 1) {
		$obj = mysql_fetch_object($result);
		$local_simulation_path .= str_replace("\/\/", "\/", $obj->local_store_path);
		$cmd1 = "cd ".$local_simulation_path;
		$compressor_opt = " a ".$obj->name.".rar -r ".$obj->name;
		$cmd2 = $compressor_cmd.$compressor_opt;
		echo $cmd1."\n";
		echo $cmd2;
	}

	echo "</pre>";
	
?>