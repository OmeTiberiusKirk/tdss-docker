<?php
	require_once('class.deform.php');
	
	define("DEBUG_IMMEDIATE", 0);
	set_time_limit(0);
	
	$start = Timer::microtime_float();

	$IG = 1201 ;	# global no. of grid in x direction (longitude)
	$JG = 1501 ;	# global no. of grid in y direction (latitude)
	
	$DS = 2 ;  # grid spacing (min)
	$XG = 80.016666666667 ; # orgin of x direction
	$YG = -29.983333333333 ; # orgin of y direction
	
	/* specify input/output directory */
	$output_dir = 'output/';
	$input_dir = 'input/';
	
	/* coordinate of cropped area */
	$long_1 = 87;
	$long_2 = 110;
	$lat_1 = -10;
	$lat_2 = 18;

	/* fault parameter file localtion */
	$fault_file_location = $input_dir.'data.dat';
	
	/* open fault file to read */
	$fp_data = fopen($fault_file_location, "r");
	$line = 0;
	$row_no = 1;
	
	/* get of each line */
	while($buff = fgets($fp_data)) {
		$line++;
		if($line > 2 && strlen($buff) > 10) {
			/* store output */
			$temp_line[$row_no++] = explode(',', str_replace("\t", ',', $buff));
		}
	}
	
	/* parameters */
	$param_suite = $temp_line;
	
	/* create filename for collecting the summary of deformation creation */
	$summary_outfile_location  = $output_dir.'summary_defrom.dat';
	
	/* open file for writing */
	$pt_out_summary = fopen($summary_outfile_location, 'w');

	/* Main loop of each fault */
	for ($line_no=1; $line_no<=count($param_suite); $line_no++) {
		/* parameters of each fault */
	    $no = $param_suite[$line_no][0]; # fault number
	    $L  = $param_suite[$line_no][1]; # length fault (m)
	    $W  = $param_suite[$line_no][2]; # width fault (m)
	    $HH = $param_suite[$line_no][3]; # epicenter depth (m)
	    $D  = $param_suite[$line_no][4]; # dislocation (m)
	    $DL = $param_suite[$line_no][5]; # dip angle (degree)
	    $TH = $param_suite[$line_no][6]; # strike angle (degree)
	    $RD = $param_suite[$line_no][7]; # rake angle (degree)
	    $X0 = $param_suite[$line_no][8]; # longitude epicenter (degree, +E)
	    $Y0 = $param_suite[$line_no][9]; # latitude epicenter (degree, +N, -S)
		
		/* open file for collecting the fault values (large map) */
	    $def_fileout_name = $output_dir.'def'.$no.'_M.dat';
	    $pt_def_out = fopen($def_fileout_name, 'w');
		
	    /* constant parameters */
	    $DR = 2.0;
	    $LENGTH = 10 ;
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
		
	    echo "! Building deformation No. ".$no." \n";
		
		/* time start of each fault */
	    $fault_time_start = Timer::microtime_float();
		
		/* clear $Z variable (fault values) */
		$Z = array();
		
		
		/* */
	    for ($i=1; $i<=($IE-$IS+1); $i++) {
			/**/
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
		
		/* write values to fault no. file */
	    $counter = 0;
	    for ($J=$JG; $J>=1; $J--) {
	        for ($I=1; $I<=$IG; $I++) {
	            fprintf($pt_def_out, "%.4f\n", $Z[$I][$J]);
	            ++$counter;
	        }
	    }
	    fclose($pt_def_out);
		
		/* filenames to read */
	    $def_outfile_location = $output_dir.'def'.$no.'_M.dat';
	    $file_out_1 = $output_dir.'deform1_'.$no.'M.dat';
	    $file_out_2 = $output_dir.'Deform_region1_'.$no.'M_XYZ.dat';
		
		/* global no. of grid in x direction (longitude) */
	    $nX = $IG;
		
		/* global no. of grid in y direction (latitude) */
	    $nY = $JG;
		
		/* open large map of created deformation file to read */
	    $pt_out = fopen($def_outfile_location, 'r');
		
		/* open new file to contain the cropped deform file */
	    $pt_out1 = fopen($file_out_1, 'w');
	    $pt_out2 = fopen($file_out_2, 'w');
		
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
		
		echo "! no. of grid y of \$data = ".count($data[1]).", x of \$data = ".count($data)."\n";
		echo "! no. of grid y of \$Tx = ".count($Tx[1]).", x of \$Tx = ".count($Tx)."\n";
		echo "! no. of grid y of \$Ty = ".count($Ty[1]).", x of \$Ty = ".count($Ty)."\n";
		echo "! refer nX = ".$nX.", nY = ".$nY."\n";
		
				
		/* reset neccessary values */
	    $max = 0;
	    $min = 0;
	    $max_long = 0;
	    $max_lat = 0;
	    $min_long = 0;
	    $min_lat = 0;
		
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
	                            fprintf($pt_out2, "%.7f %.7f %.3f\n", $tempx, $tempy, $tempz);
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
		
	   if ($line_no==1) {
	        fprintf($pt_out_summary, "Fault_No. max. max_long. max_lat. min. min_long. min_lat.\n");
	   }
	   echo "! Fault No. = ".$line_no."\n";
	   echo "! Max. = ".$max."\n";
	   echo "! Max. Long. = ".$max_long."\n";
	   echo "! Max. Lat. = ".$max_lat."\n";
	   echo "! Min. = ".$min."\n";
	   echo "! Min. Long. = ".$min_long."\n";
	   echo "! Min. Lat. =".$min_lat."\n";
	   fprintf($pt_out_summary, "%g %.3f %.7f %.7f %.3f %.7f %.7f\n", $line_no, $max, $max_long, $max_lat, $min, $min_long, $min_lat);
	   fclose($pt_out);
	   fclose($pt_out1);
	   fclose($pt_out2);
	   
	   $fault_time_stop = Timer::microtime_float();
	   echo "! fault no. = ".$ii.", time used = ".($fault_time_stop-$fault_time_start).".\n\n";
	   
	} /* end of main loop of each fault */
	
	$stop = Timer::microtime_float();
	fclose($pt_out_summary);
	echo "time used = ".($stop-$start)."\n";
	
	function dump_var($var, $filename) {
		ob_start();
		if(is_array($var)) {
			for($i=0; $i<count($var); $i++) {
				if(is_array($var[$i])) {
					for($j=0; $j<count($var[$i]); $j++) {
						
					}
				}
			}
		}
		$contents = ob_get_contents();
		ob_end_clean();
	}
?>