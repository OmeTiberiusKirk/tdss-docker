<?php
	session_start();
	require_once('../../library/function.inc.php'); 
	//define("DEBUG", 0);
	
	//if(defined("DEBUG")) 
	echo "<pre>";
		
	if(isset($_POST)) {
		$http_post_var = $_POST;
		//print_r($http_post_var);
		
		//print_r($_REQUEST);
		//echo base64_decode($_SESSION['cid']);
		ConfigHandler::insert_var_db();
	}
	
	redirect_page('seq_p1.php?section=10');
			/*switch($filename) {
				case "seq_p1.php": ConfigHandler::check_db_var_exists(); break;
				case "seq_p2.php": break;
				case "seq_p3.php": ConfigHandler::insert_var_db(); break;
			}*/

	exit;
	
	class ConfigHandler {
	
		static function insert_var_db() {	
		
			global $http_post_var;
			
			require_once('../../library/connectdb.inc.php');
			if($connection) {
				$var_id = $_POST['default'];
				
				$sql = "select var_id from seq_config_param";
				$res = mysql_query($sql, $connection);
					if($res)
					{	
						if(mysql_num_rows($res) != NULL )
						{					
							$no = mysql_num_rows($res);
							for($a = 0; $a < $no; $a++){
							
								$obj = mysql_fetch_object($res);
								$param_id[$a]= $obj->var_id;
								if($param_id[$a] == $var_id){
									$sql_param[$a] = "UPDATE seq_config_param SET default_param = 'yes' WHERE var_id = ".$var_id." \n";
									mysql_query($sql_param[$a], $connection);				
								}else{
									$sql_param[$a] = "UPDATE seq_config_param SET default_param = 'no' WHERE var_id = ".$param_id[$a]." \n";	
									mysql_query($sql_param[$a], $connection);
								}
							}
						}		
						//print_r($sql_param);
					}			
				
				//mysql_query($sql, $connection);
			}
			mysql_close($connection);
			
		}
		
		
	}
	
	//if(defined("DEBUG")) 
		echo "</pre>";
?>