<?php
	session_start();

    require('connectdb.inc.php');
	require('visualization.class.php');
	require('setting.inc.php');
	require('function.inc.php');

	if(isset($_POST))
	{
		$sql = "SELECT * FROM visualize WHERE id=".$_POST['select_vis'];
		$result = mysql_query($sql, $connection);
		$profile = mysql_fetch_object($result);

		$fp_sender_contents = fopen($template['wave-animation']['3d']['sender'], "r");
		
		if($fp_sender_contents)
		{
			$input = explode(",", $profile->input);
			$port = array();
			if(isset($_POST['display_port_no_hid_val']))
			{
				$port = array(9001, 9002, 9003, 9004);
			}
			while(!feof($fp_sender_contents))
			{
				$buffer = fgets($fp_sender_contents, 1024);
				if(preg_match("/__URL_BATHYMETRY__/", $buffer))
						$buffer = str_replace("__URL_BATHYMETRY__", $input[0], $buffer);
						
				if(preg_match("/__URL_WATER__/", $buffer))
						$buffer = str_replace("__URL_WATER__", $input[1], $buffer);
						
				if(preg_match("/__WORKING_PATH__/", $buffer))
						$buffer = str_replace("__WORKING_PATH__", $_POST['work_dir'], $buffer);
						
				if(preg_match("/__IP_1__/", $buffer))
						$buffer = str_replace("__IP_1__", $_POST['display_node'][0], $buffer);
						
				if(preg_match("/__PORT_1__/", $buffer))
						$buffer = str_replace("__PORT_1__", $port[0], $buffer);
						
				if(preg_match("/__IP_2__/", $buffer))
						$buffer = str_replace("__IP_2__", $_POST['display_node'][1], $buffer);
						
				if(preg_match("/__PORT_2__/", $buffer))
						$buffer = str_replace("__PORT_2__", $port[1], $buffer);
						
				if(preg_match("/__IP_3__/", $buffer))
						$buffer = str_replace("__IP_3__", $_POST['display_node'][2], $buffer);
						
				if(preg_match("/__PORT_3__/", $buffer))
						$buffer = str_replace("__PORT_3__", $port[2], $buffer);
						
				if(preg_match("/__IP_4__/", $buffer))
						$buffer = str_replace("__IP_4__", $_POST['display_node'][3], $buffer);
						
				if(preg_match("/__PORT_4__/", $buffer))
						$buffer = str_replace("__PORT_4__", $port[3], $buffer);

				$contents_network_file .= $buffer;
			}
			fclose($fp_sender_contents);
		}
		
		$new_sender_contents = $contents_network_file;
		
		$contents_network_file = array();
		$port = array();
		if(isset($_POST['display_port_no_hid_val'])) {
			$port = array(9001, 9002, 9003, 9004);
		}
		
		for($i=0; $i<4; $i++)
		{	
			$fp_receiver_contents = fopen($template['wave-animation']['3d']['receiver'], "r");
			if($fp_receiver_contents)
			{
				while(!feof($fp_receiver_contents))
				{
					$buffer = fgets($fp_receiver_contents, 1024);
				
					if(preg_match("/__WORKING_PATH__/", $buffer))
							$buffer = str_replace("__WORKING_PATH__", $_POST['work_dir'], $buffer);
							
					if(preg_match("/__IP__/", $buffer))
							$buffer = str_replace("__IP__", $_POST['display_node'][$i], $buffer);
							
					if(preg_match("/__PORT__/", $buffer))
							$buffer = str_replace("__PORT__", $port[$i], $buffer);
	
					$temp .= $buffer;
					
				}
				fclose($fp_receiver_contents);
				$contents_network_file[$i] = $temp;
				$temp = '';
				$buffer = '';
			}
		}
		
		$new_receiver_contents = $contents_network_file;
		
		$sender_php = file_get_contents('../Templates/tiled-php-script/sender.php');
		$receiver_php = file_get_contents('../Templates/tiled-php-script/receiver.php');
		$dir = microtime();
		$dir = str_replace(' ', '-', $dir);
		if( mkdir("../tmp/".$dir))
		{
			file_put_contents("../tmp/".$dir."/sender.php", $sender_php);
			file_put_contents("../tmp/".$dir."/receiver.php", $receiver_php);
			file_put_contents("../tmp/".$dir."/dx-sender.net", $new_sender_contents);
			foreach ($new_receiver_contents as $index => $contents)
				file_put_contents("../tmp/".$dir."/dx-recv-".($index+1).".net", $contents);
		}
		header("location: ../user/user.newtiled-display.php");
	}
?>
