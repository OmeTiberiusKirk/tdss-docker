<?php
	require('connectdb.inc.php');
	
	if( (strlen($_POST['username']) >= 3) && (strlen($_POST['password']) >= 6) )
	{		
		$sql_check="SELECT `user`.username FROM `user` WHERE `user`.username = '".$_POST['username']."' ";
		$result_check = mysql_query($sql_check, $connection);
		$rows = mysql_num_rows($result_check);
		$count =1;
		
		if ($rows >= $count)
		{
			echo "<script language=\"javascript\">alert('Your username `".$_POST['username']."` has been use.'); location.href='../home/home.regis.php';</script>";
			
		}
		else
		{
			if($_POST['password']!=$_POST['password_re'])
			{
				echo "<script language=\"javascript\">alert('Your password and confirm password do not equal.'); location.href='../home/home.regis.php';</script>";
			}
			else
			{
				$sql = "INSERT INTO user(username, password, firstname, lastname, faculty, position, email) ";
				$sql .= "VALUES('".$_POST['username']."', '".$_POST['password']."', '".$_POST['firstname']."', '".$_POST['lastname']."', '".$_POST['faculty']."', '".$_POST['position']."', '".$_POST['email']."') ";
				
				$result = mysql_query($sql, $connection);
				if ($result == false)
				{
					echo "<script language=\"javascript\">alert('Error : Could not create user `".$_POST['username']."`.');</script>";
				}
				else 
				{
					//if(mkdir("../workspace/".$workdir_name))
						echo "<script language=\"javascript\">alert('Create account successful.');</script>";
					/*else
						echo "<script language=\"javascript\">alert('Could not create workspace.');</script>";*/
				}
				
				if ( headers_sent() )
				{
					echo "<script language=\"javascript\">location.href='../home/home.regis.php';</script>";		
				}
				else
					header('Location: ../home/home.regis.php');
			}
		}	
	}else
		echo "<script language=\"javascript\">alert('Could not create user `".$_POST['username']."` \\nNOTE : Your username and password must over than 3 and 6 charectors.'); location.href='../home/home.regis.php';</script>";
		
?>