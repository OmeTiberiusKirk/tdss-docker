<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script language=\"javascript\">location.href='../';</script>";
}
$result_id = $_REQUEST['id'];
$job_profile_id = $_REQUEST['job_profile_id'];

require_once '../../library/connectdb.inc.php';
$sql = "SELECT * FROM `sim_result` WHERE `job_profile_id` = " . $job_profile_id;
$res = mysql_query($sql, $connection) or die("! death");
if (mysql_num_rows($res) == 1) {
    $obj_sim_result = mysql_fetch_object($res);
}

/*********** REGION 2 ***************/
$sql = "SELECT
				`observe_point`.`observ_point_id`,
				`observe_point`.`name_t`,
				`observe_point`.`lat_1`,
				`observe_point`.`lat_2`,
				`observe_point`.`lat_3`,
				`observe_point`.`long_1`,
				`observe_point`.`long_2`,
				`observe_point`.`long_3`,
				`observe_point`.`decimal_lat`,
				`observe_point`.`decimal_long`,
				`sim_point_val`.`values`,
				`sim_point_val`.`type`,
				`sim_point_val`.`region_no`
			FROM `observe_point`, `sim_point_val`
			WHERE
				`observe_point`.`observ_point_id` = `sim_point_val`.`id_point` AND
				`sim_point_val`.`type` = 'ETA' AND
				((`sim_point_val`.`region_no` = 2 AND `observe_point`.`R2` = 'yes') OR (`sim_point_val`.`region_no` = 1 AND `observe_point`.`R1` = 'yes')) AND
        `sim_point_val`.`sim_result_id` = " . $result_id;
$sql_observation_point_ETA = $sql;

//ORDER BY `observe_point`.`decimal_long` ASC";
$res_point = mysql_query($sql, $connection) or die("! death");
$observation_point_ETA_numrows = mysql_num_rows($res_point);

while ($obj_eta = mysql_fetch_object($res_point)) {
    $points[$obj_eta->observ_point_id]['name'] = $obj_eta->name_t;
    $points[$obj_eta->observ_point_id]['lat_1'] = $obj_eta->lat_1;
    $points[$obj_eta->observ_point_id]['lat_2'] = $obj_eta->lat_2;
    $points[$obj_eta->observ_point_id]['lat_3'] = $obj_eta->lat_3;
    $points[$obj_eta->observ_point_id]['long_1'] = $obj_eta->long_1;
    $points[$obj_eta->observ_point_id]['long_2'] = $obj_eta->long_2;
    $points[$obj_eta->observ_point_id]['long_3'] = $obj_eta->long_3;
    $points[$obj_eta->observ_point_id]['decimal_lat'] = $obj_eta->decimal_lat;
    $points[$obj_eta->observ_point_id]['decimal_long'] = $obj_eta->decimal_long;
    $points[$obj_eta->observ_point_id]['value_eta'] = $obj_eta->values;
}
$_SESSION['point_eta'] = $points;

$sql = "SELECT
				`observe_point`.`observ_point_id`,
				`observe_point`.`name_t`,
				`observe_point`.`lat_1`,
				`observe_point`.`lat_2`,
				`observe_point`.`lat_3`,
				`observe_point`.`long_1`,
				`observe_point`.`long_2`,
				`observe_point`.`long_3`,
				`observe_point`.`decimal_lat`,
				`observe_point`.`decimal_long`,
				`sim_point_val`.`values`,
				`sim_point_val`.`type`
			FROM `observe_point`, `sim_point_val`
			WHERE
				`observe_point`.`observ_point_id` = `sim_point_val`.`id_point` AND
				`sim_point_val`.`type` = 'ZMAX' AND
				((`sim_point_val`.`region_no` = 2 AND `observe_point`.`R2` = 'yes') OR (`sim_point_val`.`region_no` = 1 AND `observe_point`.`R1` = 'yes')) AND
        `sim_point_val`.`sim_result_id` = " . $result_id;

$sql_observation_point_ZMAX = $sql;

//ORDER BY `observe_point`.`decimal_long` ASC";
$res_point = mysql_query($sql, $connection) or die("! death");
$observation_point_ZMAX_numrows = mysql_num_rows($res_point);

while ($obj_zmax = mysql_fetch_object($res_point)) {
    $points[$obj_zmax->observ_point_id]['name'] = $obj_zmax->name_t;
    $points[$obj_zmax->observ_point_id]['value_zmax'] = number_format($obj_zmax->values, 2);
}

/*********** END REGION 2 **************/

