<?php
	session_start();
	
	/* set timeout for browsing the cluster directory */
	set_time_limit(600);
	
	/* $_SESSION['username'] is exists if user has been authenticated */
	if(!isset($_SESSION['username']))
	{
		/* redirect to .../ */
		echo "<script language=\"javascript\">location.href='../';</script>";
	}
	
	/* setting $dsn_root, got from HTML form */
	$dsn_root = $_REQUEST['dsn'];
	
	
	/* get username */
	$username = strtok($dsn_root, ":");
	
	/* get password */
	$password = strtok("@");
	
	/* get hostname */
	$hostname = strtok(":");
	
	/* get path */
	$path = strtok("\n");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cluster File Browser</title>
<script language="javascript">
	function winMove()
	{
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		window.moveTo(windowWidth/4, windowHeight/4);
		//window.resizeTo(windowWidth,windowHeight);
	}
	
	function SendInfo(dsn_val) {
    	//var dsn_val = document.dsn_form.dsn.value;
		//alert(dsn_val);
        window.opener.document.d_form.dsn.value = dsn_val;
        window.close();
	}
	
	function add_path(add)
	{
		document.dsn_form.path.value += add;
	}
	
	function browser()
	{
		/* if click directory then call this function. */
		/* this function is redirect to this page again with query string in URL */
		location.href = '<?=$_SERVER['PHP_SELF']?>?status=self&dsn=<?=$username.":".$password."@".$hostname.":"?>'+document.dsn_form.path.value;
	}
	
	function upper()
	{
		alert('<?=$path?>');
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
.style3 {font-size: 14px; font-weight: bold; }
.style4 {color: #FF0000}
-->
</style>
</head>
<body class="bodies">
	<?php
		
		/* if this page has $_REQUEST['dsn'], from URL.*/
		if($_REQUEST['dsn'])
		{
			/* require function.inc.php for calling : */
			/*
				validateDSN()
				saveDSNHistory()
			*/
			require_once('../../library/function.inc.php');
			
			/* require ssh class for calling to specified cluster machine */
			require_once('../../library/ssh.class.php');
			
			/* call to validateDSN in function.inc.php to produce the dsn array list, (path, username, password, hostname) */
			$dsn_arr = validateDSN($_REQUEST['dsn']);
			
			/* if invalid dsn, after valideDSN called, then its return false */
			/* checking $dsn_arr has $dsn_arr['path'] */
			if( $dsn_arr == false || !isset($dsn_arr['path']) || strlen($dsn_arr['path']) <= 1)
			{
				?>
				<center><br />
				<?php
				
				/* if dsn is invalid then print the screen of invalid dsn.*/
				if($_REQUEST['dsn'] != 'false')
				{
				?>
				<table class="fb_blocktable" id="fb_flattable" border="0" cellpadding="0" cellspacing="0">
				  <tbody>
					<tr class="fb_sectiontableentry1_stickymsg">
					  <td class="td-1"><span class="style4"><strong>Cluster DSN is not valid ! </strong></span></td>
					</tr>
				  </tbody>
</table>
				<?php
				}
				?>
				  <table width="450" border="0" cellpadding="0" cellspacing="0" class="fb_blocktable" id="fb_flattable">
                    <tbody>
                      <tr class="fb_sectiontableentry1_stickymsg">
                        <td class="td-1"><strong>Help</strong></td>
                      </tr>
                      <tr>
                        <td class="fb_contentheading" id="fb_fspot"><span>Cluster DSN (Cluster Data Source Name) Example </span></td>
                      </tr>
                    </tbody>
                  </table>
				  <table width="450" border="0" cellpadding="0" cellspacing="0" class="fb_blocktable" id="fb_flattable">
                    <tbody>
                      <tr class="fb_sectiontableentry1">
                        <td><div align="center" class="style3">Hostname or IP </div></td>
                        <td class="td-2"><div align="center"><strong><span class="td-3 style2">Username</span></strong></div></td>
                        <td class="td-3"><div align="center"><strong><span class="td-4 style2">Password</span></strong></div></td>
                        <td class="td-4"><div align="center"><strong><span class="td-5 style2">File Path </span></strong></div></td>
                      </tr>
                      <tr class="fb_sectiontableentry1">
                        <td class="td-1"><div align="center">horizon.cp.eng.chula.ac.th</div></td>
                        <td class="td-2"><div align="center">user01</div></td>
                        <td class="td-3"><div align="center">pass01</div></td>
                        <td class="td-4"><div align="center">/home/user01</div></td>
                      </tr>
                    </tbody>
                  </table>
				  <table width="450" border="0" cellpadding="0" cellspacing="0" class="fb_blocktable" id="fb_flattable">
                    <tbody>

                      <tr class="fb_sectiontableentry1">
                        <td class="td-4"><div align="center"><strong><span class="td-5 style2">DSN</span></strong></div></td>
                      </tr>
                      <tr class="fb_sectiontableentry1">
                        <td class="td-4"><div align="center" class="style4">user01:pass01@horizon.cp.eng.chula.ac.th:/home/user01</div></td>
                      </tr>
                    </tbody>
                  </table>
				  <input name="close" type="button" id="close" value="Close this window" onclick="javascript: window.close();" />
				</center>
				<?php
			}else
			{
				/* new instance of SSH class for connecting to cluster machine.*/
				$machine = new SSH;
				
				/* connect to cluster with hostname, username and password */
				$machine->connect($dsn_arr['hostname'], 22, $dsn_arr['username'], $dsn_arr['password']);
				
				/* if connecting cluster has error */
				if($machine->isError())
				{  
					?>
					<center>
					<table class="fb_blocktable" id="fb_flattable" border="0" cellpadding="0" cellspacing="0">
				  <tbody>
					<tr class="fb_sectiontableentry1_stickymsg">
					  <td class="td-1"><span class="style4"><strong>
					  
					  <?php
					  /* if error then get error message, which is produced from connect() in SSH class.*/
					  echo $machine->getError()
					  ?> ! 
					  </strong></span></td>
					</tr>
				  </tbody>
</table>
					<input name="close" type="button" id="close" value="Close this window" onclick="javascript: window.close();" />
					</center>
					<?php
				}else
				{
					/* if connect to cluster success */
					
					/* if user click for browsing the directory then $_REQUEST['status'] is up. */
					/* $_REQUEST['status'] was up after you call browse() in javascript above. */
					
					/* For below line, 1st time for visitting the cluster file browser page. */
					/* We must save dsn history. */
					/* If you want to know the mechanism for saving data please follow the saveDSNHistory() function - */
					/* in the function.inc.php */
					
					if($_REQUEST['status'] != 'self') {
						/* save dsn history to database */
						saveDSNHistory($dsn_arr);
					}
					
					/* After connect to cluster then getting list of file.*/
					/* if getFileList() is success, then return array of file list, otherwise return false */
					$filelist = $machine->getFileList($dsn_arr['path']);
					
					/* if this could not get list of file. */
					if($filelist === false)
					{
						/* checking for error */
						if($machine->isError())
						{  
							?>
							<center>
							<table class="fb_blocktable" id="fb_flattable" border="0" cellpadding="0" cellspacing="0">
				  <tbody>
					<tr class="fb_sectiontableentry1_stickymsg">
					  <td class="td-1"><span class="style4"><strong><?=$machine->getError()?> ! </strong></span></td>
					</tr>
				  </tbody>
</table>
							<input name="close" type="button" id="close" value="Close this window" onclick="javascript: window.close();" />
							</center>
							<?php
						}
					}else
					{
					/* if not error for list file the print current hostname and path used.*/
				?>
				<center>
				<form name="dsn_form" id="dsn_form">
				<table border="0" cellpadding="0" cellspacing="0" class="fb_blocktable" id="fb_flattable">
				  <tbody>
					<tr class="fb_sectiontableentry1_stickymsg">
					  <td colspan="5" class="td-1"><strong><?=$dsn_arr['hostname']?>
					  </strong></td>
					</tr>
					<tr>
					  <td class="fb_contentheading" id="fb_fspot" colspan="5"><span>Path :  
					    <input name="path" type="text" id="path" value="<?=$dsn_arr['path']?>" size="70" />
					    <input name="go" type="button" id="go" onclick="javascript: browser();" value="Go"/>
					    <input name="back" type="button" id="back" onclick="javascript: history.back();" value="Back"/>
					  </span></td>
					</tr>
					<tr class="fb_sectiontableentry1">
					  <td width="86"><div align="center" class="style3">Select</div></td>
					  <td width="86"><div align="center" class="style3">Permission</div></td>
					  <td width="258" class="td-2"><div align="center"><strong><span class="td-3 style2">Filename</span></strong></div></td>
					  <td width="72" class="td-3"><div align="center"><strong><span class="td-4 style2">Size(byte)</span></strong></div></td>
					  <td width="78" class="td-4"><div align="center"><strong><span class="td-5 style2">Date</span></strong></div></td>
					</tr>
					<?php
					
					/* counting the array of file */
					/* if equal zero then print empty, see below*/
					if(count($filelist) == 0 )
					{
						?>
						<tr class="fb_sectiontableentry1">
					  <td colspan="5" class="td-1"><em>current directory is empty </em></td>
				    </tr>
						<?php
					}else
					{
						/* if counting the array of file is not empty */
						/* then enter to loop of fetching the file */
						foreach($filelist as $index => $colname)
						{
						?>
						<tr class="fb_sectiontableentry1">
						  <td class="td-1">
								<?php
									if( $colname['permission'][0] == '-')
									{
								?>
								<input name="file" type="radio" value="<?=$_REQUEST['dsn'].$colname['filename']?>" onclick="javascript: SendInfo(this.value); " />
								<?php
									}else echo "-";
								?>					  </td>
						  <td class="td-1"><?=$colname['permission'];?></td>
						  <td class="td-2"><div align="left">
							
							<?php
								if( $colname['permission'][0] == 'd' )
								{
							?>
									<a href="javascript: add_path('<?=$colname['filename']."/";?>'); browser();"><font color="blue"><?=$colname['filename'];?></font></a>
							<?php
								}else
								{
							?>
									<?=$colname['filename'];?>
							<?php
								}
							?>
						  </div>				      </td>
						  <td class="td-3">
							
							<div align="right">
							  <?=number_format($colname['filesize'], ",");?>
							</div></td>
						  <td class="td-4"><?php
						  
						  if($colname['date'] < 10)
							$colname['date'] = '0'.$colname['date'];
						  
						  echo $colname['month']."&nbsp;".$colname['date']."&nbsp;".$colname['time'];
						  
						  ?></td>
						</tr>
						<?php
						}
					}
					?>
				  </tbody>
</table>
				</form>
				<input name="close2" type="button" id="close2" value="Close this window" onclick="javascript: window.close();" />
				</center>
				<?php
					}
				}
			}
			?>

  <?php
		}else
		{
			?>
  <div align="center"><em>No DSN defined.</em></div>
  <?php
		}
	?>
 
</body>
</html>
