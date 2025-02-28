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
	function cluster_file_selector(dsn)
	{

		if(dsn != false)
			var win = window.open('user.cluster-file-browser.php?dsn='+dsn.value, 'filebrowser', 'status=1,scrollbars=1,resizeable=1,width=650,height=350', true);	
		else
			var win = window.open('user.cluster-file-browser.php?dsn=false', 'filebrowser', 'status=1,scrollbars=1,resizeable=1,width=500,height=350', true);	
			
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/4, (windowHeight/4)+150);	
	}
	function showHistory()
	{
		win = window.open('user.clusterdsn-history.php', 'dummyname', 'status=1,scrollbars=1,resizeable=0,width=550,height=350', true);		
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/4, (windowHeight/4)+150);		
	}
	
	function show_sim_inputfile(flag)
	{
		if(flag == 1)
		{
		win = window.open('user.sim-file-selector.php?status=deform&option=true', 'Deformation File Browser', 'status=1,scrollbars=1,resizeable=0,width=950,height=350', true);		
		}else{
			win = window.open('user.sim-file-selector.php?status=region&option=true', 'Region File Browser', 'status=1,scrollbars=1,resizeable=0,width=810,height=350', true);		
		}
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/6, windowHeight/6);		
	}
	
	function removeFile(aId) 
	{
		var obj = document.getElementById(aId);
		obj.parentNode.removeChild(obj);
	}

