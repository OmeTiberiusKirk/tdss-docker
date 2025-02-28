<?php
	session_start();
	require('connectdb.inc.php');
	
	if( isset($_POST))
	{	
		if( ($_POST['password'] != $_POST['password_re']) || ($_SESSION['password'] != $_POST['password_old']))
			echo "<script language=\"javascript\">alert('New password and confirm password not equal.'); location.href='../user/user.chpass.php?section=6';</script>";
		else
		{
			$sql = "UPDATE 
						user 
					SET 
						password = '".$_POST['password']."'
					WHERE
						UID = ".$_POST['uid'].";";
						
			if ( mysql_query($sql, $connection) )
			{
				$_SESSION['password'] = $_POST['password'];
				echo "<script language=\"javascript\">alert('Change password successful.'); location.href='../user-menu/user/chpass.php?section=14';</script>";
			}else
				echo "<script language=\"javascript\">alert('Error : Could not update profile.'); location.href='../user-menu/user/chpass.php?section=14';</script>";
		}
	}else
		echo "<script language=\"javascript\">alert('Error : Could not update profile.'); location.href='../user-menu/user/chpass.php?section=14';</script>";
?>