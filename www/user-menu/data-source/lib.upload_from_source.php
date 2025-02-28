<?php
	session_start();
	
	/* set unlimit timeout */
	set_time_limit(0);

	function fn_upload_from_source($grp_id, $source_type, $param, $store_path, $db_link) {
		switch($source_type) {
			case "local":
				if(is_uploaded_file($param['files']['fileform']['tmp_name'])){
					if(isset($param['info']['wl']['region_no'])) {
					$org_file = $param['info']['new_filename']."_".strtoupper($param['info']['wl']['region_no'])."_".strtoupper(str_replace("_", "", $param['info']['wl']['type']));
					} else {
						$org_file = $param['info']['new_filename'];
					}
					$param['info']['store_path'] = $store_path."/".$org_file.".dat";
					
					/*
					echo $param['info']['store_path'];
					exit;
					*/
					
					if(move_uploaded_file($param['files']['fileform']['tmp_name'], $param['info']['store_path'])) {
						mysql_query("START TRANSACTION", $db_link) or die("! could not start transaction.");
						$param['info']['new_filename'] = $org_file;
						if(fn_save_info($grp_id, $param['info'], $db_link) == false) 
							return false;
							
						if($param['info']['data_type'] == "vis_file") {
							$store_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Visualization/Water_Level/Original";
							convert_to_dx(
								$grp_id, 
								$param['info']['data_type'],
								$store_path, 
								$org_file, 
								$param['info']['wl']['no_of_grids_x'], 
								$param['info']['wl']['no_of_grids_y'], 
								$param['info']['wl']['region_no'],
								$db_link,
								$param['info']['wl']['type'],
								$param['info']['wl']['time_step']
							);
						} else {
							convert_to_dx(
								$grp_id, 
								$param['info']['data_type'],
								$store_path, 
								/*$param['info']['new_filename'], */
								$org_file, 
								$param['info']['region']['no_of_grids_x'], 
								$param['info']['region']['no_of_grids_y'], 
								$param['info']['region']['no'],
								$db_link
							);
						}
						mysql_query("COMMIT", $db_link);
						return true;
					}else return false;
				}else {
					if(!isset($connection)) {
						require_once("../../library/connectdb.inc.php");
					}
					if($param['info']['region']['default'] == "on") {
						$sql = "UPDATE `ds_input_region` SET `default` = 'yes' WHERE `id` = ".$param['info']['region']['profile']." AND `grp_id` = ".$grp_id.";";
						mysql_query("UPDATE `ds_input_region` SET `default` = 'no' WHERE `grp_id` = ".$grp_id, $connection);
					}/*else
						$sql = "UPDATE `ds_input_region` SET `default` = 'no';";*/
					mysql_query($sql, $connection);
					//exit;
					return false;
				}
				break;
			case "cluster": 
				echo "<script language=javascript>alert('This channel is not available !');</script>";
				return true;
				break;
		}
	}
	
	function convert_to_dx($grp_id, $type, $path, $org_filename, $no_of_grids_x, $no_of_grids_y, $region_no, $db_link, $vis_type=NULL, $timestep=NULL) {
	
		require_once("../../library/setting.inc.php");
		require_once("../../library/ssh.class.php");
		require_once('../../library/zip.lib.php');
		
		$tmp_dir = "_tmp/";
		
		if(!is_dir($tmp_dir)) {
			mkdir($tmp_dir) or die("! could not create temp dir.");
		}
		
		$s_dir = time();
		$tmp_working_dir = $tmp_dir.$s_dir;
		mkdir($tmp_working_dir) or die("! could not create temp of time dir.");
		$tmp_working_dir = realpath($tmp_working_dir);
							
		$DX_network_file = file_get_contents($template['location']['network_file']);
		$DX_general_file = file_get_contents($template['location']['general_file']);
		$DX_run_file_contents = file_get_contents($template['location']['run_file']);
		
		/* 1) replacing label in network file */
		$remote_filepath = $run_at['working_dir']."/".$s_dir;
		$DX_network_file = str_replace("GENERAL_FILEPATH", $remote_filepath."/".$org_filename.".general", $DX_network_file);
		$DX_network_file = str_replace("GENERAL_FILENAME", $org_filename.".general", $DX_network_file);
		$DX_network_file = str_replace("EXPORT_FILEPATH", $remote_filepath."/".$org_filename.".dx", $DX_network_file);

		$dx_network_file_contents = $DX_network_file;
		file_put_contents($tmp_working_dir."/".$org_filename.".net", $dx_network_file_contents);
						
		/* 2) replacing label in general file */
		$DX_general_file = str_replace("__FILE_LOCATION__", $remote_filepath."/".$org_filename.".dat", $DX_general_file);
		$DX_general_file = str_replace("__NO_OF_GRIDS_X__", $no_of_grids_x, $DX_general_file);
		$DX_general_file = str_replace("__NO_OF_GRIDS_Y__", $no_of_grids_y, $DX_general_file);
		
		/* 3) replacing label in run shell file */
		$DX_run_file_contents = str_replace("GENERAL_FILENAME", $org_filename, $DX_run_file_contents);
		
		$dx_general_file_contents = $DX_general_file;
		file_put_contents($tmp_working_dir."/".$org_filename.".general", $dx_general_file_contents);
		file_put_contents($tmp_working_dir."/run.sh", $DX_run_file_contents);
						
		/* zip data file */
		$zipTest = new zipfile();
		$org_path_to_file = $path."/".$org_filename.".dat";
		$zipTest->add_file($org_path_to_file, $org_filename.".dat");
		$z_filename = $tmp_working_dir."/".$org_filename.".zip";
		$fd = fopen ($z_filename, "wb");
		$out = fwrite ($fd, $zipTest -> file());
		fclose ($fd);
		
		/* xfer to server */
		$ssh = new SSH();
		$ssh->connect($run_at['hostname'], $run_at['username'], $run_at['password'], $port = 22);

		$ssh->makeDirectory($run_at['working_dir']."/", $s_dir);
		$remote_cwd = $run_at['working_dir']."/".$s_dir."/";

		$ssh->remoteCopyFile($remote_cwd.$org_filename.".net", "<-", $tmp_working_dir."/".$org_filename.".net");
		$ssh->remoteCopyFile($remote_cwd.$org_filename.".general", "<-", $tmp_working_dir."/".$org_filename.".general");
		$ssh->remoteCopyFile($remote_cwd.$org_filename.".zip", "<-", $tmp_working_dir."/".$org_filename.".zip");
		$ssh->remoteCopyFile($remote_cwd."run.sh", "<-", $tmp_working_dir."/run.sh", 0777);
		
		/* delete temporary directory */
		$result = stristr(PHP_OS, "WIN") ? exec("echo Y | rd /s ".$tmp_working_dir) : exec("rm -rf ".$tmp_working_dir);		
		
		/* run script for downloading the input data from portal */
		sleep(0.5);
		$cmd = $remote_cwd."run.sh";
		$ssh->executeSH("cd ".$remote_cwd."; ".$cmd);

		/* copy back */
		if($type == "vis_file") {
			$tbl = "ds_input_water_level";
			$store_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Visualization/Water_Level/Transformed/";
		}else {
			$tbl = "ds_input_region";
			$store_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Visualization/Bathymetry_and_Topography_File/";
		}
      
		$tmp_zip_filename = $store_path.$org_filename.".tar.gz";
		#$ssh->remoteCopyFile($remote_cwd.$org_filename.".tar.gz", "->", $tmp_zip_filename);
		
		/* MOD for standalone */
		$file_remote = $remote_cwd.$org_filename.".tar.gz";
		$file_local = $tmp_zip_filename;
		
		if(file_exists($file_remote)) {
			copy($file_remote, $file_local);
		}else {
			die("! remote file does not exists.");
		}	
		
		require_once('../../library/zlib-extractor.class.php');
		
		$ArchiveFilename = $tmp_zip_filename;
		$DestinationPath = $store_path;
		
		$tar = new TAR($ArchiveFilename, $DestinationPath);
		$tar->extractAll();	
		
		unlink($ArchiveFilename);
		$ssh->executeSH("rm -rf ".$run_at['working_dir']."/".$s_dir);
		
		$sql = "SHOW TABLE STATUS FROM `".$db['db_name']."` LIKE '".$tbl."';";
		$res = mysql_query($sql, $db_link) or die("! could not query for getting last ID.");
		if(mysql_num_rows($res) > 0) {
			$obj = mysql_fetch_object($res);
			mysql_free_result($res);
		}
		$ref_id = ($obj->Auto_increment)-1;
		
		if($type == "region") {
			$sql = "INSERT INTO `ds_dx_region`(`reg_id`, `filename`, `path`, `no_of_grids_x`, `no_of_grids_y`, `data_order`, `region_no`, `grp_id`, `create_date`) ";
			$sql .= "VALUES(".$ref_id.", '".$org_filename.".dx', '".base64_encode($store_path.$org_filename.".dx")."', ".$no_of_grids_x.", ".$no_of_grids_y.", 'column', '".strtoupper($region_no)."', ".$grp_id.", '".time()."')";
		} else {
			$sql = "INSERT INTO `ds_dx_water_level`(`wl_id`, `filename`, `path`, `series`, `timestep`, `no_of_grids_x`, `no_of_grids_y`, `data_order`, `type`, `region_no`, `grp_id`, `create_date`) ";
			$sql .= "VALUES(".$ref_id.", '".$org_filename.".dx', '".base64_encode($store_path.$org_filename.".dx")."', 'no', ".$timestep.", ".$no_of_grids_x.", ".$no_of_grids_y.", 'column', '".strtoupper($vis_type)."', '".strtoupper($region_no)."', ".$grp_id.", '".time()."')";
		}
		mysql_query($sql, $db_link) or die('! insert dx failed.');
		
		exec("rm -rf ".$tmp_working_dir);
	}
		
	
	function fn_save_info($grp_id, $param, $db_link) {
		//print_r($param);
		//require_once("../../library/connectdb.inc.php");
		if(is_resource($db_link)){
			if($param['input_type'] == "sim" && $param['data_type'] == "region") {
				$table_name = "ds_input_region";
				if(fn_check_dup($table_name, "name", $param['new_filename'], $db_link) == true) {
					$sql = "INSERT INTO `".$table_name."`(`describe`, `name`, `region_no`, ";
					$sql .= "`lat_from_degree`, `lat_from_lipda`, `lat_from_Philipda`, `lat_to_degree` , ";
					$sql .= "`lat_to_lipda`, `lat_to_Philipda`, `long_from_degree`, `long_from_lipda`, ";
					$sql .= "`long_from_Philipda`, `long_to_degree`, `long_to_lipda`, `long_to_Philipda`, ";
					$sql .= "`interval`, `no_of_grids_x`, `no_of_grids_y`, `depth`, ";
					$sql .= "`res_lipda`, `res_Philipda`, `input_type`, `path`, ";
					$sql .= "`grp_id`, `default`, `datetime` ) ";
					if($param['region']['default'] == "on") {
						$sql_x = "UPDATE `".$table_name."` SET `default` = 'no' WHERE `grp_id` = ".$grp_id.";";
						mysql_query($sql_x, $db_link);
					}
					$sql .= "VALUES('".$param['description']."', '".$param['new_filename'].".dat', '".strtoupper($param['region']['no'])."', ";
					$sql .= "'".$param['region']['lat_from_degree']."', '".$param['region']['lat_from_lipda']."', '".$param['region']['lat_from_Philipda']."', ";
					$sql .= "'".$param['region']['lat_to_degree']."', '".$param['region']['lat_to_lipda']."', '".$param['region']['lat_to_Philipda']."', ";
					$sql .= "'".$param['region']['long_from_degree']."', '".$param['region']['long_from_lipda']."', '".$param['region']['long_from_Philipda']."', ";
					$sql .= "'".$param['region']['long_to_degree']."', '".$param['region']['long_to_lipda']."', '".$param['region']['long_to_Philipda']."', ";
					$sql .= "'".$param['region']['interval']."', '".$param['region']['no_of_grids_x']."', '".$param['region']['no_of_grids_y']."', ";
					$sql .= "'".$param['region']['max_of_depth']."', '".$param['region']['res_lipda']."', '".$param['region']['res_Philipda']."', '".$param['input_type']."', '".base64_encode($param['store_path'])."', ".$grp_id.", '".($param['region']['default'] == "on" ? "yes":"no")."', '".time()."')";
					mysql_query($sql, $db_link);
					return true;
				}else {
					echo "<script language=javascript>alert('! duplicate file name');</script>";
					return false;
				}
			}
			
			if($param['input_type'] == "vis" && $param['data_type'] == "vis_file") {
				$table_name = "ds_input_water_level";
				if(fn_check_dup($table_name, "filename", $param['new_filename'], $db_link) == true) {
					$sql = "INSERT INTO `".$table_name."`(`filename`, `path`, `series`, ";
					$sql .= "`timestep`, `no_of_grids_x`, `no_of_grids_y`, ";
					$sql .= "`data_order`, `type`, `region_no`, `grp_id`, `create_date`) ";
					$sql .= "VALUES('".$param['new_filename'].".dat', '".base64_encode($param['store_path'])."', '".$param['wl']['series']."', ";
					$sql .= "'".$param['wl']['time_step']."', '".$param['wl']['no_of_grids_x']."', '".$param['wl']['no_of_grids_y']."', ";
					$sql .= "'".$param['wl']['data_order']."', '".strtoupper($param['wl']['type'])."', '".strtoupper($param['wl']['region_no'])."', ".$grp_id.", '".time()."')";
					mysql_query($sql, $db_link);
					return true;
				}else {
					echo "<script language=javascript>alert('! duplicate file name');</script>";
					return false;
				}
			}
		}
	}
	
	function fn_check_dup($table_name, $key_name, $key_compare, $db_link) {
		if(is_resource($db_link)){
			$sql = "SELECT * FROM `".$table_name."` WHERE `".$key_name."` LIKE '".$key_compare.".dat'";
			$result = mysql_query($sql, $db_link);
			return ((mysql_num_rows($result) > 0) ? false : true);
		}
	}
	
?>
