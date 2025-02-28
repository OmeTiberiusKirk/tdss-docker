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
	if(isset($_POST['sim_type'])) {
		$_SESSION['sim_type'] = $_POST['sim_type'];
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['domain'] = $_POST['domain'];
		$_SESSION['source'] = $_POST['source'];
		$_SESSION['ob_area'] = $_POST['ob_area'];
		$_SESSION['magnitude'] = $_POST['magnitude'];
		$_SESSION['depth'] = $_POST['depth'];
		$_SESSION['lat_degree'] = $_POST['lat_degree'];
		$_SESSION['lat_lipda'] = $_POST['lat_lipda'];
		$_SESSION['lat_Philipda'] = $_POST['lat_Philipda'];
		$_SESSION['long_degree'] = $_POST['long_degree'];
		$_SESSION['long_lipda'] = $_POST['long_lipda'];
		$_SESSION['long_Philipda'] = $_POST['long_Philipda'];
		$_SESSION['task_type'] = $_POST['task_type'];
		echo "<script language=\"javascript\">document.location.href = 'check_name_exist.php';</script>";
	}
	
	if(isset($_SESSION['sim_type']) && isset($_SESSION['name']) && $_REQUEST['cmd'] == "clear") {
		session_unregister("name");
		session_unregister("sim_type");
		session_unregister("description");
		session_unregister("domain");
		session_unregister("source");
		session_unregister("ob_area");
		session_unregister("preset_id");
		session_unregister("tbl_sim_profile");
		session_unregister("magnitude");
		session_unregister("depth");
		session_unregister("lat_degree");
		session_unregister("lat_lipda");
		session_unregister("lat_Philipda");
		session_unregister("long_degree");
		session_unregister("long_lipda");
		session_unregister("long_Philipda");
		session_unregister("task_type");
		session_unregister("template");
		session_unregister("data");
		echo "<script language='javascript'>document.location.href='".$_SERVER['PHP_SELF']."?section=1';</script>";
	}
?>
<script type="text/javascript" src="../../script/select-sim.js"></script>
<?php
	//require_once('../../library/tinymce.inc.php');
	//tinymce(true);
?>
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Create simulation<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <div style="background-color:#D7F1FB; padding:4px 4px 4px 4px; border-top:#0099FF 1px solid;">
          <div align="center"><strong>Step 1 of 6</strong><font color="#000099"></font></div>
        </div>
        <table width="0" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="height:4px"></td>
          </tr>
        </table>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="select_version" id="select_version">
          <?php
		if(isset($_SESSION['name']) && isset($_SESSION['sim_type']) && isset($_SESSION['description'])) {
		?>
          <div style="background-color:#FFFFCC; padding:4px 4px 4px 4px; border: #FF0000 1px solid;">
            <div align="center"><strong>Caution !&nbsp;&nbsp;</strong><font color="#000099">Previous profile has been detected. Please <a href="<?=$_SERVER['PHP_SELF']?>?section=1&cmd=clear"><font color="#FF0000">Clear Session</font></a> or continue</font></div>
          </div>
          <?php
		  }
		  ?>
          <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend class="dq_closestoday"><strong>Select TUNAMI version </strong></legend>
          <table border="0" cellpadding="3">
            <tr>
              <?php if($_REQUEST['status']['one'] == back){
			  			if($_SESSION['sim_type'] == "sequential"){
							$seq = "checked";
						}else{
							$par = "checked";
						}	
			  		} 
			 ?>
              <td valign="middle"><input name="sim_type" type="radio" id="radio" value="sequential"  "checked"></td>
              <td valign="middle">Sequential (single CPU) </td>
            </tr>
            <tr>
              <td valign="middle"><input type="radio" name="sim_type" id="radio2" value="parallel" disabled></td>
              <td valign="middle">Parallel (multiple CPUs) </td>
            </tr>
          </table>
          <?php
          		require_once('../../library/connectdb.inc.php');
				$idc = fn_get_last_auto_increment_id("sim_profile");
		  ?>
          </fieldset>
          <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend class="dq_closestoday"><strong>General Information</strong></legend>
          <table border="0" cellpadding="4" cellspacing="0">
            
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Name </th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong>
                <input name="name" type="text" id="name" style="width:350px;" value="<?=(isset($_SESSION['name'])) ? $_SESSION['name'] : "untitled-".$idc?>">
                </strong>
                <?php if(isset($_REQUEST['detect']) && ($_REQUEST['detect'] == "true")){?>
                <strong style="color:#FF0000">"
                <?=$_SESSION['name']?>
                " has been used !!!!</strong>
                <?php }?></th>
            </tr>
            <tr>
              <th align="left" valign="top" bgcolor="#F0F0F0" scope="col"><strong>Description</strong></th>
              <th scope="col" valign="top" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><textarea name="description" cols="60" rows="6" style="width:350px;"><?=strlen($_SESSION['description']) > 0? $_SESSION['description'] : "(none)"?>
