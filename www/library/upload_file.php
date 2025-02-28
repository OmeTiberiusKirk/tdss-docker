<?php
	session_start();	
	require_once('function.inc.php'); 
	$uploaddir = $_POST['old_dir'];
	$uploadfile = $uploaddir.(stristr(PHP_OS, "WIN") ? "\\" : "/").$_FILES['userfile']['name'];
	
	if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
		die("Impossible file upload attack!");
	redirect_page($_SESSION['uri']);
?>


