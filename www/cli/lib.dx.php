<?php
	require_once('../library/connectdb.inc.php');

	$root_path = "D:/Project_TSUNAMI/wwwroot/v8/cli/Thai_Guft";
	$case_list = array("9025001", "8525002", "8525003", "8525004", "8525005", "8505006");
	
	$region1 = "region1_TG.dat";
	$region2 = "region2_TG.dat";
	
	$region_copy_path = "D:/Project_TSUNAMI/wwwroot/v8/workspace/pemjit/files/Data_Source/Simulation/Bathymetry_and_Topography_File";
	
	copy($root_path."/".$region1, $region_copy_path."/".$region1) or die("! Could not move region1 file.");
	copy($root_path."/".$region2, $region_copy_path."/".$region2) or die("! Could not move region2 file.");

	/**
	 * set up parameters
	 */

	$grp_id = 1;
	
	/**
	 * vis_file, region
	 */
	$type = "region";
	
	/* path for .dat */
	if($type == "region") {
		$DAT_path = "../workspace/ndwc/files/Data_Source/Simulation/Bathymetry_and_Topography_File";
		$DX_path = "../workspace/ndwc/files/Data_Source/Visualization/Bathymetry_and_Topography_File";
	}
	if($type == "vis_file") {
		$DAT_path = "../workspace/ndwc/files/Data_Source/Visualization/Water_Level/Original";
		$DX_path = "../workspace/ndwc/files/Data_Source/Visualization/Water_Level/Transformed";		
	}
	
	$org_filename = str_replace(".dat", "", $region1);
	
	/* number of grids */
	$no_of_grid_x = 721;
	$no_of_grid_y = 661;
	
	$region_no = 1;
	
	$db_link = $connection;
	
	$vis_type = array("ETA", "Z_MAX");
	
	$timestep = 0;
	
	/* convert to .dx */
	convert_to_dx($grp_id, $type, $root_path, $org_filename, $no_of_grid_x, $no_of_grid_y, $region_no, $db_link, $vis_type, $timestep);
	
	if(!file_exists($DAT_path.$org_filename.".dat")) {
		echo "! Error.";
	}
	
	if(!file_exists($DX_path.$org_filename.".dx")) {
		echo "! Error.";
	}	
	
	
	foreach($case_list as $case_name) {
		
		/**
		 * set up parameters
		 */
	
		$grp_id = 1;
		
		/**
		 * vis_file, region
		 */
		$type = "vis_file";
		
		/* path for .dat */
		if($type == "region") {
			$DAT_path = "../workspace/ndwc/files/Data_Source/Simulation/Bathymetry_and_Topography_File/";
			$DX_path = "../workspace/ndwc/files/Data_Source/Visualization/Bathymetry_and_Topography_File/";
		}
		if($type == "vis_file") {
			$DAT_path = "../workspace/ndwc/files/Data_Source/Visualization/Water_Level/Original/";
			$DX_path = "../workspace/ndwc/files/Data_Source/Visualization/Water_Level/Transformed/";		
		}
		
		$org_filename = "region1";
		
		/* number of grids */
		$no_of_grid_x = 721;
		$no_of_grid_y = 661;
		
		$region_no = 1;
		
		$db_link = $connection;
		
		$vis_type = array("ETA", "Z_MAX");
		
		$timestep = 0;
		
		/* convert to .dx */
		convert_to_dx($grp_id, $type, $DAT_path, $org_filename, $no_of_grid_x, $no_of_grid_y, $region_no, $db_link, $vis_type, $timestep);
		
		if(!file_exists($DAT_path.$org_filename.".dat")) {
			echo "! Error.";
		}
		
		if(!file_exists($DX_path.$org_filename.".dx")) {
			echo "! Error.";
		}
	}
	
	/**
	 * convert data file to dx format 
	 *
	 * @param unknown_type $grp_id
	 * @param unknown_type $type
	 * @param unknown_type $DAT_path
	 * @param unknown_type $org_filename
	 * @param unknown_type $no_of_grids_x
	 * @param unknown_type $no_of_grids_y
	 * @param unknown_type $region_no
	 * @param unknown_type $db_link
	 * @param unknown_type $vis_type
	 * @param unknown_type $timestep
	 */
	
	function convert_to_dx($grp_id, $type, $DAT_path, $org_filename, $no_of_grids_x, $no_of_grids_y, $region_no, $db_link, $vis_type=NULL, $timestep=NULL) {
	
		require_once("../library/setting.inc.php");
		require_once("../library/ssh.class.php");
		require_once('../library/zip.lib.php');
		
		$tmp_dir = "_tmp/";
	
		if(!is_dir($tmp_dir)) {
			mkdir($tmp_dir) or die("! [ERROR] : Could not create temp dir.");
		}
	
		$s_dir = time();
		$tmp_working_dir = $tmp_dir.$s_dir;
		mkdir($tmp_working_dir) or die("! [ERROR] : Could not create temp of working dir.");
		$tmp_working_dir = realpath($tmp_working_dir);
		
		$DX_network_file = file_get_contents($template['location']['network_file']);
		$DX_general_file = file_get_contents($template['location']['general_file']);
		$DX_run_file_contents = file_get_contents($template['location']['run_file']);
		
		/* 1) replace label in network file */
		$remote_filepath = $run_at['working_dir']."/".$s_dir;
		$DX_network_file = str_replace("GENERAL_FILEPATH", $remote_filepath."/".$org_filename.".general", $DX_network_file);
		$DX_network_file = str_replace("GENERAL_FILENAME", $org_filename.".general", $DX_network_file);
		$DX_network_file = str_replace("EXPORT_FILEPATH", $remote_filepath."/".$org_filename.".dx", $DX_network_file);
		
		$dx_network_file_contents = $DX_network_file;
		file_put_contents($tmp_working_dir."/".$org_filename.".net", $dx_network_file_contents);
		
		/* 2) replace label in general file */
		$DX_general_file = str_replace("__FILE_LOCATION__", $remote_filepath."/".$org_filename.".dat", $DX_general_file);
		$DX_general_file = str_replace("__NO_OF_GRIDS_X__", $no_of_grids_x, $DX_general_file);
		$DX_general_file = str_replace("__NO_OF_GRIDS_Y__", $no_of_grids_y, $DX_general_file);
		
		/* 3) replace label in run shell file */
		$DX_run_file_contents = str_replace("GENERAL_FILENAME", $org_filename, $DX_run_file_contents);
		
		$dx_general_file_contents = $DX_general_file;
		file_put_contents($tmp_working_dir."/".$org_filename.".general", $dx_general_file_contents);
		file_put_contents($tmp_working_dir."/run.sh", $DX_run_file_contents);
		
		/* zip data file */
		$zipTest = new zipfile();
		$org_path_to_file = $DAT_path."/".$org_filename.".dat";
		$zipTest->add_file($org_path_to_file, $org_filename.".dat");
		$z_filename = $tmp_working_dir."\/".$org_filename.".zip";
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
		$result = strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? exec("echo Y | rd /s ".$tmp_working_dir) : exec("rm -rf ".$tmp_working_dir);		
		
		/* run script for downloading the input data from portal */
		sleep(0.5);
		$cmd = $remote_cwd."run.sh";
		echo "t";
		exit;
		$ssh->executeSH("cd ".$remote_cwd.";".$cmd);
		
		/* copy back */
		if($type == "vis_file") {
			$tbl = "ds_input_water_level";
			$store_path = "../workspace/ndwc/files/Data_Source/Visualization/Water_Level/Transformed/";
		}else {
			$tbl = "ds_input_region";
			$store_path = "../workspace/ndwc/files/Data_Source/Visualization/Bathymetry_and_Topography_File/";
		}
		
		$tmp_zip_filename = $store_path.$org_filename.".tar.gz";
		$ssh->remoteCopyFile($remote_cwd.$org_filename.".tar.gz", "->", $tmp_zip_filename);
		
		require_once('../library/zlib-extractor.class.php');
		
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
	}

?>