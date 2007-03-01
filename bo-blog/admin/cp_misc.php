<?PHP
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
<<A Bluview Technology Product>>
禁止使用Windows记事本修改文件，由此造成的一切使用不正常恕不解答！
PHP+MySQL blog system.
Code: Bob Shen
Offical site: http://www.bo-blog.com
Copyright (c) Bob Shen 中国－上海
In memory of my university life
------------------------------------------------------- */

if (!defined('VALIDADMIN')) die ('Access Denied.');
include_once ("data/weather.php");
include_once ("data/cache_emot.php");
checkpermission('CP');
confirmpsw(); //Re-check password

//Define some senteces
$finishok=$lna[360];
$backtoemot="{$lna[29]}|admin.php?go=misc_emot";
$backtoforbidden="{$lna[30]}|admin.php?go=misc_forbidden";
$backtoweather="{$lna[31]}|admin.php?go=misc_weatherset";
$backtoava="{$lna[32]}|admin.php?go=misc_avatar";

if (!$job) $job='forbidden';

if ($job=='weatherset') {
	if ($weather) {
		$i=0;
		while (@list($weathername, $weatherdetail)=@each($weather)) {
			$formbody.="<tr><td colspan=2 class='prefsection'>{$lna[361]}{$weatherdetail['text']}</td></tr>";
			if ($weathername!='blank') $formbody.="<tr><td class='prefleft'>{$lna[362]}</td><td class='prefright'><input type=text size=20 name='variable[{$i}]' value='{$weathername}'> {$lna[363]}</td></tr>";
			else $formbody.="<tr><td class='prefleft'>{$lna[362]}</td><td class='prefright'><input type=text size=20 name='variable[{$i}]' value='{$weathername}' disabled><input type=hidden name='variable[{$i}]' value='{$weathername}'> {$lna[364]}</td></tr>";
			$formbody.="<tr><td class='prefleft'>{$lna[365]}</td><td class='prefright'><input type=text size=20 name='desc[{$i}]' value='{$weatherdetail['text']}'></td></tr>";
			$formbody.="<tr><td class='prefleft'>{$lna[366]}</td><td class='prefright'><input type=text size=40 name='icon[{$i}]' value='{$weatherdetail['image']}'> <img src='{$weatherdetail['image']}'></td></tr>";
			if ($weathername!='blank') $formbody.="<tr><td class='prefleft'>{$lna[367]}</td><td class='prefright'><input type=button value='{$lna[368]}' onclick=\"makesuredelweather('$weathername');\"></td></tr>";
			$i+=1;
			unset ($weathername, $weatherdetail);
		}
	}
	$display_overall.=highlightadminitems('weatherset', 'misc');
$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[31]}
</td>
<td class="sectend">{$lna[369]}</td>
</tr>
</table>
<table class='tablewidth' cellpadding=4 cellspacing=1 align=center>
<form action="admin.php?go=misc_weathersave" method="post">
$formbody
</table>
<br>
<div align=center><input type=submit value="{$lna[64]}"> <input type=reset value="{$lna[65]}"></div>
</form>
<br>
<table class='tablewidth' cellpadding=4 cellspacing=1 align=center>
<form action="admin.php?go=misc_weatheradd" method="post">
<tr><td colspan=2 class='prefsection'>{$lna[370]}</td></tr>
<tr><td class='prefleft'>{$lna[362]}</td><td class='prefright'><input type=text size=20 name='variable' value=''> {$lna[363]}</td></tr>
<tr><td class='prefleft'>{$lna[365]}</td><td class='prefright'><input type=text size=20 name='desc' value=''></td></tr>
<tr><td class='prefleft'>{$lna[366]}</td><td class='prefright'><input type=text size=40 name='icon' value=''> </td></tr>
</table>
<br>
<div align=center><input type=submit value="{$lna[64]}"> <input type=reset value="{$lna[65]}"></div>
</form>
eot;
}

