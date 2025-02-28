<?php
	session_start();
	
	/* set timeout for browsing the cluster directory */
	set_time_limit(600);
	
	/* $_SESSION['username'] is exists if user has been authenticated */
	if(!isset($_SESSION['username'])) {
		/* redirect to .../ */
		echo "<script language=\"javascript\">location.href='../';</script>";
	}
	
	if(isset($_REQUEST['curr_page_water_level'])) {
		$_SESSION['query_string'] = $_SERVER['QUERY_STRING'];
	}else {
		if(isset($_SESSION['query_string']) && $_REQUEST['data'] == "water_level") {
			$q_list = explode("&", $_SESSION['query_string']);
			$string = "";
			for($i=0; $i<count($q_list); $i++) {
				$t = explode("=", $q_list[$i]);
				$qs[$t[0]] = $t[0] == "id_parent" ? $_REQUEST['id_parent'] : $t[1];
			}
			
			foreach($qs as $name => $value) {
				if($name == "grp_id" && $value != $_REQUEST['grp_id']) {
					$value = $_REQUEST['grp_id'];
				}
				$his[] = $name."=".$value;
			}
			$str = implode("&", $his);
			header("location: ".$_SERVER['PHP_SELF']."?".$str);
		}
	}
	
	if(isset($_REQUEST['type'])) {
		$select_type[$_REQUEST['type']] = " selected";
	}else $select_type['none'] = " selected";
	
	if(isset($_REQUEST['data'])) {
		$select_data[$_REQUEST['data']] = " selected";
	}else $select_type['none'] = " selected";
	
	require_once('../../library/connectdb.inc.php');
	
	
	$g_limit = 12;
	
	
	
	/* REGION */
	$limit_r = $g_limit;
	if(!isset($_REQUEST['total_r'])) {
		$sql_r = "SELECT * FROM `ds_input_region` WHERE `grp_id` = ".$_REQUEST['grp_id'];
		$result_r = mysql_query($sql_r, $connection);
		$total_r = mysql_num_rows($result_r);
	}else $total_r = $_REQUEST['total_r'];
	$no_page_r = ceil($total_r/$limit_r);
	
	/* check Has `button` was clicked */
	if(!isset($_REQUEST['btn_r'])) {
		$start_r = 0;
		$limit_r = $g_limit;
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
	
	$str_next_r = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_r=next&start_r=".($start_r+$limit_r)."&limit_r=".$limit_r."&curr_page_r=".($curr_page_r+1)."&total_r=".$total_r."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	$selected_page_r[$_REQUEST['curr_page_r']-1] = " selected";
	
	for($i=0; $i<$no_page_r; $i++) {
		$str_jump_page_r[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_r=next&start_r=".($i * $limit_r)."&limit_r=".$limit_r."&curr_page_r=".($i+1)."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}
	
	if( ($start_r-$limit_r) < 0) {
		$start_r = 0;
		$curr_page_r = 1;
		$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_r=back&start_r=".$start_r."&limit_r=".$limit_r."&curr_page_r=".$curr_page_r."&total_r=".$total_r."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}else {
		$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_r=back&start_r=".($start_r-$limit_r)."&limit_r=".$limit_r."&curr_page_r=".($curr_page_r-1)."&total_r=".$total_r."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}
	
	$str_back_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_r=back_end&start_r=0&limit_r=10&curr_page_r=1&total_r=".$total_r."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	$str_next_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_r=next_end&start_r=".($limit_r * ($no_page_r-1))."&limit_r=10&curr_page_r=".$no_page_r."&total_r=".$total_r."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	
	
	$sql_r = "SELECT * FROM `ds_input_region` WHERE `input_type` = 'sim' AND `grp_id` = ".$_REQUEST['grp_id']." LIMIT ".$start_r.", ".$limit_r;
	$result_sim_r = mysql_query($sql_r, $connection);
	if($result_sim_r) {
		if(mysql_num_rows($result_sim_r) > 0) {
			$i = 0;
			$field_list = array('id', 'describe', 'name', 'path', 'region_no', 'long', 'lat', 'no_of_grids_x', 'no_of_grids_y', 't_interval', 'grid_no', 'max_depth', 'path', 'datetime');
			while($obj_region = mysql_fetch_object($result_sim_r)) {
				foreach($field_list as $index => $field_name) {
					$row_region[$field_name][$i] = $obj_region->$field_name;
				}
				$i++;
			}
		}
	}
	
	
	/* water level */
	$limit_water_level = $g_limit;
	if(!isset($_REQUEST['total_water_level'])) {
		$sql_water_level = "SELECT * FROM `ds_input_water_level` WHERE `grp_id` = ".$_REQUEST['grp_id'];
		$result_water_level = mysql_query($sql_water_level, $connection);
		$total_water_level = mysql_num_rows($result_water_level);
	}else $total_water_level = $_REQUEST['total_water_level'];
	$no_page_water_level = ceil($total_water_level/$limit_water_level);
	
	/* check Has `button` was clicked */
	if(!isset($_REQUEST['btn_water_level'])) {
		$start_water_level = 0;
		$limit_water_level = $g_limit;
		$curr_page_water_level = 1;
	}else {
		$start_water_level = $_REQUEST['start_water_level'];
		$limit_water_level = $_REQUEST['limit_water_level'];
		$curr_page_water_level = $_REQUEST['curr_page_water_level'];
		
		if($start_water_level > $total_water_level) {
			$start_water_level = 0;
			$curr_page_water_level = 1;
		}
	}
	
	$str_next_water_level = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_water_level=next&start_water_level=".($start_water_level+$limit_water_level)."&limit_water_level=".$limit_water_level."&curr_page_water_level=".($curr_page_water_level+1)."&total_water_level=".$total_water_level."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	$selected_page_water_level[$_REQUEST['curr_page_water_level']-1] = " selected";
	
	for($i=0; $i<$no_page_water_level; $i++) {
		$str_jump_page_water_level[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_water_level=next&start_water_level=".($i * $limit_water_level)."&limit_water_level=".$limit_water_level."&curr_page_water_level=".($i+1)."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}
	
	if( ($start_water_level-$limit_water_level) < 0) {
		$start_water_level = 0;
		$curr_page_water_level = 1;
		$str_back_water_level = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_water_level=back&start_water_level=".$start_water_level."&limit_water_level=".$limit_water_level."&curr_page_water_level=".$curr_page_water_level."&total_water_level=".$total_water_level."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}else {
		$str_back_water_level = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_water_level=back&start_water_level=".($start_water_level-$limit_water_level)."&limit_water_level=".$limit_water_level."&curr_page_water_level=".($curr_page_water_level-1)."&total_water_level=".$total_water_level."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}
	
	$str_back_end_water_level = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_water_level=back_end&start_water_level=0&limit_water_level=10&curr_page_water_level=1&total_water_level=".$total_water_level."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	
	$str_next_end_water_level = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_water_level=next_end&start_water_level=".($limit_water_level * ($no_page_water_level-1))."&limit_water_level=10&curr_page_water_level=".$no_page_water_level."&total_water_level=".$total_water_level."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	
	$sql_water_level = "SELECT * FROM `ds_dx_water_level` WHERE `grp_id` = ".$_REQUEST['grp_id']." ORDER BY `filename` LIMIT ".$start_water_level.", ".$limit_water_level;
	$result_sim_water_level = mysql_query($sql_water_level, $connection);
	if($result_sim_water_level) {
		if(mysql_num_rows($result_sim_water_level) > 0) {
			$i = 0;
			$field_list_water_level = array('id', 'filename', 'path', 'series', 'timestep', 'no_of_grids_x', 'no_of_grids_y', 'data_order', 'type', 'region_no', 'create_date');
			while($obj_region_water_level = mysql_fetch_object($result_sim_water_level)) {
				foreach($field_list_water_level as $index => $field_name) {
					$row_water_level[$field_name][$i] = $obj_region_water_level->$field_name;
				}
				$i++;
			}
		}
	}
	/* end water level */	
	
	/* dx region */
	$limit_dx_region = $g_limit;
	if(!isset($_REQUEST['total_dx_region'])) {
		$sql_dx_region = "SELECT * FROM `ds_input_region` WHERE `grp_id` = ".$_REQUEST['grp_id'];
		$result_dx_region = mysql_query($sql_dx_region, $connection);
		$total_dx_region = mysql_num_rows($result_dx_region);
	}else $total_dx_region = $_REQUEST['total_dx_region'];
	$no_page_dx_region = ceil($total_dx_region/$limit_dx_region);
	
	/* check Has `button` was clicked */
	if(!isset($_REQUEST['btn_dx_region'])) {
		$start_dx_region = 0;
		$limit_dx_region = $g_limit;
		$curr_page_dx_region = 1;
	}else {
		$start_dx_region = $_REQUEST['start_dx_region'];
		$limit_dx_region = $_REQUEST['limit_dx_region'];
		$curr_page_dx_region = $_REQUEST['curr_page_dx_region'];
		
		if($start_dx_region > $total_dx_region) {
			$start_dx_region = 0;
			$curr_page_dx_region = 1;
		}
	}
	
	$str_next_dx_region = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_dx_region=next&start_dx_region=".($start_dx_region+$limit_dx_region)."&limit_dx_region=".$limit_dx_region."&curr_page_dx_region=".($curr_page_dx_region+1)."&total_dx_region=".$total_dx_region."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	$selected_page_dx_region[$_REQUEST['curr_page_dx_region']-1] = " selected";
	
	for($i=0; $i<$no_page_dx_region; $i++) {
		$str_jump_page_dx_region[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_dx_region=next&start_dx_region=".($i * $limit_dx_region)."&limit_dx_region=".$limit_dx_region."&curr_page_dx_region=".($i+1)."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}
	
	if( ($start_dx_region-$limit_dx_region) < 0) {
		$start_dx_region = 0;
		$curr_page_dx_region = 1;
		$str_back_dx_region = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_dx_region=back&start_dx_region=".$start_dx_region."&limit_dx_region=".$limit_dx_region."&curr_page_dx_region=".$curr_page_dx_region."&total_dx_region=".$total_dx_region."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}else {
		$str_back_dx_region = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_dx_region=back&start_dx_region=".($start_dx_region-$limit_dx_region)."&limit_dx_region=".$limit_dx_region."&curr_page_dx_region=".($curr_page_dx_region-1)."&total_dx_region=".$total_dx_region."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	}
	
	$str_back_end_dx_region = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_dx_region=back_end&start_dx_region=0&limit_dx_region=10&curr_page_dx_region=1&total_dx_region=".$total_dx_region."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	
	$str_next_end_dx_region = "document.location.href='".$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&type=".$_REQUEST['type']."&data=".$_REQUEST['data']."&btn_dx_region=next_end&start_dx_region=".($limit_dx_region * ($no_page_dx_region-1))."&limit_dx_region=10&curr_page_dx_region=".$no_page_dx_region."&total_dx_region=".$total_dx_region."&id_parent=".$_REQUEST['id_parent']."&id_dwn=".$_REQUEST['id_dwn']."#reg';";
	
	$sql_dx_region = "SELECT * FROM `ds_dx_region` WHERE `grp_id` = ".$_REQUEST['grp_id']." LIMIT ".$start_dx_region.", ".$limit_dx_region;
	$result_sim_dx_region = mysql_query($sql_dx_region, $connection);
	if($result_sim_dx_region) {
		if(mysql_num_rows($result_sim_dx_region) > 0) {
			$i = 0;
			$field_list_dx_region = array('id', 'filename', 'path', 'no_of_grids_x', 'no_of_grids_y', 'data_order', 'region_no', 'create_date');
			while($obj_region_dx_region = mysql_fetch_object($result_sim_dx_region)) {
				foreach($field_list_dx_region as $index => $field_name) {
					$row_dx_region[$field_name][$i] = $obj_region_dx_region->$field_name;
				}
				$i++;
			}
		}
	}
	
	/* end dx region */	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Resource Browser</title>
<link type="text/css" rel="stylesheet" href="../../style/forum.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="th">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #ECE9E8;
}
body, td, th {
	font-family: Arial, Helvetica, sans-serif;
}
.style2 {
	font-size: 14px
}
.style3 {
	font-size: 14px;
	font-weight: bold;
}
.style4 {
	color: #FF0000
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
.tbl_border_bottom {
	border-bottom:black 1px solid;
}
-->
</style>
<script language="javascript">
	function ds_select_input_type(select_val) {
		if(select_val != 'none')
			document.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&type='+select_val;
		else
			document.location.href='<?=$_SERVER['PHP_SELF']?>';		
	}
	function ds_select_data_type(select_val) {
		if(select_val != 'none')
			document.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&type=<?=$_REQUEST['type']?>&data='+select_val;
		else
			document.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&type=<?=$_REQUEST['type']?>';
	}
	
	//send_selected_item('<?=$_REQUEST['data']?>', this.value, '<?=$row_deform['id'][$i]?>', '<?=$row_deform['filename'][$i]?>', '<?=$row_deform['path'][$i]?>');
	function send_selected_item(data_type, id, filename, path) {
		//alert('id_parent=<?=$_REQUEST['id_parent']?>, type='+data_type+', filename='+filename+', id='+id+', path='+path+', id_download=<?=$_REQUEST['id_dwn']?>');
		parent.p_echo('<?=$_REQUEST['id_parent']?>', id, filename, path, '<?=$_REQUEST['id_dwn']?>');
		parent.document.getElementById('light').style.display='none';
		parent.document.getElementById('fade').style.display='none';
	}
	
</script>
</head>
<body class="bodies">
<script type="text/javascript" src="wz_tooltip/wz_tooltip.js"></script>
<center>
  <div style="vertical-align:middle;"><br />
    <form name="dsn_form" id="dsn_form"\>
      <table border="0" cellpadding="0" cellspacing="0" class="fb_blocktable" id="fb_flattable">
        <tbody>
          <tr class="fb_sectiontableentry1_stickymsg">
            <td height="34" class="td-1"><strong><font size="3">Resource Browser and File Selector&nbsp;</font></strong></td>
          </tr>
          <tr>
            <td class="fb_contentheading" id="fb_fspot"><table border="0" cellpadding="0" cellspacing="4">
                <tr>
                  <td><font color="#990000" size="2">Select input type&nbsp;</font></td>
                  <td><font size="2"><img src="../../image/buttonorange.gif" alt="" width="7" height="10" /></font></td>
                  <td><font size="2">
                    <select name="input_type" id="input_type" onchange="javascript: ds_select_input_type(this.value);">
                      <option value="none" <?=$select_type['none']?>>- select -</option>
                      <option value="sim" <?=$select_type['sim']?>>Simulation</option>
                      <option value="vis" <?=$select_type['vis']?>>Visualization</option>
                    </select>
                    </font></td>
                  <td>
                    <?php
					if($_REQUEST['type']) {
					?>
                    <font color="#990000" size="2">data&nbsp;type&nbsp;</font>&nbsp;<img src="../../image/buttonorange.gif" alt="" width="7" height="10" />
                    <?php } ?>                   </td>
                  <td><font size="2">
                    <?php
					if($_REQUEST['type'] == "sim") {
					?>
                    <select name="input_type2" id="input_type2" onchange="javascript: ds_select_data_type(this.value);">
                      <option value="none" <?=$select_data['none']?>>- select -</option>
                      <option value="region" <?=$select_data['region']?>>Bathymetry and topography file</option>
                      <!--<option value="deform" <?=$select_data['deform']?>>Deformation file</option>-->
                    </select>
                    <?php
				  }
				  ?>
                    <?php
                  if($_REQUEST['type'] == "vis") {
				  
				  ?>
                    <select name="input_type2" id="input_type2" onchange="javascript: ds_select_data_type(this.value);">
                      <option value="none" <?=$select_data['none']?>>- select -</option>
                      <option value="region_dx" <?=$select_data['region_dx']?>>Bathymetry and topography files</option>
                      <option value="water_level" <?=$select_data['water_level']?>>Water level files (ETA, Z_MAX)</option>
                    </select>
                    <?php
				  }
				  ?>
                    </font></td>
                  <td><font size="2">Go to <a href="ds_list_sim.php" target="_blank">data source</a></font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td class="fb_contentheading" id="fb_fspot2"><div align="center">
                <?php
		  		if($_REQUEST['type'] == "sim" && $_REQUEST['data'] == "deform") {
		 	  ?>
                <!--<table border="0" cellpadding="3" cellspacing="0" class=" tbl_border fs14px">
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td colspan="10" bgcolor="#7B869A" class="tbl_border_right tbl_border_bottom"><div align="left"><font color="#FFFFFF" size="2">Deformation Files (simulation input)</font></div></td>
                  </tr>
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">!</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">ID</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Filename</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Max.&nbsp;Upward</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Max.&nbsp;Lat</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Max.&nbsp;Long</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Min.&nbsp;Downward</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Min.&nbsp;Lat</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Min.&nbsp;Long</font></td>
                    <td bgcolor="#7B869A" class=""><font color="#FFFFFF" size="2">Create&nbsp;Date</font></td>
                  </tr>
                  <?php		  
				  for($i=0; $i<count($row_deform['id']); $i++) {
					$str = (strlen($row_deform['description'][$i]) > 0) ? $row_deform['description'][$i] : "(description is not specified)";
					$str = "<u>Description</u><br>&nbsp;&nbsp;".$str."<br><br>";
					if($i%2) {
						?>
                  <tr align="center" bgcolor="#F7F8DC" onmouseover="javascript: this.style.background='#D0EFFB';" onmouseout="javascript: this.style.background='#F7F8DC'; UnTip()" id="id_<?=$row_deform['id'][$i]?>">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_deform['id'][$i]?>" id="chk[<?=$row_deform['id'][$i]?>]2" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', '<?=$row_deform['id'][$i]?>', '<?=$row_deform['filename'][$i]?>', '<?=$row_deform['path'][$i]?>');"/>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_deform['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', '<?=$row_deform['id'][$i]?>', '<?=$row_deform['filename'][$i]?>', '<?=$row_deform['path'][$i]?>');">
                        <?=$row_deform['filename'][$i]?>
                        </a> </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['max_upward'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['max_lat'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['max_long'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['min_downward'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['min_lat'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['min_long'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top"><div align="center"> <font size="2">
                        <?=date("H:s:i d/m/Y", $row_deform['create_date'][$i])?>
                        </font></div></td>
                  </tr>
                  <?php
		  			}else {
						?>
                  <tr align="center" bgcolor="#EBEBEB" onmouseover="javascript: this.style.background='#D0EFFB';" onmouseout="javascript: this.style.background='#EBEBEB'; UnTip()">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_deform['id'][$i]?>" id="chk[<?=$row_deform['id'][$i]?>]" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', '<?=$row_deform['id'][$i]?>', '<?=$row_deform['filename'][$i]?>', '<?=$row_deform['path'][$i]?>');"/>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_deform['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', '<?=$row_deform['id'][$i]?>', '<?=$row_deform['filename'][$i]?>', '<?=$row_deform['path'][$i]?>');">
                        <?=$row_deform['filename'][$i]?>
                        </a> </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['max_upward'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['max_lat'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['max_long'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['min_downward'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['min_lat'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=round($row_deform['min_long'][$i], 2)?>
                        </font></div></td>
                    <td class="tbl_border_top"><div align="center"> <font size="2">
                        <?=date("H:s:i d/m/Y", $row_deform['create_date'][$i])?>
                        </font></div></td>
                  </tr>
                  <?php
					}
				}
				
				if(count($row_deform['id']) == 0) {
					?>
                  <tr align="center">
                    <td colspan="10" bgcolor="#EBEBEB" class="tbl_border_top "><font size="2">(no data)</font></td>
                  </tr>
                  <?php
				}
				?>
                </table>-->
                <?php
				
				if(count($row_deform['id']) != 0) {
					?>
                <!--<div align="center"> <font size="2">
                  <input type="button" value="&lt;&lt;" onclick="javascript: <?=$str_back_end?>" />
                  &nbsp;
                  <input type="button" value="&lt;" onclick="javascript: <?=$str_back?>" />
                  &nbsp;Page number :
                  <select name="select" id="select">
                    <?php
          for($p=1; $p<=$no_page; $p++){
		  ?>
                    <option value="<?=$p?>" onclick="javascript: <?=$str_jump_page[$p]?>" <?=$selected_page[$p-1]?>>
                    <?=$p?>
                    </option>
                    <?php
		   }
		   ?>
                  </select>
                  &nbsp;
                  <input type="button" value="&gt;" onclick="javascript: <?=$str_next?>" />
                  &nbsp;
                  <input type="button" value="&gt;&gt;" onclick="javascript: <?=$str_next_end?>" />
                  &nbsp;
                  <input type="button" value="Get summary" onclick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/" />
                  Total<font color="#990000">&nbsp;<b>
                  <?=$total?>
                  </b></font>&nbsp;subfaults. </font></div>-->
                <?php
				}
			}
			?>
                <?php
		  		if($_REQUEST['type'] == "sim" && $_REQUEST['data'] == "region") {
					?>
                <table border="0" cellpadding="3" cellspacing="0" class=" tbl_border fs14px">
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td colspan="10" bgcolor="#7B869A" class="tbl_border_right tbl_border_bottom"><div align="left"><font color="#FFFFFF" size="2">Bathymetry and Topography Files (simulation input)</font></div></td>
                  </tr>
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">!</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">ID</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Filename</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Region&nbsp;No.</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Longitude</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Lattitude</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">No.&nbsp;of&nbsp;Grids&nbsp;[x,&nbsp;y]</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Time&nbsp;Interval</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Max.&nbsp;of&nbsp;Depth</font></td>
                    <td bgcolor="#7B869A" class=""><font color="#FFFFFF" size="2">Create&nbsp;Date&nbsp;</font></td>
                  </tr>
                  <?php
					for($i=0; $i<count($row_region['id']); $i++) {
						$str = (strlen($row_region['describe'][$i]) > 0) ? $row_region['describe'][$i] : "(description is not specified)";
						$str = "<u>Description</u><br>&nbsp;&nbsp;".$str."<br><br>";
						if($i%2) {
							?>
                  <tr align="center" bgcolor="#F7F8DC" onmouseover="javascript: this.style.background='#D0EFFB';" onmouseout="javascript: this.style.background=''; UnTip()" id="id_<?=$row_region['id'][$i]?>">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_region['id'][$i]?>" id="chk[<?=$row_region['id'][$i]?>]" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_region['id'][$i]?>, '<?=$row_region['name'][$i]?>', '<?=$row_region['path'][$i]?>');"/>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_region['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_region['id'][$i]?>, '<?=$row_region['name'][$i]?>', '<?=$row_region['path'][$i]?>');">
                        <?=$row_region['name'][$i]?>
                        </a> </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['region_no'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">-</font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <!--<?=$row_region['lat'][$i]?>-->
                        </font>-</div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['no_of_grids_x'][$i]." x ".$row_region['no_of_grids_y'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['t_interval'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['max_depth'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top "><div align="center"> <font size="2">
                        <?=date("H:s:i d/m/Y", $row_region['datetime'][$i])?>
                        </font></div></td>
                  </tr>
                  <?php
					  	}else {
							?>
                  <tr align="center" bgcolor="#EBEBEB"onmouseover="javascript: this.style.background='#D0EFFB';" onmouseout="javascript: this.style.background=''; UnTip()">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_region['id'][$i]?>" id="chk[<?=$row_region['id'][$i]?>]" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_region['id'][$i]?>, '<?=$row_region['name'][$i]?>', '<?=$row_region['path'][$i]?>');" />
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_region['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_region['id'][$i]?>, '<?=$row_region['name'][$i]?>', '<?=$row_region['path'][$i]?>');">
                        <?=$row_region['name'][$i]?>
                        </a> </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['region_no'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right">-
                      <div align="center"> </div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">-</font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['no_of_grids_x'][$i]." x ".$row_region['no_of_grids_y'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['t_interval'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_region['max_depth'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top "><div align="center"> <font size="2">
                        <?=date("H:s:i d/m/Y", $row_region['datetime'][$i])?>
                        </font></div></td>
                  </tr>
                  <?php
						}
		  			}
					if(count($row_region['id']) == 0) {
		  				?>
                  <tr align="center">
                    <td colspan="10" class="tbl_border_top "><font size="2">(no data)</font></td>
                  </tr>
                  <?php
					}
				?>
                </table>
                <div align="center"><font size="2">
                  <input type="button" value="&lt;&lt;" onclick="javascript: <?=$str_back_end_r?>" />
                  &nbsp;
                  <input type="button" value="&lt;" onclick="javascript: <?=$str_back_r?>" />
                  &nbsp;Page number :
                  <select name="select2" id="select2">
                    <?php
				for($p=1; $p<=$no_page_r; $p++){
					?>
                    <option value="<?=$p?>" onclick="javascript: <?=$str_jump_page_r[$p]?>" <?=$selected_page_r[$p-1]?>>
                    <?=$p?>
                    </option>
                    <?php
		   }
		   ?>
                  </select>
                  &nbsp;
                  <input type="button" value="&gt;" onclick="javascript: <?=$str_next_r?>" />
                  &nbsp;
                  <input type="button" value="&gt;&gt;" onclick="javascript: <?=$str_next_end_r?>" />
                  &nbsp;
                  <input type="button" value="Get summary" onclick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/" />
                  Total<font color="#990000">&nbsp;<b>
                  <?=$total_r?>
                  </b></font>&nbsp;regions. </font></div>
                <?php
				}
		?>
                <?php
				/* dx region */
		  		if($_REQUEST['type'] == "vis" && $_REQUEST['data'] == "region_dx") {
					?>
                <table border="0" cellpadding="3" cellspacing="0" class=" tbl_border fs14px">
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td colspan="7" bgcolor="#7B869A" class="tbl_border_bottom"><div align="left"><font color="#FFFFFF" size="2">Bathymetry and Topography Filesl  (visualization input)</font></div></td>
                  </tr>
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">!</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">ID</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Filename</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Region&nbsp;No.</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">No.&nbsp;of&nbsp;grids</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Data Order</font></td>
                    <td bgcolor="#7B869A" class=""><font color="#FFFFFF" size="2">Create&nbsp;Date&nbsp;</font><font size="2">&nbsp;</font></td>
                  </tr>
                  <?php
		  /*
		  	$field_list_dx_region = array('id', 'filename', 'path', 'no_of_grids_x', 'no_of_grids_y', 'data_order', 'region_no', 'create_date');
		  */
		  for($i=0; $i<count($row_dx_region['id']); $i++) {
			if($i%2) {
		  ?>
                  <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()" id="id_<?=$row_dx_region['id'][$i]?>">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_dx_region['id'][$i]?>" id="chk[<?=$row_dx_region['id'][$i]?>]2" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_dx_region['id'][$i]?>, '<?=$row_dx_region['filename'][$i]?>', '<?=$row_dx_region['path'][$i]?>');" />
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_dx_region['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_dx_region['id'][$i]?>, '<?=$row_dx_region['filename'][$i]?>', '<?=$row_dx_region['path'][$i]?>');">
                        <?=$row_dx_region['filename'][$i]?>
                        </a> </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_dx_region['region_no'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center">
                        <table width="0" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><div align="right"><font size="2">
                                <?=$row_dx_region['no_of_grids_x'][$i]?>
                                </font></div></td>
                            <td><div align="center"><font size="2">&nbsp;x&nbsp;</font></div></td>
                            <td><div align="left"><font size="2">
                                <?=$row_dx_region['no_of_grids_y'][$i]?>
                                </font></div></td>
                          </tr>
                        </table>
                      </div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_dx_region['data_order'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top "><div align="center"> <font color="#006600" size="2">
                        <?=date("H:s:i d/m/Y", $row_dx_region['create_date'][$i])?>
                        </font> </div></td>
                  </tr>
                  <?php
		  	}else {
			?>
                  <tr align="center" bgcolor="#EBEBEB"onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_dx_region['id'][$i]?>" id="chk[<?=$row_dx_region['id'][$i]?>]" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_dx_region['id'][$i]?>, '<?=$row_dx_region['filename'][$i]?>', '<?=$row_dx_region['path'][$i]?>');" />
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_dx_region['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_dx_region['id'][$i]?>, '<?=$row_dx_region['filename'][$i]?>', '<?=$row_dx_region['path'][$i]?>');">
                        <?=$row_dx_region['filename'][$i]?>
                        </a></font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_dx_region['region_no'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center">
                        <table width="0" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><div align="right"> <font size="2">
                                <?=$row_dx_region['no_of_grids_x'][$i]?>
                                </font></div></td>
                            <td><div align="center"><font size="2">&nbsp;x&nbsp;</font></div></td>
                            <td><div align="left"> <font size="2">
                                <?=$row_dx_region['no_of_grids_y'][$i]?>
                                </font></div></td>
                          </tr>
                        </table>
                      </div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_dx_region['data_order'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top"><div align="center"> <font color="#006600" size="2">
                        <?=date("H:s:i d/m/Y", $row_dx_region['create_date'][$i])?>
                        </font> </div></td>
                  </tr>
                  <?php
			}
		  }
		  if(count($row_dx_region['id']) == 0) {
		  	?>
                  <tr align="center">
                    <td colspan="30" bgcolor="#EBEBEB" class="tbl_border_top"><font size="2">(no data)</font></td>
                  </tr>
                  <?php
		  }
		  ?>
                </table>
                <div align="center"><font size="2">
                  <input type="button" value="&lt;&lt;" onclick="javascript: <?=$str_back_end_dx_region?>" />
                  &nbsp;
                  <input type="button" value="&lt;" onclick="javascript: <?=$str_back_dx_region?>" />
                  &nbsp;Page number :
                  <select name="select2" id="select2">
                    <?php
				for($p=1; $p<=$no_page_dx_region; $p++){
					?>
                    <option value="<?=$p?>" onclick="javascript: <?=$str_jump_page_dx_region[$p]?>" <?=$selected_page_dx_region[$p-1]?>>
                    <?=$p?>
                    </option>
                    <?php
		   }
		   ?>
                  </select>
                  &nbsp;
                  <input type="button" value="&gt;" onclick="javascript: <?=$str_next_dx_region?>" />
                  &nbsp;
                  <input type="button" value="&gt;&gt;" onclick="javascript: <?=$str_next_end_dx_region?>" />
                  &nbsp;
                  <input type="button" value="Get summary" onclick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/" />
                  Total<font color="#990000">&nbsp;<b>
                  <?=$total_dx_region?>
                  </b></font>&nbsp;regions. </font></div>
                <?php
				}
				/* end dx region */
				?>
                <?php
				/* water level */
		  		if($_REQUEST['type'] == "vis" && $_REQUEST['data'] == "water_level") {
					?>
                <table border="0" cellpadding="3" cellspacing="0" class=" tbl_border fs14px">
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td colspan="9" bgcolor="#7B869A" class="tbl_border_bottom"><div align="left"><font color="#FFFFFF" size="2">Water Level  (visualization input)</font></div></td>
                  </tr>
                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">!</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">ID</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Filename</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Region&nbsp;No.</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Type</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Series</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">No.&nbsp;of&nbsp;grids</font></td>
                    <td bgcolor="#7B869A" class="tbl_border_right"><font color="#FFFFFF" size="2">Data Order</font></td>
                    <td bgcolor="#7B869A" class=""><font color="#FFFFFF" size="2">Create&nbsp;Date&nbsp;</font><font size="2">&nbsp;</font></td>
                  </tr>
                  <?php
		  /*
		  	$field_list_water_level = array('id', 'filename', 'path', 'series', 'timestep', 'no_of_grids_x', 'no_of_grids_y', 'data_order', 'type', 'region_no', 'create_date');
		  */
		  for($i=0; $i<count($row_water_level['id']); $i++) {
		  /*
		  	$str = (strlen($row_region['describe'][$i]) > 0) ? $row_region['describe'][$i] : "(description is not specified)";
			$str = "<u>Description</u><br>&nbsp;&nbsp;".$str."<br><br>";
			$str .= "<u>Bathymetry and topography information</u><br>";
			$str .= "Region No. = ".$row_region['region_no'][$i]."<br>";
			$str .= "Interval = ".$row_region['interval'][$i]."<br>";
			$str .= "Number of grids [x, y] = [".$row_region['no_of_grids_x'][$i].", ".$row_region['no_of_grids_y'][$i]."]<br>";
			$str .= "Maximum of Depth = ".$row_region['depth'][$i]."<br>";
			$str .= "Location (latitude) :<br>";
			$str .= "&nbsp;&nbsp;-From = ".$row_region['lat_from_degree'][$i]."° ".$row_region['lat_from_lipda'][$i]."\' ".$row_region['lat_from_Philipda'][$i]."\'\'<br>";
			$str .= "&nbsp;&nbsp;-To = ".$row_region['lat_to_degree'][$i]."° ".$row_region['lat_to_lipda'][$i]."\' ".$row_region['lat_to_Philipda'][$i]."\'\'<br>";	
			$str .= "Location (longitude) :<br>";
			$str .= "&nbsp;&nbsp;-From = ".$row_region['long_from_degree'][$i]."° ".$row_region['long_from_lipda'][$i]."\' ".$row_region['long_from_Philipda'][$i]."\'\'<br>";
			$str .= "&nbsp;&nbsp;-To = ".$row_region['long_to_degree'][$i]."° ".$row_region['long_to_lipda'][$i]."\' ".$row_region['long_to_Philipda'][$i]."\'\'<br>";														
			$str .= "Resolution = ".$row_region['res_lipda'][$i]."\' ".$row_region['res_Philipda'][$i]."\'\'<br>";  	*/
			if($i%2) {
		  ?>
                  <tr align="center" bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()" id="id_<?=$row_water_level['id'][$i]?>">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_water_level['id'][$i]?>" id="chk[<?=$row_water_level['id'][$i]?>]2" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_water_level['id'][$i]?>, '<?=$row_water_level['filename'][$i]?>', '<?=$row_water_level['path'][$i]?>');" />
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_water_level['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_water_level['id'][$i]?>, '<?=$row_water_level['filename'][$i]?>', '<?=$row_water_level['path'][$i]?>');">
                        <?=$row_water_level['filename'][$i]?>
                        </a> </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_water_level['region_no'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_water_level['type'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"><font size="2">
                        <?=$row_water_level['series'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center">
                        <table width="0" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><div align="right"><font size="2">
                                <?=$row_water_level['no_of_grids_x'][$i]?>
                                </font></div></td>
                            <td><div align="center"><font size="2">&nbsp;x&nbsp;</font></div></td>
                            <td><div align="left"><font size="2">
                                <?=$row_water_level['no_of_grids_y'][$i]?>
                                </font></div></td>
                          </tr>
                        </table>
                      </div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_water_level['data_order'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top "><div align="center"> <font color="#006600" size="2">
                        <?=date("H:s:i d/m/Y", $row_water_level['create_date'][$i])?>
                        </font> </div></td>
                  </tr>
                  <?php
		  	}else {
			?>
                  <tr align="center" bgcolor="#EBEBEB"onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()">
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <input type="radio" name="chk" value="<?=$row_water_level['id'][$i]?>" id="chk[<?=$row_water_level['id'][$i]?>]" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_water_level['id'][$i]?>, '<?=$row_water_level['filename'][$i]?>', '<?=$row_water_level['path'][$i]?>');" />
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><font size="2">
                      <?=$row_water_level['id'][$i]?>
                      </font></td>
                    <td class="tbl_border_top tbl_border_right"><div align="left"><font size="2"><a href="#docu" onclick="javascript: send_selected_item('<?=$_REQUEST['data']?>', <?=$row_water_level['id'][$i]?>, '<?=$row_water_level['filename'][$i]?>', '<?=$row_water_level['path'][$i]?>');">
                        <?=$row_water_level['filename'][$i]?>
                        </a></font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_water_level['region_no'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_water_level['type'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_water_level['series'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center">
                        <table width="0" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><div align="right"> <font size="2">
                                <?=$row_water_level['no_of_grids_x'][$i]?>
                                </font></div></td>
                            <td><div align="center"><font size="2">&nbsp;x&nbsp;</font></div></td>
                            <td><div align="left"> <font size="2">
                                <?=$row_water_level['no_of_grids_y'][$i]?>
                                </font></div></td>
                          </tr>
                        </table>
                      </div></td>
                    <td class="tbl_border_top tbl_border_right"><div align="center"> <font size="2">
                        <?=$row_water_level['data_order'][$i]?>
                        </font></div></td>
                    <td class="tbl_border_top"><div align="center"> <font color="#006600" size="2">
                        <?=date("H:s:i d/m/Y", $row_water_level['create_date'][$i])?>
                        </font> </div></td>
                  </tr>
                  <?php
			}
		  }
		  if(count($row_water_level['id']) == 0) {
		  	?>
                  <tr align="center">
                    <td colspan="32" bgcolor="#EBEBEB" class="tbl_border_top"><font size="2">(no data)</font></td>
                  </tr>
                  <?php
		  }
		  ?>
                </table>
                <div align="center"><font size="2">
                  <input type="button" value="&lt;&lt;" onclick="javascript: <?=$str_back_end_water_level?>" />
                  &nbsp;
                  <input type="button" value="&lt;" onclick="javascript: <?=$str_back_water_level?>" />
                  &nbsp;Page number :
                  <select name="select2" id="select2">
                    <?php
				for($p=1; $p<=$no_page_water_level; $p++){
					?>
                    <option value="<?=$p?>" onclick="javascript: <?=$str_jump_page_water_level[$p]?>" <?=$selected_page_water_level[$p-1]?>>
                    <?=$p?>
                    </option>
                    <?php
		   }
		   ?>
                  </select>
                  &nbsp;
                  <input type="button" value="&gt;" onclick="javascript: <?=$str_next_water_level?>" />
                  &nbsp;
                  <input type="button" value="&gt;&gt;" onclick="javascript: <?=$str_next_end_water_level?>" />
                  &nbsp;
                  <input type="button" value="Get summary" onclick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/" />
                  Total<font color="#990000">&nbsp;<b>
                  <?=$total_water_level?>
                  </b></font>&nbsp;regions. </font></div>
                <?php
				}
				/* end water level */
		?>
              </div></td>
          </tr>
        </tbody>
      </table>
    </form>
    <input name="close2" type="button" id="close2" value="Close" onClick="parent.document.getElementById('light').style.display='none';parent.document.getElementById('fade').style.display='none';" />
    &nbsp;&nbsp;
    <input name="reload" type="button" id="reload" value="Reload" onclick="javascript: document.location.reload();" />
    <br />
  </div>
</center>
</body>
</html>
