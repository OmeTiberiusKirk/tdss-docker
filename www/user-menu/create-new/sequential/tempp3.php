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

	function SelectForm(selVal)
	{
		reg_form_main.reg1.style.display = 'none';
	}

	function addRowToTable(sel_val)
	{
		var tbl = document.getElementById('add_param');
		var lastRow = (tbl.rows.length)-1;
		if(lastRow >= 4)
		{	
			// if there's no header row in the table, then iteration = lastRow + 1
			var iteration = lastRow;
			var row = tbl.insertRow(lastRow);
			row.setAttribute('align', 'center');
			// left cell
			var cellLeft = row.insertCell(0);
			cellLeft.innerHTML = "<input name=\"name[]\" type=\"text\" id=\"name[]\" value=\""+sel_val+"\" size=\"15\" />";
			
			// right cell
			var cellRight = row.insertCell(1);
			cellRight.innerHTML = "<input name=\"val[]\" type=\"text\" id=\"val[]\" size=\"15\" />";
			
			// select cell
			/*
			var selectType = row.insertCell(2);
			var sel = document.createElement('select');
			sel.name = 'type[]';
			sel.options[0] = new Option('Number', '1');
			sel.options[1] = new Option('File', '2');
			selectType.appendChild(sel); */
			
			var act_col = row.insertCell(2);
			act_col.innerHTML = "<input name=\"button22\" type=\"button\" onClick=\"deleteRow(this);\" value=\"Delete\" />";
		}
	}
	
	
	function keyPressTest(e, obj)
	{
		var validateChkb = document.getElementById('chkValidateOnKeyPress');
		
		if (validateChkb.checked) 
		{
			var displayObj = document.getElementById('spanOutput');
			var key;
			if(window.event) 
			{
				key = window.event.keyCode; 
			} else {
				if(e.which) {
						key = e.which;
				}	
			}
		
			var objId;
			if (obj != null) 
			{
				objId = obj.id;
			} else {
				objId = this.id;
			}
			displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
		}
	}
	
	function deleteRow(row)
	{
		var tbl = document.getElementById('add_param');
		var lastRow = (tbl.rows.length)-1;
		if(lastRow >= 5)
		{
			var i=row.parentNode.parentNode.rowIndex;
			document.getElementById('add_param').deleteRow(i);
		}
	}
	
	function removeRowFromTable()
	{
		var tbl = document.getElementById('add_param');
		var lastRow = (tbl.rows.length)-1;
		if (lastRow >= 5) 
			tbl.deleteRow(lastRow - 1);
	}
	
	function openInNewWindow(frm)
	{
		// open a blank window
		var aWindow = window.open('', 'TableAddRowNewWindow',
		'scrollbars=yes,menubar=yes,resizable=yes,toolbar=no,width=400,height=400');
		
		// set the target to the blank window
		frm.target = 'TableAddRowNewWindow';
		
		// submit
		frm.submit();
	}
	
	function validateRow(frm)
	{
		var chkb = document.getElementById('chkValidate');
		
		if (chkb.checked) 
		{
			var tbl = document.getElementById('tblSample');
			var lastRow = tbl.rows.length - 1;
			var i;
			for (i=1; i<=lastRow; i++) 
			{
				var aRow = document.getElementById('txtRow' + i);
				if (aRow.value.length <= 0) 
				{
					alert('Row ' + i + ' is empty');
					return;
				}
			}
		}
		openInNewWindow(frm);
	}
	
	function saveRegion(frm)
	{
		var tbl = document.getElementById('add_param');
		var num_rows = tbl.rows.length-4;
		var confirm_flag = confirm('Please check again before you submit this region. \n Continue ?');
		if(confirm_flag)
			frm.submit();
		else
			return;
	}

