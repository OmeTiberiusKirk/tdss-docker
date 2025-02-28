<?php
	session_start();	
	require_once('function.inc.php'); 
	//$path = base64_decode($_REQUEST['file']);
	if(stristr(php_os, 'WIN')) {
		$path = str_replace("|", "\\", $_REQUEST['file']);
	} else {
		$path = str_replace("|", "/", $_REQUEST['file']);
	}
	
	//echo $path;
	function remove_directory($dir) {
		 if ($handle = opendir("$dir")) {
		   while (false !== ($item = readdir($handle))) {
			 if ($item != "." && $item != "..") {
			   if (is_dir("$dir/$item")) {
				 remove_directory("$dir/$item");
			   } else {
				 unlink("$dir/$item");
				 //echo " removing $dir/$item\n";
			   }
			 }
		   }
		   closedir($handle);
		   rmdir($dir);
		   //echo "removing $dir\n";
		 }
	}
	if (is_dir($path)) 
	{
		remove_directory($path);
	}
	else{
		/*
		echo $path;
		exit;
		*/
		unlink($path);
		/*if(strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
			exec("echo Y | rd /s ".$path) or die("! [win32] failed to delete job dir");
		else
			exec("rm -rf ".$path) or die("! [*nix] failed to delete job dir");
			
		*/
	}
	/*echo "<script language=\"javascript\">alert('Deleted ".$_REQUEST['name']." Successful !!!'); location.href='".$_SESSION['uri']."';</script>";*/
	redirect_page($_SESSION['uri']."&result=success");
?>