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
.style3 {color: #000000}
-->
</style>
<style type="text/css">
<!--
.style7 {color: #990000; font-weight: bold; font-size: 12px; }
.style36 {color: #33CCFF}
.style37 {
	color: #0000FF;
	font-style: normal;
}
.style39 {color: #FF6600}
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" --><span class="dq_closestoday">
        <?php
		
			require_once('../../library/connectdb.inc.php');
			
			$visres = array();
			if(isset($_GET['keyword']) && isset($_GET['option']))
			{
				switch($_GET['option'])
				{
					case 0 : $sql = "SELECT * FROM visualize WHERE 
      					((LOWER(description) LIKE LOWER('%".$_GET['keyword']."%')) OR 
						(LOWER(name) LIKE LOWER('%".$_GET['keyword']."%'))) AND
						visualize.uid = ".$_SESSION['uid'].";"; 
						//echo $sql;
						break;
						
					case 1 : 
						$gridsize = explode(",", $_GET['keyword']);
					$sql = "SELECT * FROM visualize WHERE 
      					gridsize_x = ".$gridsize[0]." AND gridsize_y = ".$gridsize[1]." AND
						visualize.uid = ".$_SESSION['uid'].";";
						 break;
						 
					case 2 : $sql = "SELECT * FROM visualize WHERE 
      					(LOWER(region) LIKE LOWER('%".$_GET['keyword']."%')) AND
						visualize.uid = ".$_SESSION['uid'].";";
						 break;
						 
					case 3 : $sql = "SELECT * FROM visualize WHERE 
      					(LOWER(style) LIKE LOWER('%".$_GET['keyword']."%')) AND
						visualize.uid = ".$_SESSION['uid'].";";
						 break;
						 
					case 4 : $sql = "SELECT * FROM visualize WHERE 
      					(LOWER(type) LIKE LOWER('%".$_GET['keyword']."%')) AND
						visualize.uid = ".$_SESSION['uid'].";";
						 break;
				}
			}else
			{	
			$sql = "SELECT * FROM visualize WHERE UID = ".$_SESSION['uid']." ORDER BY date DESC;";
			}
			//echo $sql;
			$result = mysql_query($sql, $connection);
			$total = mysql_num_rows($result);
			//var_dump($result);
			$visres = array();
			if($result)
			{
				$i = 0;
				while($object = mysql_fetch_object($result))
				{
					$visres[$i]['id'] = $object->id;
					$visres[$i]['name'] = $object->name;
					$visres[$i]['src_image'] = $object->store_path;
					$visres[$i]['type'] = $object->type;
					$visres[$i]['style'] = $object->style;
					$visres[$i]['description'] = $object->description;
					$visres[$i]['region'] = $object->region;
					$visres[$i]['status'] = $object->status;
					$visres[$i]['timestep'] = $object->timestep;
					$visres[$i]['date'] = $object->date;
					
					if($visres[$i]['timestep'] == 1)
					{
						$image[$i] =  "image.tiff.jpg";
					}
					else{
						$image[$i] =  "image.0.tiff.jpg";	
					}
					$i++;
				}
				/*
				echo "<pre>";
				print_r($visres);
				echo "</pre>";
				*/
			}
			
		
			
			
		?>
      </span>&nbsp;Visualization Result<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
      <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operation&nbsp;:&nbsp;</strong><a href="import_sim_result.php?section=1"><font color="#000099">Import simulation result</font></a></div>
	  <form>
      <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
	    <fieldset id="deform" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
		   <legend class="style7">Select Results Type</legend>
           <table border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td align="right" valign="middle"><input name="result_type" type="radio" onClick="javascript: document.location.href='result.php?section=1';"></td>
            <td align="left" valign="middle">Experiment (Simulation + Visualization) </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="middle"><input name="result_type" type="radio" checked></td>
            <td align="left" valign="middle">On Demand Visualization</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
           </fieldset>
		<table width="10" height="2" border="0">
             <tr>
               <td></td>
             </tr>
        </table>
		   
		   <fieldset id="vis_pane" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
		   <legend class="style7">Visualizion (0)</legend>
           <?php
		if(count($visres) > 0)
		{
			for($i=0; $i<count($visres); $i++)
			{ 
			?>
			
			<DIV class=tutorial_block>
			  <a title="Click to see actual size and more details" 
	href="../user.visres-fullsize.php?id=<?=$visres[$i]['id']?>"><img src="../../library/resize-image.php?filename=<?=$visres[$i]['src_image'].$image[$i]?>&width=100&height=100" alt="0"  border=1 align=left  style="MARGIN-BOTTOM: 5px; border-color: #0099CC" href="#"></a>
			  <DIV class=asd1><strong>Name&nbsp;:&nbsp;</strong><?=$visres[$i]['name']?> (<?=$visres[$i]['type']?>-R<?=$visres[$i]['region']?>)</DIV>
				<DIV class=asd1><strong>Style&nbsp;:&nbsp;</strong> <?=$visres[$i]['style']?></DIV>
				<DIV class=asd1><strong class="orange2 f12 style3">Description&nbsp;:&nbsp;</strong>&nbsp;
				<?php
				
				if ( strlen($visres[$i]['description']) == 0 )
					echo "<em>no description</em>";
				else
					echo $visres[$i]['description'];
				
				?></DIV>
				<DIV class=asd1><strong class="orange2 f12 style3">Date&nbsp;:&nbsp;</strong>&nbsp;<?=date('l dS \of F Y h:i:s A', $visres[$i]['date']);?></DIV>
				<DIV class=asd1><strong class="orange2 f12 style3">Status&nbsp;:&nbsp;</strong>
				  <font color="orange"><?=$visres[$i]['status']?></font>			</DIV>
				<DIV class=asd1><strong class="orange2 f12 style3">Action&nbsp;:&nbsp;</strong> <a href="../user.visres-expand.php?section=2&id=<?=$visres[$i]['id']?>">Configure</a> | <a href="javascript: confirm_del_vis('<?=$visres[$i]['name']?>', <?=$visres[$i]['id']?>);"><font color="red">Delete</font></a></DIV>
			</DIV>
			<DIV class="line light clear"></DIV>
			<?php
			}
		}else
			echo "no job.";
		?></fieldset></form>
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