</script>
<?php
	//define("DEBUG", 0);
	if(defined("DEBUG")) echo "<pre>";
	if(isset($_FILES)) {
		$flag_build_var_table = false;
		if($_FILES['tunami_file']['error'] == 0) {
			$filename = "../../Templates/simulation/".$_FILES['tunami_file']['name'];
			$_SESSION['conf_file_name'] = $_FILES['tunami_file']['name'];
			if(move_uploaded_file($_FILES['tunami_file']['tmp_name'], $filename)) {
				$file_contents = file_get_contents($filename);
				$_SESSION['file_contents'] = addslashes($file_contents);
				if(strlen($file_contents) > 0) {
					require_once('../../library/fnc_tunami_parser.php');
					$var_list = fnc_parser($file_contents);
					if(count($var_list) > 0) $flag_build_var_table = true;
					if(defined("DEBUG")) print_r($var_list);
					$_SESSION['var_list'] = $var_list;
				}
				//unlink($filename);
			}
		}
	}
	if(defined("DEBUG")) echo "</pre>";
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
.style15 {color: #0033CC}
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
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="../tasks/result.php?section=3">Results</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="../tasks/search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="../tasks/bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
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
      <DIV class=submenu_item id=c14> <A <?=$section[9]?> id=cs_14 href="observ_point.php?section=9" title="Go to data source manage page">Observation Points </A> </DIV>
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" --><?=$_POST['version'] == "sequential" ? "Sequential TUNAMI version configuration": "Parallel TUNAMI version configuration"?><!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
        <legend class="dq_closestoday"><strong> <font color="#990000"><?=ucwords($_POST['version'])?> version configuration</font> </strong></legend>
        <form action="<?=$_SERVER['PHP_SELF']?>?section=10" method="post" enctype="multipart/form-data">
          <table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <th scope="col" valign="middle" align="left">Select template from your hard drive</th>
              <th scope="col"><input name="tunami_file" type="file" id="tunami_file"></th>
              <th scope="col"><input name="parse" type=submit class=butenter id=parse style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Parse your template ..." onClick="javascript: location.href='<?=$_SERVER['PHP_SELF']?>';"></th>
            </tr>
          </table>
        </form>
        </fieldset>
        <?php 
		if(isset($_FILES['tunami_file']) && $_FILES['tunami_file']['error'] == 0) {
		?>
        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
        <legend><strong><font color="#990000">Variables/Parameters configuration table</font></strong></legend>
        <script language="javascript">
			function change_color(val) {
				if(val.value == 0)
					val.style.color='';
				if(val.value == 1) 
					val.style.color='red'; 
				if(val.value == 2)
					val.style.color='blue';
			}
		</script>
        <form action="seq_p3.php" method="post">
          <table border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td valign="middle" bgcolor="#F0F0F0">Template name
              <?php
            if(!is_resource($connection)) {
				require_once('../../library/connectdb.inc.php');
			}
			
			$inc_id = fn_get_last_auto_increment_id("seq_config_param");
			?></td>
              <td valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
              <td><input name="conf_name[name]" type="text" id="conf_name[name]" value="<?="untitled-".$inc_id?>" style="width:350px"></td>
              <td><input name="conf_name[type]" type="hidden" value="3" ></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#F0F0F0">Description </td>
              <td valign="top"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
              <td><textarea name="conf_name[des]" rows="3" id="description" style="width:350px"></textarea></td>
              <td>&nbsp;</td>
            </tr>
          </table><br>
          <table border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x">
            <tr>
              <td colspan="4" valign="top" bgcolor="#FFFF99" style="border-left:black 1px solid; border-right:black 1px solid; border-top:black 1px solid;"><div align="center"><strong><font color="#FF0000">Note: </font></strong><font color="#333333">Fill values in the textbox and select the right types of parameters</font></div></td>
            </tr>
            <tr>
              <td valign="top" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center"><font color="#FFFFFF"><strong>Description</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top:black 1px solid;border-bottom:black 1px solid; border-left:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Name</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Type</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Value</strong></font></div></td>
            </tr>

            <?php
		  for($i=0; $i<count($var_list)-1; $i++) {
		  ?>
            <tr>
              <td valign="middle" bgcolor="#F7F8DC" class="border_left"><?=(($i+1) <=9)? "0".($i+1): ($i+1)?>
                .&nbsp;
              <input name="<?=$var_list[$i]?>[description]" type="text" class="text_input_var" size="50" />              </td>
              <td valign="middle" bgcolor="#F7F8DC"><font color="#000066">
                <?=$var_list[$i]?>
                </font></td>
              <td valign="middle" bgcolor="#F7F8DC" class="">
                <select name="<?=$var_list[$i]?>[type]" onChange="javascript: change_color(this);">
                  <option value="0">Global Parameter</option>
                  <option value="1">Input File Name</option>
                  <option value="2">Output File Name</option>
                </select>              </td>
              <td valign="middle" bgcolor="#F7F8DC" class="border_right"><font color="#000066"><strong>
                <input name="<?=$var_list[$i]?>[value]" type="text" class="text_input_var" size="20" />
                </strong></font></td>
            </tr>
            <?php
		  }
		  if(isset($var_list))
		  {
		  ?>
            <tr>
              <td valign="middle" bgcolor="#F7F8DC" class="border_left border_bottom"><?=($i+1)?>
                .&nbsp;
              <input name="<?=$var_list[count($var_list)-1]?>[description]" type="text" class="text_input_var" size="50" />              </td>
              <td valign="middle" bgcolor="#F7F8DC" class="border_bottom"><font color="#000066">
                <?=$var_list[count($var_list)-1]?>
                </font></td>
              <td valign="middle" bgcolor="#F7F8DC" class="border_bottom"><select name="<?=$var_list[count($var_list)-1]?>[type]"  onChange="javascript: change_color(this);">
                  <option value="0">Global Parameter</option>
                  <option value="1">Input File Name</option>
                  <option value="2">Output File Name</option>
                </select></td>
              <td valign="middle" bgcolor="#F7F8DC" class="border_right border_bottom"><font color="#000066"><strong>
                <input name="<?=$var_list[count($var_list)-1]?>[value]" type="text" class="text_input_var" size="20"/>
                </strong></font></td>
            </tr>
            <?php
		  }else {
		  ?>
            <tr>
              <td colspan="4" valign="middle" class="border_left border_bottom border_right"><div align="center">- please upload TUNAMI template file - </div></td>
            </tr>
            <?php
		  }
		  ?>
          </table>
          <table border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td><input name="reload22" type=button class=butenter id=reload22 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="&lt; Back" onClick="javascript: location.href='seq_p1.php?section=10';"></td>
              <td><input name="reload" type=button class=butenter id=reload style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Reload" onClick="javascript: location.href='<?=$_SERVER['PHP_SELF']?>?section=10';"></td>
              <td><input name="next" type=submit class=butenter id=next style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next &gt;" onClick="javascript: location.href='<?=$_SERVER['PHP_SELF']?>';"></td>
            </tr>
          </table>
        </form>
        </fieldset>
        <? } ?>
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
