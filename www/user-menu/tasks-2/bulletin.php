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
<HTML xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/user.dwt.php" codeOutsideHTMLIsLocked="true" -->
<HEAD>
<!-- InstanceBeginEditable name="doctitle" -->
<TITLE>Web Portal :: Operation and Research Section</TITLE>
<style type="text/css">
<!--
.style3 {
	color: #000000
}
.style4 {
	color: #FFFFFF
}
-->
</style>
<style type="text/css">
<!--
.style4 {
	color: #009966
}
.style5 {
	color: #FF0000
}
.style7 {
	color: #990000;
	font-weight: bold;
	font-size: 12px;
}
.style36 {
	color: #33CCFF
}
.style39 {
	font-size: 18px
}
.style41 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FF9900;
	font-size: small;
	font-weight: bold;
}
.style43 {
	font-size: small
}
.style46 {
	color: #626262
}
.style37 {
	color: #990000
}
DIV#adv_box {
	BORDER-RIGHT: #b6d6e1 1px solid;
	PADDING-RIGHT: 0px;
	BORDER-TOP: #b6d6e1 1px solid;
	PADDING-LEFT: 20px;
	PADDING-BOTTOM: 5px;
	padding-right:20px;
	MARGIN: 7px 0px 10px;
	BORDER-LEFT: #b6d6e1 1px solid;
	PADDING-TOP: 12px;
	BORDER-BOTTOM: #b6d6e1 1px solid;
	BACKGROUND-COLOR: #eef6fb
}
.style31 {
	color: #FFFFFF;
}
-->
</style>
<script language="JavaScript">
/**
This is a JavaScript library that will allow you to easily add some basic DHTML
drop-down datepicker functionality to your Notes forms. This script is not as
full-featured as others you may find on the Internet, but it's free, it's easy to
understand, and it's easy to change.

You'll also want to include a stylesheet that makes the datepicker elements
look nice. An example one can be found in the database that this script was
originally released with, at:

http://www.nsftools.com/tips/NotesTips.htm#datepicker

I've tested this lightly with Internet Explorer 6 and Mozilla Firefox. I have no idea
how compatible it is with other browsers.

version 1.5
December 4, 2005
Julian Robichaux -- http://www.nsftools.com

HISTORY
--  version 1.0 (Sept. 4, 2004):
Initial release.

--  version 1.1 (Sept. 5, 2004):
Added capability to define the date format to be used, either globally (using the
defaultDateSeparator and defaultDateFormat variables) or when the displayDatePicker
function is called.

--  version 1.2 (Sept. 7, 2004):
Fixed problem where datepicker x-y coordinates weren't right inside of a table.
Fixed problem where datepicker wouldn't display over selection lists on a page.
Added a call to the datePickerClosed function (if one exists) after the datepicker
is closed, to allow the developer to add their own custom validation after a date
has been chosen. For this to work, you must have a function called datePickerClosed
somewhere on the page, that accepts a field object as a parameter. See the
example in the comments of the updateDateField function for more details.

--  version 1.3 (Sept. 9, 2004)
Fixed problem where adding the <div> and <iFrame> used for displaying the datepicker
was causing problems on IE 6 with global variables that had handles to objects on
the page (I fixed the problem by adding the elements using document.createElement()
and document.body.appendChild() instead of document.body.innerHTML += ...).

--  version 1.4 (Dec. 20, 2004)
Added "targetDateField.focus();" to the updateDateField function (as suggested
by Alan Lepofsky) to avoid a situation where the cursor focus is at the top of the
form after a date has been picked. Added "padding: 0px;" to the dpButton CSS
style, to keep the table from being so wide when displayed in Firefox.

-- version 1.5 (Dec 4, 2005)
Added display=none when datepicker is hidden, to fix problem where cursor is
not visible on input fields that are beneath the date picker. Added additional null
date handling for date errors in Safari when the date is empty. Added additional
error handling for iFrame creation, to avoid reported errors in Opera. Added
onMouseOver event for day cells, to allow color changes when the mouse hovers
over a cell (to make it easier to determine what cell you're over). Added comments
in the style sheet, to make it more clear what the different style elements are for.
*/

var datePickerDivID = "datepicker";
var iFrameDivID = "datepickeriframe";

var dayArrayShort = new Array('Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa');
var dayArrayMed = new Array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
var dayArrayLong = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
var monthArrayShort = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
var monthArrayMed = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
var monthArrayLong = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
 
// these variables define the date formatting we're expecting and outputting.
// If you want to use a different format by default, change the defaultDateSeparator
// and defaultDateFormat variables either here or on your HTML page.
var defaultDateSeparator = "/";        // common values would be "/" or "."
var defaultDateFormat = "mdy"    // valid values are "mdy", "dmy", and "ymd"
var dateSeparator = defaultDateSeparator;
var dateFormat = defaultDateFormat;

