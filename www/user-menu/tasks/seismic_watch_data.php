<?php
	session_start();
	
	if(!isset($_SESSION['username'])) {
		echo "<script language=\"javascript\">location.href='../../';</script>";
	}
	
	if($_REQUEST['clear'] == "true") {
		require_once('../../library/connectdb.inc.php');
		$sql = "TRUNCATE TABLE `seismic_watch_param`";
		mysql_query($sql, $connection); 
	}
	
	require_once('../../library/connectdb.inc.php');
	$sql = "SELECT * FROM `seismic_watch_param` ORDER BY `seismic_watch_param`.`id` DESC ";
	$result = @mysql_query($sql, $connection) or die("error code ".(++$i)." : ".__LINE__);
	$num_rows = @mysql_num_rows($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seismic Watch Data History</title></head>
<body style="font-family:Tahoma;">
<div align="center">
  <table style="border:1px #000000 solid" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td colspan="15" bgcolor="#EAEAEA" style="border-bottom:#999999 solid 1px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><font size="-1"><a href="<?=$_SERVER['PHP_SELF']?>">Reload</a></font></td>
            <td align="right"><font size="-1"><div id="last_data"></div></font></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="13"><div align="center">
          <h2 id="sum_all">Analyzed Data from Seismic Watch</h2>
        </div></td>
    </tr>
    <tr>
      <td colspan="13"><div align="center">
          <p><font size="-1"><font style="background-color:RED">&nbsp;&nbsp;</font>&nbsp; M &ge; 7.0,&nbsp;&nbsp;<font style="background-color:ORANGE">&nbsp;&nbsp;</font>&nbsp; 6.0 &le; M &lt; 7.0,&nbsp;&nbsp;<font style="background-color:YELLOW">&nbsp;&nbsp;</font>&nbsp; 5.0 &le; M &lt; 6.0</font></p>
        </div></td>
    </tr>
    <tr>
      <td colspan="13"></td>
    </tr>
    <tr>
      <!-- <td>UNIV_ID</td>
    <td>UNIV_NAME_TH</td>
    <td>FAC_ID</td>
    <td>FAC_NAME_TH</td>
    <td><strong>DEPT_ID</strong></td>-->
      <td><div align="center"><font size="-1"><strong>&nbsp;ID&nbsp;</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>Thailand</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>Magnitude</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>&nbsp;Latitude&nbsp;</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>&nbsp;Longitude&nbsp;</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>Depth</strong></font></div></td>
      <td><div align="center"><strong><font size="-1">Distance</font></strong></div></td>
      <td><div align="center"><font size="-1"><strong>Position</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>Announcement</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>Width(km)</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>Length(km)</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>Observe Level</strong></font></div></td>
      <td><div align="center"><font size="-1"><strong>From&nbsp;IP&nbsp;</strong></font></div></td>
    </tr>
    <?php
	$i=0;
    while($obj = mysql_fetch_object($result)) {
		if($i == 0) {
			?>
    <script language="javascript">
				document.getElementById('last_data').innerHTML = 'Last update on <?=date('l jS \of F Y G:i:s', $obj->create_datetime)?>';
			</script>
    <?php
		}
		if($obj->magnitude >= 7.0) {
			$bgcolor = "RED";
		}elseif($obj->magnitude < 7.0 && $obj->magnitude >= 6.0) {
			$bgcolor = "ORANGE";
		}elseif($obj->magnitude < 6.0 && $obj->magnitude >= 5.0) {
			$bgcolor = "YELLOW";
		}else {
			/*if($i%2 == 0)
			 	$bgcolor = "#CCCCCC";
			else
				$bgcolor = "#999999";
			*/
			$bgcolor = "";
		}
		$i++;
	?>
    <tr>
      <!--<td>1</td>
    <td>จุฬาลงกรณ์มหาวิทยาลัย</td>
    <td>210</td>
    <td>คณะวิทยาศาสตร์</td>
    <td>891</td>-->
      <td style="border-bottom:#999999 dotted 1px"><div align="center"><font size="-1"> &nbsp;
          <?=($i == 1) ? "<font color=\"#990000\">*</font>" : "" ?>
          &nbsp;
          <?=$obj->id?>
          &nbsp;&nbsp;</font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="left"><font size="-1"> &nbsp;&nbsp;
          <?=str_replace(" ", "&nbsp;", $obj->local_time)?>
          &nbsp;&nbsp;</font></div></td>
      <td style="border-bottom:#999999 dotted 1px; background-color: <?=$bgcolor?>"><div align="center"><font size="-1">
          <?=number_format($obj->magnitude, 1)?>
          </font> </div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="right"><font size="-1"> &nbsp;&nbsp;
          <?=number_format($obj->latitude, 2)?>
          &nbsp;&nbsp;</font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="right"><font size="-1"> &nbsp;&nbsp;
          <?=number_format($obj->longitude, 2)?>
          &nbsp;&nbsp;</font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="center"><font size="-1"> &nbsp;&nbsp;
          <?=number_format($obj->depth, 1)?>
          &nbsp;&nbsp;</font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="center"><font size="-1">
        <?=number_format($obj->distance, 2)?>
      </font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="center"><font size="-1">
        <?=$obj->position?>
      </font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="center"><font size="-1">
        <?=$obj->announce_criteria?>
      </font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="center"><font size="-1">
        <?=$obj->epi_width?>
      </font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="left"><font size="-1"> &nbsp;&nbsp;
          <?=$obj->epi_length?></font>
          &nbsp;&nbsp; </div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="center"><font size="-1">
        <?=$obj->observe_level?>
      </font></div></td>
      <td style="border-bottom:#999999 dotted 1px"><div align="right"><font size="-1"> &nbsp;&nbsp;
          <?=$obj->from_ip?>
          &nbsp;&nbsp;</font></div></td>
    </tr>
    <?php
    }
	?>
    <tr bgcolor="#EAEAEA">
      <td colspan="13"><div align="center">
          <?php
      if($_REQUEST['clear'] == 'true') {
	  ?>
          <form id="form1" name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>?clear=true">
            <label>
            <input type="submit" name="clear" id="clear" value="Clear" />
            </label>
          </form>
          <?php
        }else echo "&nbsp;";
		?>
        </div></td>
    </tr>
  </table>
</div>
</body>
</html>
