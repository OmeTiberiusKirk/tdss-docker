<?php
	
	session_start();
	
	if(!isset($_SESSION))
	{
		echo "<script language=\"javascript\">location.href='../user/user.vises.php';</script>";
	}else
	{
		require_once('function.inc.php');
		
		if ( $_REQUEST['grid_id'] && $_SESSION['uid'] )
		{
			require_once('connectdb.inc.php');
			require_once('function.inc.php');
			
			$sql = "SELECT `gid` FROM grid_trust WHERE gid='".$_REQUEST['grid_id']."';";
			$result = mysql_query($sql, $connection);
			if($result)
			{   
				if ( mysql_num_rows($result) == 1 )
				{   
					$object = mysql_fetch_object($result);
					$grid_id = $object->gid;
					
					
					if ($grid_id== $_REQUEST['grid_id'] )
					{        
							$sql = "DELETE FROM grid_trust WHERE gid='".$_REQUEST['grid_id']."';";
							if(mysql_query($sql, $connection))
								JSAlert('Delete successful.');
						
					}
				}
			}else
				JSAlert('Something wrong for deleting grid trusted host profile.');
		}
		 redirect_page("../user/user.gridhost.php?section=7");
	}	
?>