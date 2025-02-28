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
	if($_POST['next']) {
		$_SESSION['import'][2] = $_POST;
		echo "<script language=javascript>location.href='import_sim_output.php?section=3&grp_id=".$_REQUEST['grp_id']."';</script>";
	}
?>
<script language="javascript">
	function enable_res_browser(sender_id, reciever_id) {
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
		document.getElementById('res').src = '../data-source/resource_browser.php?type=sim&data=region&id_parent='+reciever_id+'&id_dwn=a';
	}
	
	function p_echo(elem_id, elem_ref_id, elem_filename, elem_path, elem_id_dwn) {
		str = elem_filename+'.dat'+'<input type="hidden" name="'+elem_id+'[filename]" value="'+elem_filename+'.dat">';
		str = str+'<input type="hidden" name="'+elem_id+'[path]" value="'+elem_path+'">'
		document.getElementById(elem_id).innerHTML = str;
		//document.getElementById(elem_id_dwn).innerHTML = '&nbsp;<a href="../data-source/download_file.php?download_filepath='+elem_path+'">download</a>&nbsp;|&nbsp;<a href="javascript: void()" onclick="javascript: clear_val(this);">remove</a>';
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
.style37 {
	color: #990000
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
	top:10%;
	left: 10%;
	right: 10%;
	width: 80%;
	height: 80%;
	bottom: 10%;
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
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="result.php?section=3">Results</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
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
      <DIV class=submenu_item id=c14> <A <?=$section[9]?> id=cs_14 href="../config/observ_point.php?section=9" title="Go to data source manage page">Observation Points </A> </DIV>
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Simulation name : <font color="#FFFF99"><?=$_SESSION['import'][1]['name']?></font>, group of <font color="#FFFF99"><?=$_SESSION['g_name']?></font> [Step 2 of 3]<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <form action="<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>" method="post" enctype="multipart/form-data">
          <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><strong>Direction</strong></td>
                <td><strong>&nbsp;:&nbsp;</strong></td>
                <td>Choose the observation point which is specified in this simulation</td>
                <td>&nbsp;</td>
                <td>(<a href="javascript: void();" onClick="javascript: document.location.href='<?=$_SERVER['REQUEST_URI']?>';">reload</a>)</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </div>
          <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
          <legend class="style37"><strong>Select observation point</strong></legend>
          <table border="0" cellpadding="5" cellspacing="0" class=" tbl_border fs14px">
            <tr align="center" bgcolor="#FFFFCC" class="td-0" >
              <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">!</font></td>
              <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Name</font></td>
              <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Latitude</font></td>
              <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Longitude</font></td>
              <td bgcolor="#7B869A" class=""><font color="#FFFFFF">Region</font></td>
            </tr>
            <?php 
									require_once('../../library/connectdb.inc.php');
									$point = array();
									$sq = "SELECT * FROM `observe_point`, `observe_group` WHERE `observe_point`.`grp_id` = ".$_REQUEST['grp_id']." AND `observe_point`.`grp_id` = `observe_group`.`id`";
									$res = mysql_query($sq, $connection);
									if($res)
									{	
										if(mysql_num_rows($res) != NULL )
										{					
											$no = mysql_num_rows($res);
											for($a = 0; $a <= $no; $a++){
											
												$obj = mysql_fetch_object($res);
												$point[$a]['name'] = $obj->name;
												$point[$a]['id'] = $obj->observ_point_id;
												$point[$a]['description'] = $obj->description;
												$point[$a]['lat_1'] = $obj->lat_1;
												$point[$a]['lat_2'] = $obj->lat_2;
												$point[$a]['lat_3'] = $obj->lat_3;
												$point[$a]['long_1'] = $obj->long_1;
												$point[$a]['long_2'] = $obj->long_2;
												$point[$a]['long_3'] = $obj->long_3;
												$point[$a]['R1'] = $obj->R1;
												$point[$a]['R2'] = $obj->R2;
												$point[$a]['label'] = $obj->label;
												/*
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
												*/
											}
										}
										else
											$no = 0;
									}
									if($no == 0)
									{
									}else{
										for($i=0; $i<$no; $i++)
										{
			
							?>
            <?php
                            if($i%2) {
							?>
            <tr align="center" bgcolor="#EBEBEB" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <td class="tbl_border_top tbl_border_right"><input name="select_point_id[<?=$point[$i]['id']?>]" type="checkbox" checked><input type="hidden" name="select_point_label[<?=$point[$i]['label']?>]"></td>
              <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)" onMouseOver="Tip('<?=(strlen($point[$i]['description']) > 1) ? $point[$i]['description'] : "(no description)";?>', WIDTH, 400, TITLE, '<?=$point[$i]['name']?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                  <?="".($i+1).". ".$point[$i]['name']?>
                  </a></div></td>
              <td class="tbl_border_top tbl_border_right"><div align="right">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                      <?=$point[$i]['lat_1']?>
                      °</div></td>
        <td><div align="right"></div></td>
        <td><div align="right">
          <?=$point[$i]['lat_2']?>
          '</div></td>
        <td><div align="right"></div></td>
        <td><div align="right">
          <?=$point[$i]['lat_3']?>
          "</div></td>
        <td><div align="right"></div></td>
      </tr>
                </table>
              </div></td>
              <td class="tbl_border_top tbl_border_right"><div align="right">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                        <?=$point[$i]['long_1']?>
                      °</div></td>
                    <td><div align="right"></div></td>
                    <td><div align="right">
                        <?=$point[$i]['long_2']?>
                      '</div></td>
                    <td><div align="right"></div></td>
                    <td><div align="right">
                        <?=$point[$i]['long_3']?>
                      "</div></td>
                    <td><div align="right"></div></td>
                  </tr>
                </table>
              </div></td>
              <td class="tbl_border_top"><?=$point[$i]['R1'] == "yes" ? "1": ""?><?=$point[$i]['R2'] == "yes" ? "2": ""?></td>
            </tr>
            <?php
                        }else {
						?>
            <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
              <td class="tbl_border_top tbl_border_right"><input name="select_point_id[<?=$point[$i]['id']?>]" type="checkbox" checked>
              <input type="hidden" name="select_point_label[<?=$point[$i]['label']?>]"></td>
              <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)" onMouseOver="Tip('<?=(strlen($point[$i]['description']) > 1) ? $point[$i]['description'] : "(no description)";?>', WIDTH, 400, TITLE, '<?=$point[$i]['name']?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                  <?="".($i+1).". ".$point[$i]['name']?>
                  </a></div></td>
              <td class="tbl_border_top tbl_border_right"><div align="right">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                      <div align="right">
                        <?=$point[$i]['lat_1']?>
                      °</div></td>
                    <td><div align="right"></div></td>
                    <td><div align="right">
                      <?=$point[$i]['lat_2']?>
                      '</div></td>
                    <td><div align="right"></div></td>
                    <td><div align="right">
                      <?=$point[$i]['lat_3']?>
                      "</div></td>
                    <td><div align="right"></div></td>
                  </tr>
                </table>
              </div></td>
              <td class="tbl_border_top tbl_border_right"><div align="right">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                        <?=$point[$i]['long_1']?>
                      °</div></td>
                    <td><div align="right"></div></td>
                    <td><div align="right">
                        <?=$point[$i]['long_2']?>
                      '</div></td>
                    <td><div align="right"></div></td>
                    <td><div align="right">
                        <?=$point[$i]['long_3']?>
                      "</div></td>
                    <td><div align="right"></div></td>
                  </tr>
                </table>
              </div></td>
              <td class="tbl_border_top"><?=$point[$i]['R1'] == "yes" ? "1": ""?><?=$point[$i]['R2'] == "yes" ? "2": ""?></td>
            </tr>
            <?php
							}					}//for
											}//else
									?>
          </table>
          </fieldset>
          <input name="next2" type=button class=butenter id=next2 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="&lt; Back" onClick="javascript: location.href='import_sim_result.php?section=3';">
          <input name="next" type=submit class=butenter id=next style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next &gt;">
        </form>
        <div id="light" class="white_content">
          <iframe src="" style="border-width:0px;" width="100%" height="100%" id="res">Something wrong !</iframe>
          <!-- end -->
        </div>
        <div id="fade" class="black_overlay"></div>
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
