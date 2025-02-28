<?php
	session_start();
	require('setting.inc.php');
	require('ssh.class.php');
	require('connectdb.inc.php');

	class Visualization
	{
		private $template_net_loc;
		private $ssh_object;
		private $remote_working_dir;
		
		private $remote_network_file_location;
		private $remote_runsh_file_location;
		
		private $visualization_output_image_name;
		private $visualization_output_colorbar_name;
		private $visualization_output_cleanup_flag;
		
		private $template_convert_script_loc;
		
		public function __construct($type, $style, $working_dir, $region)
		{
			global $template;
			global $visualizer;
			global $visout;
			
			$this->visualization_output_image_name = $visout['image_name'];
			$this->visualization_output_colorbar_name = $visout['colorbar'];
			$this->visualization_output_cleanup_flag = $visout['delete_flag'];
			
			$this->template_convert_script_loc = $template['sh_convert'];
			
			switch($type)
			{
				case "Wave Animation" :
					if($style == "3D")
						$this->template_net_loc = $template['wave-animation']['3d'][''.$region.''];
					else
						$this->template_net_loc = $template['wave-animation']['2d'][''.$region.''];
					break;
					
				case "Velocity" :
					if($style == "3D")
						$this->template_net_loc = $template['velocity']['3d'][''.$region.''];
					else
						$this->template_net_loc = $template['velocity']['2d'][''.$region.''];
					break;
				
				case "Depth" :
					if($style == "3D")
						$this->template_net_loc = $template['depth']['3d'][''.$region.''];
					else
						$this->template_net_loc = $template['depth']['2d'][''.$region.''];
					break;
				
				case "Height" :
					if($style == "3D")
						$this->template_net_loc = $template['height']['3d'][''.$region.''];
					else
						$this->template_net_loc = $template['height']['2d'][''.$region.''];
					break;
					
			    case "The Elapsed Time Arrival" :
			
					if($style == "3D")
						$this->template_net_loc = $template['arraival-time']['3d'][''.$region.''];
					else
						$this->template_net_loc = $template['arraival-time']['2d'][''.$region.''];															               
			     	break;
						
			}
			
			//if(!file_exists($this->template_net_loc))
				//echo "File is not exist !";
			
			//$this->ssh_object = new SSH();
			
			//$this->ssh_object->connect($visualizer['hostname'], 22, $visualizer['username'], $visualizer['password']);
			//if($this->ssh_object->isError())
				//echo $this->ssh_object->getError();
				
			//$this->ssh_object->makeDirectory($visualizer['working_dir'], $working_dir);
			//if($this->ssh_object->isError())
				//echo $this->ssh_object->getError();
			
			//$this->ssh_object->makeDirectory($visualizer['working_dir'], $working_dir."/image");
			//if($this->ssh_object->isError())
				//echo $this->ssh_object->getError();
				
			//$this->remote_working_dir = $visualizer['working_dir'].$working_dir."/";
		}
		
		public function createNetworkFile($url_ds_region, $url_ds_data, $tmp_filename, $zoom_t, $resolution_t, $rotate_x_t, $rotate_y_t, $rotate_z_t, $gridsize_x_t, $gridsize_y_t, $timestep_t, $region_t, $data_t, $axes_y_position, $axes_y_label, $axes_x_position, $axes_x_label, $point_name, $point_position, $contour_line)
		{
			global $tmpfile_prefix;
			
			$region_import_url = $url_ds_region;
			$uvm_import_url = $url_ds_data;
			$image = $this->remote_working_dir."image/".$this->visualization_output_image_name;
			$colorbar = $this->remote_working_dir."image/".$this->visualization_output_colorbar_name;
			$zoom = $zoom_t;
			$resolution = $resolution_t;
			$translate_x = (integer)($gridsize_x_t/2) * (-1);
			$translate_y = (integer)($gridsize_y_t/2) * (-1);
			$rotate_x = $rotate_x_t;
			$rotate_y = $rotate_y_t;
			$rotate_z = $rotate_z_t;
			$timestep = (integer)($timestep_t)-1;
			$region   = $region_t;
			$data     = $data_t;
			
			$tmpfile_network_file = $tmpfile_prefix."network-".$tmp_filename.".net";
			$handle = fopen($this->template_net_loc, "r");
			if ($handle) 
			{
				$i = 1;
				$contents_network_file = '';
				while (!feof($handle)) 
				{
					$buffer = fgets($handle, 1024);
					if(preg_match("/__FILE_1__/", $buffer))
						$buffer = str_replace("__FILE_1__", $region_import_url, $buffer);
					
					if(preg_match("/__FILE_2__/", $buffer))
						$buffer = str_replace("__FILE_2__", $uvm_import_url, $buffer);
					
					if(preg_match("/__IMAGE__/", $buffer))
						$buffer = str_replace("__IMAGE__", $image, $buffer);
					
					if(preg_match("/__COLORBAR__/", $buffer))
						$buffer = str_replace("__COLORBAR__", $colorbar, $buffer);
	
					if(preg_match("/__ZOOM__/", $buffer))
						$buffer = str_replace("__ZOOM__", $zoom, $buffer);

					if(preg_match("/__RESOLUTION__/", $buffer))
						$buffer = str_replace("__RESOLUTION__", $resolution, $buffer);
						
					if(preg_match("/__TRANSLATE_X__/", $buffer))
						$buffer = str_replace("__TRANSLATE_X__", $translate_x, $buffer);
						
					if(preg_match("/__TRANSLATE_Y__/", $buffer))
						$buffer = str_replace("__TRANSLATE_Y__", $translate_y, $buffer);

					if(preg_match("/__ROTATE_X__/", $buffer))
						$buffer = str_replace("__ROTATE_X__", $rotate_x, $buffer);

					if(preg_match("/__ROTATE_Y__/", $buffer))
						$buffer = str_replace("__ROTATE_Y__", $rotate_y, $buffer);

					if(preg_match("/__ROTATE_Z__/", $buffer))
						$buffer = str_replace("__ROTATE_Z__", $rotate_z, $buffer);
						
					if(preg_match("/__TIMESTEP__/", $buffer))
						$buffer = str_replace("__TIMESTEP__", $timestep, $buffer);

					if(preg_match("/__FILE1_NAME__/", $buffer))
						$buffer = str_replace("__FILE1_NAME__", $region, $buffer);

					if(preg_match("/__FILE2_NAME__/", $buffer))
						$buffer = str_replace("__FILE2_NAME__", $data, $buffer);
					
					if(preg_match("/__AXES_Y_LOCATION__/", $buffer))
						$buffer = str_replace("__AXES_Y_LOCATION__", $axes_y_position, $buffer);
					
					if(preg_match("/__AXES_Y_LABEL__/", $buffer))
						$buffer = str_replace("__AXES_Y_LABEL__", $axes_y_label, $buffer);	
					
					if(preg_match("/__AXES_X_LOCATION__/", $buffer))
						$buffer = str_replace("__AXES_X_LOCATION__", $axes_x_position, $buffer);
					
					if(preg_match("/__AXES_X_LABEL__/", $buffer))
						$buffer = str_replace("__AXES_X_LABEL__", $axes_x_label, $buffer);	
					
					if(preg_match("/__POINT_NAME__/", $buffer))
						$buffer = str_replace("__POINT_NAME__", $point_name, $buffer);						
					
					if(preg_match("/__POINT_POSITION__/", $buffer))
						$buffer = str_replace("__POINT_POSITION__", $point_position, $buffer);	
					
					if(preg_match("/__CONTOUR_LINE__/", $buffer))
						$buffer = str_replace("__CONTOUR_LINE__", $contour_line, $buffer);						
						
					//echo $i++."-> ".$buffer;
					$contents_network_file .= $buffer;
    			}
			    fclose($handle);
			}
			echo "\n";
			echo $contents_network_file;
			file_put_contents(TEMP_DIR.$tmpfile_network_file, $contents_network_file);
			$this->remote_network_file_location = $this->remote_working_dir.$tmpfile_network_file;
			//$this->ssh_object->remoteCopyFile($this->remote_network_file_location, "<-", TEMP_DIR.$tmpfile_network_file);		
		}
		
		public function createRunSH($tmp_filename)
		{
			global $template;
			global $tmpfile_prefix;
			
			$tmpfile_runsh_file = $tmpfile_prefix."runsh-".$tmp_filename.".sh";		
			$handle = fopen($template['sh_script'], "r");
			if ($handle) 
			{
				while (!feof($handle)) 
				{
					$buffer = fgets($handle, 1024);
					
					if(preg_match("/__NETWORK_FILE_LOCATION__/", $buffer))
						$buffer = str_replace("__NETWORK_FILE_LOCATION__", $this->remote_network_file_location, $buffer);
						
					if(preg_match("/__WORKING_DIR__/", $buffer))
						$buffer = str_replace("__WORKING_DIR__", $this->remote_working_dir, $buffer);
					
					$contents_runsh_file .= $buffer;
    			}
			    fclose($handle);
			}
			
			file_put_contents(TEMP_DIR.$tmpfile_runsh_file, $contents_runsh_file);
			$this->remote_runsh_file_location = $this->remote_working_dir.$tmpfile_runsh_file;
			$this->ssh_object->remoteCopyFile($this->remote_runsh_file_location, "<-", TEMP_DIR.$tmpfile_runsh_file, 0755);			
		}
		
		public function executeDXSHELL()
		{
			/* run DX */
			$sh = $this->remote_runsh_file_location;
			$output = $this->ssh_object->executeSH($sh);
			if($this->ssh_object->isError())
			{
				echo $this->ssh_object->getError();
			}else
			{
				echo "System Output : Data Visualization Process 1\n";
				echo "-----------------------------------------------------------------------------------------\n";
				foreach($output as $line)
					echo $line;
			}
			/* convert .tiff to .png to show on the web */
			echo "! Converting image ...\n";
			$cmd = "cd ".$this->remote_working_dir.";";
			// timestep != 1
			
			// timestep == 1
			$cmd .= "for i in `ls image/`; do convert -quality 500 image/\$i image/\$i.jpg; done; ";
			$cmd .= "cd ".$this->remote_working_dir.";";			
			$cmd .= "rm -rf image/*.tiff";
			//echo $cmd."\n";
			$output = $this->ssh_object->executeSH($cmd);
			if($this->ssh_object->isError())
				echo $this->ssh_object->getError();
			
			/* compress output */
			echo "! Compressing output ...\n";
			$cmd = "cd ".$this->remote_working_dir."image/; tar cvzf ../image.tar.gz * ";
			$output = $this->ssh_object->executeSH($cmd);
			if($this->ssh_object->isError())
				echo $this->ssh_object->getError();
		}
		
		public function getVisResultBack($local_location_t)
		{
			$remote_dir = $this->remote_working_dir."image.tar.gz";
			$local_location = $local_location_t."/t_image.tar.gz";
						
			$this->ssh_object->remoteCopyFile($remote_dir, "->", $local_location);
			/*if($this->ssh_object->isError())
			{
				echo "\n\nSystem Output : Data Visualization Process 2\n";
				echo "-----------------------------------------------------------------------------------------\n";			
				echo "Message # ".$this->ssh_object->getError()."\n\n";
				return false;
			}else
			{*/
				require_once('zlib-extractor.class.php');
				
				//set_time_limit(3600);
				
				$arch_file = $local_location;
				if (mkdir($local_location_t."/image"))
				{							
					$store_dir = $local_location_t."/image";
					echo $arch_file."/n";
					
					
					$tar = new TAR($arch_file, $store_dir);
					$tar->extractAll();
					unlink($local_location);
				}
				return $store_dir."/";
			//}
		}
		
		public function cleanUp()
		{
			if ($this->visualization_output_cleanup_flag == true )
			{
				$cmd = "rm -rf ".$this->remote_working_dir;
				$output = $this->ssh_object->executeSH($cmd);
				echo $output;
			}
		}
		
		// This function calculate lattitude and longitude in 
		public function calculate_Lat_Long($Lat_min, $Lipda_min, $Philipda_min, $Lat_max, $Lipda_max, $Philipda_max, $Scale_Lipda, $Scale_Philipda, $Grid_x, $Grid_y, $Scale_Lipda, $Scale_Philipda, $status)
		{
			global $value;
			$value = array();
		
			$flag = 1;$j =0;$flag_cal = 1;$flag_cal_philip = 1;
						
			if ($flag_cal == 1) {
				// Calculate Lat or Long in Decimal ::: First Value (min)
				if($Lat_min < 0){
					$value[0] = -((-$Lat_min) + ($Lipda_min/60)+ ( $Philipda_min/3600));
				}else{
					$value[0] = (($Lat_min) + ($Lipda_min/60)+ ($Philipda_min/3600));	
				}
				// Calculate Lat or Long in Decimal ::: Second Value 
				if($Scale_Philipda == 0){// ::: 87 58 0
					if($status == "lat"){
						if($Lat_max >= 0){
							if($Lipda_max == 0){
								$Lipda_s = 60 - ($Scale_Lipda/2);
								$Lat_s   = $Lat_max - 1;
							}else{
								$Lipda_s = $Lipda_max - ($Scale_Lipda/2);
								$Lats_s    = $Lat_max;
							}
							$value[1] = (($Lat_s) + ($Lipda_s/60)+ ($Philipda_min/3600));
						}else{//if($Lat_max < 0)
							if($Lipda_max == 0){
								$Lipda_s = ($Scale_Lipda/2);
								$Lat_s   = $Lat_max ;
							}else{
								$Lipda_s = $Lipda_max + ($Scale_Lipda/2);
								if($Lipda_s == 60){
									$Lipda_s =  0;
									$Lat_s   =  $Lat_max - 1;
								}else{
									$Lat_s   =  $Lat_max;
								}
							}
							$value[1] = -((-$Lat_s) + ($Lipda_s/60)+ ( $Philipda_min/3600));
						}
					}else{// if ($status == "long")
						if($Lat_min >= 0){
							if($Lipda_min == 0){
								$Lipda_s = ($Scale_Lipda/2);
								$Lat_s   = $Lat_min;
							}else{
								$Lipda_s = $Lipda_min + ($Scale_Lipda/2);
								if($Lipda_s == 60){
									$Lipda_s = 0;
									$Lat_s   = $Lat_min + 1;
								}else{
									$Lats_s    = $Lat_min;
								}
							}
							$value[1] = (($Lat_s) + ($Lipda_s/60)+ ($Philipda_min/3600));
						}else{//if($Lat_min < 0)
							if($Lipda_min == 0){
								$Lipda_s = 60 -($Scale_Lipda/2);
								$Lat_s   = $Lat_min + 1;
							}else{
								$Lipda_s = $Lipda_min - ($Scale_Lipda/2);
								$Lat_s   =  $Lat_min;
							}
							$value[1] = -((-$Lat_s) + ($Lipda_s/60)+ ( $Philipda_min/3600));
						}
					}
				}else{ //if($Scale_Philipda != 0)  ::: 88 59 58
					if($status == "lat"){
						if($Lat_max >= 0){
							if($Philipda_max == 0){
								$Philipda_s = 60 - ($Scale_Philipda/2);
								if($Lipda_max == 0){
									$Lipda_s  = 60 - 1 ;
									$Lat_s    = $Lat_max - 1;
								}else{
									$Lipda_s  = $Lipda_max - 1;
									$Lat_s    = $Lat_max;
								}
							}else{
								$Philipda_s = $Philipda_max - ($Scale_Philipda/2);
								$Lipda_s 	= $Lipda_max;
								$Lats_s     = $Lat_max;
							}
							$value[1] = (($Lat_s) + ($Lipda_s/60)+ ($Philipda_s/3600));
						}else{//if($Lat_max < 0)
							if($Philipda_max == 0){
								$Philipda_s = ($Scale_Philipda/2);
								$Lipda_s    = $Lipda_max;
								$Lat_s      = $Lat_max;
							}else{
								$Philipda_s = $Philipda_max + ($Scale_Philipda/2);
								if($Philipda_s == 60){
									$Philipda_s = 0;
									$Lipda_s 	= $Lipda_max + 1;
									if($Lipda_s == 60){
										$Lipda_s = 0;
										$Lats_s     = $Lat_max + 1;
									}else{
										$Lats_s     = $Lat_max;
									}
								}else{
									$Lipda_s 	= $Lipda_max;
									$Lats_s     = $Lat_max;
								}
							}
							$value[1] = -((-$Lat_s) + ($Lipda_s/60)+ ( $Philipda_s/3600));
						}
					}else{// if ($status == "long")
					    if($Lat_min >= 0){
							if($Philipda_min == 0){
								$Philipda_s = ($Scale_Philipda/2);
								$Lipda_s    = $Lipda_min;
								$Lat_s      = $Lat_min;
							}else{
								$Philipda_s = $Philipda_min + ($Scale_Philipda/2);
								if($Philipda_s == 60){
									$Philipda_s = 0;
									$Lipda_s    = $Lipda_min + 1;
									if($Lipda_s == 60){
										$Lipda_s = 0;
										$Lat_s   = $Lat_s + 1;
									}else{
										$Lat_s   = $Lat_s;
									}
								}else{
									$Lipda_s 	= $Lipda_min;
									$Lats_s     = $Lat_min;
								}
							}
							$value[1] = (($Lat_s) + ($Lipda_s/60)+ ($Philipda_s/3600));
						}else{//if($Lat_min < 0)
							if($Philipda_min == 0){
								$Philipda_s = 60 -($Scale_Philipda/2);
								if($Lipda_min == 0){
									$Lipda_s  = 60 - 1;
									$Lat_s    = $Lat_min + 1;
								}else{
									$Lipda_s  = $Lipda_min - 1;
	 								$Lat_s    = $Lip_min;
								}
							}else{//if($Philipda_min != 0)
								$Philipda_s = $Philipda_min - ($Scale_Philipda/2);
								$Lipda_s 	= $Lipda_min;
								$Lats_s     = $Lat_min;					
							}
							$value[1] = -((-$Lat_s) + ($Lipda_s/60)+ ( $Philipda_s/3600));
						}
					}
				}
				$flag_cal = 0;
			}
					
			// Calculate Lat or Long in Decimal ::: Third Value (max)
			$value[2] = (($Lat_max) + ($Lipda_max/60)+ ($Philipda_max/3600));
			return $value;
		} //end function of calculate Lat, Long
		
		/* This Function Calculate AutoAxes Value and position of AutoAxes in DX*/
		public function Calculate_AutoAxes( $axes_min, $axes_max, $gridsize)
		{
			global $axes;
			$axes = array();
			$max = $axes_max;
			$min = $axes_min;
			$grid = $gridsize;
			$grid2 = $grid - 1; //second grid
			$grid2 = (string)$grid2;
			$Axes = $grid/2;
			$Axes = (string)$Axes;
			$min = (string)$min;
			$max = (string)$max;
			
			//finding the gap value of autoaxes  
			$diff_gap = ($max-$min);
			$str_gap = (string)$diff_gap;
			$diff = array(); $q =1;
			$diff['5'] = floatval($str_gap)/5;
			$diff['6'] = floatval($str_gap)/6;
			$diff['8'] = floatval($str_gap)/8;
			
			foreach ($diff as $index => $value) 
			{
				$sum += $value;
			}
			//$gap_val = floatval(round($sum/count($diff), $precision));
			$gap_val = ($sum/count($diff));
			$gap_val_t = (string)$gap_val; // set to string 
		
			// set flag
			$i=0; $k=0; $m=0;$s=1; $c=1; $one =1;$x = 0; $v =0; $ee=1; $ff=1; $cot = 0;	$vv =0; $eee=1; $fff=1; $cott = 0;	
			$flag = 1;
			$flag_2 = 1;
			$flag_int = 1;
			$check_max = 1;
			$find_max = 1;
			$check =0; $first = 1; $check_exist_float =1;
			$h = 0; $check_float = 1;
			//set array
			$temp = array(); $mint  = array();$mintt  = array();
			
			$gap = '';
			$base_min ='';
		
			// check gap_val < 1 EX: 0.025.
			if($gap_val < 1){
				while ($flag != 0){
					// check position of value = "." Or Not
					if(($gap_val_t[$i] != '.') && ($flag_2 == 0) ){
						if($gap_val_t[$i] != 0){
							// set gap_val in a nice value
							if ($gap_val_t[$i] == 1 || $gap_val_t[$i] == 2){
								$temp[$j]= $gap_val_t[$i];
								break;
							}elseif ($gap_val_t[$i] >= 3 && $gap_val_t[$i] <= 5){
								$temp[$j]= '5';
								break;
							}elseif ($gap_val_t[$i] > 5) {
								$temp[$j]= '0';
								if($temp[$j-1] == "."){ 
									$temp[$j-2]= $temp[$j-1] + 1;
								}else 
									$temp[$j-1]= '1';
								$flag = 0;//set flag if $gap_val_t[$i] > 5
								break;
							}
						}else { //if gal_val_t[] = 0 set "o"
							$temp[$j] = '0';
						}
					}elseif ($gap_val_t[$i] == '.'){
						$flag_2 = 0; // if find "." set $flag_2 = 0
						$temp[$j=0]= '.';
					}
					$i++; $j++;
				}
				
			}else /*($gap_val >= 1)*/ {
				while ($flag_int != 0) {
			
					if(($gap_val_t[$k] != '.') ){
						if ($gap_val_t[$k] == 1 || $gap_val_t[$k] == 2){
							$temp[$k]= $gap_val_t[$k];
							break;
						}elseif ($gap_val_t[$k] >= 3 && $gap_val_t[$k] <= 5) {
							$temp[$k]= '5';
							break;
						}elseif ($gap_val_t[$k] > 5) {
							$temp[$k]= '0';
							$temp[$k-1]= '1';
							$flag = 0;
							break;
						}
		
					}else {
						$flag_int = 0;
					}
					$k++;	
				}	
			}

			//for ($i=0; $i<=count($temp); $i++){
				//$gap .= "$temp[$i]";
			//}
			//sort($temp);
			//$gap = implode("", $temp);
			//print_r($temp);
			$b = 0;
			foreach ($temp as $index => $value) {
				 $arr[$b]['index'] = $index;
				 $arr[$b]['val'] = $value;
				 $v++;
			}
			//print_r($arr);
			sort($arr);	
			//print_r($arr);
			$l = 0;
			foreach ($arr as $inde => $valu) {
				$gap .= $valu['val'];			
			}	
			
			//print_r($ar);
			//$gap = implode("", $re);
			//print_r($temp);
			//exit;
			
			$axes = array();
			$grid = array();
			$min_clear_flot = array(); $min_without_float =array();
			$axes['list']['min'] = $min;
			$flag_float = 0; $r=0;
			
			while ($check_max != 0){
				if($find_max == 1){
					if($gap >= 1){
						$res = $min%$gap;
						if($gap == 1){
							$min_clear_flot = (string)$min;
							
							while($check_exist_float == 1){
								if($min_clear_flot[$h] == "."){
									if($min_clear_flot[$h+1] == 0){
										if($min_clear_flot[$h+2] == 0){
											if($min_clear_flot[$h+3] == 0){
												if($min_clear_flot[$h+4] == 0){
													
												}else{
												$min_without_float[$h-1] = $min_clear_flot[$h-1] + 1;
												$check_exist_float = 0;}
											}else{ 
											$min_without_float[$h-1] = $min_clear_flot[$h-1] + 1;
											$check_exist_float = 0;}
										}else{ 
										$min_without_float[$h-1] = $min_clear_flot[$h-1] + 1;
										$check_exist_float = 0;}
									}else{
									$min_without_float[$h-1] = $min_clear_flot[$h-1] + 1;
									$check_exist_float = 0;}
								}else{
									$min_without_float[$h] = $min_clear_flot[$h];
								}
								
								$h++;
							}
						}
						if($res == 0 && (($gap != 2) or ($gap != 5))){
							$min_clear_flot = (string)$min;
							$n =0;
							while($check_exist_float == 1)
							{	
								if($min_clear_flot[$n] == "." || $min_clear_flot[$n] == null){
									if($min_clear_flot[$n+1] >= 5){
										$min_without_float[$n-1] = $min_clear_flot[$n-1]+1;
										if($min_clear_flot[$n-1] >= 5){
											$min_without_float[$n-2] = $min_clear_flot[$n-2] + 1;
											if($min_clear_flot[$n-2] >= 5){
												$min_without_float[$n-3] = $min_clear_flot[$n-3] + 1; 
											}
										}
									}
									$check_exist_float = 0;
								}else{
									$min_without_float[$n] = $min_clear_flot[$n];
								}
								
								$n++ ;
							}
							for($s = 0; $s <= count($min_without_float); $s++){
								if($check_float == 1)
									$base_min .= $min_without_float[$s];						
								$check_float = 0;
							}
							$base = $base_min;
						}else{
							$add = ($gap - $res);
							$min_clear_flot = (string)$min;
							if($res == 0 && (($gap != 2) or ($gap != 5))){
								$base = $min;					
							}else{
								$add = ($gap - $res);
								$min_clear_flot = (string)$min;
								while($flag_float == 0){
									if($min_clear_flot[$r] == "." || $min_clear_flot[$r] == NULL){
										if($min_clear_flot[$r+1] >= 5){
											$min_without_float[$r] = $min_clear_flot[$r] + 1;
											if($min_clear_flot[$r] > 9){
												$min_without_float[$r-1] = $min_clear_flot[$r-1] + 1;
												if($min_clear_flot[$r-1] > 9){
													$min_without_float[$r-2] = $min_clear_flot[$r-2] + 1;
												}
											}
										}
										$flag_float = 1;
									}else{
										$min_without_float[$r] = $min_clear_flot[$r];
									}
									$r++;
								}	
							}
							$min_clear = '';
							//print_r($min_without_float);
							$a = 0;
							for ($x = 0; $x <= count($min_without_float); $x++){
								$min_clear .= "$min_without_float[$x]";
							}
							
							$base = $min_clear + $add;
							if($first == 1){
								$axes['list'][$m] = $base;
								$axes['dx'][$m] = (((($axes['list'][$m] - $min)/($max - $min))*($Axes-(-$Axes)))+(-$Axes));
								$first = 0;
							}
							$q == 0;
						}
						// check for reset flag
						if(($base + $gap*$m) > $max){
							$find_max = 0;
							$check_max = 0;
						}elseif ($q == 1){
		
							$axes['list'][$m] = $base + $gap*$m;
							$axes['dx'][$m] = (((($axes['list'][$m] - $min)/($max - $min))*($Axes-(-$Axes)))+(-$Axes));
						}
						
					}else{ /*$gap < 1*/
					
						$min_t = (string)$min;  
						$f=count($temp) ; 
						$f=$f-1 ;
						$dd = $temp[$f];
						if($one == 1){
							if ($temp[$f] == 0){
								$cal = count($temp) - 1;
								$div = $temp[$cal-1];
								$dd = $temp[count($temp)];
							}else{   
									$uu =1; $p =1; $cont =1; $yy=1;
								
									while($uu == 1){
										if($yy == 1){
											if($min_t[$x] == '.'){
												$yy = 0;
											}
											$no = $no + 1;
										}else{
											$no = $no + 1;
											$cont = $cont + 1;
											if($cont == count($temp)){
												$uu = 0;
											}
										}
										$x++;
									}
		
								
								$cal = $no-1;
								$div = $temp[$f];
							}
							$one =0;
						}

						$res_min = $min_t[$cal]%$div;
						$add_min = $gap[$f] - $res_min;
						if($check == 0){
						if(($min_t[$cal] + $add_min) >= 10){
							$min_t[$cal] = 0;
							if($min_t[$cal-1] == '.'){
								//$min_t[$cal-2] = $min_t[$cal-2] +1;
								if(($min_t[$cal-2] +1) >= 10){
									$min_t[$cal-2] = 0;
									if($min_t[$cal-3] == null){
										while ($ee == 1){
											$mint[0] = 1;
											if($ff == 1){
												$mint[$v+1] = $min_t[$v];
												if($min_t[$v] == '.'){
													$ff = 0;
												}
												
											}elseif($ff == 0){	
												$mint[$v+1] = $min_t[$v];
												$cot = $cot +1;
												if($cot == count($temp)){
													$ee =0;
												}
											} 
											$v++;							
										}
										for($z=0; $z<=$v ; $z++){
											$min_t[$z] = $mint[$z];
										}
									}else{
										if(($min_t[$cal-3]+1) >= 10){
											$min_t[$cal-3] = 0;
											if($min_t[$cal-4] == null){
												while ($eee == 1) {
													$mintt[0] = 1;
													if($fff == 1){
														$mintt[$vv+1] = $min_t[$vv];
														if($min_t[$vv] == '.'){
															$fff = 0;
															//$mint[$v] ='.';
														}
														
													}
													elseif($fff == 0){	
														$mint[$vv+1] = $min_t[$vv];
														$cott = $cott +1;
														if($cott == count($temp)){
															$eee =0;
														}
													} 
													$vv++;							
												}
												for($zz=0; $zz<=$vv ; $zz++){
													$min_t[$zz] = $mintt[$zz];
												}
											}else{
												if(($min_t[$cal-4]+1) >= 10){
													$min_t[$cal-4] = 0;
												}else 
													$min_t[$cal-4] = ($min_t[$cal-4]+1);
											}
										}else
											$min_t[$cal-3] = $min_t[$cal-3] + 1;
									}		
								}else 
									$min_t[$cal-2] = $min_t[$cal-2] + 1;
							}else{
								if(($min_t[$cal-1] +1) >= 10){
									$min_t[$cal-1] = 0;
									print_r($min_t);
									if ($min_t[$cal-2] == '.') {	
										$min_t[$cal-2] = '.';
										if(($min_t[$cal-3] +1) >= 10){
											$min_t[$cal-3] = 0;
											
											if(($min_t[$cal-4]+1) >= 10){
												$min_t[$cal-4] = 0;
											}else 
												$min_t[$cal-4] = ($min_t[$cal-5]+1);
										}else 
											$min_t[$cal-3] = $min_t[$cal-3] + 1;
									}else{
										if(($min_t[$cal-2]+1) >= 10){
											$min_t[$cal-2] = 0;
											if ($min_t[$cal-3] == '.'){   
												$min_t[$cal-3] = '.';
												if(($min_t[$cal-4] +1) >= 10){
													$min_t[$cal-4] = 0;
													
													if(($min_t[$cal-5]+1) >= 10){
														$min_t[$cal-5] = 0;
													}else 
														$min_t[$cal-5] = ($min_t[$cal-5]+1);
												}else 
													$min_t[$cal-4] = $min_t[$cal-4] + 1;
											}
										}else 
											$min_t[$cal-2] = ($min_t[$cal-2]+1);
									}
								}else 
									$min_t[$cal-1] = $min_t[$cal-1] + 1;
							}
						}else
							$min_t[$cal] = $min_t[$cal] + $add_min;
							if($min_t[$cal] != 0){
								if($min_t[$cal+1] >= 5){
									$min_t[$cal] = $min_t[$cal]+1;
									if($min_t[$cal] >= 5){
										if($min_t[$cal-1] == "."){
											$min_t[$cal] = 0;
											$min_t[$cal-2] = $min_t[$cal-2]+1;
											if($min_t[$cal-2] >= 10){
												$min_t[$cal-2] = 0;
												$min_t[$cal-3] = $min_t[$cal-3]+1;
											}
										}else{
											$min_t[$cal] = 0;
											$min_t[$cal-1] = $min_t[$cal-1] + 1;}
										if($min_t[$cal-1] >= 10){
											$min_t[$cal-1] = 0;
											$min_t[$cal-2] = $min_t[$cal-2]+1;
										}
									}
								}
							}
							for($s=0;$s<=$cal;$s++){								
								$base_min .= $min_t[$s];
							}
						$check = 1;
						}

						if(($base_min + ($gap*$m)) > $max){
							$find_max = 0;
							$check_max = 0;
						}else{
							$axes['list'][$m] = $base_min + ($gap*$m);
							$axes['dx'][$m] = (((($axes['list'][$m] - $min)/($max - $min))*($Axes-(-$Axes)))+(-$Axes));
						}
					}
					
				}
		
				$m++;
			}
			
			$axes['list']['max'] = $max;
			return $axes;			
		}// end  of  calculate autoaxes function 
		
		public function Calculate_Value_4_Point($obj, $res)
		{   
			require('connectdb.inc.php');
			global $value;
			$value = array();
			//$sql = "select * From `point` Where uid = ".$id."";
			/*$sql = " SELECT * FROM `point` WHERE ((`point`.`observ_point_id` =2) OR(`point`.`observ_point_id` =3)OR (`point`.`observ_point_id` =4)) ";*/

			//$res = mysql_query($sql, $connection);
			$j=0;
			while($obj = mysql_fetch_object($res)){
				$value['name'][$j] = $obj->name;
				$lat_1[$j] = $obj->lat_1;
				$lat_2[$j] = $obj->lat_2;
				$lat_3[$j] = $obj->lat_3;
				$long_1[$j] = $obj->long_1;
				$long_2[$j] = $obj->long_2;
				$long_3[$j] = $obj->long_3;
				if ($lat_1[$j] < 0 || $long_1[$j] < 0){
					$value['lat'][$j] = -((-$lat_1[$j]) + ($lat_2[$j]/60)+ ($lat_3[$j]/3600));
					$value['long'][$j] = -((-$long_1[$j]) + ($long_2[$j]/60)+ ($long_3[$j]/3600));
				}// --------- End loop check if $lat < 0 ---------------------------------------
				elseif($lat_1[$j] == 0){					
					$value['lat'][$j] = (($lat_1[$j]) + ($lat_2[$j]/60)+ ($lat_3[$j]/3600));
					$value['long'][$j] = (($long_1[$j]) + ($long_2[$j]/60)+ ($long_3[$j]/3600));
				}// --------- check if $lat == 0 ---------------------------------------
				elseif($lat_1[$j] > 0){
					$value['lat'][$j] = (($lat_1[$j]) + ($lat_2[$j]/60)+ ($lat_3[$j]/3600));
					$value['long'][$j] = (($long_1[$j]) + ($long_2[$j]/60)+ ($long_3[$j]/3600));	
				}// --------- check if $lat > 0 ---------------------------------------

				$j++;
			}

			/* print_r($value); */
		return $value;
		}// end calculate  value for point
		
		public function Calculate_Point($lat, $long, $lat_min, $lat_f, $lat_max, $long_min, $long_f, $long_max, $region){
			global $result;
			$result = array();
			if($region == 1){
				$sec = 120;
			}elseif($region == 2){
				$sec = 15;
			}elseif ($region == 3){
				$sec = 5;
			}elseif($region == 4){	
				$sec = 0;
			}
			if (($lat >= $lat_min) && ($lat <= $lat_max)){
				if (($long >= $long_min) && ($long <= $long_max)){
					$result['lat'] = ((($long - $long_f)/($sec/3600))+1);
					//if($lat < 0){
						$result['long'] = ((($lat_f - $lat)/($sec/3600))+1);
					//}else{
						//$result['long'] = ((($lat - $lat_f)/($sec/3600))+1);
					//}
					return $result;
					//exit;
				}
			}else{
				return NULL;
				//exit;
			}//
		//print_r($result);
			
		}
		
		public function Calculate_Point_Table($point_data, $point_name, $Grid_x, $Grid_y, $filename)
		{
			//$observ = array();
			//$point_data = array();
			global $point_table;
			$point_table = array();
			//$point
			if (file_exists($filename)) {
				/* open file for reading the content */
				$fp = fopen($filename, "r"); 
			
				$column = 1;	$row = 1;
				while($buff = fgets($fp, 20))
				{
					if($column == ($Grid_x)){
						//echo $row.":".$column." \n";
						$point[$row][$column] = $buff;
						$column = 0;
						$row++;
						
					}else{
						$point[$row][$column] = $buff;
						//echo $row.":".$column." ";
					}
					$column++;	
				}				
			}
			
			for($i = 0; $i <= count($point); $i++){
				if($point[round($point_data[$i]['lat'])][round($point_data[$i]['long'])] != NULL){
					$point_table[$point_name[$i]] = $point[round($point_data[$i]['lat'])][round($point_data[$i]['long'])];
				}
			}
			return $point_table;
		}
	} 
?>