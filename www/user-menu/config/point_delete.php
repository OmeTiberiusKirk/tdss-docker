<?php
	session_start(); 
	require_once('../../library/connectdb.inc.php');

	if($connection) {
		//	print_r($_POST);
		$sql = "DELETE FROM observe_point WHERE observ_point_id ='".base64_decode($_REQUEST['id'])."';";
		if(mysql_query($sql, $connection)){
			$msg = "Delete ".$_REQUEST['name']." Successful!!! ";
			/*echo "<script language=javascript> alert('".$msg."'); </script>"; */
			$dest = "observ_point.php?section=11";
			echo "<script language=javascript> location.href='".$_SERVER['HTTP_REFERER']."'; </script>";
			
		}else{
			$dest = "observ_point.php?section=11";
			echo "<script language=javascript> location.href='".$_SERVER['HTTP_REFERER']."'; </script>";
		}
	}		

?>