</script>
<style type="text/css">
<!--
.style4 {color: #009966}
.style5 {color: #FF0000}
.style7 {color: #990000; font-weight: bold; font-size: 12px; }
.style36 {color: #33CCFF}
.style39 {font-size: 18px}
.style41 {font-family: Verdana, Arial, Helvetica, sans-serif; color: #FF9900; font-size: small; font-weight: bold; }
.style43 {font-size: small}
.style46 {color: #626262}
-->
</style>
<?php
	$select = array(-1, 1, 2, 3);
	$select[$_REQUEST['select']] = "selected=\"selected\"";
?>
<!-- InstanceEndEditable -->
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
<META content="index, follow" name=robots>
<link type="text/css" rel="stylesheet" href="../../../style/forum.css">
<LINK href="../../../style/style.css" type=text/css rel=stylesheet>
<LINK href="../../../style/column.css" type=text/css rel=stylesheet>
<link href="../../../style/expr.css" type="text/css" rel="stylesheet">
<SCRIPT src="../../../script/mainscript.js" type=text/javascript></SCRIPT>
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
.style4 {color: #CC0000; font-size: 12px; }
.style6 {color: #990000;
	font-weight: bold;
}
.border_bottom {
	border-bottom: 1px solid #CCCCCC;
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
      <td rowspan="2"><img src="../../../image001.png" alt=""></td>
      <td>Tsunami Decision Support System</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2"><img src="../../../Logo-Chula.png" alt="" border="0" usemap="#Map2"></td>
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
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="../../tasks/result.php?section=3">Results</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="../../tasks/search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="../../tasks/bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
      <!--<DIV class=submenu_item id=c5> <A <?=$section[5]?> id=cs_5 href="../user-menu/tasks/jobstat.php?section=5" title="See the visualizatoin result">Status</A> </DIV>-->
      <!-- ################ -->
      <!-- Data Source -->
      <DIV class=menu_item id=c1><A id="cs_1">Data Source </A></DIV>
      <!-- File Browser -->
      <DIV class=submenu_item id=c14> <A <?=$section[6]?> id=cs_14 href="../../data-source/file-browser.php?section=6" title="Go to data source manage page">File Browser </A> </DIV>
      <!-- Simulation Input -->
      <DIV class=submenu_item id=c14><A <?=$section[7]?> id=cs_14 href="../../data-source/ds_list_sim.php?section=7" title="Go to data source manage page">Input Data</A></DIV>
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
      <DIV class=submenu_item id=c14> <A <?=$section[9]?> id=cs_14 href="../../config/observ_point.php?section=9" title="Go to data source manage page">Observation Points </A> </DIV>
      <!-- Expr. Environment -->
      <!--<DIV class=submenu_item id=c14>
        <A <?=$section[12]?> id=cs_14 href="../user-menu/config/expr-envi.php?section=12" title="Go to data source manage page">Environment </A>      </DIV>-->
      <!-- ################ -->
      <!-- Management -->
      <DIV class=menu_item id=c1><A id="cs_1">User</A></DIV>
      <!-- Profile -->
      <!-- Change Password -->
      <DIV class=submenu_item id=c14> <A <?=$section[14]?> id=cs_14 href="../../user/chpass.php?section=14" title="Change your password">Change Password </A>
        <!-- MENU ENDS -->
      </DIV>
      <!-- Logout -->
      <DIV class=submenu_item id=c14><A <?=$section[0]?> id=cs_14 href="../../../library/logout.php" title="Logout of <?=$_SESSION['username']?>"><font color="#CCFF00">Logout</font> <strong>[
        <?=substr($_SESSION['username'], 0, 6)."..."?>
        ]</strong></A> </DIV>
        </DIV>
    <br><center><table><tr><td><div align="center">&nbsp;<img src="../../../logo.jpg" width="100" height="111" style="border:3px" usemap="#Map"></div></td>
    </tr><tr><td><div align="center" class="style2">&nbsp;Thai National Grid Center</div></td>
    </tr></table></center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Create Experiment Name [<span class="style7"><?=$_SESSION['job']['name']?></span>] <!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <fieldset class="ForeCode">
          <legend class="dq_closestoday"><strong>Region </strong></legend>
          <table border="0" cellpadding="5" cellspacing="0" class=" fs14px" style="border:1px #CCCCCC solid">
            <tr bgcolor="#0099CC" align="center" >
              <td bgcolor="#30BFD6"><font color="#FFFFFF"><span class="style25"><strong>Region </strong></span></font></td>
              <td bgcolor="#30BFD6"><font color="#FFFFFF"><span class="style25"><strong>Parent</strong></span></font></td>
              <td bgcolor="#30BFD6"><font color="#FFFFFF"><span class="style25"><strong>Operation</strong></span></font></td>
            </tr>
            <tr align="center">
              <td >1</td>
              <td>Region-2</td>
              <td><input name="view" type="button" id="view" value="View" />
              <input name="add2" type="submit" id="add2" value="Delete" /></td>
            </tr>
            <tr align="center">
              <td colspan="3" ><strong>Empty ! </strong></td>
            </tr>
          </table>
        </fieldset>
		  
	        <table width="10" height="2" border="0">
              <tr>
                <td></td>
              </tr>
            </table>
			<form action="" method="post" name="reg_form_main" id="reg_form_main">
	        <fieldset class="ForeCode">
          <legend class="dq_closestoday"><strong>Create new region</strong></legend>
          <table width="100%" border="0" cellpadding="5" cellspacing="0" class=" fs14px">
            <tr bgcolor="#30BFD6" align="center" >
              <td style="border-bottom:1px #CCCCCC solid"><div align="left">
                <table border="0" cellpadding="2" cellspacing="0">
                  <tr>
                    <td><font color="#FFFFFF"><strong>Select region </strong></font></td>
                    <td><span class="blue">
                    <?php
						$select_opt = array();
						if($_REQUEST['region']) {
							$select_opt[$_REQUEST['region']] = " selected";
						}
					?>
                      <select name="select_reg" id="select_reg" onChange="javascript: location.href='<?=$_SERVER['PHP_SELF']?>?section=2&region='+this.value;">
                        <option value="1" <?=$select_opt[1]?>>1</option>
                        <option value="2" <?=$select_opt[2]?>>2</option>
                        <option value="3" <?=$select_opt[3]?>>3</option>
                        <option value="4" <?=$select_opt[4]?>>4</option>
                      </select>
                    </span></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </div>
              </td>
            </tr>
          </table>
		  <div id="reg1" style="display:">
		  <?php
		  switch($_REQUEST['region'])
		  {
		  	case 1: {
					  ?>
					  <table border="0" cellpadding="5" cellspacing="0" class=" fs14px" style="border:1px #CCCCCC solid;">
						<tr bgcolor="#FFFFCC" align="center" >
						  <td colspan="3"><div align="center">
							<textarea name="R1[description]" cols="40" rows="5" id="R1[description]">Add description on Region 1</textarea>
						  </div></td>
						</tr>
						<tr bgcolor="#FFFFCC" align="center" >
						  <td><span class="style25"><strong>Parameter Name </strong></span></td>
						  <td><span class="style25"><strong>Value</strong></span></td>
						  <td>&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PCOL</div></td>
						  <td class="border_bottom"><input name="R1[PCOL]" type="text" id="R1[PCOL]" size="30" /></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROW</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="R2[PROW]" type="text" id="R2[PROW]" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IF1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="IF1" type="text" id="IF1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JF1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="JF1" type="text" id="JF1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DS1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="DS1" type="text" id="DS1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NDP1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="NDP1" type="text" id="NDP1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NP1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="NP1" type="text" id="NP1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ROWF</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="ROWF" type="text" id="ROWF" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COLF</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="COLF" type="text" id="COLF" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center" bgcolor="#FFFFCC" >
						  <td><span class="style25"><strong>Input</strong></span></td>
						  <td><strong>Select file </strong></td>
						  <td>&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REG1NAME</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="REG1NAME" type="text" id="REG1NAME" size="30" />
						  </span></td>
						  <td class="border_bottom"><input name="button25" type="button" onClick="addRowToTable(param_name_list.value);" value="Select" /></td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEF1_1NAME</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="DEF1_1NAME" type="text" id="DEF1_1NAME" size="30" />
						  </span></td>
						  <td class="border_bottom"><input name="button26" type="button" onClick="addRowToTable(param_name_list.value);" value="Select" /></td>
						</tr>
						<tr align="center">
						  <td><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEF1_2NAME</div></td>
						  <td><span class="border_bottom">
							<input name="DEF1_2NAME" type="text" id="DEF1_2NAME" size="30" />
						  </span></td>
						  <td><input name="button27" type="button" onClick="addRowToTable(param_name_list.value);" value="Select" /></td>
						</tr>
						
					  </table>
					  <?php
					  }
		  			break;
			case 2: {
					  ?>
					  <table border="0" cellpadding="5" cellspacing="0" class=" fs14px" style="border:1px #CCCCCC solid;">
						<tr bgcolor="#FFFFCC" align="center" >
						  <td colspan="3"><div align="center">
							<textarea name="description" cols="40" rows="5" id="description">Add description on region 2</textarea>
						  </div></td>
						</tr>
						<tr bgcolor="#FFFFCC" align="center" >
						  <td><span class="style25"><strong>Parameter Name </strong></span></td>
						  <td><span class="style25"><strong>Value</strong></span></td>
						  <td>&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PCOL</div></td>
						  <td class="border_bottom"><input name="PCOL" type="text" id="PCOL" size="30" /></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PROW</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="PROW" type="text" id="PROW" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IF1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="IF1" type="text" id="IF1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JF1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="JF1" type="text" id="JF1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DS1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="DS1" type="text" id="DS1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NDP1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="NDP1" type="text" id="NDP1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NP1</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="NP1" type="text" id="NP1" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ROWF</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="ROWF" type="text" id="ROWF" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COLF</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="COLF" type="text" id="COLF" size="30" />
						  </span></td>
						  <td class="border_bottom">&nbsp;</td>
						</tr>
						<tr align="center" bgcolor="#FFFFCC" >
						  <td><span class="style25"><strong>Input</strong></span></td>
						  <td><strong>Select file </strong></td>
						  <td>&nbsp;</td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REG1NAME</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="REG1NAME" type="text" id="REG1NAME" size="30" />
						  </span></td>
						  <td class="border_bottom"><input name="button25" type="button" onClick="addRowToTable(param_name_list.value);" value="Select" /></td>
						</tr>
						<tr align="center">
						  <td class="border_bottom" ><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEF1_1NAME</div></td>
						  <td class="border_bottom"><span class="border_bottom">
							<input name="DEF1_1NAME" type="text" id="DEF1_1NAME" size="30" />
						  </span></td>
						  <td class="border_bottom"><input name="button26" type="button" onClick="addRowToTable(param_name_list.value);" value="Select" /></td>
						</tr>
						<tr align="center">
						  <td><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEF1_2NAME</div></td>
						  <td><span class="border_bottom">
							<input name="DEF1_2NAME" type="text" id="DEF1_2NAME" size="30" />
						  </span></td>
						  <td><input name="button27" type="button" onClick="addRowToTable(param_name_list.value);" value="Select" /></td>
						</tr>
						
					  </table>
					  <?php
					  }break;
			}
				
					  ?>
	      <table width="100%" border="0" cellpadding="5" cellspacing="0" class=" fs14px">

            <tr bgcolor="#30BFD6" align="center" >
              <td style="border-bottom:1px #CCCCCC solid"><div align="left">
                <table border="0" cellpadding="2" cellspacing="0">
                  <tr>
                    <td><strong><font color="#FFFFFF">Parent</font></strong></td>
                    <td><span class="blue">
                      <select name="select2" id="select2">
                        <option value="0" selected>Root</option>
                        <option value="1">Region 1</option>
                        <option value="2">Region 2</option>
                        <option value="3">Region 3</option>
                        <option value="4">Region 4</option>
                      </select>
                    </span></td>
                    <td><input name="save2" type="button" id="save2" value="OK" onClick="saveRegion(this.form);"/></td>
                  </tr>
                </table>
              </div>
              </td>
            </tr>
          </table>
		  </div>
	      <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
	      </fieldset>
	  	</form>
	        <table width="10" height="2" border="0">
              <tr>
                <td></td>
              </tr>
            </table>
	        <table border="0" cellpadding="2" cellspacing="0">
            <tr>
              <th scope="col"><input name="Button" type=button id="Button" value="Clear Form" onClick="javascript: location.href='<?=$_SERVER['PHP_SELF']?>?section=2';">
                <input name="next2" type=button id="next2" value="&lt; Back" onClick="javascript: location.href='p1.php';">
                <input name="next" type=submit id="next" value="Next &gt;"></th>
            </tr>
          </table>	   
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
