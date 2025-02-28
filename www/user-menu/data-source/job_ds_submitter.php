<?php
	require_once('../../library/setting.inc.php');
	require_once('../../library/connectdb.inc.php');
	$url = "http://".$_SERVER['HTTP_HOST'].$this_host['working_dir']."/user-menu/data-source/".base64_decode($_REQUEST['url']);
	$sql = "INSERT INTO `job_submitter`(`url`, `status`) VALUES('".base64_encode($url)."', 'pending');";
	mysql_query($sql, $connection) or die("failed to queue the job.");
?>