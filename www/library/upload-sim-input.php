<?php
	session_start();
	set_time_limit(0);

	require_once('connectdb.inc.php');
	require_once('ssh.class.php');
	require_once('function.inc.php');
	require_once('setting.inc.php');
	
	$start = microtime(true);
	
	echo "<pre>";
	//print_r($_FILES);
	//print_r($_POST);
	
	$param = array();
	
	$param['uid'] = $_SESSION['uid']; 
	$param['description'] = $_POST['description'];		
	
	if($_POST['filetype'] == 'deform')
	{
		$param['longtitude'] = $_POST['deform']['longtitude'];
		$param['latitude'] = $_POST['deform']['latitude'];
		$param['depth'] = $_POST['deform']['depth'];
		$param['strike'] = $_POST['deform']['strike'];
		$param['dip'] = $_POST['deform']['dip'];
		$param['moment_magnitude'] = $_POST['deform']['moment_magnitude'];
		$param['length'] = $_POST['deform']['length'];
		$param['width'] = $_POST['deform']['width'];
		$param['dislocation'] = $_POST['deform']['dislocation'];
		$param['maximum'] = $_POST['deform']['maximum'];
		$param['minimum'] = $_POST['deform']['minimum'];
	}else{
		
		$param['longtitude'] =  $_POST['region']['longtitude'];
		$param['latitude'] = $_POST['region']['latitude'];
		$param['gridsize_x'] = $_POST['region']['gridsize_x'];
		$param['gridsize_y'] = $_POST['region']['gridsize_y'];
		$param['time_interval'] = $_POST['region']['time_interval'];
		$param['grids_no'] = $_POST['region']['grids_no'];
		$param['depth_max'] = $_POST['region']['depth_max'];
	}
	
	$param['save_path'] = "../workspace/simulation-data/";
	
	if ($_POST['ds'] == 'local' && $_FILES["fileform"]["name"])
	{
		switch($_FILES['fileform']['error'])
		{
			case UPLOAD_ERR_OK :
			
				$tmp_name = $_FILES["fileform"]["tmp_name"];
				
				if (strlen($_POST['new_filename']) >= 1 ) 
					$param['orgname'] = $_POST['new_filename'];
				else 
					$param['orgname'] = $_FILES["fileform"]["name"];
					
				$param['aliasname'] = generateRanString();
				
				if ( ! move_uploaded_file($tmp_name, $param['save_path'].$param['aliasname']))
					JSAlert("Error : Could not move uploaded file from ".$tmp_name." to data bank.", "../user/user.datasource.php?secion=4");
				break;	
		}
	}
	
	if($_POST['ds'] == 'cluster')
	{
		$dsn['string'] = $_POST['dsn'];
		$dsn['username'] = strtok($dsn['string'], ":");
		$dsn['password'] = strtok("@");
		$dsn['hostname'] = strtok(":");
		$dsn['filepath'] = strtok("\n");
		
		$remote = new SSH;
		$remote->connect($dsn['hostname'], $port = 22, $dsn['username'], $dsn['password']);
		if($remote->isError())
		{
			echo $remote->getError();
		}else
		{
			$dsn_t = $dsn['filepath'];
			$t[] = strtok($dsn_t, "/");
			
			while($t[] = strtok("/"));

			if (strlen($_POST['new_filename']) >= 1 )
				$param['orgname'] = $_POST['new_filename'];
			else
				$param['orgname'] = $t[count($t)-2];
			
			$param['aliasname'] = generateRanString();
			
			$remote->remoteCopyFile($dsn['filepath'], "->", $param['save_path'].$param['aliasname']);
			if($remote->isError())
				echo $remote->getError();
		}
	}
	
	if ($_POST['ds'] == 'url')
	{
		require_once('function.inc.php');
		
		$url_filename = $_POST['url'];
		$t[] = strtok($url_filename, "/");
		while($t[] = strtok("/"));
		
		$filename = $t[count($t)-2];
		
		if (strlen($_POST['new_filename']) >= 1 )
			$param['orgname'] = $_POST['new_filename'];
		else
			$param['orgname'] = $filename;
			
		$param['aliasname'] = generateRanString();
	
		$handle = @fopen($_POST['url'], 'rb');
		$contents = '';
		
		//$contents = stream_get_contents($handle);
		$append_handle = fopen($param['save_path'].$param['aliasname'], 'ab');
		while (!feof($handle)) 
		{
			$contents = fread($handle, 10240000);
			if (fwrite($append_handle, $contents) === FALSE)
			{
				echo "error write file.\n";	
				exit;
			}
		}
		fclose($append_handle);
		fclose($handle);
	}
	

	
	save_upload_simulaton_inputfile($param, $connection, $_POST['filetype']);
	
	echo "</pre>";
?>


