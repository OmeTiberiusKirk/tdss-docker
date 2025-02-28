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
			print_r($_SESSION);
			print_r($p1);
			print_r($p2);
			print_r($p3);
			#$c = file_get_contents(base64_decode($p3['eta_vis']['r1']['path']));
			#echo "\$c = ".strlen($c)."\n";
			#echo base64_decode($p3['eta_vis']['r1']['path']);
			exit;
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
		
		/* insert profile */
		$return_point_values = array();
		$sim_profile_id = job_config::insert_sim_profile($_REQUEST['grp_id'], $connection, $stored_dirpath, $sim_name, $p1, $p3, $ob_points, $return_point_values);
		
		/* assign to new var for ob point */
		$point_value = $return_point_values;
		
		$stored_dirpath = addslashes($stored_dirpath);

		/* insert the job profile */
		$job_profile_id = job_config::insert_job_profile($_REQUEST['grp_id'], $sim_profile_id, $sim_name, 0, $no_of_regions, $stored_dirpath, $connection);
		
		/* insert info of result */
		$sql = "INSERT INTO `sim_result`(`id`, `job_profile_id`, `uid` , `name`, ";
		$sql .= "`desc`, `magnitude`, `depth`, ";
		$sql .= "`decimal_lat`, `decimal_long`, ";		
		$sql .= "`reg_1_filename`, `reg_2_filename` , `reg_3_filename`, ";
		$sql .= "`reg_4_filename`, `sim_type`, `grp_id`, `datetime`) ";
		$sql .= "VALUES(NULL, ".$job_profile_id.", ".$_SESSION['uid'].", '".addslashes($p1['name'])."', ";
		$sql .= "'".addslashes($p1['description'])."', '".$p1['magnitude']."', '".$p1['depth']."', ";
		$sql .= "'".$p1['decimal_lat']."', '".$p1['decimal_long']."', ";	
		$sql .= "'".$p1['reg_dis_1']['filename']."', '".$p1['reg_dis_2']['filename']."', '".$p1['reg_dis_3']['filename']."', ";
		$sql .= "'".$p1['reg_dis_4']['filename']."', 'sequential', ".$_REQUEST['grp_id'].", '".time()."');";
		mysql_query("START TRANSACTION", $connection) or die("! could not start transaction.");
		mysql_query($sql, $connection) or die("! Could not insert `sim_result`. \n! ".$sql."\n! mysql_errno(".$connection.").:".mysql_error($connection)."\n<a href='javascript: void()' onclick='javascript: history.back()'>back</a>");
		
		$rid = fn_get_last_auto_increment_id("sim_result")-1;
		
		/* process the ob point's value */
		foreach($p2['select_point_id'] as $id => $status) {
			$point_id[] = $id;
		}
		
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
		echo "<script language=javascript>document.location.href='vis_runner.php?grp_id=".$_REQUEST['grp_id']."';</script>";
	
	}
	
	/* redirect */
	echo "</pre>";
	echo "<script language=javascript>location.href='result.php?section=3&grp_id=".$_REQUEST['grp_id']."';</script>";
?>