/**
This is the main function you'll call from the onClick event of a button.
Normally, you'll have something like this on your HTML page:

Start Date: <input name="StartDate">
<input type=button value="select" onclick="displayDatePicker('StartDate');">

That will cause the datepicker to be displayed beneath the StartDate field and
any date that is chosen will update the value of that field. If you'd rather have the
datepicker display beneath the button that was clicked, you can code the button
like this:

<input type=button value="select" onclick="displayDatePicker('StartDate', this);">

So, pretty much, the first argument (dateFieldName) is a string representing the
name of the field that will be modified if the user picks a date, and the second
argument (displayBelowThisObject) is optional and represents an actual node
on the HTML document that the datepicker should be displayed below.

In version 1.1 of this code, the dtFormat and dtSep variables were added, allowing
you to use a specific date format or date separator for a given call to this function.
Normally, you'll just want to set these defaults globally with the defaultDateSeparator
and defaultDateFormat variables, but it doesn't hurt anything to add them as optional
parameters here. An example of use is:

<input type=button value="select" onclick="displayDatePicker('StartDate', false, 'dmy', '.');">

This would display the datepicker beneath the StartDate field (because the
displayBelowThisObject parameter was false), and update the StartDate field with
the chosen value of the datepicker using a date format of dd.mm.yyyy
*/
function displayDatePicker(dateFieldName, displayBelowThisObject, dtFormat, dtSep)
{
  var targetDateField = document.getElementsByName (dateFieldName).item(0);
 
  // if we weren't told what node to display the datepicker beneath, just display it
  // beneath the date field we're updating
  if (!displayBelowThisObject)
    displayBelowThisObject = targetDateField;
 
  // if a date separator character was given, update the dateSeparator variable
  if (dtSep)
    dateSeparator = dtSep;
  else
    dateSeparator = defaultDateSeparator;
 
  // if a date format was given, update the dateFormat variable
  if (dtFormat)
    dateFormat = dtFormat;
  else
    dateFormat = defaultDateFormat;
 
  var x = displayBelowThisObject.offsetLeft;
  var y = displayBelowThisObject.offsetTop + displayBelowThisObject.offsetHeight ;
 
  // deal with elements inside tables and such
  var parent = displayBelowThisObject;
  while (parent.offsetParent) {
    parent = parent.offsetParent;
    x += parent.offsetLeft;
    y += parent.offsetTop ;
  }
 
  drawDatePicker(targetDateField, x, y);
}


/**
Draw the datepicker object (which is just a table with calendar elements) at the
specified x and y coordinates, using the targetDateField object as the input tag
that will ultimately be populated with a date.

This function will normally be called by the displayDatePicker function.
*/
function drawDatePicker(targetDateField, x, y)
{
  var dt = getFieldDate(targetDateField.value );
 
  // the datepicker table will be drawn inside of a <div> with an ID defined by the
  // global datePickerDivID variable. If such a div doesn't yet exist on the HTML
  // document we're working with, add one.
  if (!document.getElementById(datePickerDivID)) {
    // don't use innerHTML to update the body, because it can cause global variables
    // that are currently pointing to objects on the page to have bad references
    //document.body.innerHTML += "<div id='" + datePickerDivID + "' class='dpDiv'></div>";
    var newNode = document.createElement("div");
    newNode.setAttribute("id", datePickerDivID);
    newNode.setAttribute("class", "dpDiv");
    newNode.setAttribute("style", "visibility: hidden;");
    document.body.appendChild(newNode);
  }
 
  // move the datepicker div to the proper x,y coordinate and toggle the visiblity
  var pickerDiv = document.getElementById(datePickerDivID);
  pickerDiv.style.position = "absolute";
  pickerDiv.style.left = x + "px";
  pickerDiv.style.top = y + "px";
  pickerDiv.style.visibility = (pickerDiv.style.visibility == "visible" ? "hidden" : "visible");
  pickerDiv.style.display = (pickerDiv.style.display == "block" ? "none" : "block");
  pickerDiv.style.zIndex = 10000;
 
  // draw the datepicker table
  refreshDatePicker(targetDateField.name, dt.getFullYear(), dt.getMonth(), dt.getDate());
}


