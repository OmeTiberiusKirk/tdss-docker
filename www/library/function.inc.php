<?php
	function JSAlert($message, $redirect = null)
	{
		$s1 = "<script language=\"javascript\">alert('".$message."'); ";
		if ($redirect != null )
			$s1 .= "location.href='".$redirect."';</script>";
		else
			$s1 .= "</script>";
		echo $s1;
	}
	
	function generateRanString($prefix = null, $length = 32) 
	{  
		$chars = session_id();
		$chars_len = strlen($chars);  
		
		for ($i = 0; $i < $length; $i++)  
			$str .= $chars[mt_rand(0, $chars_len - 1)];  
			
		return $prefix.$str;  
	}  

	function validateDSN($dsn_string)
	{
		$dsn_arr = array();
		
		$dsn_t = $dsn_string;
		
		$t = strtok($dsn_t, ":");
		$dsn_arr['username'] = $t;
		
		$t = strtok("@");
		$dsn_arr['password'] = $t;
		
		$t = strtok(":");
		$dsn_arr['hostname'] = $t;
		
		$t = strtok("\n");
		$dsn_arr['path'] = $t;
		
		if ($dsn_arr['path'][strlen($dsn_arr['path'])-1] != '/')
			$dsn_arr['path'] .= '/';
		
		return $dsn_arr;
	}
	function validateGDSN($gdsn_string)
	{
		$gdsn_arr = array();
		
		$gdsn_t = $gdsn_string;
		
		$t = strtok($gdsn_t, ":");
		$gdsn_arr['hostname'] = $t;
		
		$t = strtok("\n");
		$gdsn_arr['path'] = $t;
		
		if ($gdsn_arr['path'][strlen($gdsn_arr['path'])-1] != '/')
			$gdsn_arr['path'] .= '/';
		
		return $gdsn_arr;
	}
	
	function downloadRemoteFile($url, $save_as)
	{
		$handler = fopen($url, 'r');
		
		if(!$handler)
			return false;
		else
		{	
			$contents = '';
			while (!feof($handler)) 
				$contents .= fread($handler, 10240);
			
			$t[] = strtok($url, '/');
			while($t[] = strtok('/'));
			
			$pathfile = $save_as.generateRanString('tmp-', 32);
			file_put_contents($pathfile, $contents);
			fclose($handler);
			
			return true;
		}
	}
	
	function checkRemoteFileExist($url)
	{
		$handler = @fopen($url, 'r');
		
		if(!$handler)
			return false;
		else{
			fclose($handler);
			return true;
		}
	}
	
	/* This function is created for saving the Cluster DSN */
	function saveDSNHistory($dsn_arr)
	{
		/* include connectdb.inc.php for getting the $connection (common called 'resource id')*/
		require_once('connectdb.inc.php');
		
		/* merge the DSN */
		$dsn = $dsn_arr['username'].":".$dsn_arr['password']."@".$dsn_arr['hostname'].":".$dsn_arr['path'];
		
		/* checking with database for looking for the exists DSN */
		$sql = "SELECT dsnstring FROM clusterdsn WHERE dsnstring LIKE '".$dsn."' AND uid = ".$_SESSION['uid'].";";
		
		/* quering */
		$res = mysql_query($sql, $connection);
		
		/* if DSN above is exists in database, then the mysql_num_rows() return 1 row. */
		/* if DSN above is not exist in database, then the mysql_num_rows() return 0 row */
		if( mysql_num_rows($res) == 0 )
		{
			/* construct sql statement for saving the new DSN into database*/
			$sql = "INSERT INTO clusterdsn(uid, dsnstring, status, date) VALUES(".$_SESSION['uid'].", '".$dsn."', 'ok', '".time()."');";
			/* save !! */
			if(mysql_query($sql, $connection));
		}
	}
	
	function selectGridTrustedHost($uid)
	{
		require_once('connectdb.inc.php');
		
	   $sql = "select * from grid_trust where status = 1 AND uid = ".$uid."";
	   $result = mysql_query($sql, $connection);
	   $row;
		if (mysql_num_rows($result) == 1 )
		{
			$row = mysql_fetch_object($result);
			return $row;
		}  
	}
	
	function saveGridDSNHistory($gdsn_arr, $uid)
	{
		require('connectdb.inc.php');
		
		$sql_grid = "SELECT hostname, path FROM griddsn WHERE hostname LIKE '".$gdsn_arr['hostname']."' AND path LIKE '".$gdsn_arr['path']."' AND uid = ".$_SESSION['uid'].";";
		
		/* quering */
		$res_grid = mysql_query($sql_grid, $connection);
		
		/* if DSN above is exists in database, then the mysql_num_rows() return 1 row. */
		/* if DSN above is not exist in database, then the mysql_num_rows() return 0 row */
		if( mysql_num_rows($res_grid) == 0 )
		{
		
		//$connection = mysql_connect('localhost', 'root', 'u2288f');
		
		$sql = "INSERT INTO griddsn( path, hostname, uid) VALUES('".$gdsn_arr['path']."', '".$gdsn_arr['hostname']."', ".$uid." ) ";
		
		if (!mysql_query($sql, $connection))
			echo "error: could not save history!.";
		}
	}
	
	function save_upload_simulaton_inputfile($param, $connection, $filetype)
	{
		switch($filetype)
		{
			case "deform":
				$sql = "	INSERT INTO 
							simulation_input_deform(
								uid, orgname, aliasname, description, longtitude, latitude, depth,
								strike, dip, moment_magnitude, length, width, dislocation, maximum, minimum, date) 
							VALUES(
								'".$param['uid']."', 
								'".$param['orgname']."', 
								'".$param['aliasname']."', 
								'".$param['description']."', 
								'".$param['longtitude']."',
								'".$param['latitude']."',
								'".$param['depth']."',
								'".$param['strike']."',
								'".$param['dip']."',
								'".$param['moment_magnitude']."',
								'".$param['length']."',
								'".$param['width']."',								
								'".$param['dislocation']."',
								'".$param['maximum']."',
								'".$param['minimum']."',
								'".time()."')";
				break;
				
			case "region":
				$sql = "	INSERT INTO 
							simulation_input_region(
								id, uid, orgname, aliasname, description, longtitude, latitude, gridsize_x, gridsize_y,
								time_interval, grids_no, depth_max, date) 
							VALUES(
								'NULL',
								'".$param['uid']."', 
								'".$param['orgname']."', 
								'".$param['aliasname']."', 
								'".$param['description']."', 
								'".$param['longtitude']."',
								'".$param['latitude']."',
								'".$param['gridsize_x']."',
								'".$param['gridsize_y']."',
								'".$param['time_interval']."',
								'".$param['grids_no']."',
								'".$param['depth_max']."',
								'".time()."')";
				break;
		}
		
		if (mysql_query($sql, $connection))
		{
			JSAlert("Upload successful.", "../user/user.sim-upload.php?section=1&upload_status=success");
		}
	}
	
	function saveUploadedFileInfo($total_time, $param = array(), $connection, $debug_flag)
	{		
		$sql = "	INSERT INTO 
					datasource(
						uid, orgname, aliasname, description, region, series, 
						timestep, gridsize_x, gridsize_y, data_order, date) 
					VALUES(
						'".$param['uid']."', 
						'".$param['orgname']."', 
						'".$param['aliasname']."', 
						'".$param['description']."', 
						'".$param['region']."',
						'".$param['series']."',
						'".$param['time_step']."',
						'".$param['grid_size_x']."',
						'".$param['grid_size_y']."',
						'".$param['data_order']."',
						'".time()."')";
		if (mysql_query($sql, $connection))
		{
			if($debug_flag == true)
				echo "Upload successful.\nTime used = ".$total_time." seconds.\n";
			else
				JSAlert("Time used = ".$total_time." seconds.\\nUpload successful.", "../user/user.datasource.php?section=4");
		}
	}
	
	function force_download($file, $name, $mime_type='', $del_flag = false)
	{
		 /*
		 This function takes a path to a file to output ($file), 
		 the filename that the browser will see ($name) and 
		 the MIME type of the file ($mime_type, optional).
		 
		 If you want to do something on download abort/finish,
		 register_shutdown_function('function_name');
		 */
		 if(!is_readable($file)) die('File not found or inaccessible!');
		 
		 $size = filesize($file);
		 $name = rawurldecode($name);
		 
		 /* Figure out the MIME type (if not specified) */
		 $known_mime_types=array(
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"png" => "image/png",
			"jpeg"=> "image/jpg",
			"jpg" =>  "image/jpg",
			"php" => "text/plain"
		 );
		 
		 if($mime_type=='')
		 {
			 $file_extension = strtolower(substr(strrchr($file,"."),1));
			 if(array_key_exists($file_extension, $known_mime_types))
			 {
				$mime_type=$known_mime_types[$file_extension];
			 } else {
				$mime_type="application/force-download";
			 }
		 }
		 
		 @ob_end_clean(); //turn off output buffering to decrease cpu usage
		 
		 // required for IE, otherwise Content-Disposition may be ignored
		 if(ini_get('zlib.output_compression'))
		  ini_set('zlib.output_compression', 'Off');
		 
		 header('Content-Type: ' . $mime_type);
		 header('Content-Disposition: attachment; filename="'.$name.'"');
		 header("Content-Transfer-Encoding: binary");
		 header('Accept-Ranges: bytes');
		 
		 /* The three lines below basically make the 
			download non-cacheable */
		 header("Cache-control: private");
		 header('Pragma: private');
		 header("Expires: ".date(DATE_RFC822));
		 
		 // multipart-download and download resuming support
		 if(isset($_SERVER['HTTP_RANGE']))
		 {
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			if(!$range_end) {
				$range_end=$size-1;
			} else {
				$range_end=intval($range_end);
			}
		 
			$new_length = $range_end-$range+1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: ".$new_length);
			header("Content-Range: bytes ".$range-$range_end/$size);
		 } else {
			$new_length=$size;
			header("Content-Length: ".$size);
		 }
		 
		 /* output the file itself */
		 $chunksize = 1*(1024*1024); //you may want to change this
		 $bytes_send = 0;
		 if ($file = fopen($file, 'r'))
		 {
			if(isset($_SERVER['HTTP_RANGE']))
			fseek($file, $range);
		 
			while(!feof($file) && 
				(!connection_aborted()) && 
				($bytes_send<$new_length)
				  )
			{
				$buffer = fread($file, $chunksize);
				print($buffer); //echo($buffer); // is also possible
				flush();
				$bytes_send += strlen($buffer);
			}
			fclose($file);
			
			if($del_flag == true) {
				unlink($file);
			}
		 } else die('Error - can not open file.');
		 
		die();
	}
	
	function formulateData($param, $debug_string )
	{
		$script_name_t = "function.inc.php";
		
		require('formulate.class.php');
		require('setting.inc.php');
		
		$net = $template['location']['network_file'];
		$general = $template['location']['general_file'];
		$cfg = $template['location']['cfg_file'];
		$sh = $template['location']['sh_file'];
		$debug_string[] = $script_name_t."@".__LINE__.": get template `".$net."`, `".$general."`, `".$cfg."`, and `".$sh."` ";
		
		$working_dir = $visualizer['working_dir'].$param['aliasname'];
		$debug_string[] = $script_name_t."@".__LINE__.": set visualizer working directory `".$working_dir."`";
		
		$f = new Formulate($net, $general, $cfg, $sh, $param['aliasname']);
		$debug_string[] = $script_name_t."@".__LINE__.": create Formulate() instance with above parameters ";
		
		$general_filename = $tmpfile_prefix."general-".$param['aliasname'].".general";
		$general_filepath = $working_dir."/".$general_filename;
		$export_filepath = $working_dir."/".$param['aliasname'];
		$network_file_location = "";
		$formulate_dir = $working_dir;
		
		/* (1) create .net and transfer to visualizer. */
		$f->CreateNetworkOfModule($general_filepath, $general_filename, $export_filepath, $network_file_location);
		$debug_string[] = $script_name_t."@".__LINE__.": create network of modules";
		
		$input_location = $working_dir."/".$tmpfile_prefix."data-".$param['aliasname'];
		$gridsize_x = $param['grid_size_x'];
		$gridsize_y = $param['grid_size_y'];
		$data_order = $param['data_order'];
		
		$general_file_location = $general_filepath;
		
		$data_location = $param['data_local_path'];
		$data_filename = $tmpfile_prefix."data-".$param['aliasname'];
		
		/* (2) create general file and transfer to visualizer. */
		if($param['series'] == 'yes')
			$f->CreateGeneralFile($input_location, $gridsize_x, $gridsize_y, $data_order, $param['time_step']);
		else
			$f->CreateGeneralFile($input_location, $gridsize_x, $gridsize_y, $data_order);		
		$debug_string[] = $script_name_t."@".__LINE__.": create header file";
		
		/* (3) create configuration file and transfer to visualizer. */
		$f->CreateCFG($general_file_location);
		$debug_string[] = $script_name_t."@".__LINE__.": create configuration file";
				
		/* (4) create exectued shell script and transfer to visualizer. */
		$f->CreateRunSH($network_file_location, $formulate_dir);
		$debug_string[] = $script_name_t."@".__LINE__.": create shell script";
		
		/* (5) transfer raw data to visualizer. */
		$f->TransferData($data_location, $data_filename);
		$debug_string[] = $script_name_t."@".__LINE__.": transfer raw data to visualizer";
		
		/* (6) run the formulation process. */
		$f->executeDXSHELL();
		$debug_string[] = $script_name_t."@".__LINE__.": run DX ";
		
		/* (7) transfer formulated data back to web server. */
		$flag_formulated_data = $f->getFormulatedDataBack($data_location);
		$debug_string[] = $script_name_t."@".__LINE__.": get formulated data back to file server";
	
		/* (8) clean up */
		$f->cleanUp();
		$debug_string[] = $script_name_t."@".__LINE__.": clean up";
		
		return $flag_formulated_data;
	}
	


	// ------------ lixlpixel recursive PHP functions -------------
	// recursive_remove_directory( directory to delete, empty )
	// expects path to directory and optional TRUE / FALSE to empty
	// ------------------------------------------------------------
	function recursive_remove_directory($directory, $empty=FALSE)
	{
		if(substr($directory,-1) == '/')
		{
			$directory = substr($directory,0,-1);
		}
		if(!file_exists($directory) || !is_dir($directory))
		{
			return FALSE;
		}elseif(is_readable($directory))
		{
			$handle = opendir($directory);
			while (FALSE !== ($item = readdir($handle)))
			{
				if($item != '.' && $item != '..')
				{
					$path = $directory.'/'.$item;
					if(is_dir($path)) 
					{
						recursive_remove_directory($path);
					}else{
						unlink($path);
					}
				}
			}
			closedir($handle);
			if($empty == FALSE)
			{
				if(!rmdir($directory))
				{
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	function redirect_page($url)
	{
		if(headers_sent())
		{
			?>
			<script language="javascript">
				document.location.href='<?=$url?>';
			</script>
			<?php
		}else
			header('location: '.$url);
	}
?>