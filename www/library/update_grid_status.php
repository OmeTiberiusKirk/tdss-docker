<?php
	session_start();
	print_r($_POST);
	if(!isset($_SESSION))
	{
		echo "<script language=\"javascript\">location.href='../user/user.visres.php';</script>";
	}else
	{
		require_once('connectdb.inc.php');
		require_once('function.inc.php');
     
		if (isset($_POST['grid_trusted']) )
		{
			$sql1 = "	UPDATE grid_trust
						SET
						  status = 0 ";
						  
			$res1 = mysql_query($sql1, $connection);
			
			
			$sql2 = "	UPDATE grid_trust
						SET
						  status = 1
						 WHERE
						 gid = ".$_POST['grid_trusted']." ";
			$res2 = mysql_query($sql2, $connection);
		}
        redirect_page("../user/user.configuration.php?section=7");
	}
?>


