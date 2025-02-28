<?php
	require_once('function.inc.php'); 
	if($_REQUEST['file']){
		$path = base64_decode($_REQUEST['file']);
		$name = base64_decode($_REQUEST['filename']);
		if(!is_readable($path)) 
			die('File not found or inaccessible!');
		
		force_download($path, $name, 'text/plain');
	}
	
?>