if ($job=='weathersave') {
	acceptrequest('variable,icon,desc');
	if (!is_array($variable) || !is_array($icon) || !is_array($desc)) {
		catcherror($lna[371]);
	}
	$nums=count($variable);
	for ($i=0; $i<$nums; $i++) {
		$conout.="\$weather['".safe_convert($variable[$i])."']['image']='".safe_convert($icon[$i])."';\n";
		$conout.="\$weather['".safe_convert($variable[$i])."']['text']='".safe_convert($desc[$i])."';\n";
	}
	$wholeout="<?PHP\n{$conout}";
	if (writetofile("data/weather.php", $wholeout)) {
		catchsuccess ($finishok, array($backtoemot,$backtoubb,$backtoforbidden,$backtoweather,$backtoava));
	} else {
		catcherror ($lna[66]."data/weather.php");
	}
}

if ($job=='weatheradd') {
	acceptrequest('variable,icon,desc');
	if (empty($variable) || empty($icon) || empty($desc)) {
		catcherror($lna[371]);
	}
	$conout=@readfromfile("data/weather.php");
	$conout.="\$weather['".safe_convert($variable)."']['image']='".safe_convert($icon)."';\n";
	$conout.="\$weather['".safe_convert($variable)."']['text']='".safe_convert($desc)."';\n";
	if (writetofile("data/weather.php", $conout)) {
		catchsuccess ($finishok, array($backtoemot,$backtoubb,$backtoforbidden,$backtoweather,$backtoava));
	} else {
		catcherror ($lna[66]."data/weather.php");
	}
}

if ($job=='weatherdel') {
	if (empty($itemid)) {
		catcherror($lna[372]);
	}
	$blog->query("UPDATE `{$db_prefix}blogs` SET `weather`='blank' WHERE `weather`='{$itemid}'");
	if ($weather) {
		while (@list($weathername, $weatherdetail)=@each($weather)) {
			if ($weathername!=$itemid && $weathername!=='') {
				$conout.="\$weather['{$weathername}']['image']='{$weatherdetail['image']}';\n";
				$conout.="\$weather['{$weathername}']['text']='{$weatherdetail['text']}';\n";
				unset ($weathername, $weatherdetail);
			}
		}
	}
	$wholeout="<?PHP\n{$conout}";
	if (writetofile("data/weather.php", $wholeout)) {
		catchsuccess ($finishok, array($backtoemot,$backtoubb,$backtoforbidden,$backtoweather,$backtoava));
	} else {
		catcherror ($lna[66]."data/weather.php");
	}
}

if ($job=='avatar') {
	if ($itemid=='open') {
		 changesingleconfig ('avatar', '1');
		 header ("Location: admin.php?go=misc_avatar");
	}
	elseif ($mbcon['avatar']=='0') {
$notopen=<<<eot
<tr>
<td colspan='2' class="sect" align='center'>
{$lna[373]}<a href="admin.php?go=misc_avatar_open">{$lna[374]}</a>
</td>
</tr>
eot;
	}
	$display_overall.=highlightadminitems('avatar', 'misc');
$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[32]}
</td>
<td class="sectend">{$lna[375]}</td>
</tr>
$notopen
<tr>
<td colspan='2' class="sect">
{$lna[376]}<br>
<ul><li>{$lna[377]}</li>
<li>{$lna[378]}</li>
<li>{$lna[379]}</li></ul>
<br><br>
<div align=center>
<input type=button onclick="window.location='admin.php?go=misc_avatarrefresh';" value="{$lna[380]}">
</div>
</td>
</tr>
</table>
eot;
}

if ($job=='avatarrefresh') {
	$handle=@opendir("images/avatars");
	if (!$handle) catcherror ("{$lna[155]} images/avatars {$lna[156]}<ul><li>{$lna[157]}</li><li>{$lna[158]}</li><li>{$lna[159]}</li></ul>");
	while (false !== ($file=readdir($handle))) {
		if ($file!="." && $file!=".." && (stristr($file, '.gif') || stristr($file, '.png')  || stristr($file, '.jpg'))) {
			$savetext.="'{$file}',\n";
		}
	}
	$saveall="<?PHP\n\$avatars=array(\n".$savetext.");\n?>";
	if (writetofile ("data/cache_avatars.php", $saveall)) {
		catchsuccess ($finishok, array($backtoemot,$backtoubb,$backtoforbidden,$backtoweather,$backtoava));
	} else {
		catcherror ($lna[66]."data/cache_avatars.php");
	}
}


