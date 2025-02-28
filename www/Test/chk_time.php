<?php
	echo "<pre>";
	//date_default_timezone_set("Asia/Bangkok");
	
	// Assuming today is: March 10th, 2001, 5:16:18 pm
	$today = date("F j, Y, g:i a");                 // March 10, 2001, 5:16 pm
	echo $today."\n";
	
	$today = date("m.d.y");                         // 03.10.01
	echo $today."\n";	
	
	$today = date("j, n, Y");                       // 10, 3, 2001
	echo $today."\n";	
	
	$today = date("Ymd");                           // 20010310
	echo $today."\n";	
	
	$today = date('h-i-s, j-m-y, it is w Day z ');  // 05-16-17, 10-03-01, 1631 1618 6 Fripm01
	echo $today."\n";
		
	$today = date('\i\t \i\s \t\h\e jS \d\a\y.');   // It is the 10th day.
	echo $today."\n";
		
	$today = date("D M j G:i:s T Y");               // Sat Mar 10 15:16:08 MST 2001
	echo $today."\n";
		
	$today = date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:17 m is month
	echo $today."\n";
		
	$today = date("H:i:s");                         // 17:16:17
	echo $today."\n";	
	echo "</pre>";
?>