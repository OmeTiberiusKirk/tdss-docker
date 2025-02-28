<?php
	if(isset($_REQUEST['job_id'])) {
		require_once('../../library/connectdb.inc.php');
		if(is_resource($connection)) {
			$sql = "SELECT * FROM `job_dx_formulate` WHERE `id`=".$_REQUEST['job_id'];
			echo "test";
			$res = mysql_query($sql, $connection) or die("! could not get a job id");
			if( mysql_num_rows($res) == 1 ) {
				$job_id = $obj->id;
				echo "hello";
			}
		}
	}
?>