/**
This is the function that actually draws the datepicker calendar.
*/
function refreshDatePicker(dateFieldName, year, month, day)
{
  // if no arguments are passed, use today's date; otherwise, month and year
  // are required (if a day is passed, it will be highlighted later)
  var thisDay = new Date();
 
  if ((month >= 0) && (year > 0)) {
    thisDay = new Date(year, month, 1);
  } else {
    day = thisDay.getDate();
    thisDay.setDate(1);
  }
 
  // the calendar will be drawn as a table
  // you can customize the table elements with a global CSS style sheet,
  // or by hardcoding style and formatting elements below
  var crlf = "\r\n";
  var TABLE = "<table cols=7 class='dpTable'>" + crlf;
  var xTABLE = "</table>" + crlf;
  var TR = "<tr class='dpTR'>";
  var TR_title = "<tr class='dpTitleTR'>";
  var TR_days = "<tr class='dpDayTR'>";
  var TR_todaybutton = "<tr class='dpTodayButtonTR'>";
  var xTR = "</tr>" + crlf;
  var TD = "<td class='dpTD' onMouseOut='this.className=\"dpTD\";' onMouseOver=' this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
  var TD_title = "<td colspan=5 class='dpTitleTD'>";
  var TD_buttons = "<td class='dpButtonTD'>";
  var TD_todaybutton = "<td colspan=7 class='dpTodayButtonTD'>";
  var TD_days = "<td class='dpDayTD'>";
  var TD_selected = "<td class='dpDayHighlightTD' onMouseOut='this.className=\"dpDayHighlightTD\";' onMouseOver='this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
  var xTD = "</td>" + crlf;
  var DIV_title = "<div class='dpTitleText'>";
  var DIV_selected = "<div class='dpDayHighlight'>";
  var xDIV = "</div>";
 
  // start generating the code for the calendar table
  var html = TABLE;
 
  // this is the title bar, which displays the month and the buttons to
  // go back to a previous month or forward to the next month
  html += TR_title;
  html += TD_buttons + getButtonCode(dateFieldName, thisDay, -1, "&lt;") + xTD;
  html += TD_title + DIV_title + monthArrayLong[ thisDay.getMonth()] + " " + thisDay.getFullYear() + xDIV + xTD;
  html += TD_buttons + getButtonCode(dateFieldName, thisDay, 1, "&gt;") + xTD;
  html += xTR;
 
  // this is the row that indicates which day of the week we're on
  html += TR_days;
  for(i = 0; i < dayArrayShort.length; i++)
    html += TD_days + dayArrayShort[i] + xTD;
  html += xTR;
 
  // now we'll start populating the table with days of the month
  html += TR;
 
  // first, the leading blanks
  for (i = 0; i < thisDay.getDay(); i++)
    html += TD + "&nbsp;" + xTD;
 
  // now, the days of the month
  do {
    dayNum = thisDay.getDate();
    TD_onclick = " onclick=\"updateDateField('" + dateFieldName + "', '" + getDateString(thisDay) + "');\">";
    
    if (dayNum == day)
      html += TD_selected + TD_onclick + DIV_selected + dayNum + xDIV + xTD;
    else
      html += TD + TD_onclick + dayNum + xTD;
    
    // if this is a Saturday, start a new row
    if (thisDay.getDay() == 6)
      html += xTR + TR;
    
    // increment the day
    thisDay.setDate(thisDay.getDate() + 1);
  } while (thisDay.getDate() > 1)
 
  // fill in any trailing blanks
  if (thisDay.getDay() > 0) {
    for (i = 6; i > thisDay.getDay(); i--)
      html += TD + "&nbsp;" + xTD;
  }
  html += xTR;
 
  // add a button to allow the user to easily return to today, or close the calendar
  var today = new Date();
  var todayString = "Today is " + dayArrayMed[today.getDay()] + ", " + monthArrayMed[ today.getMonth()] + " " + today.getDate();
  html += TR_todaybutton + TD_todaybutton;
  html += "<button class='dpTodayButton' onClick='refreshDatePicker(\"" + dateFieldName + "\");'>this month</button> ";
  html += "<button class='dpTodayButton' onClick='updateDateField(\"" + dateFieldName + "\");'>close</button>";
  html += xTD + xTR;
 
  // and finally, close the table
  html += xTABLE;
 
  document.getElementById(datePickerDivID).innerHTML = html;
  // add an "iFrame shim" to allow the datepicker to display above selection lists
  adjustiFrame();
}


/**
Convenience function for writing the code for the buttons that bring us back or forward
a month.
*/
function getButtonCode(dateFieldName, dateVal, adjust, label)
{
  var newMonth = (dateVal.getMonth () + adjust) % 12;
  var newYear = dateVal.getFullYear() + parseInt((dateVal.getMonth() + adjust) / 12);
  if (newMonth < 0) {
    newMonth += 12;
    newYear += -1;
  }
 
  return "<button class='dpButton' onClick='refreshDatePicker(\"" + dateFieldName + "\", " + newYear + ", " + newMonth + ");'>" + label + "</button>";
}


