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
	require_once('../../library/connectdb.inc.php');

	if($_REQUEST['act'] == "get_summary") {
		$sql = "SELECT * FROM `ds_input_deform`";
		$res = mysql_query($sql, $connection);
		$file_contents = "Fault_No.\tFilenamemax.\tlength_fault\twidth_fault\tepi_depth\tdislocate\tdip_angle\tstrike_angle\trake_angle\tlong_epi\t	lat_epi\tmax_upward\tmax_long\tmax_lat\tmin_downward\tmin_long\tmin_lat\n";
/**1 0.419 99.6500000 -3.9166667 -0.194 99.9500000 -3.5500000
2 0.419 100.0166667 -3.6166667 -0.195 100.3166667 -3.2500000"; */
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
	
	/* Delete deformation file */
	if($_REQUEST['CMD'] == "del" && $_REQUEST['param'] > 0) {
		$sql = "DELETE FROM ds_input_deform WHERE id=".$_REQUEST['param'];
		if(mysql_query($sql, $connection)) {
			echo "<script language=javascript>document.reload();</script>";
		}else
			echo "<script language=javascript>alert('Could not delete id ".$_REQUEST['param']." ?');</script>";
	}
	
	/* get total deformation file */
	$limit = 10;
	if(!isset($_REQUEST['total'])) {
		$sql = "SELECT * FROM ds_input_deform";
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
	
	$str_next = "document.location.href='".$_SERVER['PHP_SELF']."?btn=next&start=".($start+$limit)."&limit=".$limit."&curr_page=".($curr_page+1)."&total=".$total."';";
	$selected_page[$_REQUEST['curr_page']-1] = " selected";
	
	for($i=0; $i<$no_page; $i++) {
		$str_jump_page[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?btn=next&start=".($i * $limit)."&limit=".$limit."&curr_page=".($i+1)."';";
	}
	
	if( ($start-$limit) < 0) {
		$start = 0;
		$curr_page = 1;
		$str_back = "document.location.href='".$_SERVER['PHP_SELF']."?btn=back&start=".$start."&limit=".$limit."&curr_page=".$curr_page."&total=".$total."';";
	}else {
		$str_back = "document.location.href='".$_SERVER['PHP_SELF']."?btn=back&start=".($start-$limit)."&limit=".$limit."&curr_page=".($curr_page-1)."&total=".$total."';";
	}
	
	$str_back_end = "document.location.href='".$_SERVER['PHP_SELF']."?btn=back_end&start=0&limit=10&curr_page=1&total=".$total."'";
	$str_next_end = "document.location.href='".$_SERVER['PHP_SELF']."?btn=next_end&start=".($limit * ($no_page-1))."&limit=10&curr_page=".$no_page."&total=".$total."'";

	$sql = "SELECT * FROM ds_input_deform LIMIT ".$start.", ".$limit;
	$result = mysql_query($sql, $connection);
	if($result) {
		if(mysql_num_rows($result) > 0) {
			$i = 0;
			while($obj = mysql_fetch_object($result)) {
				$row_deform['id'][$i] = $obj->id;
				$row_deform['filename'][$i] = $obj->filename;
				$row_deform['description'][$i] = $obj->description;
				$row_deform['path'][$i] = $obj->path;
				$row_deform['glob_x_long'][$i] = $obj->glob_x_long;
				$row_deform['glob_y_lat'][$i] = $obj->glob_y_lat;
				$row_deform['grid_space'][$i] = $obj->grid_space;
				$row_deform['org_x'][$i] = $obj->org_x;
				$row_deform['org_y'][$i] = $obj->org_y;
				$row_deform['coord_long_1'][$i] = $obj->coord_long_1;
				$row_deform['coord_long_2'][$i] = $obj->coord_long_2;
				$row_deform['coord_lat_1'][$i] = $obj->coord_lat_1;
				$row_deform['coord_lat_2'][$i] = $obj->coord_lat_2;
				$row_deform['length'][$i] = $obj->length;
				$row_deform['length_fault'][$i] = $obj->length_fault;
				$row_deform['width_fault'][$i] = $obj->width_fault;
				$row_deform['epi_depth'][$i] = $obj->epi_depth;
				$row_deform['dislocate'][$i] = $obj->dislocate;
				$row_deform['dip_angle'][$i] = $obj->dip_angle;
				$row_deform['strike_angle'][$i] = $obj->strike_angle;
				$row_deform['rake_angle'][$i] = $obj->rake_angle;
				$row_deform['long_epi'][$i] = $obj->long_epi;
				$row_deform['lat_epi'][$i] = $obj->lat_epi;
				$row_deform['max_val'][$i] = $obj->max_val;
				$row_deform['min_val'][$i] = $obj->min_val;
				$row_deform['max_lat'][$i] = $obj->max_lat;
				$row_deform['max_long'][$i] = $obj->max_long;
				$row_deform['min_lat'][$i] = $obj->min_lat;
				$row_deform['min_long'][$i] = $obj->min_long;
				$row_deform['create_date'][$i++] = $obj->create_date;
			}
		}
	}
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
	position: absolute;
	top: 10%;
	left: 15%;
	right: 15%;
	width: 70%;
	height: 80%;
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
			document.location.href='ds_list_sim.php?section=4';
		}
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
        <strong>Select input type:</strong>&nbsp; <span style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
        <select name="input_type" id="input_type" onChange="javascript: ds_select_input_type(this.value);">
          <option value="sim">&nbsp;&nbsp;Simulation&nbsp;&nbsp;</option>
          <option value="vis" selected>&nbsp;&nbsp;Visualization&nbsp;&nbsp;</option>
        </select>
        </span>
        <input type="button" onClick="javascript: document.location.href='<?=$_SERVER['PHP_SELF']?>'" value="Reload">
        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x;">
        <legend class="style37"><strong>Bathymetry and topography file</strong></legend>
        <table border="0" cellpadding="5" cellspacing="3" class=" tbl_border fs14px">
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td class="tbl_border_right">!</td>
            <td class="tbl_border_right">ID</td>
            <td class="tbl_border_right">Filename</td>
            <td class="tbl_border_right">Max. Upward</td>
            <td class="tbl_border_right">Max. Lat</td>
            <td class="tbl_border_right">Max. Long</td>
            <td class="tbl_border_right">Min. Downward</td>
            <td class="tbl_border_right">Min. Lat</td>
            <td class="tbl_border_right">Min. Long</td>
            <td class="">Action</td>
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
			$str .= "Max. Upward = ".$row_deform['max_val'][$i]."<br>";
			$str .= "Max. Latitude = ".$row_deform['max_lat'][$i]."<br>";
			$str .= "Max. Longitude = ".$row_deform['max_long'][$i]."<br>";
			$str .= "Min. Downward = ".$row_deform['min_val'][$i]."<br>";
			$str .= "Min. Latitude = ".$row_deform['min_lat'][$i]."<br>";
			$str .= "Min. Longitude = ".$row_deform['min_long'][$i]."<br>";
		  	if($i%2) {
		  ?>
          <tr align="center" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()" id="id_<?=$row_deform['id'][$i]?>">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_deform['id'][$i]?>]" id="chk[<?=$row_deform['id'][$i]?>]" onSelect="javascript: id_<?=$row_deform['id'][$i]?>.style.background='#D0EFFB';"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_deform['id'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="#docu" onMouseOver="Tip('<?=$str?>', WIDTH, 400, TITLE, '<b>Filename:</b> <?=$row_deform['filename'][$i]?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                <?=$row_deform['filename'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['max_val'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['max_lat'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['max_long'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['min_val'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['min_lat'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['min_long'][$i]?>
              </div></td>
            <td class="tbl_border_top"><a href="javascript: void(0)" onClick="javascript: document.location.href='download_file.php?download_filepath=<?=$row_deform['path'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_deform['filename'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del&param=<?=$row_deform['id'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
		  	}else {
			?>
          <tr align="center" bgcolor="#EBEBEB"onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background=''; UnTip()">
            <td class="tbl_border_top tbl_border_right"><input type="checkbox" name="chk[<?=$row_deform['id'][$i]?>]" id="chk[<?=$row_deform['id'][$i]?>]"></td>
            <td class="tbl_border_top tbl_border_right"><?=$row_deform['id'][$i]?></td>
            <td class="tbl_border_top tbl_border_right"><div align="left"><a href="#docu" onMouseOver="Tip('<?=$str?>', WIDTH, 400, TITLE, '<b>Filename:</b> <?=$row_deform['filename'][$i]?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()">
                <?=$row_deform['filename'][$i]?>
                </a> </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['max_val'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['max_lat'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['max_long'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['min_val'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['min_lat'][$i]?>
              </div></td>
            <td class="tbl_border_top tbl_border_right"><div align="left">
                <?=$row_deform['min_long'][$i]?>
              </div></td>
            <td class="tbl_border_top"><a href="javascript: void(0)" onClick="javascript: document.location.href='download_file.php?download_filepath=<?=$row_deform['path'][$i]?>';"><a href="javascript: void(0)" onClick="javascript: document.location.href='download_file.php?download_filepath=<?=$row_deform['path'][$i]?>';">download</a>&nbsp;|&nbsp;<a href="javascript: void(0);" onClick="javascript: if(confirm('Do you want to delete `<?=$row_deform['filename'][$i]?>` ?')) { location.href='<?=$_SERVER['PHP_SELF']?>?CMD=del&param=<?=$row_deform['id'][$i]?>'; }">delete</a></td>
          </tr>
          <?php
			}
		  }
		  if(count($row_deform['id']) == 0) {
		  	?>
          <tr align="center">
            <td colspan="10" bgcolor="#EBEBEB" class="tbl_border_top tbl_border_right">(no data)</td>
          </tr>
          <?php
		  }
		  ?>
        </table>
        <br>
        <div align="left">
          <input type="button" value="&lt;&lt;" onClick="javascript: <?=$str_back_end?>">
          &nbsp;&nbsp;
          <input type="button" value="&lt;" onClick="javascript: <?=$str_back?>">
          &nbsp;&nbsp;Page number :
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
          &nbsp;&nbsp;
          <input type="button" value="&gt;" onClick="javascript: <?=$str_next?>">
          &nbsp;&nbsp;
          <input type="button" value="&gt;&gt;" onClick="javascript: <?=$str_next_end?>">
          &nbsp;
          <input type="button" value="Get summary" onClick="javascript: alert('Not available in this time.');/*location.href='<?=$_SERVER['PHP_SELF']?>?act=get_summary';*/">
          Total<font color="#990000">&nbsp;<b>
          <?=$total?>
          </b></font>&nbsp;subfaults. </div>
        </fieldset>
        <br>
        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:">
        <legend class="style37"><strong>Region file</strong></legend>
        <table border="0" cellpadding="5" cellspacing="3" class=" tbl_border fs14px">
          <tr align="center" bgcolor="#FFFFCC" class="td-0" >
            <td class="tbl_border_right">ID</td>
            <td class="tbl_border_right">Filename</td>
            <td class="tbl_border_right">Latitude</td>
            <td class="tbl_border_right">Longitude</td>
            <td class="tbl_border_right">Grid&nbsp;Size</td>
            <td class="tbl_border_right">Time&nbsp;Interval</td>
            <td class="">Create&nbsp;Date</td>
          </tr>
          <tr align="center">
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top">&nbsp;</td>
          </tr>
          <tr align="center">
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top tbl_border_right">&nbsp;</td>
            <td class="tbl_border_top">&nbsp;</td>
          </tr>
        </table>
        </fieldset>
        <br>
        <input type="button" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'" value="Add new input">
        &nbsp;
        <input type="button" onClick="javascript: document.location.href='<?=$_SERVER['PHP_SELF']?>'" value="Reload">
        <div id="light" class="white_content">
          <iframe src="importer.php" style="border-width:0px;" width="100%" height="100%">test</iframe>
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
