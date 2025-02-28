<?php
	session_start();
	if(isset($_REQUEST['section'])) {
		$menu_onmouseover = "style=\"background-color: #DDECF0; color: rgb(2, 87, 120);  font-weight:bold; background-image:url(../image/arrow_2_1.PNG)\"";
		$section = array(1, 2, 3, 4, 5);
		$section[$_REQUEST['section']] = $menu_onmouseover;

	}
	
	if (!isset($_SESSION['username'])) {
		$disable_flag = "disabled=\"disabled\"";
	}else {
		header("location: user-menu/");	
	}

	set_time_limit(3600);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>Web Portal :: Public Section</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
<META content="index, follow" name=robots>
<LINK href="style/style.css" type=text/css rel=stylesheet>
<LINK href="style/column.css" type=text/css rel=stylesheet>
<SCRIPT src="script/mainscript.js" type=text/javascript></SCRIPT>
<script src="script/submenu.js" type="text/javascript"></script>
<script language="javascript">
	var screenW = 1680, screenH = 1050;
	if (parseInt(navigator.appVersion)>3) {
	 screenW = screen.width;
	 screenH = screen.height;
	}
	else if (navigator.appName == "Netscape" 
		&& parseInt(navigator.appVersion)==3
		&& navigator.javaEnabled()
	   ) 
	{
	 var jToolkit = java.awt.Toolkit.getDefaultToolkit();
	 var jScreenSize = jToolkit.getScreenSize();
	 screenW = jScreenSize.width;
	 screenH = jScreenSize.height;
	}

	function winSizer(){
		windowWidth = window.screen.availWidth;
		windowHeight = window.screen.availHeight;
		window.moveTo(0,0);
		window.resizeTo(windowWidth,windowHeight);
	}

</script>
<META content="MSHTML 6.00.2900.2769" name=GENERATOR>
<style type="text/css">
#Layer1 {
	position:absolute;
	left:378px;
	top:14px;
	width:482px;
	height:29px;
	z-index:1;
}
.style1 {
	font-size: 22px;
	color: #FFFFFF;
}
.style2 {
	color: #C6E3E7
}

</style>
</HEAD>
<BODY onLoad="document.i_login.username.focus(); winSizer()">
<DIV id=header>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center" class="style1">
          <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><img src="image/image001.png" alt=""></td>
              <td>&nbsp;</td>
              <td align="center" valign="top">Tsunami Decision Support System<!--<br>
                <font style="size:15px">by <a href="http://ndwc.opencare.org/" target="_blank" style="color:white">National Disaster Warning Center (NDWC)</a> and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University" target="_blank">Chulalongkorn University</a></font></td>
              <td>&nbsp;</td>
              <td><img src="image/Logo-Chula.png" alt="" border="0" usemap="#Map2">--></td>
            </tr>
          </table>
        </div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</DIV>
<DIV id=main>
  <div align="center">
    <form action="library/login.php" method="post" name="i_login">
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="">&nbsp;</td>
        </tr>
        <tr>
          <td height=""><span class="style2"><strong>Username</strong></span>&nbsp;</td>
        </tr>
        <tr>
          <td height="29"><input name="username" type="text" id="username" style="width:150px" size="30" maxlength="30"></td>
        </tr>
        <tr>
          <td height=""><span class="style2"><strong>Password</strong></span>&nbsp;</td>
        </tr>
        <tr>
          <td height="29"><input name="password" type="password" id="password" style="width:150px" size="15" maxlength="15"></td>
        </tr>
        <tr>
          <td height="29"><div align="center">
              <input name="Reset" type=reset class=butenter id=submit style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="    Reset    ">
              <input name="submit" type=submit class=butenter id=submit style="PADDING-RIGHT: 6px; PADDING-LEFT: 6px; PADDING-BOTTOM: 2px; COLOR: #ffffff; PADDING-TOP: 1px" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="    Submit    ">
            </div></td>
        </tr>
        <tr>
          <td height="">&nbsp;</td>
        </tr>
      </table>
    </form>
  </div>
</DIV>
<DIV id=footer>
</DIV>
</BODY>
</HTML>