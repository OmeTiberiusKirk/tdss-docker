<?php
	session_start();
	require('setting.inc.php');
	require('ssh.class.php');

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
			
			if(!file_exists($this->template_net_loc))
				echo "File is not exist !";
			
			$this->ssh_object = new SSH();
			
			$this->ssh_object->connect($visualizer['hostname'], 22, $visualizer['username'], $visualizer['password']);
			if($this->ssh_object->isError())
				echo $this->ssh_object->getError();
				
			$this->ssh_object->makeDirectory($visualizer['working_dir'], $working_dir);
			if($this->ssh_object->isError())
				echo $this->ssh_object->getError();
			
			$this->ssh_object->makeDirectory($visualizer['working_dir'], $working_dir."/image");
			if($this->ssh_object->isError())
				echo $this->ssh_object->getError();
				
			$this->remote_working_dir = $visualizer['working_dir'].$working_dir."/";
		}
		
		public function createNetworkFile($url_ds_region, $url_ds_data, $tmp_filename, $zoom_t, $resolution_t, $rotate_x_t, $rotate_y_t, $rotate_z_t, $gridsize_x_t, $gridsize_y_t, $timestep_t, $region_t, $data_t)
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
						
						
					//echo $i++."-> ".$buffer;
					$contents_network_file .= $buffer;
    			}
			    fclose($handle);
			}
			
			file_put_contents(TEMP_DIR.$tmpfile_network_file, $contents_network_file);
			$this->remote_network_file_location = $this->remote_working_dir.$tmpfile_network_file;
			$this->ssh_object->remoteCopyFile($this->remote_network_file_location, "<-", TEMP_DIR.$tmpfile_network_file);		
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
	}
?>