/**
Convert a JavaScript Date object to a string, based on the dateFormat and dateSeparator
variables at the beginning of this script library.
*/
function getDateString(dateVal)
{
  var dayString = "00" + dateVal.getDate();
  var monthString = "00" + (dateVal.getMonth()+1);
  dayString = dayString.substring(dayString.length - 2);
  monthString = monthString.substring(monthString.length - 2);
 
  switch (dateFormat) {
    case "dmy" :
      return dayString + dateSeparator + monthString + dateSeparator + dateVal.getFullYear();
    case "ymd" :
      return dateVal.getFullYear() + dateSeparator + monthString + dateSeparator + dayString;
    case "mdy" :
    default :
      return monthString + dateSeparator + dayString + dateSeparator + dateVal.getFullYear();
  }
}


/**
Convert a string to a JavaScript Date object.
*/
function getFieldDate(dateString)
{
  var dateVal;
  var dArray;
  var d, m, y;
 
  try {
    dArray = splitDateString(dateString);
    if (dArray) {
      switch (dateFormat) {
        case "dmy" :
          d = parseInt(dArray[0], 10);
          m = parseInt(dArray[1], 10) - 1;
          y = parseInt(dArray[2], 10);
          break;
        case "ymd" :
          d = parseInt(dArray[2], 10);
          m = parseInt(dArray[1], 10) - 1;
          y = parseInt(dArray[0], 10);
          break;
        case "mdy" :
        default :
          d = parseInt(dArray[1], 10);
          m = parseInt(dArray[0], 10) - 1;
          y = parseInt(dArray[2], 10);
          break;
      }
      dateVal = new Date(y, m, d);
    } else if (dateString) {
      dateVal = new Date(dateString);
    } else {
      dateVal = new Date();
    }
  } catch(e) {
    dateVal = new Date();
  }
 
  return dateVal;
}


/**
Try to split a date string into an array of elements, using common date separators.
If the date is split, an array is returned; otherwise, we just return false.
*/
function splitDateString(dateString)
{
  var dArray;
  if (dateString.indexOf("/") >= 0)
    dArray = dateString.split("/");
  else if (dateString.indexOf(".") >= 0)
    dArray = dateString.split(".");
  else if (dateString.indexOf("-") >= 0)
    dArray = dateString.split("-");
  else if (dateString.indexOf("\\") >= 0)
    dArray = dateString.split("\\");
  else
    dArray = false;
 
  return dArray;
}

/**
Update the field with the given dateFieldName with the dateString that has been passed,
and hide the datepicker. If no dateString is passed, just close the datepicker without
changing the field value.

Also, if the page developer has defined a function called datePickerClosed anywhere on
the page or in an imported library, we will attempt to run that function with the updated
field as a parameter. This can be used for such things as date validation, setting default
values for related fields, etc. For example, you might have a function like this to validate
a start date field:

function datePickerClosed(dateField)
{
  var dateObj = getFieldDate(dateField.value);
  var today = new Date();
  today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
 
  if (dateField.name == "StartDate") {
    if (dateObj < today) {
      // if the date is before today, alert the user and display the datepicker again
      alert("Please enter a date that is today or later");
      dateField.value = "";
      document.getElementById(datePickerDivID).style.visibility = "visible";
      adjustiFrame();
    } else {
      // if the date is okay, set the EndDate field to 7 days after the StartDate
      dateObj.setTime(dateObj.getTime() + (7 * 24 * 60 * 60 * 1000));
      var endDateField = document.getElementsByName ("EndDate").item(0);
      endDateField.value = getDateString(dateObj);
    }
  }
}

*/
function updateDateField(dateFieldName, dateString)
{
  var targetDateField = document.getElementsByName (dateFieldName).item(0);
  if (dateString)
    targetDateField.value = dateString;
 
  var pickerDiv = document.getElementById(datePickerDivID);
  pickerDiv.style.visibility = "hidden";
  pickerDiv.style.display = "none";
 
  adjustiFrame();
  targetDateField.focus();
 
  // after the datepicker has closed, optionally run a user-defined function called
  // datePickerClosed, passing the field that was just updated as a parameter
  // (note that this will only run if the user actually selected a date from the datepicker)
  if ((dateString) && (typeof(datePickerClosed) == "function"))
    datePickerClosed(targetDateField);
}