</textarea></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Domain</th>
              <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong>
                <input name="domain" type="text" id="domain" style="width:250px;" size="40" value="<?=strlen($_SESSION['domain']) > 0? $_SESSION['domain'] : "(none)"?>">
                </strong></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Source</th>
              <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong>
                <input name="source" type="text" id="source" style="width:250px;" size="40" value="<?=strlen($_SESSION['source']) > 0? $_SESSION['source'] : "(none)"?>">
                </strong></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Observation area</th>
              <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong>
                <input name="ob_area" type="text" id="ob_area" style="width:250px;" size="40" value="<?=strlen($_SESSION['ob_area']) > 0 ? $_SESSION['ob_area'] : "(none)"?>">
                </strong></th>
            </tr>
          </table>
          </fieldset>
          <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
          <legend class="dq_closestoday"><strong>Earthquake parameters</strong></legend>
          <table border="0" cellpadding="4" cellspacing="0">
          
          <tr>
            <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Magnitude</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="magnitude" type="text" id="magnitude" style="width:200px" value="<?=isset($_SESSION['magnitude'])?$_SESSION['magnitude']:0?>">
              </strong></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Depth</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="depth" type="text" id="depth" style="width:200px" value="<?=isset($_SESSION['depth'])?$_SESSION['depth']:0?>">
              </strong></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Latitude</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><strong>
                    <input name="lat_degree" type="text" id="lat[degree]" style="width:50px" value="<?=isset($_SESSION['lat_degree'])?$_SESSION['lat_degree']:0?>">
                  </strong></td>
                  <td>&nbsp;°&nbsp;</td>
                  <td><strong>
                    <input name="lat_lipda" type="text" id="lat_lipda" style="width:50px" value="<?=isset($_SESSION['lat_lipda'])?$_SESSION['lat_lipda']:0?>">
                  </strong></td>
                  <td>&nbsp;'&nbsp;</td>
                  <td><strong>
                    <input name="lat_Philipda" type="text" id="lat_Philipda" style="width:50px" value="<?=isset($_SESSION['lat_Philipda'])?$_SESSION['lat_Philipda']:0?>">
                  </strong></td>
                  <td>&nbsp;''&nbsp;</td>
                </tr>
              </table></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Longitude</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><strong>
                  <input name="long_degree" type="text" id="long_degree" style="width:50px" value="<?=isset($_SESSION['long_degree'])?$_SESSION['long_degree']:0?>">
                </strong></td>
                <td>&nbsp;°&nbsp;</td>
                <td><strong>
                  <input name="long_lipda" type="text" id="long_lipda" style="width:50px" value="<?=isset($_SESSION['long_lipda'])?$_SESSION['long_lipda']:0?>">
                </strong></td>
                <td>&nbsp;'&nbsp;</td>
                <td><strong>
                  <input name="long_Philipda" type="text" id="long_Philipda" style="width:50px" value="<?=isset($_SESSION['long_Philipda'])?$_SESSION['long_Philipda']:0?>">
                </strong></td>
                <td>&nbsp;''&nbsp;</td>
              </tr>
            </table></th>
            </tr>
        </table>
        </fieldset>
          <fieldset style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend class="dq_closestoday"><strong>Select type of task</strong></legend>
          <table border="0" cellpadding="3">
            <tr>
              <?php if($_SESSION['status']['two'] == "back"){
			  			if($_SESSION['task'] == "sim_only"){
							$sim_only = "checked";
						}else{
							$one_stop = "checked";						
						}
					}
				?>
              <td valign="middle"><input name="task_type" type="radio" id="radio" value="sim_only" checked <?=(($_SESSION['status']['two'] = "back") ? $sim_only : "checked")?>></td>
              <td valign="middle">Simulation Tasks (no visualization) </td>
            </tr>
            <tr>
              <td valign="middle"><input type="radio" name="task_type" id="radio2" value="one_stop" disabled></td>
              <td valign="middle">One Stop Tasks (Simulation + Visualization) </td>
            </tr>
          </table>
          </fieldset>
          <table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <th align="left" valign="top" scope="col"><input name="next3" type=reset class=butenter id=next3 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Clear">
                <input name="reload2" type=button class=butenter id=reload2 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Reload" onClick="javascript: document.location.href='<?=$_SERVER['PHP_SELF']?>?section=6';">
                <input name="next3" type=submit class=butenter id=next4 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next &gt;"></th>
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
