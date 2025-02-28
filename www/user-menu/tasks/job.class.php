<?php
	session_start();
	set_time_limit(0);
	
	/* class of job configuration */
	class job_config {
	
		/* insert job profile into db */
		static function insert_job_profile($grp_id, $sim_result_id, $sim_name, $timestep, $no_of_region, $stored_dirpath, $db_link) 		{
			$sql = "INSERT INTO `job_profile`(`sim_profile_id`, `local_store_path`, `status`, ";
			$sql .= "`timestep_now`, `total_timestep`, `no_of_region`, `create_date`, `run_date`, `finish_date`) ";
			$sql .= "VALUES(".$sim_result_id.", '".$stored_dirpath."', 'finished', ";
			$sql .= "0, ".$timestep.", ".$no_of_region.", '".time()."', '', '');";
			mysql_query($sql, $db_link) or die("! could not create job profile.");
			return (fn_get_last_auto_increment_id("job_profile")-1);
		}
	
		/* insert simulation information into database */
		static function insert_sim_result_db ($db_link, $data, $job_profile_id) {
			global $_POST;
			global $_SESSION;
			
			$point = array();
			$point = $_POST['point'];
			$str = serialize($point);
			$time = time();
			if(is_resource($db_link)) {
			
				$d = $_SESSION['data']['val']['input'];
				$reg_no = 1;
				foreach($d as $var_name => $filename) {
					if(substr($var_name, 0, 3) == "REG") {
						$region[$reg_no++] = $filename;
					}
				}
				$sql_sim_result = "INSERT INTO `sim_result`(`job_profile_id`, `uid`, `name`, `domain`, ";
				$sql_sim_result .= "`source`, `ob_area`, `desc`, `magnitude`, `depth`, ";
				$sql_sim_result .= "`lat_degree`, `lat_lipda`, `lat_Philipda`, ";
				$sql_sim_result .= "`long_degree`, `long_lipda`, `long_Philipda`, ";
				$sql_sim_result .= "`reg_1_filename`, `reg_2_filename`, ";
				$sql_sim_result .= "`reg_3_filename`, `reg_4_filename`, `sim_type`, `datetime`) ";
				
				$sql_sim_result .= "VALUES(".$job_profile_id.", '".$_SESSION['uid']."', '".$_SESSION['name']."', '".$_SESSION['domain']."', ";
				$sql_sim_result .= "'".$_SESSION['source']."', '".$_SESSION['observ_area']."', '".$_SESSION['description']."', '".$_SESSION['magnitude']."', ".$_SESSION['depth'].", ";
				$sql_sim_result .= "'".$_SESSION['lat_degree']."','".$_SESSION['lat_lipda']."', '".$_SESSION['lat_Philipda']."', ";
				$sql_sim_result .= "'".$_SESSION['long_degree']."', '".$_SESSION['long_lipda']."', '".$_SESSION['long_Philipda']."', ";
				$sql_sim_result .= "'".$region[1]."', '".$region[2]."', ";
				$sql_sim_result .= "'".$region[3]."', '".$region[4]."', '".$_SESSION['sim_type']."', '".time()."')";		
				
				mysql_query($sql_sim_result, $db_link) or die("! could not info into sim_result.");
				$sim_result_id = (fn_get_last_auto_increment_id("sim_result")-1);
								
				return $sim_result_id;
			}
		}
			
		/* insert preset* into database */
		static function insert_sim_profile($grp_id, $db_link, & $stored_dirpath, $sim_name, $p1, $p3, $ob_points, & $ret_point_values) {
			global $_SESSION;
			
			/* check db's link */
			if(is_resource($db_link)) {

				/* specify folder that store the job-simulation dir */	
				$sim_folder = "../../workspace/".$_SESSION['username']."/files/Simulation";

				/* create destination dir */
				if(is_dir($sim_folder)){

					/* main job */
					mkdir($sim_folder."/".$sim_name) or die("! could not create main job dir.<br>");

					$stored_dirpath = $sim_folder."/".$sim_name;

					/* input */
					$input_path = $sim_folder."/".$sim_name."/input";
					mkdir($input_path) or die("! could not create input dir of this job.<br>");
					
					/* copy .dat files to ./input */
					/*$input_list_var = array("reg_dis_1", "reg_dis_2", "reg_dis_3", "reg_dis_4");
					foreach($input_list as $index => $var_slot) {
						if(is_array($p1[$var_slot])) {
							copy(base64_decode($p1[$var_slot]['path']), $input_path."/".$p1[$var_slot]['filename']);
						}
					}*/

					/* output */
					/* store .out files */
					$output_path = $sim_folder."/".$sim_name."/output";
					mkdir($output_path) or die("! could not create output dir of this job.<br>");
					
					/* copy .out files to ./output */
					/*foreach($p3 as $type => $region_r) {
						switch($type) {
							case "eta_vis":
							case "zmax_vis":
								foreach($region_r as $r_no => $contents_r) {
									$sql = "SELECT 
												`ds_dx_water_level`.`id` AS `DS_DXID`, 
												`ds_dx_water_level`.`filename` AS `DS_DXFILENAME`, 
												`ds_dx_water_level`.`path` AS `DS_DXPATH`, 
												`ds_input_water_level`.`filename` AS `DS_FILENAME`,
												`ds_input_water_level`.`path` AS `DS_PATH`
											FROM
												`ds_dx_water_level`, `ds_input_water_level`
											WHERE
												`ds_dx_water_level`.`wl_id` = `ds_input_water_level`.`id` AND 
												`ds_dx_water_level`.`filename` LIKE '".$contents_r['filename']."'";
									$res = mysql_query($sql, $db_link) or die("! failed on ".__LINE__." of ".__FILE__);
									if(mysql_num_rows($res) == 1) {
										$obj = mysql_fetch_object($res);
										$out_path = base64_decode($obj->DS_PATH);
										copy(base64_decode($obj->DS_PATH), $output_path."/".$obj->DS_FILENAME);
									}else {
										die("! failed on ".__LINE__." of ".__FILE__);
									}
								}
								break;
						}
					}
					*/
					
					/* visualization */
					$vis_path = $stored_dirpath."/visualization";
					mkdir($vis_path) or die("! could not create `visualization directory`.");
					
					/* copy .dx of water-level to ./visualization */
					$_SESSION['vis_filelist'] = array();					
					foreach($p3 as $type => $region_r) {
						switch($type) {
							case "eta_vis":
							case "zmax_vis":
								foreach($region_r as $r_no => $contents_r) {
									$s = base64_decode($contents_r['path']);
									$d = $vis_path."/".$contents_r['filename'];
									if(file_exists($d)) {
										die("! duplicate DX's input files (water-level).");
									}else {
										copy($s, $d);
									}
									$_SESSION['vis_filelist'][] = $vis_path."/".$contents_r['filename'];
								}
								break;
						}
					}
					
					/* copy .dx of region to ./visualization */
					for($i=1; $i<=4; $i++) {
						if(isset($p1['reg_dis_'.$i])) {
							$path_to_file = base64_decode($p1['reg_dis_'.$i]['path']);
							if(file_exists($path_to_file)) {
								$s = $path_to_file;
								$d = $vis_path."/".$p1['reg_dis_'.$i]['filename'];
								if(file_exists($d)) {
									die("! duplicate DX's input files (bathymetry).");
								}else {
									copy($s, $d) or die("! death on ".__LINE__.":".__FILE__);
								}
								$_SESSION['vis_filelist'][] = $vis_path."/".$p1['reg_dis_'.$i]['filename'];
							}
						}
					}
					
					/* create eta and zmax's script */
					require_once('CreateNetworkVisFile.class.php');
										
					/* CREATE VISUALIZATION NETWORK OF MODULE */
					unset($p3['next']);
					$_SESSION['vis_type'] = array();
					$_SESSION['dir_image'] = array();
					foreach($p3 as $vis_type => $rc) {
						switch($vis_type) {
							case "eta_vis": $type = ETA; break;
							case "zmax_vis": $type = HEIGHT; break;
						}
						
						$_SESSION['vis_type'][] = $vis_type;
						
						foreach($rc as $reg_no_t => $file_info) {
							$region_no = $reg_no_t[1];
						
							$DX_region_filename = $p1['reg_dis_'.$region_no]['filename'];
							$DX_waterlevel_filename = $p3[$vis_type]['r'.$region_no]['filename'];
							
							/* 	__construct($network_file_type, $filename, $region_no, $display_type, $DX_region_filename, $DX_waterlevel_filename) */
							$cn = new BuildVisualizationNetwork($type, "(none)", $region_no, "3D", $DX_region_filename, $DX_waterlevel_filename, $grp_id);
							
							/* get location */
							$obj_reginfo = getRegionLocation($DX_region_filename, $db_link);

							/* AssignAutoAxesLatitude($Lat_1, $Lat_Lipda_1, $Lat_Philipda_1, $Lat_2, $Lat_Lipda_2, $Lip_Philipda_2) */
							$cn->AssignAutoAxesLatitude($obj_reginfo->lat_from_degree, $obj_reginfo->lat_from_lipda, 
										$obj_reginfo->lat_from_philipda, $obj_reginfo->lat_to_degree, 
										$obj_reginfo->lat_to_lipda, $obj_reginfo->lat_to_philipda);
							
							/* AssignAutoAxesLongitude($Long_1, $Long_Lipda_1, $Long_Philipda_1, $Long_2, $Long_Lipda_2, $Long_Philipda_2) */
							$cn->AssignAutoAxesLongitude($obj_reginfo->long_from_degree, $obj_reginfo->long_from_lipda, 
										$obj_reginfo->long_from_philipda, $obj_reginfo->long_to_degree, 
										$obj_reginfo->long_to_lipda, $obj_reginfo->long_to_philipda);
							
							/* AssignDXInput($dx_region_filepath, $dx_water_level_filepath) */
							$DX_region_filepath = $p1['reg_dis_'.$region_no]['filename'];					
							$DX_waterlevel_filepath = $p3[$vis_type]['r'.$region_no]['filename']; 							
							$cn->AssignDXInput($DX_region_filepath, $DX_waterlevel_filepath);
							
							/* AssignNoGrids($grids_x, $grids_y) */
							$no_of_grids_x = $obj_reginfo->no_of_grids_x;
							$no_of_grids_y = $obj_reginfo->no_of_grids_y;
							$cn->AssignNoGrids($no_of_grids_x, $no_of_grids_y);
							
							/* AssignPointInfo($point) */
							$cn->AssignPointInfo($ob_points);
							
							/* AssignRegionResolution($lipda, $philipda) */
							$cn->AssignRegionResolution($obj_reginfo->res_lipda, $obj_reginfo->res_philipda);
							 
							/* AssignWaterLevelData($wl_filepath) */
							$obj_wl_filepath = getWaterLevelInfo($DX_waterlevel_filename, $db_link);
							$OUT_waterlevel_filepath = base64_decode($obj_wl_filepath->path);
							$cn->AssignWaterLevelData($OUT_waterlevel_filepath);
							#echo $OUT_waterlevel_filepath."\n";
							$cn->CalculateALL();
							
							/* BuildNetwork($zoom, $resolution, $rotate_x, $rotate_y, $rotate_z, $contour_line) */
							$no_of_contour_line = ($region_no == 1 ? 10 : 20);
							$sec = ($region_no == 1 ? 3600 : 1800);
							for($c=1; $c<=$no_of_contour_line; $c++) {
								$contour_line_t[] = $sec*$c;
							}
							//$contour_line = "60 120 180 240 300 360 420 480 540 600 660 720";
							$contour_line = implode(" ", $contour_line_t);
							
							$no_of_contour_line_diff = ($region_no == 1 ? 10 : 20);
							$sec_diff = ($region_no == 1 ? 60 : 30);
							for($c_diff =1; $c_diff <=$no_of_contour_line_diff; $c_diff++) {
								$contour_line_t_diff[] = $sec_diff*$c_diff;
							}
							
							$contour_line2 = implode(" ", $contour_line_t_diff);
							
							/* Andaman */
							if($grp_id == 1) {
								$zoom_ratio = 1500;
								$resolution = 1900;
								if($region_no == 2){
									$axes_scale = 2.8;
								}else{
									$axes_scale = 1.5;
								}
							}else {
								/* Thai Gulf */
								$axes_scale = 1.0;
								$resolution = 2000;
								if($region_no == 2) {
									$resolution = 1500;
									if($type == HEIGHT) {
										$zoom_ratio = 3000;
									}else
										$zoom_ratio = 3200;
								}else {
									if($type == HEIGHT) {
										$zoom_ratio = 1300;
									}else
										$zoom_ratio = 1500;
								}
							}
							
							#$resolution = ($grp_id == 1) ? 1900 : 2000;
							
							$cn->BuildNetwork($zoom_ratio, $resolution, 180, 0, 0, $contour_line, $contour_line2, $axes_scale, $vis_type, $region_no);
							$networkfile_contents[$region_no][$type] = $cn->getNetworkFileContents();
							$pt[$region_no][$type] = $cn->getPointsTable();
						}
					}
				}else{
					echo "! file=".__FILE__.", ".__LINE__."something wrong";
					exit;
				}
				
				#print_r($pt);
				#exit;
				
				$_SESSION['network_pathfile'] = array();
				foreach($networkfile_contents as $region_no => $type) {
					foreach($type as $t_name => $contents) {
						switch($t_name) {
							case WAVE_ANIMATION:
								break;
							case VELOCITY:
								break;
							case DEPTH:
								break;
							case HEIGHT:
								$netfile = $vis_path."/height_r".$region_no.".net";
								if(file_exists($netfile)) 
									die("! something wrong, network file already exists (height).");
								file_put_contents($netfile, $networkfile_contents[$region_no][$t_name]);
								$_SESSION['network_pathfile'][] = $netfile;
								break;
							case ETA:
								$netfile = $vis_path."/eta_r".$region_no.".net";
								if(file_exists($netfile)) 
									die("! something wrong, network file already exists (eta).");								
								file_put_contents($netfile, $networkfile_contents[$region_no][$t_name]);
								$_SESSION['network_pathfile'][] = $netfile;
								break;
						}
					}
				}
				
				$ret_point_values = $pt;
				
				/* making the visualization output directory */
				mkdir($vis_path."/image") or die("! could not create visualization output directory.");
				
				/* create SQL of a new simulation profile */
				$sql = "INSERT INTO `sim_profile`(`id`, `template_id`, `param_contents`, `datetime`, `name`, `uid`) ";
				$sql .= "VALUES(NULL, NULL, NULL, '".time()."', '".$sim_name."', '".$_SESSION['uid']."')";
				
				/* insert new profile into `sim_profile` */
				mysql_query($sql, $db_link) or die("! could not create simulation profile");
				return (fn_get_last_auto_increment_id("sim_profile")-1);
			}
		}
		
		/* parameter serialization */
		/* formalating the parameter's form */
		static function formulate($var, $timestep, $no_of_region) {
			$var_section = array("des", "val");
			$var_type = array("global", "input", "output");
			$sep = "{0x0000}";
			$header = "var_section".$sep."var_type".$sep."var_name".$sep."var_value\n";			
			$var_str = "";
			$var_str .= $header;
			foreach($var_section as $s_name) {
				foreach($var_type as $type_name) {
					foreach($var[$s_name][$type_name] as $v_name => $value) {
						$var_str .= $s_name.$sep.$type_name.$sep.$v_name.$sep.$value."\n";
						if($s_name == "val") {
							if($v_name == "NT1")
								$timestep = $value;
							if(substr($v_name, 0, 3) == "REG") {
								$no_of_region += 1;
							}
						}
						
					}
				}
			}
			return $var_str;
		}
		
		static function insert_point_values($_post_points, $ret_cal_point, $sim_result_id, $db_link) {
			/* insert ob_point into db */
			foreach($post_points['point'] as $id => $value) {
				$sql_point_val = "INSERT INTO `sim_point_val` (`sim_result_id`, `id_point`, `values`, `type`) ";
				$sql_point_val .= "VALUES(".$sim_result_id.", ".$id.", 0, '')";
				sleep(0.002);
				mysql_query($sql_point_val, $db_link) or die("! could not insert point values.");
			}

		}
	}
