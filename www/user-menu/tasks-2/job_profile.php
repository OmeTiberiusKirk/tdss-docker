<?php
	session_start();
	
	require_once('../../library/connectdb.inc.php');
	
	if(!isset($_REQUEST) || $_REQUEST['sec'] == "main") {
		$job_profile_id = $_REQUEST['job_id'];
		$sql = "SELECT * FROM `job_profile` WHERE `id` = ".$job_profile_id;
		$field_job = array("id", "sim_result_id", "name", "local_store_path", "status", "timestep_now", "total_timestep", "no_of_region", "create_date", "run_date", "finish_date");
		$result = mysql_query($sql, $connection);
		if(mysql_num_rows($result) == 1) {
			$obj = mysql_fetch_object($result);
			foreach($field_job as $index => $field_name) {
				$job_profile[$field_name] = $obj->$field_name;
			}		
		}
		
		$sql = "SELECT * FROM `sim_result` WHERE `job_profile_id` = ".$job_profile['sim_result_id'];
		$field_sim_result = array("id", "job_profile_id", "uid", "name", "domain", "source", "ob_area", "desc", "magnitude", "depth", "lat_degree", "lat_lipda", "lat_Philipda", "long_degree", "long_lipda", "long_Philipda", "reg_1_filename", "reg_2_filename", "reg_3_filename", "reg_4_filename", "sim_type", "datetime");
		$result = mysql_query($sql, $connection);
		session_unregister("job_profile_id");
		if(mysql_num_rows($result) == 1) {
			$obj = mysql_fetch_object($result);
			foreach($field_sim_result as $index => $field_name) {
				if($field_name == "job_profile_id")
					$_SESSION['job_profile_id'] = $obj->$field_name;
				$sim_result[$field_name] = $obj->$field_name;
			}
		}
		
	}
	
	//if($_REQUEST['sec'] == "param" && $_SESSION['job_profile_id'] > 0) {
		$sql = "SELECT `param_contents` FROM `sim_profile` WHERE `id` = ".$_SESSION['job_profile_id'];
		$result = mysql_query($sql, $connection);
		if(mysql_num_rows($result) == 1) {
			$obj = mysql_fetch_object($result);
			$param_contents = $obj->param_contents;
		}
		
		$data = explode("\n", stripslashes($param_contents));
		unset($data[0], $data[count($data)]);
		$sep = "{0x0000}";
		foreach($data as $index => $line) {
			$t = explode($sep, $line);
			$temp[$t[0]][$t[1]][$t[2]] = $t[3];
		}
		
		$_SESSION['param']['des'] = array();
		$_SESSION['param']['value'] = array();
		$_SESSION['param']['des'] = $temp['des']['global'];
		$_SESSION['param']['value'] = $temp['val']['global'];
		
		$_SESSION['input']['des'] = array();
		$_SESSION['input']['value'] = array();
		$_SESSION['input']['des'] = $temp['des']['input'];
		$_SESSION['input']['value'] = $temp['val']['input'];
		
		$_SESSION['output']['des'] = array();
		$_SESSION['output']['value'] = array();
		$_SESSION['output']['des'] = $temp['des']['output'];
		$_SESSION['output']['value'] = $temp['val']['output'];		
	//}
	/*
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	exit;
	*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>Job profile</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
<META content="index, follow" name=robots>
<link type="text/css" rel="stylesheet" href="../../style/forum.css">
<LINK href="../../style/style.css" type=text/css rel=stylesheet>
<LINK href="../../style/column.css" type=text/css rel=stylesheet>
<link href="../../style/expr.css" type="text/css" rel="stylesheet">
<SCRIPT src="../../script/mainscript.js" type=text/javascript></SCRIPT>
<META content="MSHTML 6.00.2900.2769" name=GENERATOR>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:9px;
	top:12px;
	width:695px;
	height:29px;
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
	height: 90%;
	bottom: 10%;
	padding: 2px;
	border: 2px solid orange;
	background-color: white;
	z-index:1002;
	overflow: hidden;
}
-->
</style>
</HEAD>
<BODY>
<DIV class="section">
  <DIV class=tutorials_list>
    <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><strong>Section</strong></td>
                <td><strong>&nbsp;:&nbsp;</strong></td>
                <td>&nbsp;</td>
                <td><a href="<?=$_SERVER['PHP_SELF']?>?job_id=<?=$_REQUEST['job_id']?>&sec=main">General</a></td>
                <td><div align="center">&nbsp;|&nbsp;</div></td>
                <td><a href="<?=$_SERVER['PHP_SELF']?>?job_id=<?=$_REQUEST['job_id']?>&sec=param">Parameters</a></td>
                <td><div align="center">&nbsp;|&nbsp;</div></td>
                <td><a href="<?=$_SERVER['PHP_SELF']?>?job_id=<?=$_REQUEST['job_id']?>&sec=input">Input</a></td>
                <td><div align="center">&nbsp;|&nbsp;</div></td>
                <td><a href="<?=$_SERVER['PHP_SELF']?>?job_id=<?=$_REQUEST['job_id']?>&sec=output">Output</a></td>
                <td><div align="center">&nbsp;|&nbsp;</div></td>
                <td><a href="<?=$_SERVER['PHP_SELF']?>?job_id=<?=$_REQUEST['job_id']?>&sec=ob_point">Observation&nbsp;Points</a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          <td><div align="right"><a href="<?=$_SERVER['REQUEST_URI']?><?=(!isset($_REQUEST['s']) ? "&s=f": "")?>" target="_blank">Full Screen</a> | <a href="<?=$_SERVER['REQUEST_URI']?>">Reload</a> | <a href="javascript: void(0)" onClick="javascript: <?=!isset($_REQUEST['s']) ? "parent.document.getElementById('light').style.display='none';parent.document.getElementById('fade').style.display='none';" : "window.open('','_parent',''); window.close();"?>">Close</a></div></td>
        </tr>
      </table>
    </div>
    <img src="../../image/spacer.gif" width="1" height="3">
    <div style="background-color:#FFFF99; padding:4px 4px 4px 4px; border-top:#999999 1px solid; border-bottom:#999999 1px solid; border-right:#999999 1px solid; border-left:#999999 1px solid;">
      <div align="center">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><font color="#FF0000"><strong>Job Status !</strong></font></td>
            <td>&nbsp;</td>
            <td>NOT SUBMIT</td>
          </tr>
        </table>
      </div>
    </div>
    <?php if(!isset($_REQUEST['sec']) || $_REQUEST['sec'] == "main") { ?>
    <!-- main-->
    <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
    <legend class="style37"><strong>General information</strong></legend>
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Name </th>
        <th scope="col" valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><?=$sim_result['name']?></td>
      </tr>
      <tr>
        <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Source</strong></th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><?=$sim_result['source']?></td>
      </tr>
      <tr>
        <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Domain</strong></th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><?=$sim_result['domain']?></td>
      </tr>
      <tr>
        <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Observation Area</strong></th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><?=$sim_result['ob_area']?></td>
      </tr>
      <tr>
        <th align="left" valign="top" bgcolor="#EBEBEB" scope="col"><strong>Description</strong></th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><?=$sim_result['desc']?></td>
      </tr>
    </table>
    </fieldset>
    <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
    <legend class="style37"><strong>Earthquake parameters</strong></legend>
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Magnitude</th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><?=$sim_result['magnitude']?>
      </tr>
      <tr>
        <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Depth</th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><?=$sim_result['depth']?></td>
      </tr>
      <tr>
        <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Latitude</th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><?=$sim_result['lat_degree']?></td>
              <td>&nbsp;°&nbsp;</td>
              <td><?=$sim_result['lat_lipda']?></td>
              <td>&nbsp;'&nbsp;</td>
              <td><?=$sim_result['lat_Philipda']?></td>
              <td>&nbsp;''&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <th align="left" valign="middle" bgcolor="#EBEBEB" scope="col">Longitude</th>
        <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
        <td align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><?=$sim_result['long_degree']?></td>
              <td>&nbsp;°&nbsp;</td>
              <td><?=$sim_result['long_lipda']?></td>
              <td>&nbsp;'&nbsp;</td>
              <td><?=$sim_result['long_Philipda']?></td>
              <td>&nbsp;''&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>
    </fieldset>
    <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
    <legend class="style37"><strong>Boundary of topology and bathymetry</strong></legend>
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th colspan="2" rowspan="3" align="left" valign="middle" bgcolor="#7B869A" scope="col" style="border-right:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">Region No.</font></div></th>
        <th colspan="4" align="left" bgcolor="#7B869A" scope="col" style="border-bottom:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">Location</font></div></th>
        <th rowspan="3" align="left" bgcolor="#7B869A" scope="col" style="border-left:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">File Name</font></div></th>
      </tr>
      <tr>
        <th colspan="2" align="left" bgcolor="#7B869A" scope="col" style="border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">Latitude</font></div></th>
        <th colspan="2" align="left" bgcolor="#7B869A" scope="col" style="border-bottom:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">Longitude</font></div></th>
      </tr>
      <tr>
        <th align="left" bgcolor="#7B869A" scope="col" style="border-right:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">From</font></div></th>
        <th align="left" bgcolor="#7B869A" scope="col" style="border-right:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">To</font></div></th>
        <th align="left" bgcolor="#7B869A" scope="col" style="border-right:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">From</font></div></th>
        <th align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">To</font></div></th>
      </tr>
      <?php
	  	
	  	for($i=1; $i<=$job_profile['no_of_region']; $i++) {
			$filename[$i] = "reg_".$i."_filename";
			$str_query[]  = "`name` LIKE '".$sim_result[$filename[$i]]."'";
		}
		
		$sql = "SELECT * FROM `ds_input_region` WHERE ".implode(" OR ", $str_query);
		$res = mysql_query($sql, $connection);
		
		
		for($i=1; $i<=$job_profile['no_of_region']; $i++) {
			$obj = mysql_fetch_object($res);
			
	  ?>
      <tr>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col" style="border-left:#7B869A solid 1px; border-bottom:#7B869A solid 1px;"><div align="center"><?=$i?></div></td>
        <td scope="col" valign="middle" style="border-bottom:#7B869A solid 1px; border-right:#7B869A solid 1px"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
        <td align="left" scope="col" style="border-right:#7B869A solid 1px; border-bottom:#7B869A solid 1px;">
          <div align="right">
            <table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="right">
                  <?=$obj->lat_from_degree?>
                </div></td>
                <td>&nbsp;°&nbsp;</td>
                <td><div align="right">
                  <?=$obj->lat_from_lipda?>
                </div></td>
                <td>&nbsp;'&nbsp;</td>
                <td><div align="right">
                  <?=$obj->lat_from_Philipda?>
                </div></td>
                <td>&nbsp;''&nbsp;</td>
              </tr>
                      </table>
        </div></td>
        <td align="left" scope="col" style="border-right:#7B869A solid 1px; border-bottom:#7B869A solid 1px;">
          <div align="right">
            <table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?=$obj->lat_to_degree?></td>
                <td>&nbsp;°&nbsp;</td>
                <td><?=$obj->lat_to_lipda?></td>
                <td>&nbsp;'&nbsp;</td>
                <td><?=$obj->lat_to_Philipda?></td>
                <td>&nbsp;''&nbsp;</td>
              </tr>
                      </table>
        </div></td>
        <td align="left" scope="col" style="border-right:#7B869A solid 1px; border-bottom:#7B869A solid 1px;">
          <div align="right">
            <table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?=$obj->long_from_degree?></td>
                <td>&nbsp;°&nbsp;</td>
                <td><?=$obj->long_from_lipda?></td>
                <td>&nbsp;'&nbsp;</td>
                <td><?=$obj->long_from_Philipda?></td>
                <td>&nbsp;''&nbsp;</td>
              </tr>
                      </table>
        </div></td>
        <td align="left" scope="col" style="border-right:#7B869A solid 1px; border-bottom:#7B869A solid 1px;">
          <div align="right">
            <table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?=$obj->long_to_degree?></td>
                <td>&nbsp;°&nbsp;</td>
                <td><?=$obj->long_to_lipda?></td>
                <td>&nbsp;'&nbsp;</td>
                <td><?=$obj->long_to_Philipda?></td>
                <td>&nbsp;''&nbsp;</td>
              </tr>
                      </table>
        </div></td>
        <td align="left" scope="col" style="border-right:#7B869A solid 1px; border-bottom:#7B869A solid 1px;"><a href="javascript: void(0)" onClick="javascript: document.location.href='../data-source/download_file.php?download_filepath=<?=$obj->path?>';"><?=$obj->name?></a></td>
      </tr>
      <?php
	  	}
	  ?>
    </table>
    </fieldset>
    <?php } ?>
    <?php if($_REQUEST['sec'] == "param") { ?>
    <!-- param-->
    <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
    <legend class="style37"><strong>Simulation parameters</strong></legend>
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">No.</font></div></th>
        <th align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Description</font></div></th>
        <th align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Parameter&nbsp;Name</font></div></th>
        <th align="left" bgcolor="#7B869A" scope="col">&nbsp;</th>
        <th align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Value</font></div></th>
      </tr>
      <?php
	  $i=1;
      foreach($_SESSION['param']['des'] as $v_name => $value) {
	  ?>
      <tr>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="left"><?=$i++?></div></td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="left"><?=$value?></div></td>
        <td scope="col" valign="middle" ><div align="left">&nbsp;&nbsp;&nbsp;<?=$v_name?></div></td>
        <td align="left" scope="col"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
        <td align="left" scope="col"><?=$_SESSION['param']['value'][$v_name]?></td>
      </tr>
      <?php
      }
	  ?>
    </table>
    </fieldset>
    <?php } ?>
    <?php if($_REQUEST['sec'] == "input") { ?>
    <?php 
		/* 
			$_SESSION['input']['des']
			$_SESSION['input']['value']
		*/
	?>
    <!-- input -->
    <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
    <legend class="style37"><strong>List of input files</strong></legend>
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th colspan="7" align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="left"><font color="#FFFFFF">Deformation</font></div>
          <div align="center"></div>
          <div align="center"></div>
          <div align="center"></div></th>
      </tr>
      <tr>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><div align="center"><font color="#FFFFFF">Description</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><div align="left"><font color="#FFFFFF">Variable Name</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th valign="middle" bgcolor="#000000" scope="col" ><div align="left"><font color="#FFFFFF">Region No.</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th align="left" bgcolor="#000000" scope="col"><font color="#FFFFFF">Filename</font></th>
      </tr>
      <?php
	  foreach($_SESSION['input']['des'] as $v_name => $value) {
	  	$str[] = "`filename` LIKE '".$_SESSION['input']['value'][$v_name]."'";
	  }
	  
	  $sql = "SELECT * FROM `ds_input_deform` WHERE ".implode(" OR ", $str);
	  $res = mysql_query($sql, $connection);
	  if(mysql_num_rows($res) > 0) {
	  	while($obj = mysql_fetch_object($res)) {
			$file[$obj->filename] = $obj->path;
		}
	  }
	  
		foreach($_SESSION['input']['des'] as $v_name => $value) {
			if(substr($v_name, 0, 3) == "DEF") {
				$region_no = substr($v_name, 3, 1);
	  ?>
      <tr>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><?=$value?></td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col">&nbsp;</td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><?=$v_name?></td>
        <td scope="col" valign="middle" >&nbsp;</td>
        <td scope="col" valign="middle" ><div align="center">
          <?=$region_no?>
        </div></td>
        <td align="left" scope="col">&nbsp;</td>
        <td align="left" scope="col"><a href="javascript: void(0)" onClick="javascript: document.location.href='../data-source/download_file.php?download_filepath=<?=$file[$_SESSION['input']['value'][$v_name]]?>';"><?=$_SESSION['input']['value'][$v_name]?></a></td>
      </tr>
      <?php
	  		}
      	}
	  ?>
    </table>
 
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th colspan="7" align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="left"><font color="#FFFFFF">Bathymetry and topography</font></div>
          <div align="center"></div>
          <div align="center"></div>
          <div align="center"></div></th>
      </tr>
      <tr>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><div align="center"><font color="#FFFFFF">Description</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><div align="left"><font color="#FFFFFF">Variable Name</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th valign="middle" bgcolor="#000000" scope="col" ><div align="left"><font color="#FFFFFF">Region No.</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th align="left" bgcolor="#000000" scope="col"><font color="#FFFFFF">Filename</font></th>
      </tr>
      <?php
	  	$str = array();
	  	foreach($_SESSION['input']['des'] as $v_name => $value) {
			$str[] = "`name` LIKE '".$_SESSION['input']['value'][$v_name]."'";
		}
		
		$sql = "SELECT * FROM `ds_input_region` WHERE ".implode(" OR ", $str);
		$res = mysql_query($sql, $connection);
		if(mysql_num_rows($res) > 0) {
			$file = array();
			while($obj = mysql_fetch_object($res)) {
				$file[$obj->name] = $obj->path;
			}
		}
	  
		foreach($_SESSION['input']['des'] as $v_name => $value) {
			if(substr($v_name, 0, 3) == "REG") {
				$region = substr($v_name, 3, 1);
	  ?>
      <tr>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><?=$value?></td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col">&nbsp;</td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><?=$v_name?></td>
        <td scope="col" valign="middle" >&nbsp;</td>
        <td scope="col" valign="middle" ><div align="center">
          <?=$region?>
        </div></td>
        <td align="left" scope="col">&nbsp;</td>
        <td align="left" scope="col"><a href="javascript: void(0)" onClick="javascript: document.location.href='../data-source/download_file.php?download_filepath=<?=$file[$_SESSION['input']['value'][$v_name]]?>';"><?=$_SESSION['input']['value'][$v_name]?></a></td>
      </tr>
      <?php
      		}
		}
	  ?>
    </table>
    </fieldset>
    <?php } ?>
    <?php if($_REQUEST['sec'] == "output") { ?>
    <!-- output-->
    <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
    <legend class="style37"><strong>List of output files</strong></legend>
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><div align="center"><font color="#FFFFFF">Description</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><div align="left"><font color="#FFFFFF">Variable Name</font></div></th>
        <th align="left" valign="middle" bgcolor="#000000" scope="col"><font color="#FFFFFF">|</font></th>
        <th align="left" bgcolor="#000000" scope="col"><font color="#FFFFFF">Filename</font></th>
      </tr>
      <?php
		foreach($_SESSION['output']['des'] as $v_name => $value) {
			//if(substr($v_name, 0, 3) == "ETA") 
	  ?>
      <tr>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><?=$value?></td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col">&nbsp;</td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><?=$v_name?></td>
        <td scope="col" valign="middle" >&nbsp;</td>
        <td align="left" scope="col"><?=$_SESSION['output']['value'][$v_name]?></td>
      </tr>
      <?php
      		//}
		}
	  ?>
    </table>
    </fieldset>
    <?php } ?>
    <?php if($_REQUEST['sec'] == "ob_point") { ?>
    <?php
    	$sql = "SELECT `job_profile`.`id` AS `jid`, `sim_result`.`id` AS `sid`, `observe_point`.`observ_point_id` AS `oid`, `observe_point`.`observ_point_id`, `observe_point`.`name`, `observe_point`.`lat_1`, `observe_point`.`lat_2`, `observe_point`.`lat_3`, `observe_point`.`long_1`, `observe_point`.`long_2`, `observe_point`.`long_3` FROM `observe_point`, `job_profile`, `sim_point_val`, `sim_result` WHERE `observe_point`.`observ_point_id` = `sim_point_val`.`id_point` AND `sim_point_val`.`sim_result_id` = `job_profile`.`sim_result_id` AND `job_profile`.`sim_result_id` = `sim_result`.`id` AND `job_profile`.`id` = ".$_REQUEST['job_id'];
		$result = mysql_query($sql, $connection);
		$no_of_point = mysql_num_rows($result);
		if($no_of_point > 0) {
		
	?>
    <!-- ob_point-->
    <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
    <legend class="style37"><strong>List of observation points (<?=$no_of_point?>)</strong></legend>
    <table border="0" cellpadding="4" cellspacing="0">
      <tr>
        <th rowspan="2" align="left" valign="middle" bgcolor="#7B869A" style="border-right:#CCCCCC solid 1px" scope="col"><div align="center"><font color="#FFFFFF">ID.</font></div></th>
        <th rowspan="2" align="left" valign="middle" bgcolor="#7B869A" style="border-right:#CCCCCC solid 1px" scope="col"><div align="center"><font color="#FFFFFF">Name</font></div></th>
        <th colspan="14" align="left" valign="middle" bgcolor="#7B869A" scope="col" style="border-bottom:#CCCCCC solid 1px"><div align="center"><font color="#FFFFFF">Location</font></div></th>
      </tr>
      <tr>
        <th colspan="7" align="left" valign="middle" bgcolor="#7B869A" style="border-right:#CCCCCC solid 1px" scope="col"><div align="center"><font color="#FFFFFF">Location</font></div></th>
        <th colspan="7" align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Location</font></div></th>
      </tr>
      <?php
     	while($obj = mysql_fetch_object($result)) {
	  ?>
      <tr>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="left"><?=$obj->oid?></div></td>
        <td align="left" valign="middle" bgcolor="#EBEBEB" scope="col"><div align="left"><font color="#000066"><strong><?=$obj->name?></strong></font></div></td>
        <td align="left" scope="col"><div align="right"></div></td>
        <td align="left" scope="col"><div align="right"><font color="#990000">
            <?=$obj->lat_1?>
        </font></div></td>
        <td align="left" scope="col"><div align="right">°</div></td>
        <td align="left" scope="col"><div align="right"><font color="#990000">
            <?=$obj->lat_2?>
        </font></div></td>
        <td align="left" scope="col"><div align="right">'</div></td>
        <td align="left" scope="col"><div align="right"><font color="#990000">
            <?=$obj->lat_3?>
        </font></div></td>
        <td align="left" scope="col" style="border-right:#7B869A solid 1px"><div align="right">''</div></td>
        <td align="left" scope="col"><div align="right"></div></td>
        <td align="left" scope="col"><div align="right"><font color="#990000">
          <?=$obj->long_1?>
        </font></div></td>
        <td align="left" scope="col"><div align="right">°</div></td>
        <td align="left" scope="col"><div align="right"><font color="#990000">
          <?=$obj->long_2?>
        </font></div></td>
        <td align="left" scope="col"><div align="right">'</div></td>
        <td align="left" scope="col"><div align="right"><font color="#990000">
          <?=$obj->long_3?>
        </font></div></td>
        <td align="left" scope="col"><div align="right">''</div></td>
      </tr>
      <?php
      	}
	  ?>
    </table>
    </fieldset>
    <?php } 
	} ?>
  </DIV>
  <DIV class="clear asd"></DIV>
</DIV>
</BODY>
</HTML>
