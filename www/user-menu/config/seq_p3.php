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

	function enable_lightbox(recv_name_id, type, dwn) {
		/*
		../data-source/resource_browser.php?type=sim&data=region
		*/
		if(type == 'REG')
			t = 'region';
		if(type == 'DEF')
			t = 'deform';
		document.getElementById('res').src = '../data-source/resource_browser.php?type=sim&data='+t+'&id_parent='+recv_name_id+'&id_dwn='+dwn;
		document.getElementById('light').style.display = 'block';
		document.getElementById('fade').style.display = 'block'
	}
	
	function p_echo(elem_id, elem_ref_id, elem_filename, elem_path, elem_id_dwn) {
		//alert(elem_id+' = '+elem_ref_id+', '+elem_ref2id);
		document.getElementById(elem_id).value = elem_filename;
		//document.getElementById(elem_id_dwn).innerHTML = '<a href="../data-source/download_file.php?download_filepath='+elem_path+'">(download)</a>|<a href="javascript: void()" onClick="javascript: document.getElementById('+b+').value = \'\'; ">remove</a>';
		document.getElementById(elem_id_dwn).innerHTML = '&nbsp;<a href="../data-source/download_file.php?download_filepath='+elem_path+'">download</a>';
	}

</script>
<?php

		session_unregister("cid");
		$global_param = array();
		$input_param = array();
		$output_param = array();
		if($_POST['next']) {
			foreach($_POST as $html_var_name => $var_info) {
				if($html_var_name != 'next') {
					switch($var_info['type']) {
						case 0: $global_param[$html_var_name] = $var_info; $G++; break;
						case 1: $input_param[$html_var_name] = $var_info; $I++; break;
						case 2: $output_param[$html_var_name] = $var_info; $O++; break;
					}
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
.style12 {
	font-family: arial
}
.style6 {
	color: #990000;
	font-weight: bold;
}
.style13 {
	color: #990000
}
.style4 {
	color: #1395A9
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
	bottom:10%;
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Template name :
        <?=$_POST['conf_name']['name']?>
        <!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <form action="handler.php" method="post">
          <input name="conf_name[name]" type="hidden" value="<?=$_POST['conf_name']['name']?>">
          <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Select input data and save your configuration profile to database.</strong></div>
          <table border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td valign="top" bgcolor="#F0F0F0">Description </td>
              <td valign="top"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
              <td><textarea name="conf_name[des]" rows="3" id="description" style="width:350px"><?=$_POST['conf_name']['des']?>
</textarea></td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend><strong> <font color="#990000">Global Parameter</font> </strong></legend>
          <table border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x">
            <tr>
              <td colspan="2" valign="top" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center"><font color="#FFFFFF"><strong>Description</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Name</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Value</strong></font></div></td>
            </tr>
            <?php 
			$i=1;
			foreach($global_param as $var_name => $var_info) {
			?>
            <tr>
              <td valign="middle" class=""><?=$i++?>
                . </td>
              <td valign="middle" class=""><input name="des[global][<?=$var_name?>]" value="<?=$var_info['description']?>" type="text" class="text_input_var" size="50" /></td>
              <td valign="middle" class=""><font color="#000066">
                <?=$var_name?>
                </font></td>
              <td valign="middle" class=""><input name="val[global][<?=$var_name?>]" type="text" class="text_input_var" value="<?=$var_info['value']?>" size="20" />
                </strong></font></td>
            </tr>
            <?php
			}
			?>
          </table>
          </fieldset>
          <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend><strong> <font color="#990000">Input File Name</font> </strong></legend>
          <table border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x">
            <tr>
              <td colspan="2" valign="top" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center"><font color="#FFFFFF"><strong>Description</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Name</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Value</strong></font></div></td>
            </tr>
            <?php 
			$i=1;
			foreach($input_param as $var_name => $var_info) {
			?>
            <tr>
              <td valign="middle" class=""><?=$i++?>
                .</td>
              <td valign="middle" class=""><input name="des[input][<?=$var_name?>]" value="<?=$var_info['description']?>" type="text" class="text_input_var" size="50" /></td>
              <td valign="middle" class=""><font color="#000066">
                <?=$var_name?>
                </font></td>
              <td valign="middle" bgcolor="" class=""><table border="0" cellspacing="0" cellpadding="2">
                  <tr>
                    <td><input name="val[input][<?=$var_name?>]" id="val[input][<?=$var_name?>]" type="text" class="text_input_var" value="<?=$var_info['value']?>" size="20"/></td>
                    <td><input type="button" class="text_input_var" value="Browse..." size="20" onClick = "javascript: enable_lightbox('val[input][<?=$var_name?>]', '<?=(substr($var_name, 0, 3) == "REG") ? "REG" : "DEF"?>', 'download_val[input][<?=$var_name?>]')" /></td>
                    <td><div id="download_val[input][<?=$var_name?>]">
                        <?php
                    	if(strlen($data['val']['input'][$var_name]) > 1) {
					?>
                        <a href="../../data-source/download_file.php?download_filepath=<?=(substr($var_name, 0, 3) == "REG") ? $reg_id_path[$data['val']['input'][$var_name]] : $def_id_path[$data['val']['input'][$var_name]]?>">download</a>
                        <?php
					}
					?>
                    </div></td>
                  </tr>
                </table>
                  </strong></font></td>
            </tr>
            <?php
			}
			?>
          </table>
          </fieldset>
          <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend><strong> <font color="#990000">Output File Name</font> </strong></legend>
          <table border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x">
            <tr>
              <td colspan="2" valign="top" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center"><font color="#FFFFFF"><strong>Description</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Name</strong></font></div></td>
              <td valign="top" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-right:black 1px solid"><div align="center"><font color="#FFFFFF"><strong>Value</strong></font></div></td>
            </tr>
            <?php 
			$i=1;
			foreach($output_param as $var_name => $var_info) {
			?>
            <tr>
              <td valign="middle" class=""><?=$i++?>
                .</td>
              <td valign="middle" class=""><input name="des[output][<?=$var_name?>]" value="<?=$var_info['description']?>" type="text" class="text_input_var" size="50" /></td>
              <td valign="middle" class=""><font color="#000066">
                <?=$var_name?>
                </font></td>
              <td valign="middle" class=""></strong>
                <input name="val[output][<?=$var_name?>]" type="text" class="text_input_var" value="<?=$var_info['value']?>" size="20" />
                </font></td>
            </tr>
            <?php
			}
			?>
          </table>
          </fieldset>
          <table border="0" cellspacing="0" cellpadding="4">
            <tr>
              <td><input name="reload22" type=button class=butenter id=reload22 style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="&lt; Back" onClick="javascript: location.href='seq_p2.php?section=10';"></td>
              <td><input name="reload" type=button class=butenter id=reload style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Reload" onClick="javascript: document.location.reload();"></td>
              <td><input name="save" type=submit class=butenter id=save style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Save to database" onClick="javascript: location.href='<?=$_SERVER['PHP_SELF']?>';"></td>
            </tr>
          </table>
        </form>
        <div id="light" class="white_content">
          <iframe src="../data-source/resource_browser.php?type=sim&data=region" id="res" style="border-width:0px;" width="100%" height="100%">Something wrong !</iframe>
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