if ($job=='emot') {
	if ($myemots) {
		$i=0;
		while (@list($emotcode, $emott)=@each($myemots)) {
			$emotimage=$emott['image'];
			$emotthumb=$emott['thumb'];
			$formbody.="<tr class='sect' align=center><td width=40><img src='images/emot/{$emotthumb}'></td><td><input type=text size=9 name='variable[{$i}]' value='{$emotcode}'></td><td><input type=text size=25 name='image[{$i}]' value='{$emotimage}'> </td><td><input type=text size=25 name='thumb[{$i}]' value='{$emotthumb}'></td></tr>";
			$i+=1;
			//if ($i==25) break;
			unset ($emotcode, $emotimage, $emotthumb);
		}
	}
	//if ($i<25) {
		//$blanked=25-$i;
		$blanked=5;
		for ($m=0; $m<$blanked; $m++) {
			$formbody.="<tr class='sect' align=center><td width=40>&nbsp;</td><td><input type=text size=9 name='variable[{$i}]' value=''></td><td><input type=text size=25 name='image[{$i}]' value=''> </td><td><input type=text size=25 name='thumb[{$i}]' value=''></td></tr>";
			$i+=1;
		}
	//}
	$display_overall.=highlightadminitems('emot', 'misc');
$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[29]}
</td>
<td class="sectend">{$lna[381]}</td>
</tr>
</table>
<table class='tablewidth' cellpadding=4 cellspacing=1 align=center>
<form action="admin.php?go=misc_emotsave" method="post">
<tr align=center class="admintitle"><td>{$lna[382]}</td><td>{$lna[383]}*</td><td>{$lna[384]}**</td><td>{$lna[385]}***</td></tr>
$formbody
</table>
<table class='tablewidth' cellpadding=4 cellspacing=1 align=center>
<tr><td class="sect">{$lna[386]}<ul><li>{$lna[387]}</li><li>{$lna[388]}</li><li>*{$lna[389]}</li><li>**{$lna[390]}</li><li>***{$lna[391]}</li></ul></td>
</tr>
</table>
<br>
<div align=center><input type=submit value="{$lna[64]}"> <input type=reset value="{$lna[65]}"></div>
</form>
eot;
}

if ($job=='emotsave') {
	acceptrequest('variable,image,thumb');
	if (!is_array($variable) || !is_array($image) || !is_array($thumb)) {
		catcherror($lna[371]);
	}
	$nums=count($variable);
	for ($i=0; $i<$nums; $i++) {
		if ($variable[$i]!=='') {
			$conout.="\$myemots['".safe_convert($variable[$i])."']['code']='".safe_convert($variable[$i])."';\n";
			$conout.="\$myemots['".safe_convert($variable[$i])."']['image']='".safe_convert($image[$i])."';\n";
			$conout.="\$myemots['".safe_convert($variable[$i])."']['thumb']='".safe_convert($thumb[$i])."';\n";
		}
	}
	$wholeout="<?PHP\n{$conout}";
	if (writetofile("data/cache_emot.php", $wholeout)) {
		include_once("data/cache_emot.php");
		recache_emotselection();
		catchsuccess ($finishok, array($backtoemot,$backtoubb,$backtoforbidden,$backtoweather,$backtoava));
	} else {
		catcherror ($lna[66]."data/cache_emot.php");
	}
}

