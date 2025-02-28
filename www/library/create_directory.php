<?php
	session_start();	
	require_once('function.inc.php'); 
	
	if ($_POST['create'] == "Create")
	{
		mkdir($_POST['old_dir']."/".$_POST['create_dir']) or die("! failed to create a new directory.");;
	}
	else
	{
		echo "Failed ......!";
	}
	//echo $_SESSION['q_str'];
	redirect_page($_SESSION['uri']);
?>