<?php
	session_start();
	
	if(!isset($_SESSION['username'])) {
		echo "<script language=\"javascript\">location.href='../';</script>";
	}
	
	$disable_flag = "";
	$flag_display = "none";
	
	if($_REQUEST['input_type']) {
		$selected_input_type[$_REQUEST['input_type']] = " selected";
	}
	
	if($_REQUEST['data_type']) {
		$selected_data_type[$_REQUEST['data_type']] = " selected";
	}
	
	if($_REQUEST['channel']) {
		$selected_channel[$_REQUEST['channel']] = " selected";
	}
	
	require_once('../../library/connectdb.inc.php');
	
	if(isset($_REQUEST['grp_id']) && $_REQUEST['grp_id'] > 0) {
		$sql = "SELECT * FROM `observe_group` WHERE `id` = ".$_REQUEST['grp_id'];
		$r = mysql_query($sql, $connection);
		$obj = mysql_fetch_object($r);
		$g_name = $obj->g_name;
	}else {
		echo "! no group ";
		exit;
	}

	
	if($_REQUEST['data_type'] == "deform" && ($_REQUEST['channel'] == "create_single_file" || $_REQUEST['channel'] == "create_multiple_file" || $_REQUEST['channel'] == "upload_file")) {
				
		$sql = "SELECT * FROM ds_config_deform";
		$result = mysql_query($sql, $connection);
		if($result) {
			if(mysql_num_rows($result) > 0) {
				$obj_conf = mysql_fetch_object($result);
			}
		}
		
		if($connection && ($_REQUEST['channel'] != "create_multiple_file")) {
			$sql = "SELECT * FROM ds_config_fault_param";
			$result = mysql_query($sql ,$connection);
			if(mysql_num_rows($result) > 0) {
			$obj_param = mysql_fetch_object($result);
			}
		}
	}
		
	if($_REQUEST['channel'] == "upload_file" || $_REQUEST['channel'] == "create_single_file") {
		require_once('../../library/connectdb.inc.php');
		require_once('lib.upload_from_source.php');
		
		switch($_REQUEST['data_type']) {
			case "region":
				$count_file = fn_get_last_auto_increment_id("ds_input_region", $connection);
				break;
			case "deform":
				$count_file = fn_get_last_auto_increment_id("ds_input_deform", $connection);
				break;
			case "vis_file":
				$count_file = fn_get_last_auto_increment_id("ds_input_water_level", $connection);
				break;
		}
	}
	
	if($_REQUEST['channel'] == "create_single_file" || $_REQUEST['channel'] == "create_multiple_file") {
		$_form_action_dest = "ds_handler_deform.php?grp_id=".$_REQUEST['grp_id']."&input_type=".$_REQUEST['input_type']."&data_type=".$_REQUEST['data_type']."&channel=".$_REQUEST['channel'];
	}else
		$_form_action_dest = "ds_handler_norm.php?grp_id=".$_REQUEST['grp_id']."&input_type=".$_REQUEST['input_type']."&data_type=".$_REQUEST['data_type']."&channel=".$_REQUEST['channel'];
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>Web Portal :: Operation and Research Section</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
<META content="index, follow" name=robots>
<link type="text/css" rel="stylesheet" href="../../style/forum.css">
<LINK href="../../style/style.css" type=text/css rel=stylesheet>
<LINK href="../../style/column.css" type=text/css rel=stylesheet>
<SCRIPT src="../../script/mainscript.js" type=text/javascript></SCRIPT>
<META content="MSHTML 6.00.2900.2769" name=GENERATOR>
<style type="text/css">
<!--
.input_text {
	width:150px;
}
#Layer1 {
	position:absolute;
	left:7px;
	top:13px;
	width:658px;
	height:31px;
	z-index:1;
}
.style1 {
	font-size: 22px;
	color: #FFFFFF;
}
-->
</style>
<style type="text/css">
<!--
.style3 {
	color: #000000
}
-->
</style>
<style>
a:active {
	color:#f00
}
a:visited {
	color:#551a8b
}
a:link {
	color:#00c
}
a.c:active {
	color: #ff0000
}
a.c:visited {
	color: #7777cc
}
a.c:link {
	color: #7777cc
}
.b {
	font-weight: bold
}
.shaded-header {
	background-color: #CCE5ED;
	border-top: 1px solid #39c;
	margin: 0px;
	padding: 0px
}
.shaded-subheader {
	background-color: #CCE5ED;
	margin: 12px 0px 0px 0px;
	padding: 0px
}
.plain-subheader {
	background-color: #fff;
	margin: 12px 0px 0px 0px;
	padding: 0px
}
.header-element {
	margin: 0px;
	padding: 2px
}
.expand {
	width: 98%
}
.s {
	font-size: smaller
}
.prefgroup {
	width: 100%
}
.phead { /*font-weight: bold; font-size: smaller; */
	vertical-align: top;
	border-bottom: 2px solid #CCE5ED;
	margin: 0px;
	padding: 16px 8px 16px 8px
}
.pbody {
	border-bottom: 2px solid #CCE5ED;
	margin: 0px;
	padding: 16px 8px 16px 8px
}
.pref-last {
	border-bottom: 0px
}
.example {
	color: gray;
	font-family: monospace;
}
.q a:visited, .q a:link, .q a:active, .q {
	color: #00c;
}
.pref_all {
	background-color: #CCE5ED;
	margin:0px 0 0px 0;
	padding: 4px 4px 4px 4px;
	width: 100%;
}
.pref_tabs { /*font-size: smaller;*/
	margin:0 0 0 0;
	padding: 0 0 0 0;
	border: none;
	width: 100%;
}
.pref_content {
	background-color: #ffffff;
	margin:0 0 0 0;
	width: 100%;
}
.tab {
	width: 1px;
	font-weight: bold;
	text-align: center;
	white-space: nowrap;
	margin: 0 0 0 0;
	padding: .2em .8em .4em .8em;
}
.tab a:visited {
	font-color:#00c;
}
.tab_selected {
	width: 1px;
	background-color: #ffffff;
	font-weight: bold;
	text-align: center;
	white-space: nowrap;
	margin: 0 0 0 0;
	padding: .2em .8em .4em .8em;
}
table.data {
	border:1px solid #E0E0E0;
	width:80%;
}
table.data td {
	border-bottom:1px solid #E0E0E0;
	padding:2px 4px 2px 4px;
}
table.data td.action {
	background-color: #E0E0E0;
}
table.data td.action input {
	font-size:.9em;
}
table.data td.last {
	border:none;
}
table.data th {
	font-weight:bold;
	text-align:left;
	border-bottom:1px solid #E0E0E0;
	padding:2px 4px 2px 4px;
	background-color:#E8E8E8;
}
.detail {
	color:#008800
}
.error {
	border:1px solid #ff0033;
}
td.qf {
	padding-top:10px;
}
select.optgroup {
	font-style:normal;
}
ul {
	margin-top:0
}
#whitelistTABLE, #blacklistTABLE, #policywhitelistTABLE, {
margin: 0px 0px 0px 15px;
}
.style37 {
	color: #990000
}
.style39 {
	font-size: 18px
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
.style7 {
	color: #990000;
	font-weight: bold;
	font-size: 12px;
}
</style>
<script>
<!--
	function select_input_type(value_r) {
		if(value_r == 'none')
			window.location.href='<?=$_SERVER['PHP_SELF']?>';			
		else 
			window.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&input_type='+value_r;
		//alert(select_t);
	}	
	
	function select_data_type(value_r) {
		if(value_r == 'none')
			window.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&input_type='+document.getElementById('input_type').value;
		else
			window.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&input_type='+document.getElementById('input_type').value+'&data_type='+value_r;
	}
	
	function select_channel(value_r) {
		if(value_r == 'none')
			window.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&input_type='+document.getElementById('input_type').value+'&data_type='+document.getElementById('data_type').value;
		else {
			window.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&input_type='+'<?=$_REQUEST['input_type']?>'+'&data_type='+'<?=$_REQUEST['data_type']?>'+'&channel='+value_r;
		}
	}
	
	function cluster_file_selector(dsn) {

		if(dsn != false)
			var win = window.open('user.cluster-file-browser.php?dsn='+dsn.value, 'filebrowser', 'status=1,scrollbars=1,resizeable=1,width=750,height=350', true);	
		else
			var win = window.open('user.cluster-file-browser.php?dsn=false', 'filebrowser', 'status=1,scrollbars=1,resizeable=1,width=700,height=350', true);	
			
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/4, (windowHeight/4)+150);	
	}
	
	function showHistory() {
		win = window.open('user.clusterdsn-history.php', 'dummyname', 'status=1,scrollbars=1,resizeable=0,width=750,height=350', true);		
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/8, (windowHeight/8)+150);		
	}

