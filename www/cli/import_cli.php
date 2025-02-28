<?php
	require_once('lib.convert.php');
	require_once('../library/connectdb.inc.php');
	require_once('job.class.php');
	require_once('class.timer.php');
	
	define("DEBUG", true);
	
	if(defined("DEBUG")) echo "<pre>";
	
	$_config[1]['no_of_grids_x'] = 690;
	$_config[1]['no_of_grids_y'] = 840;
	$_config[2]['no_of_grids_x'] = 689;
	$_config[2]['no_of_grids_y'] = 953;
	$_config['group_id'] = 1;

	$working_dir = "/home/ndwc/wwwroot/deploy-v2-cli/tsunami_cli/workspace/ndwc/";
	$runresult_path = "";
	
	/* check transformed region 1 file */
	$DX_region1_file = $working_dir."files/Data_Source/Visualization/Bathymetry_and_Topography_File/region1_ndwc.dx";
	file_exists($DX_region1_file) or die("! could not find region1.\n");
	
	/* check transformed region 2 file */
	$DX_region2_file = $working_dir."files/Data_Source/Visualization/Bathymetry_and_Topography_File/region2_ndwc.dx";
	file_exists($DX_region2_file) or die("! could not find region2.\n");
	
	/* path of water level data file*/
	$DAT_waterlevel_path = $working_dir."files/Data_Source/Visualization/Water_Level/Original";
	is_dir($DAT_waterlevel_path) or die("! no directory specified for the water level path.\n");
	
	/* path of water level tranformed file */
	$DX_waterlevel_path = $working_dir."files/Data_Source/Visualization/Water_Level/Transformed";
	is_dir($DX_waterlevel_path) or die("! no directory specified for the transformed water level path.\n");
	
	/* root of water level file path */
	//$root_path = "/home/ndwc/ndwc-data/tsunami_project/resources/Tsunami_NDWC/Run_Results";
	$root_path = "/home/ndwc/tdssdisk/Run_Results";
	is_dir($root_path) or die("! no directory specified for root path.\n");
	
	/* notation of magnitude and depth */
	$magnitude_depth = array("7510", "7530", "8010", "8030", "8510", "8530", "9010", "9030");
	
	/* suffix of water level file path */
	$path_suffix = "TG";
	
	/* case counter */
	$counter = 0;
	
	/* fetch the manitude */
	foreach ($magnitude_depth as $case_dir) {
		$case_domain = $case_dir;
		$fault[$case_domain] = getFault($root_path."/".$case_dir);
		$case_dir = $root_path."/".$case_dir."_".$path_suffix;
		$list = scandir($case_dir) or die("! could not scan ".$case_dir);
		unset($list[0]);
		unset($list[1]);
		foreach ($list as $index => $case_id) {
			$start = Timer::Now();
			$counter++;
			echo "! CASE ".$case_id."\n";
			$magnitude = ((integer)(substr($case_id, 0, 2)))/10;
			$depth = substr($case_id, 2, 2);
			$lat = trim($fault[$case_domain][$case_id]['lat']);
			$long = $fault[$case_domain][$case_id]['long'];
			echo "! magnitude = ".$magnitude.", depth = ".$depth.", lat = ".$lat.", long = ".$long."\n";
			$main_dir = $case_dir."/".$case_id."/";
			$DAT['ETA'][1] = $main_dir."eta1.out";
			$DAT['ETA'][2] = $main_dir."eta2.out";
			$DAT['Z_MAX'][1] = $main_dir."zm1.out";
			$DAT['Z_MAX'][2] = $main_dir."zm2.out";
			foreach ($DAT as $type => $elem) {
				foreach ($elem as $region_no => $DAT_path) {
					if($region_no) {
					
						/**
						 * VISUALIZATION SECTION (I)
						 **/
						$DX_waterlevel_path = "../workspace/ndwc/files/Data_Source/Visualization/Water_Level/Transformed/";
						$org_filename = $case_id."_R".$region_no."_".str_replace("_", "", $type);
						$file_full_path = $DX_waterlevel_path.$org_filename.".dx";
						if(file_exists($file_full_path)) {
							echo "> ".$org_filename."	(".$file_full_path.")	[YES]\n";
							
							if($type == "ETA") {
								$p3['eta_vis']['r'.$region_no]['filename'] = $org_filename.".dx";
								$p3['eta_vis']['r'.$region_no]['path'] = base64_encode($file_full_path);
							}else {
								$p3['zmax_vis']['r'.$region_no]['filename'] = $org_filename.".dx";
								$p3['zmax_vis']['r'.$region_no]['path'] = base64_encode($file_full_path);
							}
							
						}else {
							die("> ".$org_filename."	[NO]\n");
						}
						
						/**
						 * END of VISUALIZATION SECTION (I)
						 */
						
						
						/**
						 * 
						 * TRANSFORMATION SECTION
						 */
						$org_filename = $case_id."_R".$region_no."_".str_replace("_", "", $type);
						echo $org_filename." ".$_config[$region_no]['no_of_grids_x']."x".$_config[$region_no]['no_of_grids_y']." : ".$DAT_path."\n";
						copy($DAT_path, $DAT_waterlevel_path."/".$org_filename.".dat") or die("! Unable to copy org fil.");
						$DAT_store_path = $DAT_waterlevel_path."/".$org_filename.".dat";
						
						/**
						 * Save data file into database */
						 
						$table_name = "ds_input_water_level";
						$sql = "INSERT INTO `".$table_name."`(`filename`, `path`, `series`, ";
						$sql .= "`timestep`, `no_of_grids_x`, `no_of_grids_y`, ";
						$sql .= "`data_order`, `type`, `region_no`, `grp_id`, `create_date`) ";
						$sql .= "VALUES('".$org_filename.".dat', '".base64_encode($DAT_store_path)."', 'no', ";
						$sql .= "0, ".$_config[$region_no]['no_of_grids_x'].", ".$_config[$region_no]['no_of_grids_y'].", ";
						$sql .= "'column', '".$type."', ".$region_no.", ".$_config['group_id'].", '".time()."')";
						mysql_query($sql, $connection) or die("! ".mysql_error($connection));
						
						
						convert_to_dx(
							$_config['group_id'], 
							"vis_file", 
							$DAT_path, 
							$org_filename, 
							$_config[$region_no]['no_of_grids_x'], 
							$_config[$region_no]['no_of_grids_y'], 
							$region_no, 
							$connection,
							$type,
							0
						);
						
						/**
						 * END of TRANSFORMATION SECTION
						 */
					}
				}
			}
			
			/**
			 *
			 * VISUALIZATION SECTION (II)
			 *
			 */
			
			/**
			 * create earthquake information for each cases
			 */
			$p1['name'] = $case_id;
			$p1['magnitude'] = $magnitude;
			$p1['depth'] = $depth;
			$p1['decimal_lat'] = $lat;
			$p1['decimal_long'] = $long;
			$p1['reg_dis_1']['filename'] = "region1_ndwc.dx";
			$p1['reg_dis_1']['path'] = base64_encode($DX_region1_file);
			$p1['reg_dis_2']['filename'] = "region2_ndwc.dx";
			$p1['reg_dis_2']['path'] = base64_encode($DX_region2_file);
			
			$p2 = select_ob_point($connection);
			
			#print_r($p1);
			#print_r($p2);
			#print_r($p3);
			
			/**
			 * SUBPART-(1)
			 */
			
				/* count region */
				$no_of_regions = 0;
				for($i=1; $i<=4; $i++) {
					if(isset($p1['reg_dis_'.$i]))
						$no_of_regions++;
				}
				
				if($no_of_regions == 0)
					die("! error not specified region.");
				 
				 
				/* create simulation profile that stored in db and created on specified dir */
				$sim_name = $p1['name'];
				$stored_dirpath = "";
				$ext = array();
				foreach($p2['select_point_id'] as $pid => $status) {
					$ext[] = "`observ_point_id` = ".$pid;
				}
				
				$sql = "SELECT * FROM `observe_point` WHERE `grp_id` = ".$_config['group_id']." AND ".implode(" OR ", $ext);
				$res = mysql_query($sql, $connection);
				$ob_points = array();
				if(mysql_num_rows($res) > 0) {
					$i = 0;
					while ($obj = mysql_fetch_object($res)) {
						$ob_points[$i]['id'] = $obj->observ_point_id;
						$ob_points[$i]['name'] = $obj->label;
						$ob_points[$i]['lat_degree'] = $obj->lat_1;
						$ob_points[$i]['lat_lipda'] = $obj->lat_2;
						$ob_points[$i]['lat_philipda'] = $obj->lat_3;
						$ob_points[$i]['long_degree'] = $obj->long_1;
						$ob_points[$i]['long_lipda'] = $obj->long_2;
						$ob_points[$i++]['long_philipda'] = $obj->long_3;
					}
				}
				
				/* insert profile */
				$return_point_values = array();
				$sim_profile_id = job_config::insert_sim_profile($_config['group_id'], $connection, $stored_dirpath, $sim_name, $p1, $p3, $ob_points, $return_point_values);
				
				/* assign to new var for ob point */
				$point_value = $return_point_values;
				
				$stored_dirpath = addslashes($stored_dirpath);
		
				/* insert the job profile */
				$job_profile_id = job_config::insert_job_profile($_config['group_id'], $sim_profile_id, $sim_name, 0, $no_of_regions, $stored_dirpath, $connection);
				
				/* insert info of result */
				$sql = "INSERT INTO `sim_result`(`id`, `job_profile_id`, `uid` , `name`, ";
				$sql .= "`desc`, `magnitude`, `depth`, ";
				$sql .= "`decimal_lat`, `decimal_long`, ";		
				$sql .= "`reg_1_filename`, `reg_2_filename` , `reg_3_filename`, ";
				$sql .= "`reg_4_filename`, `sim_type`, `grp_id`, `datetime`) ";
				$sql .= "VALUES(NULL, ".$job_profile_id.", 3, '".addslashes($p1['name'])."', ";
				$sql .= "'".addslashes($p1['description'])."', '".$p1['magnitude']."', '".$p1['depth']."', ";
				$sql .= "'".$p1['decimal_lat']."', '".$p1['decimal_long']."', ";	
				$sql .= "'".$p1['reg_dis_1']['filename']."', '".$p1['reg_dis_2']['filename']."', '".$p1['reg_dis_3']['filename']."', ";
				$sql .= "'".$p1['reg_dis_4']['filename']."', 'sequential', ".$_config['group_id'].", '".time()."');";
				mysql_query("START TRANSACTION", $connection) or die("! could not start transaction.");
				mysql_query($sql, $connection) or die("! Could not insert `sim_result`. \n! ".$sql."\n! mysql_errno(".$connection.").:".mysql_error($connection)."\n<a href='javascript: void()' onclick='javascript: history.back()'>back</a>");
				
				$rid = fn_get_last_auto_increment_id("sim_result")-1;
				
				/* process the ob point's value */
				$point_id = array();
				foreach($p2['select_point_id'] as $id => $status) {
					$point_id[] = $id;
				}
				
				$point_label = array();
				foreach($p2['select_point_label'] as $label => $e) {
					$point_label[] = $label;
				}
				
				$i = 0;
				foreach($point_value as $region => $v) {
					foreach($v as $type => $pv) {
						foreach($p2['select_point_label'] as $label => $v2) {
							if($type == ETA)
								$type = "ETA";
								
							if($type == HEIGHT)
								$type = "ZMAX";
							
							$sql = "INSERT INTO `sim_point_val`(`id`, `sim_result_id`, `id_point`, `values`, `type`, `region_no`) ";
							$sql .= "VALUES(NULL, ".$rid.", ".$point_id[$i++].", ".(float)(trim($pv[$label])).", '".$type."', '".$region."');";
							mysql_query($sql, $connection) or die("! Could not insert `sim_point_val`.");
						}
						$i=0;
					}
				}
				
				/* insert a list of visualization's file */	
				foreach($p3 as $t => $elem) {
					if($t == "eta_vis" || $t == "zmax_vis") {
						$tt = ($t == "eta_vis") ? "ETA" : "ZMAX";
						foreach($elem as $r_name => $value) {
							$sql = "INSERT INTO `sim_visfile`(`id`, `id_sim_result`, `level`, `vis_filename`, `type`, `create_date`) ";
							$sql .= "VALUES(NULL, ".$rid.", '".strtoupper($r_name)."', '".$p3[$t][$r_name]['filename']."', '".$tt."', '".time()."');";
							mysql_query($sql, $connection) or die("! Could not insert `sim_visfile`. \n! ".$sql."\n! mysql_errno(".$connection.").:".mysql_error($connection)."\n<a href='javascript: void()' onclick='javascript: history.back()'>back</a>");
							sleep(0.2);
						}
					}
				}	
				
				/* commit transaction */
				mysql_query("COMMIT", $connection);
					
				/* run visualization on remoted address */
				$_SESSION['vis_path'] = $stored_dirpath;
				$_SESSION['vis_name'] = $sim_name;
				/*echo "<script language=javascript>document.location.href='vis_runner.php?grp_id=".$_REQUEST['grp_id']."';</script>";*/
			
			/**
			 * END of SUBPART-(1)
			 */
			
			
			/**
			 * SUBPART-(2)
			 */
			
				$vis_local_path = $_SESSION['vis_path'];
				$vis_filelist = $_SESSION['vis_filelist'];
				$vis_network_pathfile = $_SESSION['network_pathfile'];
				$vis_type = $_SESSION['vis_type'];
				$dir_image = $_SESSION['dir_image'];
				
				$s_dir = time();
				$local_temp_dirname = "_tmp/".$s_dir;
				mkdir($local_temp_dirname) or die("! death on ".__LINE__."->".__FILE__);
				
				/* zip data file */
				$cl = array();	
				$local_zip_list = array();
				$remote_zip_list = array();
				
				foreach($vis_filelist as $index => $path_to_filename) {
					$z = new zipfile();
					$n = explode("/", $path_to_filename);
					$z->add_file($path_to_filename, $n[count($n)-1]);
					$n_t = explode(".", $n[count($n)-1]);
					$z_filename = $local_temp_dirname."/".$n_t[0].".zip";
					$local_zip_list[] = $z_filename;
					$remote_zip_list[] = $n_t[0].".zip";
					$cl[] = $z_filename;
					$fd = fopen ($z_filename, "wb");
					$out = fwrite ($fd, $z->file());
					fclose ($fd);
					sleep(0.1);
				}
				
				/* copy .net */
				$network_filelist = array();
				foreach($vis_network_pathfile as $index => $path_to_file) {
					$n = explode("/", $path_to_file);
					copy($path_to_file, $local_temp_dirname."/".$n[count($n)-1]);
					$netfile[$n[count($n)-1]] = $local_temp_dirname."/".$n[count($n)-1];
					$network_filelist[] = $n[count($n)-1];
				}
			
				/* xfer to server */
				if(isset($ssh)) unset($ssh);
				
				$ssh = new SSH();
				$ssh->connect($run_at['hostname'], $run_at['username'], $run_at['password'], $port = 22);
				
				/* making the directory of workspace */
				$ssh->makeDirectory($run_at['working_dir']."/", $s_dir);
			
				/* make directory of images's storage */
				foreach($dir_image as $index => $dir_name) {
					$dir = $run_at['working_dir']."/".$s_dir."/".$dir_name;
					$ssh->makeDirectory($dir);
				}
				
				$remote_cwd = $run_at['working_dir']."/".$s_dir."/";
			
				/* copy of data.zip files to remote workspace */
				foreach($local_zip_list as $index => $local_filename) {
					$ssh->remoteCopyFile($remote_cwd.$remote_zip_list[$index], "<-", $local_filename);
				}
				
				/* copy networks of modules to remote workspace */
				foreach($netfile as $filename => $localpath_filename) {
					$ssh->remoteCopyFile($remote_cwd.$filename, "<-", $localpath_filename);
				}
				
				/* create shellscript of running the visualization */
				#$p1 = $_SESSION['import'][1];
				#$p3 = $_SESSION['import'][3];	
				if(!file_exists($template['sh_script'])) {
					die("! could not locate run script.");
				} else {
					
					$unzip_str = "";
					$net_str = "";
				
					$SH_template_contents = file_get_contents($template['sh_script']);
					foreach($remote_zip_list as $index => $zip_filename) {
						$unzip_str .= "unzip ".$zip_filename."\n";
					}
					$SH_template_contents = str_replace("UNZIP_ALLFILES", $unzip_str, $SH_template_contents);
					
					foreach($network_filelist as $index => $net_filename) {
						$net_str .= "dx -memory 1024 -script ".$net_filename."\n";
					}
					$SH_template_contents = str_replace("RUN_DX", $net_str, $SH_template_contents);
					
					$i = 0;
					foreach($dir_image as $index => $dir_name) {
						$img_str[$i] = "for i in `ls ".$dir_name."/`\n";
						$img_str[$i] .= "do\n";
						$img_str[$i] .= "\tconvert ".$dir_name."/\$i -trim ".$dir_name."/\$i.png\n";
						$img_str[$i] .= "done\n";
						$img_str[$i++] .= "rm -rf ".$dir_name."/*.tiff\n\n";
					}
					$SH_template_contents = str_replace("IMAGE_OPERATIONS", implode("", $img_str), $SH_template_contents);		
				}
				
				file_put_contents($local_temp_dirname."/run.sh", $SH_template_contents);
				
				/* copy shellscript to remote workspace */
				$ssh->remoteCopyFile($remote_cwd."run.sh", "<-", $local_temp_dirname."/run.sh", 0777);
				
				/* delete temporary directory */
				if(strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
					exec("echo Y | rd /s ".$local_temp_dirname);
				else
					exec("rm -rf ".$local_temp_dirname);		
				
				/* run script for downloading the input data from portal */
				sleep(0.5);
				$cmd = $remote_cwd."run.sh";
				$ssh->executeSH("cd ".$remote_cwd.";".$cmd);
			
				/* copy back */
				$img_path = realpath($vis_local_path."/visualization");
				$img_pathfile = $img_path."/image.tar.gz";
				$remote_file = $remote_cwd."image.tar.gz";
				#$ssh->remoteCopyFile($remote_cwd."image.tar.gz", "->", $img_pathfile);
				
				/* Mod for standalone */
				if(file_exists($remote_file)) {
					copy($remote_file, $img_pathfile);
				}else {
					die("! No images output.");
				}
				
				require_once('../library/zlib-extractor.class.php');
				$ArchiveFilename = $img_pathfile;
				$DestinationPath = $img_path;
			
				$tar = new TAR($ArchiveFilename, $DestinationPath);
				$tar->extractAll();	
				
				unlink($ArchiveFilename);
				$ssh->executeSH("rm -rf ".$run_at['working_dir']."/".$s_dir);
			
			/**
			 * END of SUBPART-(2)
			 */
			
			$end = Timer::Now();
			$collect = ($end-$start) + $collect;
			echo "! time = ".($end-$start)." seconds.\n\n";
			
			#if($case_id == "7510010") break;
						/**
			 *
			 *  END of VISUALIZATION SECTION (II)
			 *
			 */

		}
	}
	
	echo "\n\n! Total = ".$counter.", time average = ".($collect/$counter)."\n";
	
	if(defined("DEBUG")) echo "</pre>";
	
	function getFault($case_domain) {
		$fp = fopen($case_domain."_fault.csv", "r") or die("! could not get fault information for ".$case_domain.".\n");
		while ($line = fgets($fp, 64)) {
			$c = explode(",", $line);
			$case[$c[0]]['long'] = $c[1];
			$case[$c[0]]['lat'] = $c[2];
		}
		return $case;
	}

	function select_ob_point($db_link) {
		$sql = "SELECT `observ_point_id`, `label` FROM `observe_point` WHERE `grp_id` = 1";
		$result = mysql_query($sql, $db_link);
		if(mysql_num_rows($result) > 0) {
			while($obj = mysql_fetch_object($result)) {
				$r['select_point_id'][$obj->observ_point_id] = "on";
				$r['select_point_label'][$obj->label] = '';
			}
		}
		mysql_free_result($result);
		return $r;
	}
?>
