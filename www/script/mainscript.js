function verifyCat(sel) {
	if (sel.options[sel.selectedIndex].value == "")
		sel.selectedIndex = sel.selectedIndex - 1;
}

function PopupLink(a) {
    return !window.open(a.href, a.target, 'width=322, height=80, location=no,menubar=no,resizable=no,scrollbars=no,status=no,toolbar=no');
}

function log_analysis() {
	document.write('<img width="1" height="1" src="/log_analysis_screen_info.gif?' + 'width=' + screen.width + '&height=' + screen.height + '&depth=' + screen.colorDepth + '">\n');
	return true;
}

function goSearch(){
	history.go(-1);
}

//article bottom voting script

function rate(val){
document.f.value.value = val
document.f.submit()
setTimeout('markSubmit()', 100)
}

function markSubmit(){
document.getElementById("rateDiv").innerHTML = "<span class=\"left\">Thank you for voting</span>"
}
//end of script

//Flash-script
function verifyFlash() {
	n=navigator;
	p=n.plugins;
	v=10;
	ffff=false;
	if (p) {
		var fp = p['Shockwave Flash'];
		if(typeof fp == 'object') {
			vv = fp.description;
			k=vv.indexOf('.');
			if(k)
				ffff = vv.substring(k-1,k+2);
		}
	}
	m = '<';
	b = '>'
	document.write(m+'script type="text/vbscript" language="VBScript"'+b+'\n'+m+'!--'+'\non error resume next \nDIM o \ni='+v+'\nffff=0\nDo\nSET o = CreateObject("ShockwaveFlash.ShockwaveFlash."&i)\nIF IsObject(o) THEN \nffff=i\nEND IF\ni=i-1\nLoop Until i<1 or ffff<>0\n'+'//--'+b+m+'/SCRIPT'+b);
	ver_flash = ffff;

	return ver_flash
}


function refreshImages(){
var search="?"+(new Date()).getTime();
for(var i=0;i<document.images.length;document.images[i++].src+=search);
}