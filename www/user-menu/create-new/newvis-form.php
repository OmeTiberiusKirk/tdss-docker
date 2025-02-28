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
	function changeDefaultParameter(region, zoom, resolution, rotate_x, rotate_y, rotate_z)
	{
		<?php
			require('../../library/preset-param.inc.php');
		?>
		switch(region.value)
		{

			case '1':
			
				zoom.value = 500;	
				resolution.value = 500;		
				rotate_x.value = 180;												                
				rotate_y.value = 0;
				rotate_z.value = 0;
				break;
			case '2':
				zoom.value = 1000;	
				resolution.value = 500;		
				rotate_x.value = 180;												                
				rotate_y.value = 0;
				rotate_z.value = 0;
				break;
			case '3':
				zoom.value = 700;	
				resolution.value = 500;		
				rotate_x.value = 180;												                
				rotate_y.value = 0;
				rotate_z.value = 0;
				break;
			case '4':
				zoom.value = 700;	
				resolution.value = 500;		
				rotate_x.value = 180;												                
				rotate_y.value = 0;
				rotate_z.value = 0;
				break;
		}
	}
	
	function select_formulated_file()
	{
		var win = window.open('user.file-selector.php', 'filebrowser', 'status=1,scrollbars=1,resizeable=0,width=800,height=350', true);	
	
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/4, (windowHeight/4)+150);	}
		
	function select_formulated_file2()
	{
		var win = window.open('user.file-selector2.php', 'filebrowser', 'status=1,scrollbars=1,resizeable=1,width=750,height=350', true);	
	
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/4, (windowHeight/4)+150);	
	}
	
	function help()
	{

		var win = window.open('user.help.ds.php', 'dummyname', 'status=1,scrollbars=1,resizeable=0,width=800,height=250', true);	
			
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth/4, (windowHeight/4)+150);
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
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Create On-Demand Visualization <!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
	 
 <form action="../../library/request-render.php" method="post" name="visform" id="visform">
 	<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><fieldset class="ForeCode">
 	<legend class="dq_closestoday"><strong>General Information</strong></legend><table border="0" cellpadding="4" cellspacing="0">
     <tr>
       <th scope="col" valign="middle" align="left">Type </th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th align="left" scope="col"><strong>
	   <?php
	 
	  switch($_REQUEST['type'])
	  {
		case 1:
			$type_str = "Wave Animation";
			break;
		case 2:
			$type_str = "Height";
			break;
		case 3:
			$type_str = "Depth";
			break;
		case 4:
			$type_str = "Velocity";
			break;
		case 5:
			$type_str = "Time History";
			break;
		case 6:
			$type_str = "Height on The Coastline";
			break;
		case 7:
			$type_str = "The Elapsed Time Arrival";
			break;
	  }
	  ?>
         <input name="type_dis" type="text" id="type_dis" style="width:250px" value="<?=$type_str?>" size="40" disabled="disabled">
		 <input name="type" type="hidden" id="type" value="<?=$type_str?>">
       </strong></th>
       </tr>
     <tr>
       <th scope="col" valign="middle" align="left"><strong>Style</strong></th>
       <th scope="col" valign="middern" ><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th align="left" scope="col"> <input name="style_dis" type="text" id="style_dis" style="width:250px" value="<?=strtoupper($_REQUEST['style'])?>" size="40" disabled="disabled"><input name="style" type="hidden" id="style" value="<?=strtoupper($_REQUEST['style'])?>"></th>
       </tr>
     <tr>
       <th scope="col" valign="middle" align="left"><strong>Name</strong></th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th align="left" scope="col">
	   <?php
	   require_once('../../library/connectdb.inc.php');
	   
	   $sql = "SELECT MAX(id) as M FROM visualize;";
	   $result = mysql_query($sql, $connection);
	   if(mysql_num_rows($result) == 1 )
	   {
	   		$object = mysql_fetch_object($result);
			$max = $object->M;
			mysql_free_result($result);
	   }
	   	
	   ?>
	   <input name="name" type="text" id="name" style="width:250px" value="untitled-<?=$max?>" size="40" ></th>
       </tr>
     <tr>
       <th scope="col" valign="top" align="left"><strong>Detail</strong></th>
       <th scope="col" valign="top"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th align="left" scope="col"> <textarea name="detail" cols="40" rows="4" id="detail" style="width:250px" ></textarea>       </th>
       </tr>
     <tr>
       <th scope="col" valign="top" align="left">Status</th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th align="left" scope="col"><table border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="23"><input name="status" type="radio" id="Public" value="Public" checked> </td>
           <td width="37" class="fs14px">Public </td>
           <td width="10" class="fs14px"></td>
           <td width="23" class="fs14px"><input name="status" type="radio" value="Private" id="Private" >
           </td>
           <td width="39" class="fs14px">Private</td>
         </tr>
       </table></th>
     </tr>
   </table>
 	</fieldset></td>
    <td>&nbsp;</td>
    <td valign="top"><fieldset class="ForeCode">
    <legend class="dq_closestoday"><strong>Sample Result</strong></legend>
	<?php
		switch($_REQUEST['type'])
		{
			case 1:
				switch($_REQUEST['style'])
				{
					case "3d":
						$image = "../../library/resize-image.php?filename=../image/wave-animation-3d.jpg&width=184&height=184";
						break;
					case "2d":
						$image = "../../library/resize-image.php?filename=../image/wave-animation-2d.jpg&width=184&height=184";
						break;
				}
				break;
			case 2:
				switch($_REQUEST['style'])
				{
					case "3d":
						$image = "../../library/resize-image.php?filename=../image/height-3d.jpg&width=184&height=184";
						break;
					case "2d":
						$image = "../../library/resize-image.php?filename=../image/height-2d.jpg&width=184&height=184";
						break;
				}
				break;
			case 3:
				switch($_REQUEST['style'])
				{
					case "3d":
						$image = "../../library/resize-image.php?filename=../image/depth-3d.jpg&width=184&height=184";
						break;
					case "2d":
						$image = "../../library/resize-image.php?filename=../image/depth-2d.jpg&width=184&height=184";
						break;
				}
				break;
			case 4:
				switch($_REQUEST['style'])
				{
					case "3d":
						$image = "../../library/resize-image.php?filename=../image/velocity-3d.jpg&width=184&height=184";
						break;
					case "2d":
						$image = "../../library/resize-image.php?filename=../image/velocity-2d.jpg&width=184&height=184";
						break;
				}
				break;
			case 5:
				switch($_REQUEST['style'])
				{
					case "2d":
						$image = "../../library/resize-image.php?filename=../image/Time-His.png&width=184&height=184";
						break;
				}
				break;
			case 6:
				switch($_REQUEST['style'])
				{
					case "2d":
						$image = "../../library/resize-image.php?filename=../image/height-on-the-cosatline.jpg&width=184&height=184";
						break;
				}
				break;
			case 7:
				switch($_REQUEST['style'])
				{
					case "3d":
						$image = "../../library/resize-image.php?filename=../image/elapsed-time-3d.jpg&width=184&height=184";
						break;
					case "2d":
						$image = "../../library/resize-image.php?filename=../image/elapsed-time-2d.jpg&width=184&height=184";
						break;
				}
				break;
		}
	?>
    <img src="<?=$image?>" alt="<?=$_REQUEST['type']."(".$_REQUEST['style'].")";?>" border="1" />
    </fieldset></td>
  </tr>