// -->
</script>
<?php 	
	#require_once('../../library/tinymce.inc.php');
	#tinymce(true);
?>
</HEAD>
<BODY>
<script src="../../script/wz_tooltip.js" type="text/javascript"></script>
<table class="pref_all" border="0" style="border:#30BFD6 1px solid">
  <tbody>
    <tr>
      <td colspan="2"><!-- TABS -->
        <table class="pref_content" style="border:gray dotted 1px;">
          <tr>
            <td class=""><table style="" id="TAB_0" class="prefgroup" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><div align="right"><a href="javascript: void(0)" onClick="javascript: document.location.href='<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>&input_type=<?=$_REQUEST['input_type']?>&data_type=<?=$_REQUEST['data_type']?>&channel=<?=$_REQUEST['channel']?>';">Refresh</a> | <a href="javascript: void(0)" onClick="javascript: document.location.href='importer.php?grp_id=<?=$_REQUEST['grp_id']?>';">Reload</a>| <a href="importer.php" target="_blank">Full Screen</a> | <a href="javascript:void(0)" onClick="parent.document.getElementById('light').style.display='none';parent.document.getElementById('fade').style.display='none'; if(confirm('Do you want to reload this page ?')) { parent.document.location.reload(true);}">Close</a></div>
                          <form action="<?=$_form_action_dest?>" method="post" enctype="multipart/form-data" id="d_form">
                            <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
                            <legend class="style37"><strong>Add&nbsp;new&nbsp;input&nbsp;data&nbsp;of&nbsp;<font color="#0000CC">
                            <?=$g_name?>
                            </font></strong></legend>
                            <select name="input_type" id="input_type" onChange="javascript: select_input_type(this.value);" style="padding:3px">
                              <option value="none">-- Choose input type --</option>
                              <option value="sim" <?=$selected_input_type['sim']?>>Simulation input</option>
                              <option value="vis" <?=$selected_input_type['vis']?>>Visualization input</option>
                            </select>
                            <?php
							if(isset($_REQUEST['input_type'])) {
							?>
                            <select name="data_type" id="data_type" onChange="javascript: select_data_type(this.value);" style="padding:3px">
                              <option value="none">-- Choose file data type -- </option>
                              <?php
							  if($_REQUEST['input_type'] == "sim") {
							  ?>
                              <!--<option value="deform" <?=$selected_data_type['deform']?>>Deformation file</option>-->
                              <option value="region" <?=$selected_data_type['region']?>>Topography and bathymetry file</option>
                              <option value="other" <?=$selected_data_type['other']?>>Other file</option>
                              <?php
							  }
							  if($_REQUEST['input_type'] == "vis") {
							  ?>
                              <option value="vis_file" <?=$selected_data_type['vis_file']?>>Water level file (ETA, Zmax)</option>
                              <?php
							  }
							  ?>
                            </select>
                            <?php
							}
							if(isset($_REQUEST['data_type'])) {
							?>
                            <select name="channel" id="channel" onChange="javascript: select_channel(this.value);" style="padding:3px">
                              <option value="none">-- Choose action --</option>
                              <option value="upload_file" <?=$selected_channel['upload_file']?>>Upload file</option>
                              <?php
                              if($_REQUEST['data_type'] != "region" && $_REQUEST['data_type'] != "vis_file") {
							  ?>
                              <!--<optgroup label="Create new ...">
                              <option value="create_single_file" <?=$selected_channel['create_single_file']?>>- Create single file</option>
                              <option value="create_multiple_file" <?=$selected_channel['create_multiple_file']?>>- Create multiple file</option>
                              </optgroup>-->
                              <?php
							  }
							  ?>
                            </select>
                            <?php
							}
							?>
                            <br>
                            <table border="0" cellspacing="0" cellpadding="3">
                              <?php
								if(($_REQUEST['input_type'] == "vis" || $_REQUEST['input_type'] == "sim") 
									&& ($_REQUEST['data_type'] == "deform" || $_REQUEST['data_type'] == "region" || $_REQUEST['data_type'] == "vis_file") 
									&& ($_REQUEST['channel'] == "create_single_file" || $_REQUEST['channel'] == "upload_file")
								) {
								?>
                              <tr>
                                <td valign="middle" bgcolor="#F0F0F0">Filename</td>
                                <td valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="new_filename" type="text" id="new_filename" value="<?=isset($_SESSION['filename']) ? $_SESSION['filename'] : "untitled-".$count_file?>" style="width:350px"></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td valign="top" bgcolor="#F0F0F0">Description </td>
                                <td valign="top"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><textarea name="description" rows="3" id="description" style="width:350px"></textarea></td>
                                <td>&nbsp;</td>
                              </tr>
                              <?php
								}
								
								if( ($_REQUEST['input_type'] == "sim")
									&& ($_REQUEST['data_type'] == "deform")
									&& ($_REQUEST['channel'] == "create_multiple_file")
								) {
								?>
                              <tr>
                                <td valign="middle" bgcolor="#F0F0F0">Upload fault parameters</td>
                                <td valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="upload_fault" type="file" id="upload_fault" size="55"></td>
                                <td>&nbsp;</td>
                              </tr>
                              <?php
								}
								?>
                            </table>
                            <table width="10" height="2" border="0">
                              <tr>
                                <td></td>
                              </tr>
                            </table>
                            </fieldset>
                            <?php
							if( ($_REQUEST['input_type'] == "sim")
								&& ($_REQUEST['data_type'] == "deform")
								&& ($_REQUEST['channel'] == "create_single_file" || $_REQUEST['channel'] == "create_multiple_file" || $_REQUEST['channel'] == "upload_file"))
							{
							?>
                            <fieldset class="" id="fault_conf" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
                            <strong>
                            <legend class="style37">Deformation :: <font color="#000066">Configuration</font></legend>
                            </strong>
                            <table border="0">
                              <tr>
                                <td><strong>Select profile</strong></td>
                                <td><?php
									if(!isset($connection)) {
										require_once(".././library/connectdb.inc.php");
									}
									
									$sql = "SELECT * FROM ds_input_deform";
									$result_fault_conf = mysql_query($sql, $connection);
									if(mysql_num_rows($result_fault_conf) > 0) {
										$field_list = array('id', 'filename', 'description', 'path', 'glob_x_long', 'glob_y_lat', 'grid_space', 'org_x', 'org_y', 'coord_long_1', 'coord_long_2', 'coord_lat_1', 'coord_lat_2', 'length', 'default_conf', 'create_date');
										$i=0;
										while($obj_fault_conf = mysql_fetch_object($result_fault_conf)){
											foreach($field_list as $index => $field_name) {
												$profile_fault_conf[$field_name][$i] = $obj_fault_conf->$field_name;
											}
											$i++;
										}
									}
									
									$default_profile_id = 0;			
									for($i=0; $i<count($profile_fault_conf['id']); $i++) {
										if(!isset($_REQUEST['profile_fault_conf_id'])) {
											$select[] = "<option value=".$profile_fault_conf['id'][$i]." ".(($profile_fault_conf['default_conf'][$i] == "yes") ? "selected": "").">FILENAME=".$profile_fault_conf['filename'][$i].", DATE=".date("H:i:s j/m/Y", $profile_fault_conf['datetime'][$i])." ".($profile_fault_conf['default_conf'][$i] == "yes" ? "(default)": "")."</option>\n";
										}else {
											$select[] = "<option value=".$profile_fault_conf['id'][$i]." ".(($profile_fault_conf['id'][$i] == $_REQUEST['profile_fault_conf_id']) ? "selected": "").">FILENAME=".$profile_fault_conf['filename'][$i].", DATE=".date("H:i:s j/m/Y", $profile_fault_conf['datetime'][$i])." ".($profile_fault_conf['default_conf'][$i] == "yes" ? "(default)": "")."</option>\n";
										}
										
										if(!isset($_REQUEST['profile_fault_conf_id'])) {
											if($profile_fault_conf['default_conf'][$i] == "yes") {
												$default_profile_id = $i;
												$select_fault_conf[$profile_fault_conf['region_no'][$i]] = " selected";
											}
										}else {
											if($_REQUEST['profile_fault_conf_id'] == $profile_fault_conf['id'][$i]) {
												$default_profile_id = $i;
												$select_fault_conf[$profile_fault_conf['region_no'][$i]] = " selected";
											}
										}
									}	
												
									  ?>
                                  <!--<select name="fault_conf[profile]" id="fault_conf[profile]">
                                    <?php
                                        while($obj_profile = mysql_fetch_object($result)) {
										?>
                                    <option value="<?=$obj_profile->id?>">
                                    <?=$obj_profile->default == "yes" ? $obj_profile->filename." (default) ": $obj_profile->filename;?>
                                    </option>
                                    <?php
										}
										?>
                                  </select>-->
                                  <select name="fault_conf[profile]" id="profile_fault_conf" style="padding:3px" onChange="javascript: document.location.href='<?=$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&input_type=".$_REQUEST['input_type']."&data_type=".$_REQUEST['data_type']."&channel=".$_REQUEST['channel']."&profile_fault_conf_id="?>'+this.value+'&profile_fault_param_id='+document.getElementById('profile_fault_param').value+'&filename='+document.getElementById('profile_fault_param').value+'#fault_conf';">
                                    <?php foreach($select as $index => $str) echo $str; ?>
                                  </select>
                                </td>
                                <td>&nbsp;</td>
                                <td><!--<input type="checkbox" name="fault_conf[default]" id="deform[default]">-->
                                  <input name="deform[default_conf]" type="checkbox" <?=($profile_fault_conf['default_conf'][$default_profile_id] == "yes") ? "checked" : ""?>></td>
                                <td><strong>Set as default</strong></td>
                              </tr>
                            </table>
                            <table border="0" cellspacing="0" cellpadding="3" style="width:450px">
                              <tr valign="middle">
                                <td width="238" bgcolor="#F0F0F0">Global no. of grid in x direction (longitude)</td>
                                <td width="7"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td width="187"><input name="fault_conf[glob_x_long]" type="text" class="input_text" value="<?=$profile_fault_conf['glob_x_long'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Global no. of grid in y direction (latitude)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_conf[glob_y_lat]" type="text" class="input_text" value="<?=$profile_fault_conf['glob_y_lat'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Grid spacing (min)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_conf[grid_space]" type="text" class="input_text" value="<?=$profile_fault_conf['grid_space'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Orgin of x direction</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_conf[org_x]" type="text" class="input_text" value="<?=$profile_fault_conf['org_x'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Orgin of y direction</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_conf[org_y]" type="text" class="input_text" value="<?=$profile_fault_conf['org_y'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Coordinate of cropped area :</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp; &bull; Longitude 1, Longitude 2
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_conf[coord_long_1]" type="text" value="<?=$profile_fault_conf['coord_long_1'][$default_profile_id]?>" size="11">
                                  ,
                                  <input name="fault_conf[coord_long_2]" type="text" value="<?=$profile_fault_conf['coord_long_2'][$default_profile_id]?>" size="11"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp;&nbsp;&bull; Latitude 1, Latitude 2</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_conf[coord_lat_1]" type="text" value="<?=$profile_fault_conf['coord_lat_1'][$default_profile_id]?>" size="11">
                                  ,
                                  <input name="fault_conf[coord_lat_2]" type="text" value="<?=$profile_fault_conf['coord_lat_2'][$default_profile_id]?>" size="11"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Length (min)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_conf[length]" type="text" class="input_text" value="<?=$profile_fault_conf['length'][$default_profile_id]?>" size="20"></td>
                              </tr>
                            </table>
                            </fieldset>
                            <?php
							}
							if( ($_REQUEST['input_type'] == "sim")
								&& ($_REQUEST['data_type'] == "deform")
								&& ($_REQUEST['channel'] == "create_single_file" || $_REQUEST['channel'] == "upload_file")) 
							{
							?>
                            <fieldset class="" id="fault_param" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
                            <strong>
                            <legend class="style37">Deformation :: <font color="#000066">Fault parameters</font></legend>
                            </strong>
                            <table border="0">
                              <tr>
                                <td><strong>Select profile</strong></td>
                                <td><?php
									if(!isset($connection)) {
										require_once(".././library/connectdb.inc.php");
									}
									
									$select = array();
									$sql = "SELECT * FROM ds_input_deform";
									$result_fault_param = mysql_query($sql, $connection);
									if(mysql_num_rows($result_fault_param) > 0) {
										$field_list = array( 'id' , 'filename' , 'description' , 'path' , 'glob_x_long' , 'glob_y_lat' , 'grid_space' , 'org_x' , 'org_y' , 'coord_long_1' , 'coord_long_2' , 'coord_lat_1' , 'coord_lat_2' , 'length' , 'length_fault' , 'width_fault' , 'epi_depth' , 'dislocate' , 'dip_angle' , 'strike_angle' , 'rake_angle' , 'long_epi' , 'lat_epi' , 'max_upward' , 'min_downward' , 'max_lat' , 'max_long' , 'min_lat' , 'min_long' , 'default_conf' , 'default_param' , 'create_date' );
										$i=0;
										while($obj_fault_param = mysql_fetch_object($result_fault_param)){
											foreach($field_list as $index => $field_name) {
												$profile_fault_param[$field_name][$i] = $obj_fault_param->$field_name;
											}
											$i++;
										}
									}
									
									$default_profile_id = 0;			
									for($i=0; $i<count($profile_fault_param['id']); $i++) {
										if(!isset($_REQUEST['profile_fault_param_id'])) {
											$select[] = "<option value=".$profile_fault_param['id'][$i]." ".(($profile_fault_param['default_param'][$i] == "yes") ? "selected": "").">FILENAME=".$profile_fault_param['filename'][$i].", DATE=".date("H:i:s j/m/Y", $profile_fault_param['datetime'][$i])." ".($profile_fault_param['default_param'][$i] == "yes" ? "(default)": "")."</option>\n";
										}else {
											$select[] = "<option value=".$profile_fault_param['id'][$i]." ".(($profile_fault_param['id'][$i] == $_REQUEST['profile_fault_param_id']) ? "selected": "").">FILENAME=".$profile_fault_param['filename'][$i].", DATE=".date("H:i:s j/m/Y", $profile_fault_param['datetime'][$i])." ".($profile_fault_param['default_param'][$i] == "yes" ? "(default)": "")."</option>\n";
										}
										
										if(!isset($_REQUEST['profile_fault_param_id'])) {
											if($profile_fault_param['default_param'][$i] == "yes") {
												$default_profile_id = $i;
												$select_fault_param[$profile_fault_param['region_no'][$i]] = " selected";
											}
										}else {
											if($_REQUEST['profile_fault_param_id'] == $profile_fault_param['id'][$i]) {
												$default_profile_id = $i;
												$select_fault_param[$profile_fault_param['region_no'][$i]] = " selected";
											}
										}
									}	
												
									  ?>
                                  <!--<select name="fault_param[profile]" id="fault_param[profile]">
                                    <?php
                                        while($obj_profile = mysql_fetch_object($result)) {
										?>
                                    <option value="<?=$obj_profile->id?>">
                                    <?=$obj_profile->profile_name?>
                                    </option>
                                    <?php
										}
										?>
                                  </select>-->
                                  <select name="fault_param[profile]" id="profile_fault_param" style="padding:3px" onChange="javascript: document.location.href='<?=$_SERVER['PHP_SELF']."?input_type=".$_REQUEST['input_type']."&data_type=".$_REQUEST['data_type']."&channel=".$_REQUEST['channel']."&profile_fault_param_id="?>'+this.value+'&profile_fault_conf_id='+document.getElementById('profile_fault_conf').value+'#fault_param';">
                                    <?php foreach($select as $index => $str) echo $str; ?>
                                  </select>
                                </td>
                                <td>&nbsp;</td>
                                <td><!--<input name="fault_param[default]" type="checkbox" id="fault_param[default]">-->
                                  <input name="deform[default_param]" type="checkbox" <?=($profile_fault_param['default_param'][$default_profile_id] == "yes") ? "checked" : ""?>></td>
                                <td><strong>Set as default</strong></td>
                              </tr>
                            </table>
                            <table width="384" border="0" cellpadding="3" cellspacing="0" style="width:450px">
                              <tr valign="middle">
                                <td width="209" bgcolor="#F0F0F0">Length fault (m)</td>
                                <td width="7"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td width="216"><input name="fault_param[length_fault]" type="text" class="input_text" value="<?=$profile_fault_param['length_fault'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Width fault (m)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_param[width_fault]" type="text" class="input_text" value="<?=$profile_fault_param['width_fault'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Epicenter depth (m)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"> </td>
                                <td><input name="fault_param[epi_depth]" type="text" class="input_text" value="<?=$profile_fault_param['epi_depth'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Dislocation (m)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_param[dislocate]" type="text" class="input_text" id="fault_param[dislocate]" value="<?=$profile_fault_param['dislocate'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Dip angle (degree)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"> </td>
                                <td><input name="fault_param[dip_angle]" type="text" class="input_text" value="<?=$profile_fault_param['dip_angle'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Strike angle (degree)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_param[strike_angle]" type="text" class="input_text" value="<?=$profile_fault_param['strike_angle'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Rake angle (degree)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"> </td>
                                <td><input name="fault_param[rake_angle]" type="text" class="input_text" value="<?=$profile_fault_param['rake_angle'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Longitude epicenter (degree, +E)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_param[long_epi]" type="text" class="input_text" value="<?=$profile_fault_param['long_epi'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Latitude epicenter (degree, +N, -S)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"> </td>
                                <td><input name="fault_param[lat_epi]" type="text" class="input_text" value="<?=$profile_fault_param['lat_epi'][$default_profile_id]?>" size="20"></td>
                              </tr>
                            </table>
                            </fieldset>
                            <?php
								if ($_REQUEST['channel'] == "upload_file") {
								?>
                            <fieldset class="" id="u_deform2" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
                            <strong>
                            <legend class="style37">Deformation :: <font color="#000066">Summary</font></legend>
                            </strong>
                            <table border="0" cellpadding="3" cellspacing="0" style="width:450px">
                              <tr valign="middle">
                                <td width="95" bgcolor="#F0F0F0">Max. Upward</td>
                                <td width="7"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td width="330"><input name="fault_sum[max_upward]" type="text" class="input_text" id="fault_sum[max_upward]" value="<?=$profile_fault_param['max_upward'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Max. Latitude</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_sum[max_lat]" type="text" class="input_text" id="fault_sum[max_lat]" value="0" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Max. Longitude</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_sum[max_long]" type="text" class="input_text" id="fault_sum[max_long]" value="0" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Min. Downward</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_sum[min_downward]" type="text" class="input_text" id="fault_sum[min_downward]" value="0" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Min. Latitude</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_sum[min_lat]" type="text" class="input_text" id="fault_sum[min_lat]" value="0" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Min. Longitude</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="fault_sum[min_long]" type="text" class="input_text" id="fault_sum[min_long]" value="0" size="20"></td>
                              </tr>
                            </table>
                            </fieldset>
                            <?php
								}
								?>
                            <?php
							} 
							if( ($_REQUEST['input_type'] == "vis" || $_REQUEST['input_type'] == "sim")
								&& ($_REQUEST['data_type'] == "region")
								&& ($_REQUEST['channel'] == "upload_file"))
							{
								if(!isset($connection)) {
									require_once(".././library/connectdb.inc.php");
								}
								$sql = "SELECT * FROM `ds_input_region`";
								$result_region = mysql_query($sql, $connection);
								if(mysql_num_rows($result_region) > 0) {
		  							$field_list = array('id', 'describe', 'name', 'region_no', 'lat_from_degree', 'lat_from_lipda', 'lat_from_Philipda', 'lat_to_degree' , 'lat_to_lipda', 'lat_to_Philipda', 'long_from_degree', 'long_from_lipda', 'long_from_Philipda', 'long_to_degree', 'long_to_lipda', 'long_to_Philipda', 'interval', 'no_of_grids_x', 'no_of_grids_y', 'depth', 'res_lipda', 'res_Philipda', 'input_type', 'path', 'default', 'datetime');
									$i=0;
									while($obj_def_region = mysql_fetch_object($result_region)){
										foreach($field_list as $index => $field_name) {
											$profile_region[$field_name][$i] = $obj_def_region->$field_name;
										}
										$i++;
									}
								}
								
								$default_profile_id = 0;			
								for($i=0; $i<count($profile_region['id']); $i++) {
									if(!isset($_REQUEST['profile_id'])) {
										$select[] = "<option value=".$profile_region['id'][$i]." ".(($profile_region['default'][$i] == "yes") ? "selected": "").">FILENAME=".$profile_region['name'][$i].", DATE=".date("H:i:s j/m/Y", $profile_region['datetime'][$i])." ".($profile_region['default'][$i] == "yes" ? "(default)": "")."</option>\n";
									}else {
										$select[] = "<option value=".$profile_region['id'][$i]." ".(($profile_region['id'][$i] == $_REQUEST['profile_id']) ? "selected": "").">FILENAME=".$profile_region['name'][$i].", DATE=".date("H:i:s j/m/Y", $profile_region['datetime'][$i])." ".($profile_region['default'][$i] == "yes" ? "(default)": "")."</option>\n";
									}
									
									if(!isset($_REQUEST['profile_id'])) {
										if($profile_region['default'][$i] == "yes") {
											$default_profile_id = $i;
											$select_region[$profile_region['region_no'][$i]] = " selected";
										}
									}else {
										if($_REQUEST['profile_id'] == $profile_region['id'][$i]) {
											$default_profile_id = $i;
											$select_region[$profile_region['region_no'][$i]] = " selected";
										}
									}
								}	
												
								/*
								echo "<pre>";
								//print_r($profile_region);
								echo $default_profile_id."\n";
								echo "</pre>";
								*/
							?>
                            <fieldset class="" id="region_form" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
                            <strong>
                            <legend class="style37">Bathymetry and topography file information</legend>
                            </strong>
                            <table border="0">
                              <tr style="padding:2px">
                                <td valign="middle"><strong>Select profile</strong></td>
                                <td valign="middle"><select name="region[profile]" style="padding:3px" onChange="javascript: document.location.href='<?=$_SERVER['PHP_SELF']."?grp_id=".$_REQUEST['grp_id']."&input_type=".$_REQUEST['input_type']."&data_type=".$_REQUEST['data_type']."&channel=".$_REQUEST['channel']."&profile_id="?>'+this.value;">
                                    <?php foreach($select as $index => $str) echo $str; ?>
                                  </select>
                                </td>
                                <td></td>
                                <td><input name="region[default]" type="checkbox" <?=($profile_region['default'][$default_profile_id] == "yes") ? "checked" : ""?>></td>
                                <td><strong>Set as default</strong></td>
                              </tr>
                            </table>
                            <table border="0" cellspacing="0" cellpadding="3">
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Region number</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><select name="region[no]">
                                    <option value="r1" <?=$select_region['R1']?>>Region 1</option>
                                    <option value="r2" <?=$select_region['R2']?>>Region 2</option>
                                    <option value="r3" <?=$select_region['R3']?>>Region 3</option>
                                    <option value="r4" <?=$select_region['R4']?>>Region 4 </option>
                                  </select>
                                </td>
                              </tr>
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Interval (degree)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="region[interval]" type="text" class="input_text" id="region[interval]" value="<?=$profile_region['interval'][$default_profile_id]?>" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Number of grids</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><table width="0" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>X=</td>
                                      <td>&nbsp;</td>
                                      <td><input name="region[no_of_grids_x]" type="text" id="region[no_of_grids_x]" value="<?=$profile_region['no_of_grids_x'][$default_profile_id]?>" size="11"></td>
                                      <td>&nbsp;</td>
                                      <td>Y=</td>
                                      <td>&nbsp;</td>
                                      <td><input name="region[no_of_grids_y]" type="text" id="region[no_of_grids_y]" value="<?=$profile_region['no_of_grids_y'][$default_profile_id]?>" size="11"></td>
                                      <td>&nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Max. of depth (km)</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="region[max_of_depth]" type="text" class="input_text" size="20" value="<?=$profile_region['depth'][$default_profile_id]?>"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Location : Latitude</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp; &bull; From </td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><table width="0" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="region[lat_from_degree]" type="text" id="region[lat_from_degree]" value="<?=$profile_region['lat_from_degree'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;°&nbsp;</td>
                                      <td><input name="region[lat_from_lipda]" type="text" id="region[lat_from_lipda]" value="<?=$profile_region['lat_from_lipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;'&nbsp;</td>
                                      <td><input name="region[lat_from_Philipda]" type="text" id="region[lat_from_Philipda]" value="<?=$profile_region['lat_from_Philipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;''&nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp; &bull; To</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><table width="0" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="region[lat_to_degree]" type="text" id="region[lat_to_degree]" value="<?=$profile_region['lat_to_degree'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;°&nbsp;</td>
                                      <td><input name="region[lat_to_lipda]" type="text" id="region[lat_to_lipda]" value="<?=$profile_region['lat_to_lipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;'&nbsp;</td>
                                      <td><input name="region[lat_to_Philipda]" type="text" id="region[lat_to_Philipda]" value="<?=$profile_region['lat_to_Philipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;''&nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Location : Longitude</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp; &bull; From </td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><table width="0" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="region[long_from_degree]" type="text" id="region[long_from_degree]" value="<?=$profile_region['long_from_degree'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;°&nbsp;</td>
                                      <td><input name="region[long_from_lipda]" type="text" id="region[long_from_lipda]" value="<?=$profile_region['long_from_lipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;'&nbsp;</td>
                                      <td><input name="region[long_from_Philipda]" type="text" id="region[long_from_Philipda]" value="<?=$profile_region['long_from_Philipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;''&nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp; &bull; To</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><table width="0" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input name="region[long_to_degree]" type="text" id="region[long_to_degree]" value="<?=$profile_region['long_to_degree'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;°&nbsp;</td>
                                      <td><input name="region[long_to_lipda]" type="text" id="region[long_to_lipda]" value="<?=$profile_region['long_to_lipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;'&nbsp;</td>
                                      <td><input name="region[long_to_Philipda]" type="text" id="region[long_to_Philipda]" value="<?=$profile_region['long_to_Philipda'][$default_profile_id]?>" size="10"></td>
                                      <td>&nbsp;''&nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Resolution</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp; &bull; Lipda </td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="region[res_lipda]" type="text" class="input_text" size="20" value="<?=$profile_region['res_lipda'][$default_profile_id]?>"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">&nbsp;&nbsp;&nbsp; &bull; Philipda</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="region[res_Philipda]" type="text" class="input_text" size="20" value="<?=$profile_region['res_Philipda'][$default_profile_id]?>"></td>
                              </tr>
                            </table>
                            </fieldset>
                            <?php
							}
							if( ($_REQUEST['input_type'] == "vis")
								&& ($_REQUEST['data_type'] == 'vis_file')
								&& ($_REQUEST['channel'] == "upload_file"))
							{

							?>
                            <fieldset class="" id="region_form" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
                            <strong>
                            <legend class="style37">Information of water level file </legend>
                            </strong>
                            <table border="0">
                              <tr>
                                <td><strong>Select profile</strong></td>
                                <td><select name="wl[profile]" id="wl[profile]">
                                  </select>
                                </td>
                                <td>&nbsp;</td>
                                <td><input name="wl[default]" type="checkbox" id="wl[default]"></td>
                                <td><strong>Set as default</strong></td>
                              </tr>
                            </table>
                            <table border="0" cellspacing="0" cellpadding="3">
                              <tr valign="middle">
                                <td bgcolor="#F0F0F0">Region number</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><?php
                                if($_REQUEST['grp_id'] == 1) {
								?><select name="wl[region_no]" id="wl[reion_no]" onChange="javascript: if(this.value=='r2') { document.getElementById('wl[no_of_grids_x]').value='689'; document.getElementById('wl[no_of_grids_y]').value='953'; } if(this.value=='r1') { document.getElementById('wl[no_of_grids_x]').value='690'; document.getElementById('wl[no_of_grids_y]').value='840'; }">
                                <?php
                                }else {
								?><select name="wl[region_no]" id="wl[reion_no]" onChange="javascript: if(this.value=='r2') { document.getElementById('wl[no_of_grids_x]').value='1665'; document.getElementById('wl[no_of_grids_y]').value='1913'; } if(this.value=='r1') { document.getElementById('wl[no_of_grids_x]').value='721'; document.getElementById('wl[no_of_grids_y]').value='661'; }">
                                <?php
                                }
								?>
                                    <option value="r1" <?=$_SESSION['select']['reg_no']['r1']?>>Region 1</option>
                                    <option value="r2" <?=$_SESSION['select']['reg_no']['r2']?>>Region 2</option>
                                    <!--<option value="r3">Region 3</option>
                                    <option value="r4">Region 4 </option>-->
                                  </select></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Series</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"> </td>
                                <td><table border="0">
                                    <tr>
                                      <td><input name="wl[series]" type="radio" id="wl[series]" value="no" checked></td>
                                      <td>No</td>
                                      <td><input type="radio" name="wl[series]" id="wl[series]" value="yes" disabled></td>
                                      <td>Yes</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Total time step</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><input name="wl[time_step]" type="text" class="input_text" id="wl[time_step]" value="0" size="20"></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Number of grids</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"> </td>
                                <td><table border="0">
                                    <tr>
                                      <td>X=</td>
                                      <td><input name="wl[no_of_grids_x]" type="text" id="wl[no_of_grids_x]" value="<?=isset($_SESSION['no_of_grids_x']) ? $_SESSION['no_of_grids_x'] : 690 ?>" size="8"></td>
                                      <td>Y=</td>
                                      <td><input name="wl[no_of_grids_y]" type="text" id="wl[no_of_grids_y]" value="<?=isset($_SESSION['no_of_grids_y']) ? $_SESSION['no_of_grids_y'] : 840 ?>" size="8"></td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Data order</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><table border="0">
                                    <tr>
                                      <td><input type="radio" name="wl[data_order]" id="radio3" value="row" disabled></td>
                                      <td>Row</td>
                                      <td><input name="wl[data_order]" type="radio" id="radio4" value="column" checked></td>
                                      <td>Column</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr valign="middle">
                                <td align="left" bgcolor="#F0F0F0">Type</td>
                                <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                <td><select name="wl[type]" id="wl[region_no]">
                                    <option value="eta" <?=$_SESSION['type']['eta']?>>ETA</option>
                                    <option value="z_max" <?=$_SESSION['type']['z_max']?>>Z_MAX</option>
                                  </select></td>
                              </tr>
                            </table>
                            </fieldset>
                            <?php
							} 
							?>
                            <?php
							if( ($_REQUEST['input_type'] == "vis" || $_REQUEST['input_type'] == "sim")
								&& ($_REQUEST['data_type'] == "deform" || $_REQUEST['data_type'] == "region" || $_REQUEST['data_type'] == "vis_file")
								&& ($_REQUEST['channel'] == "upload_file"))
							{
							?>
                            <fieldset class="" id="u_deform" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
                            <strong>
                            <legend class="style37">Select file from</legend>
                            </strong>
                            <table border="0" cellpadding="3" cellspacing="0">
                              <tr>
                                <td align="left" valign="middle"><table border="0" cellspacing="0" cellpadding="3">
                                    <tr>
                                      <td bgcolor="#F0F0F0"><input name="ds" type="radio" value="local" checked="checked" onClick="javascript: fileform.disabled=false; dsn.disabled=true; dsn_btn.disabled=true; url.disabled=true; url_btn.disabled=true;"></td>
                                      <td bgcolor="#F0F0F0">Local&nbsp;Disk </td>
                                      <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                      <td><input name="fileform" type="file" id="fileform" size="95">
                                      </td>
                                      <td><b>(Max file size <font color="blue">
                                        <?=ini_get('upload_max_filesize')?>
                                        </font>) </b></td>
                                    </tr>
                                    <!--<tr>
                                      <td bgcolor="#F0F0F0"><input name="ds" type="radio" value="cluster" onClick="javascript: fileform.disabled=true; dsn.disabled=false; dsn_btn.disabled=false; url.disabled=true; url_btn.disabled=true"></td>
                                      <td bgcolor="#F0F0F0">Cluster (SSH) </td>
                                      <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                      <td><table border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td><input name="dsn" type="text" id="dsn" value="username:password@hostname:/path/to/your/directory" size="55" disabled="disabled"></td>
                                            <td class="fs14px"><input name="dsn_btn" type="button" id="dsn_btn" value=" Browse File " onClick="javascript: cluster_file_selector(dsn);" style="width:100px;" disabled="disabled"></td>
                                          </tr>
                                        </table></td>
                                      <td><table border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td><a href="javascript: showHistory('d_form');" style="color:blue">History</a></td>
                                            <td>&nbsp;</td>
                                            <td class="fs14px"><img src="../../image/help.png" alt="0" width="13" height="16" border="0" usemap="#Map2Map2" onClick="javascript: cluster_file_selector(false);">
                                              <map name="Map2Map2">
                                                <area shape="rect" coords="2,1,12,15" href="javascript: cluster_file_selector(false);">
                                              </map></td>
                                          </tr>
                                        </table></td>
                                    </tr>-->
                                    <!-- <tr>
                                      <td><input name="ds" type="radio" value="url" onClick="javascript: fileform.disabled=true; dsn.disabled=true; dsn_btn.disabled=true; url.disabled=false; url_btn.disabled=false;"></td>
                                      <td>URL</td>
                                      <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                      <td><table border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td><input name="url" type="text" id="url" value="http://hostname/path/to/filename" size="55" disabled="disabled"></td>
                                            <td class="fs14px"><input name="url_btn" type="button" id="url_btn" value="Check Exists " onClick="javascript: checkURLFileExist(url.value);" style="width:100px" disabled="disabled"></td>
                                          </tr>
                                        </table></td>
                                      <td>&nbsp;</td>
                                    </tr> -->
                                  </table></td>
                              </tr>
                            </table>
                            </fieldset>
                            <?php
							}
							?>
                            <?php
							if(isset($_REQUEST['channel'])) {
								if($_REQUEST['channel'] != "upload_file") {
							?>
                            <input name="createBtn" type=submit class=butenter id=restore3 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Create" onClick="javascript: setflag(this); Start();">
                            <?php
								}else {
							?>
                            <input name="uploadBtn" type=submit class=butenter id=uploadBtn style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Upload" onClick="javascript: setflag(this); Start();">
                            <?php
								}
							}
							?>
                          </form></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td></td>
      <td id="last_cell" valign="top" align="right"></td>
    </tr>
  </tbody>
</table>
</BODY>
</HTML>
