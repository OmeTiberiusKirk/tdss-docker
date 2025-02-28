<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script language=\"javascript\">location.href='../';</script>";
}
$disable_flag = "";
$flag_display = "none";

if (!isset($_REQUEST['r'])) {
    $_REQUEST['r'] = 1;
}
$path = "../../workspace/" . $_SESSION['username'] . "/files/Simulation/" . $_SESSION['vis_name'] . "/visualization/";
$img_eta_vis = $path . "image_eta_vis_" . $_REQUEST['r'] . "/";

$img_src = $img_eta_vis . "image.tiff.png";
$img_src_colorbar = $img_eta_vis . "colorbar.tiff.png";
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
#Layer1 {
	position:absolute;
	left:4px;
	top:8px;
	width:99%;
	height:60px;
	z-index:1;
}
.style1 {
	font-size: 22px;
	color: #FFFFFF;
}

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
.style39 {color: #990000; font-weight: bold; }
</style>
<script>

<?php
require_once '../../library/tinymce.inc.php';
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
<DIV id="header"><div class="style1" id="Layer1"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><img src="../../image/image001.png" alt="" width="50px" height="50px"></td>
        <td valign="top">&nbsp;</td>
        <td valign=""><table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>Tsunami Decision Support System  <!--<br>
            <font style="size:15px">by <a href="http://ndwc.opencare.org/" target="_blank" style="color:white">National Disaster Warning Center (NDWC)</a> and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University">Chulalongkorn University</a></font>--></td>
            </tr>
          </table></td>
        <td>&nbsp;</td>
        <!--<td valign="top"><img src="../../image/Logo-Chula.png" alt="" height="68" border="0" usemap="#Map2"></td>-->
      </tr>
    </table></div></DIV>
<DIV id="main">
  <!-- MENU STARTS -->
  <DIV class="section bordered">
<H2 id="icon_pick"><img src="../../image/color_theory_small_icon.jpg" alt="" width="14" height="14">Reference ID:
 <font color="#FFFFCC"><?=$_SESSION['vis_name']?></font></H2>
<DIV class="tutorials_list2">
  <div style="border-top:#FF9900 1px solid;background-color:#FFFFCC; padding:4px 4px 4px 4px"><strong>Operations : </strong><span class="f12"><font color="#00c">Select region</font></span>
  <?php
if (isset($_REQUEST['r'])) {
    $select[$_REQUEST['r']] = " selected";
}
?>
  <select name="select" id="select_type" onChange="javascript: window.location='<?=$_SERVER['PHP_SELF'] . "?id=" . $_REQUEST['id'] . "&job_profile_id=" . $_REQUEST['job_profile_id'] . "&r="?>'+this.value+'&grp_id=<?=$_REQUEST['grp_id']?>';">
    <option value="1" <?=$select[1]?>>1</option>
    <option value="2" <?=$select[2]?>>2</option>
    <!--<option value="3" <?//=$select[3]?>>3</option>
    <option value="4" <?//=$select[4]?>>4</option>-->

  </select>
  | <a href="../tasks/search.php?section=4">Home</a></div>
    </DIV>

<DIV class="tutorials_list">
      <table class="pref_all" border="0" style="border:#30BFD6 1px solid">
          <tbody>
            <tr>
              <td colspan="2">
                <table id="HTABS" class="pref_tabs" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td width="65" class="tab q" id="HTAB_0"><a href="general.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>General</nobr></a></td>
                      <!--<td width="213" class="tab q" id="HTAB_1"><a href="wa_time_his.php"><nobr>Wave Animation &amp; Time History</nobr></a></td>-->
                      <td width="141" class="tab_selected" id="HTAB_2"><a href="eta.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>Elapsed Time</nobr></a></td>
                      <td width="52" class="tab q" id="HTAB_3"><a href="z_max.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?><?=isset($_REQUEST['r']) ? "&r=" . $_REQUEST['r'] : ""?>"><nobr>Tsunami&nbsp;Amplitude</nobr></a></td>
                      <!--<td width="131" class="tab q" id="HTAB_5"><a href="inundation.php"><nobr>Inundation Depth</nobr></a></td>-->
                      <!--<td width="68" class="tab q" id="HTAB_6"><a href="velocity.php"><nobr>Velocity</nobr></a></td>-->
                      <td ></td>
                      <td width="8" align="right" valign="top">&nbsp;</td>
                      <td align="right" valign="top">
					  </td>
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
                                  <?php
                                  if(is_file($img_src)) {
                                  ?>
                                    <td align="center" valign="top"><div align="left">
                                        <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:white">
                                        <legend><span class="style39">Image </span></legend>
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
                                  <td valign="top" bgcolor="#000000"><?php if(file_exists($img_src_colorbar)) {?><img src="<?=$img_src_colorbar?>" alt="0" name="slide" border="0" id="slide"><?php } ?></td>
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
                                  <?php
                                  }
                                  ?>
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
                                      <legend><strong><span class="style37">Arrival time </span></strong></legend>
      <table border="0" cellpadding="5" cellspacing="3" class=" tbl_border fs14px" id="tbl01" style="display:">
                                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                                    <td class="tbl_border_right"><strong>No.</strong></td>
                                    <td class="tbl_border_right"><strong>Name</strong></td>
                                    <td class=""><strong>Elapsed Time (H:m)</strong></td>
                                    </tr>
                                  <?php

$order = array_merge(range(2, 6), [1], range(7, 16), range(19, 21), [22, 24, 17, 18, 23], range(25, count($_SESSION['point_eta'])));

$i = 1;
foreach ($order as $id) {
  $elem = $_SESSION['point_eta'][$id];
    ?>
                                  <tr align="center" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                                    <td class="tbl_border_top tbl_border_right"><div align="left">
                                      <?=$i++?>
                                    </div></td>
                                    <td class="tbl_border_top tbl_border_right">

                                      <div align="left">
                                        <?=$elem['name'] . ", " . $elem['province']?>
                                      </div></td>
                                    <td class="tbl_border_top">
                                      <div align="center">
                                        <?php
$res_time = number_format($elem['value_eta'] / 3600, 3);
    $hr = explode(".", $res_time);

    if ($hr[0] == null) {
        $hour = 0;
    } else {
        $hour = $hr[0];
    }

    //echo "hr = ".$hour."  ";

    $min = "0." . $hr[1];
    $mins = $min * 60;
    //echo "min = ".$mins."  ";
    $minutes = explode(".", $mins);
    $minute = $minutes[0];

    $sec = "0." . $minutes[1];
    $sec = $sec * 60;
    $secs = explode(".", $sec);
    $second = $secs[0];
    // check second if more than 60
    if ($second > 60) {
        $second = $second - 60;
        $minute = $minute + 1;
        if ($minute > 60) {
            $minute = $minute - 60;
            $hour = $hour + 1;
            if ($hour > 24) {
                $hour = $hour - 24;
            }
        }
    }
    // check minute if more than 60
    if ($minute > 60) {
        $minute = $minute - 60;
        $hour = $hour + 1;
        if ($hour > 24) {
            $hour = $hour - 24;
        }
    }
    /// check hour if more than 24
    if ($hour > 24) {
        $hour = $hour - 24;
    }
    if ($hour == 24) {
        $hour = 0;
    }

    $hour = (strlen((string) ($hour)) > 1) ? $hour : "0" . $hour;
    $minute = (strlen((string) ($minute)) > 1) ? $minute : "0" . $minute;
    $second = (strlen((string) ($second)) > 1) ? $second : "0" . $second;

    $result_time = $hour . ":" . $minute;
    #echo ($result_time == 0) ? "-" : $result_time;
    echo $result_time;
    ?>
                                        <!--<?php echo $points[$id]['long_1']; ?>° <?php echo $points[$id]['long_2']; ?>' <?php echo $points[$id]['long_3']; ?>"-->
                                      </div></td>
                                    </tr>
                                  <?php
}
?>
                                  <!-- <tr align="center">
                                    <td class="tbl_border_top tbl_border_right"><div align="left">DART534</div></td>
                                    <td class="tbl_border_top tbl_border_right">0°
                                    3' 1 "</td>
                                    <td class="tbl_border_top">91°
                                      53' 58 "</td>
                                    <td class="tbl_border_top">91°
                                      53' 58 "</td>
                                    <td class="tbl_border_top">91°
                                    53' 58 "</td>
                                  </tr> -->
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
<!--<DIV id=footer><a href="../../team.html" target="_blank" style="color:white">Developer Team</a>-->
</DIV>
<!-- 0.0814747692566 (10) -->
</BODY>
</HTML>
