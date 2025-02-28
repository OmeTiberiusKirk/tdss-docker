<?php

	require_once("setting.inc.php");
	
	$hostname = $db['hostname'];
	$username = $db['username'];
	$password = $db['password'];
	$db_name = $db['db_name'];
	
	$connection = mysql_connect($hostname, $username, $password) or die("! Could not connect to database ".mysql_error());
	if ($connection){
		mysql_select_db($db_name, $connection) or die("<script language=\"javascript\">alert('Error : Could not select database !'); location.href='../';</script>");
		mysql_query("SET CHARACTER SET utf8");
	}
	
	function fn_get_last_auto_increment_id($table_name) {
		global $connection;
		global $db_name;
		
		$res = mysql_query("SHOW TABLE STATUS FROM `".$db_name."` LIKE '".$table_name."';", $connection);
		if(mysql_num_rows($res) > 0) {
			$obj = mysql_fetch_object($res);
			mysql_free_result($res);
		}
		return $obj->Auto_increment;
	}

?>