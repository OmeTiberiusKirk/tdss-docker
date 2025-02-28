<?php
	
	require_once('ssh.class.php');
	require_once('setting.inc.php');
	
	$a = $_SERVER['SCRIPT_NAME'];
	$a = explode("/", $a);
	$script_name = $a[3];
	
	class Formulate
	{
		private $NETWORK_TEMPLATE;
		private $GENERAL_TEMPLATE;
		private $CFG_TEMPLATE;
		private $SH_TEMPLATE;
		
		private $contents_general_file;
		private $contents_network_file;
		private $contents_cfg_file;
		private $contents_runsh_file;
		
		private $tmpfile_general_file;
		private $tmpfile_network_file;
		private $tmpfile_cfg_file;
		private $tmpfile_runsh_file;
		
		private $remote_working_dir;
		private $local_tmp_dir;
		
		private $formuated_data_filename;
		
		private $ssh_object;
		
		public function __construct(
			$network_template_location, 
			$general_template_location, 
			$cfg_template_location, 
			$sh_template_location,
			$working_dir)
		{
			global $visualizer;
			global $tmpfile_prefix;
			
			$this->NETWORK_TEMPLATE = $network_template_location;
			$this->GENERAL_TEMPLATE = $general_template_location;
			$this->CFG_TEMPLATE = $cfg_template_location;
			$this->SH_TEMPLATE = $sh_template_location;
			
			$this->ssh_object = new SSH();
			
			$this->ssh_object->connect($visualizer['hostname'], 22, $visualizer['username'], $visualizer['password']);
			if($this->ssh_object->isError())
				echo $this->ssh_object->getError();
				
			$this->ssh_object->makeDirectory($visualizer['working_dir'], $working_dir);
			if($this->ssh_object->isError())
				echo $this->ssh_object->getError();
				
			$this->remote_working_dir = $visualizer['working_dir'].$working_dir."/";
				
			$this->tmpfile_general_file = $tmpfile_prefix."general-".$working_dir.".general";
			$this->tmpfile_network_file = $tmpfile_prefix."network-".$working_dir.".net";
			$this->tmpfile_cfg_file = $tmpfile_prefix."cfg-".$working_dir.".cfg";
			$this->tmpfile_runsh_file = $tmpfile_prefix."runsh-".$working_dir.".sh";
		}
		
		public function CreateWorkingDirectory($dir_name)
		{
			
		}
		
		public function CreateNetworkOfModule($general_filepath, $general_filename, $export_filepath, & $network_file_location)
		{   			
			$this->formulate_data_filename = $export_filepath;
			$handle = fopen($this->NETWORK_TEMPLATE, "r");
			if ($handle) 
			{
				while (!feof($handle)) 
				{
					$buffer = fgets($handle, 1024);
					if(preg_match("/GENERAL_FILEPATH/", $buffer))
						$this->contents_network_file .= str_replace("GENERAL_FILEPATH", $general_filepath, $buffer);
					else
					{
						if(preg_match("/GENERAL_FILENAME/", $buffer))
							$this->contents_network_file .= str_replace("GENERAL_FILENAME", $general_filename, $buffer);
						else
						{
							if(preg_match("/EXPORT_FILEPATH/", $buffer))
								$this->contents_network_file .= str_replace("EXPORT_FILEPATH", $export_filepath, $buffer);
							else
								$this->contents_network_file .= $buffer;
						}
					}
    			}
			    fclose($handle);
			}
			
			file_put_contents(TEMP_DIR.$this->tmpfile_network_file, $this->contents_network_file);

			$this->ssh_object->remoteCopyFile($this->remote_working_dir.$this->tmpfile_network_file, "<-", TEMP_DIR.$this->tmpfile_network_file);
			$network_file_location = $this->remote_working_dir.$this->tmpfile_network_file;
		}
		
		
		
		public function CreateGeneralFile($input_location, $gridsize_x, $gridsize_y, $data_order, $timestep=null)
		{
			$handle = fopen($this->GENERAL_TEMPLATE, "r");
			if ($handle) 
			{
				$count_line = 1;
				while (!feof($handle)) 
				{
					$buffer = fgets($handle, 1024);
					if(preg_match("/__FILE_LOCATION__/", $buffer))
						$buffer = str_replace("__FILE_LOCATION__", $input_location, $buffer);
					
					if(preg_match("/__GRIDSIZE_X__/", $buffer))
						$buffer = str_replace("__GRIDSIZE_X__", $gridsize_x, $buffer);
					
					if(preg_match("/__GRIDSIZE_Y__/", $buffer))
						$buffer = str_replace("__GRIDSIZE_Y__", $gridsize_y, $buffer);
					
					if(preg_match('/__DATA_ORDER__/', $buffer))
						$buffer = str_replace("__DATA_ORDER__", $data_order, $buffer);
					
					if($count_line == 4 && $timestep != null)
						$buffer .= "series = ".$timestep.", 1, ".$gridsize_y."\n";
						
					$this->contents_general_file .= $buffer;
					
					$count_line++;
    			}
			    fclose($handle);
			}
			
			file_put_contents(TEMP_DIR.$this->tmpfile_general_file, $this->contents_general_file);
			$this->ssh_object->remoteCopyFile($this->remote_working_dir.$this->tmpfile_general_file, "<-", TEMP_DIR.$this->tmpfile_general_file);		
		}
		
		public function CreateCFG($general_file_location)
		{
			$handle = fopen($this->CFG_TEMPLATE, "r");
			if ($handle) 
			{
				while (!feof($handle)) 
				{
					$buffer = fgets($handle, 1024);
					if(preg_match("/__GENERAL_FILE_LOCATION__/", $buffer))
						$this->contents_cfg_file .= str_replace("__GENERAL_FILE_LOCATION__", $general_file_location, $buffer);
					else
						$this->contents_cfg_file .= $buffer;
    			}
			    fclose($handle);
			}
			
			file_put_contents(TEMP_DIR.$this->tmpfile_cfg_file, $this->contents_cfg_file);
			$this->ssh_object->remoteCopyFile($this->remote_working_dir.$this->tmpfile_cfg_file, "<-", TEMP_DIR.$this->tmpfile_cfg_file);		
		}
		
		public function CreateRunSH($network_file_location, $formulate_dir)
		{
			$handle = fopen($this->SH_TEMPLATE, "r");
			if ($handle) 
			{
				while (!feof($handle)) 
				{
					$buffer = fgets($handle, 1024);
					if(preg_match("/__NETWORK_FILE_LOCATION__/", $buffer))
						$this->contents_runsh_file .= str_replace("__NETWORK_FILE_LOCATION__", $network_file_location, $buffer);
					else
					{
						if(preg_match("/__FORMULATE_DIR__/", $buffer))
							$this->contents_runsh_file .= str_replace("__FORMULATE_DIR__", $formulate_dir, $buffer);
						else
							$this->contents_runsh_file .= $buffer;
					}
    			}
			    fclose($handle);
			}
			
			file_put_contents(TEMP_DIR.$this->tmpfile_runsh_file, $this->contents_runsh_file);
			$this->ssh_object->remoteCopyFile($this->remote_working_dir.$this->tmpfile_runsh_file, "<-", TEMP_DIR.$this->tmpfile_runsh_file, 0755);			
		}
		
		public function transferData($data_local_location, $data_filename)
		{
			echo "local = ".$data_local_location."\n";
			echo "remote = ".$this->remote_working_dir.$data_filename."\n";
			
			global $tmpfile_prefix;
			$this->ssh_object->remoteCopyFile($this->remote_working_dir.$data_filename, "<-", $data_local_location);
		}
		
		public function executeDXSHELL()
		{
			$sh = $this->remote_working_dir.$this->tmpfile_runsh_file;
			echo "! execute = ".$sh."\n";
			$output = $this->ssh_object->executeSH($sh) ;
			echo "System Output : Data Formulation Process 1\n";
			echo "-----------------------------------------------------------------------------------------\n";
			foreach($output as $line)
				echo $line;
		}
		
		public function getFormulatedDataBack($local_location)
		{
			$formulate_data_filepath = $this->formulate_data_filename.".dx";
			echo "! in function `".__FUNCTION__."`\n";
			echo "! remote = ".$formulate_data_filepath."\n";
			echo "! local = ".$local_location."\n";
			$this->ssh_object->remoteCopyFile($formulate_data_filepath, "->", $local_location);
			if($this->ssh_object->isError())
			{
				echo "\n\nSystem Output : Data Formulation Process 2\n";
				echo "-----------------------------------------------------------------------------------------\n";			
				echo "Error Message : ".$this->ssh_object->getError()."\n\n";
				return false;
			}else
				return true;
		}
		
		public function cleanUp()
		{
			global $formulate;
			
			if($formulate['delete_flag'] == true)
			{
				$cmd = "rm -rf ".$this->remote_working_dir;
				$output = $this->ssh_object->executeSH($cmd);
				echo $output;
			}
		}
	}
?>