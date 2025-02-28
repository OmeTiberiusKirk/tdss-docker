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
<HTML xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/user.dwt.php" codeOutsideHTMLIsLocked="true" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Web Portal :: Operation and Research Section</TITLE>
<script language="javascript">

	function del_item(eid, name, grp_id) {
		if(confirm('Do you really want to delete `'+name+'` ?')) {
			document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id='+grp_id+'&act=del&id='+eid;
		}else
			return;
	}
	
	function swap_pane() {
		if(sim_pane.style.display == '')
			alert('sim_pane is openned');
		else
			alert('test');
	}
	
	function select_jump(v){ //v3.0
		<?php
		if(isset($_REQUEST['list'])) {
			?>
			document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id=<?=$_REQUEST['grp_id']?>&sort='+v+'&list=<?=$_REQUEST['list']?>';
			<?
		}else {
		?>
	 	document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id=<?=$_REQUEST['grp_id']?>&sort='+v;
		<?php
		}
		?>
	}
	
	function jump(v){ //v3.0
		document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id='+v;
	 // if (restore) selObj.selectedIndex=0;
	}
	
</script>
<?php

	require_once('../../library/connectdb.inc.php');
	
	if(isset($_REQUEST['grp_id']) && $_REQUEST['grp_id'] > 0) 
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
	/******************* Water level ************************/
	/* Delete deformation file 
	if($_REQUEST['CMD'] == "del_water_level" && $_REQUEST['param'] > 0) {
		$sql = "DELETE FROM `ds_dx_water_level` WHERE id=".$_REQUEST['param'];
		unlink(base64_decode($_REQUEST['filepath'])) or die("could not delete water level file (id=".$_REQUEST['param'].").");;
		if(mysql_query($sql, $connection)) {
			echo "<script language=javascript>document.location.href='ds_list_vis.php?section=7';</script>";
		}else
			echo "<script language=javascript>alert('Could not delete id ".$_REQUEST['param']." ?');</script>";
	}*/
	
	if($_REQUEST['act'] == "del" && $_REQUEST['id'] > 0 && !isset($_REQUEST['res'])) {
		ob_start();
		ob_implicit_flush();
		if(is_resource($connection)) {
			$sim_result_id = $_REQUEST['id'];
			$sql = "SELECT * FROM `sim_result` WHERE `id`=".$sim_result_id." AND `grp_id` = ".$_REQUEST['grp_id'];
			$result = mysql_query($sql, $connection) or die("! query failed on line ".__LINE__);
			if(mysql_num_rows($result) == 1) {
				mysql_query("START TRANSACTION");
				$sql = "SELECT * FROM `job_profile` WHERE `sim_profile_id` = ".$sim_result_id;
				$result = mysql_query($sql, $connection);
				if(mysql_num_rows($result) == 1) {
					$obj = mysql_fetch_object($result);
					$dir = $obj->local_store_path;
					$dir = realpath($dir);
					$chk = is_dir($dir) ? true : false;
					if($chk) {
						if(stristr(PHP_OS, 'WIN'))
							exec("echo Y | rd /s ".$dir) or die("! [win32] failed to delete job dir");
						else
							exec("rm -rf ".$dir);
					}else ; //echo("! [notice] not distination dir.\n!Waiting to delete profile ...");

					$sql = "DELETE FROM `sim_result`, `sim_profile`, `sim_point_val`, `job_profile`, `sim_visfile` ";
					$sql .= "USING `sim_result`, `sim_profile`, `sim_point_val`, `job_profile`, `sim_visfile` ";
					$sql .= "WHERE `sim_result`.`id` = `sim_point_val`.`sim_result_id` AND ";
					$sql .= "`sim_result`.`id` = `job_profile`.`sim_profile_id` AND ";
					$sql .= "`sim_result`.`job_profile_id` = `sim_profile`.`id` AND ";
					$sql .= "`sim_result`.`id` = ".$sim_result_id." AND `sim_visfile`.`id_sim_result` = ".$sim_result_id." AND ";
					$sql .= "`sim_result`.`grp_id` = ".$_REQUEST['grp_id'];
					mysql_query($sql, $connection) or die("! unable to delete job profile.");
					
				} else die("! job profile is not found.");
			}else die("! something wrong.");
			mysql_query("COMMIT") or die("! unable to commit transaction");
			sleep(0.5);
			echo "<script language=javascript>document.location.href='".$_SERVER['PHP_SELF']."?section=3&grp_id=".$_REQUEST['grp_id']."&res=success';</script>";						
		}else die("! no db link");
	}
		
	/* get total deformation file */
	$limit = 10;
	if(!isset($_REQUEST['total'])) {
		$sql = "SELECT * FROM `sim_result` WHERE `grp_id` = ".$_REQUEST['grp_id'];
		$result = mysql_query($sql, $connection);
		$total = mysql_num_rows($result);
	}else $total = $_REQUEST['total'];
	$no_page = ceil($total/$limit);
	
	/* check Has `button` was clicked */
	if(!isset($_REQUEST['btn'])) {
		$start = 0;
		$limit = 10;
		$curr_page = 1;
	}else {
		$start = $_REQUEST['start'];
		$limit = $_REQUEST['limit'];
		$curr_page = $_REQUEST['curr_page'];
		
		if($start > $total) {
			$start = 0;
			$curr_page = 1;
		}
	}
	
	$str_next = "document.location.href='".$_SERVER['PHP_SELF']."?section=3&grp_id=".$_REQUEST['grp_id']."&btn=next&start=".($start+$limit)."&limit=".$limit."&curr_page=".($curr_page+1)."&total=".$total."&sort=".$_REQUEST['sort']."&list=".$_REQUEST['list']."';";
	$selected_page[$_REQUEST['curr_page']-1] = " selected";
	
	for($i=0; $i<$no_page; $i++) {
		$str_jump_page[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?section=3&grp_id=".$_REQUEST['grp_id']."&btn=next&start=".($i * $limit)."&limit=".$limit."&curr_page=".($i+1)."&sort=".$_REQUEST['sort']."&list=".$_REQUEST['list']."';";
	}
	
	if( ($start-$limit) < 0) {
		$start = 0;
		$curr_page = 1;
		$str_back = "document.location.href='".$_SERVER['PHP_SELF']."?section=3&grp_id=".$_REQUEST['grp_id']."&btn=back&start=".$start."&limit=".$limit."&curr_page=".$curr_page."&total=".$total."&sort=".$_REQUEST['sort']."&list=".$_REQUEST['list']."';";
	}else {
		$str_back = "document.location.href='".$_SERVER['PHP_SELF']."?section=3&grp_id=".$_REQUEST['grp_id']."&btn=back&start=".($start-$limit)."&limit=".$limit."&curr_page=".($curr_page-1)."&total=".$total."&sort=".$_REQUEST['sort']."&list=".$_REQUEST['list']."';";
	}
	
	$str_back_end = "document.location.href='".$_SERVER['PHP_SELF']."?section=3&grp_id=".$_REQUEST['grp_id']."&btn=back_end&start=0&limit=".$limit."&curr_page=1&total=".$total."&sort=".$_REQUEST['sort']."&list=".$_REQUEST['list']."';";
	
	$str_next_end = "document.location.href='".$_SERVER['PHP_SELF']."?section=3&grp_id=".$_REQUEST['grp_id']."&btn=next_end&start=".($limit * ($no_page-1))."&limit=10&curr_page=".$no_page."&total=".$total."&sort=".$_REQUEST['sort']."&list=".$_REQUEST['list']."';";

	//$sql = "SELECT * FROM `ds_dx_water_level` LIMIT ".$start.", ".$limit;
	$expr = array();
	switch($_REQUEST['sort']) {
		case "name":
		case "magnitude":
		case "depth":
			$order = $_REQUEST['sort'];
			break;
		case "create_date":
		default:
			$order = "datetime";
			$_REQUEST['sort'] = "create_date";
			if(!isset($_REQUEST['list']))
				$_REQUEST['list'] = "DESC";							
			break;
		case "latitude":
			$order = "decimal_lat";
			break;
		case "longitude":
			$order = "decimal_long";
			break;
	}
	$sq = "SELECT * FROM `sim_result`  WHERE  `uid` =".$_SESSION['uid']." AND `grp_id` = ".$_REQUEST['grp_id']." ORDER BY `".$order."` ".$_REQUEST['list']." LIMIT ".$start.", ".$limit;
	$result = mysql_query($sq, $connection) or die("! query failed.");
	if(is_resource($result)) {
		$total_p = mysql_num_rows($result);
		if($total_p > 0) {					
			$i =0;
			$field_list = array("id", "job_profile_id", "name", "magnitude", "depth", "decimal_lat", "decimal_long", "grp_id", "datetime");
			while($obj = mysql_fetch_object($result)) {
				foreach($field_list as $index => $field_name) {
					$sim_result[$field_name][$i] = $obj->$field_name;
				}
				$i++;
			}
		}
		else
			$total_p = 0;
	}
	/********* END **************/
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
.style7 {
	color: #990000;
	font-weight: bold;
	font-size: 12px;
}
.style39 {
	color: #FF6600
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
.style43 {
	font-size: 120%
}
-->
</style>
<script language="javascript">
	function enable_map(lat, long) {
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
		document.getElementById('res').src = 'http://www.ndwc.go.th/server_monitoring/map.php?lat='+lat+'&long='+long+'&zoom=6&info=Earthquake location';
	}
</script>
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" --><span class="dq_closestoday"> </span>&nbsp;Simulation results<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operations&nbsp;: &nbsp;</strong><a href="javascript: void(0)"><font color="#000099">Select  group</font></a>
          <select name="grp" id="grp" onChange="jump(this.value)" style="font-size:13px; text-align:left">
            <?php
          require_once('../../library/connectdb.inc.php');
		  $sql = "SELECT * FROM `observe_group`";
		  $rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		  if( mysql_num_rows($rg) > 0 ) {
		  	while($obj = mysql_fetch_object($rg)) {
		  ?>
            <option value="<?=$obj->id?>" style="font-size:13px; text-align:left" <?=$selected_group[$obj->id]?>>&nbsp;-
            <?=$obj->g_name?>
            &nbsp;
            <?=$obj->default == "yes" ? "(default)" : ""?>
            </option>
            <?php
		  	}
          }else {
		  ?>
            <option value="0">! ERROR, no define group</option>
            <?php
          }
		  ?>
          </select>
          | <a href="import_sim_result.php?section=3&grp_id=<?=$_REQUEST['grp_id']?>"><font color="#000099">Import simulation result</font></a> |
          <!--<a href="javascript: void(0)" onClick="javascript: if(document.getElementById('form_search').style.display=='') { document.getElementById('form_search').style.display='none'}else{ document.getElementById('form_search').style.display='';}"><font color="#000099">Search</font></a> | -->
          <a href="javascript: void(0)" onClick="javascript: document.location.href='<?=$_SERVER['PHP_SELF']?>?section=3&grp_id=<?=$_REQUEST['grp_id']?>';"><font color="#000099">Reload</font></a></div>
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <form>
          <?php
		  
				
		if($_REQUEST['res'] == "success") {
		?>
          <div id="msg_box" style="background-color:#FFFF99; padding:4px 4px 4px 4px; border-top:#999999 1px solid; border-bottom:#999999 1px solid; border-right:#999999 1px solid; border-left:#999999 1px solid;">
            <div align="center">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><font color="#FF0000"><strong>Note !</strong></font></td>
                  <td>&nbsp;</td>
                  <td>Delete   successful. <a href="javascript: void(0);" onClick="javascript: document.getElementById('msg_box').style.display = 'none';">Clear</a></td>
                </tr>
              </table>
            </div>
          </div>
          <?php
		}
		?>
          <table width="10" height="2" border="0">
            <tr>
              <td><table width="0" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td><strong>Sort&nbsp;by</strong></td>
                    <td>&nbsp;</td>
                    <td><?php
    $sel[$_REQUEST['sort']] = " selected";
	?>
                      <select name="select_sort_by" id="select_sort_by" onChange="javascript: select_jump(document.getElementById('select_sort_by').value);" style="font-size:13px; text-align:left">
                        <option value="name" <?=$sel['name']?> style="font-size:13px; text-align:left">Name</option>
                        <option value="magnitude" <?=$sel['magnitude']?> style="font-size:13px; text-align:left">Magnitude</option>
                        <option value="depth" <?=$sel['depth']?> style="font-size:13px; text-align:left">Depth (km)</option>
                        <option value="latitude" <?=$sel['latitude']?> style="font-size:13px; text-align:left">Latitude</option>
                        <option value="longitude" <?=$sel['longitude']?> style="font-size:13px; text-align:left">Longitude</option>
                        <option value="create_date" <?=$sel['create_date']?> style="font-size:13px; text-align:left">Create Date</option>
                      </select></td>
                    <td><a href="<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id=<?=$_REQUEST['grp_id']?>&sort=<?=$_REQUEST['sort']?>&list=ASC">[A&nbsp;to&nbsp;Z]</a></td>
                    <td><a href="<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id=<?=$_REQUEST['grp_id']?>&sort=<?=$_REQUEST['sort']?>&list=DESC">[Z&nbsp;to&nbsp;A]</a></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          <fieldset id="sim_pane" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
          <legend class="style7">List of simulation results</legend>
          <?php
		if(count($sim_result['id']) > 0) {
		?>
          <br>
          <div align="left">
            <!--<input type="button" value="&lt;&lt;" onClick="javascript: <?=$str_back_end?>">-->
            &nbsp;
            <input type="button" value="&lt;" onClick="javascript: <?=$str_back?>">
            &nbsp;Page number :
            <select name="select" id="select" style="font-size:13px; text-align:left">
              <?php
          for($p=1; $p<=$no_page; $p++){
		  ?>
              <option value="<?=$p?>" onClick="javascript: <?=$str_jump_page[$p]?>" <?=$selected_page[$p-1]?> style="font-size:13px; text-align:left">
              <?=$p?>
              </option>
              <?php
		   }
		   ?>
            </select>
            &nbsp;
            <input type="button" value="&gt;" onClick="javascript: <?=$str_next?>">
            &nbsp;
            <!--<input type="button" value="&gt;&gt;" onClick="javascript: <?=$str_next_end?>">-->
            &nbsp;
            <!--<input type="button" value="Get summary" onClick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/">-->
            Total<font color="#990000">&nbsp;<b>
            <?=$total?>
            </b></font>&nbsp;cases. </div>
          <?php
		}
		?>
          <br>
          <?php
			for($i=0; $i<count($sim_result['id']); $i++) {
			?>
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr onMouseOver="javascript: this.style.background='#D0EFFB'; this.style.borderBottom='#A4ED8B 1px solid'; this.style.borderTop='#A4ED8B 1px solid';  document.getElementById('s<?=$sim_result['id'][$i]?>').style.display='';" onMouseOut="javascript: this.style.background=''; this.style.borderBottom=''; this.style.borderTop=''; document.getElementById('s<?=$sim_result['id'][$i]?>').style.display='none';" title="<?="Create date : ".date('h:i:s A d/m/Y', $sim_result['datetime'][$i])?>">
              <td ><table border="0" cellpadding="0" cellspacing="1">
                  <tr>
                    <td rowspan="6" valign="top"><?php
                    $today = date('d', time());
					$cd = date('d', $sim_result['datetime'][$i]);
					#if($today == $cd) {
					?>
                      <a href="../bulletin/general.php?id=<?=$sim_result['id'][$i]?>&job_profile_id=<?=$sim_result['job_profile_id'][$i]?>&grp_id=<?=$sim_result['grp_id'][$i]?>">
                      <table width="49" height="51" border="0" cellpadding="0" cellspacing="0" background="../../image/blog-calendar.png">
                        <tr>
                          <td height="18"><div align="center"><font color="white"> M
                              <?=number_format($sim_result['magnitude'][$i], 1)?>
                              </font></div></td>
                        </tr>
                        <tr>
                          <td height="33"><div align="center"> <span class="style43">Δ</span>
                              <?=$sim_result['depth'][$i]?>
                            </div></td>
                        </tr>
                      </table>
                      </a>
                     
                    </td>
                    <td rowspan="6" valign="top">&nbsp;</td>
                    <td align="left" valign="top">Name: <strong>
                      <?=$sim_result['name'][$i]?>
                      </strong>, Magnitude: <strong>
                      <?=number_format($sim_result['magnitude'][$i], 1)?>
                      </strong>, Depth: <strong>
                      <?=$sim_result['depth'][$i]?>
                      </strong>km.</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Latitude:<font color="#0000CC"> <strong>
                      <?=$sim_result['decimal_lat'][$i]?>
                      </strong></font></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" valign="top">Longitude:<strong> <font color="#0000CC">
                      <?=$sim_result['decimal_long'][$i]?>
                      </font></strong></td>
                  </tr>
                </table></td>
              <td><div id="s<?=$sim_result['id'][$i]?>" style="display:none">
                  <div align="right"><a href="javascript: void(0);" onClick="javascript: enable_map(<?=$sim_result['decimal_lat'][$i]?>, <?=$sim_result['decimal_long'][$i]?>);">View&nbsp;earthquake&nbsp;location</a>&nbsp;|&nbsp;<a href="../bulletin/general.php?id=<?=$sim_result['id'][$i]?>&job_profile_id=<?=$sim_result['job_profile_id'][$i]?>&grp_id=<?=$sim_result['grp_id'][$i]?>" class="style39">Detail</a>&nbsp;|&nbsp;<a href="bulletin.php?section=4.1&id=<?=$sim_result['id'][$i]?>&grp_id=<?=$sim_result['grp_id'][$i]?>">Create&nbsp;Bulletin</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: del_item(<?=$sim_result['id'][$i]?>, '<?=$sim_result['name'][$i]?>', <?=$sim_result['grp_id'][$i]?>);">Delete</a>&nbsp;</div>
                </div></td>
            </tr>
          </table>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <?php
				}
			?>
          <?php
		if(count($sim_result['id']) != 0) {
		?>
          <br>
          <div align="left">
            <!--<input type="button" value="&lt;&lt;" onClick="javascript: <?=$str_back_end?>">-->
            &nbsp;
            <input type="button" value="&lt;" onClick="javascript: <?=$str_back?>">
            &nbsp;Page number :
            <select name="select" id="select" style="font-size:13px; text-align:left">
              <?php
          for($p=1; $p<=$no_page; $p++){
		  ?>
              <option value="<?=$p?>" onClick="javascript: <?=$str_jump_page[$p]?>" <?=$selected_page[$p-1]?> style="font-size:13px; text-align:left">
              <?=$p?>
              </option>
              <?php
		   }
		   ?>
            </select>
            &nbsp;
            <input type="button" value="&gt;" onClick="javascript: <?=$str_next?>">
            &nbsp;
            <!--<input type="button" value="&gt;&gt;" onClick="javascript: <?=$str_next_end?>">-->
            &nbsp;
            <!--<input type="button" value="Get summary" onClick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/">-->
            Total<font color="#990000">&nbsp;<b>
            <?=$total?>
            </b></font>&nbsp;cases. </div>
          <?php
		}
		?>
          </fieldset>
        </form>
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
<!-- InstanceEnd -->
</HTML>
