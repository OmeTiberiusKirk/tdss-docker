<?php

	require('setting.inc.php');
	
	$a = $_SERVER['SCRIPT_NAME'];
	$a = explode("/", $a);
	$script_name = $a[3];

    /**
     * define max of output length
     */

	define(SSH2_FETCHOUTPUT_MAX_LENGTH, 5);
	
	/* 
	This class provided by Pemjit Aphimaeteethomrong 
	which used for managing cluster machine environment based on GE 6.0u
	*/
	class SSH {
	
		/* keep cluster connection */
		private $connection;
		
		/* keep authentication information */
		private $hostname;
		private $port;
		private $username;
		private $password;
		
		/* cluster command location or environment */
		private $clusterCmdPath = array();
		
		/* necessary command to use this class */
		private	$cmd_pwd;
		
		
		private $err_message = array();
		private $err_flag = array();
		
		private $last_path;
		
		private $machine_type;
		
		public function __construct() {
			global $visualizer;
			
			/* specify the machine type */
			$this->machine_type = $visualizer['os'];
		}

		/* connect to cluster with $hostname, $port, $username, $password */
		public function connect($hostname, $username, $password, $port = 22) {
			/* assign information to class property */
			$this->hostname = $hostname;
			$this->port = $port;
			$this->username = $username;
			$this->password = $password;
			
			/* check the @ssh2 extension is loaded */
			if (!extension_loaded('ssh2')) {
			
				/* check exists php_@ssh2.dll */
   			if (!dl('ssh2.so')) {
			       echo "Fatal Error : Could not found ssh2 extension.\n";
				   exit;
				}
   		}
			
			//ADD the ping command to route the specified host
			
			/* using ssh channel to connect to cluster */
			$this->connection = @ssh2_connect($this->hostname, $this->port);
			
			if ($this->connection === FALSE) {
				$this->err_flag = true;
				$this->err_message = "Could not connect to remote host.";
				return;
			}
			
			/* authenticate with username and password */
			$result = @ssh2_auth_password($this->connection, $this->username, $this->password);
			if ( $result == FALSE ) {
				$this->err_flag = true;
				$this->err_message = "Invalid username or password.";
				return;
			}
			/* 
				set variable for getting cluster environment 
				`which` for locate the command path
				`pwd`	for printing working directory
			*/
			$this->cmd_pwd = "pwd";
		}
		
		public function __destruct() {
			return;
		}
		
		/* used for getting an authorized key and execute path*/
		public function getFileList($path) {
			$collect_output = array();
			//$cmd = "ls -l ".$path." | grep '^-' ";
			$cmd = "ls -l ".$path."";
		
			/* get home directory path using `pwd` command */
			$stdout_stream = $this->executeCommand($cmd);
				
			/* fetch output both stdout and stderr */
			$stream = $this->fetchOutput($stdout_stream, SSH2_STREAM_STDERR);
				
			/* get error message (stderr) */
			while($line = fgets($stream['stderr'])) {
				if(strlen($line) >  SSH2_FETCHOUTPUT_MAX_LENGTH) {
					/* ls: /home/pemjit: Permission denied */
					$t = strtok($line, ':');
					$path = strtok(':');
					$query_msg = strtok(':');
					$this->err_flag = true;
					$this->err_message = $path." : ".$query_msg;
					return false;
				}
				//return false;
			}
				
			/* get output message (stdout) */
			$i=0;
			while($line = fgets($stream['stdout'])) {
				if(strlen($line) > SSH2_FETCHOUTPUT_MAX_LENGTH) {
					$permission = strtok($line, ' ');
					if($permission != 'total') {
						$collect_output[$i]['permission'] = $permission;
					
						$something = strtok(' ');
						$collect_output[$i]['something'] = $something;
						
						$username = strtok(' ');
						$collect_output[$i]['username'] = $username;
						
						$groupname = strtok(' ');
						$collect_output[$i]['groupname'] = $groupname;
						
						$filesize = strtok(' ');
						$collect_output[$i]['filesize'] = $filesize;
						
						$month = strtok(' ');
						$collect_output[$i]['month'] = $month;
						
						$date = strtok(' ');
						$collect_output[$i]['date'] = $date;
						
						/* if Linux Fedora Core 8.0 then comment below */
						if($this->machine_type == 'centos') {
							$time = strtok(' ');
							$collect_output[$i]['time'] = $time;
						}
						
						$filename = strtok(' ');
						$collect_output[$i++]['filename'] = $filename;
					}						
						/*		
							CentOS Example:
							-rw-r--r--  1 yod yod      240 Oct 29 18:07 authen
							-rw-r--r--  1 yod yod    56472 Jul 23 23:09 blackbird-1.0.0-stable.tar.gz
							-r--r--r--  1 yod yod     5223 Jun 24  1994 examine.c
						*/
				}
			}
			return $collect_output;
		}
		
		
		public function gridDownloadFile($path, $hostname, $aliasname, $debug_string) {
		
			/* File downloading command, its push into Grid Trusted Host shell*/
			/* and save to visualization/workspace/formulated-data/ with filename $aliasname */
			$cmd_download_file = "globus-url-copy gsiftp://".$hostname."".$path." ftp://pemjit:pemjit@161.200.92.162/visualization/workspace/formulated-data/".$aliasname." ";
			$debug_string[] = __FILE__."@".__LINE__.": command to download file `".$cmd_download_file."`";
			
			/* Execute above command on Grid Trusted Host shell */
		    $stdout_stream_gridfile = $this->executeCommand($cmd_download_file);
		    $debug_string[] = __FILE__."@".__LINE__.": execute command";
			
			/* Fetching both standard output (common output) and standard error (if error), */
			/* the $stream_gridfile contains both stdout and stderr.  */
			/* You may check the $stream_gridfile['stderr'] if error */
			/* and check the $stream_gridfile['stdout'] if success (commonly, its returned blank for above command). */
			$stream_gridfile = $this->fetchOutput($stdout_stream_gridfile, SSH2_STREAM_STDERR);
			$debug_string[] = __FILE__."@".__LINE__.": fetch output";
			
			/* Use below statement for checking the stdout and stderr. */
			/* For the above command, $cmd_download_file contains the blank of both stdout, stderr, if success */
			/* and return some message if something wrong. */
			/* You may test with incorrect password or others.*/
			foreach($stream_gridfile as $stream_name => $stream_value) {
			
				/* first loop for stdout, second loop for stderr */
				/* $output_line contains stdout message and stderr message respectively */
				while($output_line = fgets($stream_value)) {
					/* Print stream name message (stdout, stderr)*/
					$debug_string[] = __FILE__."@".__LINE__.": stream (stdout, stderr) has been fetched ".$stream_name.":".$output_line."";
				}
			}
		}
		
		
		public function gridExpire() {
			$cmd_check_expire = "grid-cert-info -enddate";
			$stdout_stream = $this->executeCommand($cmd_check_expire);
			$stream = $this->fetchOutput($stdout_stream,SSH2_STREAM_STDERR);
			
			while($line = fgets($stream['stderr'])) {
				if(strlen($line) >  SSH2_FETCHOUTPUT_MAX_LENGTH) {
					/* /bin/ls: /home/yod/: Permission denied */
					$t = strtok($line, ':');
					$path = strtok(':');
					$query_msg = strtok(':');
					$this->err_flag = true;
					$this->err_message = $path." : ".$query_msg;
					return false;
				}
				//return false;
			}
			
							
			/* get output message (stdout) */
	
			while($line = fgets($stream['stdout'])) {
				   $grid_expire_output = $line;
			}
			return $grid_expire_output;
			
		}
		
		public function gridGetFileList($path, $hostname, $pass_phrase)
		{
			$collect_output = array();
			
			$cmd_create_proxy = "echo \"".$pass_phrase."\" | grid-proxy-init -pwstdin";
			
			$stdout_stream_proxy = $this->executeCommand($cmd_create_proxy);
			$stream_proxy = $this->fetchOutput($stdout_stream_proxy, SSH2_STREAM_STDERR);
			//$cmd = "ls -l ".$path." | grep '^-' ";
			$cmd = "globus-job-run ".$hostname." /bin/ls -l ".$path." ";
		
			/* get home directory path using `pwd` command */
			$stdout_stream = $this->executeCommand($cmd);
				
			/* fetch output both stdout and stderr */
			$stream = $this->fetchOutput($stdout_stream, SSH2_STREAM_STDERR);
				
			/* get error message (stderr) */
			while($line = fgets($stream['stderr'])) {
				if(strlen($line) >  SSH2_FETCHOUTPUT_MAX_LENGTH) {
					/* /bin/ls: /home/yod/: Permission denied */
					$t = strtok($line, ':');
					$path = strtok(':');
					$query_msg = strtok(':');
					$this->err_flag = true;
					$this->err_message = $path." : ".$query_msg;
					return false;
				}
				//return false;
			}
			
							
			/* get output message (stdout) */
			$i=0;
			while($line = fgets($stream['stdout'])) {
				if(strlen($line) > SSH2_FETCHOUTPUT_MAX_LENGTH) {
					$permission = strtok($line, ' ');
					if($permission != 'total') {
						$collect_output[$i]['permission'] = $permission;
					
						$something = strtok(' ');
						$collect_output[$i]['something'] = $something;
						
						$username = strtok(' ');
						$collect_output[$i]['username'] = $username;
						
						$groupname = strtok(' ');
						$collect_output[$i]['groupname'] = $groupname;
						
						$filesize = strtok(' ');
						$collect_output[$i]['filesize'] = $filesize;
						
						$month = strtok(' ');
						$collect_output[$i]['month'] = $month;
						
						$date = strtok(' ');
						$collect_output[$i]['date'] = $date;
						
						/* if Linux Fedora Core 8.0 then comment below */
						if($this->machine_type == 'centos') {
							$time = strtok(' ');
							$collect_output[$i]['time'] = $time;
						}
						
						$filename = strtok(' ');
						$collect_output[$i++]['filename'] = $filename;
					}
					
						/*		
						CentOS Example:
									
						-rw-r--r--  1 yod yod      240 Oct 29 18:07 authen
						-rw-r--r--  1 yod yod    56472 Jul 23 23:09 blackbird-1.0.0-stable.tar.gz
						-r--r--r--  1 yod yod     5223 Jun 24  1994 examine.c
						
						*/
					
				}
			}
			return $collect_output;
		}
			
		/* execute specified command */
		private function executeCommand($command) {
			/* execute specified `$command` command */
				return @ssh2_exec($this->connection, $command);
		}
		
		/* fetching output from current executed command before */
		private function fetchOutput($stdout_stream, $flag) {
			/* fetch both stdout/stderr stream from current connection */
			$stderr_stream = @ssh2_fetch_stream($stdout_stream, $flag);					
			if (!$stderr_stream) {
				$this->err_flag = true;
				$this->err_message = "Fatal Error : Could not fetch output.\n";
				return;
			}
			
			/* set blocking stream for fgets() function */
			stream_set_blocking($stderr_stream, true);
			
			/* assign stdout/stderr to array for processing later*/
			$stream['stdout'] = $stdout_stream;
			$stream['stderr'] = $stderr_stream;
			
			/* return stdout/stderr which contained in array to caller */
			return $stream;
		}
		
		//------------------This method use for arrange array -------------------
		private function rearrangeArray($arr) {
			$t = array();
			$i = 0;
			
			foreach ($arr as $value) {
				$t[$this->stat_list[$i++]] = $value;
			}
			
			return $t;
		}
		
		
		//---------------This method use for get error message------------
		public function getError() {
			return $this->err_message;
		}
		
		//---------------This method use for get error flag------------
		
		public function isError() {
			return $this->err_flag;
		}
		
		public function remoteCopyFile($remote_filename, $direction, $local_filename, $mode = 0755) {			
			set_time_limit(0);
			switch($direction) {
				case "->" :
					//echo "! in function `".__FUNCTION__."`\n";
					//echo "! write at ".$local_filename."\n";
					//echo "! recieve from ".$remote_filename."\n";
					if(ssh2_scp_recv($this->connection, $remote_filename, $local_filename))
						return true;
					else {
						$this->err_flag = true;
						$this->err_message = "Could not copy file from `".$remote_filename."` to `".$local_filename."`.";
						//$this->err_message = "Could not copy file from `remote` to `local`.";
					}
					break;
				
				case "<-" :
					if(@ssh2_scp_send($this->connection, $local_filename, $remote_filename, $mode))
						return true;
					else {
						$this->err_flag = true;
						$this->err_message = "Could not copy file from `".$local_filename."` to `".$remote_filename."`.";
					}
				default :
					$this->err_flag = true;
					$this->err_message = "Fatal Error : Invalid direction.";
					break;
			}
		}
		
		public function makeDirectory($dir_abspath, $dir_name=null, $fetch_output_flag=false) {
		
			if($dir_name != null ) {
				$cmd = "mkdir ".$dir_abspath.$dir_name;
			} else {
				$cmd = "mkdir ".$dir_abspath;
			}
			
			$stdout_stream = $this->executeCommand($cmd);
				
			if($fetch_output_flag == true) {
				/* fetch output both stdout and stderr */
				$stream = $this->fetchOutput($stdout_stream, SSH2_STREAM_STDERR);
				
				/* get error message (stderr) */
				while($line = fgets($stream['stderr'])) {
					if(strlen($line) >  SSH2_FETCHOUTPUT_MAX_LENGTH) {
						/* ls: /home/pemjit: Permission denied */
						$t = strtok($line, ':');
						$path = strtok(':');
						$query_msg = strtok(':');
						$this->err_flag = true;
						$this->err_message = $path." : ".$query_msg;
						return false;
					}
					//return false;
				}
				
				/* get output message (stdout) */
				$i=0;
				while($line = fgets($stream['stdout'])) {
					if(strlen($line) > SSH2_FETCHOUTPUT_MAX_LENGTH) {
						$this->err_flag = true;
						$this->err_message = "create directory `".$dir_abspath.$dir_name."` : something wrong";
						return false;
					}
				}
			}
		}
		
		public function changeDir($dis_dir) {
			$cmd = "cd  ".$dis_dir;
			
			$stdout_stream = $this->executeCommand($cmd);
				
			/* fetch output both stdout and stderr */
			$stream = $this->fetchOutput($stdout_stream, SSH2_STREAM_STDERR);
				
			/* get error message (stderr) */
			while($line = fgets($stream['stderr'])) {
				if(strlen($line) >  SSH2_FETCHOUTPUT_MAX_LENGTH) {
					/* ls: /home/pemjit: Permission denied */
					$t = strtok($line, ':');
					$path = strtok(':');
					$query_msg = strtok(':');
					$this->err_flag = true;
					$this->err_message = $path." : ".$query_msg;
					return false;
				}
				//return false;
			}
				
			/* get output message (stdout) */
			$i=0;
			while($line = fgets($stream['stdout'])) {
				if(strlen($line) > SSH2_FETCHOUTPUT_MAX_LENGTH) {
					$this->err_flag = true;
					$this->err_message = "change directory to `".$dis_dir."` : something wrong";
					return false;
				}
			}		
		}
		
		public function executeSH($command, $flag_enable_fetch_output = true) {
			$cmd = $command;
			$stdout_stream = $this->executeCommand($cmd);
				
			/* fetch output both stdout and stderr */
			$stream = $this->fetchOutput($stdout_stream, SSH2_STREAM_STDERR);
			
			$output = "";	
			
			if($flag_enable_fetch_output != false) {
				/* get error message (stderr) */
				while($line = @fgets($stream['stderr'])) {
					$output[] = $line;
					if(strlen($line) >  SSH2_FETCHOUTPUT_MAX_LENGTH) {
						$this->err_flag = true;
						$this->err_message = $line;
						//return false;
					}
					//return false;
				}
				
				/* get output message (stdout) */
				$i=0;
			
				while($line = @fgets($stream['stdout'])) {
					$output[] = $line;
				}		
			}
			return $output;
		}
	}
?>
