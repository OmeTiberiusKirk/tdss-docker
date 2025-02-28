<?php
	session_start();
	/*
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	exit;
	*/
	require_once('lib.bulletin-th.php');
	$b = new Bulletin();
	
	/* function assignHeaderInfo($release_no, $year_release, $announce_date, $announce_time) */
	$b->assignHeaderInfo($_POST['h_release'], $_POST['h_year'], $_POST['h_date'], $_POST['h_time']);
		
	/* function assignEqInfo($eq_date, $eq_time, $richter, $depth) */
	$b->assignEqInfo($_POST['eq_date'], $_POST['eq_time'], $_POST['eq_richter'], $_POST['eq_depth']);
	
	/* function assignEqLocation($latitude, $longitude, $area, $distance, $coastname) */
	$b->assignEqLocation($_POST['eq_lat'], $_POST['eq_long'], $_POST['eq_area'], $_POST['eq_distance'], $_POST['eq_coastname']);
	
	/* function assignObservationArea($province, $area, $eta_value, $zmax_value) */
	foreach($_POST['ob']['province'] as $id => $p_name) {
		$b->assignObservationArea($p_name, $_POST['ob']['area'][$id], $_POST['ob']['eta'][$id], $_POST['ob']['zmax'][$id]);
	}

	/* run ! */	
	//echo "<pre>";
	$b->Create();
	//echo "</pre>";
	
	/* get PDF */
	$filename = $_POST['h_release']."_".$_POST['h_year']."_".str_replace("/", "_", $_POST['h_date'])."_".str_replace(":", "_", $_POST['h_time']);
	$path_to_file = "../../workspace/".$_SESSION['username']."/files/Bulletin/".$filename."_thai.pdf";
	$b->getOutput($path_to_file, "F");
	if(file_exists($path_to_file)) {
		require_once('../../library/connectdb.inc.php');
		$sql = "INSERT INTO 
					`bulletin`(`uid`, `release_no`, `release_year`, `announce_date`, 
					`announce_time`, `eq_date`, `eq_time`, 
					`magnitude`, `depth_km`, 
					`eq_area_lat`, `eq_area_long`, `eq_area_name`, 
					`eq_distance_km`, `th_coast_name`, `path_filename`) 
				VALUES(".$_SESSION['uid'].", ".$_POST['h_release'].", '".$_POST['h_year']."', '".$_POST['h_date']."', 
					'".$_POST['h_time']."', '".$_POST['eq_date']."', '".$_POST['eq_time']."', 
					'".$_POST['eq_richter']."', '".$_POST['eq_depth']."', 
					".$_POST['eq_lat'].", ".$_POST['eq_long'].", '".$_POST['eq_area']."', 
					'".$_POST['eq_distance']."', '".$_POST['eq_coastname']."', '".$path_to_file."')";
		if(is_resource($connection)) {
			$result = mysql_query($sql, $connection) or die("! could not insert bulletin profile.");
		}
		echo "<script language=javascript>alert('! Create the bulletin successful');</script>";
	}else
		echo "<script language=javascript>alert('! Create the bulletin successful');</script>";
	echo "<script language=javascript>document.location.href='bulletin_release.php?section=4.1';</script>";
?>