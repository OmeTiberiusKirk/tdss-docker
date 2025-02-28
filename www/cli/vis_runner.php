<?php
	session_start();
	
	require_once('../../library/zip.lib.php');
	require_once('../../library/ssh.class.php');
	require_once('../../library/setting.inc.php');
	
	echo "<pre>";
	
	$vis_local_path = $_SESSION['vis_path'];
	$vis_filelist = $_SESSION['vis_filelist'];
	$vis_network_pathfile = $_SESSION['network_pathfile'];
	$vis_type = $_SESSION['vis_type'];
	$dir_image = $_SESSION['dir_image'];
	
	$s_dir = time();
	$local_temp_dirname = "_tmp/".$s_dir;
	mkdir($local_temp_dirname) or die("! death on ".__LINE__."->".__FILE__);
	
	/* zip data file */
	$cl = array();	
	foreach($vis_filelist as $index => $path_to_filename) {
		$z = new zipfile();
		$n = explode("/", $path_to_filename);
		$z->add_file($path_to_filename, $n[count($n)-1]);
		$n_t = explode(".", $n[count($n)-1]);
		$z_filename = $local_temp_dirname."/".$n_t[0].".zip";
		$local_zip_list[] = $z_filename;
		$remote_zip_list[] = $n_t[0].".zip";
		$cl[] = $z_filename;
		$fd = fopen ($z_filename, "wb");
		$out = fwrite ($fd, $z->file());
		fclose ($fd);
		sleep(0.1);
	}
	
	/* copy .net */
	$network_filelist = array();
	foreach($vis_network_pathfile as $index => $path_to_file) {
		$n = explode("/", $path_to_file);
		copy($path_to_file, $local_temp_dirname."/".$n[count($n)-1]);
		$netfile[$n[count($n)-1]] = $local_temp_dirname."/".$n[count($n)-1];
		$network_filelist[] = $n[count($n)-1];
	}

	/* xfer to server */
	$ssh = new SSH();
	$ssh->connect($run_at['hostname'], $run_at['username'], $run_at['password'], $port = 22);
	
	/* making the directory of workspace */
	$ssh->makeDirectory($run_at['working_dir']."/", $s_dir);

	/* make directory of images's storage */
	foreach($dir_image as $index => $dir_name) {
		$dir = $run_at['working_dir']."/".$s_dir."/".$dir_name;
		$ssh->makeDirectory($dir);
	}
	
	$remote_cwd = $run_at['working_dir']."/".$s_dir."/";

	/* copy of data.zip files to remote workspace */
	foreach($local_zip_list as $index => $local_filename) {
		$ssh->remoteCopyFile($remote_cwd.$remote_zip_list[$index], "<-", $local_filename);
	}
	
	/* copy networks of modules to remote workspace */
	foreach($netfile as $filename => $localpath_filename) {
		$ssh->remoteCopyFile($remote_cwd.$filename, "<-", $localpath_filename);
	}
	
	/* create shellscript of running the visualization */
	$p1 = $_SESSION['import'][1];
	$p3 = $_SESSION['import'][3];	
	if(!file_exists($template['sh_script'])) {
		die("! could not locate run script.");
	} else {
		
		$unzip_str = "";
		$net_str = "";
	
		$SH_template_contents = file_get_contents($template['sh_script']);
		foreach($remote_zip_list as $index => $zip_filename) {
			$unzip_str .= "unzip ".$zip_filename."\n";
		}
		$SH_template_contents = str_replace("UNZIP_ALLFILES", $unzip_str, $SH_template_contents);
		
		foreach($network_filelist as $index => $net_filename) {
			$net_str .= "dx -memory 1024 -script ".$net_filename."\n";
		}
		$SH_template_contents = str_replace("RUN_DX", $net_str, $SH_template_contents);
		
		$i = 0;
		foreach($dir_image as $index => $dir_name) {
			$img_str[$i] = "for i in `ls ".$dir_name."/`\n";
			$img_str[$i] .= "do\n";
			$img_str[$i] .= "\tconvert ".$dir_name."/\$i -trim ".$dir_name."/\$i.png\n";
			$img_str[$i] .= "done\n";
			$img_str[$i++] .= "rm -rf ".$dir_name."/*.tiff\n\n";
		}
		$SH_template_contents = str_replace("IMAGE_OPERATIONS", implode("", $img_str), $SH_template_contents);		
	}
	
	file_put_contents($local_temp_dirname."/run.sh", $SH_template_contents);
	
	/* copy shellscript to remote workspace */
	$ssh->remoteCopyFile($remote_cwd."run.sh", "<-", $local_temp_dirname."/run.sh", 0777);
	
	/* delete temporary directory */
	if(strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
		exec("echo Y | rd /s ".$local_temp_dirname);
	else
		exec("rm -rf ".$local_temp_dirname);		
	
	/* run script for downloading the input data from portal */
	sleep(0.5);
	$cmd = $remote_cwd."run.sh";
	$ssh->executeSH("cd ".$remote_cwd.";".$cmd);

	/* copy back */
	$img_path = realpath($vis_local_path."/visualization");
	$img_pathfile = $img_path."/image.tar.gz";
	$remote_file = $remote_cwd."image.tar.gz";
	#$ssh->remoteCopyFile($remote_cwd."image.tar.gz", "->", $img_pathfile);
	
	/* Mod for standalone */
	if(file_exists($remote_file)) {
		copy($remote_file, $img_pathfile);
	}else {
		die("! No images output.");
	}
	
	require_once('../../library/zlib-extractor.class.php');
	$ArchiveFilename = $img_pathfile;
	$DestinationPath = $img_path;

	$tar = new TAR($ArchiveFilename, $DestinationPath);
	$tar->extractAll();	
	
	unlink($ArchiveFilename);
	$ssh->executeSH("rm -rf ".$run_at['working_dir']."/".$s_dir);
	echo "</pre>";
	echo "<script language=javascript>location.href='result.php?section=3&grp_id=".$_REQUEST['grp_id']."';</script>";

?>