/**
Use an "iFrame shim" to deal with problems where the datepicker shows up behind
selection list elements, if they're below the datepicker. The problem and solution are
described at:

http://dotnetjunkies.com/WebLog/jking/archive/2003/07/21/488.aspx
http://dotnetjunkies.com/WebLog/jking/archive/2003/10/30/2975.aspx
*/
function adjustiFrame(pickerDiv, iFrameDiv)
{
  // we know that Opera doesn't like something about this, so if we
  // think we're using Opera, don't even try
  var is_opera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);
  if (is_opera)
    return;
  
  // put a try/catch block around the whole thing, just in case
  try {
    if (!document.getElementById(iFrameDivID)) {
      // don't use innerHTML to update the body, because it can cause global variables
      // that are currently pointing to objects on the page to have bad references
      //document.body.innerHTML += "<iframe id='" + iFrameDivID + "' src='javascript:false;' scrolling='no' frameborder='0'>";
      var newNode = document.createElement("iFrame");
      newNode.setAttribute("id", iFrameDivID);
      newNode.setAttribute("src", "javascript:false;");
      newNode.setAttribute("scrolling", "no");
      newNode.setAttribute ("frameborder", "0");
      document.body.appendChild(newNode);
    }
    
    if (!pickerDiv)
      pickerDiv = document.getElementById(datePickerDivID);
    if (!iFrameDiv)
      iFrameDiv = document.getElementById(iFrameDivID);
    
    try {
      iFrameDiv.style.position = "absolute";
      iFrameDiv.style.width = pickerDiv.offsetWidth;
      iFrameDiv.style.height = pickerDiv.offsetHeight ;
      iFrameDiv.style.top = pickerDiv.style.top;
      iFrameDiv.style.left = pickerDiv.style.left;
      iFrameDiv.style.zIndex = pickerDiv.style.zIndex - 1;
      iFrameDiv.style.visibility = pickerDiv.style.visibility ;
      iFrameDiv.style.display = pickerDiv.style.display;
    } catch(e) {
    }
 
  } catch (ee) {
  }
 
}

	function jump(v){ //v3.0
		document.location.href='<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?>&grp_id='+v;
	 // if (restore) selObj.selectedIndex=0;
	}
