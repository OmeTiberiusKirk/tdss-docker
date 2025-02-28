<?php
	session_start();
	if(isset($_REQUEST['section'])) { 
		$menu_onmouseover = "style=\"background-color: #DDECF0; color: rgb(2, 87, 120);  font-weight:bold;background-image:url(../image/arrow_2_1.PNG)\"";
		$section = array(0, 1, 2, 3, 4, '4.1', 5, 6, 7, 8, 9, 10, 11, 12, 13);
		$section[$_REQUEST['section']] = $menu_onmouseover;
	}
	
	if(!isset($_SESSION['username'])) {
		echo "<script language=\"javascript\">location.href='../../';</script>";
	}
	$disable_flag = "";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/user.dwt.php" codeOutsideHTMLIsLocked="true" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Web Portal :: Operation and Research Section</TITLE>
<script language="javascript">
	
	function delete_link(f, p) {
		if(confirm('Do you really want to delete '+f+' ?')) 
			document.location.href = '../../library/delete_file_brown.php?file='+p+'&name='+f+'';

	
	}
</script>
<!-- InstanceEndEditable -->
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
<META content="index, follow" name=robots>
<link type="text/css" rel="stylesheet" href="../../style/forum.css">
<LINK href="../../style/style.css" type=text/css rel=stylesheet>
<LINK href="../../style/column.css" type=text/css rel=stylesheet>
<link href="../../style/expr.css" type="text/css" rel="stylesheet">
<SCRIPT src="../../script/mainscript.js" type=text/javascript></SCRIPT>
<!--<script src="../script/submenu.js" type="text/javascript"></script>-->
<META content="MSHTML 6.00.2900.2769" name=GENERATOR>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:4px;
	top:8px;
	width: 99%;
	z-index:1;
	height:60px;
}
.style1 {
	font-size: 22px;
	color: #FFFFFF;
}
.style2 {
	color: #FFFFFF
}
-->
</style>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.tbl_border {
	border:black 1px solid;
}
.tbl_border_right {
	border-right:black 1px solid;
}
.tbl_border_top {
	border-top:black 1px solid;
}
-->
</style>
<style type="text/css">
<!--
.style4 {
	color: #009966
}
.style5 {
	color: #FF0000
}
.style7 {
	color: #990000;
	font-weight: bold;
	font-size: 12px;
}
.style36 {
	color: #33CCFF
}
.style39 {
	font-size: 18px
}
.style41 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FF9900;
	font-size: small;
	font-weight: bold;
}
.style43 {
	font-size: small
}
.style46 {
	color: #626262
}
img {
	border:none
}

</style>
<script language="javascript">
	function download_file(url)
	{
		location.href='lib.download-file.php?'+url;
	}
</script>
<!-- InstanceEndEditable -->
<script type="text/javascript">

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

</script>
</HEAD>
<BODY onLoad="refreshImages()">
<DIV id=header>
  <div class="style1" id="Layer1">
  <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><img src="../../image/image001.png" alt="" width="50px" height="50px"></td>
        <td valign="top">&nbsp;</td>
        <td valign=""><table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>Tsunami Decision Support System  <!--<br>
            <font style="size:15px">by <a href="http://ndwc.opencare.org/" target="_blank" style="color:white">National Disaster Warning Center (NDWC)</a> and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University">Chulalongkorn University</a></font>--></td>
            </tr>
          </table></td>
        <td>&nbsp;</td>
        <!--<td valign="top"><img src="../../image/Logo-Chula.png" alt="" height="68" border="0" usemap="#Map2"></td>-->
      </tr>
    </table>
  </div>
