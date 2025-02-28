<?php
	require_once('D:/Project_TSUNAMI/wwwroot/v8/library/connectdb.inc.php');
	$sql = "SELECT * FROM `job_submitter` WHERE `status` = 'pending';";
	$res = mysql_query($sql, $connection) or die("failed");
	if(mysql_num_rows($res) > 0) {
		while($obj = mysql_fetch_object($res)) {
			$contents = file_get_contents(base64_decode($obj->url));
			echo $contents;
			if($contents == "submitted") {
				$sql = "UPDATE `job_submitter` SET `status` = 'processing' WHERE `id`=".$obj->id;
				mysql_query($sql, $connection);
			}
		}
	}
?>