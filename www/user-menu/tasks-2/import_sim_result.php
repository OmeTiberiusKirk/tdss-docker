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
	if($_REQUEST['clear'] == "yes")
		session_unregister("import");

	if($_POST['next']) {
		$_SESSION['import'][1] = $_POST;
		echo "<script language=javascript>location.href='import_sim_select_ob_point.php?section=3&grp_id=".$_REQUEST['grp_id']."';</script>";
	}
	
	require_once('../../library/connectdb.inc.php');
	
	$id_inc = fn_get_last_auto_increment_id("sim_result");
	
	/*if(!isset($_REQUEST['grp_id'])) {
		$sql = "SELECT * FROM `observe_group` WHERE `default` LIKE 'yes';";
		$rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		$obj = mysql_fetch_object($rg);
		$g_default = $obj->g_name;
		$g_default_id = $obj->id;
		$_REQUEST['grp_id'] = $g_default_id;
		$_SESSION['g_name'] = $g_default;
		$_SESSION['g_id'] = $g_default_id;
	}else {*/
		$sql = "SELECT * FROM `observe_group` WHERE `id` = ".$_REQUEST['grp_id'];
		$rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		$obj = mysql_fetch_object($rg);
		$g_default = $obj->g_name;
		$g_default_id = $obj->id;
		$_REQUEST['grp_id'] = $g_default_id;
		$_SESSION['g_name'] = $g_default;
		$_SESSION['g_id'] = $g_default_id;	
	//}