/* query input */
$sql = "SELECT * FROM `sim_visfile` WHERE `id_sim_result` = " . $result_id;
$res = mysql_query($sql, $connection) or die("! could not query inputs.");

$_SESSION['point_zmax'] = $points;

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
<style>
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
	position: absolute;
	top: 10%;
	left: 10%;
	width: 80%;
	height: 80%;
	padding: 2px;
	border: 2px solid orange;
	background-color: white;
	z-index:1002;
	overflow: hidden;
}
</style>
<META content="MSHTML 6.00.2900.2769" name=GENERATOR>
<style type="text/css">
<!--
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
-->
</style>
<style>
a:active {
	color:#f00
}
a:visited {
	color:#551a8b
}
a:link {
	color:#00c
}
a.c:active {
	color: #ff0000
}
a.c:visited {
	color: #7777cc
}
a.c:link {
	color: #7777cc
}
.b {
	font-weight: bold
}
.shaded-header {
	background-color: #CCE5ED;
	border-top: 1px solid #39c;
	margin: 0px;
	padding: 0px
}
.shaded-subheader {
	background-color: #CCE5ED;
	margin: 12px 0px 0px 0px;
	padding: 0px
}
.plain-subheader {
	background-color: #fff;
	margin: 12px 0px 0px 0px;
	padding: 0px
}
.header-element {
	margin: 0px;
	padding: 2px
}
.expand {
	width: 98%
}
.s {
	font-size: smaller
}
.prefgroup {
	width: 100%
}
.phead { /*font-weight: bold; font-size: smaller; */
	vertical-align: top;
	border-bottom: 2px solid #CCE5ED;
	margin: 0px;
	padding: 16px 8px 16px 8px
}
.pbody {
	border-bottom: 2px solid #CCE5ED;
	margin: 0px;
	padding: 16px 8px 16px 8px
}
.pref-last {
	border-bottom: 0px
}
.example {
	color: gray;
	font-family: monospace;
}
.q a:visited, .q a:link, .q a:active, .q {
	color: #00c;
}
.pref_all {
	background-color: #CCE5ED;
	margin:0px 0 0px 0;
	padding: 4px 4px 4px 4px;
	width: 100%;
}
.pref_tabs { /*font-size: smaller;*/
	margin:0 0 0 0;
	padding: 0 0 0 0;
	border: none;
	width: 100%;
}
.pref_content {
	background-color: #ffffff;
	margin:0 0 0 0;
	width: 100%;
}
.tab {
	width: 1px;
	font-weight: bold;
	text-align: center;
	white-space: nowrap;
	margin: 0 0 0 0;
	padding: .2em .8em .4em .8em;
}
.tab a:visited {
	font-color:#00c;
}
.tab_selected {
	width: 1px;
	background-color: #ffffff;
	font-weight: bold;
	text-align: center;
	white-space: nowrap;
	margin: 0 0 0 0;
	padding: .2em .8em .4em .8em;
}
table.data {
	border:1px solid #E0E0E0;
	width:80%;
}
table.data td {
	border-bottom:1px solid #E0E0E0;
	padding:2px 4px 2px 4px;
}
table.data td.action {
	background-color: #E0E0E0;
}
table.data td.action input {
	font-size:.9em;
}
table.data td.last {
	border:none;
}
table.data th {
	font-weight:bold;
	text-align:left;
	border-bottom:1px solid #E0E0E0;
	padding:2px 4px 2px 4px;
	background-color:#E8E8E8;
}
.detail {
	color:#008800
}
.error {
	border:1px solid #ff0033;
}
td.qf {
	padding-top:10px;
}
ul {
	margin-top:0
}
#whitelistTABLE, #blacklistTABLE, #policywhitelistTABLE, {
margin: 0px 0px 0px 15px;
}
.style37 {
	color: #990000
}
.tbl_border {
	border:black 1px solid;
}
.tbl_border_right {
	border-right:black 1px solid;
}
.tbl_border_top {
	border-top:black 1px solid;
}
</style>
<script>
<!--
	function change_time() {
		/* tbl01 click */
		if(document.getElementById('tbl02').style.display == 'none') {
			document.getElementById('tbl02').style.display = '';
			document.getElementById('tbl01').style.display = 'none';
		}else {
			/* tbl02 click */
			if(document.getElementById('tbl01').style.display == 'none') {
				document.getElementById('tbl01').style.display = '';
				document.getElementById('tbl02').style.display = 'none';
			}
		}
	}

