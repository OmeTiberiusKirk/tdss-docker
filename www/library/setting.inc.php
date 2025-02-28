<?php
	#define("MAIN_TEMPLATE_PATH", "/home/ndwc/wwwroot/deploy-v1/");
	define("MAIN_TEMPLATE_PATH", "/home/ndwc/wwwroot/deploy-v2-cli/tsunami_cli/");
	define("TEMPLATE_DIR", MAIN_TEMPLATE_PATH."Templates/");
	define("FORMULATION_TEMPLATE_DIR", TEMPLATE_DIR."formulation/");
	define("VISUALIZATION_TEMPLATE_DIR", TEMPLATE_DIR."visualization/");
	define("WAVE_ANIMATION_TEMPLATE_DIR", VISUALIZATION_TEMPLATE_DIR."wave-animation/");
	define("HEIGHT_TEMPLATE_DIR", VISUALIZATION_TEMPLATE_DIR."height/");
	define("DEPTH_TEMPLATE_DIR", VISUALIZATION_TEMPLATE_DIR."depth/");
	define("VELOCITY_TEMPLATE_DIR", VISUALIZATION_TEMPLATE_DIR."velocity/");
	define("TIME_HISTORY_TEMPLATE_DIR", VISUALIZATION_TEMPLATE_DIR."time-history/");
	define("HEIGHT_COASTLINE_TEMPLATE_DIR", VISUALIZATION_TEMPLATE_DIR."height-coastline/");
	define("ARRIVAL_TIME_TEMPLATE_DIR", VISUALIZATION_TEMPLATE_DIR."arrival-time/");
	define("TEMP_DIR", "../tmp/");

	/* portal address*/
	/* COUTION !! (1) */
	//$hostname = "192.168.136.127";
	#$hostname = "161.200.92.186";
	#$host_addr_dir = "http://".$hostname."/tsunami-portal/";

	/* database */
	/* CAUTION !! (2) */
	$db['hostname'] = "tdss-database";
	// $db['hostname'] = "ldap.facgure.com";
	// $db['hostname'] = "172.17.0.2";
	// $db['hostname'] = "localhost";
	$db['username'] = "root";
	#$db['password'] = "JVg7sT6q";
	$db['password'] = "1q2w3e4r";
	/* $db['db_name'] = "tsunami_cli"; */
	$db['db_name'] = "tdssdb";

	/* visualizer */
	/* CAUTION !! (3) */
	//$visualizer['hostname'] = "horizon.cp.eng.chula.ac.th";
	$run_at['hostname'] = "127.0.0.1";
	#$run_at['hostname'] = "161.200.92.164";
	$run_at['username'] = "ndwc";
	$run_at['password'] = "ndwc2009";
	//$visualizer['password'] = "yod";
	$run_at['working_dir'] = "/home/ndwc/RUN_WORKSPACE";

	#$this_host['ip'] = "58.9.228.172";
	#$this_host['working_dir'] = "/tsunami/v8";


	/* support type = 'fedora', 'centos' for managing the style of `ls`'s column */
	$visualizer['os'] = 'fedora';
	//$visualizer['os'] = 'centos';

	/* data formulation necessary template file */
	$template['location']['network_file'] = FORMULATION_TEMPLATE_DIR."file.net";
	$template['location']['general_file'] = FORMULATION_TEMPLATE_DIR."file.general";
	$template['location']['run_file'] = FORMULATION_TEMPLATE_DIR."run.sh";

	$template['sh_script'] = VISUALIZATION_TEMPLATE_DIR."run.sh";
	$template['sh_convert'] = VISUALIZATION_TEMPLATE_DIR."convert.sh";
	$template['wave-animation']['2d']['4'] = WAVE_ANIMATION_TEMPLATE_DIR;
	$template['wave-animation']['3d']['4'] = WAVE_ANIMATION_TEMPLATE_DIR;

	$template['velocity']['3d']['1'] = VELOCITY_TEMPLATE_DIR."velocity-3d-r1.net";
	$template['velocity']['3d']['2'] = VELOCITY_TEMPLATE_DIR."velocity-3d-r2.net";
	$template['velocity']['3d']['3'] = VELOCITY_TEMPLATE_DIR."velocity-3d-r3.net";
	$template['velocity']['3d']['4'] = VELOCITY_TEMPLATE_DIR."velocity-3d-r4.net";

	$template['velocity']['2d']['1'] = VELOCITY_TEMPLATE_DIR."velocity-2d-r1.net";
	$template['velocity']['2d']['2'] = VELOCITY_TEMPLATE_DIR."velocity-2d-r2.net";
	$template['velocity']['2d']['3'] = VELOCITY_TEMPLATE_DIR."velocity-2d-r3.net";
	$template['velocity']['2d']['4'] = VELOCITY_TEMPLATE_DIR."velocity-2d-r4.net";

	$template['depth']['3d']['1'] = DEPTH_TEMPLATE_DIR."depth-3d-r1.net";
	$template['depth']['3d']['2'] = DEPTH_TEMPLATE_DIR."depth-3d-r2.net";
	$template['depth']['3d']['3'] = DEPTH_TEMPLATE_DIR."depth-3d-r3.net";
	$template['depth']['3d']['4'] = DEPTH_TEMPLATE_DIR."depth-3d-r4.net";

	$template['depth']['2d']['1'] = DEPTH_TEMPLATE_DIR."depth-2d-r4.net";
	$template['depth']['2d']['2'] = DEPTH_TEMPLATE_DIR."depth-2d-r4.net";
	$template['depth']['2d']['3'] = DEPTH_TEMPLATE_DIR."depth-2d-r4.net";
	$template['depth']['2d']['4'] = DEPTH_TEMPLATE_DIR."depth-2d-r4.net";

	/* ETA */
	$template['G1']['arraival-time']['3d']['1'] = ARRIVAL_TIME_TEMPLATE_DIR."eta-1-8-aundaman.net";
	$template['G1']['arraival-time']['3d']['2'] = ARRIVAL_TIME_TEMPLATE_DIR."eta-2-8-aundaman.net";
	$template['G2']['arraival-time']['3d']['1'] = ARRIVAL_TIME_TEMPLATE_DIR."eta-1-8-aowthai.net";
	$template['G2']['arraival-time']['3d']['2'] = ARRIVAL_TIME_TEMPLATE_DIR."eta-2-8-aowthai.net";
	$template['arraival-time']['3d']['3'] = ARRIVAL_TIME_TEMPLATE_DIR."ETA-3D-R3.net";
	$template['arraival-time']['3d']['4'] = ARRIVAL_TIME_TEMPLATE_DIR."ETA-3D-R4.net";

	$template['arraival-time']['2d']['1'] = ARRIVAL_TIME_TEMPLATE_DIR."elapsed-time-2d-r1.net";
	$template['arraival-time']['2d']['2'] = ARRIVAL_TIME_TEMPLATE_DIR."elapsed-time-2d-r2.net";
	$template['arraival-time']['2d']['3'] = ARRIVAL_TIME_TEMPLATE_DIR."elapsed-time-2d-r3.net";
	$template['arraival-time']['2d']['4'] = ARRIVAL_TIME_TEMPLATE_DIR."elapsed-time-2d-r4.net";

	/* ZMAX */
	$template['G1']['height']['3d']['1'] = HEIGHT_TEMPLATE_DIR."zmn-1-6-aundaman.net";
	$template['G1']['height']['3d']['2'] = HEIGHT_TEMPLATE_DIR."zmn-2-6-aundaman.net";
	$template['G2']['height']['3d']['1'] = HEIGHT_TEMPLATE_DIR."zmn-1-6-aowthai.net";
	$template['G2']['height']['3d']['2'] = HEIGHT_TEMPLATE_DIR."zmn-2-6-aowthai.net";
	$template['height']['3d']['3'] = HEIGHT_TEMPLATE_DIR."HEIGHT-3D-R3.net";
	$template['height']['3d']['4'] = HEIGHT_TEMPLATE_DIR."HEIGHT-3D-R4.net";

	$template['height']['2d']['1'] = HEIGHT_TEMPLATE_DIR."height-2d-r1.net";
	$template['height']['2d']['2'] = HEIGHT_TEMPLATE_DIR."height-2d-r2.net";
	$template['height']['2d']['3'] = HEIGHT_TEMPLATE_DIR."height-2d-r3.net";
	$template['height']['2d']['4'] = HEIGHT_TEMPLATE_DIR."height-2d-r4.net";

	$template['wave-animation']['2d']['1'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-2d-r1.net";
	$template['wave-animation']['2d']['2'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-2d-r2.net";
	$template['wave-animation']['2d']['3'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-2d-r3.net";
	$template['wave-animation']['2d']['4'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-2d-r4.net";

	$template['wave-animation']['3d']['1'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-3d-r1.net";
	$template['wave-animation']['3d']['2'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-3d-r2.net";
	$template['wave-animation']['3d']['3'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-3d-r3.net";
	$template['wave-animation']['3d']['4'] = WAVE_ANIMATION_TEMPLATE_DIR."wave-animation-3d-r4.net";

	$template['wave-animation']['3d']['sender'] = WAVE_ANIMATION_TEMPLATE_DIR."tiled-wave-3d-sender.net";
	$template['wave-animation']['3d']['receiver'] = WAVE_ANIMATION_TEMPLATE_DIR."tiled-wave-3d-receiver.net";

	$tmpfile_prefix = "tmp-";

	/* visualization output */
	$visout['image_name'] = "image";
	$visout['colorbar'] = "colorbar";
	$visout['delete_flag'] = false;

	/* formulation output */
	$formulate['delete_flag'] = false;

	/* enable debugging */
	$debug['formulate'] = true;

	/* local data source path */
	$_datasource['global_path'] = "";

?>