?>
<script language="javascript">
	function enable_res_browser(sender_id, reciever_id) {
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
		document.getElementById('res').src = '../data-source/resource_browser.php?grp_id=<?=$_REQUEST['grp_id']?>&type=vis&data=region_dx&id_parent='+reciever_id+'&id_dwn=a';
	}
	
	//parent.p_echo(id_parent, id, filename, path, id_dwn');
	function p_echo(local_id_parent, id, filename, path, local_id_download) {
		str = '<a href="../data-source/download_file.php?download_filepath='+path+'">'+filename+'</a>'+'<input type="hidden" name="'+local_id_parent+'[filename]" value="'+filename+'">';
		str = str+'<input type="hidden" name="'+local_id_parent+'[path]" value="'+path+'">';
		//str = str+'<input type="hidden" name="'+local_id_parent+'[id]" value="'+id+'">';
		document.getElementById(local_id_parent).innerHTML = str;
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
.style38 {
	color: #FF0000;
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
<DIV id=header>
  <div class="style1" id="Layer1">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><img src="../../image/image001.png" alt="" width="74" height="68"></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>Tsunami Decision Support System<br>
              <font style="size:15px">by National Disaster Warning Center (NDWC) and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University">Chulalongkorn University</a></font></td>
            </tr>
          </table></td>
        <td>&nbsp;</td>
        <td valign="top"><img src="../../image/Logo-Chula.png" alt="" height="68" border="0" usemap="#Map2"></td>
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
          <td><div align="center" class="style2">&nbsp;Thai National Grid Center</div></td>
        </tr>
      </table>
    </center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Import&nbsp;simulation&nbsp;result [Step 1 of 3]<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
      <form action="<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>" method="post" enctype="multipart/form-data">
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="10"></td>
              </tr>
            <tr>
              <td><strong>Operation</strong></td>
              <td><strong>&nbsp;:&nbsp;</strong></td>
              <td>&nbsp;<a href="javascript: void();" onClick="javascript: document.location.href='<?=$_SERVER['REQUEST_URI']?>';"><font color="#000099">Reload</font></a> | <a href="result.php?section=3" style="color:#000099">Back</a></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
        <?php
		if(isset($_SESSION['import'])) {
		?>
        <img src="../../image/spacer.gif" width="1" height="3">
        <div style="background-color:#FFFF99; padding:4px 4px 4px 4px; border-top:#999999 1px solid;">
          <div align="center">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><font color="#FF0000"><strong>Caution !</strong></font></td>
                <td>&nbsp;</td>
                <td>Previous task has been detected. Please <a href="<?=$_SERVER['PHP_SELF']?>?section=3&grp_id=<?=$_REQUEST['grp_id']?>&clear=yes">clear session</a> before fill in the form.</td>
              </tr>
            </table>
          </div>
        </div>
       	<?php
		}
		?>
        <table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="height:4px"></td>
  </tr>
</table>
<div style="background-color:#FFFF99; padding:4px 4px 4px 4px; border-top:#999999 1px solid">
          <div align="center"><span class="style38">Notice !</span>&nbsp;You are importing the simulation result on the group of <b><font color="#000099">`<?=$g_default?>`</font></b>. <a href="../config/new_ob_group.php?section=9">(change)</a></div>
        </div>
        <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
        <legend class="style37"><strong>General information</strong></legend>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Name </th>
            <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="name" type="text" style="width:350px" id="name" value="<?=isset($_SESSION['import'][1]['name'])?$_SESSION['import'][1]['name']:"untitled-".$id_inc?>">
              </strong></th>
            </tr>
          <!--<tr>
            <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Source</strong></th>
            <th scope="col" valign="top" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="source" type="text" id="source" style="width:350px" value="<?=isset($_SESSION['import'][1]['source'])?$_SESSION['import'][1]['source']:""?>">
            </strong></th>
            </tr>
          <tr>
            <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Domain</strong></th>
            <th scope="col" valign="top" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="domain" type="text" id="domain" style="width:350px" value="<?=isset($_SESSION['import'][1]['domain'])?$_SESSION['import'][1]['domain']:""?>">
            </strong></th>
          </tr>
          <tr>
            <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Observation Area</strong></th>
            <th scope="col" valign="top" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="ob_area" type="text" id="ob_area" style="width:350px" value="<?=isset($_SESSION['import'][1]['ob_area'])?$_SESSION['import'][1]['ob_area']:""?>">
            </strong></th>
          </tr>-->
          <!--<tr>
            <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Description</strong><strong>
              <input name="source" type="hidden" id="source" value="<?=isset($_SESSION['import'][1]['source'])?$_SESSION['import'][1]['source']:""?>">
              <input name="domain" type="hidden" id="domain" value="<?=isset($_SESSION['import'][1]['domain'])?$_SESSION['import'][1]['domain']:""?>">
              <input name="ob_area" type="hidden" id="ob_area" value="<?=isset($_SESSION['import'][1]['ob_area'])?$_SESSION['import'][1]['ob_area']:""?>">
            </strong></th>
            <th scope="col" valign="top" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><textarea name="description" cols="60" rows="6" id="description" style="width:350px;" ><?=isset($_SESSION['import'][1]['description'])?$_SESSION['import'][1]['description']:""?></textarea></th>
          </tr>-->
        </table>
        </fieldset>
        <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
        <legend class="style37"><strong>Earthquake information</strong></legend>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <th align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Parameter</font></div></th>
            <th valign="middle" bgcolor="#7B869A" scope="col" ><div align="center"><font color="#FFFFFF"></font></div></th>
            <th align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Values</font></div></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Magnitude</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="magnitude" type="text" id="magnitude" style="width:200px" value="<?=isset($_SESSION['import'][1]['magnitude'])?$_SESSION['import'][1]['magnitude']:0?>">
              </strong></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Depth</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><strong>
              <input name="depth" type="text" id="depth" style="width:200px" value="<?=isset($_SESSION['import'][1]['depth'])?$_SESSION['import'][1]['depth']:0?>">
              </strong></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Latitude</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><input name="decimal_lat" type="text" id="decimal_lat" style="width:200px" value="<?=isset($_SESSION['import'][1]['decimal_lat'])?$_SESSION['import'][1]['decimal_lat']:0?>"><!--<table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><strong>
                    <input name="lat[degree]" type="text" id="lat[degree]" style="width:50px" value="<?=isset($_SESSION['import'][1]['lat']['degree'])?$_SESSION['import'][1]['lat']['degree']:0?>">
                    
                  </strong></td>
                  <td>&nbsp;°&nbsp;</td>
                  <td><strong>
                    <input name="lat[lipda]" type="text" id="lat[lipda]" style="width:50px" value="<?=isset($_SESSION['import'][1]['lat']['lipda'])?$_SESSION['import'][1]['lat']['lipda']:0?>">
                  </strong></td>
                  <td>&nbsp;'&nbsp;</td>
                  <td><strong>
                    <input name="lat[Philipda]" type="text" id="lat[Philipda]" style="width:50px" value="<?=isset($_SESSION['import'][1]['lat']['Philipda'])?$_SESSION['import'][1]['lat']['Philipda']:0?>">
                  </strong></td>
                  <td>&nbsp;''&nbsp;</td>
                </tr>
              </table>--></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Longitude</th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><!--<table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><strong>
                  <input name="long[degree]" type="text" id="long[degree]" style="width:50px" value="<?=isset($_SESSION['import'][1]['long']['degree'])?$_SESSION['import'][1]['long']['degree']:0?>">
                </strong></td>
                <td>&nbsp;°&nbsp;</td>
                <td><strong>
                  <input name="long[lipda]" type="text" id="long[lipda]" style="width:50px" value="<?=isset($_SESSION['import'][1]['long']['lipda'])?$_SESSION['import'][1]['long']['lipda']:0?>">
                </strong></td>
                <td>&nbsp;'&nbsp;</td>
                <td><strong>
                  <input name="long[Philipda]" type="text" id="long[Philipda]" style="width:50px" value="<?=isset($_SESSION['import'][1]['long']['Philipda'])?$_SESSION['import'][1]['long']['Philipda']:0?>">
                </strong></td>
                <td>&nbsp;''&nbsp;</td>
              </tr>
            </table>-->
              <input name="decimal_long" type="text" id="decimal_long" style="width:200px" value="<?=isset($_SESSION['import'][1]['decimal_long'])?$_SESSION['import'][1]['decimal_long']:0?>"></th>
            </tr>
        </table>
        </fieldset>
        <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
        <legend class="style37"><strong>Specify topology and bathymetry file</strong></legend>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <th align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Region No.</font></div></th>
            <th valign="middle" bgcolor="#7B869A" scope="col" ><div align="center"><font color="#FFFFFF"></font></div></th>
            <th align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">File Name</font></div></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="center">1 </div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <div id="reg_dis_1" style="color:#009900"></div>                    </td>
                  <td>&nbsp;</td>
                  <td>
                    <input type="button" name="btn_L1" id="region_1" value="Browse..." onClick="javascript: enable_res_browser('region_1', 'reg_dis_1');">                    </td>
                </tr>
              </table></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="center">2</div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <div id="reg_dis_2" style="color:#009900"></div>                    </td>
                  <td>&nbsp;</td>
                  <td><strong>
                    <input type="button" name="btn_L2" id="region_2" value="Browse..." onClick="javascript: enable_res_browser('region_2', 'reg_dis_2');">
                    </strong></td>
                </tr>
              </table></th>
            </tr>
            <!--
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="center">3</div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <div id="reg_dis_3" style="color:#009900"></div>                    </td>
                  <td>&nbsp;</td>
                  <td><strong>
                    <input type="button" name="btn_L3" id="region_3" value="Browse..." onClick="javascript: enable_res_browser('region_3', 'reg_dis_3');">
                    </strong></td>
                </tr>
              </table></th>
            </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="center">4</div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <div id="reg_dis_4" style="color:#009900"></div>                    </td>
                  <td>&nbsp;</td>
                  <td><strong>
                    <input type="button" name="btn_L4" id="region_1" value="Browse..." onClick="javascript: enable_res_browser('region_4', 'reg_dis_4');">
                    </strong></td>
                </tr>
              </table></th>
            </tr>
            -->
        </table>
        </fieldset>
        <br>
        <!--<input name="next2" type=reset class=butenter id=next2 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Clear">-->
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
</BODY>
<!-- InstanceEnd --></HTML>
