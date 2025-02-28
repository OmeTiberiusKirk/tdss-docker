<?php	
	session_start();
//	echo $_REQUEST['url'];
	if ( isset($_REQUEST['url']))
	{
		$url = $_REQUEST['url'];
		$t[] = strtok($url, '/');
		while($t[] = strtok('/'));
		
		$filename = $t[count($t)-2];
//		echo $_REQUEST['url'];
		$handle = @fopen($_REQUEST['url'], 'r');
//		var_dump($handle);
//		$handle = is_file($_REQUEST['url']);
//		var_dump($handle);
		if($handle)
			$flag = true;
		else
			$flag = false;
		
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
      <td bgcolor="#FFFFCC" style="border-bottom: #000000 5px solid"><div align="center" class="style5">Check URL File Exist </div></td>
    </tr>
	<?php
	
	if ($flag == false)
	{
		//echo "Your username ".$_REQUEST['username']." has been used.";
	?>
    <tr>
      <td height="29"><div align="center"><strong>&nbsp;<span class="style3"><?=$filename?></span>&nbsp;<span class="style6"> is not exist.</span></strong></div></td>
    </tr>
	<?php
	}else
	{
	?>
    <tr>
      <td><div align="center"><strong>&nbsp;<span class="style3"><?=$filename?></span>&nbsp;<span class="style6"> is exist.</span></strong></div></td>
    </tr>
	<?php
	}
	?>
  </table><input name="Close" type="button" onClick="javascript: window.close();" value="Close" />
</div>