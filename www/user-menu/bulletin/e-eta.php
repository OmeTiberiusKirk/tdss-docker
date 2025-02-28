<?php
	session_start();
	
	if(!isset($_SESSION['username']))
	{
		echo "<script language=\"javascript\">location.href='../';</script>";
	}
	$disable_flag = "";
	$flag_display = "none";
	
	if(!isset($_REQUEST['r'])) {
		$_REQUEST['r'] = 1;
	}
	$path = "../../workspace/".$_SESSION['username']."/files/Simulation/".$_SESSION['vis_name']."/visualization/";
	$img_eta_vis = $path."image_eta_vis_".$_REQUEST['r']."/";
	
	$img_src = $img_eta_vis."image.tiff.png";
	$img_src_colorbar = $img_eta_vis."colorbar.tiff.png";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>Web Portal :: Operation and Research Section</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
<META content="index, follow" name=robots>
<link type="text/css" rel="stylesheet" href="../../style/forum.css">
<LINK href="../../style/style.css" type=text/css rel=stylesheet>
<LINK href="../../style/column.css" type=text/css rel=stylesheet>
<SCRIPT src="../../script/mainscript.js" type=text/javascript></SCRIPT>
<!--<script src="../script/submenu.js" type="text/javascript"></script>-->
<META content="MSHTML 6.00.2900.2769" name=GENERATOR>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:7px;
	top:13px;
	width:658px;
	height:31px;
	z-index:1;
}
.style1 {
	font-size: 22px;
	color: #FFFFFF;
}
-->
</style>
<style>
a:active { color:#f00 }
a:visited { color:#551a8b }
a:link { color:#00c }
a.c:active { color: #ff0000 }
a.c:visited { color: #7777cc }
a.c:link { color: #7777cc }
.b { font-weight: bold }
.shaded-header { background-color: #CCE5ED; border-top: 1px solid #39c;
margin: 0px; padding: 0px }
.shaded-subheader { background-color: #CCE5ED; margin: 12px 0px 0px 0px;
 padding: 0px }
.plain-subheader { background-color: #fff; margin: 12px 0px 0px 0px;
 padding: 0px }
.header-element { margin: 0px; padding: 2px}
.expand { width: 98% }
.s { font-size: smaller }
.prefgroup { width: 100% }
.phead { /*font-weight: bold; font-size: smaller; */vertical-align: top;
border-bottom: 2px solid #CCE5ED; margin: 0px;
padding: 16px 8px 16px 8px}
.pbody { border-bottom: 2px solid #CCE5ED; margin: 0px;
padding: 16px 8px 16px 8px}
.pref-last { border-bottom: 0px}
.example { color: gray; font-family: monospace; }
.q a:visited,.q a:link,.q a:active,.q {color: #00c; }
.pref_all {background-color: #CCE5ED; margin:0px 0 0px 0; padding: 4px 4px 4px 4px; width: 100%;}
.pref_tabs { /*font-size: smaller;*/ margin:0 0 0 0; padding: 0 0 0 0; border: none; width: 100%;}
.pref_content { background-color: #ffffff; margin:0 0 0 0; width: 100%;}

.tab { width: 1px; font-weight: bold;  text-align: center; white-space: nowrap; margin: 0 0 0 0; padding: .2em .8em .4em .8em;}
.tab a:visited {font-color:#00c;}
.tab_selected { width: 1px; background-color: #ffffff; font-weight: bold;text-align: center; white-space: nowrap; margin: 0 0 0 0; padding: .2em .8em .4em .8em;}
table.data {border:1px solid #E0E0E0; width:80%;}
table.data td {border-bottom:1px solid #E0E0E0; padding:2px 4px 2px 4px;}
table.data td.action {background-color: #E0E0E0;}
table.data td.action input {font-size:.9em;}
table.data td.last {border:none;}
table.data th {font-weight:bold; text-align:left; border-bottom:1px solid #E0E0E0; padding:2px 4px 2px 4px; background-color:#E8E8E8;}
.detail {color:#008800}
.error {border:1px solid #ff0033;}
td.qf {padding-top:10px;}
ul {margin-top:0}
#whitelistTABLE, #blacklistTABLE, #policywhitelistTABLE, {margin: 0px 0px 0px 15px;}
.style37 {color: #990000}
.tbl_border {border:black 1px solid; }
.tbl_border_right {border-right:black 1px solid; }
.tbl_border_top {border-top:black 1px solid; }
</style>
<script>
<!--
<?php 
	require_once('../../library/tinymce.inc.php');
	tinymce(true);
?>
</HEAD>
<script language="javascript">
	for (var i = 0; i < 7 ; i++) {
		document.getElementById("HTAB_" + i).className = (i == <?=$_REQUEST['tab']?>) ? "tab_selected" : "tab q";
		document.getElementById("TAB_" + i).style.display = (i == <?=$_REQUEST['tab']?>) ? "" : "none";
	}
</script>
<BODY>
<div class="style1" id="Layer1"><table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td rowspan="2"><img src="../../image001.png" alt=""></td>
      <td>Tsunami Decision Support System</td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2"><img src="../../Logo-Chula.png" alt="" border="0" usemap="#Map2"></td>
    </tr>
    <tr>
      <td><font style="size:14px">by National Disaster Warning Center (NDWC) and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University">Chulalongkorn University</a></font> </td>
    </tr>
  </table></div>
<DIV id=header></DIV>
<DIV id=main>
  <!-- MENU STARTS -->
  <DIV class="section bordered">
<H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" alt="" width="14" height="14">Simulation&nbsp;Name:
  <?=$_SESSION['vis_name']?>
  &nbsp;</H2>
<DIV class=tutorials_list>
      <table class="pref_all" border="0" style="border:#30BFD6 1px solid">
          <tbody>
            <tr>
              <td colspan="2"><!-- TABS -->
                <table id="HTABS" class="pref_tabs" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td width="65" class="tab q" id="HTAB_0"><a href="general.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>General</nobr></a></td>
                      <!--<td width="213" class="tab q" id="HTAB_1"><a href="wa_time_his.php"><nobr>Wave Animation &amp; Time History</nobr></a></td>-->
                      <td width="141" class="tab_selected" id="HTAB_2"><a href="eta.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>Elapsed Time</nobr></a></td>
                      <td width="52" class="tab q" id="HTAB_3"><a href="z_max.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>Wave Height</nobr></a></td>
                      <!--<td width="131" class="tab q" id="HTAB_5"><a href="inundation.php"><nobr>Inundation Depth</nobr></a></td>
                      <td width="68" class="tab q" id="HTAB_6"><a href="velocity.php"><nobr>Velocity</nobr></a></td>-->
                      <td >					  </td>
                      <td width="8" align="right" valign="top">&nbsp;</td>
                      <td align="right" valign="top">
					  <table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <th scope="col"><div align="left" class="f12">Region</div></th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col"> <?php
									if(isset($_REQUEST['r'])) {
										$select[$_REQUEST['r']] = " selected";
									}
								?><form method="get" name="load_region" id="load_region">
                                      <select name="select" id="select_type" onChange="javascript: window.location='<?=$_SERVER['PHP_SELF']."?id=".$_REQUEST['id']."&job_profile_id=".$_REQUEST['job_profile_id']."&r="?>'+this.value+'&grp_id=<?=$_REQUEST['grp_id']?>';">
                                        <option value="1" <?=$select[1]?>>1</option>
                                        <option value="2" <?=$select[2]?>>2</option>
                                       <!-- <option value="3" <?//=$select[3]?>>3</option>
                                        <option value="4" <?//=$select[4]?>>4</option>
                                       --> 
                                      </select>
                                    </form></th>
                                <th scope="col">&nbsp;</th>
                              </tr>
                            </table></td>
                            <td><a href="javascript: void();" onClick="javascript: window.location='../tasks/result.php?section=3&grp_id=<?=$_REQUEST['grp_id']?>';">Back</a></td>
                            <td>&nbsp;</td>
                            <td><a href="javascript: void();" onClick="javascript: window.location='<?=$_SERVER['REQUEST_URI']?>'">Reload</a></td>
                          </tr>
                      </table></td>
                    </tr>
                  </tbody>
                </table>
               <table class="pref_content">
     			   <tr>
                        <td class="ForeCode">
						<table id="TAB_2" class="prefgroup" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td align="center" valign="top"><div align="left">
                                        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:white">
                                        <legend><span class="style37">Image </span></legend>
                                        <div align="center">
                                          <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td colspan="3" valign="top" bgcolor="#000000"><div align="center"></div></td>
                                            </tr>
                                            <tr>
                                              <td colspan="3" valign="top" bgcolor="#000000"><div align="center"></div></td>
                                            </tr>
                                            <tr>
                                              <td colspan="3" valign="top" bgcolor="#000000">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td valign="top" bgcolor="#000000"><table border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                    <td>&nbsp;</td>
                                                    <td valign="top"><img src="<?=$img_src?>"></td>
                                                    <td><img src="../../image/space_black.jpg" alt="0" width="17" height="50"></td>
                                                  </tr>
                                                  <tr>
                                                    <td><img src="../../image/space_black.jpg" alt="0" width="17" height="50"></td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                              </table></td>
                                              <td valign="top" bgcolor="#000000"><img src="<?=$img_src_colorbar?>" alt="0" name="slide" border="0" id="slide"></td>
                                              <td bgcolor="#000000"><img src="../../image/space_black.jpg" alt="0" width="17" height="50"></td>
                                            </tr>
                                            <tr>
                                              <td valign="top" bgcolor="#000000"></td>
                                              <td bgcolor="#000000"><img src="../../image/space_black.jpg" alt="0" width="18" height="13"></td>
                                              <td bgcolor="#000000"></td>
                                            </tr>
                                          </table>
                                        </div>
                                      </fieldset>
                                      </div></td>
                                    <td valign="top"><!--<fieldset>
                                      <legend><span class="style39">Adding Contour Line </span></legend>
                                      <table border="1" cellpadding="5" cellspacing="0" class=" fs14px">
                                        <tr align="center">
                                          <td bgcolor="#B1C3D9" align="center"><span class="style25 style42"><strong>Time (min) </strong></span></td>
                                          <td >
										  <form name="form2" method="post" action="">
                                            <label>
                                              <input type="text" name="textfield2">
                                            </label>
                                          </form>										  </td>
                                        </tr>
										<tr align="center">
                                          <td colspan="2"><input name="Add" type="button" value="Add"></td>
                                        </tr>
                                      </table>
                                    </fieldset>--></td>
									 <td valign="top"><fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:white">
                                      <legend><span class="style37">Arrival time </span></legend>
                                      <table border="1" cellpadding="5" cellspacing="0" class=" fs14px">
                                        <tr bgcolor="#FFFFCC" align="center" >
                                          <td><span class="style25"><strong>No.</strong></span></td>
                                          <td><span class="style25"><strong>Name</strong></span></td>
                                          <td><strong>Elapsed Time<span class="f11">(h:m)</span></strong></td>
                                        </tr>
                                        <?php
										$i  = 1;
										foreach($_SESSION['point_eta'] as $id => $elem) {
                                        ?>
                                        <tr align="center" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                                          <td><?=$i++?></td>
                                          <td><div align="left"><?=$elem['name']?></div></td>
                                          <td ><?php
                                          $res_time = number_format($elem['value_eta']/3600, 3);
										  $hr = explode(".", $res_time);
	
											if($hr[0] == NULL)
												$hour = 0;
											else
												$hour = $hr[0];
												
											//echo "hr = ".$hour."  ";
											
											$min = "0.".$hr[1]; 
											$mins = $min * 60;
											//echo "min = ".$mins."  ";
											$minutes = explode(".", $mins);	
											$minute = $minutes[0] ;
															
											$sec = "0.".$minutes[1];
											$sec = $sec * 60;
											$secs = explode(".", $sec);
											$second = $secs[0];
											// check second if more than 60
											if($second > 60){
												$second = $second - 60;
												$minute = $minute + 1;
												if($minute > 60){
													$minute = $minute - 60;
													$hour = $hour + 1;
													if($hour > 24 ){
														$hour = $hour - 24;
													}
												}
											}
											// check minute if more than 60
											if($minute > 60 ){
												$minute = $minute - 60;
												$hour = $hour +1;
												if($hour > 24){
													$hour = $hour -24;
												}
											}
											/// check hour if more than 24
											if($hour > 24 ){
												$hour = $hour - 24;
											}
											if($hour == 24){
												$hour = 0;
											}
											
											$hour = (strlen((string)($hour)) > 1) ? $hour : "0".$hour;
											$minute = (strlen((string)($minute)) > 1) ? $minute : "0".$minute;
											$second = (strlen((string)($second)) > 1) ? $second : "0".$second;
																
											$result_time = $hour.":".$minute;
											echo $result_time;
										  ?></td>
                                        </tr>
                                        <?php
                                        }
										?>
                                      </table>
                                    </fieldset></td>
                                  </tr>
                                </table></td>
                              </tr>
                          </table>
               	  </td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td></td>
              <td id="last_cell" valign="top" align="right"></td>
            </tr>
          </tbody>
        </table>
      </DIV>
  </DIV>
</DIV>
<DIV id=footer><SPAN>Partners:</SPAN><A href="http://www.cp.eng.chula.ac.th" target=_blank>Department of Computer Engineering</A>and<A href="http://www.ce.eng.chula.ac.th" target=_blank>Department of Civil Engineering</A>, <a href="http://www.chula.ac.th" target="_blank">Chulalongkorn University</a> | <A href="http://www.thaigrid.or.th" target=_blank>Thai National Grid Center (TNGC)</A></DIV>
<!-- 0.0814747692566 (10) -->
</BODY>
</HTML>
