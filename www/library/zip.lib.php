<?php
	class zipfile {
		var $datasec = array();
		var $ctrl_dir = array();
		var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
		var $old_offset = 0;
		
		function add_dir($name) {
			$name = str_replace("", "/", $name);
			
			$fr = "\x50\x4b\x03\x04";
			$fr .= "\x0a\x00";
			$fr .= "\x00\x00";
			$fr .= "\x00\x00";
			$fr .= "\x00\x00\x00\x00";
			
			$fr .= pack("V",0);
			$fr .= pack("V",0);
			$fr .= pack("V",0);
			$fr .= pack("v", strlen($name) );
			$fr .= pack("v", 0 );
			$fr .= $name;
			$fr .= pack("V", 0);
			$fr .= pack("V", 0);
			$fr .= pack("V", 0);
			
			$this -> datasec[] = $fr;
			$new_offset = strlen(implode("", $this->datasec));
			
			$cdrec = "\x50\x4b\x01\x02";
			$cdrec .="\x00\x00";
			$cdrec .="\x0a\x00";
			$cdrec .="\x00\x00";
			$cdrec .="\x00\x00";
			$cdrec .="\x00\x00\x00\x00";
			$cdrec .= pack("V",0);
			$cdrec .= pack("V",0);
			$cdrec .= pack("V",0);
			$cdrec .= pack("v", strlen($name) );
			$cdrec .= pack("v", 0 );
			$cdrec .= pack("v", 0 );
			$cdrec .= pack("v", 0 );
			$cdrec .= pack("v", 0 );
			$ext = "\x00\x00\x10\x00";
			$ext = "\xff\xff\xff\xff";
			$cdrec .= pack("V", 16 );
			$cdrec .= pack("V", $this -> old_offset );
			$cdrec .= $name;
			
			$this -> ctrl_dir[] = $cdrec;
			$this -> old_offset = $new_offset;
			return;
		}
		
		function add_file($data, $name) {
			$fp = fopen($data,"r");
			$data = fread($fp,filesize($data));
			fclose($fp);
			$name = str_replace("", "/", $name);
			$unc_len = strlen($data);
			$crc = crc32($data);
			$zdata = gzcompress($data);
			$zdata = substr ($zdata, 2, -4);
			$c_len = strlen($zdata);
			$fr = "\x50\x4b\x03\x04";
			$fr .= "\x14\x00";
			$fr .= "\x00\x00";
			$fr .= "\x08\x00";
			$fr .= "\x00\x00\x00\x00";
			$fr .= pack("V",$crc);
			$fr .= pack("V",$c_len);
			$fr .= pack("V",$unc_len);
			$fr .= pack("v", strlen($name) );
			$fr .= pack("v", 0 );
			$fr .= $name;
			$fr .= $zdata;
			$fr .= pack("V",$crc);
			$fr .= pack("V",$c_len);
			$fr .= pack("V",$unc_len);
			
			$this -> datasec[] = $fr;
			$new_offset = strlen(implode("", $this->datasec));
			
			$cdrec = "\x50\x4b\x01\x02";
			$cdrec .="\x00\x00";
			$cdrec .="\x14\x00";
			$cdrec .="\x00\x00";
			$cdrec .="\x08\x00";
			$cdrec .="\x00\x00\x00\x00";
			$cdrec .= pack("V",$crc);
			$cdrec .= pack("V",$c_len);
			$cdrec .= pack("V",$unc_len);
			$cdrec .= pack("v", strlen($name) );
			$cdrec .= pack("v", 0 );
			$cdrec .= pack("v", 0 );
			$cdrec .= pack("v", 0 );
			$cdrec .= pack("v", 0 );
			$cdrec .= pack("V", 32 );
			$cdrec .= pack("V", $this -> old_offset );
			
			$this -> old_offset = $new_offset;
			
			$cdrec .= $name;
			$this -> ctrl_dir[] = $cdrec;
		}
		
		function file() {
			$data = implode("", $this -> datasec);
			$ctrldir = implode("", $this -> ctrl_dir);
			
			return
			$data .
			$ctrldir .
			$this -> eof_ctrl_dir .
			pack("v", sizeof($this -> ctrl_dir)) .
			pack("v", sizeof($this -> ctrl_dir)) .
			pack("V", strlen($ctrldir)) .
			pack("V", strlen($data)) .
			"\x00\x00";
		}
	}
	
	function extractZip( $zipFile = '', $dirFromZip = '' )
	{   
		define(DIRECTORY_SEPARATOR, '/');
	
		$zipDir = getcwd() . DIRECTORY_SEPARATOR;
		$zip = zip_open($zipDir.$zipFile);
	
		if ($zip)
		{
			while ($zip_entry = zip_read($zip))
			{
				$completePath = $zipDir . dirname(zip_entry_name($zip_entry));
				$completeName = $zipDir . zip_entry_name($zip_entry);
			   
				// Walk through path to create non existing directories
				// This won't apply to empty directories ! They are created further below
				if(!file_exists($completePath) && preg_match( '#^' . $dirFromZip .'.*#', dirname(zip_entry_name($zip_entry)) ) )
				{
					$tmp = '';
					foreach(explode('/',$completePath) AS $k)
					{
						$tmp .= $k.'/';
						if(!file_exists($tmp) )
						{
							@mkdir($tmp, 0777);
						}
					}
				}
			   
				if (zip_entry_open($zip, $zip_entry, "r"))
				{
					if( preg_match( '#^' . $dirFromZip .'.*#', dirname(zip_entry_name($zip_entry)) ) )
					{
						if ($fd = @fopen($completeName, 'w+'))
						{
							fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
							fclose($fd);
						}
						else
						{
							// We think this was an empty directory
							mkdir($completeName, 0777);
						}
						zip_entry_close($zip_entry);
					}
				}
			}
			zip_close($zip);
		}
		return true;
	}

?>