</script>
<style type="text/css">
/* the div that holds the date picker calendar */
.dpDiv {
}
/* the table (within the div) that holds the date picker calendar */
.dpTable {
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: center;
	color: #505050;
	background-color: #ece9d8;
	border: 1px solid #AAAAAA;
}
/* a table row that holds date numbers (either blank or 1-31) */
.dpTR {
}
/* the top table row that holds the month, year, and forward/backward buttons */
.dpTitleTR {
}
/* the second table row, that holds the names of days of the week (Mo, Tu, We, etc.) */
.dpDayTR {
}
/* the bottom table row, that has the "This Month" and "Close" buttons */
.dpTodayButtonTR {
}
/* a table cell that holds a date number (either blank or 1-31) */
.dpTD {
	border: 1px solid #ece9d8;
}
/* a table cell that holds a highlighted day (usually either today's date or the current date field value) */
.dpDayHighlightTD {
	background-color: #CCCCCC;
	border: 1px solid #AAAAAA;
}
/* the date number table cell that the mouse pointer is currently over (you can use contrasting colors to make it apparent which cell is being hovered over) */
.dpTDHover {
	background-color: #aca998;
	border: 1px solid #888888;
	cursor: pointer;
	color: red;
}
/* the table cell that holds the name of the month and the year */
.dpTitleTD {
}
/* a table cell that holds one of the forward/backward buttons */
.dpButtonTD {
}
/* the table cell that holds the "This Month" or "Close" button at the bottom */
.dpTodayButtonTD {
}
/* a table cell that holds the names of days of the week (Mo, Tu, We, etc.) */
.dpDayTD {
	background-color: #CCCCCC;
	border: 1px solid #AAAAAA;
	color: white;
}
/* additional style information for the text that indicates the month and year */
.dpTitleText {
	font-size: 12px;
	color: gray;
	font-weight: bold;
}
/* additional style information for the cell that holds a highlighted day (usually either today's date or the current date field value) */ 
.dpDayHighlight {
	color: 4060ff;
	font-weight: bold;
}
/* the forward/backward buttons at the top */
.dpButton {
	font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: gray;
	background: #d8e8ff;
	font-weight: bold;
	padding: 0px;
}
/* the "This Month" and "Close" buttons at the bottom */
.dpTodayButton {
	font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: gray;
	background: #d8e8ff;
	font-weight: bold;
}
.tbl_border {
	border:black 1px solid;
	font-size:13px;
}
.tbl_border_right {
	border-right:black 1px solid;
}
.tbl_border_top {
	border-top:black 1px solid;
}
</style>
<?php
	require_once('../../library/connectdb.inc.php');
	
	if(isset($_REQUEST['grp_id'])) 
		$g_default_id = $_REQUEST['grp_id'];
	else {
		$sql = "SELECT * FROM `observe_group` WHERE `default` LIKE 'yes';";
		$rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		$obj = mysql_fetch_object($rg);
		$g_default_name = $obj->g_name;
		$g_default_id = $obj->id;
		$_REQUEST['grp_id'] = $g_default_id;
	}
	$selected_group[$g_default_id] = " selected";	
	
	$sql = "SELECT * FROM `sim_result` WHERE `id`=".$_REQUEST['id'];
	$result = mysql_query($sql, $connection);
	if(mysql_num_rows($result) == 1) {
		$obj_result = mysql_fetch_object($result);
	}

	$time_now = time();
	$h_release = fn_get_last_auto_increment_id("bulletin");
	$h_year = date("y", $time_now)+43;
	$h_date = date('j/m/'.$h_year, $time_now);
	$h_time = date('H:i:s', $time_now);

		$sql_eta = "SELECT * FROM `sim_point_val`, `observe_point` 
				WHERE 
					`sim_point_val`.`id_point` = `observe_point`.`observ_point_id` AND 
					`sim_point_val`.`type` LIKE 'ETA' AND 
					((`sim_point_val`.`region_no` = 2 AND `observe_point`.`R2` = 'yes') OR (`sim_point_val`.`region_no` = 1 AND `observe_point`.`R1` = 'yes')) AND 
					`sim_point_val`.`sim_result_id` = ".$_REQUEST['id'];
					
		$sql_zmax = "SELECT * FROM `sim_point_val`, `observe_point` 
				WHERE 
					`sim_point_val`.`id_point` = `observe_point`.`observ_point_id` AND 
					`sim_point_val`.`type` LIKE 'ZMAX' AND 
					((`sim_point_val`.`region_no` = 2 AND `observe_point`.`R2` = 'yes') OR (`sim_point_val`.`region_no` = 1 AND `observe_point`.`R1` = 'yes')) AND  
					`sim_point_val`.`sim_result_id` = ".$_REQUEST['id'];
	
	$res_point_eta = mysql_query($sql_eta, $connection);
	if(mysql_num_rows($res_point_eta) < 1) die("! Could not query ETA of point of region 2.");
	
	$res_point_zmax = mysql_query($sql_zmax, $connection);
	if(mysql_num_rows($res_point_zmax) < 1) die("! Could not query Z_MAX of point of region 2.");
	
	
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
	z-index:1;
	height:60px;
}
.style1 {
	font-size: 22px;
	color: #FFFFFF;
}
.style2 {
	color: #FFFFFF
}
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
<DIV id=header>
  <div class="style1" id="Layer1">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top"><img src="../../image/image001.png" alt="" width="74" height="68"></td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>Tsunami Decision Support System<br>
                <font style="size:15px">by National Disaster Warning Center (NDWC) and <a href="http://www.chula.ac.th" style="color:white" title="Chulalongkorn University">Chulalongkorn University</a></font></td>
            </tr>
          </table></td>
        <td>&nbsp;</td>
        <td valign="top"><img src="../../image/Logo-Chula.png" alt="" height="68" border="0" usemap="#Map2"></td>
      </tr>
    </table>
  </div>
