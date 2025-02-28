<?php
	session_start();
	
	/* add code for checking the existing job */
	
		
		require_once("../../library/connectdb.inc.php");
		require_once("../../library/setting.inc.php");
		require_once("../../library/ssh.class.php");
				
		$tmp_dir = "_tmp/";
		
		if(is_resource($connection) && $_REQUEST['type'] == "reg") {
			$sql = "SELECT * FROM `ds_input_region` WHERE `id` = ".$_REQUEST['data_id'];
			$res = mysql_query($sql, $connection) or die("! error ");
			if(mysql_num_rows($res) == 1) {
				$obj = mysql_fetch_object($res);
				$_t_name = explode(".", $obj->name);
				$dx['id'] = $obj->id;
				$dx['filename'] = $_t_name[0];
				$dx['path'] = "";
				$dx['no_of_grids_x'] = $obj->no_of_grids_x;
				$dx['no_of_grids_y'] = $obj->no_of_grids_y;
				$dx['data_order'] = "column";
				$_t_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Visualization/Bathymetry_and_Topography_file/";
				$_t_remote_download_url = "http://".$this_host['ip'].$this_host['working_dir'];
				$_t_remote_download_url .= "/user-menu/data-source/download_file.php?download_filepath=".$obj->path;
				
				if(!is_dir($tmp_dir)) {
					mkdir($tmp_dir) or die("! could not create temp dir.");
				}else {
					$s_dir = time();
					$filename = "file";
					$tmp_working_dir = $tmp_dir.$s_dir;
					mkdir($tmp_working_dir) or die("! could not create temp of time dir.");
					$tmp_working_dir = realpath($tmp_working_dir);
										
					$DX_network_file = file_get_contents($template['location']['network_file']);
					$DX_general_file = file_get_contents($template['location']['general_file']);
					$DX_wget_file = file_get_contents($template['location']['wget_file']);
					$DX_run_file = file_get_contents($template['location']['run_dx_file']);
					
					/* 1) replacing label in network file */
					$remote_filepath = $run_at['working_dir']."/".$s_dir;
					$DX_network_file = str_replace("GENERAL_FILEPATH", $remote_filepath."/".$filename.".general", $DX_network_file);
					$DX_network_file = str_replace("GENERAL_FILENAME", $filename.".general", $DX_network_file);
					$DX_network_file = str_replace("EXPORT_FILEPATH", $remote_filepath."/".$filename.".dx", $DX_network_file);

					$dx_network_file_contents = $DX_network_file;
					file_put_contents($tmp_working_dir."/".$filename.".net", $dx_network_file_contents);
									
					/* 2) replacing label in general file */
					$DX_general_file = str_replace("__FILE_LOCATION__", $remote_filepath."/".$filename.".dat", $DX_general_file);
					$DX_general_file = str_replace("__NO_OF_GRIDS_X__", $dx['no_of_grids_x'], $DX_general_file);
					$DX_general_file = str_replace("__NO_OF_GRIDS_Y__", $dx['no_of_grids_y'], $DX_general_file);
					
					$dx_general_file_contents = $DX_general_file;
					file_put_contents($tmp_working_dir."/".$filename.".general", $dx_general_file_contents);
					
					/* 3) replacing label in sh file */
					$DX_wget_file = str_replace("__FILENAME__", $remote_filepath."/".$filename.".dat", $DX_wget_file);
					$DX_wget_file = str_replace("__DOWNLOAD_FROM__", $_t_remote_download_url, $DX_wget_file);
					
					$dx_wget_file_contents = $DX_wget_file;
					file_put_contents($tmp_working_dir."/wget.sh", $dx_wget_file_contents);
									
					$ssh = new SSH();
					$ssh->connect($run_at['hostname'], $run_at['username'], $run_at['password'], $port = 22);

					$ssh->makeDirectory($run_at['working_dir']."/", $s_dir);
					$remote_cwd = $run_at['working_dir']."/".$s_dir."/";

					$ssh->remoteCopyFile($remote_cwd.$filename.".net", "<-", $tmp_working_dir."/".$filename.".net");
					$ssh->remoteCopyFile($remote_cwd.$filename.".general", "<-", $tmp_working_dir."/".$filename.".general");
					$ssh->remoteCopyFile($remote_cwd."wget.sh", "<-", $tmp_working_dir."/wget.sh", 0777);
					
					$result = strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? exec("echo Y | rd /s ".$tmp_working_dir) : exec("rm -rf ".$tmp_working_dir);
					
					/* run script for downloading the input data from portal */
					$cmd = $remote_cwd."wget.sh";
					$ssh->executeSH($cmd);
				}				
			}	
		}
?>