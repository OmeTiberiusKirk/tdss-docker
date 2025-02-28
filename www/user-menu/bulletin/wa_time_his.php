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
	
	function load_region(no_r){
		alert(no_r);
	}
	
// -->
</script>
<?php
	$file_list = array();
	$total_img = 100;

	//"workspace/pemjit/files/Experiments/Khaolak_Phuket_2004/R1/z1_50/image_0.jpg"
	$root_path = "../../workspace/".$_SESSION['username']."/files/Experiments/".$_SESSION['expr_name']."/";
	if(!isset($_SESSION['file_root_path']))
		$_SESSION['file_root_path'] = $root_path;

	if($_SESSION['r'] && !isset($_REQUEST['r']))
		$_REQUEST['r'] = $_SESSION['r'];
	switch($_REQUEST['r']){
		case 1 : 
		default:
			$img_url_path_a = "\"".$root_path."R1/z1_50/image_"; 
			$colorbar_url = $root_path."R1/z1_50/wave-animation-3d-r1-colorbar.jpg";
			$_REQUEST['r'] = 1;
			break;
		case 2 : 
			$img_url_path_a = "\"".$root_path."/R2/image_"; 
			$colorbar_url = $root_path."R2/wave-animation-3d-r2-colorbar.jpg";
			break;
		case 3 :
			$total_img = 200;
			$img_url_path_a = "\"".$root_path."/R3/z3_50/image_"; 
			$colorbar_url = $root_path."/R3/z3_50/wave-animation-3d-r3-colorbar.jpg"; 
			break;
	}
	$_SESSION['r'] = $_REQUEST['r'];
	$img_url_path_b = ".jpg\"";
	$init_img = $img_url_path_a."0".$img_url_path_b;
	
	for($i=1; $i<$total_img; $i++)
		$file_list[] = $img_url_path_a.$i.$img_url_path_b;
	$load = implode(",", $file_list);
