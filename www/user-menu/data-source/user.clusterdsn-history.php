<?php
	session_start();
	
	if(!isset($_SESSION['username']))
	{
		echo "<script language=\"javascript\">location.href='../';</script>";
	}
	
	if($_REQUEST['id'])
	{
		require_once('../library/connectdb.inc.php');
		
		if ( $_REQUEST['id'] >= 1 )
		{
			$sql = "DELETE FROM clusterdsn WHERE id=".$_REQUEST['id'].";";
			if(!mysql_query($sql, $connection))
			{
				?>
				<script language="javascript">
					alert('Fatal Error : Could not delete Cluster DSN `'+<?=$_REQUEST['dsn']?>+'`.');
				</script>
				<?php
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cluster DSN History</title>
<script language="javascript">
	function winMove()
	{
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		window.moveTo(windowWidth/4, windowHeight/4);
		//window.resizeTo(windowWidth,windowHeight);
	}
	
	function confirm_delete(id, dsn)
	{
		var c = confirm('Do you really want to delete `'+dsn+'` ?');
		if(c)
			window.location.href = '<?=$_SERVER['PHP_SELF']?>?id='+id+'&dsn='+dsn;
		else
			return;
	}
	
	function SendInfo(dsn_val) {
    	//var dsn_val = document.dsn_form.dsn.value;
		alert(dsn_val);
        window.opener.document.dsn.value = dsn_val;
        window.close();
	}
</script>
<link type="text/css" rel="stylesheet" href="../../style/forum.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="th">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #ECE9E8;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
.style2 {font-size: 14px}
-->
</style>
</head>
<body class="bodies">
<center>
  <table border="0" cellpadding="0" cellspacing="0" class="fb_blocktable" id="fb_flattable">
				  <tbody>
					
					<tr>
					  <td class="fb_contentheading" id="fb_fspot" colspan="4"><div align="center"><span class="td-1"><strong>Cluster DSN History </strong></span></div></td>
					</tr>
					<tr class="fb_sectiontableentry1">
					  <td><div align="center"><strong>No.</strong></div></td>
					  <td><div align="center"><strong>DSN String </strong></div></td>
					  <td class="td-4"><div align="center"><strong><span class="td-5 style2">Date</span></strong></div></td>
					  <td class="td-4"><div align="center"><strong><span class="td-5 style2">Action</span></strong></div></td>
					</tr>
					<?php
					require_once('../../library/connectdb.inc.php');
					
					$sql = "SELECT * FROM clusterdsn WHERE uid = ".$_SESSION['uid'].";";
					$res = mysql_query($sql, $connection);
					if ( mysql_num_rows($res) > 0 )
					{
						while($row = mysql_fetch_object($res))
						{
					?>
						<tr class="fb_sectiontableentry1">
					  <td class="td-1"><div align="center">&nbsp;&nbsp;<?=$row->id?>&nbsp;&nbsp;</div></td>
					  <td class="td-1"><div align="left"><a href="javascript: SendInfo('<?=$row->dsnstring?>');"><font color="blue">
				      <?php
					  	$temp = $row->dsnstring;
						$t = array();
						$t['username'] = strtok($temp, ":");
						$t['password'] = strtok("@");
						$t['hostname'] = strtok(":");
						$t['directory'] = strtok(NULL);
						echo $t['username']."@".$t['hostname'].":".$t['directory'];
					  
					  ?>
					    </font></a></div></td>
					  <td class="td-4"><div align="center">&nbsp;&nbsp;<?=date('d/m/y', $row->date);?>&nbsp;&nbsp;</div></td>
					  <td class="td-4"><div align="center">&nbsp;&nbsp;<a href="javascript: confirm_delete(<?=$row->id?>, '<?=$row->dsnstring?>');"><font color="#FF0000">delete</font></a>&nbsp;&nbsp;</div></td>
					</tr>
					<?php
						}
					}else
					{
					?>
						<tr class="fb_sectiontableentry1">
						  <td colspan="4" class="td-1"><div align="center"><em>no record </em></div></td>
				    </tr>
					<?php
					}
					?>
				  </tbody>
</table>
				<input name="close" type="button" id="close" value="Close this window" onClick="javascript: window.close();" />
</center>
</body>
</html>
