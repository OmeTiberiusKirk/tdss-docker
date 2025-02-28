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
<style type="text/css">
<!--
.style3 {
	color: #000000
}
.style4 {
	color: #FFFFFF
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
.style37 {
	color: #990000
}
DIV#adv_box {
	BORDER-RIGHT: #b6d6e1 1px solid;
	PADDING-RIGHT: 0px;
	BORDER-TOP: #b6d6e1 1px solid;
	PADDING-LEFT: 12px;
	PADDING-BOTTOM: 12px;
	padding-right:12px;
	MARGIN: 7px 0px 10px;
	BORDER-LEFT: #b6d6e1 1px solid;
	PADDING-TOP: 12px;
	BORDER-BOTTOM: #b6d6e1 1px solid;
	BACKGROUND-COLOR: #eef6fb
}
.style31 {
	color: #FFFFFF;
}
.tbl_border {
	border:black 1px solid;
}
.tbl_border_right {
	border-right:black 1px solid;
}
.tbl_border_top {
	border-top:black 1px solid;
}
.tbl_border_bottom {
	border-bottom:black 1px solid;
}
.black_overlay {
	display: none;
	position:fixed;
	top: 0%;
	left: 0%;
	width: 100%;
	height: 100%;
	background-color: black;
	z-index:1001;
	-moz-opacity: 0.9;
	opacity:.80;
	filter: alpha(opacity=80);
}
.white_content {
	display: none;
	position:fixed;
	top: 10%;
	bottom: 10%;
	height: 80%;
	left: 20%;
	right: 20%;
	width: 60%;
	padding: 2px;
	border: 2px solid orange;
	background-color: white;
	z-index:1002;
	overflow: hidden;
}
</style>
<script language="javascript">
  /*function enable_map(lat, long) {
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
		document.getElementById('res').src = 'http://www.ndwc.go.th/server_monitoring/map.php?lat='+lat+'&long='+long+'&zoom=5&info=Earthquake location';
	}*/
	
	function jump(v){ //v3.0
		document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id='+v;
	 // if (restore) selObj.selectedIndex=0;
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
</style>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<script type="text/javascript">

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
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
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="result.php?section=3">Database</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
      <!--<DIV class=submenu_item id=c5> <A <?=$section[5]?> id=cs_5 href="../user-menu/tasks/jobstat.php?section=5" title="See the visualizatoin result">Status</A> </DIV>-->
      <!-- ################ -->
      <!-- Data Source -->
      <!--<DIV class=menu_item id=c1><A id="cs_1">Data Source </A></DIV>-->
      <!-- File Browser -->
      <!--<DIV class=submenu_item id=c14> <A <?=$section[6]?> id=cs_14 href="../data-source/file-browser.php?section=6" title="Go to data source manage page">File Browser </A> </DIV>-->
      <!-- Simulation Input -->
      <!--<DIV class=submenu_item id=c14><A <?=$section[7]?> id=cs_14 href="../data-source/ds_list_sim.php?section=7" title="Go to data source manage page">Input Data</A></DIV>-->
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
      <DIV class=submenu_item id=c14> <!--<A <?=$section[14]?> id=cs_14 href="../user/chpass.php?section=14" title="Change your password">Change Password </A>-->
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
    </center>
    -->
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Bulletin&nbsp;management<!-- InstanceEndEditable --> </H2>
      <!--<DIV class=tutorials_list>--> <!--InstanceBeginEditable name="visualization_output" -->
        <!--<div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operations&nbsp;:&nbsp;</strong><font color="#000099"> Select group </font><select name="grp" id="grp" onChange="jump(this.value)" style="font-size:13px; text-align:left">-->
          <?php
          require_once('../../library/connectdb.inc.php');
			if(isset($_REQUEST['grp_id'])) 
				$g_default_id = $_REQUEST['grp_id'];
			else {
				$sql = "SELECT * FROM `observe_group` WHERE `default` LIKE 'yes';";
				$rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
				$obj = mysql_fetch_object($rg);
				$g_default_name = $obj->g_name;
				$g_default_id = $obj->id;
				$_REQUEST['grp_id'] = $g_default_id;
			}
			$selected_group[$g_default_id] = " selected";	
	
		  $sql = "SELECT * FROM `observe_group`";
		  $rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		  if( mysql_num_rows($rg) > 0 ) {
		  	while($obj = mysql_fetch_object($rg)) {
		  ?>
            <!--<option value="<?=$obj->id?>" style="font-size:13px; text-align:left" <?=$selected_group[$obj->id]?>>&nbsp;- <?=$obj->g_name?>&nbsp;<?=$obj->default == "yes" ? "(default)" : ""?></option>-->
          <?php
		  	}
          }else {
		  ?>
          <!--<option value="0">! ERROR, no define group</option>-->
          <?php
          }
		  ?>
          <!--</select>-->
        <!--</div>-->
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <?php 
									require_once('../../library/connectdb.inc.php');
									
									if($_REQUEST['act'] == "del") {
										@unlink(base64_decode($_REQUEST['th_path_file'])); // or die('Something wrong : could not delete this bulletin.');
										@unlink(base64_decode($_REQUEST['en_path_file']));
										$sql = "DELETE FROM `bulletin` WHERE `id` = ".$_REQUEST['id'];
										mysql_query($sql, $connection);
										echo "<script language=javascript>location.href='".$_SERVER['PHP_SELF']."?section=4.1&grp_id=".$_REQUEST['grp_id'].";</script>";
									}
									
									$point = array();
									$sql = "SELECT 
                    `bulletin`.`release_no`, 
                    `bulletin`.`release_year`, 
                    `bulletin`.`announce_date`, 
                    `bulletin`.`announce_time`, 
                    `bulletin`.`magnitude`, 
                    `bulletin`.`depth_km`, 
                    `bulletin`.`eq_area_lat`, 
                    `bulletin`.`eq_area_long`, 
                    `bulletin`.`en_path_filename`, 
                    `bulletin`.`th_path_filename`,  
                    `sim_result`.`job_profile_id`, 
                    `bulletin`.`from_result_id`
                    FROM 
                      `bulletin`, `sim_result` 
                    WHERE 
                      `bulletin`.`uid`=".$_SESSION['uid']." AND 
                      `bulletin`.`grp_id` = ".$_REQUEST['grp_id']." AND 
                      `bulletin`.`from_result_id` = `sim_result`.`id` ORDER BY `bulletin`.`release_no` DESC";

									$res = mysql_query($sql, $connection);
									$no = mysql_num_rows($res);
		?>
      
        <div id="search_result_box"style="background-color:#FFFFCC; padding:4px 4px 4px 4px; border-top:#999999 1px solid"> <strong> List of released bulletin
          &nbsp;:</strong>&nbsp;found <font color="#FF0000">
          <?=$no?>
          </font> record(s)
          <div style="padding-top: 10px;"> <a href="../../workspace/ndwc/files/XML-Bulletins/latest-bulletin.xml" target="_blank">Click to view the latest bulletin XML format</a></div>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <div id="adv_box" style="">
            <table border="0" cellpadding="5" cellspacing="0" class=" tbl_border fs14px">
              <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><div align="center"><font color="#FFFFFF">No.</font></div></td>
                <!--<td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><div align="center"><font color="#FFFFFF">Year</font></div></td>-->
                <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Announce&nbsp;Date</font></td>
                <td colspan="2" bgcolor="#7B869A" class="tbl_border_right tbl_border_bottom"><font color="#FFFFFF">Earthquake&nbsp;Information</font></td>
                <td colspan="2" bgcolor="#7B869A" class="tbl_border_right tbl_border_bottom"><font color="#FFFFFF">Location</font></td>
                <!--<td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Create From</font></td>-->
                <td rowspan="2" bgcolor="#7B869A" class=""><font color="#FFFFFF">Operation</font></td>
              </tr>
              <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                <td bgcolor="#7B869A" class="tbl_border_right"><div align="center"><font color="#FFFFFF">Magnitude</font></div></td>
                <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Depth&nbsp;(km)</font></td>
                <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Latitude</font></td>
                <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Longitude</font></td>
              </tr>
              <?php
											$i = 0;
											if(mysql_num_rows($res) > 0) {
											while($obj = mysql_fetch_object($res)) {
												if($i%2) {
												?>
              <tr align="center" bgcolor="#EBEBEB" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=$obj->release_no?>
                  </div></td>
                <!--<td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=$obj->release_year?>
                  </div></td>-->
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=$obj->announce_date." ".$obj->announce_time?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->magnitude, 2)?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->depth_km, 2)?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->eq_area_lat, 2)?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->eq_area_long, 2)?>
                  </div></td>
                <!--<td class="tbl_border_top tbl_border_right"><div align="left"><a href="../bulletin/general.php?id=<?=$obj->from_result_id?>&job_profile_id=<?=$obj->job_profile_id?>&grp_id=<?=$_REQUEST['grp_id']?>">
                  <?=$obj->from_result_name?>
                  </a>[IP:<?=$obj->from_ip?>]</div></td>-->
                <td class="tbl_border_top "><div align="center"><!--<a href="javascript: void(0);" onClick="javascipt: enable_map(<?=$obj->eq_area_lat?>, <?=$obj->eq_area_long?>)">View earthquake location</a> |--> <a href="../data-source/download_file.php?download_filepath=<?=base64_encode($obj->th_path_filename)?>">Download XML</a> | <!--| <a href="../data-source/download_file.php?download_filepath=<?=base64_encode($obj->en_path_filename)?>">Download English</a> | --><a href="javascript: if(confirm('Do really want to delete this bulletin ?')) { document.location.href='<?=$_SERVER['PHP_SELF']?>?section=4.1&act=del&id=<?=$obj->release_no?>&th_path_file=<?=base64_encode($obj->th_path_filename)?>&en_path_file=<?=base64_encode($obj->en_path_filename)?>&grp_id=<?=$_REQUEST['grp_id']?>'; }else{};">Delete</a></div></td>
              </tr>
              <?php
												}else {
												?>
              <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=$obj->release_no?>
                  </div></td>
                <!--<td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=$obj->release_year?>
                  </div></td>-->
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=$obj->announce_date." ".$obj->announce_time?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->magnitude, 2)?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->depth_km, 2)?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->eq_area_lat, 2)?>
                  </div></td>
                <td class="tbl_border_top tbl_border_right"><div align="center">
                    <?=number_format($obj->eq_area_long, 2)?>
                  </div></td>
                <!--<td class="tbl_border_top tbl_border_right"><div align="left"><a href="../bulletin/general.php?id=<?=$obj->from_result_id?>&job_profile_id=<?=$obj->job_profile_id?>&grp_id=<?=$_REQUEST['grp_id']?>">
                  <?=$obj->from_result_name?>
                  </a>[IP:<?=$obj->from_ip?>]</div></td>-->
                <td class="tbl_border_top"><div align="center"><!--<a href="javascript: void(0);" onClick="javascipt: enable_map(<?=$obj->eq_area_lat?>, <?=$obj->eq_area_long?>)">View earthquake location</a> |--> <a href="../data-source/download_file.php?download_filepath=<?=base64_encode($obj->th_path_filename)?>">Download XML</a> | <!-- <a href="../data-source/download_file.php?download_filepath=<?=base64_encode($obj->en_path_filename)?>">Download English</a> | --> <a href="javascript: if(confirm('Do really want to delete this bulletin ?')) { document.location.href='<?=$_SERVER['PHP_SELF']?>?section=4.1&act=del&id=<?=$obj->release_no?>&th_path_file=<?=base64_encode($obj->th_path_filename)?>&en_path_file=<?=base64_encode($obj->en_path_filename)?>&grp_id=<?=$_REQUEST['grp_id']?>'; }else{};">Delete</a></div></td>
              </tr>
              <?php
												}
												$i++;
											}
											}else {
												?>
              <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
                <td colspan="9" class="tbl_border_top"><div align="center">(no bulletin)</div></td>
              </tr>
              <?php
											}
                                            ?>
            </table>
          </div>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
        </div>
        <div id="light" class="white_content">
          <iframe src="" style="border-width:0px;" width="100%" height="100%" id="res">Something wrong !</iframe>
          <!-- end -->
        </div>
        <div id="fade" class="black_overlay" onClick="javascript: document.getElementById('light').style.display='none'; document.getElementById('fade').style.display='none'; /* document.location.href='<?=$_SERVER['REQUEST_URI']?>'; */"></div>
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
