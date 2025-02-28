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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Add new group of observation point<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <script type="text/javascript" src="wz_tooltip/wz_tooltip.js"></script>
        <?php
        	if(strlen($_POST['g_name']) > 0 && isset($_POST['add'])) {
				require_once('../../library/connectdb.inc.php');
				$sql = "INSERT INTO `observe_group`(`g_name`) VALUES('".$_REQUEST['g_name']."')";
				echo $sql;
				exit;
				mysql_query($sql, $connection) or die('! Could not insert new group name.');
			}	
		?>
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operation:</strong>&nbsp;&nbsp;<a href="observ_point.php?section=9">List the observation points</a> | <a href="new_ob_group.php?section=9" onclick = "document.getElementById('LBOX').src='importer.php';document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><font color="#000099">Group configuration</font></a><br>
        </div>
        <form action="<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&act=update_status" method="post" name="update" id="update">
          <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend class="style37  style3"><strong><font color="#990000">List of group</font></strong></legend>
          <div align="left"><span style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:"> </span>
            <table width="10" height="2" border="0">
              <tr>
                <td></td>
              </tr>
            </table>
          </div>
          <table border="0" cellpadding="5" cellspacing="0" class=" tbl_border fs14px">
            <tr align="center" bgcolor="#FFFFCC" class="td-0" >
              <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">No.</font></td>
              <td rowspan="2" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Name</font></td>
            </tr>
            <tr bgcolor="#FFFFCC" align="center" >
              <td colspan="2" bgcolor="#7B869A"><font color="#FFFFFF">Action</font></td>
            </tr>
            <?php
         require_once('../../library/connectdb.inc.php');		 
		 if($_REQUEST['act'] == "del" && $_REQUEST['id'] > 0) {
		 	$sql = "DELETE FROM `observe_group` WHERE `id` = ".addslashes($_REQUEST['id']);
			mysql_query($sql, $connection) or die("! could not delete.");
			
		 }
		 
		 if($_REQUEST['act'] == "update_status") {
		 	$sql = "UPDATE `observe_group` SET `default` = 'no'";
			mysql_query($sql, $connection) or die("! something wrong, please contact administrator.");
			
		 	$sql = "UPDATE `observe_group` SET `default` = 'yes' WHERE `id` = ".$_POST['set_default'];
			mysql_query($sql, $connection) or die("! could not update status.");
			
			foreach($_POST['g_name'] as $id => $g_name) {
				$sql = "UPDATE `observe_group` SET `g_name` = '".$g_name."' WHERE `id` = ".$id;
				mysql_query($sql, $connection) or die("! could not update group.");
			}
		 }
		
		 $sql = "SELECT * FROM `observe_group`";
		 $res = mysql_query($sql, $connection);
		 if(mysql_num_rows($res) > 0) {
		 	$i=0;
		 	while($obj = mysql_fetch_object($res)) {
				if(($i++)%2) {
		 ?>
            <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <td class="tbl_border_top tbl_border_right"><?=$obj->id?></td>
              <td class="tbl_border_top tbl_border_right"><div align="left" id="g_name_dis<?=$obj->id?>" onClick="javascript: document.getElementById('g_name_dis<?=$obj->id?>').style.display='none'; document.getElementById('g_name_edit<?=$obj->id?>').style.display='';">
                  <?=$obj->g_name?>
                </div>
                <div align="left" id="g_name_edit<?=$obj->id?>" style="display:none">
                  <input type="text" name="g_name[<?=$obj->id?>]" value="<?=$obj->g_name?>">
                  &nbsp;<a href="javascript: void(0)" onClick="javascript: document.getElementById('g_name_dis<?=$obj->id?>').style.display=''; document.getElementById('g_name_edit<?=$obj->id?>').style.display='none';">Close</a></div></td>
              <td class="tbl_border_top tbl_border_right"><div align="center">
                  <table width="0" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><input type="radio" name="set_default" value="<?=$obj->id?>" <?=$obj->default == "yes" ? "checked" : ""?>></td>
                      <td>set default</td>
                    </tr>
                  </table>
                </div></td>
              <td class="tbl_border_top"><a href=" <?=$_SERVER['PHP_SELF']?>?act=del&id=<?=$obj->id?>" onClick=""><font color="#CC3300">Delete</font></a></td>
            </tr>
            <?php
                } else {
				?>
            <tr align="center" bgcolor="#EBEBEB" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <td class="tbl_border_top tbl_border_right"><?=$obj->id?></td>
              <td class="tbl_border_top tbl_border_right">
              <div align="left" id="g_name_dis<?=$obj->id?>" onClick="javascript: document.getElementById('g_name_dis<?=$obj->id?>').style.display='none'; document.getElementById('g_name_edit<?=$obj->id?>').style.display='';">
                <?=$obj->g_name?>
              </div>
              <div align="left" id="g_name_edit<?=$obj->id?>" style="display:none">
                <input type="text" name="g_name[<?=$obj->id?>]" value="<?=$obj->g_name?>">
                &nbsp;<a href="javascript: void(0)" onClick="javascript: document.getElementById('g_name_dis<?=$obj->id?>').style.display=''; document.getElementById('g_name_edit<?=$obj->id?>').style.display='none';">Close</a></div>
              </td>
              <td class="tbl_border_top tbl_border_right"><div align="center">
                  <table width="0" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><input type="radio" name="set_default" value="<?=$obj->id?>" <?=$obj->default == "yes" ? "checked" : ""?>></td>
                      <td>set default</td>
                    </tr>
                  </table>
                </div></td>
              <td class="tbl_border_top"><a href="<?=$_SERVER['PHP_SELF']?>?act=del&id=<?=$obj->id?>" onClick=""><font color="#CC3300">Delete</font></a></td>
            </tr>
            <?php
		 		}
         	}
         }
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
                <td><input name="update" type=submit class=butenter id=update style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Update Status" <?=$disable_flag?>  onClick="javascript: confirm_del_vis('<?=$visres['name']?>', <?=$_REQUEST['id']?>);"></td>
              </tr>
            </table>
          </div>
          </fieldset>
        </form>
        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
        <legend><strong><font color="#990000">Enter name</font></strong></legend>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="add" id="add">
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <table border="0" cellpadding="5" cellspacing="1" class=" fs14px">
            <tr align="center">
              <td><div align="left">
                  <input name="g_name" type="text" id="g_name" style="width:300px">
                </div></td>
            </tr>
          </table>
          <div align="left">
            <table border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td><input name="restore22222" type=submit class=butenter id=restore2222 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="   Add   " <?=$disable_flag?>  onClick="" >
                  &nbsp;&nbsp;</td>
                <td>&nbsp;</td>
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
</BODY>
<!-- InstanceEnd --></HTML>
