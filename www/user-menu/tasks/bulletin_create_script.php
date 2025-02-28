<?php
	session_start();
	
	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";
	//exit;

	/****** THAI ******/
	require_once('lib.bulletin-th.php');
	$TH = new Bulletin_TH();
	
	/* function assignHeaderInfo($release_no, $year_release, $announce_date, $announce_time) */
	$TH->assignHeaderInfo($_POST['h_release'], $_POST['h_year'], $_POST['h_date'], $_POST['h_time']);
		
	/* function assignEqInfo($eq_date, $eq_time, $richter, $depth) */
	$TH->assignEqInfo($_POST['h_gname'], $_POST['h_gid'], $_POST['eq_date'], $_POST['eq_time'], $_POST['eq_richter'], $_POST['eq_depth']);
	
	/* function assignEqLocation($latitude, $longitude) */
	$TH->assignEqLocation($_POST['eq_lat'], $_POST['eq_long']);
	
	/* function assignObservationArea($province, $area, $eta_value) */
	foreach($_POST['ob']['province'] as $id => $p_name) {
		$TH->assignObservationArea($p_name, $_POST['ob']['area'][$id], $_POST['ob']['eta'][$id],  number_format($_POST['ob']['zmax'][$id], 2));
	}

	/* run ! */	
	$TH->Create();
	
	/****** ENGLISH ******/
	require_once('lib.bulletin-en.php');
	$EN = new Bulletin_EN();
	
	/* function assignHeaderInfo($release_no, $year_release, $announce_date, $announce_time) */
	$EN->assignHeaderInfo($_POST['h_release'], $_POST['h_year'], $_POST['h_date'], $_POST['h_time']);
		
	/* function assignEqInfo($eq_date, $eq_time, $richter, $depth) */
	$EN->assignEqInfo($_POST['h_gname'], $_POST['h_gid'], $_POST['eq_date'], $_POST['eq_time'], $_POST['eq_richter'], $_POST['eq_depth']);
	
	/* function assignEqLocation($latitude, $longitude) */
	$EN->assignEqLocation($_POST['eq_lat'], $_POST['eq_long']);
	
	/* function assignObservationArea($province, $area, $eta_value) */
	foreach($_POST['ob']['province_eng'] as $id => $p_name) {
		$EN->assignObservationArea($p_name, $_POST['ob']['area_eng'][$id], $_POST['ob']['eta'][$id],  number_format($_POST['ob']['zmax'][$id], 2));
	}

	/* run ! */	
	$EN->Create();
	
	
	/* get PDF */
	$filename = $_POST['h_release']."_".$_POST['h_year']."_".str_replace("/", "_", $_POST['h_date'])."_".str_replace(":", "_", $_POST['h_time']);
	$path_to_file_TH = "../../workspace/".$_SESSION['username']."/files/Bulletin/".$filename."_TH.pdf";
	$path_to_file_EN = "../../workspace/".$_SESSION['username']."/files/Bulletin/".$filename."_EN.pdf";
	$path_XMLbulletin = "../../workspace/".$_SESSION['username']."/files/XML-Bulletins/".$filename.".xml";
	$path_latestXMLBulletin = "../../workspace/".$_SESSION['username']."/files/XML-Bulletins/latest-bulletin.xml";

	$TH->getOutput($path_to_file_TH, "F");
	$EN->getOutput($path_to_file_EN, "F");
	if(file_exists($path_to_file_TH) && file_exists($path_to_file_EN)) {
		require_once('../../library/connectdb.inc.php');
		$_SESSION['lat'] = $_POST['eq_lat'];
		    $_SESSION['long'] = $_POST['eq_long'];
			 $sql = "SELECT";
			 $sql .= "	`id`, `job_profile_id`, `name`, `magnitude`, ";
			 $sql .= "	`depth`, `decimal_lat`, `decimal_long`, ";
			 $sql .= "	ROUND(SQRT(POW(`decimal_lat`-(" . floatval($_SESSION['lat']) . "), 2) + POW(`decimal_long`-(" . floatval($_SESSION['long']) . "), 2)), 3) AS `R` ";
			 $sql .= "FROM `sim_result` WHERE `name` = " . $_REQUEST['result_name'];
		$res = mysql_query($sql, $connection) or die("! death");
		if (mysql_num_rows($res) == 1) {
		    $obj_sim_result = mysql_fetch_object($res);
			 }
		/*$sql = "INSERT INTO 
					`bulletin`(`uid`, `release_no`, `release_year`, `announce_date`, 
					`announce_time`, `eq_date`, `eq_time`, 
					`magnitude`, `depth_km`,
					`eq_area_lat`, `eq_area_long`, `th_path_filename`, `en_path_filename`, 
					`grp_id`, `from_result_id`, `from_result_name`, `from_ip`, `create_datetime`) 
				VALUES(".$_SESSION['uid'].", ".$_POST['h_release'].", '".$_POST['h_year']."', '".$_POST['h_date']."', 
					'".$_POST['h_time']."', '".$_POST['eq_date']."', '".$_POST['eq_time']."', 
					'".$_POST['eq_richter']."', '".$_POST['eq_depth']."', 
					".$_POST['eq_lat'].", ".$_POST['eq_long'].", '".$path_to_file_TH."', '".$path_to_file_EN."', 
					".$_REQUEST['grp_id'].", '".$_REQUEST['from_result_id']."','".$_REQUEST['result_name']."', '".$_SERVER['REMOTE_ADDR']."', '".time()."')";*/
		$sql = "INSERT INTO 
					`bulletin`(`uid`, `release_no`, `release_year`, `announce_date`, `announce_time`, `magnitude`, `depth_km`,
					`eq_date`, `eq_time`, `eq_area_lat`, `eq_area_long`, `en_path_filename`, `th_path_filename`, 
					`grp_id`, `from_result_id`, `create_datetime`) 
				VALUES(".$_SESSION['uid'].", ".$_POST['h_release'].", '".$_POST['h_year']."', '".$_POST['h_date']."', '".$_POST['h_time']."', '".$_POST['eq_richter']."', '".$_POST['eq_depth']."',
					 '".$_POST['eq_date']."', '".$_POST['eq_time']."', ".$_POST['eq_lat'].", ".$_POST['eq_long'].", '".$path_XMLbulletin."', '".$path_XMLbulletin."', 
					".$_REQUEST['grp_id'].", '".$_REQUEST['from_result_id']."', '".time()."')";
					
		if(is_resource($connection)) {
			#echo $sql;
			$result = mysql_query($sql, $connection) or die("! could not insert bulletin profile (".mysql_error($connection).") SQL >> {$sql}");
		}
		
		/*------------------- Start Create XML -----------------*/
		$originalDate = $_POST['eq_date'];
		$newDate = date("m/d/Y", strtotime($originalDate));
		$create_xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>"."";
		$create_xml .= "<ndwc-tdss reference-timestamp=\"".time()."\">\n";
		$create_xml .= "\t<bulletin-info release=\"".$_POST['h_release']."\" year=\"".$_POST['h_year']."\" date=\"".$_POST['h_date']." ".$_POST['h_time']."\">\n";
		$create_xml .= "\t\t<earthquake-info date=\"".$newDate." ".$_POST['eq_time']."\">\n";
		$create_xml .= "\t\t\t<region name=\"".$_POST['h_gname']."\" />\n";
		$create_xml .= "\t\t\t<magnitude value=\"".$_POST['eq_richter']."\" />\n";
		$create_xml .= "\t\t\t<depth value=\"".$_POST['eq_depth']."\" />\n";
		$create_xml .= "\t\t\t<location latitude=\"".$_POST['eq_lat']."\" longitude=\"".$_POST['eq_long']."\" />\n";
		$create_xml .= "\t\t</earthquake-info>\n";
		
		for($j=2; $j<=(count($_POST['ob']['province'])+1); $j++){
			$create_xml .= "\t\t<observation-area province-name-th=\"".$_POST['ob']['province'][$j]."\" province-name-en=\"".$_POST['ob']['province_eng'][$j]."\" area-name-th=\"".$_POST['ob']['area'][$j]."\" area-name-en=\"".$_POST['ob']['area_eng'][$j]."\" eta=\"".calculate_eta($_POST['ob']['eta'][$j])."\" zmax=\"".round(number_format($_POST['ob']['zmax'][$j], 3), 2)."\" /> \n";
			//$create_xml .= "\t\t<observation-area province-name-th=\"".$_POST['ob']['province'][$j]."\" province-name-en=\"".$_POST['ob']['province_eng'][$j]."\" area-name-th=\"".$_POST['ob']['area'][$j]."\" area-name-en=\"".$_POST['ob']['area_eng'][$j]."\" eta=\"".$_POST['ob']['eta'][$j]."\" zmax=\"".round(number_format($_POST['ob']['zmax'][$j], 3), 2)."\" /> \n";
		}
		
		$create_xml .= "\t</bulletin-info>\n";
		$create_xml .= "\t<database-matched-result reference-id=\"".$_REQUEST['result_name']."\" distance=\"".$obj_sim_result->R."\" magnitude=\"".$obj_sim_result->magnitude."\" depth=\"".$obj_sim_result->depth."\" latitude=\"".$obj_sim_result->decimal_lat."\" longitude=\"".$obj_sim_result->decimal_long."\" />\n";
		
		//   ../../workspace/ndwc/files/Simulation/750500129/visualization/image_eta_vis_1/image.tiff.png
		/*$create_xml .= "\t\t<visualization type=\"eta\" region-no=\"1\">\n\t\t\t<image-map  filename=\"".$_REQUEST['result_name']."-ETA-R1-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_eta_vis_1/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar  filename=\"".$_REQUEST['result_name']."-ETA-R1-COLORBAR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_eta_vis_1/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";
		$create_xml .= "\t\t<visualization type=\"eta\" region-no=\"2\">\n\t\t\t<image-map filename=\"".$_REQUEST['result_name']."-ETA-R2-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_eta_vis_2/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar filename=\"".$_REQUEST['result_name']."-ETA-R2-COLORBAR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_eta_vis_2/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";
		$create_xml .= "\t\t<visualization type=\"zmax\" region-no=\"1\">\n\t\t\t<image-map filename=\"".$_REQUEST['result_name']."-ZMAX-R1-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_zmax_vis_1/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar filename=\"".$_REQUEST['result_name']."-ZMAX-R1-COLORBAR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_zmax_vis_1/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";
		$create_xml .= "\t\t<visualization type=\"zmax\" region-no=\"2\">\n\t\t\t<image-map filename=\"".$_REQUEST['result_name']."-ZMAX-R2-MAP.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_zmax_vis_2/image.tiff.png")))."</image-map>\n\t\t\t<image-colorbar filename=\"".$_REQUEST['result_name']."-ZMAX-R2-COLORABR.png\">".chunk_split(base64_encode(file_get_contents("../../workspace/ndwc/files/Simulation/".$_REQUEST['result_name']."/visualization/image_zmax_vis_2/colorbar.tiff.png")))."</image-colorbar>\n\t\t</visualization>\n";*/
		//$create_xml .= "\t</database-matched-result>\n";
		$create_xml .= "</ndwc-tdss>\n";
		
		$xml_file = $path_XMLbulletin;
		$file_handle = fopen($xml_file, 'w')or die("Can't open file");
		fwrite($file_handle, $create_xml);
		fclose($file_handle);
		//file_put_contents("../../xml/latest.info", time());
		file_put_contents($path_latestXMLBulletin, $create_xml);
		
		//echo $path_XMLbulletin;
		
		//exit;
		
		/*-------------------- XML Create Finished -------------------*/
		
		echo "<script language=javascript>alert('! Created bulletin successfully');</script>";
	}else
		echo "<script language=javascript>alert('! Created bulletin successfully');</script>";
	echo "<script language=javascript>document.location.href='bulletin_release.php?section=4.1&grp_id=".$_REQUEST['grp_id']."';</script>";
	
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
	function calculate_eta($eta_time){
		
			$res_time = $eta_time;
			//echo $res_time;
			
			/* HOUR */
			$hr = explode(".", $res_time);
			
			$hour = $hr[0];
				
			/* MIN */
			$min = "0.".$hr[1]; 
			$mins = $min * 60;
			//echo "min = ".$mins."  ";
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
			 $pointStr_eta = ($res_time == 0) ? "-" : $result_time;
			
			//$pointStr_eta = $hr_res.":".$min_res.":".$sec_res;			
			return $pointStr_eta;
		}
?>