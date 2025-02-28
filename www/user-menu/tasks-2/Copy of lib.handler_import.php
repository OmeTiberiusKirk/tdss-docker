<?php
	session_start();
	
	echo "<pre>";
	
	require_once('../../library/setting.inc.php');
	require_once('../../library/connectdb.inc.php');
	require_once('job.class.php');
	
	if(is_resource($connection)) {
		$sql = "";
		$p1 = $_SESSION['import'][1];
		$p2 = $_SESSION['import'][2];
		unset($p2['next']);
		$p3 = $_SESSION['import'][3];
		
		/*
			print_r($p1);
			print_r($p2);
			print_r($p3);
			$c = file_get_contents(base64_decode($p3['eta_vis']['r1']['path']));
			echo "\$c = ".strlen($c)."\n";
			echo base64_decode($p3['eta_vis']['r1']['path']);
			//exit;
		*/
			
		/* count region */
		$no_of_regions = 0;
		for($i=1; $i<=4; $i++) {
			if(isset($p1['reg_dis_'.$i]))
				$no_of_regions++;
		}
		
		if($no_of_regions == 0)
			die("! error no specified region.");
		 
		 /* print no of regs */
		 /* echo $no_of_regions; */
		 
		/* create simulation profile that stored in db and created on specified dir */
		$sim_name = $p1['name'];
		$stored_dirpath = "";
		$ext = "";
		foreach($p2['select_point_id'] as $pid => $status) {
			$ext[] = "`observ_point_id` = ".$pid;
		}
		$sql = "SELECT * FROM `observe_point` WHERE `grp_id` = ".$_REQUEST['grp_id']." AND ".implode(" OR ", $ext);
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
		
		$return_point_values = array();
		$sim_profile_id = job_config::insert_sim_profile($_REQUEST['grp_id'], $connection, $stored_dirpath, $sim_name, $p1, $p3, $ob_points, $return_point_values);
		$point_value = $return_point_values;
				
		$stored_dirpath = addslashes($stored_dirpath);

		/* pre-result which inserted into db */		
		//$sim_result_id = job_config::insert_sim_result_db($connection, addslashes($f), $sim_profile_id);
	
		/**/
		//job_config::insert_point_values($_post_points, $ret_cal_point, $sim_result_id, $db_link)
		
		/* create job profile that used for monitoring */
		$job_profile_id = job_config::insert_job_profile($_REQUEST['grp_id'], $sim_profile_id, $sim_name, 0, $no_of_regions, $stored_dirpath, $connection);
		
		$sql = "INSERT INTO `sim_result`(`id`, `job_profile_id`, `uid` , `name`, ";
		$sql .= "`desc`, `magnitude`, `depth`, ";
		/*$sql .= "`lat_degree`, `lat_lipda`, `lat_Philipda`, ";
		$sql .= "`long_degree`, `long_lipda` , `long_Philipda`, ";*/
		$sql .= "`decimal_lat`, `decimal_long`, ";		
		$sql .= "`reg_1_filename`, `reg_2_filename` , `reg_3_filename`, ";
		$sql .= "`reg_4_filename`, `sim_type`, `grp_id`, `datetime`) ";
		$sql .= "VALUES(NULL, ".$job_profile_id.", ".$_SESSION['uid'].", '".addslashes($p1['name'])."', ";
		$sql .= "'".addslashes($p1['description'])."', '".$p1['magnitude']."', '".$p1['depth']."', ";
		/*$sql .= "'".$p1['lat']['degree']."', '".$p1['lat']['lipda']."', '".$p1['lat']['Philipda']."', ";
		$sql .= "'".$p1['long']['degree']."', '".$p1['long']['lipda']."', '".$p1['long']['Philipda']."', ";*/
		$sql .= "'".$p1['decimal_lat']."', '".$p1['decimal_long']."', ";	
		$sql .= "'".$p1['reg_dis_1']['filename']."', '".$p1['reg_dis_2']['filename']."', '".$p1['reg_dis_3']['filename']."', ";
		$sql .= "'".$p1['reg_dis_4']['filename']."', 'sequential', ".$_REQUEST['grp_id'].", '".time()."');";
		mysql_query("START TRANSACTION", $connection) or die("! could not start transaction.");
		mysql_query($sql, $connection) or die("! Could not insert `sim_result`. \n! ".$sql."\n! mysql_errno(".$connection.").:".mysql_error($connection)."\n<a href='javascript: void()' onclick='javascript: history.back()'>back</a>");
		
		$rid = fn_get_last_auto_increment_id("sim_result")-1;
		
		/* HERE */
		/*echo "<pre>";
		print_r($p2);
		print_r($point_value);
		echo "</pre>";
		exit;
		*/
		/*
		foreach($pv as $type => $c) {
			foreach($p_type as $type_name => $point) {
				foreach($point as $point_name => $value) {
					for($i=0; $i<count($ob_points); $i++) {
						if($ob_points[$i]['name'] == $point_name) {
							$new['R'.$index][$type_name][$i]['id'] = $ob_points[$i]['id'];
							$new['R'.$index][$type_name][$i]['value'] = $value;
						}
					}
				}
			}
		}
		*/
		
		foreach($p2['select_point_id'] as $id => $status) {
			$point_id[] = $id;
		}
		
		foreach($p2['select_point_label'] as $label => $e) {
			$point_label[] = $label;
		}
		$i = 0;
		foreach($point_value as $type => $v) {
			foreach($p2['select_point_label'] as $label => $v2) {				
				if($type == ETA)
					$type = "ETA";
					
				if($type == HEIGHT)
					$type = "ZMAX";
				
				$sql = "INSERT INTO `sim_point_val`(`id`, `sim_result_id`, `id_point`, `values`, `type`) ";
				$sql .= "VALUES(NULL, ".$rid.", ".$point_id[$i++].", ".(float)(trim($v[$label])).", '".$type."');";
				mysql_query($sql, $connection) or die("! Could not insert `sim_point_val`.");
			}
			$i = 0;
		}
		/*
		print_r($point_value);
		exit;
		foreach($point_value as $region_no => $v) {
			foreach($p2['select_point_label'] as $label => $v2) {				
				$sql = "INSERT INTO `sim_point_val`(`id`, `sim_result_id`, `id_point`, `values`, `type`, `region_no`) ";
				$sql .= "VALUES(NULL, ".$rid.", ".$point_id[$i++].", ".(float)(trim($v[$label])).", '".$type."', '".$region_no."');";
				mysql_query($sql, $connection) or die("! Could not insert `sim_point_val`.");
			}
			$i = 0;
		}
		*/
		
		/*
			$sql = "INSERT INTO `sim_point_val`(`id`, `sim_result_id`, `id_point`, `values`, `type`) ";
			$sql .= "VALUES(NULL, ".$rid.", ".$point_id.", ".$val.", '".strtoupper($tt)."');";
			mysql_query($sql, $connection) or die("! Could not insert `sim_point_val`.");
		*/

		/*
			$sql = "INSERT INTO `sim_point_val`(`id`, `sim_result_id`, `id_point`, `values`, `type`) ";
			$sql .= "VALUES(NULL, ".$rid.", ".$point_id.", ".$val.", '".strtoupper($tt)."');";
			mysql_query($sql, $connection) or die("! Could not insert `sim_point_val`.");
		*/
						
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
		
		mysql_query("COMMIT", $connection);
			
		$_SESSION['vis_path'] = $stored_dirpath;
		$_SESSION['vis_name'] = $sim_name;
		echo "<script language=javascript>document.location.href='vis_runner.php?grp_id=".$_REQUEST['grp_id']."';</script>";
	
	}
	
	/*
		1. create simulation's directory.
	*/
	
	/*
		2. copy *.dx.
		3. construct .net, .general, .cfg of Z_MAX, ETA.
		4. zip all
		5. mkdir at server
		6. xfer the zip file to server
		7. xtract the zip on server
		8. run script
		9. zip (tar.gz) all of files on server
		10. xfer back
		11. xtract
		12. save status 
	*/
	
	echo "</pre>";
	echo "<script language=javascript>location.href='result.php?section=3&grp_id=".$_REQUEST['grp_id']."';</script>";
?>