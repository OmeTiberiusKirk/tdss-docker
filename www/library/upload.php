<?php
	session_start();
	
	/* set unlimit timeout */
	set_time_limit(0);

	/* require for database connection */
	require_once('connectdb.inc.php');
	
	/* require for secure shell to cluster, grid trusted host and visualier */
	require_once('ssh.class.php');
	
	/* require for generateRanString(), formulateData() and saveUploadedFileInfo() */
	require_once('function.inc.php');
	
	/* require for site configuration */
	require_once('setting.inc.php');
	
	/* staring up of the stop watch */
	$start = microtime(true);
	
	/* print HTML preset for easy debugging */
	echo "<pre>";
	
	/* setting the debugging message collector */
	/* in setting.inc.php, the $debug['formulate'] is equal true */
	/* then this system will print debug message*/
	$debug_string = array();
	$debug_string[] = $script_name."@".__LINE__.": incomming \$_POST ";

	/* assign the neccessary data formulation parameters */
	$param['uid'] = $_SESSION['uid'];
	$param['description'] = $_POST['description'];
	$param['region'] = $_POST['region'];
	$param['series'] = $_POST['series'];
	$param['time_step'] = $_POST['time_step'];
	$param['grid_size_x'] = $_POST['grid_size_x'];
	$param['grid_size_y'] = $_POST['grid_size_y'];
	$param['data_order'] = $_POST['data_order'];
	$param['save_path'] = "../workspace/".$_SESSION['username']."/files/Data_Source/Visualization/";

	/* setting current script name for debugging */
	$a = $_SERVER['SCRIPT_NAME'];
	$a = explode("/", $a);
	$script_name = $a[3];
	
	/* assign debug message */
	$debug_string[] = $script_name."@".__LINE__.": assign the neccessary data formulation parameters.";
	
	
	/**************************************************/
	/* If select the data source is CLIENT LOCAL DISK */
	/**************************************************/
	if ($_POST['ds'] == 'local' && $_FILES["fileform"]["name"])
	{
		/* lookup to the file uploaded error or not */
		$debug_string[] = $script_name."@".__LINE__.": data source is local disk.";
		switch($_FILES['fileform']['error'])
		{
			case UPLOAD_ERR_OK :
			
				/* if not error*/
				$debug_string[] = $script_name."@".__LINE__.": file uploading is OK.";
				$tmp_name = $_FILES["fileform"]["tmp_name"];
				
				if (strlen($_POST['new_filename']) >= 1 ) 
					$param['orgname'] = $_POST['new_filename'];
				else 
					$param['orgname'] = $_FILES["fileform"]["name"];
				
				/* create random string for alias name */
				/* generateRanString() in function.inc.php */
				$param['aliasname'] = generateRanString();
				$debug_string[] = $script_name."@".__LINE__.": generate random string for alias name, `".$param['aliasname']."`";
				
				/* move upload file from php's temporary directory to site's directory */
				if ( ! move_uploaded_file($tmp_name, $param['save_path'].$param['aliasname']))
					JSAlert("Error : Could not move uploaded file from ".$tmp_name." to data bank.", "../user/user.datasource.php?secion=4");
				else
					$debug_string[] = $script_name."@".__LINE__.": move upload file from php's temp to `".$param['save_path']."` successful.";
				break;	
			
			/*if error for uploading file */
			case UPLOAD_ERR_INI_SIZE :
				JSAlert("The uploaded file exceeds the", "../user/user.datasource.php?secion=4");
				break;
				
			case UPLOAD_ERR_FORM_SIZE :
				JSAlert("The uploaded file exceeds", "../user/user.datasource.php?secion=4");
				break;
				
			case UPLOAD_ERR_PARTIAL :
				JSAlert("The uploaded file was only partially uploaded", "../user/user.datasource.php?secion=4");
				break;
				
			case UPLOAD_ERR_NO_FILE :
				JSAlert("No file was uploaded.", "../user/user.datasource.php?secion=4");
				break;
				
			case UPLOAD_ERR_NO_TMP_DIR :
				JSAlert("Missing a temporary folder.", "../user/user.datasource.php?secion=4");
				break;
				
			case UPLOAD_ERR_CANT_WRITE :
				JSAlert("Failed to write file to disk.", "../user/user.datasource.php?secion=4");
				break;	
				
			case UPLOAD_ERR_EXTENSION :
				JSAlert("File upload stopped by extension.", "../user/user.datasource.php?secion=4");
				break;	
		}
	}
	
	/*************************************************/
	/* If select the data source is CLUSTER MACHINE. */
	/*************************************************/
	if($_POST['ds'] == 'cluster')
	{
		$debug_string[] = $script_name."@".__LINE__.": data source is cluster.";
	
		/* cutting of dsn */	
		$dsn['string'] = $_POST['dsn'];
		$dsn['username'] = strtok($dsn['string'], ":");
		$dsn['password'] = strtok("@");
		$dsn['hostname'] = strtok(":");
		$dsn['filepath'] = strtok("\n");
		
		$debug_string[] = $script_name."@".__LINE__.": extract DSN ";
		
		/* create instance of SSH for connecting to cluster machine */
		/* SSH classs in ssh.class.php */
		$remote = new SSH;
		$debug_string[] = $script_name."@".__LINE__.": create SSH instance";
		
		/* connect to cluster with hostname, username and password on port = 22 */
		$remote->connect($dsn['hostname'], $port = 22, $dsn['username'], $dsn['password']);
		$debug_string[] = $script_name."@".__LINE__.": connect to ".$dsn['hostname']." with username = '".$dsn['username']."', password = '".$dsn['password']."' ";
		
		/* check for connecting error */
		if($remote->isError())
		{
			$debug_string[] = $script_name."@".__LINE__.": connect error";
			
			/* get mesage if error*/
			echo $remote->getError();
		}else
		{
			/* if connect successful */
			$debug_string[] = $script_name."@".__LINE__.": connect success";
			
			$dsn_t = $dsn['filepath'];
			$t[] = strtok($dsn_t, "/");
			
			while($t[] = strtok("/"));

			/* if user want to rename file */
			if (strlen($_POST['new_filename']) >= 1 )
				$param['orgname'] = $_POST['new_filename'];
			else
				/* if user don't want to rename file */
				$param['orgname'] = $t[count($t)-2];
			
			$debug_string[] = $script_name."@".__LINE__.": original filename : ".$param['orgname']."";
			
			/* generate alias name for referencing */
			$param['aliasname'] = generateRanString();
			$debug_string[] = $script_name."@".__LINE__.":  create alias filename : ".$param['aliasname']."";
			$param['data_local_path'] = $param['save_path'].$param['aliasname'];
			/* copy file from specified cluster to file server which described in $param['save_path'] */
			$remote->remoteCopyFile($dsn['filepath'], "->", $param['data_local_path']);
			$debug_string[] = $script_name."@".__LINE__.": copy file from cluster, `".$dsn['filepath']."` to `".$param['save_path'].$param['aliasname']."`";
			
			/* if copy file is error */
			if($remote->isError())
				echo $remote->getError();
			else
				/* if not error */
				$debug_string[] = $script_name."@".__LINE__.": copy success ";
				
			$debug_string[] = $script_name."@".__LINE__.": copy file from cluster to formulated directory successfull";
		}
	}
	
	/***************************
	/* If data source is GRID */
	/**************************/
	if($_POST['ds'] == 'grid')
	{
		$debug_string[] = $script_name."@".__LINE__.": data source is grid.";
		
		/* extract the grid dsn */
		$gdsn['string'] = $_POST['grid_dsn'];
		$gdsn['hostname'] = strtok($gdsn['string'], ":");
		$gdsn['filepath'] = strtok("\n");
		 
		$debug_string[] = $script_name."@".__LINE__.": extract Grid DSN ";
		
		 /* select default grid trusted host account */
		$sql =  "SELECT * FROM grid_trust WHERE uid = ".$_SESSION['uid']." AND status = 1;";
		
		/* query into database */
		$result = mysql_query($sql, $connection);
		
		/* the result must returned 1 row */
		if (mysql_num_rows($result) == 1 )
		{
			/* the $row collect $row->hostname, $row->username and $row->password */
			$row = mysql_fetch_object($result); 
			if($row)
				$debug_string[] = $script_name."@".__LINE__.": select Grid Trusted Host from database ";
		}
		
		/* create SSH instance, in ssh.class.php */
		$remote = new SSH;
		$debug_string[] = $script_name."@".__LINE__.": create SSH instance for connecting to Grid Trusted Host";
		
		/* connect to Grid Trusted Host with $row->? above */
		$remote->connect($row->hostname, $port = 22, $row->username, $row->password);
		$debug_string[] = $script_name."@".__LINE__.": connecting to `".$row->hostname."` with username = `".$row->username."`, password = `".$row->password."`";
		
		/* if connection failed then print error message */
		if($remote->isError())
		{
			$debug_string[] = $script_name."@".__LINE__.": connection error ".$remote->getError();
			echo $remote->getError();
		}else
		{
			$debug_string[] = $script_name."@".__LINE__.": connecting success";
			
			/* if not eror then :) */
			$gdsn_t = $gdsn['filepath'];
			
			/* cutting dsn for getting the file name */
			$t[] = strtok($gdsn_t, "/");	
			while($t[] = strtok("/"));

			/* check rename file input box on form */
			if (strlen($_POST['new_filename']) >= 1 )
				$param['orgname'] = $_POST['new_filename'];
			else
				/* if don't want to rename the file */
				$param['orgname'] = $t[count($t)-2];
			
			$debug_string[] = $script_name."@".__LINE__.": setting original file name as `".$param['orgname']."`";
			
			/* generate the aliasname */
			$param['aliasname'] = generateRanString();
			$debug_string[] = $script_name."@".__LINE__.": generate random string for alias file name"; 
			
			$debug_string[] = $script_name."@".__LINE__.": downloading specified file from grid";
			
			/* get file from grid */
			$remote->gridDownloadFile($gdsn['filepath'], $gdsn['hostname'], $param['aliasname'], & $debug_string);
	
			/* checking downloading file is error */
			if($remote->isError())
				/* get error */
				echo $remote->getError();
			else
				/* if no error */
				$debug_string[] = $script_name."@".__LINE__.": download file from grid successful";
		}
	
	}
	
	/**************************************/
	/* If data source is DOWNLOADABLE URL */
	/**************************************/
	if ($_POST['ds'] == 'url')
	{
		$debug_string[] = $script_name."@".__LINE__.": data source is downloadable URL";
		
		require_once('function.inc.php');
		
		/* extract URL for getting the filename */
		$url_filename = $_POST['url'];
		$t[] = strtok($url_filename, "/");
		while($t[] = strtok("/"));
		
		/* cut tail of file */
		$filename = $t[count($t)-2];
		
		/* if user want to rename the file */
		if (strlen($_POST['new_filename']) >= 1 )
			/* assing new filename */ 
			$param['orgname'] = $_POST['new_filename'];
		else
			/* if no defined the new file*/
			$param['orgname'] = $filename;
			
		$debug_string[] = $script_name."@".__LINE__.": seting original file name is `".$param['orgname']."`";	
		
		/* generate the random string for reference the formulated file */
		$param['aliasname'] = generateRanString();
		$debug_string[] = $script_name."@".__LINE__.": generate random string for alias file name, `".$param['aliasname']."`";
		
		/* remote file opening */
		$handle = @fopen($_POST['url'], 'rb');
		$debug_string[] = $script_name."@".__LINE__.": remote open file `".$_POST['url']."`";
		
		$contents = '';
		
		/* open new file for collecting */
		$append_handle = fopen($param['save_path'].$param['aliasname'], 'ab');
		$debug_string[] = $script_name."@".__LINE__.": create file in local `".$param['save_path'].$param['aliasname']."`";
		$debug_string[] = $script_name."@".__LINE__.": reading contents";
		
		/* reading the remote file */
		while (!feof($handle)) 
		{
			$contents = fread($handle, 10240000);
			if (fwrite($append_handle, $contents) === FALSE)
			{	
				/* if reading file was error */
				echo "error write file.\n";	
				exit;
			}
		}
		$debug_string[] = $script_name."@".__LINE__.": reading contents is successful, and close file";
		
		/* close file handler */
		fclose($append_handle);
		fclose($handle);
	}
	
	
	/***********************************/
	/* THIS IS THE FORMULATION PROCESS */
	/***********************************/
	
	/* call formulateData() function in function.inc.php */
	$flag = formulateData($param, & $debug_string);	
	if($flag == true )
		$debug_string[] = $script_name."@".__LINE__.": formulated file has been created";
	
	/* ending of the stop watch */
	$end = microtime(true);
	
	/* calculate total time has been used */
	$total_time = $end - $start;
	
	/* getting the original name for saving into database for user readable.*/
	$org_filename = $param['orgname'];
	$t = strtok($org_filename, ".");
	
	/* concat original file name with dx extension*/
	$param['orgname'] = $t.".dx";
	
	/* append debug */
	$debug_string[] = $script_name."@".__LINE__.": renew file extension as .dx (".$param['orgname'].")";
	
	/* if formulation process was successful */
	if($flag == true)
	{
		/* save information to database */
		/* In below function, system will print the debug message, */
		/* when debug's flag is set in the settting.inc.php, */
		/* if not the system will execute the Alert box of JavaScript */
		saveUploadedFileInfo($total_time, $param, $connection, $debug['formulate']);
		
		/* append debug */
		$debug_string[] = $script_name."@".__LINE__.": save information to database already";
		
		/* if debug's flag is set on the setting.inc.php */
		if ($debug['formulate'] == true)
		{
			/* print debug message */
			echo "<h2>Debug</h2>";
			foreach($debug_string as $value)
				echo $value."\n";
		}
	}else 
	{
		/* if formulation process was failed */
		$delete_filepath = $param['save_path'].$param['aliasname'];
		
		/* delete uploaded file on save path */
		unlink($delete_filepath);
		
		/* append debug */
		$debug_string[] = $script_name."@".__LINE__.": delete temporary, if failed";
		
		if ($debug['formulate'] == true)
		{
			/* print debug message */
			echo "<h2>Debug</h2>\n";
			foreach($debug_string as $value)
				echo $value."\n";		
		}	
		echo "\n[Process Failed]\n";	
		echo "<input type=\"button\" value=\"Back\" onclick=\"javascript: history.back();\">";
	} 
     
	/* print HTML preset close tag */
	echo "</pre>";
?>


