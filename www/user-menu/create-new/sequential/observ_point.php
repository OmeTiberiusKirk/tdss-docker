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
	require_once('../../../library/tinymce.inc.php');
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
.style15 {
	color: #006699
}
</style>
<!-- InstanceEndEditable -->
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
<META content="index, follow" name=robots>
<link type="text/css" rel="stylesheet" href="../../../style/forum.css">
<LINK href="../../../style/style.css" type=text/css rel=stylesheet>
<LINK href="../../../style/column.css" type=text/css rel=stylesheet>
<link href="../../../style/expr.css" type="text/css" rel="stylesheet">
<SCRIPT src="../../../script/mainscript.js" type=text/javascript></SCRIPT>
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
      <td rowspan="2"><img src="../../../image001.png" alt=""></td>
      <td>Tsunami Decision Support System</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2"><img src="../../../Logo-Chula.png" alt="" border="0" usemap="#Map2"></td>
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
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="../../tasks/result.php?section=3">Results</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="../../tasks/search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="../../tasks/bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
      <!--<DIV class=submenu_item id=c5> <A <?=$section[5]?> id=cs_5 href="../user-menu/tasks/jobstat.php?section=5" title="See the visualizatoin result">Status</A> </DIV>-->
      <!-- ################ -->
      <!-- Data Source -->
      <DIV class=menu_item id=c1><A id="cs_1">Data Source </A></DIV>
      <!-- File Browser -->
      <DIV class=submenu_item id=c14> <A <?=$section[6]?> id=cs_14 href="../../data-source/file-browser.php?section=6" title="Go to data source manage page">File Browser </A> </DIV>
      <!-- Simulation Input -->
      <DIV class=submenu_item id=c14><A <?=$section[7]?> id=cs_14 href="../../data-source/ds_list_sim.php?section=7" title="Go to data source manage page">Input Data</A></DIV>
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
      <DIV class=submenu_item id=c14> <A <?=$section[9]?> id=cs_14 href="../../config/observ_point.php?section=9" title="Go to data source manage page">Observation Points </A> </DIV>
      <!-- Expr. Environment -->
      <!--<DIV class=submenu_item id=c14>
        <A <?=$section[12]?> id=cs_14 href="../user-menu/config/expr-envi.php?section=12" title="Go to data source manage page">Environment </A>      </DIV>-->
      <!-- ################ -->
      <!-- Management -->
      <DIV class=menu_item id=c1><A id="cs_1">User</A></DIV>
      <!-- Profile -->
      <!-- Change Password -->
      <DIV class=submenu_item id=c14> <A <?=$section[14]?> id=cs_14 href="../../user/chpass.php?section=14" title="Change your password">Change Password </A>
        <!-- MENU ENDS -->
      </DIV>
      <!-- Logout -->
      <DIV class=submenu_item id=c14><A <?=$section[0]?> id=cs_14 href="../../../library/logout.php" title="Logout of <?=$_SESSION['username']?>"><font color="#CCFF00">Logout</font> <strong>[
        <?=substr($_SESSION['username'], 0, 6)."..."?>
        ]</strong></A> </DIV>
        </DIV>
    <br><center><table><tr><td><div align="center">&nbsp;<img src="../../../logo.jpg" width="100" height="111" style="border:3px" usemap="#Map"></div></td>
    </tr><tr><td><div align="center" class="style2">&nbsp;Thai National Grid Center</div></td>
    </tr></table></center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->
        <?=$_SESSION['name']?>
        <span class="style15">(Template name :
        <?=$_SESSION['template_name']?>
        )</span><!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <script type="text/javascript" src="../sequential/wz_tooltip/wz_tooltip.js"></script>
        <div style="background-color:#D7F1FB; padding:4px 4px 4px 4px; border-top:#0099FF 1px solid;">
          <div align="center"><strong>Step 6 of 6</strong><font color="#000099"></font></div>
        </div>
        <table width="0" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="height:4px"></td>
          </tr>
        </table>

              <form action="handler.php" method="post">
                <fieldset style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
                <legend class="style37  style3"><strong><font color="#990000">Select observation point</font> </strong></legend>
                <table border="0" cellpadding="5" cellspacing="0" class=" tbl_border fs14px">
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">!
                      </h1>
                      </font></td>
                    <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">No.</font></td>
                    <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Name</font></td>
                    <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Latitude</font></td>
                    <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Longitude</font></td>
                  </tr>
                  <tr bgcolor="#FFFFCC" align="center" > </tr>
                  <?php 
									require_once('../../../library/connectdb.inc.php');
									$point = array();
									$_SESSION['data']['des']['output'] = $_POST['des']['output'];	
									$_SESSION['data']['val']['output'] = $_POST['val']['output'];	
									$sq = "SELECT * FROM observe_point WHERE  uid=".$_SESSION['uid'];
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
												if($obj->sim_res == 'yes')
													$point[$a]['sim'] = "checked";
												
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
                  <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
                    <td class="tbl_border_top tbl_border_right"><input name="point[<?=$point[$i]['id']?>]" type="checkbox" value="chk" checked <?=$point[$i]['wave']?>></td>
                    <td class="tbl_border_top tbl_border_right"><?=$i+1?></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><a href="javascript: void(0)" onMouseOver="Tip('<?=(strlen($point[$i]['description']) > 1) ? $point[$i]['description'] : "(no description)";?>', WIDTH, 400, TITLE, '<?=$point[$i]['name']?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                        <?=$point[$i]['name']?>
                        </a></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="right">
                        <?=$point[$i]['lat_1']?>
                        °&nbsp;
                        <?=$point[$i]['lat_2']?>
                        '&nbsp;
                        <?=$point[$i]['lat_3']?>
                        "</div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="right">
                        <?=$point[$i]['long_1']?>
                        °&nbsp;
                        <?=$point[$i]['long_2']?>
                        '&nbsp;
                        <?=$point[$i]['long_3']?>
                        "</div></td>
                  </tr>
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
                <table border="0" cellspacing="0" cellpadding="4">
                  <tr>
                    <td><input name="reload22" type=button class=butenter id=reload22 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="&lt; Back" onClick="javascript: location.href='param_3.php?section=6&status=back';"></td>
                    <td><input name="save" type=submit class=butenter id=save style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next&gt;" onClick="javascript: location.href='conf_save.php';"></td>
                  </tr>
                </table>
                </fieldset>
                <br>
              </form>
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
