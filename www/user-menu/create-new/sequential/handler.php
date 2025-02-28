<?php
	session_start();
	require_once('../../../library/connectdb.inc.php'); 
	
	/*
		echo "<pre>";
		print_r($_POST);
		print_r($_SESSION);
		echo "</pre>";
		exit;
	*/
	
	/* start transaction control */
	mysql_query("START TRANSACTION") or die("! could not start transaction");
	
	if(isset($_POST)) {
		$http_post_var = $_SESSION['data'];
		
		/* formulate parameters as a serializeed-string */
		$timestep = 0;
		$no_of_region = 0;
		$f = job_config::formulate($http_post_var, &$timestep, &$no_of_region);
				
		/* create simulation profile that stored in db and created on specified dir */
		$stored_dirpath = "";
		$sim_profile_id = job_config::insert_sim_profile_db($connection, addslashes($f), &$stored_dirpath);
		$stored_dirpath = addslashes($stored_dirpath);

		/* pre-result which inserted into db */
		$sim_result_id = job_config::insert_sim_result_db($connection, addslashes($f), $sim_profile_id);
		
		/* create job profile that used for monitoring */
		$job_profile_id = job_config::insert_job_profile($sim_result_id, $_SESSION['name'], $timestep, $no_of_region, $stored_dirpath, $connection);
	}
	/* commit above transaction */
	mysql_query("COMMIT") or die("! could not commit transaction");
	
	echo "<script language=javascript>document.location.href='../../tasks/jobstat.php?section=5&s=".$_SESSION['name']."';</script>";
	
	/* class of job configuration */
	class job_config {
	
		/* insert job profile into db */
		static function insert_job_profile($sim_result_id, $sim_name, $timestep, $no_of_region, $stored_dirpath, $db_link) {
			$sql = "INSERT INTO `job_profile`(`sim_result_id`, `name`, `local_store_path`, `status`, ";
			$sql .= "`timestep_now`, `total_timestep`, `no_of_region`, `create_date`, `run_date`, `finish_date`) ";
			$sql .= "VALUES(".$sim_result_id.", '".$sim_name."', '".$stored_dirpath."', 'pending', ";
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
				
				/* insert ob_point into db */
				foreach($_POST['point'] as $id => $value) {
					$sql_point_val = "INSERT INTO `sim_point_val` (`sim_result_id`, `id_point`, `values`, `type`) ";
					$sql_point_val .= "VALUES(".$sim_result_id.", ".$id.", 0, '')";
					sleep(0.002);
					mysql_query($sql_point_val, $db_link) or die("! could not insert point values.");
				}
				
				return $sim_result_id;
			}
		}
			
		/* insert preset* into database */
		static function insert_sim_profile_db($db_link, $data, $stored_dirpath) {
			global $_POST;
			global $_SESSION;
					
			if(is_resource($db_link)) {
				
				/* get default template of fortran code */
				$sql = "SELECT `var_id`, `template_file` FROM `seq_config_param` WHERE `default_param` = 'yes'";
				$res = mysql_query($sql, $db_link) or die("! could not select template.");
				if(mysql_num_rows($res) == 1){
					$obj = mysql_fetch_object($res);
					$id = $obj->var_id;
					$template_file = $obj->template_file;
				}
								
				/* for replacing the label */
				foreach($_SESSION['data']['val']['global'] as $parameter => $values){
					if(@preg_match("/\(/", $parameter)) {
						$t = str_replace("(", "_", $parameter);
						$t = str_replace(")", "", $t);
						$parameter = $t;
					}
					
					if(preg_match("/__".$parameter."__/", $template_file)) {
						$template_file = str_replace("__".$parameter."__", $values, $template_file);
					}
				}
				
				/* replace single dimension of fortran's array */
				foreach($_SESSION['data']['val']['input'] as $parameter => $values){
					if( substr($parameter, 0, 3) == "REG" || substr($parameter, 0, 3) == "DEF") {
						$input_dir = "input/";
					}else {
						$input_dir = "";
					}
					
					if(preg_match("/__".$parameter."__/", $template_file))
					$template_file = str_replace("__".$parameter."__", $input_dir.$values, $template_file);
				}
				
				/* replace two dimension of fortran's array */
				foreach($_SESSION['data']['val']['output'] as $parameter => $values){
					if(preg_match("/__".$parameter."__/", $template_file))
					$template_file = str_replace("__".$parameter."__", "output/".$values, $template_file);
				}
				
				/* specify folder that store the job-simulation dir */	
				$sim_folder = "../../".$_SESSION['vis-path']."/files/simulation";
			
				/* create destination dir */
				if(is_dir($sim_folder)){
				
					/* main job */
					mkdir($sim_folder."/".$_SESSION['name']) or die("! could not create main job dir.<br>");
					
					$stored_dirpath = realpath($sim_folder."/".$_SESSION['name']);
					
					/* input */
					mkdir($sim_folder."/".$_SESSION['name']."/input") or die("! could not create input dir of this job.<br>");;
					
					/* output */
					mkdir($sim_folder."/".$_SESSION['name']."/output") or die("! could not create output dir of this job.<br>");
					
					/* create shell-script to run the job */
					$remote_host_working_dir = "/home/yod/simulation";
					$run_sh_location = "../../../Templates/simulation/run.sh";
					$run_sh_contents = file_get_contents($run_sh_location);
					$run_sh_contents = str_replace("__WORKINGDIR__", $remote_host_working_dir, $run_sh_contents);
					$run_sh_contents = str_replace("__FORNAME__", $_SESSION['name'].".for", $run_sh_contents);		
					file_put_contents($stored_dirpath."/run.sh", $run_sh_contents) or die("! could not create `shell-script`.");
					
					/* visualization */
					mkdir($stored_dirpath."/visualization") or die("! could not create `visualization directory`.");
					
					/* create fortran name */
					$file = $sim_folder."/".$_SESSION['name']."/".$_SESSION['name'].".for";
					file_put_contents($file, $template_file);
				}else{
					echo "file=".__FILE__.", ".__LINE__."something wrong";
					exit;
				}
				
				/* get input's filename from buffer */
				$f = 0;
				foreach($_SESSION['data']['val']['input'] as $file_name) {
					$fn[$f++] = $file_name;
				}
				
				$c = count($_SESSION['data']['val']['input']);
				for($a=0; $a<$c; $a++) {
						$fname_def[] = " `filename` LIKE '".$fn[$a]."' ";
						$fname_reg[] = " `name` LIKE '".$fn[$a]."' ";
				}
				
				/* create SQL for querying data from database */
				$sql_input_def = "SELECT * FROM `ds_input_deform` WHERE  ".implode(" OR ", $fname_def)." ";
				$sql_input_reg = "SELECT * FROM `ds_input_region` WHERE  ".implode(" OR ", $fname_reg)." ";
				
				/* select data from deformation and region table */
				$res_input_def = mysql_query($sql_input_def, $db_link) or die("! could not query for deformation file.");
				$res_input_reg = mysql_query($sql_input_reg, $db_link) or die("! could not query for bathymetry and topography file.");
				$fl_def = 0;				
				$fl_reg = 0;
				
				/* copy DEFORMATION from data source to simulation JOB */
				while($object = mysql_fetch_object($res_input_def)) {
					$path[$fl_def] = base64_decode($object->path);
					$file_input[$fl_def] = $object->filename;
					copy("../".$path[$fl_def], $sim_folder."/".$_SESSION['name']."/input/".$file_input[$fl_def]);
					$fl_def++;
				}
				
				/* copy REGION from data source to simulation JOB */
				while($object_reg = mysql_fetch_object($res_input_reg)) {
					$path_reg[$fl_reg] = base64_decode($object_reg->path);
					$file_input_reg[$fl_reg] = $object_reg->name;
					copy("../".$path_reg[$fl_reg], $sim_folder."/".$_SESSION['name']."/input/".$file_input_reg[$fl_reg]);
				}
				
				/* create SQL of a new simulation profile */
				$sql = "INSERT INTO `sim_profile`(`name`, `param_contents`, `datetime`, `uid`, `template_id`) ";
				$sql .= "VALUES('".$_SESSION['name']."', '".$data."', '".time()."', '".$_SESSION['uid']."', '".$id."')\n";
				
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
	}
		
?>
