<?php
	session_start();
	set_time_limit(0);
?>
<pre>
<?php
	/*
	print_r($_FILES);
	print_r($_POST);
	exit;
	*/
	
	require_once("lib.upload_from_source.php");
	
	
	if($_POST['new_filename']) {
		unset($_SESSION['filename']);
		unset($_SESSION['select']['reg_no']);
		unset($_SESSION['type']);
		
		$_POST['new_filename'] = trim($_POST['new_filename']);
		
		$_SESSION['filename'] = $_POST['new_filename'];
		$_SESSION['select']['reg_no'][$_POST['wl']['region_no']] = "selected";
		$_SESSION['no_of_grids_x'] = $_POST['wl']['no_of_grids_x'];
		$_SESSION['no_of_grids_y'] = $_POST['wl']['no_of_grids_y'];
		$_SESSION['type'][$_POST['wl']['type']] = "selected";		
	}
	
	if(isset($_POST['deform']['default_conf']) && $_POST['deform']['default_conf'] == "on" && $_FILES['fileform']['error'] != 0) {
		require_once("../../library/connectdb.inc.php");
		update_default($connection, "conf");
	}
	
	if(isset($_POST['deform']['default_param']) && $_POST['deform']['default_param'] == "on" && $_FILES['fileform']['error'] != 0) {
		require_once("../../library/connectdb.inc.php");
		update_default($connection, "param");
	}
	//exit;
	if(($_REQUEST['input_type'] == "sim" || $_REQUEST['input_type'] == "vis") && 
		($_REQUEST['data_type'] == "region" || $_REQUEST['data_type'] == "vis_file") 
		&& $_REQUEST['channel'] == "upload_file") {
		if($_REQUEST['data_type'] == "region") {
			$store_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Simulation/Bathymetry_and_Topography_File";
		} else {
			$store_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Visualization/Water_Level/Original";
		}
		$ds_param['files'] = $_FILES;
		$ds_param['info'] = $_POST;
		
		require_once('../../library/connectdb.inc.php');
		
		if(fn_upload_from_source($_REQUEST['grp_id'], $_POST['ds'], $ds_param, $store_path, $connection) == true) {
			echo "<script language=javascript>alert('Upload successful.');</script>";
		}
		echo "<script language=javascript>document.location.href='importer.php?grp_id=".$_REQUEST['grp_id']."&input_type=".$_REQUEST['input_type']."&data_type=".$_REQUEST['data_type']."&channel=".$_REQUEST['channel']."';</script>";
	}
		
	if($_REQUEST['input_type'] == "sim" && $_REQUEST['data_type'] == "deform" && $_REQUEST['channel'] == "upload_file") {
		$store_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Simulation/Deformation_File";
		if($_FILES['deform']['error'] == 0) {
			require_once('../../library/connectdb.inc.php');
			if(fn_check_dup("ds_input_deform", "filename", $_POST['new_filename'], $connection) == true) {
				if(move_uploaded_file($_FILES['fileform']['tmp_name'], $store_path."/".$_POST['new_filename'].".dat")) {
					if(isset($_POST['deform']['default_conf']) && $_POST['deform']['default_conf'] == "on") {
						$sql = "UPDATE `ds_input_deform` SET `default_conf` = 'no' WHERE `default_conf` = 'yes';";
						mysql_query($sql, $connection) or die("! could not update `ds_input_deform` 1");
					}
					
					if(isset($_POST['deform']['default_param']) && $_POST['deform']['default_param'] == "on") {
						$sql = "UPDATE `ds_input_deform` SET `default_param` = 'no' WHERE `default_param` = 'yes';";
						mysql_query($sql, $connection) or die("! could not update `ds_input_deform` 2");
					}
					
					$sql = "INSERT INTO 
								`ds_input_deform` (
									`id`, `filename`, `description`, `path`, 
									`glob_x_long`, `glob_y_lat`, `grid_space`, 
									`org_x`, `org_y`, `coord_long_1`, 
									`coord_long_2`, `coord_lat_1`, `coord_lat_2`, 
									`length`, `length_fault`, `width_fault`, 
									`epi_depth`, `dislocate`, `dip_angle`, 
									`strike_angle`, `rake_angle`, `long_epi`, 
									`lat_epi`, `max_upward`, `min_downward`, 
									`max_lat`, `max_long`, `min_lat`, 
									`min_long`, `default_conf`, 
									`default_param`, `create_date`) 
							VALUES (
									NULL, '".$_POST['new_filename'].".dat', '".$_POST['description']."', '".base64_encode($store_path."/".$_POST['new_filename'].".dat")."', 
									'".$_POST['fault_conf']['glob_x_long']."', '".$_POST['fault_conf']['glob_y_lat']."', '".$_POST['fault_conf']['grid_space']."', 
									'".$_POST['fault_conf']['org_x']."', '".$_POST['fault_conf']['org_y']."', '".$_POST['fault_conf']['coord_long_1']."', 
									'".$_POST['fault_conf']['coord_long_2']."', '".$_POST['fault_conf']['coord_lat_1']."', '".$_POST['fault_conf']['coord_lat_2']."', 
									'".$_POST['fault_conf']['length']."', '".$_POST['fault_conf']['length_fault']."', '".$_POST['fault_conf']['width_fault']."', 
									'".$_POST['fault_conf']['epi_depth']."', '".$_POST['fault_conf']['dislocate']."', '".$_POST['fault_conf']['dip_angle']."', 
									'".$_POST['fault_conf']['strike_angle']."', '".$_POST['fault_conf']['rake_angle']."', '".$_POST['fault_conf']['long_epi']."', 
									'".$_POST['fault_conf']['lat_epi']."', '".$_POST['fault_sum']['max_upward']."', '".$_POST['fault_sum']['min_downward']."', 
									'".$_POST['fault_sum']['max_lat']."', '".$_POST['fault_sum']['max_long']."', '".$_POST['fault_sum']['min_lat']."', 
									'".$_POST['fault_sum']['min_long']."', '".(($_POST['deform']['default_conf'] == "on") ? "yes":"no")."', 
									'".(($_POST['deform']['default_param'] == "on") ? "yes":"no")."', '".time()."');";
					/*
					$sql = "INSERT INTO `tsunami_version`.`ds_input_deform` ";
					$sql .= "(`id`, `filename`, `description`, `path`, `glob_x_long`, `glob_y_lat`, ";
					$sql .= "`grid_space`, `org_x`, `org_y`, `coord_long_1`, `coord_long_2`, ";
					$sql .= "`coord_lat_1`, `coord_lat_2`, `length`, `length_fault`, `width_fault`, ";
					$sql .= "`epi_depth`, `dislocate`, `dip_angle`, `strike_angle`, `rake_angle`, ";
					$sql .= "`long_epi`, `lat_epi`, `max_upward`, `min_downward`, ";
					$sql .= "`max_lat`, `max_long`, `min_lat`, `min_long`, `default_conf`, `default_param`, `create_date`)";
					$sql .= " VALUES (NULL, '".$_POST['new_filename']."', '".$_POST['description']."', '".base64_encode($store_path."/".$_POST['new_filename'])."', ";
					$sql .= "'".$_POST['fault_conf']['glob_x_long']."', '".$_POST['fault_conf']['glob_y_lat']."', ";
					$sql .= "'".$_POST['fault_conf']['grid_space']."', '".$_POST['fault_conf']['org_x']."', ";
					$sql .= "'".$_POST['fault_conf']['org_y']."', '".$_POST['fault_conf']['coord_long_1']."', ";
					$sql .= "'".$_POST['fault_conf']['coord_long_2']."', '".$_POST['fault_conf']['coord_lat_1']."', ";
					$sql .= "'".$_POST['fault_conf']['coord_lat_2']."', '".$_POST['fault_conf']['length']."', '".$_POST['fault_param']['length_fault']."', ";
					$sql .= "'".$_POST['fault_param']['width_fault']."', '".$_POST['fault_param']['epi_depth']."', ";
					$sql .= "'".$_POST['fault_param']['dislocate']."', '".$_POST['fault_param']['dip_angle']."', ";
					$sql .= "'".$_POST['fault_param']['strike_angle']."', '".$_POST['fault_param']['rake_angle']."', ";
					$sql .= "'".$_POST['fault_param']['long_epi']."', '".$_POST['fault_param']['lat_epi']."', ";
					$sql .= "'".$_POST['fault_sum']['max_upward']."', '".$_POST['fault_sum']['min_downward']."', '".$_POST['fault_sum']['max_lat']."', '".$_POST['fault_sum']['max_long']."', '".$_POST['fault_sum']['min_lat']."', '".$_POST['fault_sum']['min_long']."', '".(($_POST['deform']['default_conf'] == "on") ? "yes":"no")."', '".(($_POST['deform']['default_param'] == "on") ? "yes":"no")."', '".time()."');";
					//echo $sql;
					//exit; */
					mysql_query($sql, $connection);
					echo "<script language=javascript>alert('Upload successful.');</script>";
				}
			}else {
				echo "<script language=javascript>alert('Duplicate filename !');</script>";
			}
			echo "<script language=javascript>document.location.href='importer.php?grp_id=".$_REQUEST['grp_id']."&input_type=".$_POST['input_type']."&data_type=".$_POST['data_type']."&channel=".$_POST['channel']."';</script>";
		}
	}
	
	function update_default($db_conn, $type) {
		global $_POST;
		switch($type) {
			case "conf":
				$sql = "UPDATE `ds_input_deform` SET `default_conf` = 'no' WHERE `default_conf` = 'yes';";
				//echo $sql."<br>";
				mysql_query($sql, $db_conn);
				$sql = "UPDATE `ds_input_deform` SET `default_conf` = 'yes' WHERE `id` = ".$_POST['fault_conf']['profile'];
				//echo $sql."<br>";
				mysql_query($sql, $db_conn);
				break;
			case "param":
				$sql = "UPDATE `ds_input_deform` SET `default_param` = 'no' WHERE `default_param` = 'yes';";
				//echo $sql."<br>";
				mysql_query($sql, $db_conn);
				$sql = "UPDATE `ds_input_deform` SET `default_param` = 'yes' WHERE `id` = ".$_POST['fault_param']['profile'];
				//echo $sql."<br>";
				mysql_query($sql, $db_conn);
				break;
		}
	}
?>
</pre>
