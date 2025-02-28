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
	function SelectVisType(type_t)
	{
		window.location.href='<?=$_SERVER['PHP_SELF']?>?section=3&select='+type_t;
		//alert(type_t);
	}
	
	function  fullsize_image()
	{ 
	
		//$_REQUEST['file_name'] = "../image/wave-animation-3d-r1.png";
		var win = window.open('user.full-size-image.php', 'dummyname', 'status=1,scrollbars=1,resizeable=0', true);	
			
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		win.moveTo(windowWidth, (windowHeight)+150);
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
.style4 {color: #CC0000; font-size: 12px; }
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
	  	  
		       </table>
		       <div align="left">
		<form action="" method="get">
		  <table border="0">
            <tr>
              <th scope="col"><div align="left" class="f12">Choose  Visualization Type</div></th>
              <th scope="col"><img src="../../image/sub_sub_catclose.gif" width="4" height="7"></th>
              <th scope="col"> <select name="select" id="select_type">
                  <option value="1" <?=$select[1]?>>1. Wave Animation</option>
                  <option value="2" <?=$select[2]?>>2. Height</option>
                  <option value="3" <?=$select[3]?>>3. Depth</option>
                  <option value="4" <?=$select[4]?>>4. Velocity</option>
                  <option value="5" <?=$select[5]?>>5. Time History</option>
                  <option value="6" <?=$select[6]?>>6. Height on The Coastline</option>
                  <option value="7" <?=$select[7]?>>7. The Elapsed Time Arrival</option>
                </select>              </th>
              <th scope="col"><input name="go" type="button" id="go" value="Go" onClick="javascript: SelectVisType(select_type.value);"></th>
            </tr>
          </table>
		</form>
        </div><DIV class="line light clear"></DIV>
		<?php
		switch($_REQUEST['select'])
		{
			default :
			case 1 :
		?>
        	<div align="left">
          <table border="0">
            <tr>
              <th rowspan="4" valign="top" class="ForeCode" scope="col"><div align="left"><img src="../../image/1.gif" alt="0" width="28" height="28"></div>              <div align="left"></div></th>
              <th colspan="6" class="ForeCode" scope="col"><div align="left">
                <table border="0">
                      <tr>
                        <th scope="col"><div align="left" class="style4">Name</div></th>
                        <th scope="col"><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></th>
                        <th scope="col"><div align="left" class="f12">&nbsp;Wave Animation </div></th>
                      </tr>
                      <tr>
                        <th scope="row"><div align="left" class="style4">Available on</div></th>
                        <td><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></td>
                        <td><div align="left" class="f12">&nbsp;R1, R2, R3, R4</div></td>
                      </tr>
                  </table>
              </div>              <div align="left"></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center" class="f12">2-Dimension</div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center" class="f12">3-Dimension</div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/wave-animation-2d.jpg&width=200&height=200" border="1" onClick="javascript: fullsize_image();" /></div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/wave-animation-3d.jpg&width=200&height=200" border="1" /></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit" type=submit class=butenter id=submit style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=1&style=2d';">
              </div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit2" type=submit class=butenter id=submit2 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=2&type=1&style=3d';">
              </div></th>
            </tr>
          </table>
        </div>
        <?php
				break;
			case 2 :
			?>
			<div align="left">
          <table border="0">
            
            
            <tr>
              <th rowspan="4" valign="top" class="ForeCode" scope="col"><div align="left"><img src="../../image/2.gif" alt="0" width="28" height="28"></div>
                  <div align="left"></div></th>
              <th colspan="6" class="ForeCode" scope="col"><div align="left">
                  <table border="0">
                    <tr>
                      <th scope="col"><div align="left" class="style4">Name</div></th>
                      <th scope="col"><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></th>
                      <th scope="col"><div align="left" class="f12">&nbsp;Height</div></th>
                    </tr>
                    <tr>
                      <th scope="row"><div align="left" class="style4">Available on</div></th>
                      <td><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></td>
                      <td><div align="left" class="f12">&nbsp;R1, R2, R3, R4</div></td>
                    </tr>
                  </table>
              </div>
                  <div align="left"></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center" class="f12">2-Dimension</div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center" class="f12">3-Dimension</div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/height-2d.jpg&width=200&height=200" border="1" /></div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/height-3d.jpg&width=200&height=200" border="1" /></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center">
                <input name="submit34" type=submit class=butenter id=submit34 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=2&style=2d';" 	>
              </div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit4" type=submit class=butenter id=submit4 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=2&style=3d';">
              </div></th>
            </tr>
          </table>
        </div>
        <?php
				break;
			case 3 :
			?>
		<div align="left">
          <table border="0">
            
            
            <tr>
              <th rowspan="4" valign="top" class="ForeCode" scope="col"><div align="left"><img src="../../image/3.gif" alt="0" width="28" height="28"></div>
              <div align="left"></div></th>
              <th colspan="6" class="ForeCode" scope="col"><div align="left">
                  <table border="0">
                    <tr>
                      <th scope="col"><div align="left" class="style4">Name</div></th>
                      <th scope="col"><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></th>
                      <th scope="col"><div align="left" class="f12">&nbsp;Depth</div></th>
                    </tr>
                    <tr>
                      <th scope="row"><div align="left" class="style4">Available on</div></th>
                      <td><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></td>
                      <td><div align="left" class="f12">&nbsp;R1, R2, R3, R4</div></td>
                    </tr>
                  </table>
              </div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center" class="f12">2-Dimension</div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center" class="f12">3-Dimension</div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/depth-2d.jpg&width=200&height=200" border="1" /></div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/depth-3d.jpg&width=200&height=200" border="1" /></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit32" type=submit class=butenter id=submit32 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=3&style=2d';">
              </div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit33" type=submit class=butenter id=submit33 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=3&style=3d';">
              </div></th>
            </tr>
          </table>
        </div>
        <?php
				break;
			case 4 :
			?>
			        	<div align="left">
          <table border="0">
            <tr>
              <th rowspan="4" valign="top" class="ForeCode" scope="col"><div align="left"><img src="../../image/4.gif" alt="0" width="28" height="28"></div>              
              <div align="left"></div></th>
              <th colspan="6" class="ForeCode" scope="col"><div align="left">
                <table border="0">
                      <tr>
                        <th scope="col"><div align="left" class="style4">Name</div></th>
                        <th scope="col"><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></th>
                        <th scope="col"><div align="left" class="f12">&nbsp;Velocity </div></th>
                      </tr>
                      <tr>
                        <th scope="row"><div align="left" class="style4">Available on</div></th>
                        <td><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></td>
                        <td><div align="left" class="f12">&nbsp;R1, R2, R3, R4</div></td>
                      </tr>
                  </table>
              </div>              <div align="left"></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center" class="f12">2-Dimension</div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center" class="f12">3-Dimension</div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/velocity-2d.jpg&width=200&height=200" border="1" /></div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/velocity-3d.jpg&width=200&height=200" border="1" /></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center">
                <input name="submit5" type=submit class=butenter id=submit5 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=4&style=2d';">
              </div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit2" type=submit class=butenter id=submit2 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=4&style=3d';">
              </div></th>
            </tr>
          </table>
        </div>
        <?php
				break;
				case 5 :
		?>
				<div align="left">
          <table border="0">
            
            
            <tr>
              <th rowspan="4" valign="top" class="ForeCode" scope="col"><div align="left"><img src="../../image/5.gif" alt="0" width="28" height="28"></div></th>
              <th colspan="6" class="ForeCode" scope="col"><div align="left">
                  <table border="0">
                    <tr>
                      <th scope="col"><div align="left" class="style4">Name</div></th>
                      <th scope="col"><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></th>
                      <th scope="col"><div align="left" class="f12">&nbsp;Time History </div></th>
                    </tr>
                    <tr>
                      <th scope="row"><div align="left" class="style4">Available on</div></th>
                      <td><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></td>
                      <td><div align="left" class="f12">&nbsp;R1, R2, R3, R4</div></td>
                    </tr>
                  </table>
              </div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center" class="f12">2-Dimension</div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center" class="f12">3-Dimension</div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/Time-His.jpg&width=200&height=200" border="1" /></div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/Time-His.jpg&width=200&height=200" border="1" /></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit32" type=submit class=butenter id=submit32 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=5&style=2d';">
              </div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit33" type=submit class=butenter id=submit33 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=5&style=3d';" disabled="disabled">
              </div></th>
            </tr>
          </table>
        </div>
		<?php
		 break;
		 case 6 :
		?>
		<div align="left">
          <table border="0">
            
            
            <tr>
              <th rowspan="4" valign="top" class="ForeCode" scope="col"><div align="left"><img src="../../image/6.gif" alt="0" width="28" height="28"></div></th>
              <th colspan="6" class="ForeCode" scope="col"><div align="left">
                  <table border="0">
                    <tr>
                      <th scope="col"><div align="left" class="style4">Name</div></th>
                      <th scope="col"><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></th>
                      <th scope="col"><div align="left" class="f12">&nbsp;Height on The Coastline  </div></th>
                    </tr>
                    <tr>
                      <th scope="row"><div align="left" class="style4">Available on</div></th>
                      <td><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></td>
                      <td><div align="left" class="f12">&nbsp;R1, R2, R3, R4</div></td>
                    </tr>
                  </table>
              </div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center" class="f12">2-Dimension</div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center" class="f12">3-Dimension</div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/height-on-the-cosatline.jpg&width=200&height=200" border="1" /></div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/height-on-the-cosatline.jpg&width=200&height=200" border="1" /></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center">
                <input name="submit322" type=submit class=butenter id=submit322 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=6&style=2d';">
              </div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit33" type=submit class=butenter id=submit33 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=6&style=3d';" disabled="disabled">
              </div></th>
            </tr>
          </table>
        </div>
		<?php
		 break;
		 case 7 :
		?>
				<div align="left">
          <table border="0">
            
            
            <tr>
              <th rowspan="4" valign="top" class="ForeCode" scope="col"><div align="left">
                <div align="left"><img src="../../image/7.gif" alt="0" width="28" height="28"></div>
              </div></th>
              <th colspan="6" class="ForeCode" scope="col"><div align="left">
                  <table border="0">
                    <tr>
                      <th scope="col"><div align="left" class="style4">Name</div></th>
                      <th scope="col"><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></th>
                      <th scope="col"><div align="left" class="f12">The Elapsed Time Arrival</div></th>
                    </tr>
                    <tr>
                      <th scope="row"><div align="left" class="style4">Available on</div></th>
                      <td><img src="../../image/dot_arrow.gif" alt="0" width="5" height="12"></td>
                      <td><div align="left" class="f12">&nbsp;R1, R2, R3, R4</div></td>
                    </tr>
                  </table>
              </div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center" class="f12">2-Dimension</div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center" class="f12">3-Dimension</div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/elapsed-time-2d.jpg&width=200&height=200" border="1" /></div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center"><img src="../../library/resize-image.php?filename=../image/elapsed-time-3d.jpg&width=200&height=200" border="1" /></div></th>
            </tr>
            <tr>
              <th class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit32" type=submit class=butenter id=submit32 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=7&style=2d';">
              </div></th>
              <th colspan="5" class="ForeCode" scope="col"><div align="center">
                <INPUT name="submit33" type=submit class=butenter id=submit33 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value=Create onClick="javascript: document.location.href='newvis-form.php?section=3&type=7&style=3d';">
              </div></th>
            </tr>
          </table>
        </div>
		<?php
		 break;
		?>
        <?php
		}
		?>
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
