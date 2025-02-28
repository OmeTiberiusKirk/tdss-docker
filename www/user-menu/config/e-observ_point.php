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
<?php 
	require_once('../../library/tinymce.inc.php');
	tinymce(true);
?>
<style>
.tbl_border {
	border:black 1px solid;
}
.tbl_border_right {
	border-right:black 1px solid;
}
.tbl_border_top {
	border-top:black 1px solid;
}
</style>
<script language="javascript">
	function point_delete(name, url) {
		if(confirm('Do you want to delete `'+name+'` ?')) {
			document.location.href=url;
		}
	}
	
	function enable_map(lat, long) {
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
		document.getElementById('res').src = 'http://www.ndwc.go.th/server_monitoring/map.php?lat='+lat+'&long='+long+'&zoom=10&info=Location';
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
	height:54px;
	z-index:1;
}
.style1 {
	font-size: 22px;
	color: #FFFFFF;
}
.style2 {color: #FFFFFF}
-->
</style>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
<!--
.style3 {
	color: #996666;
	font-size: 13px;
}
.style5 {font-size: 14px}
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

-->
</style>
<!-- InstanceEndEditable -->
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</HEAD>
<BODY onLoad="refreshImages()">
<div class="style1" id="Layer1">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td rowspan="2"><img src="../../image001.png" alt=""></td>
      <td>Tsunami Decision Support System</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2"><img src="../../Logo-Chula.png" alt="" border="0" usemap="#Map2"></td>
    </tr>
    <tr>
      <td><font style="size:14px">by National Disaster Warning Center (NDWC) and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University">Chulalongkorn University</a></font> </td>
    </tr>
  </table>
</div>
<DIV id=header></DIV>
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
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="../tasks/result.php?section=3">Results</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="../tasks/search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="../tasks/bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
      <!--<DIV class=submenu_item id=c5> <A <?=$section[5]?> id=cs_5 href="../user-menu/tasks/jobstat.php?section=5" title="See the visualizatoin result">Status</A> </DIV>-->
      <!-- ################ -->
      <!-- Data Source -->
      <DIV class=menu_item id=c1><A id="cs_1">Data Source </A></DIV>
      <!-- File Browser -->
      <DIV class=submenu_item id=c14> <A <?=$section[6]?> id=cs_14 href="../data-source/file-browser.php?section=6" title="Go to data source manage page">File Browser </A> </DIV>
      <!-- Simulation Input -->
      <DIV class=submenu_item id=c14><A <?=$section[7]?> id=cs_14 href="../data-source/ds_list_sim.php?section=7" title="Go to data source manage page">Input Data</A></DIV>
      <!-- Visualization Input -->
      <!-- ################ -->
      <!-- Tools -->
      <!-- MATLAB -->
      <!-- GnuPlot -->
      <!-- ################ -->
      <!-- Preferences -->
      <DIV class=menu_item id=c1><A id="cs_1">Configuration</A></DIV>
      <!-- Expr. Parameters -->
      <!--<DIV class=submenu_item id=c14>
        <A <?=$section[8]?> id=cs_14 href="../user-menu/config/seq_p1.php?section=8" title="Go to data source manage page">Preset Parameters </A>      </DIV>-->
      <DIV class=submenu_item id=c14> <A <?=$section[9]?> id=cs_14 href="observ_point.php?section=9" title="Go to data source manage page">Observation Points </A> </DIV>
      <!-- Expr. Environment -->
      <!--<DIV class=submenu_item id=c14>
        <A <?=$section[12]?> id=cs_14 href="../user-menu/config/expr-envi.php?section=12" title="Go to data source manage page">Environment </A>      </DIV>-->
      <!-- ################ -->
      <!-- Management -->
      <DIV class=menu_item id=c1><A id="cs_1">User</A></DIV>
      <!-- Profile -->
      <!-- Change Password -->
      <DIV class=submenu_item id=c14> <A <?=$section[14]?> id=cs_14 href="../user/chpass.php?section=14" title="Change your password">Change Password </A>
        <!-- MENU ENDS -->
      </DIV>
      <!-- Logout -->
      <DIV class=submenu_item id=c14><A <?=$section[0]?> id=cs_14 href="../../library/logout.php" title="Logout of <?=$_SESSION['username']?>"><font color="#CCFF00">Logout</font> <strong>[
        <?=substr($_SESSION['username'], 0, 6)."..."?>
        ]</strong></A> </DIV>
        </DIV>
    <br><center><table><tr><td><div align="center">&nbsp;<img src="../../logo.jpg" width="100" height="111" style="border:3px" usemap="#Map"></div></td>
    </tr><tr><td><div align="center" class="style2">&nbsp;Thai National Grid Center</div></td>
    </tr></table></center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Observation point configuratoin <!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <script type="text/javascript" src="wz_tooltip/wz_tooltip.js"></script>
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operation:</strong>&nbsp;&nbsp;<a href="observ_point.php?section=9&g_id=<?=$_REQUEST['g_id']?>">List the observation points</a> | <a href="new_ob_group.php?section=9" onclick = "document.getElementById('LBOX').src='importer.php';document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><font color="#000099">Group configuration</font></a><br>
        </div>
        <?php
			require_once('../../library/connectdb.inc.php');
														
			$g_default = 0;
			$sql = "SELECT MIN(`id`) AS `m_id` FROM `observe_group`";
			$g_rd = mysql_query($sql, $connection);
			$obj = mysql_num_rows($g_rd) == 1 ? mysql_fetch_object($g_rd) : null;
			$g_default = $obj->m_id;  
			$now_id = 0;
			if($_REQUEST['g_id'] > 0) {
				$now_id = $_REQUEST['g_id'];
				$sel_ob_group[$_REQUEST['g_id']] = " selected";
			}else {
				$now_id = $g_default;
				$sel_ob_group[$g_default] = " selected";
			}
      	
		?>
        <form action="point_update.php?grp_id=<?=$now_id?>" method="post">                
                    
                      <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
                      <legend class="style37  style3"><strong><font color="#990000">Table of Observation Point</font> </strong></legend>
                      <div align="left">
                        <table width="0" border="0" cellspacing="2" cellpadding="3">
                          <tr>
                            <td>Select group of observation point</td>
                            <td>:</td>
                            <td><span style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
                            <?php
														
							$sql = "SELECT * FROM `observe_group` ";
							$g_res = mysql_query($sql, $connection) or die("! failed");
							if(mysql_num_rows($g_res) > 0) {
							?>
                              <select name="group" id="group" onChange="javascript: location.href='<?=$_SERVER['PHP_SELF']?>?section=9&g_id='+this.value;" style="font-size:13px; text-align:left">
                              <?php
                              while($obj = mysql_fetch_object($g_res)) {
							  ?>
                                <option value="<?=$obj->id?>" style="font-size:13px; text-align:left" <?=$sel_ob_group[$obj->id]?>>&nbsp;-&nbsp;<?=$obj->g_name?>&nbsp;<?=$obj->default == "yes" ? "(default)" : ""?>&nbsp;</option>
                               <?php
                               }
							   ?>
                              </select>
                              <?php
                              }
							  ?>
                            </span></td>
                          </tr>
                        </table>
                        <span style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">                        </span>
                        <table width="10" height="2" border="0">
                          <tr>
                            <td></td>
                          </tr>
                        </table>
                      </div>
                        <table border="0" cellpadding="5" cellspacing="0" class=" tbl_border fs14px">
                        <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                          <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">No.</font></td>
                          <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Province</font></td>
                          <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Area</font></td>
                          <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">จังหวัด</font></td>
                          <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">พื้นที่</font></td>
                          <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Latitude</font></td>
                          <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Longitude</font></td>
                        </tr>
                        <tr bgcolor="#FFFFCC" align="center" >
                         <!-- <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Time&nbsp;history</font></td>
                          <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">ETA</font></td>
                          <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">ZMax</font></td>-->
                          <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Available&nbsp;on&nbsp;region </font></td>
                          <td bgcolor="#7B869A"><font color="#FFFFFF">Action</font></td>
                        </tr>
                        <?php 
									require_once('../../library/connectdb.inc.php');
									
									$current_g_id = 0;
									$point = array();
									$sq = "SELECT * FROM observe_point WHERE  uid=".$_SESSION['uid'];
									if($_REQUEST['g_id'] > 0 ) {
										$sq .= " AND `grp_id` = ".$_REQUEST['g_id'];
										$current_g_id = $_REQUEST['g_id'];
									}else {
										$sq .= " AND `grp_id` = ".$g_default;
										$current_g_id = $g_default;
									}
									$res = mysql_query($sq, $connection);
									if($res) {	
										if(mysql_num_rows($res) != NULL ) {					
											$no = mysql_num_rows($res);
											for($a = 0; $a <= $no; $a++) {
												$obj = mysql_fetch_object($res);
												$point[$a]['province'] = $obj->province;
												$point[$a]['province_t'] = $obj->province_t;
												$point[$a]['area'] = $obj->name;
												$point[$a]['area_t'] = $obj->name_t;
												$point[$a]['id'] = $obj->observ_point_id;
												$point[$a]['description'] = $obj->description;
												$point[$a]['lat_1'] = $obj->lat_1;
												$point[$a]['lat_2'] = $obj->lat_2;
												$point[$a]['lat_3'] = $obj->lat_3;
												$point[$a]['long_1'] = $obj->long_1;
												$point[$a]['long_2'] = $obj->long_2;
												$point[$a]['long_3'] = $obj->long_3;
												$point[$a]['decimal_lat'] = $obj->decimal_lat;
												$point[$a]['decimal_long'] = $obj->decimal_long;
												if($obj->wave == 'yes')
													$point[$a]['wave'] = "checked";
												if($obj->eta == 'yes')
													$point[$a]['eta'] = "checked";
												if($obj->zmax == 'yes')
													$point[$a]['zmax'] = "checked";
												if($obj->R1 == 'yes')	
													$point[$a]['R1'] = "checked";
												if($obj->R2 == 'yes')	
													$point[$a]['R2'] = "checked";
												if($obj->R3 == 'yes')	
													$point[$a]['R3'] = "checked";
												if($obj->R4 == 'yes')	
													$point[$a]['R4'] = "checked";
											}
										}
										else
											$no = 0;
									}
									if($no == 0)
									{
									?>
                                    <tr align="center" bgcolor="#EBEBEB" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                          <td colspan="8" class="tbl_border_top">(no observation point)</td>
                          </tr>
                                    <?php
									}else{
										for($i=0; $i<$no; $i++)
										{
			
							if($i%2) {
                            ?>
                        <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                          <td class="tbl_border_top tbl_border_right"><?=$i+1?></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)" onMouseOver="Tip('<?=(strlen($point[$i]['description']) > 1) ? $point[$i]['description'] : "(no description)";?>', WIDTH, 400, TITLE, '<?=$point[$i]['name']?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                            <?=$point[$i]['province']?>
                          </a></div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left">
                            <?=$point[$i]['area']?>
                          </div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)">
                            <?=$point[$i]['province_t']?>
                          </div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)">
                            <?=$point[$i]['area_t']?>
                          </div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="right"><?=$point[$i]['lat_1']?>°&nbsp;<?=$point[$i]['lat_2']?>'&nbsp;<?=$point[$i]['lat_3']?>"</div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="right"><?=$point[$i]['long_1']?>°&nbsp;<?=$point[$i]['long_2']?>'&nbsp;<?=$point[$i]['long_3']?>"</div></td>
                          <!--<td class="tbl_border_top tbl_border_right"><input name="wave[<?=$point[$i]['id']?>]" type="checkbox" value="checkbox" <?=$point[$i]['wave']?>></td>
                          <td class="tbl_border_top tbl_border_right"><input name="eta[<?=$point[$i]['id']?>]" type="checkbox" value="checkbox" <?=$point[$i]['eta']?> ></td>
                          <td class="tbl_border_top tbl_border_right"><input name="zmax[<?=$point[$i]['id']?>]" type="checkbox" value="checkbox" <?=$point[$i]['zmax']?> ></td> -->
                          <td class="tbl_border_top tbl_border_right">R1
                            <input name="R1[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R1']?>>
                            R2
                            <input name="R2[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R2']?>>
                            <!--R3
                            <input name="R3[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R3']?>>
                            R4
                            <input name="R4[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R4']?>>                          </td>-->
                          <td class="tbl_border_top"><a href="javascript: void(0);" onClick="javascript: enable_map(<?=number_format($point[$i]['decimal_lat'], 2)?>, <?=number_format($point[$i]['decimal_long'], 2)?>);">View&nbsp;location</a>&nbsp;|&nbsp;<a href="javascript: void(0)" onClick="javascript: point_delete('<?=$point[$i]['name']?>', 'point_delete.php?id=<?=base64_encode($point[$i]['id'])?>&name=<?=$point[$i]['name']?>');"><font color="#CC3300">Delete</font></a></td>
                        </tr>
                        <?php
						}else {
						?><tr align="center" bgcolor="#EBEBEB" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                          <td class="tbl_border_top tbl_border_right"><?=$i+1?></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)" onMouseOver="Tip('<?=(strlen($point[$i]['description']) > 1) ? $point[$i]['description'] : "(no description)";?>', WIDTH, 400, TITLE, '<?=$point[$i]['name']?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                            <?=$point[$i]['province']?>
                          </a></div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left">
                            <?=$point[$i]['area']?>
                          </div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)">
                            <?=$point[$i]['province_t']?>
                          </div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)">
                            <?=$point[$i]['area_t']?>
                          </div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="right"><?=$point[$i]['lat_1']?>°&nbsp;<?=$point[$i]['lat_2']?>'&nbsp;<?=$point[$i]['lat_3']?>"</div></td>
                          <td class="tbl_border_top tbl_border_right"><div align="right"><?=$point[$i]['long_1']?>°&nbsp;<?=$point[$i]['long_2']?>'&nbsp;<?=$point[$i]['long_3']?>"</div></td>
                          <!--<td class="tbl_border_top tbl_border_right"><input name="wave[<?=$point[$i]['id']?>]" type="checkbox" value="checkbox" <?=$point[$i]['wave']?>></td>
                          <td class="tbl_border_top tbl_border_right"><input name="eta[<?=$point[$i]['id']?>]" type="checkbox" value="checkbox" <?=$point[$i]['eta']?> ></td>
                          <td class="tbl_border_top tbl_border_right"><input name="zmax[<?=$point[$i]['id']?>]" type="checkbox" value="checkbox" <?=$point[$i]['zmax']?> ></td>-->
                          <td class="tbl_border_top tbl_border_right">R1
                            <input name="R1[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R1']?>>
                            R2
                            <input name="R2[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R2']?>>
                            <!--R3
                            <input name="R3[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R3']?>>
                            R4
                            <input name="R4[<?=$point[$i]['id']?>]" type="checkbox" <?=$point[$i]['R4']?>>                          </td> -->
                          <td class="tbl_border_top"><a href="javascript: void(0);" onClick="javascript: enable_map(<?=number_format($point[$i]['decimal_lat'], 2)?>, <?=number_format($point[$i]['decimal_long'], 2)?>);">View&nbsp;location</a>&nbsp;|&nbsp;<a href="javascript: void(0)" onClick="javascript: point_delete('<?=$point[$i]['name']?>', 'point_delete.php?id=<?=base64_encode($point[$i]['id'])?>&name=<?=$point[$i]['name']?>');"><font color="#CC3300">Delete</font></a></td>
                        </tr>
                        
                        <?php
						}
						?>
                        
                        <?php
												}//for
											}//else
									?>
                      </table>
                        <table width="10" height="2" border="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                        <div align="left">
                        <table border="0" cellspacing="0" cellpadding="3">
                          <tr>
                            <td><input name="submit" type=submit class=butenter id=submit style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Update Point" <?=$disable_flag?>  onClick="javascript: confirm_del_vis('<?=$visres['name']?>', <?=$_REQUEST['id']?>);"></td>
                          </tr>
                        </table>
                        </div>
                        </fieldset>
                      <br>
                    </form>
                    <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
                    <legend class="style37  style5"><strong><font color="#990000">Add New Observation Point</font></strong></legend>
                    <form action="point_add.php" method="post"><input type="hidden" name="p_group" value="<?=$current_g_id?>">
                      <table width="10" height="2" border="0">
                        <tr>
                          <td></td>
                        </tr>
                      </table>
                      <table border="0" cellpadding="5" cellspacing="1" class=" fs14px">
                        <tr align="center">
                          <td bgcolor="#E0E9FE"><div align="left"><strong>Province</strong> (EN)</div></td>
                          <td><div align="left">
                              <input type="text" name="p_province" style="width:300px">
                          </div></td>
                        </tr>
                        <tr align="center">
                          <td bgcolor="#E0E9FE"><div align="left"><strong>จังหวัด </strong>(TH)</div></td>
                          <td><div align="left">
                              <input type="text" name="p_province_t" style="width:300px">
                          </div></td>
                        </tr>
                        <tr align="center">
                          <td bgcolor="#E0E9FE"><div align="left"><strong>Station</strong> (EN)</div></td>
                          <td><div align="left">
                              <input type="text" name="p_area" style="width:300px">
                          </div></td>
                        </tr>
                        <tr align="center">
                          <td bgcolor="#E0E9FE"><div align="left"><strong>ชื่อสถานี </strong>(TH)</div></td>
                          <td><div align="left">
                              <input type="text" name="p_area_t" style="width:300px">
                          </div></td>
                        </tr>
                        <tr align="center">
                          <td valign="top" bgcolor="#E0E9FE"><div align="left"><strong>Description</strong></div></td>
                          <td><div align="left">
                              <textarea name="description" cols="40" rows="5" style="width:300px"></textarea>
                          </div></td>
                        </tr>
                        <tr align="center">
                          <td bgcolor="#E0E9FE"><div align="left"><strong>Latitude</strong></div></td>
                          <td ><div align="left" valign="top">
                              <input type="text" name="lat_1" size="10">
                            °
                            <input type="text" name="lat_2" size="10">
                            '
                            <input type="text" name="lat_3" size="10">
                            " </div></td>
                        </tr>
                        <tr align="center">
                          <td bgcolor="#E0E9FE"><div align="left" ><strong>Longitude</strong></div></td>
                          <td><div align="left" valign="top">
                              <input type="text" name="long_1" size="10">
                            °
                            <input type="text" name="long_2" size="10">
                            '
                            <input type="text" name="long_3" size="10">
                            " </div></td>
                        </tr>
                        <tr align="center">
                          <td bgcolor="#E0E9FE"><div align="left" ><strong>Label</strong></div></td>
                          <td><div align="left">
                            <input name="p_label" type="text" id="p_label" style="width:300px">
                          </div></td>
                        </tr>
                      </table>
                      <div align="left">
                        <table border="0" cellspacing="0" cellpadding="3">
                          <tr>
                            <td height="9"></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td><input name="restore22222" type=submit class=butenter id=restore2222 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="  Add new point  " <?=$disable_flag?>  onClick="" >
                              &nbsp;&nbsp;</td>
                            <td><input name="cancel" type=reset class=butenter id=cancel style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="  Cancel  " <?=$disable_flag?>  onClick="parent.document.getElementById('light').style.display='none';parent.document.getElementById('fade').style.display='none'"></td>
                          </tr>
                        </table>
                      </div>
                    </form>
                    </fieldset>
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
<DIV id=footer><SPAN>Partners:</SPAN><A href="http://www.cp.eng.chula.ac.th" target=_blank>Department of Computer Engineering</A>and<A href="http://www.ce.eng.chula.ac.th" target=_blank>Department of Civil Engineering</A>, <a href="http://www.chula.ac.th" target="_blank">Chulalongkorn University</a> | <A href="http://www.thaigrid.or.th" target=_blank>Thai National Grid Center (TNGC)</A></DIV>

<map name="Map"><area shape="rect" coords="5,3,96,110" href="http://www.thaigrid.or.th" title="Thai National Grid Center">
</map>
<map name="Map2"><area shape="rect" coords="5,4,28,45" href="http://www.chula.ac.th" title="Chulalongkorn University"></map></BODY>
<!-- InstanceEnd --></HTML>
