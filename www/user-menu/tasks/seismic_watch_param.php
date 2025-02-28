<?php
	require_once('../../library/connectdb.inc.php');
	if($_REQUEST['key'] == "4271879056ba78239df95db6d7d8c5789978cb96" && $_REQUEST['m'] > 0 && $_REQUEST['depth'] > 0) {
		$sql = "INSERT INTO `tsunami_cli`.`seismic_watch_param` (
					`id`, `local_time`, `location`, `latitude`, 
					`longitude`, `magnitude`, `depth`, `distance`, 
					`position`, `epi_width`, `epi_length`, `observe_level`, 
					`announce_criteria`, `from_ip`, `create_datetime`) 
				VALUES ( 
					NULL, '".$_REQUEST['t']."', '".$_REQUEST['location']."', '".$_REQUEST['lat']."', 
					'".$_REQUEST['long']."', '".$_REQUEST['m']."', '".$_REQUEST['depth']."', '".$_REQUEST['distance']."', 
					'".$_REQUEST['pos']."', '".$_REQUEST['epi_width']."', '".$_REQUEST['epi_length']."', '".$_REQUEST['observe_level']."', 
					'".$_REQUEST['ann_criteria']."', '".$_SERVER['REMOTE_ADDR']."', '".time()."');";		
		$result = @mysql_query($sql, $connection) or die("error");
		echo "success";
		sleep(0.2); 
	}else echo "some wrong";
?>