<?php
	session_start();
	
	echo "<pre>";
	
	require_once('connectdb.inc.php');
	require_once('function.inc.php');
	
	$param = array();
	$param['uid'] = $_SESSION['uid'];
	$param['name'] = $_POST['name'];
	$param['description'] = $_POST['description'];
	$param['np'] = $_POST['np'];
	$param['run_at'] = $_POST['dsn'];
	$param['domain'] = $_POST['domain'];
	$param['source'] = $_POST['tsunami_source'];
	$param['observ_area'] = $_POST['tsunami_observation_area'];
	$param['exe_filename'] = $_POST['exe_filename'];
	$param['mpich_home'] = $_POST['mpich_home'];
	$param['fortran_compiler'] = $_POST['fortran_compiler'];
	$param['fortran_lib'] = $_POST['library'];
	$param['mpi_c_compiler'] = $_POST['mpi_c_compiler'];
	$param['log_filename'] = $_POST['log_filename'];
	$param['deform_file'] = implode(",", $_POST['deform_filename']);
	$param['region_file'] = implode(",", $_POST['region_filename']);
	
	$sql = "INSERT INTO 
				simulation(
					uid, name, description, np, run_at, domain, source, observ_area, exe_filename,
					mpich_home, fortran_compiler, fortran_lib, mpi_c_compiler, log_filename, deform_file, region_file, date)
				VALUES(
					'".$param['uid']."', 
					'".$param['name']."', 
					'".$param['description']."', 
					'".$param['np']."', 
					'".$param['run_at']."', 
					'".$param['domain']."', 
					'".$param['source']."', 
					'".$param['observ_area']."', 
					'".$param['exe_filename']."',
					'".$param['mpich_home']."', 
					'".$param['fortran_compiler']."', 
					'".$param['fortran_lib']."', 
					'".$param['mpi_c_compiler']."', 
					'".$param['log_filename']."', 
					'".$param['deform_file']."', 
					'".$param['region_file']."', 
					'".time()."')";
	
	echo $sql;
	$result = mysql_query($sql, $connection);
	
	sleep(5);
	
	redirect_page('../user/user.simulate.php?section=1');
	
	echo "</pre>";
?>