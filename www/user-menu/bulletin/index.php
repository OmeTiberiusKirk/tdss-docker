<?php
	session_start();
	if(!isset($_SESSION['username'])) {
		echo "<script language=\"javascript\">location.href='../';</script>";
	}else {
		header('location: general.php');
	}
?>

