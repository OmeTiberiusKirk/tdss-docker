<?php
	//$_POST['username'] = "gismap";
	//$_POST['password'] = "tdss4gismap";
	//$_POST['key'] = "959cbafbe99747feff615e29f088835f";
	
	$username = md5($_POST['username']);
	$password = md5($_POST['password']);
	//echo $username;
	if(md5($_POST['username']) != "ff4d791102491878c64d68ee7e60ea0a" || md5($_POST['password']) != "332d1e050f96f5d8e955b7090b263682" || $_POST['key'] != "959cbafbe99747feff615e29f088835f"){
		 echo "<script language=javascript>alert('! Cannot sign in');</script>";
		 
		 //echo "Failed";
		 exit;	
	}
	
	/* require $_POST 	
		EQ-Criteria key = 4271879056ba78239df95db6d7d8c5789978cb96
		Digest Search key = 1ded9dd146c099d10c088f76664ebdce
	*/	
	/*	$_POST['key'] = 1ded9dd146c099d10c088f76664ebdce;
		$_POST['username'] = 'gis';
		$_POST['password'] = 'gi$m@p4ndwc';
		$_POST['magnitude'] = 8.2;
		$_POST['depth'] = 2;
		$_POST['latitude'] = 45.635;
		$_POST['longitude'] = 166.56;
	*/
	
	
	
	require('../../library/connectdb.inc.php');
	

	/*
	
	Example
	===============================
		$_REQUEST :: 
		
		search.php?
			grp_id=1&
			date=15%2F07%2F2009&
			time=16%3A22%3A28&
			name=seismic_watch&
			lat=-45.635&
			long=166.56&
			magnitude=8.2&
			depth=2&
			search_btn=Submit+Query
	*/
	
	define("DEBUG", true);
	if(defined("DEBUG")) {
		//echo '<META http-equiv=Content-Type content="text/html; charset=utf-8">';
		//echo "<pre>";
	}

	//$_POST['grp_id'] = 1;
	//$_POST['lat'] = -45.635;
	//$_POST['long'] = 166.56;
	//$_POST['magnitude'] = 8.2;
	//$_POST['depth'] = 2;
	//$_POST['date'] = '15/07/2009';
	//$_POST['time'] = '16:22:28';
	//$_POST['distance'] = 77.5;
	//$_POST['region_name'] = "Off W. Coast of S. Island, N.Z.";

	
	$_SESSION['lat'] = $_POST['lat'];
	$_SESSION['long'] = $_POST['long'];
	$_SESSION['magnitude'] = $_POST['magnitude'];
	$_SESSION['depth'] = $_POST['depth'];
	$_SESSION['date'] = $_POST['date'];
	$_SESSION['time'] = $_POST['time'];
	
	foreach($_POST as $varname => $value) {
		$_SESSION['search'][$varname] = $value;	
	}
				
	/* create statement for searching */
	$sq = "SELECT ";
	$sq .= "	`id`, `job_profile_id`, `name`, `magnitude`, ";
	$sq .= "	`depth`, `decimal_lat`, `decimal_long`, ";
	$sq .= "	ROUND(SQRT(POW(`decimal_lat`-(".floatval($_SESSION['lat'])."), 2) + POW(`decimal_long`-(".floatval($_SESSION['long'])."), 2)), 3) AS `R` ";
	$sq .= "FROM `sim_result` WHERE `grp_id` = ".$_POST['grp_id'];
						
	/* magnitude criteria */
	if($_SESSION['magnitude'] != 0) {
		if($_SESSION['magnitude'] >= 7.1 && $_SESSION['magnitude'] <= 7.5) 
			$m = 7.5;
					
		if($_SESSION['magnitude'] >= 7.6 && $_SESSION['magnitude'] <= 8.0)
			$m = 8.0;
					
		if($_SESSION['magnitude'] >= 8.1 && $_SESSION['magnitude'] <= 8.5)
			$m = 8.5;
					
		if($_SESSION['magnitude'] >= 8.6)
			$m = 9.0;	
					
		$sq .= " AND `magnitude` = ".(float)$m." ";
	}
	
	/* add tail and query ! */
	$sq .= " ORDER BY `R` ASC LIMIT 0, 1";
	$res = mysql_query($sq, $connection) or die("Fatal error: query failed ".__LINE__);
	
	/* check returned number of records. */
	if(mysql_num_rows($res) == 1) {
		
		/* fetch result */
		$obj = mysql_fetch_object($res);
		
		/* fetch simulation profile */
		$sql = "SELECT * FROM `sim_result` WHERE `id`=".$obj->job_profile_id;
		$result = mysql_query($sql, $connection) or die("Fatal error: query failed ".__LINE__);
		if(mysql_num_rows($result) == 1) {
			$obj_result = mysql_fetch_object($result);
		}
		//var_dump($obj_result);
		//exit;
		/* set bulletin information */
		$time_now = time();
		$h_release = fn_get_last_auto_increment_id("bulletin");
		$h_year = date("y", $time_now)+43;
		$h_date = date('j/m/'.$h_year, $time_now);
		$h_time = date('H:i:s', $time_now);
	
		/* statement of eta */
		$sql_eta = "SELECT * FROM `sim_point_val`, `observe_point` 
					WHERE 
						`sim_point_val`.`id_point` = `observe_point`.`observ_point_id` AND 
						`sim_point_val`.`type` LIKE 'ETA' AND 
						((`sim_point_val`.`region_no` = 2 AND `observe_point`.`R2` = 'yes') OR 
						 (`sim_point_val`.`region_no` = 1 AND `observe_point`.`R1` = 'yes')) AND 
						`sim_point_val`.`sim_result_id` = ".$obj->job_profile_id;
					
		/* statement of zmax */
		$sql_zmax = "SELECT * FROM `sim_point_val`, `observe_point` 
					 WHERE 
						`sim_point_val`.`id_point` = `observe_point`.`observ_point_id` AND 
						`sim_point_val`.`type` LIKE 'ZMAX' AND 
						((`sim_point_val`.`region_no` = 2 AND `observe_point`.`R2` = 'yes') OR 
						 (`sim_point_val`.`region_no` = 1 AND `observe_point`.`R1` = 'yes')) AND  
						`sim_point_val`.`sim_result_id` = ".$obj->job_profile_id;
		
		/* job profile id var */
		$job_id = $obj->job_profile_id;
		
		/* query base search [ VIZ] */
		$sql_viz = "SELECT * FROM `sim_result`, `job_profile` where `job_profile`.`id` = `sim_result`.`job_profile_id` and `sim_result`.`id` = ".$job_id." ;"; 
		$res_viz = mysql_query($sql_viz, $connection);
		$obj_viz = mysql_fetch_object($res_viz);
		$_POST['path'] = $obj_viz->local_store_path;
		$_POST['lat_base'] = $obj_viz->decimal_lat;
		$_POST['long_base'] = $obj_viz->decimal_long;
		$_POST['mag'] = $obj_viz->magnitude;
		$_POST['dep'] = $obj_viz->depth;
		$_POST['ref_id'] = $obj_viz->name;
		
		/*cho "Data from viz \n";
		echo "path = ".$_POST['path']."\n";
		echo "lat = ".$_POST['lat_base']."\n";
		echo "long = ".$_POST['long_base']."\n";
		echo "magnitude = ".$_POST['mag']."\n";
		echo "depth = ".$_POST['dep']."\n\n---------------------------------\n";
		*/
		
		/* query eta, zmax */
		$res_point_eta = mysql_query($sql_eta, $connection);
		if(mysql_num_rows($res_point_eta) < 1) die("! Could not query ETA of point of region 2.");
				
		$res_point_zmax = mysql_query($sql_zmax, $connection);
		if(mysql_num_rows($res_point_zmax) < 1) die("! Could not query Z_MAX of point of region 2.");
		
		
		$create_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>"."";
		$create_xml .= "<ndwc-tdss reference-timestamp=\"".time()."\">\n";
		$create_xml .= "\t<bulletin-info release=\"".$h_release."\" year=\"".$h_year."\" date=\"".$h_date." ".$h_time."\">\n";
		$create_xml .= "\t\t<earthquake-info date=\"".$_POST['date']." ".$_POST['time']."\">\n";
		$create_xml .= "\t\t\t<region name=\"".$_POST['region_name']."\" />\n";
		$create_xml .= "\t\t\t<magnitude value=\"".$_POST['magnitude']."\" />\n";
		$create_xml .= "\t\t\t<depth value=\"".$_POST['depth']."\" />\n";
		$create_xml .= "\t\t\t<location latitude=\"".$_POST['lat']."\" longitude=\"".$_POST['long']."\" />\n";
		$create_xml .= "\t\t</earthquake-info>\n";
		
		/*echo $h_release."/".$h_year."\n";
		echo $h_date." ".$h_time."\n";
		echo $_POST['date']." ".$_POST['time']."\n";
		echo "Richter ".$_POST['magnitude']."\n";
		echo "Depth (km) ".$_POST['depth']."\n";
		echo "Location:\n";
		echo "	".$_POST['lat']."\n";
		echo "	".$_POST['long']."\n";
		*/
				
				
		/* fetch & create array of zmax */
		while($obj = mysql_fetch_object($res_point_zmax)) {
			$val_zmax[$n] = $obj->values;
			$n++;
		}
		
		/* fetch eta */
		$i = 1;
		while($obj = mysql_fetch_object($res_point_eta)) {
			//echo ($i++)." ".$obj->province_t."(".$obj->province.") ".$obj->name_t."(".$obj->name.") ".calculate_eta($_POST['time'], time_p($obj->values))."[".time_p($obj->values)."]	".round(number_format($val_zmax[$i-1], 3), 2)."\n";
			//$create_xml .= "\t\t<observation-area province-name-th=\"".$obj->province_t."\" province-name-en=\"".$obj->province."\" area-name-th=\"".$obj->name_t."\" area-name-en=\"".$obj->name."\" eta=\"".(time_p($obj->values) == "-" ? "-" : calculate_eta($_POST['time'], time_p($obj->values)))."\" zmax=\"".round(number_format($val_zmax[$i-1], 3), 2)."\" /> \n";
			$create_xml .= "\t\t<observation-area province-name-th=\"".$obj->province_t."\" province-name-en=\"".$obj->province."\" area-name-th=\"".$obj->name_t."\" area-name-en=\"".$obj->name."\" eta=\"".time_p($obj->values)."\" zmax=\"".round(number_format($val_zmax[$i-1], 3), 2)."\" /> \n";
			$i++;
		}
	}	
	
	
	$create_xml .= "\t</bulletin-info>\n";
	$create_xml .= "\t<database-matched-result reference-id=\"".$_POST['ref_id']."\" distance=\"".$_POST['diatance']."\" magnitude=\"".$_POST['mag']."\" depth=\"".$_POST['dep']."\" latitude=\"".$_POST['lat_base']."\" longitude=\"".$_POST['long_base']."\" >\n";
	$create_xml .= "\t\t<visualization type=\"eta\" region-no=\"1\">\n\t\t\t<image-map  filename=\"".$_POST['ref_id']."-ETA-R1-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_eta_vis_1/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar  filename=\"".$_POST['ref_id']."-ETA-R1-COLORBAR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_eta_vis_1/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";
	$create_xml .= "\t\t<visualization type=\"eta\" region-no=\"2\">\n\t\t\t<image-map filename=\"".$_POST['ref_id']."-ETA-R2-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_eta_vis_2/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar filename=\"".$_POST['ref_id']."-ETA-R2-COLORBAR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_eta_vis_2/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";
	$create_xml .= "\t\t<visualization type=\"zmax\" region-no=\"1\">\n\t\t\t<image-map filename=\"".$_POST['ref_id']."-ZMAX-R1-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_zmax_vis_1/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar filename=\"".$_POST['ref_id']."-ZMAX-R1-COLORBAR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_zmax_vis_1/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";
	$create_xml .= "\t\t<visualization type=\"zmax\" region-no=\"2\">\n\t\t\t<image-map filename=\"".$_POST['ref_id']."-ZMAX-R2-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_zmax_vis_2/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar filename=\"".$_POST['ref_id']."-ZMAX-R2-COLORBAR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_POST['ref_id']."/visualization/image_zmax_vis_2/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";
	$create_xml .= "\t</database-matched-result>\n";
	$create_xml .= "</ndwc-tdss>\n";
	
	$xml_file = "../../xml/result.xml";
	$file_handle = fopen($xml_file, 'w')or die("Can't open file");
	fwrite($file_handle, $create_xml);
	fclose($file_handle);
	 
	if(isset($xml_file)){
		$path = iconv("UTF-8", "UTF-8", $xml_file);
		$name = 'result.xml';
		//echo $path;
		//echo "name  ===".$name;
		//if(!is_readable($path)) 
			//die('File not found or inaccessible!!!');
		if(!isset($_SESSION['username'])) {
			file_put_contents("../../xml/latest.info", time());
			force_download($path, $name, 'text/xml');
		}
	}
	
	/* on/off debugging */
	//if(defined("DEBUG")) //echo "</pre>";	
	
