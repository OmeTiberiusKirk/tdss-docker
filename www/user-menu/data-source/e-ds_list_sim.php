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
		$_REQUEST['grp_id'] = $g_default_id;	}
	
	if($_REQUEST['act'] == "get_summary") {
		$sql = "SELECT * FROM `ds_input_deform` WHERE `grp_id` = ".$_REQUEST['grp_id'];
		$res = mysql_query($sql, $connection);
		$file_contents = "Fault_No.\tFilenamemax.\tlength_fault\twidth_fault\tepi_depth\tdislocate\tdip_angle\tstrike_angle\trake_angle\tlong_epi\t	lat_epi\tmax_upward\tmax_long\tmax_lat\tmin_downward\tmin_long\tmin_lat\n";
		while($obj = mysql_fetch_object($res)) {
			//$t = array($obj->id, $obj->filename, $obj->glob_x_long, $obj->glob_y_lat, $obj->grid_space, $obj->org_x, $obj->org_y, $obj->coord_long_1, $obj->coord_long_2, $obj->coord_lat_1, $obj->coord_lat_2, $obj->length, $obj->length_fault, $obj->width_fault, $obj->epi_depth, $obj->dislocate, $obj->dip_angle, $obj->strike_angle, $obj->rake_angle, $obj->long_epi, $obj->lat_epi, $obj->max_val, $obj->max_lat, $obj->max_long, $obj->min_val, $obj->min_lat, $obj->min_long);
			$t = array($obj->id, $obj->filename, $obj->length_fault, $obj->width_fault, $obj->epi_depth, $obj->dislocate, $obj->dip_angle, $obj->strike_angle, $obj->rake_angle, $obj->long_epi, $obj->lat_epi, round($obj->max_val, 3), round($obj->max_long, 7), round($obj->max_lat, 7), round($obj->min_val, 3), round($obj->min_long, 7), round($obj->min_lat, 7));
			$file_contents .= implode("\t", $t)."\n";
		}
		$filename = "tmp_".time().".dat";
		$fp = fopen($filename, "w");
		fwrite($fp, $file_contents);
		fclose($fp);
		echo "<script language=javascript>document.location.href='download_file.php?download_filepath=".base64_encode($filename)."';history.back();</script>";
		//unlink($filename);
	}
	
	/******************* DEFORMATION ************************/
	/* Delete deformation file */
	if($_REQUEST['CMD'] == "del_deform" && $_REQUEST['param'] > 0) {
		$sql = "DELETE FROM `ds_input_deform` WHERE `id` = ".$_REQUEST['param']." AND `grp_id` = ".$_REQUEST['grp_id'];
		unlink(base64_decode($_REQUEST['filepath']));
		if(mysql_query($sql, $connection)) {
			echo "<script language=javascript>document.location.href='ds_list_sim.php?section=7&grp_id=".$_REQUEST['grp_id']."#def';</script>";
		}else
			echo "<script language=javascript>alert('Could not delete id ".$_REQUEST['param']." ?');</script>";
	}
	
	
	/* get total deformation file */
	$limit = 10;
	if(!isset($_REQUEST['total'])) {
		$sql = "SELECT * FROM `ds_input_deform` WHEE `grp_id` = ".$_REQUEST['grp_id'];
		$result = mysql_query($sql, $connection);
		$total = @mysql_num_rows($result);
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
	
	$str_next = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn=next&start=".($start+$limit)."&limit=".$limit."&curr_page=".($curr_page+1)."&total=".$total."#def';";
	$selected_page[$_REQUEST['curr_page']-1] = " selected";
	
	for($i=0; $i<$no_page; $i++) {
		$str_jump_page[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn=next&start=".($i * $limit)."&limit=".$limit."&curr_page=".($i+1)."#def';";
	}
	
	if( ($start-$limit) < 0) {
		$start = 0;
		$curr_page = 1;
		$str_back = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn=back&start=".$start."&limit=".$limit."&curr_page=".$curr_page."&total=".$total."#def';";
	}else {
		$str_back = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn=back&start=".($start-$limit)."&limit=".$limit."&curr_page=".($curr_page-1)."&total=".$total."#def';";
	}
	
	$str_back_end = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn=back_end&start=0&limit=10&curr_page=1&total=".$total."#def'";
	$str_next_end = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn=next_end&start=".($limit * ($no_page-1))."&limit=10&curr_page=".$no_page."&total=".$total."#def'";

	$sql = "SELECT * FROM `ds_input_deform` WHERE `grp_id` = ".$_REQUEST['grp_id']." LIMIT ".$start.", ".$limit;
	$result = mysql_query($sql, $connection);
	if($result) {
		if(mysql_num_rows($result) > 0) {
			$i = 0;
			$field_list = array("id", "filename", "description", "path", "glob_x_long", 
							"glob_y_lat", "grid_space", "org_x", "org_y", "coord_long_1", "coord_long_2", 
							"coord_lat_1", "coord_lat_2", "length", "length_fault", "width_fault", "epi_depth", 
							"dislocate", "dip_angle", "strike_angle", "rake_angle", "long_epi", 
							"lat_epi", "max_epi", "min_downward", "max_upward", "max_lat", "max_long", "min_lat", "min_long", "create_date");
			while($obj = mysql_fetch_object($result)) {
				foreach($field_list as $index => $field_name) {
					$row_deform[$field_name][$i] = $obj->$field_name;
				}
				$i++;
			}
		}
	}
	/********* END **************/
	
	/********************* REGION ***************/
	/* delete region file */
	if($_REQUEST['CMD'] == "del_region" && $_REQUEST['param'] > 0) {
		$sql = "DELETE FROM `ds_input_region`, `ds_dx_region` USING `ds_input_region`, `ds_dx_region` ";
		$sql .= "WHERE `ds_input_region`.`id` = `ds_dx_region`.`reg_id` AND `ds_input_region`.`id` = ".$_REQUEST['param']." AND `ds_input_region`.`grp_id` = ".$_REQUEST['grp_id'];
		@unlink(base64_decode($_REQUEST['filepath']));
		@unlink(base64_decode($_REQUEST['dx_path']));
		if(mysql_query($sql, $connection)) {
			echo "<script language=javascript>document.location.href='ds_list_sim.php?section=7&grp_id=".$_REQUEST['grp_id']."#reg';</script>";
		}else
			echo "<script language=javascript>alert('Could not delete id ".$_REQUEST['param']." ?');</script>";
	}
	
	$limit_r = 10;
	if(!isset($_REQUEST['total_r'])) {
		$sql_r = "SELECT * FROM `ds_input_region`, `ds_dx_region` WHERE `ds_input_region`.`id` = `ds_dx_region`.`reg_id` AND `ds_input_region`.`grp_id` = ".$_REQUEST['grp_id'];
		$result_r = mysql_query($sql_r, $connection);
		$total_r = mysql_num_rows($result_r);
	}else $total_r = $_REQUEST['total_r'];
	$no_page_r = ceil($total_r/$limit_r);
	
	/* check Has `button` was clicked */
	if(!isset($_REQUEST['btn_r'])) {
		$start_r = 0;
		$limit_r = 10;
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
	
	$str_next_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=next&start_r=".($start_r+$limit_r)."&limit_r=".$limit_r."&curr_page_r=".($curr_page_r+1)."&total_r=".$total_r."#reg';";
	$selected_page_r[$_REQUEST['curr_page_r']-1] = " selected";
	
	for($i=0; $i<$no_page_r; $i++) {
		$str_jump_page_r[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=next&start_r=".($i * $limit_r)."&limit_r=".$limit_r."&curr_page_r=".($i+1)."#reg';";
	}
	
	if( ($start_r-$limit_r) < 0) {
		$start_r = 0;
		$curr_page_r = 1;
		$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=back&start_r=".$start_r."&limit_r=".$limit_r."&curr_page_r=".$curr_page_r."&total_r=".$total_r."#reg';";
	}else {
		$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=back&start_r=".($start_r-$limit_r)."&limit_r=".$limit_r."&curr_page_r=".($curr_page_r-1)."&total_r=".$total_r."#reg';";
	}
	
	$str_back_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=back_end&start_r=0&limit_r=10&curr_page_r=1&total_r=".$total_r."'";
	$str_next_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=7&grp_id=".$_REQUEST['grp_id']."&btn_r=next_end&start_r=".($limit_r * ($no_page_r-1))."&limit_r=10&curr_page_r=".$no_page_r."&total_r=".$total_r."#reg'";
	
	$tbl1 = "ds_input_region";
	$tbl2 = "ds_dx_region";
	$f1 = array(
				"id", "describe", "name", "region_no", "lat_from_degree", "lat_from_lipda", "lat_from_Philipda", 
				"lat_to_degree", "lat_to_lipda", "lat_to_Philipda", "long_from_degree", "long_from_lipda", 
				"long_from_Philipda", "long_to_degree", "long_to_lipda", "long_to_Philipda", "interval", 
				"no_of_grids_x", "no_of_grids_y", "depth", "res_lipda", "res_Philipda", 
				"input_type", "path", "grp_id", "default", "datetime");
	$f2 = array("id", "path");
	foreach($f1 as $field1) {
		$s1[] = "`".$tbl1."`.`".$field1."` AS `R_".strtoupper($field1)."`";
		$select_f[] = "R_".strtoupper($field1);
	}
	
	foreach($f2 as $field2) {
		$s1[] = "`".$tbl2."`.`".$field2."` AS `DX_".strtoupper($field2)."`";
		$select_f[] = "DX_".strtoupper($field2);
	}
	
	$sql_r = "SELECT ".implode(", ", $s1)." FROM `ds_input_region`, `ds_dx_region` WHERE `ds_input_region`.`id` = `ds_dx_region`.`reg_id` AND `ds_input_region`.`input_type` = 'sim' AND `ds_input_region`.`grp_id` = ".$_REQUEST['grp_id']." LIMIT ".$start_r.", ".$limit_r;
	$result_sim_r = mysql_query($sql_r, $connection);
	if($result_sim_r) {
		if(mysql_num_rows($result_sim_r) > 0) {
			$i = 0;
			#$field_list = array('id', 'describe', 'name', 'region_no', 'lat_from_degree', 'lat_from_lipda', 'lat_from_Philipda', 'lat_to_degree' , 'lat_to_lipda', 'lat_to_Philipda', 'long_from_degree', 'long_from_lipda', 'long_from_Philipda', 'long_to_degree', 'long_to_lipda', 'long_to_Philipda', 'interval', 'no_of_grids_x', 'no_of_grids_y', 'depth', 'res_lipda', 'res_Philipda', 'input_type', 'path', 'default', 'datetime');
			$field_list = $select_f;
			while($obj_region = mysql_fetch_object($result_sim_r)) {
				foreach($field_list as $index => $field_name) {
					$row_region[$field_name][$i] = $obj_region->$field_name;
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
	right: 4%;*/
	width: 92%;
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
			document.location.href='ds_list_vis.php?section=7&grp_id=<?=$_REQUEST['grp_id']?>';
		}else {
			document.location.href='<?=$_SERVER['PHP_SELF']?>';
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
    <br><center><table><tr><td><div align="center">&nbsp;<img src="../../logo.jpg" width="100" height="111" style="border:3px" usemap="#Map"></div></td>
    </tr><tr><td><div align="center" class="style2">&nbsp;Thai National Grid Center</div></td>
    </tr></table></center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->List of  input data<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <script type="text/javascript" src="wz_tooltip/wz_tooltip.js"></script>
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operations :</strong>&nbsp;<font color="#000099"> Select group </font>&nbsp;<select name="grp" id="grp" onChange="jump(this.value)" style="font-size:13px; text-align:left">
          <?php
          require_once('../../library/connectdb.inc.php');
		  
			$selected_group[$g_default_id] = " selected";		  
		  $sql = "SELECT * FROM `observe_group`";
		  $rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		  if( mysql_num_rows($rg) > 0 ) {
		  	while($obj = mysql_fetch_object($rg)) {
		  ?>
            <option value="<?=$obj->id?>" style="font-size:13px; text-align:left" <?=$selected_group[$obj->id]?>>&nbsp;- <?=$obj->g_name?>&nbsp;<?=$obj->default == "yes" ? "(default)" : ""?></option>
          <?php
		  	}
          }else {
		  ?>
          <option value="0">! ERROR, no define group</option>
          <?php
          }
		  ?>
          </select>&nbsp;<img src="../../image/buttonorange.gif" width="7" height="10">&nbsp;<font color="#000099">Select type</font>&nbsp;<select name="input_type" id="input_type" onChange="javascript: ds_select_input_type(this.value);"  style="font-size:13px; text-align:left">
            <option value="sim"  style="font-size:13px; text-align:left" selected>&nbsp;&nbsp;Simulation&nbsp;&nbsp;</option>
            <option value="vis"  style="font-size:13px; text-align:left">&nbsp;&nbsp;Visualization&nbsp;&nbsp;</option>
          </select>&nbsp;&nbsp;|&nbsp;<a href="javascript: void(0)" onclick = "document.getElementById('LBOX').src='importer.php?grp_id=<?=$_REQUEST['grp_id']?>';document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"><font color="#000099">Add new input data</font></a>&nbsp;|&nbsp;<a href="javascript: void(0)" onClick="document.getElementById('LBOX').src='resource_browser.php?type=sim&data=region';document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Resource Browser</a>&nbsp;|&nbsp;<a href="javascript: void(0)" onClick="javascript: document.location.reload();"><font color="#000099">Reload</font></a> </div>
        <?php
		if(count($row_deform['id']) != 0) {
		?>
        <!--<fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
        <legend class="style37"><strong>Deformation file (<font color="#990000"><b>
        <?=$total?>
        </b></font>)</strong></legend>
        <table border="0" cellpadding="3" cellspacing="0" class=" tbl_border fs14px">
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">!</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">ID</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Filename</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Max.&nbsp;Upward</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Max.&nbsp;Lat</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Max.&nbsp;Long</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Min.&nbsp;Downward</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Min.&nbsp;Lat</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Min.&nbsp;Long</font></td>
            <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Create&nbsp;Date</font></td>
            <td bgcolor="#7B869A" class=""><font color="#FFFFFF">Action</font></td>
          </tr>
          <?php
		  
		  for($i=0; $i<count($row_deform['id']); $i++) {
		  	$str = (strlen($row_deform['description'][$i]) > 0) ? $row_deform['description'][$i] : "(description is not specified)";
			$str = "<u>Description</u><br>&nbsp;&nbsp;".$str."<br><br>";
			$str .= "<u>Configuration</u><br>";
			$str .= "Global no. of grid in x direction (longitude) = ".$row_deform['glob_x_long'][$i]."<br>";
			$str .= "Global no. of grid in y direction (latitude) = ".$row_deform['glob_y_lat'][$i]."<br>";
			$str .= "Grid spacing (min) = ".$row_deform['grid_space'][$i]."<br>";
			$str .= "Orgin of x, y direction = [".$row_deform['org_x'][$i].", ".$row_deform['org_y'][$i]."]<br>";
			$str .= "Coordinate of cropped area :<br>";
			$str .= "&nbsp;&nbsp;[longitude1, longitude2] = [".$row_deform['coord_long_1'][$i].", ".$row_deform['coord_long_2'][$i]."]<br>";
			$str .= "&nbsp;&nbsp;[latitude1, latitude2] = [".$row_deform['coord_lat_1'][$i].", ".$row_deform['coord_long_1'][$i]."]<br><br>";
			$str .= "<u>Fault Parameters</u><br>";
			$str .= "Length (min) = ".$row_deform['length'][$i]."<br>";
			$str .= "Length fault (m) = ".$row_deform['length_fault'][$i]."<br>";
			$str .= "Width fault (m) = ".$row_deform['width_fault'][$i]."<br>";
			$str .= "Epicenter depth (m) = ".$row_deform['epi_depth'][$i]."<br>";
			$str .= "Dislocation (m) = ".$row_deform['dislocate'][$i]."<br>";
			$str .= "Dip angle (degree) = ".$row_deform['dip_angle'][$i]."<br>";
			$str .= "Strike angle (degree) = ".$row_deform['strike_angle'][$i]."<br>";
			$str .= "Rake angle (degree) = ".$row_deform['rake_angle'][$i]."<br>";
			$str .= "Longitude epicenter (degree, +E) = ".$row_deform['long_epi'][$i]."<br>";
			$str .= "Latitude epicenter (degree, +N, -S) = ".$row_deform['lat_epi'][$i]."<br><br>";
			$str .= "<u>Summary</u><br>";
			$str .= "Max. Upward = ".$row_deform['max_upward'][$i]."<br>";
			$str .= "Max. Latitude = ".$row_deform['max_lat'][$i]."<br>";
			$str .= "Max. Longitude = ".$row_deform['max_long'][$i]."<br>";
			$str .= "Min. Downward = ".$row_deform['min_downward'][$i]."<br>";
			$str .= "Min. Latitude = ".$row_deform['min_lat'][$i]."<br>";
			$str .= "Min. Longitude = ".$row_deform['min_long'][$i]."<br>";
		  	if($i%2) {
		  ?>
          <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC'; UnTip()" id="id_<?=$row_deform['id'][$i]?>">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_deform['id'][$i]?>]" id="chk[<?=$row_deform['id'][$i]?>]" onSelect="javascript: id_<?=$row_deform['id'][$i]?>.style.background='#D0EFFB';"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_deform['id'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="#docu" onMouseOver="Tip('<?=$str?>', WIDTH, 400, TITLE, '<b>Filename:</b> <?=$row_deform['filename'][$i]?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                <?=$row_deform['filename'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=!is_float($row_deform['max_upward'][$i]) ? $row_deform['max_upward'][$i] : round($row_deform['max_upward'][$i], 2)?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=!is_float($row_deform['max_lat'][$i]) ? $row_deform['max_lat'][$i] : round($row_deform['max_lat'][$i], 2)?>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=!is_float($row_deform['max_long'][$i]) ? $row_deform['max_long'][$i] : round($row_deform['max_long'][$i], 2)?>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=!is_float($row_deform['min_downward'][$i]) ? $row_deform['min_downward'][$i] : round($row_deform['min_downward'][$i], 2)?>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=!is_float($row_deform['min_lat'][$i]) ? $row_deform['min_lat'][$i] : round($row_deform['min_lat'][$i], 2)?>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=!is_float($row_deform['min_long'][$i]) ? $row_deform['min_long'][$i] : round($row_deform['min_long'][$i], 2)?>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center"><font color="#006600">
              <?=date("H:s:i d/m/Y", $row_deform['create_date'][$i])?>
            </font></div></td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_deform['path'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_deform['filename'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del_deform&param=<?=$row_deform['id'][$i]?>&filepath=<?=$row_deform['path'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
		  	}else {
			?>
          <tr align="center" bgcolor="#EBEBEB" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#EBEBEB'; UnTip()">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_deform['id'][$i]?>]" id="chk[<?=$row_deform['id'][$i]?>]"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_deform['id'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="#docu" onMouseOver="Tip('<?=$str?>', WIDTH, 400, TITLE, '<b>Filename:</b> <?=$row_deform['filename'][$i]?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                <?=$row_deform['filename'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=!is_float($row_deform['max_upward'][$i]) ? $row_deform['max_upward'][$i] : round($row_deform['max_upward'][$i], 2)?>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=!is_float($row_deform['max_lat'][$i]) ? $row_deform['max_lat'][$i] : round($row_deform['max_lat'][$i], 2)?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=!is_float($row_deform['max_long'][$i]) ? $row_deform['max_long'][$i] : round($row_deform['max_long'][$i], 2)?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=!is_float($row_deform['min_downward'][$i]) ? $row_deform['min_downward'][$i] : round($row_deform['min_downward'][$i], 2)?>
              </div></td>
            <td bgcolor="#EBEBEB" class="tbl_border_top tbl_border_right"><div align="center">
                <?=!is_float($row_deform['min_lat'][$i]) ? $row_deform['min_lat'][$i] : round($row_deform['min_lat'][$i], 2)?>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <?=!is_float($row_deform['min_long'][$i]) ? $row_deform['min_long'][$i] : round($row_deform['min_long'][$i], 2)?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
               <font color="#006600"><?=date("H:s:i d/m/Y", $row_deform['create_date'][$i])?></font>
              </div></td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_deform['path'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_deform['filename'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del_deform&param=<?=$row_deform['id'][$i]?>&filepath=<?=$row_deform['path'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
			}
		  }
		  if(count($row_deform['id']) == 0) {
		  	?>
          <tr align="center">
            <td colspan="11" bgcolor="#EBEBEB" class="tbl_border_top tbl_border_right">(no data)</td>
          </tr>
          <?php
		  }
		  ?>
        </table>
        <?php
		if(count($row_deform['id']) != 0) {
		?>
        <br>
        <div align="left">
          <input type="button" value="&lt;&lt;" onClick="javascript: <?=$str_back_end?>">
          &nbsp;
          <input type="button" value="&lt;" onClick="javascript: <?=$str_back?>">
          &nbsp;Page number :
          <select name="select" id="select">
            <?php
          for($p=1; $p<=$no_page; $p++){
		  ?>
            <option value="<?=$p?>" onClick="javascript: <?=$str_jump_page[$p]?>" <?=$selected_page[$p-1]?>>
            <?=$p?>
            </option>
            <?php
		   }
		   ?>
          </select>
          &nbsp;
          <input type="button" value="&gt;" onClick="javascript: <?=$str_next?>">
          &nbsp;
          <input type="button" value="&gt;&gt;" onClick="javascript: <?=$str_next_end?>">
          &nbsp;
          <input type="button" value="Get summary" onClick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/">
          Total<font color="#990000">&nbsp;<b>
          <?=$total?>
          </b></font>&nbsp;subfaults. </div>
        <?php
		 }
		 ?>
        </fieldset> -->
        <?php
		}
		?>
        <?php
		if(count($row_region['R_ID']) != 0) {
		?>
        <br>
        <fieldset id="reg"style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:; display:;">
        <legend class="style37"><strong>Bathymetry and topography file (<font color="#990000"><b>
        <?=$total_r?>
        </b></font>)</strong></legend>
        <table border="0" cellpadding="3" cellspacing="0" class=" tbl_border fs14px">
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td rowspan="3" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">!</font></td>
            <td rowspan="3" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">ID</font></td>
            <td rowspan="3" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Filename</font></td>
            <td colspan="2" rowspan="3" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">No.&nbsp;of&nbsp;grids</font></td>
            <td colspan="24" bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF">Location</font></td>
            <td rowspan="3" bgcolor="#7B869A" class=""><font color="#FFFFFF">Action</font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td colspan="12" bgcolor="#7B869A" class="tbl_border_right tbl_border_top"><font color="#FFFFFF">Latitude</font></td>
            <td colspan="12" bgcolor="#7B869A" class="tbl_border_right tbl_border_top"><font color="#FFFFFF">Longitude</font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td colspan="6" bgcolor="#7B869A" class="tbl_border_right tbl_border_top"><font color="#FFFFFF">From</font></td>
            <td colspan="6" bgcolor="#7B869A" class="tbl_border_right tbl_border_top"><font color="#FFFFFF">To</font></td>
            <td colspan="6" bgcolor="#7B869A" class="tbl_border_right tbl_border_top"><font color="#FFFFFF">From</font></td>
            <td colspan="6" bgcolor="#7B869A" class="tbl_border_right tbl_border_top"><font color="#FFFFFF">To</font></td>
          </tr>
          <?php
		  /*
		  	$field_list = array('id', 'describe', 'name', 'region_no', 'long', 'lat', 
							'grid_size_x', 'grid_size_y', 't_interval', 'grid_no', 'max_depth', 'path',  'datetime');
		  */
		  for($i=0; $i<count($row_region['R_ID']); $i++) {
		  	$str = (strlen($row_region['R_DESCRIBE'][$i]) > 0) ? $row_region['R_DESCRIBE'][$i] : "(description is not specified)";
			$str = "<u>Description</u><br>&nbsp;&nbsp;".$str."<br><br>";
			$str .= "<u>Bathymetry and topography information</u><br>";
			$str .= "Region No. = ".$row_region['R_REGION_NO'][$i]."<br>";
			$str .= "Interval = ".$row_region['R_INTERVAL'][$i]."<br>";
			$str .= "Number of grids [x, y] = [".$row_region['R_NO_OF_GRIDS_X'][$i].", ".$row_region['R_NO_OF_GRIDS_Y'][$i]."]<br>";
			$str .= "Maximum of Depth = ".$row_region['R_DEPTH'][$i]."<br>";
			$str .= "Location (latitude) :<br>";
			$str .= "&nbsp;&nbsp;-From = ".$row_region['R_LAT_FROM_DEGREE'][$i]."° ".$row_region['R_LAT_FROM_LIPDA'][$i]."\' ".$row_region['R_LAT_FROM_PHILIPDA'][$i]."\'\'<br>";
			$str .= "&nbsp;&nbsp;-To = ".$row_region['R_LAT_TO_DEGREE'][$i]."° ".$row_region['R_LAT_TO_LIPDA'][$i]."\' ".$row_region['R_LAT_TO_PHILIPDA'][$i]."\'\'<br>";
			$str .= "Location (longitude) :<br>";
			$str .= "&nbsp;&nbsp;-From = ".$row_region['R_LONG_FROM_DEGREE'][$i]."° ".$row_region['R_LONG_FROM_LIPDA'][$i]."\' ".$row_region['R_LONG_FROM_PHILIPDA'][$i]."\'\'<br>";
			$str .= "&nbsp;&nbsp;-To = ".$row_region['R_LONG_TO_DEGREE'][$i]."° ".$row_region['R_LONG_TO_LIPDA'][$i]."\' ".$row_region['R_LONG_TO_PHILIPDA'][$i]."\'\'<br>";														
			$str .= "Resolution = ".$row_region['R_RES_LIPDA'][$i]."\' ".$row_region['R_RES_PHILIPDA'][$i]."\'\'<br>";  	
			$str .= "Create Date = ".date("H:s:i d/m/Y", $row_region['R_DATETIME'][$i])."";
			if($i%2) {
		  ?>
          <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()" id="id_<?=$row_region['R_ID'][$i]?>">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_region['R_ID'][$i]?>]" id="chk[<?=$row_region['R_ID'][$i]?>]" onSelect="javascript: id_<?=$row_region['R_ID'][$i]?>.style.background='#D0EFFB';"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_region['R_ID'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="download_file.php?download_filepath=<?=$row_region['R_PATH'][$i]?>" onMouseOver="Tip('<?=$str?>', WIDTH, 400, TITLE, '<b>Filename:</b> <?=$row_region['R_NAME'][$i]?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 0, CLICKCLOSE, true, FONTSIZE, '11px')" onMouseOut="UnTip()">
                <?=$row_region['R_NAME'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                      <?=$row_region['R_NO_OF_GRIDS_X'][$i]?>
                    </div></td>
                    <td><div align="center">&nbsp;x&nbsp;</div></td>
                    <td><div align="left">
                      <?=$row_region['R_NO_OF_GRIDS_Y'][$i]?>
                    </div></td>
                  </tr>
                </table>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=$row_region['R_REGION_NO'][$i]?>
            </div></td>
            <td class="tbl_border_top "><font color="#990000"><?=$row_region['R_LAT_FROM_DEGREE'][$i]?></font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_FROM_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_FROM_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_TO_DEGREE'][$i]?>
            </font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_TO_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_TO_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_FROM_DEGREE'][$i]?>
            </font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_FROM_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_FROM_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_TO_DEGREE'][$i]?>
            </font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_TO_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_TO_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_region['R_PATH'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_region['R_NAME'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&CMD=del_region&param=<?=$row_region['R_ID'][$i]?>&filepath=<?=$row_region['R_PATH'][$i]?>&dx_id=<?=$row_region['DX_ID'][$i]?>&dx_path=<?=$row_region['DX_PATH'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
		  	}else {
			?>
          <tr align="center" bgcolor="#EBEBEB"onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_region['R_ID'][$i]?>]" id="chk[<?=$row_region['R_ID'][$i]?>]"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_region['R_ID'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="download_file.php?download_filepath=<?=$row_region['R_PATH'][$i]?>" onMouseOver="Tip('<?=$str?>', WIDTH, 400, TITLE, '<b>Filename:</b> <?=$row_region['R_NAME'][$i]?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 0, CLICKCLOSE, true, FONTSIZE, '11px')" onMouseOut="UnTip()">
                <?=$row_region['R_NAME'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="right">
                        <?=$row_region['R_NO_OF_GRIDS_X'][$i]?>
                    </div></td>
                    <td><div align="center">&nbsp;x&nbsp;</div></td>
                    <td><div align="left">
                        <?=$row_region['R_NO_OF_GRIDS_Y'][$i]?>
                    </div></td>
                  </tr>
                </table>
            </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="center">
              <?=$row_region['R_REGION_NO'][$i]?>
            </div></td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_FROM_DEGREE'][$i]?>
            </font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_FROM_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_FROM_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_TO_DEGREE'][$i]?>
            </font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_TO_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LAT_TO_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_FROM_DEGREE'][$i]?>
            </font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_FROM_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_FROM_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_TO_DEGREE'][$i]?>
            </font></td>
            <td class="tbl_border_top ">°</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_TO_LIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top ">'</td>
            <td class="tbl_border_top "><font color="#990000">
              <?=$row_region['R_LONG_TO_PHILIPDA'][$i]?>
            </font></td>
            <td class="tbl_border_top tbl_border_right">''</td>
            <td class="tbl_border_top"><a href="download_file.php?download_filepath=<?=$row_region['R_PATH'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_region['R_NAME'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&CMD=del_region&param=<?=$row_region['R_ID'][$i]?>&filepath=<?=$row_region['R_PATH'][$i]?>&dx_id=<?=$row_region['DX_ID'][$i]?>&dx_path=<?=$row_region['DX_PATH'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
			}
		  }
		  if(count($row_region['R_ID']) == 0) {
		  	?>
          <tr align="center">
            <td colspan="30" bgcolor="#EBEBEB" class="tbl_border_top">(no data)</td>
          </tr>
          <?php
		  }
		  ?>
        </table>
        <?php
		if(count($row_region['R_ID']) != 0) {
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
          <?=$total_r?>
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
        if($total_r > 0) {
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
<DIV id=footer><SPAN>Partners:</SPAN><A href="http://www.cp.eng.chula.ac.th" target=_blank>Department of Computer Engineering</A>and<A href="http://www.ce.eng.chula.ac.th" target=_blank>Department of Civil Engineering</A>, <a href="http://www.chula.ac.th" target="_blank">Chulalongkorn University</a> | <A href="http://www.thaigrid.or.th" target=_blank>Thai National Grid Center (TNGC)</A></DIV>

<map name="Map"><area shape="rect" coords="5,3,96,110" href="http://www.thaigrid.or.th" title="Thai National Grid Center">
</map>
<map name="Map2"><area shape="rect" coords="5,4,28,45" href="http://www.chula.ac.th" title="Chulalongkorn University"></map></BODY>
<!-- InstanceEnd --></HTML>
