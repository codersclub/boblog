var currentpicname;
var realpath="attachment/";

function insertmyUpload (filename) {
	filename=filename.replace(/\*/g, '.');
	filename=realpath+filename;
	if (document.getElementById('ifautoaddubb').checked) filename=autoattachubb (filename);
	parent.AddText(filename);
}

function autoattachubb (filename) {
	var finalresult;
	finalresult="[file]"+filename+"[/file]";
	var extindex = filename.lastIndexOf(".");
	if (extindex!=-1) {
		var realext=filename.substring(extindex+1);
		if (realext=="gif" || realext=="jpg" || realext=="png" || realext=="bmp" || realext=="jpeg") {
			 finalresult="[img]"+filename+"[/img]";
		}
		else if (realext=="swf")  {
			 finalresult="[swf=400,300]"+filename+"[/swf]";
		}
		else if (realext=="wma" || realext=="mp3" || realext=="asf" || realext=="wmv")  {
			 finalresult="[wmp=400,300]"+filename+"[/wmp]";
		}
		else if (realext=="rm" || realext=="rmvb" || realext=="ra" || realext=="ram")  {
			 finalresult="[real=400,300]"+filename+"[/real]";
		}
		else if (realext=="htm" || realext=="html")  {
			 finalresult="[url]"+filename+"[/url]";
		}
		else if (realext=="zip" || realext=="rar")  {
			 finalresult="[file]"+filename+"[/file]";
		}
	}
	return finalresult;
}

function picPreview (filename) {
	var realfilename=realpath+filename;
	currentpicname=realfilename;
	var divdvs="<div style='margin-top: 0px;  width: 400px !important; width: 320px; height: 165px; background-repeat: no-repeat; background-position: 130px 20px !important; background-position: 0px 20px; background-image: url("+realfilename+");'>"+jslang[18]+"<input type='text' id='picalign' value='m' size=1 maxlength=1>(l-"+jslang[19]+",m-"+jslang[20]+",r-"+jslang[21]+") <input type='button' value='"+jslang[22]+"' onclick='doinsertimage();'></div>";
	document.getElementById('picp').innerHTML=divdvs;
}

function doinsertimage() {
	var alignpro=document.getElementById('picalign').value;
	var plusalign;
	if (alignpro=='l') plusalign=' align=l';
	else if  (alignpro=='r') plusalign=' align=r';
	else plusalign='';
	var finalresult="[img"+plusalign+"]"+currentpicname+"[/img]";
	parent.AddText(finalresult);
}
