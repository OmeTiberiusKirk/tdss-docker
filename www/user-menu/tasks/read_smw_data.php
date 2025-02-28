<?php
	session_start();
	
	$redirect_url = $_SERVER['HTTP_REFERER'];
	$i = 0;
	
	require_once('../../library/connectdb.inc.php');
	$sql = "SELECT * FROM `seismic_watch_param` ORDER BY `seismic_watch_param`.`id` DESC LIMIT 0 , 1";
	$result = @mysql_query($sql, $connection) or die("error code ".(++$i)." : ".__LINE__);
	$num_rows = @mysql_num_rows($result);
	if($num_rows == 1) {
		$obj = mysql_fetch_object($result) or die("error code ".(++$i)." : ".__LINE__);
		$_SESSION['location'] = $obj->location;
		$_SESSION['name'] = 'seismic_watch';
		$_SESSION['lat'] = $obj->latitude;
		$_SESSION['long'] = $obj->longitude;
		$_SESSION['radius'] = 0;
		$_SESSION['magnitude'] = $obj->magnitude;
		$_SESSION['depth'] = $obj->depth;
		
		$date = explode(" ", $obj->local_time);
		$time = $date[1];
		$date = explode("/", $date[0]);
		$date = $date[1]."/".$date[0]."/".($date[2]-543);		
		
		$_SESSION['date'] = $date;
		$_SESSION['time'] = $time;
		#echo "<pre>";
		#var_dump($obj);
		#echo "</pre>";
		$redirect_url = str_replace("&from=smw", "", $redirect_url);
		header("location: ".$redirect_url."&from=smw");
	}else {
		$redirect_url = str_replace("&from=smw", "", $redirect_url);
		?>
        <script language="javascript">
			alert('! no data from Seismic Watch.');
			document.location = '<?=$redirect_url?>';
		</script>
        <?php
	}
?>