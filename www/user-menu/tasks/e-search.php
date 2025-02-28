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
	function confirm_del_vis(name, id) {
		if(confirm('Do you really want to delete `'+name+'` ?'))
		{
			document.location.href = '../library/delete-vis.php?id='+id;
		}else
			return;
	}
	
	function swap_pane() {
		if(sim_pane.style.display == '')
			alert('sim_pane is openned');
		else
			alert('test');
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
DIV#adv_box {
	BORDER-RIGHT: #b6d6e1 1px solid;
	PADDING-RIGHT: 0px;
	BORDER-TOP: #b6d6e1 1px solid;
	PADDING-LEFT: 20px;
	PADDING-BOTTOM: 5px;
	padding-right:20px;
	MARGIN: 7px 0px 10px;
	BORDER-LEFT: #b6d6e1 1px solid;
	PADDING-TOP: 12px;
	BORDER-BOTTOM: #b6d6e1 1px solid;
	BACKGROUND-COLOR: #eef6fb
}
.style47 {
	color: #003366
}
-->
</style>
<script language="javascript">
	function hide() {
		document.getElementById('search_tbl').style.display == 'none'
		document.getElementById('hide').style.display = 'none';
		document.getElementById('unhide').style.display = '';
	}
	
	function unhide() {
		document.getElementById('search_tbl').style.display == ''
		document.getElementById('hide').style.display = '';
		document.getElementById('unhide').style.display = 'none';	
	}
	
	/*function select_sim_result(sim_rest_box, sel_id) {
		if(document.getElementById(sel_id).checked == true) {
			document.getElementById(sel_id).checked=false; 
			document.getElementById(sim_rest_box).style.background='';
		}else {
			document.getElementById(sel_id).checked=true; 
			document.getElementById(sim_rest_box).style.background='#D1DCE9';
		}
	}*/
	
	function select_sim_result(sim_rest_box) {
		if(document.getElementById(sim_rest_box).style.background == "#D1DCE9") {
			document.getElementById(sim_rest_box).style.background = '';
		}else {
			document.getElementById(sim_rest_box).style.background = '#D1DCE9';
		}
	}	
	
	function clear_search_form() {
		document.getElementById('f_name').value = '';
	}
	function jump(v){ //v3.0
		document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id='+v;
	 // if (restore) selObj.selectedIndex=0;
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Search simulation and visualization results<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <?php
			require('../../library/connectdb.inc.php');
			
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
			
			if(isset($_POST['name'])) {
				$_SESSION['name'] = $_POST['name'];
				$_SESSION['lat'] = $_POST['lat'];
				$_SESSION['long'] = $_POST['long'];
				$_SESSION['radius'] = $_POST['radius'];
				$_SESSION['min_m'] = $_POST['mag_min'];
				$_SESSION['max_m'] = $_POST['mag_max'];
				$_SESSION['depth'] = $_POST['depth'];
				if(strlen($_SESSION['name']) > 0) {
					$_part[] = " `name` LIKE '%".$_SESSION['name']."%'";
				}
			}else {
				$sql = "SELECT MAX(`magnitude`) AS `max_m`, MIN(`magnitude`) AS `min_m` FROM `sim_result` WHERE `grp_id` = ".$_REQUEST['grp_id'];
				$res = mysql_query($sql, $connection) or die('! query failed.');
				if(mysql_num_rows($res) == 1) {
					$obj = mysql_fetch_object($res);
					$_SESSION['min_m'] = round($obj->min_m, 2);
					$_SESSION['max_m'] = round($obj->max_m, 2);
				}
			}
		?>
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operations :&nbsp; </strong><font color="#000099"> Select group</font>
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
          | <a href="<?=$_SERVER['PHP_SELF']?>?section=4"><font color="#000099">Reload</font></a><br>
          <!--<input name="search_from" type="radio" id="radio" value="imported_results" checked>
        <a href="<?=$_SERVER['PHP_SELF']?>?section=4"><font color="#000099">From  simulation results</font></a><br>
        <font color="#000099">
        <input type="radio" name="search_from" id="radio3" value="on_demand" disabled>
        From on demand visualization</font>-->
        </div>
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <form action="<?=$_SERVER['PHP_SELF']?>?section=4&grp_id=<?=$_REQUEST['grp_id']?>" method="post" name="search">
          <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
          <legend><strong class="style37">Enter necessary information</strong>&nbsp;<a href="javascript: void(0);" onClick="javascript: document.getElementById('search_tbl').style.display='none'; document.getElementById('unhide').style.display=''; this.style.display='none';" id="hide">Hide</a><a href="javascript: void(0);" onClick="javascript: document.getElementById('search_tbl').style.display=''; document.getElementById('hide').style.display=''; document.getElementById('unhide').style.display='none';" id="unhide" style="display:none">Unhide</a></legend>
          <table border="0" cellpadding="4" cellspacing="0" id="search_tbl" style="display:">
            <tr>
              <th colspan="5" align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><u>Search by</u> :</th>
            </tr>
            <!-- <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">Description</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="description2" type="text" style="width:350px" id="description" value="<?=(isset($_SESSION['search']['description'])? $_SESSION['search']['description']:"(description)")?>" onMouseMove="javascript: if(this.value=='(description)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(description)';"></th>
            </tr>-->
            <!--<tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47"> Name </span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong> </strong>
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="name" type="text" style="width:350px; text-align:center; font-weight:bold" id="f_name" value="<?=$_SESSION['name']?>"></td>
                  </tr>
                </table></th>
            </tr>-->
      
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">Earthquake info.</span></th>
              <th valign="middern" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" bgcolor="#F0F0F0" scope="col">&nbsp;
                  <?php
              	$time_now = time();
				$year = date("Y", $time_now);
				$date = date('j/m/'.$year, $time_now);
				$time = date('H:i:s', $time_now);
			  ?></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Date</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="date" type="text" style="width:100px; text-align:center; font-weight:bold" onClick="displayDatePicker('date');"  id="date" value="<?=!isset($_SESSION['date']) ? $date : $_SESSION['date']?>"></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Time</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="time" type="text" style="width:100px; text-align:center; font-weight:bold" id="time" value="<?=!isset($_SESSION['time']) ? $time : $_SESSION['time']?>"></th>
            </tr>
            
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">Location :</span></th>
              <th valign="middern" bgcolor="#F0F0F0" scope="col"><input name="name" type="hidden" style="width:350px; text-align:center; font-weight:bold" id="f_name" value="<?=$_SESSION['name']?>"></th>
              <th align="left" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Latitude</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="lat" type="text" style="width:100px; text-align:center; font-weight:bold" id="lat" value="<?=$_SESSION['lat']?>"></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Longitude</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="long" type="text" style="width:100px; text-align:center; font-weight:bold" id="long" value="<?=$_SESSION['long']?>"></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Redius</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="radius" type="text" id="radius" style="width:100px; text-align:center; font-weight:bold" value="<?=$_SESSION['radius']?>"></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">Magnitude</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="mag_min" type="text" id="mag_min" style="width:45px; text-align:center; font-weight:bold" value="<?=number_format($_SESSION['min_m'], 1)?>">
                -
                <input name="mag_max" type="text" id="mag_max" style="width:45px; text-align:center; font-weight:bold" value="<?=number_format($_SESSION['max_m'], 1)?>">
                [min-max]</th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col"><span class="style47">Depth (km)</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="depth" type="text" id="depth" style="width:100px; text-align:center; font-weight:bold;" value="<?=$_SESSION['depth']?>"></th>
            </tr>
            </tr>
          </table>
          </fieldset>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <input name="search_btn" type=submit class=butenter id=search_btn style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Submit Query">
        </form>
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <div id="search_result_box"style="background-color:#FFFFCC; padding:4px 4px 4px 4px; border-top:#999999 1px solid"> <strong> <strong>
          <?php
				require_once('../../library/connectdb.inc.php');
					
					$expr = array();
									
					$sq = "SELECT * FROM `sim_result` WHERE ";
					$sq_c[]= " uid=".$_SESSION['uid'];
					if(strlen($_SESSION['name'])) {
						$sq_c[] = " `name` LIKE '%".$_SESSION['name']."%'";
					}
					
					if((float)($_SESSION['min_m']) > 0 && (float)($_SESSION['max_m']) > 0) {
						$c = " (`magnitude` >= ".$_SESSION['min_m']." AND `magnitude` <= ".$_SESSION['max_m'].") ";
						$sq_c[] = $c;
					}
					
					if((int)($_SESSION['depth']) > 0) {
						$sq_c[] = " `depth` = ".$_SESSION['depth'];
					}
					
					if(strlen((string)($_SESSION['lat'])) > 0 ) {
						if(strlen((string)($_SESSION['radius'])) == 0) {
							$c = "`decimal_lat` LIKE '%".(float)($_SESSION['lat'])."%'";
						}
						
						if(strlen((string)($_SESSION['radius'])) > 0) {
							$c = " (`decimal_lat` >= ".((float)($_SESSION['lat']) - (float)($_SESSION['radius']));
							$c .= " AND `decimal_lat` <= ".((float)($_SESSION['lat']) + (float)($_SESSION['radius'])).") ";
						}
						$sq_c[] = $c;
					}
					
					if(strlen((string)($_SESSION['long'])) > 0 ) {
						if(strlen((string)($_SESSION['radius'])) == 0) {
							$c = "`decimal_long` LIKE '%".(float)($_SESSION['long'])."%'";
						}
						
						if(strlen((string)($_SESSION['radius'])) > 0) {
							$c = " (`decimal_long` >= ".((float)($_SESSION['long']) - (float)($_SESSION['radius']));
							$c .= " AND `decimal_long` <= ".((float)($_SESSION['long']) + (float)($_SESSION['radius'])).") ";
						}
						$sq_c[] = $c;
					}
					
					$sq .= implode(" AND ", $sq_c)." AND `grp_id` = ".$_REQUEST['grp_id']." ORDER BY datetime DESC";
					/*show searching results per-page*/
					$per_page = 10; 
					
					if(!$_REQUEST['btn_r'])
						$page = 1;
					else
						$page = $_REQUEST['curr_page_r'];
					
					$res_count_page = mysql_query($sq, $connection);
					$page_start = ($per_page * $page)- $per_page;
					$num_rows = mysql_num_rows($res_count_page);
					
					if($num_rows <= $per_page){
						$num_page = 1;
					}elseif(($num_rows%$per_page) == 0){
						$num_page = ($num_rows/$per_page);
					}else{
						$num_page = ($num_rows/$per_page) + 1;
						$num_page = (int)$num_page;
					}
						
					$sq .= " LIMIT ".$page_start.", ".$per_page;
	
					/* check Has `button` was clicked */
					if(!isset($_REQUEST['btn_r'])) {
						$curr_page_r = 1;
					}else {
						$curr_page_r = $_REQUEST['curr_page_r'];
					} 
					if($curr_page_r == $num_page)
						$curr_page_r = $curr_page_r-1;
					$str_next_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=4&grp_id=".$_REQUEST['grp_id']."&btn_r=next&curr_page_r=".($curr_page_r+1)."&name=".$_SESSION['search']['name']."&desc=".$_SESSION['search']['desc']."&lat=".$_SESSION['search']['lat']."&long=".$_SESSION['search']['long']."&radius=".$_SESSION['search']['radius']."&mag_min=".$_SESSION['search']['mag_min']."&mag_max=".$_SESSION['search']['mag_max']."&depth=".$_SESSION['search']['depth']."#search_result_box';";
					$selected_page_r[$_REQUEST['curr_page_r']-1] = " selected";
					
					for($i=0; $i<$num_rows; $i++) {
						$str_jump_page_r[($i+1)] = "document.location.href='".$_SERVER['PHP_SELF']."?section=4&grp_id=".$_REQUEST['grp_id']."&btn_r=next&curr_page_r=".($i+1)."&name=".$_SESSION['search']['name']."&desc=".$_SESSION['search']['desc']."&lat=".$_SESSION['search']['lat']."&long=".$_SESSION['search']['long']."&radius=".$_SESSION['search']['radius']."&mag_min=".$_SESSION['search']['mag_min']."&mag_max=".$_SESSION['search']['mag_max']."&depth=".$_SESSION['search']['depth']."#search_result_box';";
					}
					if($page == 1){
						//$start_r = 0;
						//$curr_page_r = 1;
						$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=4&grp_id=".$_REQUEST['grp_id']."&btn_r=back&curr_page_r=".$page."&name=".$_SESSION['search']['name']."&desc=".$_SESSION['search']['desc']."&lat=".$_SESSION['search']['lat']."&long=".$_SESSION['search']['long']."&radius=".$_SESSION['search']['radius']."&mag_min=".$_SESSION['search']['mag_min']."&mag_max=".$_SESSION['search']['mag_max']."&depth=".$_SESSION['search']['depth']."#search_result_box';";
					}else {
						$str_back_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=4&grp_id=".$_REQUEST['grp_id']."&btn_r=back&curr_page_r=".($page-1)."&name=".$_SESSION['search']['name']."&desc=".$_SESSION['search']['desc']."&lat=".$_SESSION['search']['lat']."&long=".$_SESSION['search']['long']."&radius=".$_SESSION['search']['radius']."&mag_min=".$_SESSION['search']['mag_min']."&mag_max=".$_SESSION['search']['mag_max']."&depth=".$_SESSION['search']['depth']."#search_result_box';";
					}
					
					$str_back_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=4&grp_id=".$_REQUEST['grp_id']."&btn_r=back_end&curr_page_r=1&name=".$_SESSION['search']['name']."&desc=".$_SESSION['search']['desc']."&lat=".$_SESSION['search']['lat']."&long=".$_SESSION['search']['long']."&radius=".$_SESSION['search']['radius']."&mag_min=".$_SESSION['search']['mag_min']."&mag_max=".$_SESSION['search']['mag_max']."&depth=".$_SESSION['search']['depth']."#search_result_box'";
					
					$str_next_end_r = "document.location.href='".$_SERVER['PHP_SELF']."?section=4&grp_id=".$_REQUEST['grp_id']."&btn_r=next_end&curr_page_r=".$num_page."&name=".$_SESSION['search']['name']."&desc=".$_SESSION['search']['desc']."&lat=".$_SESSION['search']['lat']."&long=".$_SESSION['search']['long']."&radius=".$_SESSION['search']['radius']."&mag_min=".$_SESSION['search']['mag_min']."&mag_max=".$_SESSION['search']['mag_max']."&depth=".$_SESSION['search']['depth']."#search_result_box'";
					
					#echo $sq;
					$res = mysql_query($sq, $connection);
					if($res) {	
						if(mysql_num_rows($res) != NULL ) {					
							$no = mysql_num_rows($res);
							for($a = 0; $a <= $no; $a++) {
								$obj = mysql_fetch_object($res);
								$sim_result[$a]['id'] = $obj->id;
								$sim_result[$a]['job_profile_id'] = $obj->job_profile_id;
								$sim_result[$a]['name'] = $obj->name;
								$sim_result[$a]['description'] = strlen($obj->desc) < 10 ? "(no specified description)" : $obj->desc;
								$sim_result[$a]['submit_date'] = $obj->datetime;
								$sim_result[$a]['domain'] = strlen($obj->domain) < 1 ? "(no specified Tsunami's domain)" : $obj->domain;
								$sim_result[$a]['source'] = strlen($obj->source) < 1 ? "(no specified Tsunami's source)" : $obj->source;
								$sim_result[$a]['observ_area'] = strlen($obj->observ_area) < 1 ? "(no specified Tsunami's observation area)" : $obj->observ_area;
								$sim_result[$a]['magnitude'] = $obj->magnitude;
								$sim_result[$a]['depth'] = $obj->depth;
								$sim_result[$a]['lat_degree'] = $obj->lat_degree;
								$sim_result[$a]['lat_lipda'] = $obj->lat_lipda;
								$sim_result[$a]['lat_Philipda'] = $obj->lat_Philipda;
								$sim_result[$a]['long_degree'] = $obj->long_degree;
								$sim_result[$a]['long_lipda'] = $obj->long_lipda;
								$sim_result[$a]['long_Philipda'] = $obj->long_Philipda;
								$sim_result[$a]['decimal_lat'] = $obj->decimal_lat;
								$sim_result[$a]['decimal_long'] = $obj->decimal_long;								
							}
						}
						else
							$no = 0;
					}
		?>
          </strong>
          <table width="10" height="1" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <strong>Results&nbsp;:&nbsp;</strong>found <font color="#FF0000">
          <?=$num_rows?>
          </font> record(s) <font color="#FF0000">
          <?=$num_page?>
          </font> Pages <br>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <div id="adv_box" style="">
            <?php
			for($g=0; $g<$no; $g++)
			{
			?>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="sim_rest_<?=$g?>">
              <tr onMouseOver="javascript: this.style.background='#D0EFFB'; this.style.borderBottom='#A4ED8B 1px solid'; this.style.borderTop='#A4ED8B 1px solid';  document.getElementById('s<?=$sim_result[$g]['id']?>').style.display='';" onMouseOut="javascript: this.style.background=''; this.style.borderBottom=''; this.style.borderTop=''; document.getElementById('s<?=$sim_result[$g]['id']?>').style.display='none';" onClick="javascript: select_sim_result('sim_rest_<?=$g?>') /* select_sim_result('sim_rest_<?=$g?>', 'sel_[<?=$g?>]') */">
                <td><table border="0" cellpadding="0" cellspacing="1">
                    <tr>
                      <!--<td rowspan="5" valign="top"><input type="checkbox" name="sel[<?=$g?>]" id="sel_[<?=$g?>]" onClick="javascript: document.getElementById('sim_rest_<?=$g?>').style.background='#D1DCE9';"></td>-->
                      <td rowspan="5" valign="top">&nbsp;</td>
                      <td rowspan="5" valign="top"><a href="../bulletin/general.php?id=<?=$sim_result[$g]['id']?>&job_profile_id=<?=$sim_result[$g]['job_profile_id']?>">
                        <?php
                    $today = date('d', time());
					$cd = date('d', $sim_result[$g]['submit_date']);
					if($sim_result[$g]['magnitude'] <= 7.5) {
					?>
                        <table width="49" height="51" border="0" cellpadding="0" cellspacing="0" background="../../image/blog-calendar2.png">
                          <tr>
                            <td height="18"><div align="center"><font color="white"> M
                                <?=number_format($sim_result[$g]['magnitude'], 1)?>
                                </font></div></td>
                          </tr>
                          <tr>
                            <td height="33"><div align="center"> D
                                <?=$sim_result[$g]['depth']?>
                              </div></td>
                          </tr>
                        </table>
                        <?php }else {
							if($sim_result[$g]['magnitude'] > 7.5) {
						?>
                        <table width="49" height="51" border="0" cellpadding="0" cellspacing="0" background="../../image/blog-calendar.png">
                          <tr>
                            <td height="18"><div align="center"><font color="white"> M
                                <?=$sim_result[$g]['magnitude']?>
                                </font></div></td>
                          </tr>
                          <tr>
                            <td height="33"><div align="center"> D
                                <?=$sim_result[$g]['depth']?>
                              </div></td>
                          </tr>
                        </table>
                        <?php } 
					}
					?>
                        </a></td>
                      <td rowspan="5" valign="top">&nbsp;</td>
                      <td align="left" valign="top">                        </td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><table width="0" border="0" cellspacing="1" cellpadding="0">
                          <tr>
                            <td>Magnitude: <font color="#0000CC">
                            <?=number_format($sim_result[$g]['magnitude'], 1)?>
                            </font>, Depth: <font color="#0000CC">
                            <?=$sim_result[$g]['depth']?>
                            </font>km.</td>
                          </tr>
                          <tr>
                            <td>Latitude:<font color="#0000CC">
                            <?=$sim_result[$g]['decimal_lat']?>
                            <!--°&nbsp;
                      <?=$sim_result[$g]['lat_lipda']?>
                      '&nbsp;
                      <?=$sim_result[$g]['lat_Philipda']?>" N-->
                            </font>,&nbsp;Longitude: <font color="#0000CC">
                            <?=$sim_result[$g]['decimal_long']?>
                            <!--°&nbsp;
                    <?=$sim_result[$g]['long_lipda']?>
                    '&nbsp;
                    <?=$sim_result[$g]['long_Philipda']?>
                    " E-->
                            </font> </td>
                          </tr>
                                              </table></td>
                    </tr>
                    
                    <!--<tr>
                    <td align="left" valign="top">Create Date: <font color="#003399"><em>
                      <?=date('h:i:s d/m/Y', $sim_result[$g]['submit_date']);?>
                      </em></font></td>
                  </tr>-->
                </table></td>
                <td><div id="s<?=$sim_result[$g]['id']?>" style="display:none">
                    <div align="right"><a href="bulletin.php?section=4.1&id=<?=$sim_result[$g]['id']?>&grp_id=<?=$_REQUEST['grp_id']?>">Create&nbsp;Bulletin</a>&nbsp;</div>
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
          </div>
          <!-- <input name="interpulate_btn" type=button class=butenter id=interpulate_btn style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Interpolate selected item"> -->
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <?php if($num_rows != 0){?>
          <div align="left">
            <input type="button" value="&lt;&lt;" onClick="javascript: <?=$str_back_end_r?>">
            &nbsp;
            <input type="button" value="&lt;" onClick="javascript: <?=$str_back_r?>">
            &nbsp;Page number :
            <select name="select" id="select">
              <?php
          for($p=1; $p<=$num_page; $p++){
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
            <?=$num_rows?>
            </b></font>&nbsp;record(s). </div>
          <?php }?>
        </div>
        <br>
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
