<?php
	session_start(); 
	require_once('../../library/connectdb.inc.php');

	if($connection) {
		//	print_r($_POST);
		$lat = $_POST['lat_1'] + ($_POST['lat_2']/60) + ($_POST['lat_3']/3600);
		$long = $_POST['long_1'] + ($_POST['long_2']/60) + ($_POST['long_3']/3600);
		$sql = "INSERT INTO `observe_point`(`province`, `province_t`, `name`, `name_t`, `lat_1`, `lat_2`, `lat_3`, `long_1`, `long_2`, `long_3`, `decimal_lat`, `decimal_long`, `label`, `grp_id`, `uid`) VALUES('".$_POST['p_province']."', '".$_POST['p_province_t']."', '".$_POST['p_area']."', '".$_POST['p_area_t']."', '".$_POST['lat_1']."', '".$_POST['lat_2']."', '".$_POST['lat_3']."', '".$_POST['long_1']."', '".$_POST['long_2']."', '".$_POST['long_3']."', '".$lat."', '".$long."', '".$_POST['p_label']."', ".$_POST['p_group'].", '".$_SESSION['uid']."')";
		mysql_query($sql, $connection);
		$msg = "Insert ".$_POST['p_name']." Successful!!! ";
	}
	mysql_close($connection);
	$dest = "observ_point.php?section=9&g_id=".$_REQUEST['p_group'];
	echo "<script language=javascript> location.href='".$dest."'; </script>";


		

?>