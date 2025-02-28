<?php
	if ( $_REQUEST['file'] && strlen($_REQUEST['file']) == 32 )
	{
		require_once('connectdb.inc.php');
		require_once('function.inc.php');
		
		$sql = "SELECT `orgname`, `aliasname` FROM datasource WHERE aliasname='".$_REQUEST['file']."';";
		$result = mysql_query($sql, $connection);
		if($result)
		{
			if ( mysql_num_rows($result) == 1 )
			{
				$object = mysql_fetch_object($result);
				$db_org_filename = $object->orgname;
				$db_alias_filename = $object->aliasname;
				
				if ($db_alias_filename == $_REQUEST['file'] )
				{
					if(unlink('../workspace/formulated-data/'.$_REQUEST['file']))
					{
						$sql = "DELETE FROM datasource WHERE aliasname='".$_REQUEST['file']."';";
						if(mysql_query($sql, $connection))
							JSAlert('Delete file successful.', '../user/user.datasource.php');
					}else
						JSAlert('Could not delete file.');
				}
			}
		}else
			JSAlert('Something wrong for deleting file.');
	}
?>