<?php
	set_time_limit(0);
	
	/* job-ID, prior, name, user, state, submit/start at, queue, slots ja-task-ID */
	
	$header = "job-ID,prior,name,user,state,submit/start at,queue";
	$stat_list = preg_split('/,/', $header);
	$header = array();

	
	function jobStat($host, $username, $password)
	{
		if (!($connection=@ssh2_connect($host, 22))) 
		{
		   echo "[FAILED]\n";
		   exit(1);
		}
		
		if (!@ssh2_auth_password($connection, $username, $password)) {
		   echo "[FAILED]\n";
		   exit(1);
		}
	
		
		$stdout_stream = ssh2_exec($connection, "qstat");
		sleep(1);
		$stderr_stream = ssh2_fetch_stream($stdout_stream, SSH2_STREAM_STDERR);
		stream_set_blocking($stderr_stream, true);
		
		$i=0;
		$list = array();
		
		while($line = fgets($stderr_stream))
		{ 
			//ob_flush();
			//flush(); 
			$str = preg_replace('/\s\s+/', ' ', $line);
			$arr[] = preg_split("/ /", $str);
			
		}
		
		$i=0;
				
		while($line = fgets($stdout_stream))
		{ 
			flush(); 
			if ($i >= 2)
			{
				$str = preg_replace('/\s\s+/', ' ', $line);
				$arr[$i] = preg_split("/ /", $str);
				$t = $arr[$i][7];
				unset($arr[$i][0]);
				unset($arr[$i][7]);
				unset($arr[$i][9]);
				unset($arr[$i][10]);
				$arr[$i][6] .= " ".$t;
				$arr[$i] = rearrange_array($arr[$i]);
			}
			$i++;
		}
		fclose($stdout_stream);
		return $arr;
	}
	
	function rearrange_array($arr)
	{
		global $header;
		global $stat_list;
		
		$t = array();
		$i = 0;
		foreach ($arr as $value) {
			$t[$stat_list[$i++]] = $value;
		}
		return $t;
	}

?>