// -->
</script>
<?php
require_once '../../library/tinymce.inc.php';
tinymce(true);
?>
</HEAD>
<script language="javascript">

  /* numrows = <?php echo $observation_point_ETA_numrows; ?>
  <?php echo $sql_observation_point_ETA ?>
  */

  /* numrows = <?php echo $observation_point_ZMAX_numrows; ?>
  <?php echo $sql_observation_point_ZMAX; ?>
  */
</script>
<BODY>
<DIV id=header>
  <div class="style1" id="Layer1">
  <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><img src="../../image/image001.png" alt="" width="50px" height="50px"></td>
        <td valign="top">&nbsp;</td>
        <td valign=""><table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>Tsunami Decision Support System</td>
            </tr>
          </table></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
</DIV>
<DIV id=main>
  <!-- MENU STARTS -->
  <DIV class="section bordered">
    <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">Reference ID: <font color="#FFFFCC">
      <?php $_SESSION['vis_name'] = $obj_sim_result->name;
echo $obj_sim_result->name;?>
      </font></H2>
    <DIV class=tutorials_list2>
      <div style="border-top:#FF9900 1px solid;background-color:#FFFFCC; padding:4px 4px 4px 4px"><strong>Operations : </strong><a href="../tasks/search.php?section=4">Home</a></div>
    </DIV>
    <DIV class=tutorials_list>
      <table class="pref_all" border="0" style="border:#30BFD6 1px solid">
        <tbody>
          <tr>
            <td colspan="2"><!-- TABS -->
              <table id="HTABS" class="pref_tabs" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr>
                    <td id="HTAB_0" class="tab_selected"><a href="general.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>General</nobr></a></td>
                    <td id="HTAB_2" class="tab q"><a href="eta.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>Elapsed Time</nobr></a></td>
                    <td id="HTAB_3" class="tab q"><a href="z_max.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>Tsunami Amplitude</nobr></a></td>
                    <td valign="top" align="right">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
              <table class="pref_content">
                <tr>
                  <td class="ForeCode"><table style="" id="TAB_0" class="prefgroup" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td valign="top"><fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
                                <legend class="style37"><strong>General information</strong></legend>
                                <form action="../../library/update-expr.php" method="post" name="expr">
                                  <table border="0" cellpadding="6" cellspacing="0">
                                    <tr>
                                      <td valign="top"><strong>Group Name</strong></td>
                                      <td valign="top"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                      <td><?php
if (isset($_REQUEST['grp_id']) && $_REQUEST['grp_id'] > 0) {
    $sql = "SELECT * FROM `observe_group` WHERE `id` = " . $_REQUEST['grp_id'];
    $rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
    $obj = mysql_fetch_object($rg);
    $g_default_name = $obj->g_name;
    $g_default_id = $obj->id;
}
echo $g_default_name;
?></td>
                                    </tr>


                                    <tr>
                                      <td valign="middle"><strong>Magnitude</strong></td>
                                      <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                      <td><?=$obj_sim_result->magnitude?></td>
                                    </tr>
                                    <tr>
                                      <td valign="middle"><strong>Depth</strong></td>
                                      <td><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                      <td><?=$obj_sim_result->depth?>&nbsp;km.</td>
                                    </tr>
                                    <tr>
                                      <td valign="top"><strong>Location</strong></td>
                                      <td valign="top"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></td>
                                      <td><table width="0" border="0" cellspacing="0" cellpadding="3">
                                          <tr>
                                            <td>Latitude</td>
                                            <td>&nbsp;</td>
                                            <td>=</td>
                                            <td>&nbsp;</td>
                                            <td><font color="#000099"><?=$obj_sim_result->decimal_lat?></font></td>
                                          </tr>
                                          <tr>
                                            <td>Longitude</td>
                                            <td>&nbsp;</td>
                                            <td>=</td>
                                            <td>&nbsp;</td>
                                            <td><font color="#000099"><?=$obj_sim_result->decimal_long?></font></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                  </table>
                                </form>
                                </fieldset>
                                <?php
/* query for input data */
?>
                              </td>
                              <td valign="top">&nbsp;</td>
                              <td valign="top"><fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:#FFFFFF">
                                <legend class="style37"><strong>Table of observation points</strong></legend>
                                <table border="0" cellpadding="5" cellspacing="3" class=" tbl_border fs14px" id="tbl01" style="display:">
                                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                                    <td class="tbl_border_right"><strong>Name</strong></td>
                                    <td class="tbl_border_right"><strong>Latitude</strong></td>
                                    <td class="tbl_border_right"><strong>Longitude</strong></td>
                                    <td class="tbl_border_right" onClick="javascript: change_time();"><strong>Elapsed Time (h:m)</strong></td>
                                    <td class=""><strong>Tsunami&nbsp;Amplitude&nbsp;(m)</strong></td>
                                  </tr>
                                  <?php