if ($job=='forbidden') {
	extract_forbidden();
	$item_name=array('banword'=>$lna[392], 'nosearch'=>$lna[393], 'keep'=>$lna[394], 'suspect'=>$lna[395], 'banip'=>$lna[396]);
	$item_desc=array('banword'=>$lna[397], 'nosearch'=>$lna[398], 'keep'=>$lna[399], 'suspect'=>$lna[400], 'banip'=>$lna[401]);
	foreach ($item_name as $key=>$item) {
		$bodyarea=@implode("\r", $forbidden[$key]);
		$selbody[$key]="<a name='f_{$key}'></a><table class='tablewidth' cellpadding=4 align=center><tr><td class='sect'><table class='tablewidth' cellpadding=1 align=center><tr><td class='sect'><b>{$item}</b><br><textarea name='{$key}' cols='80' rows='5'>{$bodyarea}</textarea><br>{$item_desc[$key]} $lna[402]</td></tr></table></td></tr></table><br>";
		$option[$key]="<option value='{$key}'>{$item}</option>\n";
	}
	$selbody_all=@implode('', $selbody);
	$option_all=@implode('', $option);
	$display_overall.=highlightadminitems('forbidden', 'misc');
$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[30]}
</td>
<td class="sectend">{$lna[403]}</td>
</tr>
<form action="admin.php?go=misc_forbiddensave" method="post">
</table>
$selbody_all
<table cellpadding=3 cellspacing=1 align=center class='tablewidth'>
<tr><td class='sect' align=center><input type=submit value="{$lna[404]}"> <input type=reset value="{$lna[405]}">
</td></tr></form></table>
<br><br>
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<form action="admin.php?go=misc_importforbidden" method="post" enctype='multipart/form-data'>
<tr>
<td width=160 class="sectstart">
{$lna[406]}
</td>
<td class="sectend">{$lna[407]}</td>
</tr>
<tr><td colspan=2 class='sect'>

<table cellpadding=3 cellspacing=1 align=center width=80%>
<tr><td width=25% align=right>{$lna[408]}</td><td width=5%>&nbsp;</td><td width=70%><input type=file name="importfile"><br>{$lna[409]}</td></tr>
<tr><td width=25% align=right>{$lna[410]}</td><td width=5%>&nbsp;</td><td width=70%><select name="destination">{$option_all}</select></td></tr>
<tr><td class='sect' align=center colspan=3><input type=submit value="{$lna[64]}"> <input type=reset value="{$lna[65]}">
</td></tr></table>

</td></tr></table>
</form>
eot;
}

if ($job=='forbiddensave') {
	acceptrequest('banword,nosearch,keep,suspect,banip');
	$items=array('banword', 'nosearch', 'keep', 'suspect', 'banip');
	foreach ($items as $item_name) {
		$item=str_replace("\r", ',', trim($$item_name));
		$item=str_replace("\n", ',', $item);
		$item=str_replace(",,", ',', $item);
		$item_array=@explode(',', safe_convert($item));
		$item_array=array_unique($item_array);
		$item_array=array_values($item_array);
		$item=@implode(",", $item_array);
		$update_query[]="`{$item_name}`='{$item}'";
	}
	$update_query_all=@implode(', ', $update_query);
	$blog->query("UPDATE `{$db_prefix}forbidden` SET {$update_query_all}");
	catchsuccess ($finishok, array($backtoemot,$backtoubb,$backtoforbidden,$backtoweather,$backtoava));
}

if ($job=='importforbidden') {
	acceptrequest('destination');
	$items=array('banword', 'nosearch', 'keep', 'suspect', 'banip');
	if (!in_array($destination, $items)) catcherror($lna[411]);
	$importfile=$_FILES['importfile'];
	$upload_file=$importfile['tmp_name'];
	$upload_filename=urlencode($importfile['name']);
	$ext=strtolower(strrchr($upload_filename,'.'));
	if ($ext!='.txt') catcherror($lna[412]);
	if (!move_uploaded_file ($upload_file,"{$db_tmpdir}/{$upload_filename}")) catcherror ($lna[130].'temp/'); 
	$filecontent=@file("{$db_tmpdir}/{$upload_filename}");
	$item=trim(@implode(",", $filecontent));
	$item=safe_convert($item);
	$item=str_replace("<br/>", '', $item);
	extract_forbidden();
	$old=@implode(",", $forbidden[$destination]);
	$item.=','.$old;
	$item=str_replace(",,", ',', $item);
	$blog->query("UPDATE `{$db_prefix}forbidden` SET `{$destination}`='{$item}'");
	@unlink("{$db_tmpdir}/{$upload_filename}");
	catchsuccess ($finishok, array($backtoemot,$backtoubb,$backtoforbidden,$backtoweather,$backtoava));
}