?>

<?php
	function getRegionLocation($DX_region_filename, $db_link) {
		if(is_resource($db_link)) {
			$sql = "SELECT 
						`ds_input_region`.`name` , `ds_input_region`.`region_no` , `ds_input_region`.`lat_from_degree` , 
						`ds_input_region`.`lat_from_lipda` , `ds_input_region`.`lat_from_philipda` , 
						`ds_input_region`.`lat_to_degree` , `ds_input_region`.`lat_to_lipda` , 
						`ds_input_region`.`lat_to_philipda` , `ds_input_region`.`long_from_degree` , 
						`ds_input_region`.`long_from_lipda` , `ds_input_region`.`long_from_philipda` , 
						`ds_input_region`.`long_to_degree`, `ds_input_region`.`long_to_lipda`, `ds_input_region`.`long_to_philipda`,
						`ds_input_region`.`no_of_grids_x` , `ds_input_region`.`no_of_grids_y` , 
						`ds_input_region`.`res_lipda` , `ds_input_region`.`res_philipda`
					FROM `ds_input_region` , `ds_dx_region`
					WHERE `ds_dx_region`.`reg_id` = `ds_input_region`.`id`
					AND `ds_dx_region`.`filename` LIKE '".$DX_region_filename."';";
			$res = mysql_query($sql, $db_link) or die("! death on ".__LINE__.":".__FILE__);
			if(mysql_num_rows($res) == 1) {
				return mysql_fetch_object($res);
			}else die("! death on ".__LINE__.":".__FILE__);
		}else die("! death on ".__LINE__.":".__FILE__);
	}
	
	function getWaterLevelInfo($DX_waterlevel_filename, $db_link) {
		if(is_resource($db_link)) {
			$sql = "SELECT 
						`ds_input_water_level`.`id`, 
						`ds_input_water_level`.`filename`, 
						`ds_input_water_level`.`path` 
					FROM `ds_input_water_level`, `ds_dx_water_level` 
					WHERE `ds_input_water_level`.`id` = `ds_dx_water_level`.`wl_id` 
					AND `ds_dx_water_level`.`filename` LIKE '".$DX_waterlevel_filename."';";
			$res = mysql_query($sql, $db_link) or die("! death on ".__LINE__.":".__FILE__);
			if(mysql_num_rows($res) == 1) {
				return mysql_fetch_object($res);
			}else die("! death on ".__LINE__.":".__FILE__);
		}else die("! death on ".__LINE__.":".__FILE__);
	}
?>
