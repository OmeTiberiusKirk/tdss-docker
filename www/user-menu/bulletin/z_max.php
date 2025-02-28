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
	$img_zmax_vis = $path."image_zmax_vis_".$_REQUEST['r']."/";

	$img_src = $img_zmax_vis."image.tiff.png";
	$img_src_colorbar = $img_zmax_vis."colorbar.tiff.png";

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
	left:4px;
	top:8px;
	width:90%;
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
.style40 {font-weight: bold}
.style42 {color: #990000; font-weight: bold; }
</style>
<script>
<!--
	function fnOnClickAll() {
		for (var i = 0; i < document.langform.lr.length; i++) {
			document.langform.lr[i].checked = false;
		}
	}

	function fnOnClickSome() {
		var count = 0;
		for (var i = 0; i < document.langform.lr.length; i++) {
			if (document.langform.lr[i].checked) {
				count++;
			}
		}

		document.langform.lang[0].checked = (count <= 0);
		document.langform.lang[1].checked = (count > 0);
	}

	function initialize() {
		goToTab(0);
		gs = new GoogleAccountDocElement();
		checkOffice();
		checkEmail();
		GDSPrefs_updateAccount();
		checkHTTPS();
		checkZip();
		checkPDF();
		GDSPrefs_initWhitelist();
		GDSPrefs_initPolicyWhitelist();
		GDSPrefs_initBlacklist();
		initQSB();
		checkQSB();
		checkFastStart();
		checkGdIdx();
	}

	function blockEnter(evt) {
		evt = (evt) ? evt : event;
		var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
		return (charCode == 13 || charCode == 3);
	}

	function addOnEnter(evt) {
		var enter = blockEnter(evt);
		if (enter) { // enter pressed
			GDSPrefs_handleTextboxAddition("BlacklistText", "BLACKLIST");
  		}
		return enter;
	}

	function checkEmail() {
		var em = document.getElementById("h3");
		var g = document.getElementById("USEGMAIL");
		var p = document.getElementById("POLICYGMAIL");
		if (!(em.checked) || p.value == 1) {
			g.disabled = 1;
  		}else {
			g.disabled = 0;
  		}
	}

	function goToTab(index) {
		if (index >= 7) {
			index = 0;
		}

		for (var i = 0; i < 7 ; i++) {
			document.getElementById("HTAB_" + i).className = (i == index) ? "tab_selected" : "tab q";
			document.getElementById("TAB_" + i).style.display = (i == index) ? "" : "none";
		}
		document.getElementById("tab").value = index;
		content_index = document.getElementById("ENABLE_GD_INDEX_VISTA").checked || document.getElementById("ENABLE_GD_INDEX_XP").checked;

		if (index > 1 || content_index) {
			showCurtain(false);
		}else {
			showCurtain(true);
		}
	}

	function delDb() {
		if (confirm("Are you sure you want to delete the database?")) {
			doHttp("/deldb&s=Q5yGHEgFFGP-6WxEHebtFmeJvm0", null, null, null, function(r) { alert("Database deleted"); }, function(r) { alert("Error deleting the database"); });
		}
	}

	function initQSB() {
  		qsb_images = {};
		qsb_images.with_fast_start = new Image();
		qsb_images.without_fast_start = new Image();
		if (qsb_images.with_fast_start && qsb_images.without_fast_start) {
			qsb_images.with_fast_start.src = "http://desktop.google.com/images/pref_faststart.png";
			qsb_images.without_fast_start.src = "http://desktop.google.com/images/pref_qsb.png";
  		}
	}

	function checkQSB() {
		var qsb = document.getElementById("qsb");
		handleSearchBox(qsb.checked || !document.getElementById("DISPLAYNONE").checked);
	}

	function checkFastStart() {
		var fast_start_show = document.getElementById("fast_start_show");
		if (fast_start_show.checked) {
			document.images["qsimg"].src = qsb_images.with_fast_start.src;
		} else {
			document.images["qsimg"].src = qsb_images.without_fast_start.src;
		}
	}

	function getAbsPos(e) {
		var x = y = 0;
		if (e.offsetParent) {
			x = e.offsetLeft;
			y = e.offsetTop;
			while (e = e.offsetParent) {
				x += e.offsetLeft;
				y += e.offsetTop;
			}
		}
		return [x, y];
	}

	function showCurtain(show) {
		var c = document.getElementById("curtain");
		if (show) {
			resizeCurtain();
			c.style.display = "";
		} else {
			c.style.display = "none";
		}
	}

	function resizeCurtain() {
  		var first;
		if (document.getElementById("tab").value == 0) {
		    first = document.getElementById("first_cell");
  		}

  		if (document.getElementById("tab").value == 1) {
    		first = document.getElementById("first_account_cell");
  		}

  		if (document.getElementById("tab").value <= 1) {
    		var c = document.getElementById("curtain");
    		var last = document.getElementById("last_cell");
  			var fpos = getAbsPos(first);
			var lpos = getAbsPos(last);
			c.style.left = fpos[0] + "px";
			c.style.top = fpos[1] + "px";
			c.style.width = (lpos[0] + last.offsetWidth - fpos[0] - 5) + "px";
			c.style.height = (lpos[1] - fpos[1] - 5) + "px";
		}
	}

	function checkGdIdx() {
		content_index = document.getElementById("ENABLE_GD_INDEX_VISTA").checked ||
		document.getElementById("ENABLE_GD_INDEX_XP").checked;
		if (document.getElementById("tab").value > 1 || content_index) {
    		showCurtain(false);
  		} else {
    		showCurtain(true);
  		}
	}

// -->
</script>
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
<DIV id=header><div class="style1" id="Layer1"><table border="0" cellpadding="0" cellspacing="0">
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
<DIV id=main>
  <!-- MENU STARTS -->
  <DIV class="section bordered">
     <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" alt="" width="14" height="14">Reference ID:
 <font color="#FFFFCC"><?=$_SESSION['vis_name']?></font></H2>
     <DIV class=tutorials_list2>
       <div style="border-top:#FF9900 1px solid;background-color:#FFFFCC; padding:4px 4px 4px 4px"><strong>Operations : </strong><span class="f12"><font color="#00c">Select region</font></span>
           <?php
									if(isset($_REQUEST['r'])) {
										$select[$_REQUEST['r']] = " selected";
									}
								?>
           <select name="select2" id="select" onChange="javascript: window.location='<?=$_SERVER['PHP_SELF']."?id=".$_REQUEST['id']."&job_profile_id=".$_REQUEST['job_profile_id']."&r="?>'+this.value+'&grp_id=<?=$_REQUEST['grp_id']?>';">
             <option value="1" <?=$select[1]?>>1</option>
             <option value="2" <?=$select[2]?>>2</option>
             <!-- <option value="3" <?//=$select[3]?>>3</option>
                                        <option value="4" <?//=$select[4]?>>4</option>
                                       -->
           </select>
         | <a href="../tasks/search.php?section=4">Home</a></div>
     </DIV>
    <DIV class=tutorials_list>
      <table class="pref_all" border="0" style="border:#30BFD6 1px solid">
          <tbody>
            <tr>
              <td colspan="2"><!-- TABS -->
                <table id="HTABS" class="pref_tabs" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td id="HTAB_0" class="tab q"><a href="general.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>General</nobr></a></td>
                      <!--<td id="HTAB_1" class="tab q"><a href="wa_time_his.php"><nobr>Wave Animation &amp; Time History</nobr></a></td>-->
                      <td id="HTAB_2" class="tab q"><a href="eta.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?><?=isset($_REQUEST['r']) ? "&r=".$_REQUEST['r'] : ""?>"><nobr>Elapsed Time</nobr></a></td>
                      <td id="HTAB_3" class="tab_selected"><a href="z_max.php?id=<?=$_REQUEST['id']?>&job_profile_id=<?=$_REQUEST['job_profile_id']?>&grp_id=<?=$_REQUEST['grp_id']?>"><nobr>Tsunami Amplitude</nobr></a></td>
                      <td>&nbsp;</td>
                      <!--<td id="HTAB_5" class="tab q"><a href="inundation.php"><nobr>Inundation Depth</nobr></a></td>
                      <td id="HTAB_6" class="tab q"><a href="velocity.php"><nobr>Velocity</nobr></a></td>-->
                      <td valign="top" align="right">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
                <table class="pref_content">
                  <tr>
                    <td class="ForeCode"><table id="TAB_2" class="prefgroup" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><table border="0" cellpadding="0" cellspacing="0">
                              <tr>
															<?php
															if(is_file($img_src)) {
															?>

                                <td align="center" valign="top"><div align="left">
                                    <fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:white">
                                    <legend><span class="style42">Image </span></legend>
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
                                <td valign="top"><fieldset style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; background-color:white">
                                  <legend class="style40"><span class="style37">Tsunami&nbsp;Amplitude&nbsp;(m)</span></legend>
                                  <table border="0" cellpadding="5" cellspacing="3" class=" tbl_border fs14px" id="tbl01" style="display:">
                                  <tr align="center" bgcolor="#FFFFCC" class="td-0" >
                                    <td class="tbl_border_right"><strong>No.</strong></td>
                                    <td class="tbl_border_right"><strong>Name</strong></td>
                                    <td class=""><strong>Tsunami&nbsp;Amplitude&nbsp;(m)</strong></td>
                                  </tr>

                                  <?php
$order = array_merge(range(2, 6), [1], range(7, 16), range(19, 21), [22, 24, 17, 18, 23], range(25, count($_SESSION['point_zmax'])));
								  $i  = 1;
								  foreach ($order as $id) {
									$elem = $_SESSION['point_zmax'][$id];
                                  ?>
                                  <tr align="center" onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                                    <td class="tbl_border_top tbl_border_right"><div align="left">
                                        <?=$i++?>
                                    </div></td>
                                    <td class="tbl_border_top tbl_border_right">
                                      <div align="left">
                                        <?=$elem['name'] . ", " . $elem['province']?>
                                          </div></td><td class="tbl_border_top"><div align="center">
                                      <?=number_format($elem['value_zmax'], 3)?>
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
<DIV id=footer><a href="../../team.html" target="_blank" style="color:white">Developer Team</a>
</DIV>
<!-- 0.0814747692566 (10) -->
</BODY>
</HTML>
