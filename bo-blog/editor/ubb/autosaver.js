/*    本文件部分思路和方法来自
       基于Ajax的网站通用草稿自动保存系统SipoAutoSaver(ver 3.0)  by Sipo
       http://www.dc9.cn/post/SipoAutoSaverV3.html                                 */

var AutoSaveTime=60;   //修改每次保存时间(秒)
var AutoHideMsg=55;  

var autosaveroff=getCookie ('autosaveroff');
if (autosaveroff!=1) {
	savertimer = window.setTimeout("timer()", 0);
}
savetime=AutoSaveTime;
function timer() { 
	var timemsg=document.getElementById('timemsg');
	var timemsg2=document.getElementById('timemsg2');
	savetime=savetime-1;
	timemsg.innerHTML = savetime+jslang[63];
	if (savetime>=0){
		savertimer = window.setTimeout("timer()", 1000);
		if (savetime==AutoHideMsg) timemsg2.innerHTML='';
	}
	else {
		if (savetime<=-1000) {savetime=AutoSaveTime;timer();}
		else{
			timemsg.innerHTML = jslang[64];
			savedraft();
			savetime=AutoSaveTime;
			timer();
		}
	}
}

function savedraft() {
	var content = blogencode(document.getElementById('content').value);
	var idforsave = blogencode(document.getElementById('idforsave').value);
	var title = blogencode(document.getElementById('title').value);
	var gourl="admin/cp_autosaver.php";
	var postData = "unuse=unuse&title="+title+"&content="+content+"&idforsave="+idforsave;
	makeRequest(gourl, 'savemydraft', 'POST', postData);
}

function savemydraft() {
	var timemsg2=document.getElementById('timemsg2');
	if (http_request.readyState == 4) {
		if (http_request.status == 200) {
			if (http_request.responseText=='ok') {
				timemsg2.innerHTML = jslang[65];
				savetime=-1000;
			} else {
				alert('Auto save failed.');
			}
		}  else {
			alert('Auto save failed.');
		}
	}
}

function stopautosaver () {
	clearTimeout(savertimer);
}

function restartautosaver () {
	savertimer = window.setTimeout("timer()", 0);
	var dateObjexp= new Date();
	dateObjexp.setFullYear(2010); 
	setCookie('autosaveroff', 0,dateObjexp, null, null, false);
}

function stopforever() {
	var dateObjexp= new Date();
	dateObjexp.setFullYear(2010); 
	setCookie('autosaveroff', 1,dateObjexp, null, null, false);
	stopautosaver();
	document.getElementById('timemsg').innerHTML='Autosaver disabled.';
}