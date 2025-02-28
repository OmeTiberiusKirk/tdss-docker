<?php
	session_start();
	    echo "<pre>";
		if ($_POST['set_to_home'] != "on")
			$_POST['set_to_home'] = "off";
			print_r($_POST);
		$sql = "	UPDATE expr_info
						SET 
							name = '".$_POST['name']."', 
							description = '".$_POST['description']."', 
							last_update = '".time()."', 
							domain = ".$_POST['domain'].", 
							source = ".$_POST['source'].", 
							observ_area = ".$_POST['observ_area'].", 
							set_to_home = ".$_POST['set_to_home'].",

						WHERE
							uid = ".$_SESSION['uid']." AND expr_id = ".$_POST['eid'];
		echo "</pre>";
	
?>