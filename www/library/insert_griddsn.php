<?php
	session_start();

	if(!isset($_SESSION))
	{
		echo "<script language=\"javascript\">location.href='../user/user.visres.php';</script>";
	}else
	{
		require_once('connectdb.inc.php');
		require_once('function.inc.php');
     
		if((strlen($_POST['username']) > 2) && (strlen($_POST['password'])> 2) && (strlen($_POST['hostname']) > 2) )
		{
			$sql = "	INSERT INTO grid_trust( uid,username, password, hostname, pass_phrase, datetime)
						values (
							".$_SESSION['uid'].",
							'".$_POST['username']."', 
							'".$_POST['password']."', 
							'".$_POST['hostname']."', 
							'".$_POST['pass_phrase']."',  
							'".time()."')";
			$res = mysql_query($sql, $connection);
		}
        redirect_page("../user/user.gridhost.php?section=7");
	}
?>


