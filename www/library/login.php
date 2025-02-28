<?php
	session_start();
	
	require('connectdb.inc.php');
	require('function.inc.php');
	
	if(!isset($_POST))
		echo "<script language=\"javascript\">location.href='../user-menu';</script>";
	
	
	
	$sql = "SELECT * FROM `user` WHERE username = '".$_POST['username']."' AND password = '".$_POST['password']."'";	
	
	
	
	$result = mysql_query($sql, $connection)or die("<script language=\"javascript\">alert('Could not select specified user \'".$_POST['username']."\' !'); location.href='../home';</script>");
	$rows = mysql_num_rows($result);
	
   
  	
	if($rows == 1)
	{
		/* we can use this function like this because mysql_fetch_object return only one row */
		$object = mysql_fetch_object($result);
		
		$_SESSION['uid'] = $object->UID;
		$_SESSION['username'] = $object->username;
		$_SESSION['password'] = $object->password;
		$_SESSION['firstname'] = $object->firstname;
		$_SESSION['lastname'] = $object->lastname;
		$_SESSION['faculty'] = $object->faculty;
		$_SESSION['position'] = $object->position;
		$_SESSION['email'] = $object->email;
		$_SESSION['vis-path'] = '../workspace/'.$_POST['username'];
		
		if(is_dir('../workspace/'.$_POST['username'].''))
		{
			echo "<script language=\"javascript\">location.href='../user-menu/';</script>";
		}
		else
		{
			$path = '../workspace/'.$_POST['username'].'';
			if(!file_exists($path))
			{
				if(mkdir($path))
				{
					//$htaccess_path_file = "library/.htaccess";
					//copy($htaccess_path_file, $path);
					$file_storage = $path."/files";
					mkdir($file_storage);
					//copy($htaccess_path_file, $file_storage);
					echo "<script language=\"javascript\">alert('create workspace successful !'); location.href='../';</script>";
				}else
				
					echo "<script language=\"javascript\">alert('could not create ".$path."!'); location.href='../';</script>";
			}
		}
		/*echo "<script language=\"javascript\">alert('login success !'); location.href='../user';</script>";*/
	}else
	{
		echo "<script language=\"javascript\">alert('invalid username or password !'); location.href='../';</script>";
	}
?>
