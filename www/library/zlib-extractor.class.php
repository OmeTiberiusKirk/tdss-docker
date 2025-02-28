<?php
	/**
	* TAR Class for extract files from Tape Archive file
	* Written by Roongroj Pongsapich
	* Revised by Theerayooth Kosin
	*
	* Version: 0.1
	* Release date: 03 December 2007
	*
	* Version 0.1.1
	* Release date: 01 January 2008
	* 
	* 
	* Class details
	* =============
	* TAR($filename) -- class constructor, $filename is asssociated .tar file
	* obj->files -- array contains tar header for files in archive (see TARheader class for available attributes)
	* obj->setBase($path) -- set base path for extraction (default is ./)
	* obj->noOutput() -- hide debug result
	* obj->extractAll() -- extract all files to directory (according to base path)
	*
	* Utility functions
	* =================
	* ungz($filename) -- extract .tar.gz file to .tar and return .tar filename as result
	*
	* CopyRight
	* =========
	* This file is released under LGPL License (see http://www.gnu.org/licenses/lgpl.txt)
	*
	*/
	
	/**
	 * Example usage:
	 * Archive filename to extract, Supported filetype: .tar.gz, .tar.bz2 (bz2 is not supported on some server)
	 * Destination directory to extract to, the default "./" mean same directory as extract.php
	 * 
	 * 		$ArchiveFilename = "visualizer.tar.gz";
	 *		$DestinationPath = ".";  (current working this script)
	 *			or
	 *		$DestinationPath = "../tmp";
	 *			NOT
	 *		$DestinationPath = "../tmp/";  ( NOTE ! DO not terminate with '/' )
	 */
	
	class TARheader
	{
		public $filename;
		public $offset;
		public $blocksize;
		public $filesize;
		public $filetype;
		
		private $filemode;
		private $ownerID;
		private $groupID;
		private $lastmod;
		private $checksum;
		private $linkfilename;
		
		public function TarHeader($S) 
		{
			$this->filename = trim(substr($S, 0, 100));
			$this->filemode = octdec(trim(substr($S, 100, 8)));
			$this->ownerID = octdec(trim(substr($S, 108, 8))); /* unuse */
			$this->groupID = octdec(trim(substr($S, 116, 8))); /* unuse */
			$this->filesize = octdec(trim(substr($S, 124, 12)));
			$this->lastmod = octdec(trim(substr($S, 136, 12))); /* unuse */
			$this->checksum = octdec(trim(substr($S, 148, 8))); /* unuse */
			$this->filetype = octdec(trim(substr($S, 156, 1)));
			$this->linkfilename = trim(substr($S, 157, 100)); /* unuse */
			$this->offset = 0; /* to be set later by TAR while parsing data */
			$this->blocksize = ceil($this->filesize/512)*512;
		}
	}
	
	/**
	 * TAR class is used for extracting the archive file such as .tar.gz, .tar.bz2
	 *
	 */
	class TAR
	{
		private $filename;
		private $files;
		private $basePath = "./";
		private $debug = true;
		private $tarTempFilename;
		
		public function __construct($src, $dest, $debug=null) 
		{
			$this->initial($src, $dest);
			$this->setBase($dest);
			
			$this->filename = $this->tarTempFilename;
			$fh = fopen($this->tarTempFilename, "rb");
		
			while(!feof($fh)) 
			{
				$header = new TARheader(fread($fh, 512));
				if(!$header->filename) 
					break;
					
				$header->offset = ftell($fh);
				fseek($fh, $header->blocksize, SEEK_CUR);
				$this->files[] = $header;
			}
			
			if($debug != null)
				$this->debug = $debug;
			else
				$this->debug = false;
				
			fclose($fh);
		}
		
		public function initial($ArchiveFilename, $DestinationPath)
		{
			if(!file_exists($ArchiveFilename)) 
				die("Error: Archive not found."); 
				
			if(!is_dir($DestinationPath)) 
			{
				if(!mkdir($DestinationPath)) 
					die("Permission denied: Destination directory is not exists, and cannot be created."); 
			}
			
			if(!is_writable($DestinationPath))
				die("Permission denied: Destination directory is not writable.");
			
			switch($this->extname($ArchiveFilename)) 
			{
				case "gz":
						$this->tarTempFilename = $this->ungz($ArchiveFilename, $DestinationPath);
					break;
					
				case "bz2":
						if(!function_exists("bzopen"))
							die("Error: Bzip file type is not support by this system.");
						else 
							$this->tarTempFilename = $this->unbz2($ArchiveFilename, $DestinationPath); 
					break;
					
				default:
					die("Error: Unsupported archive. Only (.tar.gz) and (.tar.bz2) are supported at this time.");
			}
		}
		
		public function setBase($path) 
		{
			$this->basePath = $path . ((substr($path, -1) != "/") ? "/" : "");
		}
				
		public function extractAll() 
		{
			$fh = fopen($this->filename, "rb");
			#echo $this->filename;
			#echo "-->filename1\n";
			foreach($this->files as $header) 
			{
				#echo $this->files;
			    #echo "-->files\n"; 
				$filename = $this->basePath . $header->filename;
				#echo $this->filename;
   				#echo "-->filename2\n";
				if ($header->filetype == 5) 
				{
					#echo $this->filetype;
   					#echo "-->filetype\n";
					// filename indicate directory
					//mkdir($this->basePath.$header->filename, $header->filemode);
					mkdir($filename, 0755); // new folder with 0777 permission
					if($this->debug) 
					{ 
						#echo $filename . " ---- directory created.\n"; 
					}
				} else if($header->filetype == 0) 
						{
							// filename indicate normal file
							fseek($fh, $header->offset, SEEK_SET);
							$content = $header->blocksize>0 ? fread($fh, $header->filesize) : "";
							$filename = $this->basePath . $header->filename;
							$pif = pathinfo($filename);
							
							if(!is_dir($pif["dirname"])) 
								mkdir($pif["dirname"]);
								
							$tmpfh = fopen($filename, "wb");
							fwrite($tmpfh, $content);
							fclose($tmpfh);
							
							if($this->debug){}
								#echo $filename . " extracted.\n";
						}
			}
			fclose($fh);
			$this->cleanup();
		}
		
		public function ungz($gn, $basepath="./") 
		{
			$tarfilename = $basepath.basename($gn, ".gz");
		
			$gh = gzopen($gn, "rb");
			$fh = fopen($tarfilename, "wb");
	
			while(!gzeof($gh)) 
				fwrite($fh, gzread($gh, 8192));
	
			gzclose($gh);
			fclose($fh);
		
			return $tarfilename;
		}
		
		public function unbz2($bn, $basepath="./") 
		{
			$tarfilename = $basepath . basename($bn, ".bz2");
			$bh = bzopen($bn, "r");
			$fh = fopen($tarfilename, "wb");
			
			while(!feof($bh))
				fwrite($fh, bzread($bh, 8192));
				
			bzclose($bh);
			fclose($fh);
			
			return $tarfilename;
		}
		
		public function extname($filename) 
		{
			$pinfo = pathinfo($filename);
			return $pinfo["extension"];    
		}
		
		public function cleanup()
		{
			unlink($this->tarTempFilename);
		}
	}
	
	/* Example */
	/* 
	$ArchiveFilename = "D:/wwwroot/visualization/workspace/pemjit/visres-20080117-133721/t_image.tar.gz";
	$DestinationPath = "D:/wwwroot/visualization/workspace/pemjit/visres-20080117-133721/image";
	
	$tar = new TAR($ArchiveFilename, $DestinationPath);
	$tar->extractAll();
	*/
?>