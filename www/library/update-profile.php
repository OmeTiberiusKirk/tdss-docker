<?php
	session_start();
	require('connectdb.inc.php');
	
	if( isset($_POST))
	{
		/*if( ($_POST['password'] != $_POST['password_re']) )
			echo "<script language=\"javascript\">alert('New password and confirm password not equal.'); location.href='../user/user.profile.php';</script>";
		else
		{*/
		$sql = "UPDATE 
					user 
				SET 
					firstname = '".$_POST['firstname']."', 
					lastname = '".$_POST['lastname']."', 
					faculty = '".$_POST['faculty']."', 
					position = '".$_POST['position']."', 
					email = '".$_POST['email']."'
				WHERE
					UID = ".$_POST['uid'].";";
					
					
		 echo $sql;
		if ( mysql_query($sql, $connection) )
		{
			$_SESSION['firstname'] = $_POST['firstname'];
			$_SESSION['lastname'] = $_POST['lastname'];
			$_SESSION['faculty'] = $_POST['faculty'];
			$_SESSION['position'] = $_POST['position'];
			$_SESSION['email'] = $_POST['email'];
			
			echo "<script language=\"javascript\">alert('Update profile successful.'); location.href='../user/user.profile.php';</script>";
		}else
			echo "<script language=\"javascript\">alert('Error : Could not update profile.'); location.href='../user/user.profile.php';</script>";
	}else
		echo "<script language=\"javascript\">alert('Error : Could not update profile.'); location.href='../user/user.profile.php';</script>";
?>