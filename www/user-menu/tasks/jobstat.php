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
	
	function show_profile(profile_id) {
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
		document.getElementById('res').src = 'job_profile.php?sec=main&job_id='+profile_id;
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
.style31 {
	color: #FFFFFF;
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->&nbsp;Tsunami simulation job <!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><strong>Operation</strong></td>
                    <td><strong>&nbsp;:&nbsp;</strong></td>
                    <td>&nbsp;</td>
                    <td><a href="<?=$_SERVER['REQUEST_URI']?>">Reload</a></td>
                    <td><div align="center">&nbsp;</div></td>
                  </tr>
                </table></td>
              <td><div align="right"></div></td>
            </tr>
          </table>
        </div>
        <!--<table width="0" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="height:4px"></td>
          </tr>
        </table>
        <div style="background-color:#FFFFCC; padding:4px 4px 4px 4px; border: #FF0000 1px solid;">
            <div align="center"><strong>Message !&nbsp;&nbsp;</strong><font color="#000099">{</font><font color="#000099">Explanation} <a href="<?=$_SERVER['PHP_SELF']?>?section=1&cmd=clear"><font color="#FF0000">{Link}</font></a> {Extend}</font></div>
        </div>-->
        <form>
          <fieldset id="deform" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
          <legend class="style7"> Status </legend>
          <?php
			require_once('../../library/connectdb.inc.php');
			if(is_resource($connection)) {
				$sql = "SELECT * FROM `job_profile`";
				$res = mysql_query($sql, $connection) or die("! could not select job profile.");
				if(mysql_num_rows($res) == 0) {
			
			?>
          <table border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x">
            <tr>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31"> ID</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31">Name</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31">Status</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center" class="style31"> Timestep</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center" class="style31">Create&nbsp;Date</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid"><div align="center" class="style31">Operations</div></td>
            </tr>
            <tr align="center">
              <td colspan="6" bgcolor="#F7F8DC" style="border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid">- No job-</td>
            </tr>
          </table>
          <?php
				}else {
				?>
          <table border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31"> ID</div></td>
              <td colspan="2" valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31">Name</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31">Status</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center" class="style31"> Timestep</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center" class="style31">Create&nbsp;Date</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid"><div align="center" class="style31">Operations</div></td>
              <td valign="top"></td>
            </tr>
            <?php
					while($obj = mysql_fetch_object($res)) {
			?>
            <tr bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
              <td valign="middle" bordercolor="#D4D0C8" bgcolor="" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center">
                  <?=$obj->id?>
                </div></td>
              <td valign="middle" bordercolor="#D4D0C8" bgcolor="" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="left"> <a href="javascript: void(0);" onClick="javascript: show_profile(<?=$obj->sim_result_id?>)"> <font color="#000066"><b>
                  <?=$obj->name?>
                  </b></font> </a> </div></td>
              <td valign="middle" bordercolor="#D4D0C8" bgcolor="" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="left"><font color="#990000">
                  <?=$obj->no_of_region?>
                  </font> region</div></td>
              <td valign="middle" bordercolor="#D4D0C8" bgcolor="" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center"><span class="style28">
                  <?=$obj->status?>
                  </span> </div></td>
              <td valign="middle" bordercolor="#D4D0C8" bgcolor="" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="right">
                  <?=$obj->total_timestep?>
                </div>
                <div align="right"></div></td>
              <td valign="middle" bordercolor="#D4D0C8" bgcolor="" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center"><font color="#336600">
                  <?=date('H:i:s A d/m/Y', $obj->create_date)?>
                  </font></div></td>
              <td valign="middle" bordercolor="#D4D0C8" style="border-bottom:black 1px solid;  border-left:black 1px solid; border-right:black 1px solid;"><a href="../../workspace/pemjit/files/Simulation/job_run.php?id=<?=$obj->id?>">Run</a>&nbsp;|&nbsp;<a href="job_stop.php?id=<?=$obj->id?>"><font color="#0099FF">Stop</font></a><span class="style32">&nbsp;|&nbsp;</span><a href="job_delete.php?id=<?=$obj->id?>"><font color="red">Delete</font></a></td>
              <td valign="left" bgcolor="#F7F8DC"><strong><font color="#FF0000">
                <?=($_REQUEST['s'] == $obj->name) ? "!&nbsp;New" : ""?>
                </font></strong></td>
            </tr>
            <?php
					}
					?>
          </table>
          <?
				}
			}
			?>
          </fieldset>
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

<map name="Map"><area shape="rect" coords="5,3,96,110" href="http://www.thaigrid.or.th" title="Thai National Grid Center">
</map>
<map name="Map2"><area shape="rect" coords="5,4,28,45" href="http://www.chula.ac.th" title="Chulalongkorn University"></map></BODY>
<!-- InstanceEnd --></HTML>
