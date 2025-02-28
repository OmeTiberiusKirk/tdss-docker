<?php
	session_start();
	
	if(!isset($_SESSION['username']))
	{
		echo "<script language=\"javascript\">location.href='../';</script>";
	}
	$disable_flag = "";
	$flag_display = "none";
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
<style type="text/css">
<!--
.style3 {color: #000000}

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
.style39 {font-size: 18px}
.tbl_border {border:black 1px solid; }
.tbl_border_right {border-right:black 1px solid; }
.tbl_border_top {border-top:black 1px solid; }
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
<div class="style1" id="Layer1">Tsunami Simulation and Visualization Portal</div>
<DIV id=header></DIV>
<DIV id=header_bottom></DIV>
<DIV id=main>
  <!-- MENU STARTS -->
  <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;&nbsp;<?=$_SESSION['expr_name']?>&nbsp;</H2>
    <DIV class=tutorials_list>
      <table class="pref_all" border="0" style="border:#30BFD6 1px solid">
          <tbody>
            <tr>
              <td colspan="2"><!-- TABS -->
                <table id="HTABS" class="pref_tabs" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td id="HTAB_0" class="tab q"><a href="general.php"><nobr>General</nobr></a></td>
                      <td id="HTAB_1" class="tab q"><a href="wa_time_his.php"><nobr>Wave Animation &amp; Time History</nobr></a></td>
                      <td id="HTAB_2" class="tab q"><a href="eta.php"><nobr>Elapsed Time Arrival</nobr></a></td>
                      <td id="HTAB_3" class="tab q"><a href="z_max.php"><nobr>Zmax</nobr></a></td>
                      <td id="HTAB_4" class="tab_selected"><a href="height_coastline.php"><nobr>Height on the coastline</nobr></a></td>
                      <td id="HTAB_5" class="tab q"><a href="inundation.php"><nobr>Inundation Depth</nobr></a></td>
                      <td id="HTAB_6" class="tab q"><a href="velocity.php"><nobr>Velocity</nobr></a></td>
                      <td valign="top" align="right"><table border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <th scope="col"><div align="left" class="f12">Region</div></th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col"> <select name="select" id="select_type">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                  </select>                                </th>
                                <th scope="col">&nbsp;</th>
                              </tr>
                            </table></td>
                            <td><a href="javascript: void();" onClick="javascript: window.location='../expr/result.php';">Back</a></td>
                            <td>&nbsp;</td>
                            <td><a href="javascript: void();" onClick="javascript: window.location='<?=$_SERVER['PHP_SELF']?>'">Reload</a></td>
                          </tr>
                        </table></td>
                    </tr>
                  </tbody>
                </table>
                <table class="pref_content">
        <tr>
                        <td class="ForeCode">&nbsp;</td>
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
<DIV id=footer><SPAN>Partners:</SPAN><A href="http://www.cp.eng.chula.ac.th" 
target=_blank>Department of Computer Engineering </A> | <A href="http://www.ce.eng.chula.ac.th" 
target=_blank>Department of Civil Engineering </A> | <A 
href="http://www.thaigrid.net" target=_blank>ThaiGrid</A></DIV>
<!-- 0.0814747692566 (10) -->
</BODY>
</HTML>
