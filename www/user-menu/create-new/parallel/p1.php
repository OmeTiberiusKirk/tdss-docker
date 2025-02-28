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
	if(isset($_POST)) {
		$_SESSION['expr']['name'] = $_POST['name'];
		$_SESSION['expr']['description'] = $_POST['description'];
		$_SESSION['expr']['sim_type'] = $_POST['sim_type'];
	}
?>
<script language="javascript">
	function load_default()
	{
		alert('load default');
	}
	
	function submit_form(frm)
	{
		frm.submit();
	}
	
</script>
<style type="text/css">
<!--
.style4 {color: #009966}
.style5 {color: #FF0000}
.style7 {color: #990000; font-weight: bold; font-size: 12px; }
.style36 {color: #33CCFF}
.style39 {font-size: 18px}
.style41 {font-family: Verdana, Arial, Helvetica, sans-serif; color: #FF9900; font-size: small; font-weight: bold; }
.style43 {font-size: small}
.style46 {color: #626262}
-->
</style>
<?php	
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
.style4 {color: #CC0000; font-size: 12px; }
.style6 {color: #990000;
	font-weight: bold;
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
      <H2 id=icon_pick><img src="../../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" --><?=$_SESSION['expr']['name']?>  <!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
<form action="../lib.save-status.php?page=1" method="post" name="form_page_1" id="form_page_1" style="display:">
          
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <fieldset class="ForeCode">
          <legend class="dq_closestoday"><strong>Setup experiment information </strong></legend>
          <table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <th scope="col" valign="middle" align="left">Domain <input type="hidden" name="page" value="1"></th>
              <th scope="col" valign="middle"><img src="../../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong>
                <input name="domain" type="text" id="domain" style="width:250px" size="40">
              </strong></th>
              <th align="left" scope="col">&nbsp;</th>
            </tr>
            <tr>
              <th scope="col" valign="top" align="left"><strong>Tsunami Source </strong></th>
              <th scope="col" valign="middle" ><img src="../../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong>
                <input name="tsunami_source" type="text" id="tsunami_source" style="width:250px" size="40">
              </strong></th>
              <th align="left" scope="col">&nbsp;</th>
            </tr>
            <tr>
              <th scope="col" valign="middle" align="left"><strong>Tsunami Observation Area </strong></th>
              <th scope="col" valign="middle"><img src="../../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="tsunami_observation_area" type="text" id="tsunami_observation_area" style="width:250px" size="40" ></th>
              <th align="left" scope="col">&nbsp;</th>
            </tr>
          </table>
          </fieldset>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <fieldset class="ForeCode">
          <legend class="dq_closestoday"><strong>Setup global Parameters </strong></legend>
          <table border="0">
            <tr>
              <td><strong>DT1</strong></td>
              <td><input type="text" name="textfield3" /></td>
              <td>&nbsp;</td>
              <td><strong>DT</strong></td>
              <td><input type="text" name="textfield215" /></td>
            </tr>
            <tr>
              <td><strong>NT1</strong></td>
              <td><input type="text" name="textfield222" /></td>
              <td>&nbsp;</td>
              <td><strong>NT2</strong></td>
              <td><input type="text" name="textfield232" /></td>
            </tr>
            <tr>
              <td><strong>NF</strong></td>
              <td><input type="text" name="textfield242" /></td>
              <td>&nbsp;</td>
              <td><strong>NR</strong></td>
              <td><input type="text" name="textfield252" /></td>
            </tr>
            <tr>
              <td><strong>GX</strong></td>
              <td><input type="text" name="textfield262" /></td>
              <td>&nbsp;</td>
              <td><strong>GX1</strong></td>
              <td><input type="text" name="textfield272" /></td>
            </tr>
            <tr>
              <td><strong>GG</strong></td>
              <td><input type="text" name="textfield282" /></td>
              <td>&nbsp;</td>
              <td><strong>NTP</strong></td>
              <td><input type="text" name="textfield292" /></td>
            </tr>
            <tr>
              <td><strong>KP</strong></td>
              <td><input type="text" name="textfield2102" /></td>
              <td>&nbsp;</td>
              <td><strong>XG</strong></td>
              <td><input type="text" name="textfield2112" /></td>
            </tr>
            <tr>
              <td><strong>YG</strong></td>
              <td><input type="text" name="textfield2122" /></td>
              <td>&nbsp;</td>
              <td><strong>TIDE</strong></td>
              <td><input type="text" name="textfield2132" /></td>
            </tr>
            <tr>
              <td><strong>FM</strong></td>
              <td><input type="text" name="textfield2143" /></td>
              <td>&nbsp;</td>
              <td><strong>TIMEFAULT</strong></td>
              <td><input type="text" name="textfield21423" /></td>
            </tr>
            <tr>
              <td><strong>BASEPATH</strong></td>
              <td><input type="text" name="textfield214222" /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
		  </fieldset>
		  <table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <th scope="col"><input name="reload2" type=button class=butenter id=reload2 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="&lt; Back" onClick="javascript: location.href='p1.php';">
              <input name="submit322" type=reset class=butenter id=submit322 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Clear form">
                <input name="reload" type=button class=butenter id=reload style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Reload" onClick="javascript: location.href='<?=$_SERVER['PHP_SELF']?>';">
                <input name="submit3222" type=button class=butenter id=submit3222 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Load default profile" onClick="load_default();">
                <input name="submit32222" type=button class=butenter id=submit32222 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next &gt;" onClick="submit_form(this.form);"></th>
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
