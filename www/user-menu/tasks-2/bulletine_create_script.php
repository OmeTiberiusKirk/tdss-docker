<?php
	session_start();

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
	$TH->getOutput($path_to_file_TH, "F");
	$EN->getOutput($path_to_file_EN, "F");
	if(file_exists($path_to_file_TH) && file_exists($path_to_file_EN)) {
		require_once('../../library/connectdb.inc.php');
		$sql = "INSERT INTO 
					`bulletin`(`uid`, `release_no`, `release_year`, `announce_date`, 
					`announce_time`, `eq_date`, `eq_time`, 
					`magnitude`, `depth_km`,
					`eq_area_lat`, `eq_area_long`, `th_path_filename`, `en_path_filename`, 
					`grp_id`, `from_result_id`, `create_datetime`) 
				VALUES(".$_SESSION['uid'].", ".$_POST['h_release'].", '".$_POST['h_year']."', '".$_POST['h_date']."', 
					'".$_POST['h_time']."', '".$_POST['eq_date']."', '".$_POST['eq_time']."', 
					'".$_POST['eq_richter']."', '".$_POST['eq_depth']."', 
					".$_POST['eq_lat'].", ".$_POST['eq_long'].", '".$path_to_file_TH."', '".$path_to_file_EN."', 
					".$_REQUEST['grp_id'].", ".$_REQUEST['from_result_id'].", '".time()."')";
		if(is_resource($connection)) {
			$result = mysql_query($sql, $connection) or die("! could not insert bulletin profile.");
		}
		echo "<script language=javascript>alert('! Create bulletin successful');</script>";
	}else
		echo "<script language=javascript>alert('! Create bulletin successful');</script>";
	echo "<script language=javascript>document.location.href='bulletin_release.php?section=4.1&grp_id=".$_REQUEST['grp_id']."';</script>";
?>