?>
<script language="javascript">
	var img_total = <?=$total_img?>;

	function slide_image(status)
	{	
		if (!document.images)
			return 
		
		/* append image's tag on this document */
		whichimage = document.tform.time_step.value;
		
		if(status == 'next'){
			whichimage++;
			if(whichimage > img_total)
				whichimage = 1;
		}else{
			whichimage--;
			if(whichimage < 1 )
				whichimage = img_total;
		}
		
		document.tform.time_step.value = whichimage;	
		document.images.slide.src=slideimages[whichimage].src
		
		/* counting image index */
		
	}

	/* setting variable for containing image*/
	var slideimages = new Array()
	
	/* setting image changing speed */
	var slideshowspeed=200

	/* index of image */
	var whichimage=0
	
	/* counter for 'Play' and 'Pause' button */
	var count = 1;
	
	/* flag for disbling and enabling the starting and stopping slideshow */
	var flag = false;
	
	/* setting flag for start and stop slideshow */
	function setflag(btn)
	{
		count++;
		if(count%2 == 0 )
		{
			btn.value = 'Pause';
			flag = true;
		}else
		{
			btn.value = 'Play';
			flag = false;
		}
	}
	
	/* starting the slideshow */
	function Start()
	{
		if(flag == true)
		{
			if (!document.images){
				return;
			}
			/* append image's tag on this document */
			whichimage = document.tform.time_step.value;
			document.images.slide.src=slideimages[whichimage].src
			
			/* counting image index */
			if (whichimage<slideimages.length)
			{
				/* running number (index of series of image) */
				++whichimage
				document.tform.time_step.value = whichimage;
			}else
			{
				/* if image not present, then reset index */
				whichimage=0
				alert('t');
			}
			//alert(whichimage);
			/* set slideshow speed*/
			setTimeout("Start()", slideshowspeed)
		}
	}
	
	/* slideshow the image */
	function SlideshowImages()
	{
		/* loop for reading the argument list */
		for (i=0;i<SlideshowImages.arguments.length;i++)
		{
			/* create image's tag on HTML */
			slideimages[i]=new Image()
			slideimages[i].src=SlideshowImages.arguments[i];
		}
	}
	
	/* loading image from server */
	SlideshowImages(<?=$load?>)
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
    <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;&nbsp;Koshimura&nbsp;</H2>
    <DIV class=tutorials_list>
      <table class="pref_all" border="0" style="border:#30BFD6 1px solid">
        <tbody>
          <tr>
            <td colspan="2"><!-- TABS -->
              <table id="HTABS" class="pref_tabs" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr>
                    <td id="HTAB_0" class="tab q"><a href="general.php"><nobr>General</nobr></a></td>
                    <td id="HTAB_1" class="tab_selected"><a href="wa_time_his.php"><nobr>Wave Animation &amp; Time History</nobr></a></td>
                    <td id="HTAB_2" class="tab q"><a href="eta.php"><nobr>Elapsed Time Arrival</nobr></a></td>
                    <td id="HTAB_3" class="tab q"><a href="z_max.php"><nobr>Zmax</nobr></a></td>
                    
                    <td id="HTAB_5" class="tab q"><a href="inundation.php"><nobr>Inundation Depth</nobr></a></td>
                    <td id="HTAB_6" class="tab q"><a href="velocity.php"><nobr>Velocity</nobr></a></td>
                    <td valign="top" align="right"><table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td><table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <th scope="col"><div align="left" class="f12">Region</div></th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col"> 
								<?php
									if(isset($_REQUEST['r'])) {
										$select[$_REQUEST['r']] = " selected";
									}
								?>
								<form method="get" name="load_region" id="load_region"><select name="select" id="select_type" onChange="javascript: window.location='<?=$_SERVER['PHP_SELF']."?r="?>'+this.value;">
                                    <option value="1" <?=$select[1]?>>1</option>
                                    <option value="2" <?=$select[2]?>>2</option>
                                    <option value="3" <?=$select[3]?>>3</option>
                                    <option value="4" <?=$select[4]?>>4</option>
                                  </select></form>
                                </th>
                                <th scope="col">&nbsp;</th>
                              </tr>
                            </table></td>
                          <td><a href="javascript: void();" onClick="javascript: window.location='../tasks/result.php';">Back</a></td>
                          <td>&nbsp;</td>
                          <td><a href="javascript: void();" onClick="javascript: window.location='<?=$_SERVER['PHP_SELF']?>'">Reload</a></td>
                        </tr>
                      </table></td>
                  </tr>
                </tbody>
              </table>
              <table class="pref_content">
                <tr>
                  <td class="ForeCode"><table id="TAB_1" class="prefgroup" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="center" valign="top"><div align="left">
                                  <fieldset>
                                  <legend><span class="style37">Image </span></legend>
                                  <div align="center">
                                    <table width="10" height="2" border="0">
                                      <tr>
                                        <td></td>
                                      </tr>
                                    </table>
                                  </div>
                                  <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td colspan="3" valign="top" bgcolor="#000000"><div align="center">
                                        <table border="0" cellpadding="2" cellspacing="0">
                                          <tr>
                                            <td valign="middle">&nbsp;</td>
                                            <td valign="middle">&nbsp;</td>
                                            <td align="left">&nbsp;</td>
                                            <td align="left">&nbsp;</td>
                                            <td valign="middle">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td valign="middle"><strong><font color="#FFFFFF">Time step</font> </strong></td>
                                            <td valign="middle"><form method="post" name="tform" id="tform">
                                                <input type="text" name="time_step" id="time_step" size="4" value="1" style="text-align:center">
                                              <font color="white">of
                                              <?=$total_img?></font>
                                            </form></td>
                                            <td align="left">&nbsp;</td>
                                            <td align="left"><span style="padding:3px"> </span> <span style="padding:3px">
                                              <input name="restore3" type=button class=butenter id=restore2 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Previous" onClick="javascript: slide_image('back');" >
                                              &nbsp;
                                              <input name="btn" type=button class=butenter id=restore3 style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Play" onClick="javascript: setflag(this); Start();" >
                                              &nbsp;
                                              <input name="re_render2" type=button class=butenter id=re_render style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px; width:80px; height:27px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Next" onClick="javascript: slide_image('next'); " >
                                            </span><a href="" style="color:blue"></a></td>
                                            <td valign="middle"><a href="" style="color:blue">output.tar.gz</a></td>
                                          </tr>
                                          <tr>
                                            <td valign="middle">&nbsp;</td>
                                            <td valign="middle">&nbsp;</td>
                                            <td align="left">&nbsp;</td>
                                            <td align="left">&nbsp;</td>
                                            <td valign="middle">&nbsp;</td>
                                          </tr>
                                        </table>
                                      </div></td>
                                    </tr>
                                    <tr>
                                      <td valign="top" bgcolor="#000000"><table border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td><img src="../../image/space_black.jpg" alt="0" width="17" height="50"></td>
                                            <td><img src="../../image/space_black.jpg" alt="0" width="17" height="50"></td>
                                          </tr>
                                          <tr>
                                            <td><img src="../../image/space_black.jpg" alt="0" width="17" height="50"></td>
                                            <td><img src="<?=$colorbar_url?>"></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                        </table></td>
                                      <td bgcolor="#000000"><img src="<?=str_replace("\"", "", $init_img)?>" alt="0" name="slide" border="0" id="slide"></td>
                                      <td bgcolor="#000000">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td valign="top" bgcolor="#000000">&nbsp;</td>
                                      <td bgcolor="#000000">&nbsp;</td>
                                      <td bgcolor="#000000">&nbsp;</td>
                                    </tr>
                                  </table>
                                  </fieldset>
                                </div>
                                <div align="left"></div></td>
                              <td valign="top"><fieldset>
                                <legend><span class="style37">Time History </span></legend>
                                <table border="0" cellpadding="3" cellspacing="0">
                                  <tr>
                                    <td valign="middle"><strong>Phuket</strong> <a href="" style="color:blue">Zoom</a> | <a href="" style="color:blue">output.tar.gz</a></td>
                                  </tr>
                                  <tr>
                                    <td valign="middle"><div align="center"><img src="temp_output_img/Point-Phuket-417-1.jpg" alt="0" width="300" height="130" border="1"></div></td>
                                  </tr>
                                </table>
                                <table border="0" cellpadding="3" cellspacing="0">
                                  <tr>
                                    <td valign="middle"><strong>Ranong</strong> <a href="" style="color:blue">Zoom</a> | <a href="" style="color:blue">output.tar.gz</a></td>
                                  </tr>
                                  <tr>
                                    <td valign="middle"><div align="center"><img src="temp_output_img/Point-Ranong-417-1(1).jpg" alt="0" width="300" height="130" border="1"></div></td>
                                  </tr>
                                </table>
                                <table border="0" cellpadding="3" cellspacing="0">
                                  <tr>
                                    <td valign="middle"><strong>Trung</strong> <a href="" style="color:blue">Zoom</a> | <a href="" style="color:blue">output.tar.gz</a></td>
                                  </tr>
                                  <tr>
                                    <td valign="middle"><div align="center"><img src="temp_output_img/Point-Trung-417-1(1).jpg" alt="0" width="300" height="130" border="1"></div></td>
                                  </tr>
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
<DIV id=footer><SPAN>Partners:</SPAN><A href="http://www.cp.eng.chula.ac.th" 
target=_blank>Department of Computer Engineering </A> | <A href="http://www.ce.eng.chula.ac.th" 
target=_blank>Department of Civil Engineering </A> | <A 
href="http://www.thaigrid.net" target=_blank>ThaiGrid</A></DIV>
<!-- 0.0814747692566 (10) -->
</BODY>
</HTML>
