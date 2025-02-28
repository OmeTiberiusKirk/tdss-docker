<?php
	session_start(); 
	require_once('../../library/connectdb.inc.php');

	if($connection) {
		//echo	base64_encode($_POST['id']);
		$sql = "DELETE FROM seq_config_param WHERE var_id ='".base64_decode($_REQUEST['id'])."';";
		if(mysql_query($sql, $connection)){
			$msg = "Delete ".$_REQUEST['name']." Successful!!! ";
			echo "<script language=javascript> alert('".$msg."'); </script>";
			$dest = "seq_p1.php?section=10";
			echo "<script language=javascript> location.href='".$dest."'; </script>";
			
		}else{
			$dest = "seq_p1.php?section=10";
			echo "<script language=javascript> location.href='".$dest."'; </script>";
		}
		
	}
	//mysql_close($connection);


		

?>