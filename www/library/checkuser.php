<?php	
	session_start();
	
	if ( isset($_REQUEST['PHPSESSID'], $_REQUEST['username']))
	{
		require_once('connectdb.inc.php');
		
		if( strlen($_REQUEST['username']) >= 3) 	
		{	
			$sql_check="SELECT `user`.username FROM `user` WHERE `user`.username = '".$_REQUEST['username']."' ";
			$result_check = mysql_query($sql_check, $connection);
			$rows = mysql_num_rows($result_check);
			$count =1;
		}
	}else
		echo "<script language=\"javascript\">alert('Not authorized to access this page directly !'); location.href='../home';</script>";
?>

<style type="text/css">
<!--
body {
	background-color: #E0DFE3;
	margin-left: 0px;
	margin-top: 0px;
}
body,td,th {
	font-family: Tahoma;
	font-size: 14px;
	color: #E8E8E8;
}
a {
	font-family: Tahoma;
	font-size: 14px;
}
.style3 {color: green}
.style5 {
	color: #000000;
	font-weight: bold;
}
.style6 {color: #990000}
-->
</style><title>Check username</title>
<div align="center">
  <table width="200" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td bgcolor="#FFFFCC" style="border-bottom: #000000 5px solid"><div align="center" class="style5">Check username</div></td>
    </tr>
	<?php
	
	if ($rows >= $count)
	{
		//echo "Your username ".$_REQUEST['username']." has been used.";
	?>
    <tr>
      <td height="29"><div align="center"><strong><span class="style4"><?=$_REQUEST['username']?></span>&nbsp;<span class="style6"> is not available.</span></strong></div></td>
    </tr>
	<?php
	}else
	{
	?>
    <tr>
      <td><div align="center"><strong><span class="style3"><?=$_REQUEST['username']?></span><span class="style6"> is available.</span></strong></div></td>
    </tr>
	<?php
	}
	?>
  </table><input name="Close" type="button" onClick="javascript: window.close();" value="Close" />
</div>