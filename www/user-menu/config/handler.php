<?php
	session_start();
	require_once('../../library/function.inc.php'); 
	
	define("DEBUG", 0);
	if(defined("DEBUG")) echo "<pre>Debug...\n";
		
	if(isset($_POST)) {
		require_once('../../library/connectdb.inc.php');
		$http_post_var = $_POST;
		#print_r($http_post_var);
		$f = config_handler::formulate($http_post_var);
		if(isset($_SESSION['cid']) && $_SESSION['cid'] > 0) {
			config_handler::update_var_db($connection, addslashes($f));
		}else {
			config_handler::insert_var_db($connection, addslashes($f));
		}
	}
	
	session_unregister("file_contents");
	redirect_page($_SESSION['uri']);
	
	class config_handler {
		static function insert_var_db($db_link, $data) {
			global $_POST;
			global $_SESSION;
				
			if(is_resource($db_link)) {
				$sql = "INSERT INTO seq_config_param(name, description, data, template_file, uid, date) ";
				$sql .= "VALUES('".$_POST['conf_name']['name']."', '".addslashes($_POST['conf_name']['des'])."', '".$data."', '".$_SESSION['file_contents']."', '".$_SESSION['uid']."', '".time()."')\n";				
				mysql_query($sql, $db_link);
			}
		}
		
		static function update_var_db($db_link, $data) {
			global $_POST;
			global $_SESSION;
			
			if(is_resource($db_link)) {
				$sql = "UPDATE `seq_config_param` SET  `name` = '".$_POST['conf_name']['name']."', `description` = '".addslashes($_POST['conf_name']['des'])."', `data` = '".$data."', `date` = '".time()."' ";
				$sql .= "WHERE var_id = ".$_SESSION['cid'];
				mysql_query($sql, $db_link);
			}
		}
		
		static function formulate($var) {
			$var_section = array("des", "val");
			$var_type = array("global", "input", "output");
			$sep = "{0x0000}";
			$header = "var_section".$sep."var_type".$sep."var_name".$sep."var_value\n";			
			$var_str = "";
			$var_str .= $header;
			foreach($var_section as $s_name) {
				foreach($var_type as $type_name) {
					foreach($var[$s_name][$type_name] as $v_name => $value) {
						$var_str .= $s_name.$sep.$type_name.$sep.$v_name.$sep.$value."\n";
					}
				}
			}
			return $var_str;
		}
	}
	
	if(defined("DEBUG")) echo "</pre>";
?>