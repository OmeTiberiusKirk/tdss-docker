<?php
	session_start();	
	
	require_once('function.inc.php'); 

	if($_REQUEST['path']){
		$path = base64_decode($_REQUEST['path']).(stristr(PHP_OS, "WIN") ? "\\" : "/");
		$namef = base64_decode($_REQUEST['filename']);
		if(!is_readable($path)) 
			die('File not found or inaccessible!');
		
	}
	
	require_once('zip.lib.php');	
	
	$zipTest = new zipfile();
	$zipTest->add_file($path.$namef, $namef);
	$filename = $path.$namef.".zip";
	$fd = fopen ($filename, "wb");
	$out = fwrite ($fd, $zipTest -> file());
	fclose ($fd);
	redirect_page($_SESSION['uri']);

?>