if ($job=='sessiondir') {
	$checked=($db_defaultsessdir=='1') ? 'checked' : '';

	$display_overall.=highlightadminitems('sessiondir', 'misc');
$display_overall.= <<<eot
<form action="admin.php?go=misc_changesessiondir" method="post">
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[935]}
</td>
<td class="sectend">{$lna[936]}</td>
<tr><td colspan=2 class='sect'>

<table cellpadding=6 cellspacing=1 align=center width=95%>
<tr><td colspan=2>{$lna[977]}</td></tr>
<tr><td width=25% align=right valign=top>{$lna[482]}</td><td><input type=password name="modpassword"><br>{$lna[964]}</td></tr>
<tr><td width=25% align=right valign=top>{$lna[978]}</td><td><input type=text name="newdirname">/<br>{$lna[979]}</td></tr>
<tr><td width=25% align=right valign=top>{$lna[824]}</td><td><input type=checkbox value=1 name="usedefaultsess" {$checked}>{$lna[1000]}<br>{$lna[1001]}</td></tr>

<tr><td class='sect' align=center colspan=2><input type=submit value="{$lna[64]}"> <input type=reset value="{$lna[65]}">
</td></tr></table>

</td></tr></table>
</form>
eot;
}

if ($job=='testsession') {
	$testcontent1=<<<eot
<?php
error_reporting(0);
session_cache_limiter("private, must-revalidate");
session_start();
\$_SESSION['testboblogsess']='This is a test string.';
eot;
	$testcontent2=<<<eot
<?php
error_reporting(0);
session_cache_limiter("private, must-revalidate");
session_start();
die (\$_SESSION['testboblogsess']);
eot;
	writetofile ("data/tmpsesstest1.php", $testcontent1);
	writetofile ("data/tmpsesstest2.php", $testcontent2);
	$display_overall.=highlightadminitems('sessiondir', 'misc');
$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[935]}
</td>
<td class="sectend">{$lna[936]}</td>
<tr><td colspan=2 class='sect' align=center>
<iframe id="ifa" width=250 height=100 src='data/tmpsesstest1.php'></iframe><br>
<br>
{$lna[1002]}<br><input type=button onclick="document.getElementById('ifa').src='data/tmpsesstest2.php'" value='{$lna[1003]}'><br><br>
{$lna[1004]}<br>
<input type=button onclick="document.getElementById('ifb').innerHTML='<b><font color=green>{$lna[1005]}</font></b>'" value='{$lna[1006]}'>  
<input type=button onclick="document.getElementById('ifb').innerHTML='<b><font color=red>{$lna[1007]}</font></b>'" value='{$lna[1008]}'>
<br><div id='ifb'></div>
</td></tr></table>
eot;
}



