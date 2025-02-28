<?php
	session_start();
	require_once('../../library/function.inc.php'); 
	
	define("DEBUG", 0);
	if(defined("DEBUG")) echo "<pre>Debug...\n";
		
	if(isset($_POST)) {
		require_once("../../library/connectdb.inc.php");
		$http_post_var = $_POST;
		foreach($_POST['des']['global'] as $vname => $value) {
			$_POST['des']['global'][$vname] = addslashes($value);
		}
		ConfigHandler::insert_var_db();
	}
	
	redirect_page('seq_p1.php?section=10');

	class ConfigHandler {
		static function insert_var_db() {	
			global $http_post_var;
			require_once('../../library/connectdb.inc.php');
			if(isset($http_post_var['des']) && isset($http_post_var['val']) && $connection) {
				$data = serialize($http_post_var);
				$sql = "UPDATE seq_config_param
						SET  
							data = '".addslashes(serialize($http_post_var))."',
							date = '".time()."'

						WHERE
							var_id = ".$_SESSION['cid']." \n";	
							//echo $sql;	
				mysql_query($sql, $connection);
			}
			mysql_close($connection);
			
		}
	}
	
	if(defined("DEBUG")) 
		echo "</pre>";
?>