</DIV>
<DIV id=main>
  <!-- MENU STARTS -->
  <DIV id=left_column>
    <DIV id="navigation">
      <!-- ################ -->
      <!-- Navigator -->
      <!-- <DIV class=menu_item id=c1><A id="cs_1">Navigator</A></DIV>-->
      <!-- Home -->
      <!--      	<DIV class=submenu_item id=c5> <A <?=$section[0]?> id=cs_5 href="../" title="Go to front page">Home Page</A> </DIV>	-->
      <!-- ################ -->
      <!-- Create New ... -->
      <!-- <DIV class=menu_item id=c1><A id="cs_1">Create New .. </A></DIV> -->
      <!-- Experiment -->
      <!--		<DIV class=submenu_item id=c14>
        <A <?=$section[1]?> id=cs_14 href="../user-menu/create-new/index.php?section=1" title="Go to data source manage page">Simulation</A>      </DIV> -->
      <!-- Visualization -->
      <!-- 	<DIV class=submenu_item id=c14>
        <A <?=$section[2]?> id=cs_14 href="../user-menu/create-new/new-vis.php?section=2" title="Go to data source manage page">Visualization</A>
      </DIV> -->
      <!-- ################ -->
      <!-- Experiment -->
      <DIV class=menu_item id=c1><A id="cs_1">Simulation</A></DIV>
      <!-- Results -->
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="../tasks/result.php?section=3">Database</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="../tasks/search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="../tasks/bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
      <!--<DIV class=submenu_item id=c5> <A <?=$section[5]?> id=cs_5 href="../user-menu/tasks/jobstat.php?section=5" title="See the visualizatoin result">Status</A> </DIV>-->
      <!-- ################ -->
      <!-- Data Source -->
      <!--<DIV class=menu_item id=c1><A id="cs_1">Data Source </A></DIV>-->
      <!-- File Browser -->
      <!--<DIV class=submenu_item id=c14> <A <?=$section[6]?> id=cs_14 href="file-browser.php?section=6" title="Go to data source manage page">File Browser </A> </DIV>-->
      <!-- Simulation Input -->
      <!--<DIV class=submenu_item id=c14><A <?=$section[7]?> id=cs_14 href="ds_list_sim.php?section=7" title="Go to data source manage page">Input Data</A></DIV>-->
      <!-- Visualization Input -->
      <!-- ################ -->
      <!-- Tools -->
      <!-- MATLAB -->
      <!-- GnuPlot -->
      <!-- ################ -->
      <!-- Preferences -->
      <!--<DIV class=menu_item id=c1><A id="cs_1">Configuration</A></DIV>-->
      <!-- Expr. Parameters -->
      <!--<DIV class=submenu_item id=c14>
        <A <?php echo $section[8]; ?> id=cs_14 href="../user-menu/config/seq_p1.php?section=8" title="Go to data source manage page">Preset Parameters </A>      </DIV>-->
      <!--<DIV class=submenu_item id=c14> <A <?php echo $section[9]; ?> id=cs_14 href="../config/observ_point.php?section=9" title="Go to data source manage page">Observation Points </A> </DIV>-->
      <!-- Expr. Environment -->
      <!--<DIV class=submenu_item id=c14>
        <A <?=$section[12]?> id=cs_14 href="../user-menu/config/expr-envi.php?section=12" title="Go to data source manage page">Environment </A>      </DIV>-->
      <!-- ################ -->
      <!-- Management -->
      <DIV class=menu_item id=c1><A id="cs_1">User</A></DIV>
      <!-- Profile -->
      <!-- Change Password -->
      <DIV class=submenu_item id=c14> <!--A <?=$section[14]?> id=cs_14 href="../user/chpass.php?section=14" title="Change your password">Change Password </A>-->
        <!-- MENU ENDS -->
      </DIV>
      <!-- Logout -->
      <DIV class=submenu_item id=c14><A <?=$section[0]?> id=cs_14 href="../../library/logout.php" title="Logout of <?=$_SESSION['username']?>"><font color="#CCFF00">Logout</font> <strong>[
        <?=substr($_SESSION['username'], 0, 6)."..."?>
        ]</strong></A> </DIV>
    </DIV>
    <!--
    <br>
    <center>
      <table>
        <tr>
          <td><div align="center" class="style2"><strong>Powered By</strong></div></td>
        </tr>
        <tr>
          <td><div align="center">&nbsp;<img src="../../image/logo.jpg" width="90" height="27" style="border:3px" usemap="#Map"></div></td>
        </tr>
        <tr>
          <td><div align="center" class="style2">&nbsp;<a href="http://www.thaigrid.or.th" target="_blank" style="color:white">Thai National Grid Center</a></div></td>
        </tr>
      </table>
    </center>-->
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Browse your files or directory<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <?php
			$dir = realpath("../../workspace/".$_SESSION['username']."/files/");
			if(isset($_REQUEST['dir']) && $_REQUEST['dir'] != '..') {
				if(stristr(PHP_OS, 'WIN')) {
					$dir .= "\\".str_replace("|", "\\", $_REQUEST['dir']);
				} else {
					$dir .= "/".str_replace("|", "/", $_REQUEST['dir']);
				}
			}
						
			if (@is_dir($dir)) {
				if ($dh = @opendir($dir)) {
					$i=0;
					while (($file = @readdir($dh)) !== false) {
						if($file != ".") {
							$files[$i]['filepath'] = $dir;
							$files[$i]['filename'] = $file;
							if(stristr(PHP_OS, "WIN")) {
								$fpath = $dir."\\".$file;
							} else {
								$fpath = $dir."/".$file;
							}
							$files[$i]['mod_time'] = @date("m-d-Y H:i:s", @filemtime($fpath));
							$files[$i]['size'] = (@is_dir($fpath)) ? -1 : @filesize($fpath);
							$files[$i]['type'] = @filetype($fpath);
							if($_REQUEST['dir'] && $_REQUEST['dir'] != '..')
								$files[$i]['link'] = $_REQUEST['dir']."|".$files[$i]['filename'];
							else 
								$files[$i]['link'] = $files[$i]['filename'];
							$i++;
						}
					}
					closedir($dh);
				}
			}else die("! could not open workspace.");
			/*
			echo "<pre>";
			print_r($files);
			echo "</pre>";
			exit;
			*/
		?>
        <?php
			//Path : =$dir

			$tests = explode("&", $_SERVER['REQUEST_URI']);
			
			$test = explode("=", $tests[1]);
			$tes = explode("|", $test[1]);
			for($b=0; $b < count($tes)-1; $b++){
				$te[$b] = $tes[$b];
			}
			if(count($te) == NULL){
				$pat = $tests[0];
			}else{
				$t = implode("|", $te);
				$pat = $tests[0]."&dir=".$t;
			}
			/* group a file */
			$no_dir = 0;
			$no_file = 0;
			foreach($files as $index => $info) {
				if($info['type'] == "file") {
					$t = explode(".", $info['link']);
					$exts = $t[count($t)-1];
					$info['ext'] = $exts;
					$no_file++;
				}
									
				if($info['type'] == "dir") {
					$files_dir[] = $info;
					$no_dir++;
				}
				if($info['type'] == "file") {
					//$n2_files[] = $info;
					$files_t[$info['ext']][] = $info;
				}
			}
			/*
			echo "<pre>";
			print_r($files_t);
			echo "</pre>";
			*/
			$temp = array();
			if(count($files_t) > 0 ) {
				foreach($files_t as $ext => $info) {
					$temp = @array_merge($temp, $info);
				}
			}
			$files = @array_merge($files_dir, $temp);
			//echo $pat;
		?>
        <?php
        	if(isset($_REQUEST['dir'])) {
				$_REQUEST['dir'] = str_replace("../", "", $_REQUEST['dir']);
				if(strlen($_REQUEST['dir']) > 0) {
					$a = explode("|", $_REQUEST['dir']);
					$temp = "";
					$t = array();
					foreach($a as $index => $c_dir_name) {
						$temp[] = $c_dir_name;
						$str_dir = implode("|", $temp);
						$t[] = "<a href='".$_SERVER['PHP_SELF']."?section=6&dir=".$str_dir."'>".$c_dir_name."</a>";
					}
					$cp = implode("&nbsp;<img src=\"../../image/dot_arrow.gif\">&nbsp;", $t);
				}else echo "<script language=javascript>alert('Invalid refered directory !');document.location.href='".$_SERVER['PHP_SELF']."?secion=6';</script>";
				?>
        <div style="border-top:#999999 1px solid;background-color:#D5EBFD; padding:4px 4px 4px 4px"><font color="#FF0000"><strong>!&nbsp;</strong></font><font color="#000099"><strong>Current :</strong></font>&nbsp;<font color="#006600"><?=$_SESSION['username']."@"?><?=$cp?></font><img src="../../image/spacer.gif" width="1" height="3"><br><font color="#FF0000"><strong>!&nbsp;</strong></font><font color="#000099"><strong>Information :</strong></font>&nbsp;<font color="#006600"><?=($no_dir > 0 && $no_dir ==1) ? "<b>".$no_dir."</b> directory" : "<b>".$no_dir."</b> directories"?>,&nbsp;<?=($no_file > 0 && $no_file == 1) ? "<b>".$no_file."</b> file" : "<b>".$no_file."</b> files"?></font></div>
        <?php
			}else {
			?>
        <div style="border-top:#999999 1px solid; background-color:#D5EBFD; padding:4px 4px 4px 4px"><font color="#FF0000"><strong>!&nbsp;</strong></font><font color="#000099"><strong>Current :</strong></font>&nbsp;<font color="#006600"><?=$_SESSION['username']."@home"?></font><img src="../../image/spacer.gif" width="1" height="3"><br><font color="#FF0000"><strong>!&nbsp;</strong></font><font color="#000099"><strong>Information :</strong></font>&nbsp;<font color="#006600"><?=($no_dir > 0 && $no_dir ==1) ? "<b>".$no_dir."</b> directory" : "<b>".$no_dir."</b> directories"?>,&nbsp;<?=($no_file > 0 && $no_file == 1) ? "<b>".$no_file."</b> file" : "<b>".$no_file."</b> files"?></font></div>
            <?php
			}
		?>
        <fieldset class="" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x">
        <legend class="style7">File Browser </legend>
            <img src="../../image/spacer.gif" width="1" height="6">
        <table border="0" cellpadding="3" cellspacing="0" class="tbl_border fs14px">
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Directory / File</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Size</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Date Modified</font></td>
            <td bgcolor="#7B869A" class=""><font color="#FFFFFF">Action </font></td>
          </tr>
          <?php
			$count_element = count($files);
			if($count_element > 0)
			{
				for($i=0; $i<count($files); $i++)
				{
					if($files[$i]['type'] == 'dir')
					{
						if($files[$i]['filename'] == '..')
						{
							if(isset($_REQUEST['dir'])){
							?>
                              <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
                                <td colspan="4"><div align="left">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td><div align="left"><a href="<?=$pat?>"><img src="../../image/folderup.png" alt=" " width="13" height="16"></a></div></td>
                                        <td>&nbsp;</td>
                                        <td><a href="<?=$pat?>" style="color:#000099">
                                          <?=$files[$i]['filename']?>
                                          </a></td>
                                      </tr>
                                    </table>
                                  </div></td>
          </tr>
                             <?php
							}
						}else {
							?>
					          <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
            <td ><div align="left">
                <table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><div align="left"><a href="<?=$_SERVER['../../user/section3/PHP_SELF']."?section=6&dir=".$files[$i]['link']?>">
                        <?php
                                      	if($files[$i]['filename'] == 'EXPERIMENT')
											echo "<img src=\"../../image/folder2.png\" alt=\" \">";
										else
											echo "<img src=\"../../image/folder_icon.png\" alt=\" \">";			
									  
									  ?></a>
                      </div></td>
                    <td>&nbsp;</td>
                    <td><a href="<?=$_SERVER['../../user/section3/PHP_SELF']."?section=6&dir=".$files[$i]['link']?>" style="color:#000099">
                      <?=$files[$i]['filename']?>
                      </a></td>
                  </tr>
                </table>
              </div></td>
            <td><div align="middle">-</div></td>
            <td class="blue"><div align="center">
                <?=$files[$i]['mod_time']?>
              </div></td>
            <td><div align="center"> <!--Zip | --> Download <!--|
                <?php 
							  if (($files[$i]['filename'] == "Data_Source") || ($files[$i]['filename'] == "Experiments") || 
							  	  ($files[$i]['filename'] == "On_Demand_Visualization") || ($files[$i]['filename'] == "Visualization") ||
								  ($files[$i]['filename'] == "Simulation") || 
								  ($files[$i]['filename'] == "Bathymetry_and_Topography_File") ||
								  ($files[$i]['filename'] == "Deformation_File") ||
								  ($files[$i]['filename'] == "Bulletin")
								 ){ 
								  }else{
							  ?>
                <a href="javascript: delete_link('<?=$files[$i]['filename']?>', '<?php echo str_replace("\\", "|", $files[$i]['filepath']."\\".$files[$i]['filename'])?>')" style="color:#000099">
                <?php }?>
                Delete</a> --></div></td>
          </tr>
				            <?php
						}
					}else
					{
						?>
				          <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
            <td><div align="left">
                <table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td><div align="left"><?php
                    $r = explode(".", $files[$i]['filename']);
					$ext = $r[count($r)-1];
					if($ext == "rar" || $ext == "gz" || $ext == "zip")
						echo "<img src=\"../../image/rar_icon.png\" alt=\"\" width=\"19\" height=\"15\">";
					elseif($ext == "ppt" || $ext == "pptx")
						echo "<img src=\"../../image/ppt_icon.png\" width=\"19\" height=\"18\">";
					elseif($ext == "xls" || $ext == "xlsx")
						echo "<img src=\"../../image/excel_icon.png\" width=\"19\" height=\"19\">";
					else
						echo "<img src=\"../../image/file.png\" alt=\" \" width=\"13\" height=\"16\">";
					?>
	                    </div></td>
                    <td>&nbsp;</td>
                    <td><?=$files[$i]['filename']?></td>
                  </tr>
                </table>
              </div></td>
            <td><div align="right">
                <?php if(round($files[$i]['size']/1000, 2)>=1000){
								$answ = round($files[$i]['size']/1000, 2);
								echo round($answ/1000, 2)." MB";
							}else{
								echo round($files[$i]['size']/1000, 2)," KB";
							}?>
              </div></td>
            <td class="blue"><div align="center">
                <?=$files[$i]['mod_time']?>
              </div></td>
            <td><div align="center"><!--<a href="../../library/zip_file_brown.php?path=<?=base64_encode($files[$i]['filepath'])?>&filename=<?=base64_encode($files[$i]['filename'])?>" style="color:#000099">Zip</a> | --><a href="../../library/download_file_brown.php?file=<?=base64_encode($files[$i]['filepath'].(stristr(PHP_OS, "WIN") ? "\\" : "/").$files[$i]['filename'])?>&filename=<?=base64_encode($files[$i]['filename'])?>" style="color:#000099">Download</a> <!--| <a href="javascript: delete_link('<?=$files[$i]['filename']?>', '<?php echo str_replace("\\", "|", $files[$i]['filepath']."|".$files[$i]['filename'])?>')" style="color:#000099">Delete</a> --></div></td>
          </tr>
			            <?php
					}
				}
			}
			?>
        </table>
        </fieldset>
        <!--
        <fieldset class="" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x">
        <legend class="style7">Operation </legend>
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><img src="../../image/buttonorange.gif" width="7" height="10"></td>
            <td>&nbsp;</td>
            <td>Create New Directory </td>
            <td>&nbsp;</td>
            <form action="../../library/create_directory.php" method="post" name="dir">
              <td align="left" valign="middle"><input name="old_dir" type="hidden" value="<?=$dir?>">
                <input name="create_dir" type="text" size="40">
                <input name="create" type=submit class=butenter id=create style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:23px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Create">
            </form>
            </td>
            <td>&nbsp;
              <?php $_SESSION['uri'] = $_SERVER['REQUEST_URI'];
							$_SESSION['q_str'] = $_SERVER['QUERY_STRING']; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="9"><table width="10" height="2" border="0">
                <tr>
                  <td></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><img src="../../image/buttonorange.gif" alt=" " width="7" height="10"></td>
            <td>&nbsp;</td>
            <td>Upload File </td>
            <td>&nbsp;</td>
            <form action="../../library/upload_file.php" enctype="multipart/form-data" method="post" name="dir">
              <td><input name="old_dir" type="hidden" value="<?=$dir?>">
                <input name="userfile" type="file" size="40"></td>
              <td>&nbsp;</td>
              <td><input name="upload" type=submit class=butenter style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:23px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Upload !"></td>
              <td>&nbsp;</td>
              <td><strong><font color="#990000">*</font></strong> <font color="#000066">Maximum 
                <?=ini_get("upload_max_filesize")?>
              </font></td>
            </form>
          </tr>
          <tr>
            <td colspan="9"><table width="10" height="2" border="0">
                <tr>
                  <td></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><img src="../../image/buttonorange.gif" alt=" " width="7" height="10"></td>
            <td>&nbsp;</td>
            <td>Reload (<a href="javascript: void(0)" onClick="javascript: document.location.reload()"><font color="#000099">Click</font></a>)</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </fieldset> -->
        <!-- InstanceEndEditable --></DIV>
      <DIV class="clear asd"></DIV>
    </DIV>
    <!-- FEATURED RESOURCES START -->
    <DIV id=margin_footer></DIV>
    <!-- FEATURED RESOURCES STOP -->
  </DIV>
</DIV>
<!--<DIV id=footer><a href="../../team.html" target="_blank" style="color:white">Developer Team</a></DIV>-->
</BODY>
<!-- InstanceEnd --></HTML>