if ($job=='changesessiondir') {
	acceptrequest('modpassword,newdirname,usedefaultsess');
	$checkmodp=md5($modpassword);
	$checkmodp_try=array();
	$checkmodp_try=$blog->getbyquery("SELECT * FROM `{$db_prefix}user` WHERE `userid`='{$userdetail['userid']}' AND `userpsw`='{$checkmodp}'");
	if ($checkmodp_try['userid']!=$userdetail['userid']) catcherror($lna[965]);
	if ($checkmodp_try['usergroup']!=2) catcherror($lna[965]);

	if (empty($newdirname)) catcherror ($lna[980]);
	$newdirname=basename($newdirname);
	if (!is_dir($newdirname)) catcherror ($lna[980]);
	else { //attempt to write
		$test=writetofile("{$newdirname}/text.txt", ' ');
		if (!$test)  catcherror ($lna[980]);
		else @unlink("{$newdirname}/text.txt");
	}
	if ($usedefaultsess!=1) {
		$partwrite="\$db_tmpdir='{$newdirname}';\n\$db_defaultsessdir='0';\n";
	} else {
		$partwrite="\$db_tmpdir='{$newdirname}';\n\$db_defaultsessdir='1';\n";
	}

	unset ($config);
	include('data/config.php');
	$savetext="<?PHP\n\$db_server='{$db_server}';\n\$db_username='{$db_username}';\n\$db_password='{$db_password}';\n\$db_name='{$db_name}';\n\$db_prefix='{$db_prefix}';\n\$db_410='{$db_410}';\n";
	while (@list ($key, $val) = @each ($config)) {
		$savetext.="\$config['{$key}']='".admin_convert(stripslashes($val))."';\n";
	}
	if (writetofile ("data/config.php", $savetext)) {
		catchsuccess ($lna[981]);
	} else {
		catcherror ($lna[66]."data/config.php");
	}
}

if ($job=='urlrewrite') {
	if ($config['smarturl']==0) $checksta1='checked';
	elseif ($config['urlrewrite']==0) $checksta2='checked';
	else $checksta3='checked';
	$display_overall.=highlightadminitems('urlrewrite', 'misc');
$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[527]}
</td>
<td class="sectend">{$lna[528]}</td>
<tr><td colspan=2 class='sect'>
<form action="admin.php?go=misc_urlrewritesave" method="post">
{$lna[1084]}<br>
<input type=radio value='0' name="urlrewritesta" {$checksta1}> {$lna[511]}<br>
<input type=radio value='1' name="urlrewritesta" {$checksta2}> {$lna[938]}<br>
<input type=radio value='2' name="urlrewritesta" {$checksta3}> {$lna[940]}<br>
<div align=center><input type=submit value="{$lna[64]}"> <input type=reset value="{$lna[65]}"></div></form>
</td></tr></table>
<br><br>
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[529]}
</td>
<td class="sectend">{$lna[530]}</td>
<tr><td colspan=2 class='sect' align=center>
<br><form action="admin.php?go=misc_urlrewriteguide" method="post">
<div align=center><input type=submit value="{$lna[529]}"></div><br><br>
</form>
</td></tr></table>
eot;
}

if ($job=='urlrewriteguide') {
	acceptrequest('servertype,serverroot');
	$servertype=floor($servertype);
	$serverroot=safe_convert(stripslashes($serverroot));
	if (!$servertype || !$serverroot) {
		if (strstr(PHP_OS, 'WIN')) $IIScheck='checked';
		else $Apachecheck='checked';
		$possibleroot=pathinfo($_SERVER['PHP_SELF']);
		$possibleroot=$possibleroot['dirname'].'/';
		$display_overall.=highlightadminitems('urlrewrite', 'misc');
		$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[529]}
</td>
<td class="sectend">{$lna[530]}</td>
<tr><td colspan=2 class='sect'>
<form action="admin.php?go=misc_urlrewriteguide" method="post">
{$lna[1085]}<br>
<input type=radio value='1' name="servertype" {$Apachecheck}> Apache<br>
<input type=radio value='2' name="servertype" {$IIScheck}> IIS<br><br>
{$lna[1086]}<br>
<input type=text value='$possibleroot' name="serverroot"><br><br>
<div align=center><input type=submit value="{$lna[64]}"></div><br><br>
</form>
</td></tr></table>
eot;
	} else {
		if ($servertype==1) {
			$ruletemplate=nl2br(readfromfile("images/others/rule_apache.txt"));
			$ruletemplate=str_replace('<ROOTHERE>', $serverroot, $ruletemplate);
			$rulefilename=".htaccess";
		} else {
			$ruletemplate=nl2br(readfromfile("images/others/rule_iis.txt"));
			$ruletemplate=str_replace('<ROOTHERE>', str_replace('/', "\\/", $serverroot), $ruletemplate);
			$rulefilename="httpd.ini";
		}
		$showword=sprintf($lna[1087], $rulefilename);
		@include_once ("data/cache_latest.php");
		$testid=$cache_latest_all[0]['blogid'];
		$display_overall.=highlightadminitems('urlrewrite', 'misc');
		$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[529]}
