<?php
	session_start();
	
	set_time_limit(7200);
	
	echo "<pre>";
	
	//print_r($_POST);

    require('connectdb.inc.php');
	require('visualization.class.php');
	require('setting.inc.php');
	require('function.inc.php');
	
	if(isset($_POST))
	{
		$url_ds_region = $host_addr_dir."library/download.php?file=".$_POST['hid_val_regionfile'];
		$url_ds_data = $host_addr_dir."library/download.php?file=".$_POST['hid_val_data'];
		$ran_string = generateRanString();
		$start_time = microtime(true);
		$v = new Visualization($_POST['type'], $_POST['style'], $ran_string, $_POST['region']);
		
		/* (1) create .net */		
		$v->createNetworkFile(
			$url_ds_region, 
			$url_ds_data, 
			$ran_string, 
			$_POST['zoom'], 
			$_POST['resolution'], 
			$_POST['rotate_x'], 
			$_POST['rotate_y'], 
			$_POST['rotate_z'],
			$_POST['gridsize_x'], 
			$_POST['gridsize_y'],
			$_POST['timestep'],
			$url_ds_region,
			$url_ds_data
		);
		
		/* (2) create shell script */
		$v->createRunSH($ran_string);
		
		/* (3) execute */
		$v->executeDXSHELL();
		
		/* (4) make directory to store the visualization result */
		$time = time();
		$str_datetime = date('Ymd-His');
		$local_save_dir = $_SESSION['vis-path']."/visres-".$str_datetime;
		if(mkdir($local_save_dir))
		{
			/* (5) get all of image back to local dir */
			$store_path = $v->getVisResultBack($local_save_dir);
			
			/* (6) save information */
			$sql = "	INSERT INTO 
						visualize(
							uid, name, description, type, style, region, gridsize_x, gridsize_y, timestep, zoom, resolution, rotate_x, rotate_y, rotate_z, store_path, input, filename, status, aliasname_file_1, aliasname_file_2, date) 
						VALUES(
							'".$_SESSION['uid']."',
							'".$_POST['name']."',
							'".$_POST['detail']."',
							'".$_POST['type']."',
							'".$_POST['style']."',
							'".$_POST['region']."',
							'".$_POST['gridsize_x']."',
							'".$_POST['gridsize_y']."',
							'".$_POST['timestep']."',
							'".$_POST['zoom']."',
							'".$_POST['resolution']."',
							'".$_POST['rotate_x']."',
							'".$_POST['rotate_y']."',
							'".$_POST['rotate_z']."',
							'".$store_path."',
							'".$_POST['hid_val_regionfile'].",".$_POST['hid_val_data']."',
							'".$_POST['regionfile'].",".$_POST['data']."',
							'".$_POST['status']."',
							'".$_POST['hid_val_regionfile']."',
							'".$_POST['hid_val_data']."',
							'".time()."')";
			$result = mysql_query($sql, $connection);
			$id = mysql_insert_id($connection);
			
			/* (7) clean up */
			$v->cleanUp();

			$end_time = microtime(true);
			JSAlert("Time used = ".($end_time-$start_time)." seconds.\\nVisualization Process successful.", "../user/user.visres-expand.php?section=2&id=".$id);
		}else
		{
			$end_time = microtime(true);
			JSAlert("Time used = ".($end_time-$start_time)." seconds.\\nVisualization Process Failed !.\\nReason : Could not create output directory.", "../user/user.visres.php?section=2");
		}
	}
	echo "</pre>";
?>