</DIV>
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
      <DIV class=submenu_item id=c5> <A <?=$section[3]?> id=cs_5 href="result.php?section=3">Results</A> </DIV>
      <!-- Status -->
      <DIV class=submenu_item id=c5> <A <?=$section[4]?> id=cs_5 href="search.php?section=4" title="See the visualizatoin result">Search </A> </DIV>
      <DIV class=submenu_item id=c5> <A <?=$section['4.1']?> id=cs_5 href="bulletin_release.php?section=4.1" title="See the visualizatoin result">Bulletin </A> </DIV>
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
    <br>
    <center>
      <table>
        <tr>
          <td><div align="center" class="style2"><strong>Powered By</strong></div></td>
        </tr>
        <tr>
          <td><div align="center">&nbsp;<img src="../../image/logo.jpg" width="90" height="27" style="border:3px" usemap="#Map"></div></td>
        </tr>
        <tr>
          <td><div align="center" class="style2">&nbsp;Thai National Grid Center</div></td>
        </tr>
      </table>
    </center>
  </DIV>
  <DIV id=middle_column>
    <DIV class="section bordered">
      <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14" height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Bulletin&nbsp;management<!-- InstanceEndEditable --> </H2>
      <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
        <div style="background-color:#D5EBFD; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>Operations&nbsp;:&nbsp;</strong>
          <!--<font color="#000099"> Select group </font><select name="grp" id="grp" onChange="jump(this.value)" style="font-size:13px; text-align:left">
          <?php
          require_once('../../library/connectdb.inc.php');
		  
		  $g_name = "";
		  $sql = "SELECT * FROM `observe_group`";
		  $rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
		  if( mysql_num_rows($rg) > 0 ) {
		  	while($obj = mysql_fetch_object($rg)) {
				if($obj->id == $_REQUEST['grp_id']) {
					$g_name = $obj->g_name;
					$g_id = $obj->id;
				}
		  ?>
            <option value="<?=$obj->id?>" style="font-size:13px; text-align:left" <?=$selected_group[$obj->id]?>>&nbsp;- <?=$obj->g_name?>&nbsp;<?=$obj->default == "yes" ? "(default)" : ""?></option>
          <?php
		  	}
          }else {
		  ?>
          <option value="0">! ERROR, no define group</option>
          <?php
          }
		  ?>
          </select> | -->
          <a href="result.php?section=3"><font color="#000099">Create new </font></a> | <a href="bulletin_release.php?section=<?=$_REQUEST['section']?>"><font color="#000099">List of released bulletin</font></a> | <a href="<?=$_SERVER['PHP_SELF']?>?section=<?=$_REQUEST['section']?><?=strlen($_REQUEST['id']) > 0 ? "&id=".$_REQUEST['id'] : ""?>"><font color="#000099">Reload</font></a></div>
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
          </tr>
        </table>
        <form action="bulletine_create_script.php?grp_id=<?=$_REQUEST['grp_id']?>" method="post">
          <fieldset id="def" style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
          <legend><strong class="style37">Create bulletin</strong>&nbsp;: <strong>enter neccessary information</strong></legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td valign="top"><table width="443" border="0" class="tbl_border" cellpadding="4" cellspacing="0" id="search_tbl3" style="display:">
                  <tr bgcolor="#FFFFFF">
                    <td colspan="3" valign="top" bordercolor="#999999" bgcolor="#7B869A" ><div align="center" class="style31">
                        <div align="left">Bulletin information of <b><u>
                          <?=$g_name?>
                          </u></b>
                          <input type="hidden" name="h_gname" value="<?=$g_name?>">
                          <input type="hidden" name="h_gid" value="<?=$g_id?>">
                          <input type="hidden" name="from_result_id" value="<?=$_REQUEST['id']?>">
                        </div>
                      </div></td>
                  </tr>
                  <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                    <th width="79" align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Release/Year</th>
                    <th width="7" valign="middern" scope="col"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
                    <th width="333" align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><input name="h_release" id="h_release" style=" text-align:center" value="<?=$h_release?>" size="5" maxlength="5"></td>
                          <td>&nbsp;/&nbsp;</td>
                          <td><input name="h_year" id="h_year" style="text-align:center" value="<?=$h_year?>" size="5" maxlength="5"></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></th>
                  </tr>
                  <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
                    <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Create&nbsp;date&nbsp;&amp;&nbsp;time</th>
                    <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
                    <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><input name="h_date" id="h_date" style="text-align:center" onClick="displayDatePicker('h_date');" value="<?=$h_date?>" size="25" maxlength="25"></td>
                          <td></td>
                          <td>&nbsp;</td>
                          <td><input name="h_time" id="h_time" style="text-align:center" value="<?=$h_time?>" size="15" maxlength="15"></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table></th>
                  </tr>
                </table></td>
              <td valign="top">&nbsp;</td>
            </tr>
          </table>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <table width="443" border="0" cellpadding="4" cellspacing="0" id="search_tbl" style="display:" class="tbl_border">
            <tr bgcolor="#FFFFFF">
              <td colspan="3" valign="top" bordercolor="#999999" bgcolor="#7B869A"><div align="center" class="style31">
                  <div align="left">Earthquake information</div>
                </div></td>
            </tr>
            <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Date &amp; Time</th>
              <th scope="col" valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="eq_date" id="eq_date" style="text-align:center" onClick="displayDatePicker('eq_date');" value="(click to select date)" size="25" maxlength="25"></td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td><input name="eq_time" id="eq_time" value="(enter time)" size="15" maxlength="15" style="text-align:center"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></th>
            </tr>
            <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Richter</th>
              <th scope="col" valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="eq_richter" id="eq_richter" style="text-align:center" onClick="displayDatePicker('ADate');" value="<?=number_format($obj_result->magnitude, 1)?>" size="25" maxlength="25"></td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></th>
            </tr>
            <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">Depth (km)</th>
              <th scope="col" valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><table width="0" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><input name="eq_depth" id="eq_depth" style="text-align:center" onClick="displayDatePicker('ADate');" value="<?=$obj_result->depth?>" size="25" maxlength="25"></td>
                    <td></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></th>
            </tr>
            <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <th align="left" valign="top" bgcolor="#F0F0F0" scope="col">Location</th>
              <th scope="col" valign="middle">&nbsp;</th>
              <th align="left" valign="top" scope="col">&nbsp;</th>
            </tr>
            <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;&nbsp;&nbsp;+&nbsp;Latitude</th>
              <th scope="col" valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" valign="top" scope="col"><input name="eq_lat" id="eq_lat" style="text-align:center" value="<?=$obj_result->decimal_lat?>" size="50" maxlength="50"></th>
            </tr>
            <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <th align="left" valign="middle" bgcolor="#F0F0F0" scope="col">&nbsp;&nbsp;&nbsp;+&nbsp;Longitude</th>
              <th scope="col" valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" valign="top" scope="col"><input name="eq_long" id="eq_long" style="text-align:center" value="<?=$obj_result->decimal_long?>" size="50" maxlength="50"></th>
            </tr>
          </table>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <table border="0" cellpadding="4" cellspacing="0" id="search_tbl2" style="display:" class="tbl_border">
            <tr bgcolor="#FFFFFF">
              <td colspan="6" valign="top" bordercolor="#999999" bgcolor="#7B869A"><div align="center" class="style4">
                  <div align="middle" class="style31">Information of observation area</div>
                </div></td>
            </tr>
            <tr>
              <th align="left" valign="middle" bgcolor="#BCCCDF" scope="col" class="tbl_border_right"><div align="center">No.</div></th>
              <th align="left" valign="middle" bgcolor="#BCCCDF" scope="col" class="tbl_border_right"><div align="center">Province</div></th>
              <th valign="middle" bgcolor="#BCCCDF" scope="col" class="tbl_border_right"><div align="center">Area</div></th>
              <th valign="middle" bgcolor="#BCCCDF" scope="col"><div align="center"></div></th>
              <th align="left" bgcolor="#BCCCDF" scope="col" class="tbl_border_right"><div align="center">Elapse Time Arrival&nbsp;(H:M:S)</div></th>
              <th align="left" bgcolor="#BCCCDF" scope="col"><div align="center">Wave Height&nbsp;(metre)</div></th>
            </tr>
            <?php
			$i = 1; $n = 1; 
			while($obj = mysql_fetch_object($res_point_zmax)) {
				$val_zmax[$n] = $obj->values;
				$n++;
			}
			while($obj = mysql_fetch_object($res_point_eta)) {
				
            ?>
            <tr onMouseOver="javascript: this.style.background='#D0EFFB';" onMouseOut="javascript: this.style.background='';">
              <th align="left" valign="middle" bgcolor="" scope="col" class="tbl_border_right"><div align="center">
                  <?=$i++?>
                </div></th>
              <th align="left" valign="middle" bgcolor="" scope="col" class="tbl_border_right"> <div align="left">
                  <?=$obj->province_t?>
                  <input type="hidden" name="ob[province][<?=$i?>]" value="<?=$obj->province_t?>">
                  <input type="hidden" name="ob[province_eng][<?=$i?>]" value="<?=$obj->province?>">
                </div></th>
              <th scope="col" valign="middle" class="tbl_border_right"><div align="left">
                  <?=$obj->name_t?>
                  <input type="hidden" name="ob[area][<?=$i?>]" value="<?=$obj->name_t?>">
                  <input type="hidden" name="ob[area_eng][<?=$i?>]" value="<?=$obj->name?>">
                </div></th>
              <th scope="col" valign="middle"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col" class="tbl_border_right"><div align="center">
                  <?php $res_time = round(($obj->values/3600), 3);
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
										
					$result_time = $hour.":".$minute.":".$second;
					echo ($result_time == 0) ? "-" : $result_time;
					#echo $res_time;
			  ?>
                  <input type="hidden" name="ob[eta][<?=$i?>]" value="<?=round(($obj->values/3600), 3)?>">
                </div></th>
              <th align="left" scope="col"><div align="center">
                  <?=number_format($val_zmax[$i-1], 3)?>
                  <input type="hidden" name="ob[zmax][<?=$i?>]" value="<?=$val_zmax[$i-1]?>">
                </div></th>
            </tr>
            <?php
			}
            ?>
          </table>
          </fieldset>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <input name="create" type=submit class=butenter id=create style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Create">
          <input name="discard" type=button class=butenter id=discard style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Discard">
        </form>
        <table width="10" height="2" border="0">
          <tr>
            <td></td>
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
</BODY>
<!-- InstanceEnd -->
</HTML>
