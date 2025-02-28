<?php
	session_start();
	if(!isset($_SESSION['username']))
	{
		echo "<script language=\"javascript\">location.href='../';</script>";
	}else
	{
		require_once('connectdb.inc.php');
		require_once('function.inc.php');
		
		$sql = "SELECT * FROM visualize WHERE UID = ".$_SESSION['uid']." AND id = ".$_GET['id'];
		$result = mysql_query($sql, $connection);
		if(mysql_num_rows($result) == 1 )
		{
			$object = mysql_fetch_object($result);
			$dir = $object->store_path;
			$dirlist = explode("/", $dir);
			unset($dirlist[count($dirlist)-1]);
			$vis_dir = $dirlist[0]."/".$dirlist[1]."/".$dirlist[2]."/".$dirlist[3];
			$image_dir = $dirlist[0]."/".$dirlist[1]."/".$dirlist[2]."/".$dirlist[3]."/".$dirlist[4];
			$filelist = scandir($dir);
			unset($filelist[0], $filelist[1]);
			
			foreach($filelist as $filename)
			{
				if(!unlink($image_dir."/".$filename))
					echo "! delete visualize output is not successful.\n";
			}
			
			rmdir($image_dir);
			rmdir($vis_dir);
			
			$sql = "DELETE FROM visualize WHERE UID = ".$_SESSION['uid']." AND id = ".$_GET['id'];
			if(!mysql_query($sql, $connection))
				echo "! delete infomation from database failed.\n";
		}	
	}
?>
<script language="javascript">
	document.location.href = '../user/user.visres.php?section=2';
</script>