</table>

	<fieldset class="ForeCode">
   <legend class="dq_closestoday"><strong>Configuration</strong></legend><table border="0" cellpadding="4" cellspacing="0">
     <tr valign="middern">
       <th scope="col" valign="top" align="left"><strong>Region</strong></th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th align="left" scope="col"> <select name="region" size="1" id="region" onChange="javascript: changeDefaultParameter(region, zoom, resolution, rotate_x, rotate_y, rotate_z);">
           <option value="1">Region 1</option>
           <option value="2">Region 2</option>
           <option value="3">Region 3</option>
           <option value="4">Region 4</option>
         </select>       </th>
       </tr>
     <tr>
       <th scope="col" align="left">Zoom</th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <td><input name="zoom" type="text" id="zoom"  value="500" style="text-align:center" size="10" <?=$disable_flag?>></td>
       </tr>
     <tr>
       <th scope="col" align="left">Resolution</th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <td><input name="resolution" type="text" id="resolution"  style="text-align:center" value="500" size="10" <?=$disable_flag?>></td>
       </tr>
     <tr valign="middern">
       <th scope="col" align="left">Rotate</th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <td>X°
         <input name="rotate_x" type="text" id="rotate_x"  style="text-align:center" size="3" value="180" <?=$disable_flag?>>
		 &nbsp;
         Y°
         <input name="rotate_y" type="text" id="rotate_y"  style="text-align:center" size="3" value="0" <?=$disable_flag?>>
         &nbsp;
         Z°
         <input name="rotate_z" type="text" id="rotate_z"  style="text-align:center" size="3" value="0" <?=$disable_flag?>></td>
       </tr>
   </table>
   </fieldset>
	<fieldset class="ForeCode">
   <legend class="dq_closestoday"><strong>Select Data</strong></legend><table border="0" cellpadding="4" cellspacing="0">
     
     <tr>
       <th scope="col" align="left">Region  
         <input type="hidden" value="" id="hid_val_regionfile" name="hid_val_regionfile"></th>
       <th scope="col"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th scope="col" align="left"><input name="regionfile" type="text" id="regionfile" size="55" style="width:250px"></th>
       <th scope="col"><span class="fs14px">
         <input name="btn1" type="button" id="btn1" value=" Browse File " onClick="javascript: select_formulated_file();" style="width:100px;">
       </span></th>
       <th scope="col"><table border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td class="fs14px"><img src="../../image/help.png" alt="0" width="13" height="16" border="0" usemap="#Map2" onClick="javascript: cluster_file_selector(false);">
               <map name="Map2">
                 <area shape="rect" coords="1,1,11,15" href="javascript: alert('If you have not been uploaded the data.\nPlease go to the `data source` menu.');">
               </map></td>
         </tr>
       </table></th>
     </tr>
     <tr>
       <th scope="col" align="left"><?php
	 
	  switch($_REQUEST['type'])
	  {
		case 1:
			echo "Z*";
			break;
		case 2:
			echo "ZMN*";
			break;
		case 3:
			echo "ZMN*";
			break;
		case 4:
			echo "UVM*";
			break;
		case 5:
			echo "Time History";
			break;
		case 6:
			echo "Height on The Coastline";
			break;
		case 7:
			echo "ETA*";
			break;
	  }
	  ?>
         <input type="hidden" value="" id="hid_val_data" name="hid_val_data"></th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th scope="col" align="left"><input name="data" type="text" id="data" size="55" style="width:250px" disabled="disabled"></th>
       <th scope="col"><span class="fs14px">
         <input name="data_btn" type="button" id="data_btn" value=" Browse File " onClick="javascript: select_formulated_file2();" style="width:100px;" disabled="disabled">
       </span></th>
       <th scope="col"><table border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td class="fs14px"><table border="0" cellpadding="0" cellspacing="0">
             <tr>
               <td class="fs14px"><img src="../../image/help.png" alt="0" width="13" height="16" border="0" usemap="#Map2" onClick="javascript: cluster_file_selector(false);">
                   <map name="Map2">
                     <area shape="rect" coords="1,1,11,15" href="javascript: alert('If you have not been uploaded the data.\nPlease go to the `data source` menu.');">
                 </map></td>
             </tr>
           </table>           </td>
         </tr>
       </table></th>
     </tr>
     <tr id="gridsize" style="display:">
       <th scope="col" align="left">Time Step </th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th scope="col" align="left"><table border="0" align="left" cellpadding="0" cellspacing="0">
           <tr>
             <td><input name="timestep_dis" type="text" id="timestep_dis"  style="text-align:center" value="0" size="10" disabled="disabled"><input name="timestep" type="hidden" value=""></td>
             </tr>
       </table></th>
       <th scope="col">&nbsp;</th>
       <th scope="col">&nbsp;</th>
     </tr>
     <tr id="gridsize" style="display:">
       <th scope="col" align="left">Grid Size </th>
       <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
       <th scope="col" align="left"><table border="0" align="left" cellpadding="0" cellspacing="0">
           <tr>
             <td><input name="gridsize_x_dis" type="text" id="gridsize_x_dis"  style="text-align:center" value="0" size="10" disabled="disabled"></td>
             <td>&nbsp;X&nbsp;</td>
             <td><input name="gridsize_y_dis" type="text" id="gridsize_y_dis"  style="text-align:center" value="0" size="10" disabled="disabled"></td>
           </tr>
       </table><input type="hidden" name="gridsize_x" value=""><input type="hidden" name="gridsize_y" value=""></th>
       <th scope="col">&nbsp;</th>
       <th scope="col">&nbsp;</th>
     </tr>
   </table>
   </fieldset>
	<table border="0" cellpadding="4" cellspacing="0">
     <tr>
       <th scope="col"> <input name="Back" type=button class=butenter id=reset style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Back" onClick="javascript: history.back();" <?=$disable_flag?>>         
         &nbsp;&nbsp;
         <input name="reset" type=reset class=butenter id=render style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Reset" <?=$disable_flag?>>
  &nbsp;&nbsp;
         <input name="render" type=submit class=butenter style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Render" <?=$disable_flag?>></th></tr>
   </table>
 </form>
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
