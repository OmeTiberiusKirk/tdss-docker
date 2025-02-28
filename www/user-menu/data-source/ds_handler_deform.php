<?php
	session_start();
	set_time_limit(0);
?>
<pre>
<?php

	//print_r($_POST);
	//print_r($_FILES);
	//exit;

	if($_POST['input_type'] == "sim" && $_POST['data_type'] == "deform" && ($_POST['channel'] == "create_single_file" || $_POST['channel'] == "create_multiple_file") ) {
		require_once('../../library/class.deform.php');
		$ds_sim_path = "../../workspace/".$_SESSION['username']."/files/Data_Source/Simulation/Deformation_File/";
		ob_implicit_flush();
		if($_POST && strlen($_FILES['upload_fault']['name']) > 2) {
			$fp = fopen($_FILES['upload_fault']['tmp_name'], "r");
			if($fp) {
				$line_no = 0;
				while($line = fgets($fp, 128)) {
					if($line[0] != '%' && strlen($line) > 20 ) {
						$line_r[] = explode("\t", $line);
					}
				}
				fclose($fp);
			}
			$counter = count($line_r);
		}else {
			$counter = 1;			
		}
		
		# print_r($_POST);
		# print_r($_FILES);
		for($loop=0; $loop<$counter; $loop++) {
			require_once('../../library/connectdb.inc.php');
			if($counter != 1) {
				$_POST['new_filename'] = $line_r[$loop][1];
				$_POST['description'] = "";
				/*
				$_POST['deform']['glob_x_long'] = ;
				$_POST['deform']['glob_y_lat'] = ;
				$_POST['deform']['grid_space'] = ;
				$_POST['deform']['org_x'] = ;
				$_POST['deform']['org_y'] = ;
				$_POST['deform']['ds_sim_path'] = ;
				$_POST['deform']['coord_long_1'] = ;
				$_POST['deform']['coord_long_2'] = ;
				$_POST['deform']['coord_lat_1'] = ;
				$_POST['deform']['coord_lat_2'] = ;
				*/
				$_POST['fault_param']['length_fault'] = $line_r[$loop][2];
				$_POST['fault_param']['width_fault'] = $line_r[$loop][3];
				$_POST['fault_param']['epi_depth'] = $line_r[$loop][4];
				$_POST['fault_param']['dislocate'] = $line_r[$loop][5];
				$_POST['fault_param']['dip_angle'] = $line_r[$loop][6];
				$_POST['fault_param']['strike_angle'] = $line_r[$loop][7];
				$_POST['fault_param']['rake_angle'] = $line_r[$loop][8];
				$_POST['fault_param']['long_epi'] = $line_r[$loop][9];
				$_POST['fault_param']['lat_epi'] = str_replace("\r\n", "", $line_r[$loop][10]);
			}
						/* check duplicate */
			$sql = "SELECT * FROM ds_input_deform WHERE filename LIKE '".$_POST['new_filename']."'";
			$result = mysql_query($sql, $connection);
			if(mysql_num_rows($result) > 0) {
				echo "<script language=javascript>alert('Duplicate file name !'); history.back();</script>"; 
				exit;
			}
			
			if($_POST['deform']['update_config_profile']) {
				$sql = "UPDATE ds_config_deform SET ";
				$sql .= "glob_x_long = '".$_POST['fault_conf']['glob_x_long']."', ";
				$sql .= "glob_y_lat = '".$_POST['fault_conf']['glob_y_lat']."', ";
				$sql .= "org_x = '".$_POST['fault_conf']['org_x']."', ";
				$sql .= "org_y = '".$_POST['fault_conf']['org_y']."', ";
				$sql .= "coord_long_1 = '".$_POST['fault_conf']['coord_long_1']."', ";
				$sql .= "coord_long_2 = '".$_POST['fault_conf']['coord_long_2']."', ";
				$sql .= "coord_lat_1 = '".$_POST['fault_conf']['coord_lat_1']."', ";
				$sql .= "coord_lat_2 = '".$_POST['fault_conf']['coord_lat_2']."', ";
				$sql .= "create_date = '".time()."' WHERE id = 1";
				if(!mysql_query($sql, $connection))
					echo "! update_fault_profile error.\n";
			}
			
			if($_POST['deform']['update_fault_profile']) {
				$sql = "UPDATE ds_config_fault_param SET ";
				$sql .= "length = '".$_POST['fault_param']['length']."', ";
				$sql .= "length_fault = '".$_POST['fault_param']['length_fault']."', ";
				$sql .= "width_fault = '".$_POST['fault_param']['width_fault']."', ";
				$sql .= "epi_depth = '".$_POST['fault_param']['epi_depth']."', ";
				$sql .= "dislocate = '".$_POST['fault_param']['dislocate']."', ";
				$sql .= "dip_angle = '".$_POST['fault_param']['dip_angle']."', ";
				$sql .= "strike_angle = '".$_POST['fault_param']['strike_angle']."', ";
				$sql .= "rake_angle = '".$_POST['fault_param']['rake_angle']."', ";
				$sql .= "long_epi = '".$_POST['fault_param']['long_epi']."', ";
				$sql .= "lat_epi = '".$_POST['fault_param']['lat_epi']."', ";
				$sql .= "create_date = '".time()."' WHERE id = 1";
				if(!mysql_query($sql, $connection))
					echo "! update_fault_profile error.\n";
			}
			
			$save_info['description'] = $_POST['description'];
			$save_info['new_filename'] = $_POST['new_filename'];
			$save_info['deform'] = $_POST['fault_conf'];
		
			define("DEBUG_IMMEDIATE", 0);
			set_time_limit(0);
			
			/*
			print_r($_POST['fault_param']);
			print_r($_POST['fault_conf']);
			exit;
			*/
			
			/* time start of each fault */
			$fault_time_start = Timer::microtime_float();
			
			$IG = $_POST['fault_conf']['glob_x_long'];	# global no. of grid in x direction (longitude)
			$JG = $_POST['fault_conf']['glob_y_lat'];	# global no. of grid in y direction (latitude)
			
			$DS = $_POST['fault_conf']['grid_space'] ;  # grid spacing (min)
			$XG = $_POST['fault_conf']['org_x']; # orgin of x direction
			$YG = $_POST['fault_conf']['org_y']; # orgin of y direction
			
			/* specify input/output directory */
			$output_dir = $ds_sim_path;
			
			/* coordinate of cropped area */
			$long_1 = $_POST['fault_conf']['coord_long_1'];
			$long_2 = $_POST['fault_conf']['coord_long_2'];
			$lat_1 = $_POST['fault_conf']['coord_lat_1'];
			$lat_2 = $_POST['fault_conf']['coord_lat_2'];
		
			/* Start calculation */
			
			/* parameters of each fault */
			$L  = $_POST['fault_param']['length_fault']; # length fault (m)
			$W  = $_POST['fault_param']['width_fault']; # width fault (m)
			$HH = $_POST['fault_param']['epi_depth']; # epicenter depth (m)
			$D  = $_POST['fault_param']['dislocate']; # dislocation (m)
			$DL = $_POST['fault_param']['dip_angle']; # dip angle (degree)
			$TH = $_POST['fault_param']['strike_angle']; # strike angle (degree)
			$RD = $_POST['fault_param']['rake_angle']; # rake angle (degree)
			$X0 = $_POST['fault_param']['long_epi']; # longitude epicenter (degree, +E)
			$Y0 = $_POST['fault_param']['lat_epi']; # latitude epicenter (degree, +N, -S)
			
			/* open file for collecting the fault values (large map) */
			$def_fileout_name = $output_dir."tmp_".$_POST['new_filename'].'.dat';
			$pt_def_out = fopen($def_fileout_name, 'w');
		
			/* constant parameters */
			/* */
			$DR = $DS;
			/* (min)*/
			$LENGTH = $_POST['fault_conf']['length'];
			$A = 3.14159;
			$RR = 6.378E+6;
			$E = 1.7453E-2 ;
			
			/* initialization */
			$XO = $X0-$LENGTH ;
			$YO = $Y0-$LENGTH ;
			$IS = ($XO-$XG)*60/$DR ;
			$JS = ($YO-$YG)*60/$DR ;
			if ($IS < 2) $IS = 2;
			if ($JS < 2) $JS = 2;
			$IE = $IS+2*$LENGTH*60/$DR ;
			$JE = $JS+2*$LENGTH*60/$DR ;
			if ($IE > $IG-1) $IE = $IG-1;
			if ($JE > $JG-1) $JE = $JG-1;
		
			$XL = $A*$RR*($X0-$XO)*cos($E*$YO)/180.0 ;
			$YL = $A*$RR*($Y0-$YO)/180.0 ;
			$H1 = $HH/sin($E*$DL);         
			$H2 = $HH/sin($E*$DL)+$W ;
			$DSS = (-1)*$D*cos($E*$RD) ;
			$DD = $D*sin($E*$RD) ;
			echo "<br><hr><b>Processing step <span id='step".$loop."'></span> of 4</b> (Filename:&nbsp;".$_POST['new_filename'].")";
			echo "<hr>";
			echo "Step 1 Creating deformation ... ";
			$t1_start = Timer::microtime_float();
			/* clear $Z variable (fault values) */
			$Z = array();
			echo "<script language=javascript>document.getElementById('step".$loop."').innerHTML = '1';</script>";
			echo "<span id='no".$loop."'></span>";
			for ($i=1; $i<=($IE-$IS+1); $i++) {
				/**/
				$pg = round(($i*100)/($IE-$IS+1), 0);
				echo "<script language=javascript>document.getElementById('no".$loop."').innerHTML = \"".$pg."% of 100% \";</script>";
				//echo "! ".$i." of ".($IE-$IS+1)."\n";
				for ($j=1; $j<=($JE-$JS+1); $j++) {
					
					/* main calculation */
					$YY = $A*$RR*$DR*($j-1)/(60*180) ;
					$XX = $A*$RR*$DR*($i-1)*cos($E*($YO+$DR*($j-1)/60))/(60*180) ;
					$X1 = ($XX-$XL)*sin($E*$TH)+($YY-$YL)*cos($E*$TH)-$L/2.0 ;
					$X2 = ($XX-$XL)*cos($E*$TH)-($YY-$YL)*sin($E*$TH)+$HH/tan($E*$DL) ;
					$X3 = 0.0 ;
					$F1 = FaultCalculation::uscal($X1, $X2, $X3, $L/2 , $H2, $E*$DL);
					$F2 = FaultCalculation::uscal($X1, $X2, $X3, $L/2, $H1, $E*$DL);
					$F3 = FaultCalculation::uscal($X1, $X2, $X3, ($L*(-1))/2, $H2, $E*$DL) ;
					$F4 = FaultCalculation::uscal($X1, $X2, $X3, ($L*(-1))/2, $H1, $E*$DL) ;
					$G1 = FaultCalculation::udcal($X1, $X2, $X3, $L/2, $H2, $E*$DL);
					$G2 = FaultCalculation::udcal($X1, $X2, $X3, $L/2, $H1, $E*$DL);
					$G3 = FaultCalculation::udcal($X1, $X2, $X3, ($L*(-1))/2, $H2, $E*$DL);
					$G4 = FaultCalculation::udcal($X1, $X2, $X3, ($L*(-1))/2, $H1, $E*$DL);
					$US = ($F1-$F2-$F3+$F4)*$DSS/(12.0*$A) ;
					$UD = ($G1-$G2-$G3+$G4)*$DD/(12.0*$A) ;
					$II = (int)($i+$IS-1);
					$JJ = (int)($j+$JS-1);
					$Z[$II][$JJ] = $US+$UD+$Z[$II][$JJ];
					
					if ( $Z[$II][$JJ] > -0.01 && $Z[$II][$JJ] < 0.01) {
						$Z[$II][$JJ] = 0 ;
					}
					
					/* end of mail calculation */
				}
				/* end */
			}
			/* end */
			$t2_start = Timer::microtime_float();
			echo "\t\t\t".round(($t2_start-$t1_start), 2)." sec.";
			echo "<script language=javascript>document.getElementById('step".$loop."').innerHTML = '2';</script>";
			echo "\nStep 2 Formulating output ... ";
			
			$t1_start = Timer::microtime_float();
			
			/* write values to fault no. file */
			$cc = 0;
			for ($J=$JG; $J>=1; $J--) {
				for ($I=1; $I<=$IG; $I++) {
					fprintf($pt_def_out, "%.4f\n", $Z[$I][$J]);
					++$cc;
				}
			}
			fclose($pt_def_out);
		
			/* filenames to read */
			$def_outfile_location = $output_dir."tmp_".$_POST['new_filename'].'.dat';
			$file_out_1 = $output_dir.$_POST['new_filename'].'.dat';
			
			/* global no. of grid in x direction (longitude) */
			$nX = $IG;
			
			/* global no. of grid in y direction (latitude) */
			$nY = $JG;
			
			/* open large map of created deformation file to read */
			$pt_out = fopen($def_outfile_location, 'r');
			
			/* open new file to contain the cropped deform file */
			$pt_out1 = fopen($file_out_1, 'w');
			
			$i=1;
			$j=1;
			$data = array();
			$temp = array();
			
			/* read large map of above created deformation file */
			while($value = fgets($pt_out, 32)){
				$temp[$i++] = doubleval($value);
				if(count($temp) == $nX) {
					$data[$j++] = $temp;
					$temp = null;
					$i = 1;
				}
			}
		
			/* generate the latitude, longitude */
			$X = array();
			$Y = array();
			$X = MATLAB::LinearlySpacedVector($XG, $XG+$DS/60*($nX-1), $nX);
			$Y = MATLAB::LinearlySpacedVector($YG+$DS/60*($nY-1), $YG, $nY);
			
			/* create the 2-dimensional metrix of x direction */
			$cTx = 0;
			$Tx = array();
			for ($i=1; $i<=$nY; $i++) {
				$Tx[$i] = $X;
				$cTx++;
			}
			
			/* create the 2-dimensional metrix of y direction */
			$i = 1;
			$cTy = 0;
			$Ty = array();
			foreach ($Y as $index => $value) {
				for($i=1; $i<=$nX; $i++) {
					$Ty[$index][$i] = $value;
					$cTy++;
				}
			}
			echo "success.";
			$t2_start = Timer::microtime_float();
			echo "\t\t\t\t\t".round(($t2_start-$t1_start), 2)." sec.";
			
			/*
			echo "! Recheck \n";
			echo "! no. of grid y of \$data = ".count($data[1]).", x of \$data = ".count($data)."\n";
			echo "! no. of grid y of \$Tx = ".count($Tx[1]).", x of \$Tx = ".count($Tx)."\n";
			echo "! no. of grid y of \$Ty = ".count($Ty[1]).", x of \$Ty = ".count($Ty)."\n";
			echo "! refer nX = ".$nX.", nY = ".$nY."\n";
			*/
					
			/* reset neccessary values */
			$max = 0;
			$min = 0;
			$max_long = 0;
			$max_lat = 0;
			$min_long = 0;
			$min_lat = 0;
			echo "<script language=javascript>document.getElementById('step".$loop."').innerHTML = '3';</script>";
			echo "\nStep 3 Cropping the region of interest ... ";
			$t1_start = Timer::microtime_float();
			
			/* crop the specified region, collect min, max of lat, long */
			for ($i=1; $i<=$nY; $i++) {
				for ($j=1; $j<=$nX; $j++) {
					$tempz = doubleval($data[$i][$j]);
					$tempx = doubleval($Tx[$i][$j]);
					$tempy = doubleval($Ty[$i][$j]);
					if ($tempy >= $lat_1) {
						if ($tempy <= $lat_2) {
							if ($tempx >= $long_1) {
								if ($tempx <= $long_2) {
									fprintf($pt_out1, "%.3f\n", $tempz);  
									if ($tempz > $max) {
										$max = $tempz;
										$max_long = $tempx;
										$max_lat = $tempy;
									}
									if ($min > $tempz) {
										$min = $tempz;
										$min_long = $tempx;
										$min_lat = $tempy;
									}
								}
							}
						}
					}
				}
			}
			$t2_start = Timer::microtime_float();
			echo "success";
			echo "\t\t\t".round(($t2_start-$t1_start), 2)." sec.";
			echo "<script language=javascript>document.getElementById('step".$loop."').innerHTML = '4';</script>";
			echo "\nStep 4 Saving to database ... ";		
			
			if(isset($_POST['deform']['default_conf']) && $_POST['deform']['default_conf'] == "on") {
				$sql = "UPDATE `ds_input_deform` SET `default_conf` = 'no' WHERE `default_conf` = 'yes';";
				mysql_query($sql, $connection);
			}
			
			if(isset($_POST['deform']['default_param']) && $_POST['deform']['default_param'] == "on") {
				$sql = "UPDATE `ds_input_deform` SET `default_param` = 'no' WHERE `default_param` = 'yes';";
				mysql_query($sql, $connection);
			}
			$sql = "INSERT INTO `tsunami_version`.`ds_input_deform` ";
			$sql .= "(`id`, `filename`, `description`, `path`, `glob_x_long`, `glob_y_lat`, ";
			$sql .= "`grid_space`, `org_x`, `org_y`, `coord_long_1`, `coord_long_2`, ";
			$sql .= "`coord_lat_1`, `coord_lat_2`, `length`, `length_fault`, `width_fault`, ";
			$sql .= "`epi_depth`, `dislocate`, `dip_angle`, `strike_angle`, `rake_angle`, ";
			$sql .= "`long_epi`, `lat_epi`, `max_upward`, `min_downward`, ";
			$sql .= "`max_lat`, `max_long`, `min_lat`, `min_long`, `default_conf`, `default_param`, `create_date`)";
			$sql .= " VALUES (NULL, '".$_POST['new_filename'].".dat', '".$_POST['description']."', '".base64_encode($file_out_1)."', ";
			$sql .= "'".$_POST['fault_conf']['glob_x_long']."', '".$_POST['fault_conf']['glob_y_lat']."', ";
			$sql .= "'".$_POST['fault_conf']['grid_space']."', '".$_POST['fault_conf']['org_x']."', ";
			$sql .= "'".$_POST['fault_conf']['org_y']."', '".$_POST['fault_conf']['coord_long_1']."', ";
			$sql .= "'".$_POST['fault_conf']['coord_long_2']."', '".$_POST['fault_conf']['coord_lat_1']."', ";
			$sql .= "'".$_POST['fault_conf']['coord_lat_2']."', '".$_POST['fault_conf']['length']."', '".$_POST['fault_param']['length_fault']."', ";
			$sql .= "'".$_POST['fault_param']['width_fault']."', '".$_POST['fault_param']['epi_depth']."', ";
			$sql .= "'".$_POST['fault_param']['dislocate']."', '".$_POST['fault_param']['dip_angle']."', ";
			$sql .= "'".$_POST['fault_param']['strike_angle']."', '".$_POST['fault_param']['rake_angle']."', ";
			$sql .= "'".$_POST['fault_param']['long_epi']."', '".$_POST['fault_param']['lat_epi']."', ";
			$sql .= "'".$max."', '".$min."', '".$max_lat."', '".$max_long."', '".$min_lat."', '".$min_long."', '".(($_POST['deform']['default_conf'] == "on") ? "yes":"no")."', '".(($_POST['deform']['default_param'] == "on") ? "yes":"no")."', '".time()."');";
			mysql_query($sql, $connection);
			echo "success";
			/*
				[new_filename] => test
				[description] => 
				[deform] => Array
					(
						[glob_x_long] => 1201
						[glob_y_lat] => 1501
						[grid_space] => 2
						[org_x] => 80.016666666667
						[org_y] => -29.983333333333
						[coord_long_1] => 87
						[coord_long_2] => 110
						[coord_lat_1] => -10
						[coord_lat_2] => 18
						[length_fault] => 100000
						[width_fault] => 50000
						[epi_depth] => 5000
						[dislocate] => 1
						[dip_angle] => 12
						[strike_angle] => 320
						[rake_angle] => 90
						[long_epi] => 100
						[lat_epi] => -4.2
					)
			*/
			
			echo "\n\n<hr><b>Summary</b><hr>";
			echo "! Max. = ".$max;
			echo "\n! Max. Long. = ".$max_long;
			echo "\n! Max. Lat. = ".$max_lat;
			echo "\n! Min. = ".$min;
			echo "\n! Min. Long. = ".$min_long;
			echo "\n! Min. Lat. =".$min_lat;
			fclose($pt_out);
			fclose($pt_out1);
		   
			/* End calculation. */
			unlink($def_fileout_name);
			$fault_time_stop = Timer::microtime_float();
			
			echo "<hr>! Total time used for creating deformation file\t\t\t".round(($fault_time_stop-$fault_time_start), 2)." sec.\n\n";
			echo "<input type=button value=\"Download deformation file\" onclick=\"javascript: document.location.href='download_file.php?download_filepath=".base64_encode($file_out_1)."';\">";
		}
		echo "<input type=button value=Back onclick='javascript: history.back();'>";
	}
	
	
?>
</pre>
