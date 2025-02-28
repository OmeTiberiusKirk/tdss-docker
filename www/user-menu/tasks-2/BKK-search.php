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
<script language="javascript">
	function confirm_del_vis(name, id)
	{
		if(confirm('Do you really want to delete `'+name+'` ?'))
		{
			document.location.href = '../library/delete-vis.php?id='+id;
		}else
			return;
	}
	
	function swap_pane()
	{
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
.style3 {
	color: #000000
}
.style4 {
	color: #FFFFFF
}
-->
</style>
<style type="text/css">
<!--
.style4 {
	color: #009966
}
.style5 {
	color: #FF0000
}
.style7 {
	color: #990000;
	font-weight: bold;
	font-size: 12px;
}
.style36 {
	color: #33CCFF
}
.style39 {
	font-size: 18px
}
.style41 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FF9900;
	font-size: small;
	font-weight: bold;
}
.style43 {
	font-size: small
}
.style46 {
	color: #626262
}
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
	
	function select_sim_result(sim_rest_box, sel_id) {
		if(document.getElementById(sel_id).checked == true) {
			document.getElementById(sel_id).checked=false; 
			document.getElementById(sim_rest_box).style.background='';
		}else {
			document.getElementById(sel_id).checked=true; 
			document.getElementById(sim_rest_box).style.background='#D1DCE9';
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
    <br><center><table><tr><td><div align="center">&nbsp;<img src="../../logo.jpg" width="100" height="111" style="border:3px" usemap="#Map"></div></td>
    </tr><tr><td><div align="center" class="style2">&nbsp;Thai National Grid Center</div></td>
    </tr></table></center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Search simulation and visualization results<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <?php
			if(isset($_POST['search_btn'])) {
				#echo "<pre>";
				$sql = "SELECT * FROM sim_result  WHERE  uid=".$_SESSION['uid'];
				if($_POST['name'] != "(name)") {
					$sql .= " AND `name` LIKE '%".$_POST['name']."%' ";
				}
				
				if($_POST['magnitude'] != "(magnitude)") {
					$sql .= " OR (`magnitude` > ".($_POST['magnitude']-2)." AND `magnitude` < ".($_POST['magnitude']+2).") ";				
				}
				
				if($_POST['source'] != "(tsunami source)") {
					$sql .= " OR `source` LIKE '%".$_POST['source']."%' ";
				}
				$sql .= " ORDER BY datetime DESC";
				#echo $sql;
				#echo "</pre>";
			}
		?>
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Related search options&nbsp;:&nbsp; </strong><a href="<?=$_SERVER['PHP_SELF']?>?section=4"><font color="#000099">Reload</font></a><br>
          <input name="search_from" type="radio" id="radio" value="imported_results" checked>
          <a href="<?=$_SERVER['PHP_SELF']?>?section=4"><font color="#000099">From  simulation results</font></a><br>
          <font color="#000099">
          <input type="radio" name="search_from" id="radio3" value="on_demand" disabled>
          From on demand visualization</font></div>
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
          <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
          <legend><strong class="style37">Enter necessary information</strong>&nbsp;<a href="javascript: void(0);" onClick="javascript: document.getElementById('search_tbl').style.display='none'; document.getElementById('unhide').style.display=''; this.style.display='none';" id="hide">Hide</a><a href="javascript: void(0);" onClick="javascript: document.getElementById('search_tbl').style.display=''; document.getElementById('hide').style.display=''; document.getElementById('unhide').style.display='none';" id="unhide" style="display:none">Unhide</a></legend>
          <table border="0" cellpadding="4" cellspacing="0" id="search_tbl" style="display:">
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Searh by</th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><strong> </strong>
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="name" type="text" style="width:350px" id="name" value="(name)" onMouseMove="javascript: if(this.value == '(name)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(name)';"></td>
                  </tr>
                </table></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="description" type="text" style="width:350px" id="description" value="(description)" onMouseMove="javascript: if(this.value=='(description)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(description)';"></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"> <table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="latitude" type="text" style="width:100px" id="latitude" value="(latitude)" onMouseMove="javascript: if(this.value=='(latitude)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(latitude)';"></td>
                    <td>&nbsp;</td>
                    <td><input name="longitude" type="text" style="width:100px" id="longitude" value="(longitude)"  onMouseMove="javascript: if(this.value == '(longitude)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(longitude)';"></td>
                    <td>&nbsp;</td>
                    <td><font style="font-size:9px"><img src="../../image/help.png" alt="" width="13" height="16"></font></td>
                    <td>&nbsp;</td>
                    <td><font style="font-size:9px"> Example : 7, 45, 30.74 (degree, lipda, Philipda)</font></td>
                  </tr>
                </table></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="magnitude" type="text" style="width:350px" id="magnitude" value="(magnitude)" onMouseMove="javascript: if(this.value=='(magnitude)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(magnitude)';"></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="depth" type="text" style="width:350px" id="depth" value="(depth)" onMouseMove="javascript: if(this.value=='(depth)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(depth)';"></th>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;</th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="ob_area" type="text" style="width:350px" id="ob_area" value="(observation area)" onMouseMove="javascript: if(this.value=='(observation area)') this.value='';" onMouseOut="javascript: if(this.value=='') this.value='(observation area)';"></th>
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
        <div id="search_result_box"style="background-color:#FFFFCC; padding:4px 4px 4px 4px; border-top:#999999 1px solid"> <strong>
          <?php
          if(isset($_SESSION['uid']))
			{
				require_once('../../library/connectdb.inc.php');
					
					$expr = array();
					
					if(isset($sql)) {
						$sq = $sql;
					}else
						$sq = "SELECT * FROM sim_result  WHERE  uid=".$_SESSION['uid']." ORDER BY datetime DESC";
						
					$res = mysql_query($sq, $connection);
					if($res)
					{	
						if(mysql_num_rows($res) != NULL )
						{					
							$no = mysql_num_rows($res);
							for($a = 0; $a <= $no; $a++){
								$obj = mysql_fetch_object($res);
								$sim_result[$a]['id'] = $obj->id;
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
							}
						}
						else
							$no = 0;
					}
			}
		?>
          Search summary&nbsp;:</strong>&nbsp;Latitude=?, Longitude=?, <br>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <strong>Results&nbsp;:&nbsp;</strong>found <font color="#FF0000">
          <?=$no?>
          </font> record(s)<br>
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
              <tr onClick="javascript: select_sim_result('sim_rest_<?=$g?>', 'sel_[<?=$g?>]')">
                <td onMouseOver="javascript: this.style.background='#D0EFFB'; this.style.borderBottom='#A4ED8B 2px solid'; this.style.borderTop='#A4ED8B 2px solid';" onMouseOut="javascript: this.style.background=''; this.style.borderBottom=''; this.style.borderTop='';" title="<?="Create date : ".date('h:i:s A d/m/Y', $sim_result[$g]['submit_date'])?>"><table border="0" cellpadding="0" cellspacing="1">
                    <tr>
                      <td rowspan="6" valign="top"><input type="checkbox" name="sel[<?=$g?>]" id="sel_[<?=$g?>]" onClick="javascript: document.getElementById('sim_rest_<?=$g?>').style.background='#D1DCE9';"></td>
                      <td rowspan="6" valign="top">&nbsp;</td>
                      <td rowspan="6" valign="top"><a href="../bulletin/general.php?eid=<?=$sim_result[$g]['id']?>">
                        <?php 
						switch($sim_result[$g]['id']) {
							case 19 : ?>
                        <img src="../../image/HEIGHT-3D-R2_t.jpg" alt="0" width="35" height="35" border="0">
                        <?php 
								break;
							case 17 : ?>
                        <img src="../../image/image_59.jpg" alt="0" width="35" height="35" border="1">
                        <?php 
								break;
							default : ?>
                        <img src="../../image/tsu_ico.png" alt="0" width="35" height="35" border="0">
                        <?php 
								break;
						}?>
                        </a></td>
                      <td rowspan="6" valign="top">&nbsp;</td>
                      <td align="left" valign="top">Name: <strong>
                        <?=$sim_result[$g]['name']?>
                        </strong><font color="#330066">
                        <?=(date('d/m/Y', $sim_result[$g]['submit_date']) == date('d/m/Y', time())) ? "-- Today !" : "";?>
                        </font></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top">Magnitude:
                        <?=$sim_result[$g]['magnitude']?>
                        , Depth:
                        <?=$sim_result[$g]['depth']?></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top">Latitude:<font color="#0000CC">
                        <?=$sim_result[$g]['lat_degree']?>
                        °&nbsp;
                        <?=$sim_result[$g]['lat_lipda']?>
                        '&nbsp;
                        <?=$sim_result[$g]['lat_Philipda']?>
                        " N </font>,&nbsp;Longitude: <font color="#0000CC">
                        <?=$sim_result[$g]['long_degree']?>
                        °&nbsp;
                        <?=$sim_result[$g]['long_lipda']?>
                        '&nbsp;
                        <?=$sim_result[$g]['long_Philipda']?>
                        " E</font></td>
                    </tr>
                    <!--<tr>
                    <td align="left" valign="top">Create Date: <font color="#003399"><em>
                      <?=date('h:i:s d/m/Y', $sim_result[$g]['submit_date']);?>
                      </em></font></td>
                  </tr>-->
                  </table></td>
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
          <input name="interpulate_btn" type=button class=butenter id=interpulate_btn style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Interpolate selected item">
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
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

<map name="Map"><area shape="rect" coords="5,3,96,110" href="http://www.thaigrid.or.th" title="Thai National Grid Center">
</map>
<map name="Map2"><area shape="rect" coords="5,4,28,45" href="http://www.chula.ac.th" title="Chulalongkorn University"></map></BODY>
<!-- InstanceEnd --></HTML>
