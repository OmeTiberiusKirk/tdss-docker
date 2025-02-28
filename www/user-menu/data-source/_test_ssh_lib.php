<?php
	require_once("../../library/ssh.class.php");
	
	$ssh = new SSH();
	$host = "161.200.92.246";
	$username = "yod";
	$password = "yod";
	set_time_limit(3600);
	$ssh->connect($host, $username, $password, $port = 22);
	$f_list = $ssh->getFileList("/home/yod");
	/* remoteCopyFile($remote_filename, $direction, $local_filename, $mode = 0644 */
	//$ssh->remoteCopyFile("/home/yod/untitled-4.rar", "->", "aaa.tar.gz");
	echo "<pre>";
	print_r($ssh);
	print_r($f_list);
	echo "</pre>";
?>