</td>
<td class="sectend">{$lna[530]}</td>
<tr><td colspan=2 class='sect'>
{$showword}<br>
<div style="width:90%; background-color: #CCC; font-family: Terminal; color: #000; border: 1px solid #000;">
$ruletemplate
</div>
<br><br>
<b>[{$lna[939]}]</b><br>
<a href="read.php?{$testid}" target="_blank">{$lna[1088]}</a><br>
<a href="post/{$testid}.htm" target="_blank">{$lna[1089]}</a><br>
<br><br>
<b>[{$lna[1090]}]</b><br>
<a href="admin.php?go=misc_urlrewritesave&urlrewritesta=2">{$lna[1091]}</a><br>
<a href="admin.php?go=misc_urlrewriteguide2">{$lna[1092]}</a><br>
</td></tr></table>
eot;
	}
}

if ($job=='urlrewriteguide2') {
	@include_once ("data/cache_latest.php");
	$testid=$cache_latest_all[0]['blogid'];
	$display_overall.=highlightadminitems('urlrewrite', 'misc');
	$display_overall.= <<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[529]}
</td>
<td class="sectend">{$lna[530]}</td>
<tr><td colspan=2 class='sect'>
{$lna[1093]}<br>
<b>[{$lna[939]}]</b><br>
<a href="read.php?{$testid}" target="_blank">{$lna[1088]}</a><br>
<a href="read.php/{$testid}.htm" target="_blank">{$lna[1089]}</a><br>
<br><br>
<b>[{$lna[1090]}]</b><br>
<a href="admin.php?go=misc_urlrewritesave&urlrewritesta=1">{$lna[1091]}</a><br>
<a href="admin.php?go=misc_urlrewritesave&urlrewritesta=0">{$lna[1092]}</a><br>
</td></tr></table>
eot;
}

if ($job=='urlrewritesave') {
	acceptrequest('urlrewritesta');
	$urlrewritesta=floor($urlrewritesta);
	if ($urlrewritesta==2) {
		$destinesmarturl=1;
		$destineurlrewrite=1;
	} elseif ($urlrewritesta==1) {
		$destinesmarturl=1;
		$destineurlrewrite=0;
	} else {
		$destinesmarturl=0;
		$destineurlrewrite=0;
	}
	$savetext="<?PHP\n\$db_server='{$db_server}';\n\$db_username='{$db_username}';\n\$db_password='{$db_password}';\n\$db_name='{$db_name}';\n\$db_prefix='{$db_prefix}';\n\$db_410='{$db_410}';\n\$db_tmpdir='{$db_tmpdir}';\n\$db_defaultsessdir='{$db_defaultsessdir}';\n";
	while (@list ($key, $val) = @each ($config)) {
		if ($key=='smarturl') {
			$savetext.="\$config['{$key}']='{$destinesmarturl}';\n";
			$saved1=1;
		}
		elseif ($key=='urlrewrite') {
			$savetext.="\$config['{$key}']='{$destineurlrewrite}';\n";
			$saved2=1;
		}
		else $savetext.="\$config['{$key}']='".admin_convert(stripslashes($val))."';\n";
	}
	if ($saved1!=1) $savetext.="\$config['smarturl']='{$destinesmarturl}';\n";
	if ($saved2!=1) $savetext.="\$config['urlrewrite']='{$destinesmarturl}';\n";
	if (writetofile ("data/config.php", $savetext)) {
		catchsuccess ($lna[1094], "{$lna[39]}|admin.php");
	} else {
		catcherror ($lna[66]."data/config.php");
	}
}