$i = 1;
foreach ($points as $id => $elem) {
    ?>
                                  <tr align="center" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                                    <td class="tbl_border_top tbl_border_right"><div align="left">
                                        <?=$i++ . ") " . $points[$id]['name']?>
                                      </div></td>
                                    <td class="tbl_border_top tbl_border_right"><div align="right">
                                        <?=number_format($points[$id]['decimal_lat'], 6)?>
                                        <!--<?=$points[$id]['lat_1']?>° <?=$points[$id]['lat_2']?>' <?=$points[$id]['lat_3']?>"-->
                                      </div></td>
                                    <td class="tbl_border_top tbl_border_right"><div align="right">
                                        <?=number_format($points[$id]['decimal_long'], 6)?>
                                        <!--<?=$points[$id]['long_1']?>° <?=$points[$id]['long_2']?>' <?=$points[$id]['long_3']?>"-->
                                      </div></td>
                                    <td class="tbl_border_top tbl_border_right"><div align="center">
                                        <?php
$res_time = number_format($points[$id]['value_eta'] / 3600, 3);

    /* HOUR */
    $hr = explode(".", $res_time);
    $hour = $hr[0];

    /* MIN */
    $min = "0." . $hr[1];
    $mins = $min * 60;
    $minutes = explode(".", $mins);
    $minute = $minutes[0];

    /* SEC */
    $sec = "0." . $minutes[1];
    $sec = $sec * 60;
    $secs = explode(".", $sec);
    $second = $secs[0];

    $hour = (strlen((string) ($hour)) > 1) ? $hour : "0" . $hour;
    $minute = (strlen((string) ($minute)) > 1) ? $minute : "0" . $minute;
    $second = (strlen((string) ($second)) > 1) ? $second : "0" . $second;

    $result_time = $hour . ":" . $minute;
    echo ($res_time == 0) ? "-" : $result_time;

    ?>
                                      </div></td>
                                    <td class="tbl_border_top"><div align="center">
                                        <?=number_format($points[$id]['value_zmax'], 3)?>
                                      </div></td>
                                  </tr>
                                  <?php
}
?>

                                </table>
                                <table border="0" cellpadding="5" cellspacing="3" class=" tbl_border fs14px" id="tbl02" style="display:none">
                                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                                    <td class="tbl_border_right"><strong>Name</strong></td>
                                    <td class="tbl_border_right"><strong>Latitude</strong></td>
                                    <td class="tbl_border_right"><strong>Longitude</strong></td>
                                    <td class="tbl_border_right" onClick="javascript: change_time();"><strong>Elapsed Time (h:m)</strong></td>
                                    <td class=""><strong>Height&nbsp;(M)</strong></td>
                                  </tr>
                                  <?php
$i = 1;
foreach ($points as $id => $elem) {
    ?>
                                  <tr align="center" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                                    <td class="tbl_border_top tbl_border_right"><div align="left">
                                        <?=$i++ . ") " . $points[$id]['name']?>
                                      </div></td>
                                    <td class="tbl_border_top tbl_border_right"><div align="right">
                                        <?=number_format($points[$id]['decimal_lat'], 6)?>
                                        <!--<?=$points[$id]['lat_1']?>° <?=$points[$id]['lat_2']?>' <?=$points[$id]['lat_3']?>"-->
                                      </div></td>
                                    <td class="tbl_border_top tbl_border_right"><div align="right">
                                        <?=number_format($points[$id]['decimal_long'], 6)?>
                                        <!--<?=$points[$id]['long_1']?>° <?=$points[$id]['long_2']?>' <?=$points[$id]['long_3']?>"-->
                                      </div></td>
                                    <td class="tbl_border_top tbl_border_right"><div align="center">
                                        <?php
$res_time = number_format($points[$id]['value_eta'] / 3600, 3);
    $hr = explode(".", $res_time);

    if ($hr[0] == null) {
        $hour = 0;
    } else {
        $hour = $hr[0];
    }

    $min = "0." . $hr[1];
    $mins = $min * 60;
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
    echo number_format(($points[$id]['value_eta'] / 3600), 3) . " hrs.";
    echo " ".$points[$id]['value_eta'];

    ?>
                                      </div></td>
                                    <td class="tbl_border_top"><div align="center">
                                        <?=number_format($points[$id]['value_zmax'], 3)?>
                                      </div></td>
                                  </tr>
                                  <?php
}
?>

                                </table>
                                </fieldset></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
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
</DIV>
</BODY>
</HTML>