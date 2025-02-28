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
	function enable_res_browser(sender_id, reciever_id) {
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
		document.getElementById('res').src = '../data-source/resource_browser.php?grp_id=<?=$_REQUEST['grp_id']?>&type=vis&data=water_level&id_parent='+reciever_id+'&id_dwn=a';
	}
	
	function p_echo(local_id_parent, id, filename, path, local_id_download) {
		str = '<a href="../data-source/download_file.php?download_filepath='+path+'">'+filename+'</a>'+'<input type="hidden" name="'+local_id_parent+'[filename]" value="'+filename+'">';
		str = str+'<input type="hidden" name="'+local_id_parent+'[path]" value="'+path+'">';
		//str = str+'<input type="hidden" name="'+local_id_parent+'[name]" value="'+filename+'">';
		document.getElementById(local_id_parent).innerHTML = str;
		//document.getElementById(elem_id_dwn).innerHTML = '&nbsp;<a href="../data-source/download_file.php?download_filepath='+elem_path+'">download</a>&nbsp;|&nbsp;<a href="javascript: void()" onclick="javascript: clear_val(this);">remove</a>';
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
	height: 80%;
	bottom: 10%;
	padding: 2px;
	border: 2px solid orange;
	background-color: white;
	z-index:1002;
	overflow: hidden;
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Simulation name : <font color="#FFFF99"><?=$_SESSION['import'][1]['name']?></font>, group of <font color="#FFFF99"><?=$_SESSION['g_name']?></font> [Step 3 of 3]<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
		<?php
			if(isset($_POST['next'])) {
				$_SESSION['import'][3] = (isset($_POST)) ? $_POST : null;
				echo "<script language=javascript>location.href='lib.handler_import.php?grp_id=".$_REQUEST['grp_id']."'</script>"; 
                /*
				echo "<pre>";
				print_r($_SESSION['import']);
				echo "</pre>";
				*/
			}
        ?>
      <form action="<?=$_SERVER['PHP_SELF']?>?grp_id=<?=$_REQUEST['grp_id']?>" method="post" enctype="multipart/form-data">
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Description</strong></td>
              <td><strong>&nbsp;:&nbsp;</strong></td>
              <td>Elapes Time Arrival and Zmax Visualization </td>
              <td>&nbsp;</td>
              <td>(<a href="javascript: void();" onClick="javascript: document.location.href='<?=$_SERVER['REQUEST_URI']?>';">reload</a>)</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
        <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
        <legend class="style37"><strong>Select related files of both ETA and Zmax for each region</strong></legend>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <th align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Region No.</font></div></th>
            <th valign="middle" bgcolor="#7B869A" scope="col" ><div align="center"><font color="#FFFFFF"></font></div></th>
            <th align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">ETA</font></div></th>
            <th align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Zmax</font></div></th>
          </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EEEEEE" scope="col"><div align="center">1</div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                	<td>&nbsp;</td>
                    <td><strong style="color:#009900">
                    <div id="eta_vis[r1]"></div>
                  </strong></td>
                  <td>&nbsp;</td>
                  <td><strong>
                    <input type="button" name="eta_r1" id="eta_r1" value="Browse..." onClick="javascript: enable_res_browser('eta_r1', 'eta_vis[r1]');">
                  </strong></td>
                </tr>
            </table></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td><strong style="color:#009900">
                  <div id="zmax_vis[r1]"></div>
                </strong></td>
                <td>&nbsp;</td>
                <td><strong>
                  <input type="button" name="zmax_r1" id="region_5" value="Browse..." onClick="javascript: enable_res_browser('zmax_r1', 'zmax_vis[r1]');">
                </strong></td>
              </tr>
            </table></th>
          </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EEEEEE" scope="col"><div align="center">2</div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                  <td><strong style="color:#009900">
                    <div id="eta_vis[r2]"></div>
                  </strong></td>
                  <td>&nbsp;</td>
                  <td><strong>
                    <input type="button" name="eta_r2" id="region_2" value="Browse..." onClick="javascript: enable_res_browser('eta_r2', 'eta_vis[r2]');">
                  </strong></td>
                </tr>
            </table></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td><strong style="color:#009900">
                  <div id="zmax_vis[r2]"></div>
                </strong></td>
                <td>&nbsp;</td>
                <td><strong>
                  <input type="button" name="zmax_r2" id="zmax_r2" value="Browse..." onClick="javascript: enable_res_browser('zmax_r2', 'zmax_vis[r2]');">
                </strong></td>
              </tr>
            </table></th>
          </tr>
          <!--
          <tr>
            <th align="left" valign="middle" bgcolor="#EEEEEE" scope="col"><div align="center">3</div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                  <td><strong style="color:#009900">
                    <div id="eta_vis[r3]"></div>
                  </strong></td>
                  <td>&nbsp;</td>
                  <td><strong>
                    <input type="button" name="eta_r3" id="eta_r3" value="Browse..." onClick="javascript: enable_res_browser('eta_r3', 'eta_vis[r3]');">
                  </strong></td>
                </tr>
            </table></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td><strong style="color:#009900">
                  <div id="zmax_vis[r3]"></div>
                </strong></td>
                <td>&nbsp;</td>
                <td><strong>
                  <input type="button" name="zmax_r3" id="zmax_r3" value="Browse..." onClick="javascript: enable_res_browser('zmax_r3', 'zmax_vis[r3]');">
                </strong></td>
              </tr>
            </table></th>
          </tr>
          <tr>
            <th align="left" valign="middle" bgcolor="#EEEEEE" scope="col"><div align="center">4</div></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                  <td><strong style="color:#009900">
                    <div id="eta_vis[r4]"></div>
                  </strong></td>
                  <td>&nbsp;</td>
                  <td><strong>
                    <input type="button" name="eta_r4" id="eta_r4" value="Browse..." onClick="javascript: enable_res_browser('eta_r4', 'eta_vis[r4]');">
                  </strong></td>
                </tr>
            </table></th>
            <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td><strong style="color:#009900">
                  <div id="zmax_vis[r4]"></div>
                </strong></td>
                <td>&nbsp;</td>
                <td><strong>
                  <input type="button" name="zmax_r4" id="zmax_r4" value="Browse..." onClick="javascript: enable_res_browser('zmax_r4', 'zmax_vis[r4]');">
                </strong></td>
              </tr>
            </table></th>
          </tr>
          -->
        </table>
        </fieldset>
        <!--<fieldset id="def2" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
        <legend class="style37"><strong>Enter ETA and Zmax's values of each  points </strong></legend>
        <?php
        	require('../../library/connectdb.inc.php');
			if(is_resource($connection)) {
				$p_status = $_SESSION['import'][2];
				$sql = "SELECT * FROM observe_point WHERE ";
				foreach($p_status['select_point_id'] as $index => $value) {
					$_p[] = "observ_point_id = ".$index;
				}
				$t = implode(" OR ", $_p);
				$sql .= $t;
				$res = mysql_query($sql, $connection);
			}
		?>
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
              <th align="left" valign="middle" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Observation Point Name</font></div></th>
              <th valign="middle" bgcolor="#7B869A" scope="col" ><div align="center"><font color="#FFFFFF"></font></div></th>
              <th colspan="2" align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">ETA</font></div></th>
              <th colspan="2" align="left" bgcolor="#7B869A" scope="col"><div align="center"><font color="#FFFFFF">Zmax</font></div></th>
            </tr>
        	<?php
			while($obj = mysql_fetch_object($res)) {
			?>
            
            <tr>
            <th align="left" valign="middle" bgcolor="#EEEEEE" scope="col">&nbsp;&nbsp;&nbsp;<?=$obj->name?></th>
            <th scope="col" valign="middle" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
            <th align="left" scope="col"><input type="text" name="eta[<?=$obj->observ_point_id?>]" id="eta[<?=$obj->observ_point_id?>]" value="0"></th>
            <th align="left" scope="col">mins</th>
            <th align="left" scope="col"><input type="text" name="zmax[<?=$obj->observ_point_id?>]" id="zmax[<?=$obj->observ_point_id?>]" value="0"></th>
            <th align="left" scope="col">M.</th>
            </tr>
            <?php
			}
			?>
        </table>
        </fieldset>-->
        <br>
        <!--<input name="next2" type=button class=butenter id=next2 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="&lt; Back" onClick="javascript: location.href='import_sim_select_ob_point.php?section=3&grp_id=<?=$_REQUEST['grp_id']?>';">-->
        <input name="next" type=submit class=butenter id=next style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next &gt;">
        </form>
        <div id="light" class="white_content">
          <iframe src="" style="border-width:0px;" width="100%" height="100%" id="res">Something wrong !</iframe>
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
</BODY>
<!-- InstanceEnd --></HTML>
