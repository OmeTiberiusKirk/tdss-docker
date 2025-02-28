<?php
	session_start();
	set_time_limit(7200);
	if(!isset($_SESSION['username']))
	{
		echo "<script language=\"javascript\">location.href='../';</script>";
	}else
	{
		require_once('connectdb.inc.php');
		require_once('visualization.class.php');
		require_once('function.inc.php');
	
		
		echo "<pre>";
		print_r($_POST);
		
		
	    //echo $_POST[['file_1'];
		$url_ds_region = $_POST['file_1'];
		$url_ds_data = $_POST['file_2'];
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
			$_POST['region_file'],
			$_POST['data_file']
		);
		
		/* (2) create shell script */
		$v->createRunSH($ran_string);
		
		/* (3) execute */
		$v->executeDXSHELL();
		
		/* (4) make directory to store the visualization result */
		/*
			$time = time();
			$str_datetime = date('Ymd-His');
			$local_save_dir = $_SESSION['vis-path']."/visres-".$str_datetime;
		*/
		echo "store_path = ".$_POST['store_path']."\n";
		recursive_remove_directory($_POST['store_path']);
		$path_t = explode("/", $_POST['store_path']);


		unset($path_t[5]);
		$path_delete = implode("/", $path_t);
		
		echo "delete path = ".$path_delete."\n";
		recursive_remove_directory($path_delete);
		
		unset($path_t[4]);		
		
		$path_t = implode("/", $path_t);
		
		$local_save_dir = $path_t;
		echo "save path = ".$local_save_dir."\n";
		
		if(is_dir($local_save_dir))
		{
			$store_path = $v->getVisResultBack($local_save_dir);
			
			$sql = "	UPDATE visualize
						SET 
							name = '".$_POST['name']."', 
							description = '".$_POST['description']."', 
							zoom = ".$_POST['zoom'].", 
							resolution = ".$_POST['resolution'].", 
							rotate_x = ".$_POST['rotate_x'].", 
							rotate_y = ".$_POST['rotate_y'].", 
							rotate_z = ".$_POST['rotate_z'].",
							status = '".$_POST['status']."',  
							date = '".time()."'
						WHERE
							UID = ".$_SESSION['uid']." AND id = ".$_POST['id'];
			
			echo $sql;
			$result = mysql_query($sql, $connection);
			$id = $_POST['id'];
			
			$v->cleanUp();

			$end_time = microtime(true);
			//JSAlert("Time used = ".($end_time-$start_time)." seconds.\\nVisualization Process successful.", "../user/user.visres-expand.php?section=2&id=".$id);
			redirect_page("../user/user.visres-expand.php?section=2&id=".$id);
		}else
		{
			$end_time = microtime(true);
			JSAlert("Time used = ".($end_time-$start_time)." seconds.\\nVisualization Process Failed !.\\nReason : Could not create output directory.", "../user/user.visres.php?section=2");
		}
		echo "</pre>";
	}
?>