/*----------------- Time Conversion ----------------------------*/
	function time_p($t) {
		$res_time = number_format($t/3600, 3);

		/* HOUR */
		$hr = explode(".", $res_time);
		$hour = $hr[0];
			
		/* MIN */
		$min = "0.".$hr[1]; 
		$mins = $min * 60;
		$minutes = explode(".", $mins);	
		$minute = $minutes[0] ;
				
		/* SEC */		
		$sec = "0.".$minutes[1];
		$sec = $sec * 60;
		$secs = explode(".", $sec);
		$second = $secs[0];
		
		$hour = (strlen((string)($hour)) > 1) ? $hour : "0".$hour;
		$minute = (strlen((string)($minute)) > 1) ? $minute : "0".$minute;
		$second = (strlen((string)($second)) > 1) ? $second : "0".$second;
							
		$result_time = $hour.":".$minute.":".$second;
		return ($res_time == 0) ? "-" : $result_time;
	}
	
/* ------------- Calculate ETA ---------------------------*/
	function calculate_eta($occur, $eta_time){
			$time_occ = explode(":", $occur);
			$time_eta = explode(":", $eta_time);
			
			$sec = $time_occ[2] + $time_eta[2];
			$min = $time_occ[1] + $time_eta[1];
			$hr  = $time_occ[0] + $time_eta[0];			
			
			if($sec >= 60){
				$sec = $sec - 60;
				$min = $min + 1;
			}
			
			if($min >= 60){
				$min = $min - 60;
				$hr  = $hr +1;
			}
			
			if($hr >= 24){
				$hr = $hr - 24;
			}
			
			$pointStr_eta = $hr.":".$min.":".$sec;			
			return $pointStr_eta;
		}
		
	/*---------------download function---------------------*/
	function force_download($file, $name, $mime_type='', $del_flag = false){
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
			"xml" => "text/xml",
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
?> 

