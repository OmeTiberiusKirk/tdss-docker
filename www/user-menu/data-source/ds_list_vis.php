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
	if(!isset($_REQUEST['section'])) {
		/*echo "<script language=javascript>document.location.href='".$_SERVER['PHP_SELF']."?section=4';</script>";*/
	}
	
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
			
	/******************* Water level ************************/
	/* Delete deformation file */
	if($_REQUEST['CMD'] == "del_water_level" && $_REQUEST['id'] > 0) {
		$sql = "DELETE FROM `ds_input_water_level`, `ds_dx_water_level` USING `ds_input_water_level`, `ds_dx_water_level` WHERE `ds_input_water_level`.`id` = ".$_REQUEST['id']." AND `ds_input_water_level`.`id` = `ds_dx_water_level`.`wl_id`";
		@unlink(base64_decode($_REQUEST['ds_filepath']));
		@unlink(base64_decode($_REQUEST['dx_filepath']));
		if(mysql_query($sql, $connection)) {
			/*echo "<script language=javascript>document.location.href='ds_list_vis.php?section=7&filter=".$_REQUEST['filter']."#wl';</script>";*/
			echo "<script language=javascript>document.location.href='".$_SERVER['HTTP_REFERER']."#wl';</script>";
		}else
			echo "<script language=javascript>alert('Could not delete id ".$_REQUEST['param']." ?');</script>";
	}
	
	
	/* get total deformation file */
	$limit_dx = 20;
	if(!isset($_REQUEST['total_r'])) {
		$sql_dx = "SELECT * FROM `ds_dx_water_level` WHERE `grp_id` = ".$_REQUEST['grp_id'];
		$result_dx = mysql_query($sql_dx, $connection);
		$total_dx = mysql_num_rows($result_dx);
	}else $total_dx = $_REQUEST['total_dx'];
	$no_page_dx = ceil($total_dx/$limit_dx);

	/* check Has `button` was clicked */
	if(!isset($_REQUEST['btn_dx'])) {
		$start_dx = 0;
		$limit_dx = 20;
		$curr_page_dx = 1;
	}else {
		$start_dx = $_REQUEST['start_dx'];
		$limit_dx = $_REQUEST['limit_dx'];
		$curr_page_dx = $_REQUEST['curr_page_dx'];
		
		if($start_dx > $total_dx) {
			$start_dx = 0;
			$curr_page_dx = 1;
		}
	}
	
	$str_next_dx = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_dx=next_dx&start_dx=".(($start_dx+$limit_dx) == $total_dx ? $start_dx : ($start_dx + $limit_dx))."&limit_dx=".$limit_dx."&curr_page_dx=".(($curr_page_dx+1) > $no_page_dx ? $curr_page_dx : ($curr_page_dx+1))."&total_dx=".$total_dx."&filter=".$_REQUEST['filter']."#wl'";
	$selected_page_dx[$_REQUEST['curr_page_dx']-1] = " selected";
	
	for($i=0; $i<$no_page_dx; $i++) {
		$str_jump_page_dx[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_dx=next_dx&start_dx=".($i * $limit_dx)."&limit_dx=".$limit_dx."&curr_page_dx=".($i+1)."&total_dx=".$total_dx."&filter=".$_REQUEST['filter']."#wl'";
	}
	
	if( ($start_dx-$limit_dx) < 0) {
		$start_dx = 0;
		$curr_page_dx = 1;
		$str_back_dx = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_dx=back_dx&start_dx=".$start_dx."&limit_dx=".$limit_dx."&curr_page_dx=".$curr_page_dx."&total_dx=".$total_dx."&filter=".$_REQUEST['filter']."#wl'";
	}else {
		$str_back_dx = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_dx=back_dx&start_dx=".($start_dx-$limit_dx)."&limit_dx=".$limit_dx."&curr_page_dx=".($curr_page_dx-1)."&total_dx=".$total_dx."&filter=".$_REQUEST['filter']."#wl'";
	}
	
	$str_back_end_dx = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_dx=back_end_dx&start_dx=0&limit_dx=".$limit_dx."&curr_page_dx=1&total_dx=".$total_dx."&filter=".$_REQUEST['filter']."#wl'";
	$str_next_end_dx = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_dx=next_end_dx&start_dx=".($limit_dx * ($no_page_dx-1))."&limit_dx=".$limit_dx."&curr_page_dx=".$no_page_dx."&total_dx=".$total_dx."&filter=".$_REQUEST['filter']."#wl'";

	//$sql = "SELECT * FROM `ds_dx_water_level` LIMIT ".$start.", ".$limit;
	$sql_dx = "SELECT  
		`ds_input_water_level`.`id` AS `DS_ID`,
		`ds_input_water_level`.`path` AS `DS_PATH` ,  		
		`ds_dx_water_level`.`id` AS `DX_ID` ,  
		`ds_dx_water_level`.`filename` AS `DX_FILENAME` ,  
		`ds_dx_water_level`.`path` AS `DX_PATH` ,  
		`ds_dx_water_level`.`series` AS `DX_SERIES` ,  
		`ds_dx_water_level`.`timestep` AS `DX_TIMESTEP` ,  
		`ds_dx_water_level`.`no_of_grids_x` AS `DX_NOGRIDS_X` ,  
		`ds_dx_water_level`.`no_of_grids_y` AS `DX_NOGRIDS_Y` ,  
		`ds_dx_water_level`.`data_order` AS `DX_DATA_ORDER` ,  
		`ds_dx_water_level`.`type` AS `DX_TYPE` ,  
		`ds_dx_water_level`.`region_no` AS `DX_REGION_NO` ,  
		`ds_dx_water_level`.`create_date` AS `DX_CREATEDATE` 
	FROM `ds_dx_water_level` , `ds_input_water_level` WHERE `ds_dx_water_level`.`wl_id` = `ds_input_water_level`.`id` AND `ds_dx_water_level`.`grp_id` = ".$_REQUEST['grp_id']." ";
	
	if(isset($_REQUEST['filter'])) {
		if($_REQUEST['filter'] == "ETA")
			$sql_dx .= "AND `ds_dx_water_level`.`type` LIKE 'ETA' ";
		
		if($_REQUEST['filter'] == "ZMAX")
			$sql_dx .= "AND `ds_dx_water_level`.`type` LIKE 'Z_MAX' ";
	}
	
	$sql_dx .= " ORDER BY `ds_dx_water_level`.`filename` ASC "."LIMIT ".$start_dx.", ".$limit_dx;
	
	$result_dx = mysql_query($sql_dx, $connection) or die("! query failed.");
	if($result_dx) {
		$total_waterlevel_dx = mysql_num_rows($result_dx);
		if($total_waterlevel_dx > 0) {
			$i = 0;
			$field_dx_waterlevel_list = array("DS_ID", "DS_PATH", "DX_ID", "DX_FILENAME", "DX_PATH", "DX_SERIES", "DX_TIMESTEP", "DX_NOGRIDS_X", "DX_NOGRIDS_Y", "DX_DATA_ORDER", "DX_TYPE", "DX_REGION_NO", "DX_CREATEDATE");
			while($obj = mysql_fetch_object($result_dx)) {
				foreach($field_dx_waterlevel_list as $index => $field_name) {
					$row_dx_water_level[$field_name][$i] = $obj->$field_name;
				}
				$i++;
			}
		}
	}
	/********* END **************/
	
	/********************* REGION ***************/
	/* delete region file */
	if($_REQUEST['CMD'] == "del_dx_region" && $_REQUEST['id'] > 0) {
		$sql = "DELETE FROM `ds_input_region`, `ds_dx_region` USING `ds_input_region`, `ds_dx_region` WHERE `ds_input_region`.`id` = ".$_REQUEST['id']." AND `ds_input_region`.`id` = `ds_dx_region`.`reg_id`";
		unlink(base64_decode($_REQUEST['ds_filepath']));
		unlink(base64_decode($_REQUEST['dx_filepath']));
		if(mysql_query($sql, $connection)) {
			echo "<script language=javascript>document.location.href='ds_list_vis.php?section=7&grp_id=".$_REQUEST['grp_id']."';</script>";
		}else
			echo "<script language=javascript>alert('Could not delete id ".$_REQUEST['param']." ?');</script>";
	}
	
	$limit_r = 20;
	if(!isset($_REQUEST['total_r'])) {
		$sql_r = "SELECT * FROM `ds_dx_region` WHERE `grp_id` = ".$_REQUEST['grp_id'];
		$result_r = mysql_query($sql_r, $connection);
		$total_r = mysql_num_rows($result_r);
	}else $total_r = $_REQUEST['total_r'];
	$no_page_r = ceil($total_r/$limit_r);
	
	/* check Has `button` was clicked */
	if(!isset($_REQUEST['btn_r'])) {
		$start_r = 0;
		$limit_r = 20;
		$curr_page_r = 1;
	}else {
		$start_r = $_REQUEST['start_r'];
		$limit_r = $_REQUEST['limit_r'];
		$curr_page_r = $_REQUEST['curr_page_r'];
		
		if($start_r > $total_r) {
			$start_r = 0;
			$curr_page_r = 1;
		}
	}
	
	$str_next_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=next&start_r=".($start_r+$limit_r)."&limit_r=".$limit_r."&curr_page_r=".($curr_page_r+1)."&total_r=".$total_r."&filter=".$_REQUEST['filter']."#reg';";
	$selected_page_r[$_REQUEST['curr_page_r']-1] = " selected";
	
	for($i=0; $i<$no_page_r; $i++) {
		$str_jump_page_r[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=next&start_r=".($i * $limit_r)."&limit_r=".$limit_r."&curr_page_r=".($i+1)."&filter=".$_REQUEST['filter']."#reg';";
	}
	
	if( ($start_r-$limit_r) < 0) {
		$start_r = 0;
		$curr_page_r = 1;
		$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=back&start_r=".$start_r."&limit_r=".$limit_r."&curr_page_r=".$curr_page_r."&total_r=".$total_r."&filter=".$_REQUEST['filter']."#reg';";
	}else {
		$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=back&start_r=".($start_r-$limit_r)."&limit_r=".$limit_r."&curr_page_r=".($curr_page_r-1)."&total_r=".$total_r."&filter=".$_REQUEST['filter']."#reg';";
	}
	
	$str_back_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=back_end&start_r=0&limit_r=10&curr_page_r=1&total_r=".$total_r."&filter=".$_REQUEST['filter']."#reg'";
	$str_next_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=next_end&start_r=".($limit_r * ($no_page_r-1))."&limit_r=10&curr_page_r=".$no_page_r."&total_r=".$total_r."&filter=".$_REQUEST['filter']."#reg'";
	
	
	$sql_r = "SELECT 
				`ds_input_region`.`id` AS `DS_ID`,
				`ds_input_region`.`path` AS `DS_PATH`,
				`ds_dx_region`.`id` AS `DX_ID`,
				`ds_dx_region`.`filename` AS `DX_FILENAME`,
				`ds_dx_region`.`path` AS `DX_PATH`,
				`ds_dx_region`.`no_of_grids_x` AS `DX_NO_OF_GRIDS_X`,
				`ds_dx_region`.`no_of_grids_y` AS `DX_NO_OF_GRIDS_Y`,
				`ds_dx_region`.`data_order` AS `DX_DATA_ORDER`,
				`ds_dx_region`.`region_no` AS `DX_REGION_NO`,
				`ds_dx_region`.`grp_id` AS `DX_GRP_ID`,
				`ds_dx_region`.`create_date` AS `DX_CREATE_DATE`
			 FROM 
			 	`ds_input_region`, `ds_dx_region` 
			 WHERE 
			 	`ds_input_region`.`id` = `ds_dx_region`.`reg_id` AND 
				`ds_input_region`.`grp_id` = ".$_REQUEST['grp_id']." LIMIT ".$start_r.", ".$limit_r;
	$result_region_dx_r = mysql_query($sql_r, $connection);
	if($result_region_dx_r) {
		$dx_region_total_r = mysql_num_rows($result_region_dx_r);
		if($dx_region_total_r > 0) {
			$i = 0;
			$field_dx_region_list = array('DS_ID', 'DS_PATH', 'DX_ID', 'DX_FILENAME', 'DX_PATH', 'DX_NO_OF_GRIDS_X', 'DX_NO_OF_GRIDS_Y', 'DX_DATA_ORDER', 'DX_REGION_NO', 'DX_REGION_NO', 'DX_GRP_ID', 'DX_CREATE_DATE');
			while($obj_dx_region = mysql_fetch_object($result_region_dx_r)) {
				foreach($field_dx_region_list as $index => $field_name) {
					$row_dx_region[$field_name][$i] = $obj_dx_region->$field_name;
				}
				$i++;
			}
		}
	}
	/***************** END ***********************/
	/*
	echo "<pre>";
	print_r($row_region);
	echo "</pre>";
	*/
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
.tbl_border {
	border:black 1px solid;
}
.tbl_border_right {
	border-right:black 1px solid;
}
.tbl_border_top {
	border-top:black 1px solid;
}
-->
</style>
<style>
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
	top: 6%;
	left: 4%;
	right: 4%;
*/  width: 92%;
	height: 88%;
	bottom: 6%;
	padding: 2px;
	border: 2px solid orange;
	background-color: white;
	z-index:1002;
	overflow: hidden;
}
.style37 {
	color: #990000
}
</style>
<script language="javascript">
	function ds_select_input_type(select_val) {
		if(select_val == 'vis') {
			document.location.href='<?=$_SERVER['PHP_SELF']?>';		
		}else {
			document.location.href='ds_list_sim.php?section=7&grp_id=<?=$_REQUEST['grp_id']?>';
		}
	}
	
	function jump(v) {
		document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id='+v;
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
              <font style="size:15px">by <a href="http://ndwc.opencare.org/" target="_blank" style="color:white">National Disaster Warning Center (NDWC)</a>
 and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University">Chulalongkorn University</a></font></td>
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
      <DIV class=submenu_item id=c14> <A <?=$section[6]?> id=cs_14 href="file-browser.php?section=6" title="Go to data source manage page">File Browser </A> </DIV>
      <!-- Simulation Input -->
      <DIV class=submenu_item id=c14><A <?=$section[7]?> id=cs_14 href="ds_list_sim.php?section=7" title="Go to data source manage page">Input Data</A></DIV>
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
          <td><div align="center" class="style2"><a href="http://www.thaigrid.or.th" target="_blank" style="color:white">Thai National Grid Center</a></div></td>
        </tr>
      </table>
    </center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->List of  input data<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <script type="text/javascript" src="wz_tooltip/wz_tooltip.js"></script>
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operations :</strong>&nbsp;<font color="#000099"> Select group </font>&nbsp;<select name="grp" id="grp" onChange="jump(this.value)" style="font-size:13px; text-align:left">
            <?php
            
			require_once('../../library/connectdb.inc.php');
		  
		  
		  $sql = "SELECT * FROM `observe_group`";
		  $rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		  if( mysql_num_rows($rg) > 0 ) {
		  	while($obj = mysql_fetch_object($rg)) {
		  ?>
            <option value="<?=$obj->id?>" style="font-size:13px; text-align:left" <?=$selected_group[$obj->id]?>>&nbsp;-
            <?=$obj->g_name?>&nbsp;<?=$obj->default == "yes" ? "(default)" : ""?>
            </option>
            <?php
		  	}
          }else {
		  ?>
            <option value="0">! ERROR, no define group</option>
            <?php
          }
		  ?>
          </select>&nbsp;<img src="../../image/buttonorange.gif" width="7" height="10">&nbsp;<font color="#000099">Select type</font>&nbsp;<select name="input_type" id="input_type" onChange="javascript: ds_select_input_type(this.value);"  style="font-size:13px; text-align:left">
            <option value="sim"  style="font-size:13px; text-align:left">&nbsp;&nbsp;Simulation&nbsp;&nbsp;</option>
            <option value="vis"  style="font-size:13px; text-align:left" selected>&nbsp;&nbsp;Visualization&nbsp;&nbsp;</option>
          </select>&nbsp;|&nbsp;<a href="javascript: void(0)" onclick = "document.getElementById('LBOX').src='importer.php?grp_id=<?=$_REQUEST['grp_id']?>';document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><font color="#000099">Add new input data</font></a>&nbsp;|&nbsp;<a href="javascript: void(0)" onClick="document.getElementById('LBOX').src='resource_browser.php?type=sim&data=region&grp_id=<?=$_REQUEST['grp_id']?>';document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Resource Browser</a>&nbsp;|&nbsp;<a href="javascript: void(0)" onClick="javascript: document.location.reload();"><font color="#000099">Reload</font></a> </div>
        <?php
		if(count($row_dx_region['DX_ID']) != 0) {
		?>
        <br>
        <fieldset id="reg"style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:; display:;">
        <legend class="style37"><strong>Bathymetry and topography files (<font color="#990000"><b>
        <?=$dx_region_total_r?>
        </b></font>) </strong></legend>
        <table border="0" cellpadding="3" cellspacing="0" class=" tbl_border">
          <tr align="center" bgcolor="#FFFFCC" class="" >
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">!</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">ID</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Filename</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Region&nbsp;No.</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">No.&nbsp;of&nbsp;grids</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Create&nbsp;Date&nbsp;</font></td>
            <td bgcolor="#7B869A" class=""><font color="#FFFFFF">Action</font></td>
          </tr>
          <?php
		  /*
		  	$field_list = array('id', 'describe', 'name', 'region_no', 'long', 'lat', 
							'grid_size_x', 'grid_size_y', 't_interval', 'grid_no', 'max_depth', 'path',  'datetime');
		  */
		  for($i=0; $i<count($row_dx_region['DX_ID']); $i++) {
			if($i%2) {
		  ?>
          <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()" id="id_<?=$row_dx_region['DX_ID'][$i]?>">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_dx_region['DX_ID'][$i]?>]" id="chk[<?=$row_dx_region['DX_ID'][$i]?>]" onSelect="javascript: id_<?=$row_dx_region['DX_ID'][$i]?>.style.background='#D0EFFB';"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_dx_region['DX_ID'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="download_file.php?download_filepath=<?=$row_dx_region['DX_PATH'][$i]?>">
                <?=$row_dx_region['DX_FILENAME'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=$row_dx_region['DX_REGION_NO'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                        <?=$row_dx_region['DX_NO_OF_GRIDS_X'][$i]?>
                      </div></td>
                    <td><div align="center">&nbsp;x&nbsp;</div></td>
                    <td><div align="left">
                        <?=$row_dx_region['DX_NO_OF_GRIDS_Y'][$i]?>
                      </div></td>
                  </tr>
                </table>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center"> <font color="#006600">
                <?=date("H:s:i d/m/Y", $row_dx_region['DX_CREATE_DATE'][$i])?>
                </font> </div></td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_dx_region['DX_PATH'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="download_file.php?download_filepath=<?=$row_dx_region['DS_PATH'][$i]?>">original&nbsp;data</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_dx_region['DX_FILENAME'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del_dx_region&id=<?=$row_dx_region['DS_ID'][$i]?>&dx_filepath=<?=$row_dx_region['DX_PATH'][$i]?>&ds_filepath=<?=$row_dx_region['DS_PATH']?>&grp_id=<?=$row_dx_region['DX_GRP_ID'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
		  	}else {
			?>
          <tr align="center" bgcolor="#EBEBEB"onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_dx_region['DX_ID'][$i]?>]" id="chk[<?=$row_dx_region['DX_ID'][$i]?>]"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_dx_region['DX_ID'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="download_file.php?download_filepath=<?=$row_dx_region['DX_PATH'][$i]?>">
                <?=$row_dx_region['DX_FILENAME'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=$row_dx_region['DX_REGION_NO'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                        <?=$row_dx_region['DX_NO_OF_GRIDS_X'][$i]?>
                      </div></td>
                    <td><div align="center">&nbsp;x&nbsp;</div></td>
                    <td><div align="left">
                        <?=$row_dx_region['DX_NO_OF_GRIDS_Y'][$i]?>
                      </div></td>
                  </tr>
                </table>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center"> <font color="#006600">
                <?=date("H:s:i d/m/Y", $row_dx_region['DX_CREATE_DATE'][$i])?>
                </font> </div></td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_dx_region['DX_PATH'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="download_file.php?download_filepath=<?=$row_dx_region['DS_PATH'][$i]?>">original&nbsp;data</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_dx_region['DX_FILENAME'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del_dx_region&id=<?=$row_dx_region['DS_ID'][$i]?>&dx_filepath=<?=$row_dx_region['DX_PATH'][$i]?>&ds_filepath=<?=$row_dx_region['DS_PATH'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
			}
		  }
		  if(count($row_dx_region['DX_ID']) == 0) {
		  	?>
          <tr align="center">
            <td colspan="30" bgcolor="#EBEBEB" class="tbl_border_top tbl_border_right">(no data)</td>
          </tr>
          <?php
		  }
		  ?>
        </table>
        <?php
		if(count($row_dx_region['DX_ID']) != 0) {
		?>
        <br>
        <div align="left">
          <input type="button" value="&lt;&lt;" onClick="javascript: <?=$str_back_end_r?>">
          &nbsp;
          <input type="button" value="&lt;" onClick="javascript: <?=$str_back_r?>">
          &nbsp;Page number :
          <select name="select" id="select">
            <?php
          for($p=1; $p<=$no_page_r; $p++){
		  ?>
            <option value="<?=$p?>" onClick="javascript: <?=$str_jump_page_r[$p]?>" <?=$selected_page_r[$p-1]?>>
            <?=$p?>
            </option>
            <?php
		   }
		   ?>
          </select>
          &nbsp;
          <input type="button" value="&gt;" onClick="javascript: <?=$str_next_r?>">
          &nbsp;
          <input type="button" value="&gt;&gt;" onClick="javascript: <?=$str_next_end_r?>">
          &nbsp;
          <!--<input type="button" value="Get summary" onClick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/">-->
          Total<font color="#990000">&nbsp;<b>
          <?=$dx_region_total_r?>
          </b></font>&nbsp;regions. </div>
        <?php
		}
		?>
        </fieldset>
        <br>
        <?php
		}
		?>
        <?php

		if(count($row_dx_water_level['DX_ID']) != 0) {
		?>
        <fieldset id="wl"style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:; display:;">
        <legend class="style37"><strong>Water level files (<font color="#990000"><b>
        <?=$total_dx?>
        </b></font>)</strong> [<a href="<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&filter=ETA#wl">ETA</a> | <a href="<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&filter=ZMAX#wl">ZMAX</a>]</legend>
        <table border="0" cellpadding="3" cellspacing="0" class=" tbl_border fs14px">
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">!</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">ID</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Filename</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Region&nbsp;No.</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">No.&nbsp;of&nbsp;grids</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Type&nbsp;</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Create&nbsp;Date&nbsp;</font></td>
            <td bgcolor="#7B869A" class=""><font color="#FFFFFF">Action</font></td>
          </tr>
          <?php
		  /*
		  	"DS_ID", "DS_PATH", "DX_ID", "DX_FILENAME", "DX_PATH", "DX_SERIES", "DX_TIMESTEP", "DX_NOGRIDS_X", "DX_NOGRIDS_Y", "DX_DATA_ORDER", "DX_TYPE", "DX_REGION_NO", "DX_CREATEDATE"
		  */
		  for($i=0; $i<count($row_dx_water_level['DX_ID']); $i++) {
		  	/*$str = (strlen($row_water_level['describe'][$i]) > 0) ? $row_water_level['describe'][$i] : "(description is not specified)";
			$str = "<u>Description</u><br>&nbsp;&nbsp;".$str."<br><br>";
			$str .= "<u>Bathymetry and topography information</u><br>";
			$str .= "Region No. = ".$row_water_level['region_no'][$i]."<br>";
			$str .= "Interval = ".$row_water_level['interval'][$i]."<br>";
			$str .= "Number of grids [x, y] = [".$row_water_level['no_of_grids_x'][$i].", ".$row_water_level['no_of_grids_y'][$i]."]<br>";
			$str .= "Maximum of Depth = ".$row_water_level['depth'][$i]."<br>";
			$str .= "Location (latitude) :<br>";
			$str .= "&nbsp;&nbsp;-From = ".$row_water_level['lat_from_degree'][$i]."° ".$row_water_level['lat_from_lipda'][$i]."\' ".$row_water_level['lat_from_Philipda'][$i]."\'\'<br>";
			$str .= "&nbsp;&nbsp;-To = ".$row_water_level['lat_to_degree'][$i]."° ".$row_water_level['lat_to_lipda'][$i]."\' ".$row_water_level['lat_to_Philipda'][$i]."\'\'<br>";	
			$str .= "Location (longitude) :<br>";
			$str .= "&nbsp;&nbsp;-From = ".$row_water_level['long_from_degree'][$i]."° ".$row_water_level['long_from_lipda'][$i]."\' ".$row_water_level['long_from_Philipda'][$i]."\'\'<br>";
			$str .= "&nbsp;&nbsp;-To = ".$row_water_level['long_to_degree'][$i]."° ".$row_water_level['long_to_lipda'][$i]."\' ".$row_water_level['long_to_Philipda'][$i]."\'\'<br>";														
			$str .= "Resolution = ".$row_water_level['res_lipda'][$i]."\' ".$row_water_level['res_Philipda'][$i]."\'\'<br>";  	
			*/
			if($i%2) {
		  ?>
          <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()" id="id_<?=$row_dx_water_level['DX_ID'][$i]?>">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_dx_water_level['DX_ID'][$i]?>]" id="chk[<?=$row_dx_water_level['DX_ID'][$i]?>]" onSelect="javascript: id_<?=$row_dx_water_level['DX_ID'][$i]?>.style.background='#D0EFFB';"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_dx_water_level['DX_ID'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="download_file.php?download_filepath=<?=$row_dx_water_level['DX_PATH'][$i]?>">
                <?=$row_dx_water_level['DX_FILENAME'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=$row_dx_water_level['DX_REGION_NO'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                        <?=$row_dx_water_level['DX_NOGRIDS_X'][$i]?>
                      </div></td>
                    <td><div align="center">&nbsp;x&nbsp;</div></td>
                    <td><div align="left">
                        <?=$row_dx_water_level['DX_NOGRIDS_Y'][$i]?>
                      </div></td>
                  </tr>
                </table>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center"> <font color="#006600">
                <?=$row_dx_water_level['DX_TYPE'][$i]?>
                </font> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center"> <font color="#006600">
                <?=date("H:s:i d/m/Y", $row_dx_water_level['DX_CREATEDATE'][$i])?>
                </font> </div></td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_dx_water_level['DX_PATH'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="download_file.php?download_filepath=<?=$row_dx_water_level['DS_PATH'][$i]?>';">original&nbsp;data</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_dx_water_level['DX_FILENAME'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del_water_level&id=<?=$row_dx_water_level['DS_ID'][$i]?>&dx_filepath=<?=$row_dx_water_level['DX_PATH'][$i]?>&ds_filepath=<?=$row_dx_water_level['DS_PATH'][$i]?>&filter=<?=$_REQUEST['filter']?>&grp_id=<?=$_REQUEST['grp_id']?>'; }">delete</a></td>
          </tr>
          <?php
		  	}else {
			?>
          <tr align="center" bgcolor="#EBEBEB"onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()" id="id_<?=$row_dx_water_level['DX_ID'][$i]?>">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_dx_water_level['DX_ID'][$i]?>]" id="chk[<?=$row_dx_water_level['DX_ID'][$i]?>]"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_dx_water_level['DX_ID'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="download_file.php?download_filepath=<?=$row_dx_water_level['DX_PATH'][$i]?>">
                <?=$row_dx_water_level['DX_FILENAME'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=$row_dx_water_level['DX_REGION_NO'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                        <?=$row_dx_water_level['DX_NOGRIDS_X'][$i]?>
                      </div></td>
                    <td><div align="center">&nbsp;x&nbsp;</div></td>
                    <td><div align="left">
                        <?=$row_dx_water_level['DX_NOGRIDS_Y'][$i]?>
                      </div></td>
                  </tr>
                </table>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center"> <font color="#006600">
                <?=$row_dx_water_level['DX_TYPE'][$i]?>
                </font> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center"> <font color="#006600">
                <?=date("H:s:i d/m/Y", $row_dx_water_level['DX_CREATEDATE'][$i])?>
                </font> </div></td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_dx_water_level['DX_PATH'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="download_file.php?download_filepath=<?=$row_dx_water_level['DS_PATH'][$i]?>';">original&nbsp;data</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_dx_water_level['DX_FILENAME'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del_water_level&id=<?=$row_dx_water_level['DS_ID'][$i]?>&dx_filepath=<?=$row_dx_water_level['DX_PATH'][$i]?>&ds_filepath=<?=$row_dx_water_level['DX_DSPATH'][$i]?>&filter=<?=$_REQUEST['filter']?>&grp_id=<?=$_REQUEST['grp_id']?>'; }">delete</a></td>
          </tr>
          <?php
			}
		  }
		  if(count($row_dx_water_level['DX_ID']) == 0) {
		  	?>
          <tr align="center">
            <td colspan="31" bgcolor="#EBEBEB" class="tbl_border_top tbl_border_right">(no data)</td>
          </tr>
          <?php
		  }
		  ?>
        </table>
        <?php
		if(count($row_dx_water_level['DX_ID']) != 0) {
		?>
        <br>
        <div align="left">
          <input type="button" value="&lt;&lt;" onClick="javascript: <?=$str_back_end_dx?>">
          &nbsp;
          <input type="button" value="&lt;" onClick="javascript: <?=$str_back_dx?>">
          &nbsp;Page number :
          <select name="select" id="select">
            <?php
          for($p=1; $p<=$no_page_dx; $p++){
		  ?>
            <option value="<?=$p?>" onClick="javascript: <?=$str_jump_page_dx[$p]?>" <?=$selected_page_dx[$p-1]?>>
            <?=$p?>
            </option>
            <?php
		   }
		   ?>
          </select>
          &nbsp;
          <input type="button" value="&gt;" onClick="javascript: <?=$str_next_dx?>">
          &nbsp;
          <input type="button" value="&gt;&gt;" onClick="javascript: <?=$str_next_end_dx?>">
          &nbsp;
          <!--<input type="button" value="Get summary" onClick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/">-->
          Total<font color="#990000">&nbsp;<b>
          <?=$total_dx?>
          </b></font>&nbsp;files. </div>
        <?php
		}
		?>
        </fieldset>
        <br>
        <?php
		}
		?>
        <?php
        if($dx_region_total_r > 0 || $total_dx_waterlevel > 0) {
		?>
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-bottom:#999999 1px solid;"><a href="javascript: void(0)" onclick = "document.getElementById('LBOX').src='importer.php?grp_id=<?=$_REQUEST['grp_id']?>';document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><font color="#000099">Add new input data</font></a> | <a href="javascript: void(0)" onClick="javascript: document.location.reload();"><font color="#000099">Reload</font></a></div>
        <?php
        }
		?>
        <div id="light" class="white_content">
          <iframe src="" style="border-width:0px;" width="100%" height="100%" id="LBOX">Something wrong !</iframe>
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
<DIV id=footer><a href="../../team.html" target="_blank" style="color:white">Developer Team</a>
</DIV>
</BODY>
<!-- InstanceEnd --></HTML>
