<?php
	session_start();
	
	//set_time_limit(600000);
	echo "<pre>";
	//print_r($_POST);
    require('connectdb.inc.php');
	require('../../library/visualization.class.php');
	require('setting.inc.php');
	require('function.inc.php');
	
	
	$Lattitude = array();
	$Longitude = array();
	$autoaxes_lat = array();
	$autoaxes_long = array();
	$Val_4_Point = array();
	$point = array();
	
	/* specify .general or .dx of region and water_level files */
	/*
		for ETA:
			$url_ds_region = "region.dx";
			$url_ds_data = "eta.dx";
		for ZMAX:
			$url_ds_region = "region.dx";
			$url_ds_data = "zmax.dx";
	*/
	$url_ds_region = "D:/re_dx/sumatra_84/general/region1.general";
	$url_ds_data = "D:/re_dx/sumatra_84/general/eta1.general";
	
	/* create name for making directory at remoted host */
	$network_filename = generateRanString();
	
	/* start the stopwatch */
	$start_time = microtime(true);
	
	/* create instance of Visualization */
	$v = new Visualization("The Elapsed Time Arrival", "3D", $network_filename, "1");
	
	/* (1) Calculate Lat & Long for autoaxes  */
   	//-----------------Lattitude -----------------------
	$Lat_1 =-10;  $Lat_Lipda_1 =0; $Lat_Philipda_1 = 0;
	$Lat_2 = 18; $Lat_Lipda_2 = 0; $Lat_Philipda_2 = 0; 
	$Lattitude = array(); $j =0;	
		
	//-----------------Longitude------------------------------
	$Long_1 = 87;  $Long_Lipda_1 = 0; $Long_Philipda_1 = 0;
	$Long_2 = 110; $Long_Lipda_2 = 0; $Long_Philipda_2 = 0; 
	$Longitude = array(); 		
	
	//------ Grid Size ---------- 
	$Grid_x = 690; $Grid_y = 840;
		
	//-----------Scale--------------------- 
	$Scale_Lipda = 2;  $Scale_Philipda = 0;
		
	//------------ Region ---------
	/* number of region */
	$region = 1;
		
	/* refer to simulation result id ? */
	$Simulation_Result_id = 3;
		
	//--------- water-surface file ----------
	/* refer to water surface file */
	$filename = "D:/re_dx/sumatra_84/eta1.out";
		
	/* (1) ####### Calaulate_Lat_Long ##############*/
	/* calculate the ... ? */
	$Lattitude = $v->calculate_Lat_Long(
						$Lat_1, $Lat_Lipda_1, $Lat_Philipda_1, 
						$Lat_2, $Lat_Lipda_2, $Lat_Philipda_2, 
						$Scale_Lipda, $Scale_Philipda, 
						$Grid_x, $Grid_y, 
						$Scale_Lipda, $Scale_Philipda, "lat");
						
	$Longitude = $v->calculate_Lat_Long(
						$Long_1, $Long_Lipda_1, $Long_Philipda_1, 
						$Long_2, $Long_Lipda_2, $Long_Philipda_2, 
						$Scale_Lipda, $Scale_Philipda, 
						$Grid_x, $Grid_y, 
						$Scale_Lipda, $Scale_Philipda, "long");
	//print_r($Lattitude);print_r($Longitude);
		
	/* (2) ######## Calculate AutoAxes ##############*/
	$autoaxes_lat = $v->Calculate_AutoAxes($Lattitude[0], $Lattitude[2], $Grid_y);
	$autoaxes_long = $v->Calculate_AutoAxes($Longitude[0], $Longitude[2], $Grid_x);
	
	/* set array to string for DX */
	for($i = 0; $i<count($autoaxes_lat['dx']); $i++) {
		$axes_y_position = implode($autoaxes_lat['dx']," ");
		if($i == (count($autoaxes_lat['dx'])-1))
			$axes_y_label    .= '"'.$autoaxes_lat['list'][$i].'" ';
		else
			$axes_y_label    .= '"'.$autoaxes_lat['list'][$i].'", ';
	}
	//print_r($autoaxes_long);
	
	for($i = 0; $i<count($autoaxes_long['dx']); $i++) {
		$axes_x_position = implode($autoaxes_long['dx']," ");
		if($i == (count($autoaxes_long['dx'])-1))
			$axes_x_label    .= '"'.$autoaxes_long['list'][$i].'" ';
		else
			$axes_x_label    .= '"'.$autoaxes_long['list'][$i].'", ';
	}
	//echo "/n axes_x_label = ".$axes_x_label;
		
	/* (3) ########## Calculate Observation Point ################*/
	$sql = "select * From `point` Where uid = ".$id."";
	$res = mysql_query($sql, $connection);
	$obj = mysql_fetch_object($res);
	$Val_4_Point = $v->Calculate_Value_4_Point($obj, $res);
	//print_r($Val_4_Point);
	
	for($i = 0; $i<count($Val_4_Point['name']); $i++) {
		$point[$i] = $v->Calculate_Point(
						$Val_4_Point['lat'][$i], $Val_4_Point['long'][$i], 
						$Lattitude[0], $Lattitude[1], $Lattitude[2], 
						$Longitude[0], $Longitude[1], $Longitude[2], $region);
		if($i == (count($Val_4_Point['name'])-1)) {
			$point_name    .= '"'.$Val_4_Point['name'][$i].'" ';
			$point_position .= "[".$point[$i]['lat']." ".$point[$i]['long']." 0]";
			//$row == 342 && $column == 242
			//$point_4_cal_val .= "(if(\$row == ".round($point[$i]['lat'])." && \$column == ".round($point[$i]['long']).")){ /$$point_name[][/$i] = /$buff; /$i = /$i + 1;}  ";
		} else {
			$point_name    .= '"'.$Val_4_Point['name'][$i].'", ';
			$point_position .= "[".$point[$i]['lat']." ".$point[$i]['long']." 0], ";
			//   $point_4_cal_val .= "(if(\$row == ".round($point[$i]['lat'])." && \$column == ".round($point[$i]['long']).")){ /$[$point_name][/$i] = /$buff; /$i = /$i + 1;}  ";
		}
	}
	
	//echo $point_4_cal_val;
	//print_r($point);
	$point_table = $v->Calculate_Point_Table($point, $Val_4_Point['name'], $Grid_x, $Grid_y, $filename);
	//print_r($point_table);
	//echo $point_position;
	
	/* set up the contour line */	
	$contour_line = "60 120 180 240 300 360 420 480 540 600 660 720";
		
	/* (4) ################  create .net ####################
	$v->createNetworkFile(
		$url_ds_region, 
		$url_ds_data, 
		$network_filename, 
		1500, 	//zoom
		900, 	//resolution
		180, 	//rotate_x
		0, 		//rotate_y
		0,		//rotate_z
		690,	//grid_x
		840,	//grid_y
		$_POST['timestep'],
		"region1.general",
		"eta1.general",
		$axes_y_position,
		$axes_y_label,
		$axes_x_position,
		$axes_x_label,
		$point_name,
		$point_position,
		$contour_line
	);	*/	
		
	/* (5) create shell script */
	//$v->createRunSH($ran_string);
		
	/* (6) execute the visualization's script */
	//$v->executeDXSHELL();
		
	/* (7) make directory to store the visualization result */
	//$time = time();
	//$str_datetime = date('Ymd-His');
	//$local_save_dir = $_SESSION['vis-path']."/visres-".$str_datetime;
	//if(mkdir($local_save_dir)) {
			
		/* (8) get all of image back to local dir */
		//$store_path = $v->getVisResultBack($local_save_dir);
			
		/* (9) save information */
		/*$sql = "	INSERT INTO visualize(
						uid, name, description, type, style, region, 
						gridsize_x, gridsize_y, timestep, zoom, 
						resolution, rotate_x, rotate_y, rotate_z, 
						store_path, input, filename, status, 
						aliasname_file_1, aliasname_file_2, date) 
					VALUES(
						'".$_SESSION['uid']."', '".$_POST['name']."', '".$_POST['detail']."', '".$_POST['type']."', '".$_POST['style']."', '".$_POST['region']."',
						'".$_POST['gridsize_x']."', '".$_POST['gridsize_y']."', '".$_POST['timestep']."', '".$_POST['zoom']."',
						'".$_POST['resolution']."', '".$_POST['rotate_x']."', '".$_POST['rotate_y']."', '".$_POST['rotate_z']."',
						'".$store_path."', '".$_POST['hid_val_regionfile'].",".$_POST['hid_val_data']."', '".$_POST['regionfile'].",".$_POST['data']."', 
						'".$_POST['status']."', '".$_POST['hid_val_regionfile']."', '".$_POST['hid_val_data']."', '".time()."')";
		//$result = mysql_query($sql, $connection);
		//$id = mysql_insert_id($connection);
			
		/* (10) clean up */
		//$v->cleanUp();

		//$end_time = microtime(true);
		//JSAlert("Time used = ".($end_time-$start_time)." seconds.\\nVisualization Process successful.");
	//}else //{
			//$end_time = microtime(true);
			//JSAlert("Time used = ".($end_time-$start_time)." seconds.\\nVisualization Process Failed !.\\nReason : Could not create output directory.");
			//JSAlert("Time used = ".($end_time-$start_time)." seconds.");
	//}

	echo "</pre>";
?>