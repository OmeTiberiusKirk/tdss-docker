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
	function load_default()
	{
		alert('load default');
	}
	
	function submit_form(frm)
	{
		frm.submit();
	}
	function send_config_id(id){
		<input name="default" type="hidden" value="+id+">;
	}
	
</script>
<?php	
	$_SESSION['status']['one'] = "back";
	$select = array(-1, 1, 2, 3);
	$select[$_REQUEST['select']] = "selected=\"selected\"";
?>
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
.style47 {
	font-weight: bold
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
        <!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
                <div style="background-color:#D7F1FB; padding:4px 4px 4px 4px; border-top:#0099FF 1px solid;">
          <div align="center"><strong>Step 2 of 6</strong><font color="#000099"></font></div>
        </div>
        <table width="0" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="height:4px"></td>
          </tr>
        </table>
<form action="param_1.php?section=1" method="post" name="form_page_1" id="form_page_1" style="display:">
          <fieldset style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend class="dq_closestoday"><strong>Select Preset Parameters </strong></legend>
          <table border="0">
            <tr>
              <td><strong>Load parameters from</strong></td>
              <td><img src="../../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
              <td><?php
									if(!isset($connection)) {
										require_once("../../../library/connectdb.inc.php");
									}
									
									/* select default template */
									$sql_default = "SELECT * FROM `seq_config_param` WHERE `default_param` = 'yes'";
									$result_default = mysql_query($sql_default, $connection);
					
									if(mysql_num_rows($result_default) == 1) {
										$i=0;
										while($obj_conf = mysql_fetch_object($result_default)){
											/* default's profile */
											$profile_conf['id'][0] = $obj_conf->var_id;
											$profile_conf['name'][0] = $obj_conf->name;
											$profile_conf['date'][0] = $obj_conf->date;
											$profile_conf['default_conf'][0] = "yes";											
											$i++;
										}
									}
									
									/* select child */
									$sql = "SELECT * FROM `sim_profile` where `uid` = ".$_SESSION['uid']." AND `template_id` = ".$profile_conf['id'][0]." ";
									$result_preset = mysql_query($sql, $connection);
									if(mysql_num_rows($result_preset) > 0) {
										$field_list = array('id', 'name', 'date');
										while($obj_conf = mysql_fetch_object($result_preset)){
											foreach($field_list as $index => $field_name) {
												$profile_conf[$field_name][$i] = $obj_conf->$field_name;
												$profile_conf['default_conf'][$i] = "";
											}
											$i++;
										}
									}

									$default_profile_id = 0;
									for($i=0; $i<count($profile_conf['id']); $i++) {
										$var_prefix = ($profile_conf['default_conf'][$i] == "yes") ? "d_": "";
										if($profile_conf['default_conf'][$i] == "yes") {
											$h = "<optgroup label=\"Main Template\" style=\"font-style:normal\">";
											$t = "</optgroup>";
										}else {
											$h = "";
											$t = "";
										}
										if($i == 1) {
											$h = "<optgroup label=\"Previous Profiles\" style=\"font-style:normal\">";
											$t = "</optgroup>";
											$glob_id = $profile_conf['id'][$i];
											$select[] = $h."<option style=\"font-size:12px\" value=".$var_prefix.$profile_conf['id'][$i]." ".(($profile_conf['default_conf'][$i] == "yes") ? "selected": "").">- ".$profile_conf['name'][$i]." (".date("H:i:s j/m/Y", $profile_conf['date'][$i]).")</option>\n";										
											
										}else {
											$select[] = $h."<option style=\"font-size:12px\" value=".$var_prefix.$profile_conf['id'][$i]." ".(($profile_conf['default_conf'][$i] == "yes") ? "selected": "").">- ".$profile_conf['name'][$i]." (".date("H:i:s j/m/Y", $profile_conf['date'][$i]).")</option>".$t."\n";										
										}
									}	
									$select[count($select)-1] .= $select[count($select)-1]."</optgroup>";
					 ?>
                <select name="preset_id[<?=$glob_id?>]" id="profile_fault_conf" style="padding:3px; font-size:12px"  >
                  <?php foreach($select as $index => $str) echo $str; ?>
                </select>
              </td>
              <td></td>
            </tr>
          </table>
          </fieldset>
          <table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <th scope="col"><input name="back" type=button class=butenter id=back style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="&lt; Back" onClick="javascript: location.href='../?section=1';">
                <input name="submit322" type=reset class=butenter id=submit style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Clear form">
                <input name="reload" type=button class=butenter id=reload style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Reload" onClick="javascript: location.href='<?=$_SERVER['PHP_SELF']?>';">
                <input name="submit32222" type=submit class=butenter id=submit32222 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next &gt;"></th>
            </tr>
          </table>
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
