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
		$_SESSION['uri'] = $_SERVER['REQUEST_URI'];
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
.style14 {
	color: #0033CC
}
.style23 {
	color: #0066FF
}
.style28 {
	color: #000000;
}
.style31 {
	color: #FFFFFF;
}
.style32 {
	color: #333333
}
.style34 {
	color: #FF0000
}
.style37 {
	color: #336600
}

</style>
<script type="text/javascript">

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Present parameters and define template of simulation version<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <script type="text/javascript" src="wz_tooltip/wz_tooltip.js"></script>
        <form action="seq_p2.php?section=8" method="post" name="dsform" id="dsform" style="display:">
          <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
          <legend><font color="#990000"><strong>Create a new  template </strong></font></legend>
          <table border="0" cellpadding="4" cellspacing="0">
            <tr>
              <th scope="col" valign="middle" align="left"><input name="version" type="radio" value="sequential" checked></th>
              <th valign="middle" scope="col"><div align="left">Sequential</div></th>
              <th valign="middle" scope="col">&nbsp;</th>
              <th valign="middle" scope="col"><input name="version" type="radio" value="parallel" disabled="disabled"></th>
              <th valign="middle" scope="col"><div align="left"> Parallel </div></th>
              <th valign="middle" scope="col">&nbsp;</th>
              <th valign="middle" scope="col"><input name="next" type=submit class=butenter id=next style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next &gt;" ></th>
            </tr>
          </table>
          </fieldset>
        </form>
        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
        <legend class="style14"><strong><font color="#990000">Sequential template</font> </strong></legend>
        <table heigh="3" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <form action="update_default.php" method="post">
          <table border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF" style="background-image:url(../../../image/gradient-inner.png); background-repeat:repeat-x">
            <tr>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31"> Default</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31">ID</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-bottom:black 1px solid; border-left:black 1px solid; border-top:black 1px solid;"><div align="center" class="style31">Name </div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center" class="style31">Last&nbsp;Update</div></td>
              <td valign="top" bordercolor="#999999" bgcolor="#7B869A" style="border-top: black 1px solid; border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid"><div align="center" class="style31">Operations</div></td>
            </tr>
            <?php 
			  	require_once('../../library/connectdb.inc.php');
					$expr = array();
					$sq = "SELECT * FROM seq_config_param  WHERE  uid=".$_SESSION['uid'];
					$res = mysql_query($sq, $connection);
					if($res) {	
						if(mysql_num_rows($res) != NULL){					
                $no = mysql_num_rows($res);
							  for($a = 0; $a <= $no; $a++){
                  $obj = mysql_fetch_object($res);
                  $expr[$a]['description'] = (strlen($obj->description) > 0) ? $obj->description: "(description is not specified)";
                  $expr[$a]['name'] = $obj->name;
                  $expr[$a]['id'] = $obj->var_id;
                  if(($obj->default_param) == 'yes'){
                    $expr[$a]['default'] = "checked";
                  }else{
                    $expr[$a]['default'] = "";
                  }
                  
                  $expr[$a]['date'] = date('l d F Y h:i:s A', $obj->date);
                  //date('l dS \of F Y h:i:s A', $expr['submit_date'])
							  }
						}else {
              $no = 0;
            }
					}
					if($no == 0) {
			?>
            <tr align="center">
              <td colspan="5" bgcolor="#F7F8DC" style="border-bottom:black 1px solid; border-left:black 1px solid; border-right:black 1px solid">- Please create experiment parameter configuration   profile for sequential version -</td>
            </tr>
            <?
					}else{
						for($i=0; $i<$no; $i++) {
			?>
            <tr bgcolor="#F7F8DC" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='#F7F8DC';">
              <td valign="middle" bordercolor="#D4D0C8" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center">
                  <input name="default" type="radio" value="<?=$expr[$i]['id']?>" <?=$expr[$i]['default']?>>
                </div></td>
              <td valign="middle" bordercolor="#D4D0C8" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="center">
                  <?=$expr[$i]['id']?>
                </div></td>
              <td valign="middle" bordercolor="#D4D0C8" style="border-bottom:black 1px solid; border-left:black 1px solid;">&nbsp;<span class="style28">&nbsp;<a href="#docu" onMouseOver="Tip('<?=addslashes($expr[$i]['description'])?>', WIDTH, 300, TITLE, '<b>Filename:</b> <?=$expr[$i]['name']?>', SHADOW, true, FADEIN, 300, FADEOUT, 300, STICKY, 1, CLOSEBTN, true, DELAY, 400)" onMouseOut="UnTip()"><?=$expr[$i]['name']?></a>&nbsp;</span> </td>
              <td valign="middle" bordercolor="#D4D0C8" style="border-bottom:black 1px solid; border-left:black 1px solid;"><div align="right"><span class="style37" align="right">
                  <?=$expr[$i]['date']?>
                  </span> </div></td>
              <td valign="middle" bordercolor="#666666" style="border-bottom:black 1px solid;  border-left:black 1px solid; border-right:black 1px solid;"><a href="../../library/download.php?type=db&filename=<?=$expr[$i]['name']?>&table=seq_config_param&field_select=template_file&refer_id=<?=$expr[$i]['id']?>&refer_field=var_id">Download&nbsp;template&nbsp;file<span class="style32"></span></a>&nbsp;|&nbsp;<a href="seq_p4.php?section=8&id=<?=base64_encode($expr[$i]['id'])?>"><span class="style23" onMouseOver="javascript:this.style.color='#666666';" onMouseOut="javascript:this.style.color='#0066FF';"><span class="style32"></span>Edit</span></a><span class="style32">&nbsp;|&nbsp;</span><a href="conf.php?id=<?=base64_encode($expr[$i]['id'])?>&name=<?=$expr[$i]['name']?>"><span class="style34" onMouseOver="javascript:this.style.color='#666666';" onMouseOut="javascript:this.style.color='red';" >Delete</span></a></td>
            </tr>
            <?php
			  			}//for
          }
			?>
          </table>
          <br>
          <INPUT name="dischard" type=reset class=butenter  style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="  Discard Change  " <?=$disable_flag?> >
          &nbsp;&nbsp;
          <INPUT name="submit" type=submit class=butenter  style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="  Submit Change  " <?=$disable_flag?>  >
        </form>
        </fieldset>
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
