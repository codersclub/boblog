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

//Define some senteces
$finishok=$lna[265];
$partbacktoart=$lna[266];
$backtoaddnew="{$lna[267]}|admin.php?go=edit_add";
$backtodraft="{$lna[325]}|admin.php?go=entry_draft";

if (!$job) $job='add';
$id=$itemid;

include_once ("data/cache_emot.php");
include_once ("data/weather.php");

//All Tags
$existtagall=trim(readfromfile("data/cache_tags.php"));
$exist_tags_all=@explode(' ',$existtagall);

if ($job=='add' || $job=='store') { //Permission check
	checkpermission('AddEntry');
	confirmpsw(); //Re-check password
} elseif ($job=='edit' || $job=='restore') {
	checkpermission('EditEntry');
	confirmpsw(); //Re-check password
} 

if ($job!='add' && $job!='store' && $job!='sendtb') {
	if ($id=="") $cancel=$lna[268];
	else {
		if ($permission['SeeHiddenEntry']!=1) {
			$partialquery="SELECT * FROM `{$db_prefix}blogs` WHERE `blogid`='{$id}'  AND `property`<>'2'";
		} else {
			$partialquery="SELECT * FROM `{$db_prefix}blogs` WHERE `blogid`='{$id}'";
		}
		$recordsa=$blog->getgroupbyquery($partialquery);
		$records=$recordsa[0];
		if ($records['blogid']=='') {
			$cancel=$lna[268];
		}
		$records['content']=safe_invert($records['content'], $records['htmlstat']);
		$records['content']=preg_replace("/\[php\](.+?)\[\/php\]/ise", "phpcode4('\\1')", $records['content']);
	}
}

if ($job=='edit' && $records['authorid']!=$userdetail['userid'] && $permission['EditSafeMode']!=1) {
	$cancel=$lna[268];
}

catcherror ($cancel);

if ($job=='add' || $job=='edit') { //Initialize public items
	acceptrequest('ignore,loaddraft');
	// Draft!
	if (is_file('data/draftsaved.php') && $ignore!=1) {
		$saved_draft=substr(readfromfile('data/draftsaved.php'), 13);
		@list($draftid, $drafttitle, $draftcontent)=@explode('||', $saved_draft);
		if ($job=='edit' && $draftid!=$id) {
			$jumptourl=(is_numeric($draftid)) ? "go=edit_edit_{$draftid}" : "go=edit_add";
		} else $jumptourl=$_SERVER['QUERY_STRING'];
		@header("Content-Type: text/html; charset=utf-8");
		$t=new template;
		$t->showtips($lna[926],"<font color=red>{$lna[927]}</font><br>",array("{$lna[928]}|admin.php?{$jumptourl}&ignore=1&loaddraft=1",  "{$lna[929]}|admin.php?".$_SERVER['QUERY_STRING']."&ignore=1"));
		exit();
	}

	$currentjob=basename($_SERVER['QUERY_STRING']);

	if(is_array($weather)) { //Get Weather List
		while (@list($wkey, $wvalue)=@each($weather)) {
			$arrayoption_weather[]=$wvalue['text'];
			$arrayvalue_weather[]=$wkey;
		}
	}
	$arrayoption_property=array($lna[269], $lna[270], $lna[271], $lna[272]);
	$arrayvalue_property=array(0, 1, 2, 3);
	$arrayoption_sticky=array($lna[273], $lna[274], $lna[275]);
	$arrayvalue_sticky=array(0, 1, 2);
	$usergp_1=array_values($usergp);
	$usergp_2=array_keys($usergp);
	$arrayoption_editors=array('QuickTags', $lna[568], $lna[1017], $lna[711]);
	$arrayvalue_editors=array('quicktags', 'ubb', 'tinymce', 'custom');

	$ismoreon='none';
	if ($permission['AddTag']==1) {
		$taglist="<b>{$lna[276]}</b>: &nbsp; ";
		$taglist_all="<b>{$lna[1066]}</b>: &nbsp; ";
		$exist_tags_tmp=$blog->getarraybyquery("SELECT * FROM `{$db_prefix}tags` ORDER BY `tagcounter` DESC LIMIT 20");
		$exist_tags=$exist_tags_tmp['tagname'];
		for ($i=0; $i<count($exist_tags); $i++) {
			$taglist.="<a href=\"javascript: inserttag('{$exist_tags[$i]}', 'tags');\">{$exist_tags[$i]}</a> &nbsp; ";
		}
		for ($i=0; $i<count($exist_tags_all); $i++) {
			$taglist_all.="<a href=\"javascript: inserttag('{$exist_tags_all[$i]}', 'tags');\">{$exist_tags_all[$i]}</a> &nbsp; ";
		}
		$tagdisable='';
	} else {
		$taglist=$lna[277];
		$tagdisable='disabled';
	}
}

if ($job=='edit') { //Initialize Edit only items
	$selectedid_weather=array_search($records['weather'], $arrayvalue_weather); //selected weather
	$selectedid_category=array_search($records['category'], $arrayvalue_categories); //selected category
	$selectedid_sticky=array_search($records['sticky'], $arrayvalue_sticky); //if pinned
	$records['content']=stripslashes($records['content']);
	$records['tags']=str_replace('>', ' ', trim($records['tags'],'>'));
	if ($permission['AddTag']!=1) $taglist.="<input type='hidden' name='tags' value='{$records['tags']}'>";
	if ($records['permitgp']!=='') {
		$allowedgp=@explode('|', $records['permitgp']);
		foreach ($usergp as $gpid=>$gpname) {
			if (@!in_array($gpid, $allowedgp)) $arraychecked_permitgp[]=1;
			else $arraychecked_permitgp[]=0;
		}
	}
	$editwarntime=$lna[278];
	$hiddenareas="<input type='hidden' name='go' id='go' value='edit_restore_{$records['blogid']}'/>";
	$hiddenareas.="<input type='hidden' name='idforsave' id='idforsave' value='{$records['blogid']}'/>";
	$hiddenareas.="<input type='hidden' name='oldgo' id='oldgo' value='{$currentjob}'/>";
	$resendping="<input type=checkbox name='resend' value=1>{$lna[279]}<br>";
	$records['pub_tmp']=gmdate('Y-n-j-H-i-s', $records['pubtime']+$config['timezone']*3600);
}

if ($job=='add') { //Initialize Add only items
	if ($permission['Html']==1) $records['htmlstat']=1;
	if ($permission['Ubb']==1) $records['ubbstat']=1;
	if ($permission['Emot']==1) $records['emotstat']=1;
	$hiddenareas="<input type='hidden' name='go' id='go' value='edit_store'/>";
	$hiddenareas.="<input type='hidden' name='idforsave' id='idforsave' value=''/>";
	$hiddenareas.="<input type='hidden' name='oldgo' id='oldgo' value='{$currentjob}'/>";
	$records['pub_tmp']=gmdate('Y-n-j-H-i-s', time()+$config['timezone']*3600);
}

if ($job=='add' || $job=='edit') { //Initialize public items
	@list($records['pub_year'], $records['pub_month'], $records['pub_day'], $records['pub_hour'], $records['pub_min'], $records['pub_sec'])=explode('-', $records['pub_tmp']);
	if ($permission['Html']==1) $disablehtmlstatus=0;
	else $disablehtmlstatus=1;
	if ($permission['Ubb']==1) $disableubbstatus=0;
	else $disableubbstatus=1;
	if ($permission['Emot']==1) $disableemotstatus=0;
	else $disableemotstatus=1;
	if ($permission['PinEntry']==1) $disabled_sticky=0;
	else $disabled_sticky=1;
	$puttingproperty=autoselect('property', $arrayoption_property, $arrayvalue_property, $records['property']);

	$selectedid_editors=array_search($useeditor, $arrayvalue_editors);
	$puttingeditors=autoselect('useeditor', $arrayoption_editors, $arrayvalue_editors, $selectedid_editors);

	$puttingcates=autoselect('category', $arrayoption_categories, $arrayvalue_categories, $selectedid_category);
	$puttingcates=str_replace('</select>', "<option value='new'>[+]{$lna[180]}</option></select>", $puttingcates);
	$puttingcates=str_replace('<select', "<select onchange=\"if (this.options[this.selectedIndex].value=='new') {document.getElementById('addnewcate').style.display='block';} else {document.getElementById('addnewcate').style.display='none';}\"  ", $puttingcates);
	for ($i=0; $i<sizeof($arrayvalue_categories); $i++) {
		$puttingcates_after.="<option value='{$arrayvalue_categories[$i]}'>{$lna[1025]} {$arrayoption_categories[$i]}</option>";
	}

	$puttingweather=autoselect('sweather', $arrayoption_weather, $arrayvalue_weather, $selectedid_weather);
	$puttingsticky=autoselect('sticky', $arrayoption_sticky, $arrayvalue_sticky, $selectedid_sticky);
	$puttinghtml=autoradio('checkbox', 'html', array($lna[280]), array(1), array($records['htmlstat']), array($disablehtmlstatus));
	$puttingubb=autoradio('checkbox', 'ubb', array($lna[281]), array(1), array($records['ubbstat']), array($disableubbstatus));
	$puttingemot=autoradio('checkbox', 'emot', array($lna[282]), array(1), array($records['emotstat']), array($disableemotstatus));
	$puttingpermitgp=autoradio ('checkbox', 'permitgp[]', $usergp_1, $usergp_2, $arraychecked_permitgp);
	$puttingstarred=autoradio ('checkbox', 'starred', array($lna[1020]), array(1), array($records['starred']%2));

	if ($loaddraft==1) {
		$saved_draft=substr(readfromfile('data/draftsaved.php'), 13);
		@list($draftid, $drafttitle, $draftcontent)=@explode('||', $saved_draft);
		$records['title']=base64_decode($drafttitle);
		$records['content']=base64_decode($draftcontent);
	}
	$editorbody=str_replace("{content}", $records['content'], $editorbody);

//Now Begins the main part
	$display_overall.=highlightadminitems('write', 'entry');
$display_overall.= <<<eot
<script type='text/javascript'>
function chktitle() {
	if (document.getElementById('title').value=='' || document.getElementById('title').value==null) {
		alert("{$lna[877]}");
	} else if (document.getElementById('category').options[document.getElementById('category').selectedIndex].value=='new') {
		alert("{$lna[1026]}");
	}
	else document.getElementById('realsubmit').click();
}
</script>
<form name='editentry' id='editentry' action='admin.php' method='post' enctype='multipart/form-data' 	{$submitjs}>{$hiddenareas}
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<td width=160 class="sectstart">
{$lna[22]}
</td>
<td class="sectend">{$lna[283]}</td>
</tr>
<tr>
<td colspan=2  class="sect">

<table width=98% cellpadding=4 cellspacing=1 align=center>
<tr bgcolor="#ffffff" align=left>
<td width=100 align=center>{$lna[567]}</td><td>{$puttingeditors} <input type=button value="{$lna[64]}" onclick="changeeditor();"></td></tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 align=center>{$lna[284]}</td><td><input type='text' name='title' id='title' value="{$records['title']}" size='50'  class='formtext'></td></tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 align=center valign=top>{$lna[285]}</td><td>
<div id='cateselarea'>{$puttingcates} {$lna[286]}

<div id='addnewcate' style='display: none;'>
<table width='95%' align=left>
<tr><td width=100>{$lna[182]}</td>
<td><input type="text" name="newcatename" id="newcatename" value="" size="30"></td></tr>
<tr><td width=100 valign=top>{$lna[183]}</td>
<td><textarea cols=30 rows=4 name="newcatedesc" id="newcatedesc"></textarea></td></tr>
<tr><td width=100>{$lna[187]}</td>
<td><select name="newcatemode" id="newcatemode"><option value="0">{$lna[188]}</option><option value="1">{$lna[189]}</option></select>
</td></tr>
<tr><td width=100>{$lna[184]}</td>
<td><select name="newcateproperty" id="newcateproperty"><option value="0">{$lna[185]}</option><option value="1">{$lna[186]}</option></select></td></tr>
<tr><td width=100>{$lna[1022]}</td><td><select name="targetcate" id="targetcate">
<option value='-1'>{$lna[1023]}</option><option value='-2' selected>{$lna[1024]}</option>
$puttingcates_after
</select></td></tr>
<tr><td colspan=2><input type=button value="{$lna[64]}" onclick="ajax_addcategory();"> <input type=button value="{$lna[138]}" onclick="showhidediv('addnewcate');">
</td></tr></table>
</div>
	
</div>
</td></tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 valign=top align=center>{$lna[287]}<br><div align=left>{$puttinghtml}<br>{$puttingubb}<br>{$puttingemot}<br>{$puttingstarred}</div>
</td>
<td>
$editorbody
</td>
</tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 valign=top align=center>{$lna[288]}</td>
<td><input type=checkbox id='changemytime' name='changemytime' value=1 onclick="timechanger();">{$lna[289]} $editwarntime
<div style="clear:both; display: none;" id="changetime">{$lna[290]} <input type='text' name='newyear' size='4' value="{$records['pub_year']}" maxlength='4'>{$lna[291]} - <input type='text' name='newmonth' size='2' value="{$records['pub_month']}" maxlength='2'>{$lna[292]} - <input type='text' name='newday' size='2' value="{$records['pub_day']}" maxlength='2'>{$lna[293]} -  <input type='text' name='newhour' size='2' value="{$records['pub_hour']}" maxlength='2'>{$lna[294]} -  <input type='text' name='newmin' size='2' value="{$records['pub_min']}" maxlength='2'>{$lna[295]}  -  <input type='text' name='newsec' size='2' value="{$records['pub_sec']}" maxlength='2'>{$lna[296]}</div>
</td>
</tr>

<tr bgcolor="#ffffff" align=left>
<td width=100 valign=top align=center>{$lna[297]}</td>
<td>
{$lna[298]} {$puttingproperty} ({$lna[299]})<br>
{$lna[300]} {$puttingsticky} <br>
{$lna[301]} {$puttingweather}
</td>
</tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 valign=top align=center>{$lna[302]}</td>
<td>{$lna[303]}<br>
{$puttingpermitgp}
</td>
</tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 valign=top align=center>Tags</td>
<td><textarea name='tags' id='tags' rows='2' cols='100' class='formtextarea' {$tagdisable}>{$records['tags']}</textarea>
<div id="tag_few">{$taglist} [<a href="javascript: showhidediv('tag_all');showhidediv('tag_few');">{$lna[1064]}</a>]</div><div id="tag_all" style='display:none;'>{$taglist_all} [<a href="javascript: showhidediv('tag_few');showhidediv('tag_all');">{$lna[1065]}</a>]</div>{$lna[304]} 
</td>
</tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 valign=top align=center>{$lna[305]}</td>
<td>{$resendping}<textarea name='pinged' id='pinged' rows='2' cols='100' class='formtextarea'>{$records['pinged']}</textarea><br>
{$lna[306]}
</td>
</tr>
<tr bgcolor="#ffffff" align=left>
<td width=100 align=center valign=top>{$lna[1080]}</td><td><input type='text' name='blogpsw' id='blogpsw' value="{$records['blogpsw']}" size='15' maxlength='18' class='formtext'> {$lna[1081]}</td></tr>

</table>

</td>
</tr>
<tr>
<td colspan=4 align=center class="sectbar">
<input type=button value="{$lna[64]}" onclick="chktitle();"> <input type=reset value="{$lna[65]}">
</td></tr>
</table>
<div style='visibility: hidden'><input type=submit value="{$lna[64]}" id='realsubmit'></div>
</form>
eot;
}

if ($job=='store' || $job=='restore') {
	acceptrequest('title,property,category,tags,sticky,html,ubb,emot,sweather,permitgp,pinged,changemytime,resend,autoping,starred,blogpsw,useeditor', 0, 'post');
	//Get content
	$content=$_POST['content'];
	//If magic quotes is on, strip the slashes automatically added
	if ($mqgpc_status==1) $content=stripslashes($content);

	if ($title=='' || $content=='')  {
		$cancel=$lna[307];
	}
	if ($job=='restore' && $records['authorid']!=$userdetail['userid'] && $permission['EditSafeMode']!=1) {
		$cancel=$lna[308];
	}
	if ($permission['PinEntry']!=1 && $sticky!=0) {
		$cancel=$lna[309];
	}

	catcherror ($cancel);

	$property=@floor($property);
	$category=@floor($category);
	$sticky=@floor($sticky);
	$htmlstat=@floor($html);
	$ubbstat=@floor($ubb);
	$emotstat=@floor($emot);
	$blogid=@floor($blogid);
	$starred=@floor($starred);

	if ($categories[$category]['cateproperty']==1) $property=2;

	if ($autobr==0) {
		$content=str_replace("\r",'',$content);  //Disable auto linebreak in WYSIWYG editors
	}
	if ($callaftersubmit) {
		$content=call_user_func ($callaftersubmit, $content);
	}

	$content=preg_replace("/\[php\](.+?)\[\/php\]/ise", "phpcode3('\\1')", $content);
	if ($htmlstat!=1 || $permission['Html']!=1) {
		$content=preg_replace("/\[code\](.+?)\[\/code\]/ise", "phpcode2('\\1')", $content);
		$content=safe_convert($content, 0, 1);
	} else {
		$content=preg_replace("/\[code\](.+?)\[\/code\]/ise", "phpcode('\\1')", $content);
		$content=safe_convert($content, 1, 1);
	}

	$title=safe_convert(stripslashes($title));

	if ($tags) {
		$tags_array=@explode(' ', mystrtolower(trim($tags)));
		$tags_array_all=array_unique($tags_array);
		$tags=@implode(' ', $tags_array_all);
		$tags=safe_convert($tags);
		$tags=str_replace('&nbsp;', '', $tags);
		$tags_array=@explode(' ', $tags);
		$tags='>'.str_replace(' ', '>', $tags).'>';
	} else $tags='';

	if ($pinged) $pinged=safe_convert($pinged);
	if (is_array($permitgp)) {
		$permitgp=array_diff(array_keys($usergp), $permitgp);
		$permitgp=array_values($permitgp);
		$permitgp=@implode('|', $permitgp);
	}

	$currenttime=time();
	$currentuserid=$userdetail['userid'];

	if ($changemytime==1) {
		acceptrequest('newyear,newmonth,newday,newhour,newmin,newsec');
		$finaltime=gmmktime($newhour,$newmin,$newsec,$newmonth,$newday,$newyear)-$config['timezone']*3600;
	} elseif ($job=='store') $finaltime=$currenttime;
	else $finaltime=$records['pubtime'];

	$content=plugin_walk('storecontent', $content); //load plugin

	if ($job=='store') {
		$currentid=$maxrecord['maxblogid']+1;
		$query="INSERT INTO `{$db_prefix}blogs` VALUES ('{$currentid}', '{$title}','{$finaltime}','{$currentuserid}', 0, 0, 0, '{$property}','{$category}','{$tags}','{$sticky}','{$htmlstat}', '{$ubbstat}', '{$emotstat}', '{$content}', '0', '0', '{$sweather}', '0', '{$pinged}', '{$permitgp}', '{$starred}', '{$blogpsw}', '0')";
	} else {
		$currentid=$itemid;
		if ($tags || $records['tags']!='') {
			$oldtags=@explode('>', trim($records['tags'],'>'));
			$oldtags_query="'".@implode("', '", $oldtags)."'";
			if ($oldtags_query!="''") $blog->query("UPDATE `{$db_prefix}tags` SET tagentry=replace(tagentry, ',{$currentid},', ','), tagcounter=tagcounter-1 WHERE tagname in({$oldtags_query})"); //Remove all records containing this entry
		}
		$query="UPDATE `{$db_prefix}blogs` SET title='{$title}', pubtime='{$finaltime}', property='{$property}', category='{$category}', tags='{$tags}', sticky='{$sticky}', htmlstat='{$htmlstat}', ubbstat='{$ubbstat}', emotstat='{$emotstat}', content='{$content}',  editorid='{$currentuserid}', edittime='{$currenttime}', weather='{$sweather}', pinged='{$pinged}', permitgp='{$permitgp}', starred='{$starred}', blogpsw='{$blogpsw}' WHERE `blogid`='{$id}'";
	}
	$blog->query($query);

	if ($tags || $records['tags']!='') {
		$newtags=@array_diff($tags_array_all, $exist_tags_all);
		$newtags=array_values($newtags); //Kill all keys
		$modifytags=@array_diff($tags_array_all, $newtags);
		$modifytags_query="'".@implode("', '", $modifytags)."'";
		$blog->query("UPDATE `{$db_prefix}tags` SET  tagentry=replace(tagentry, '<end>', '{$currentid},<end>'), tagcounter=tagcounter+1 WHERE tagname in({$modifytags_query})");
		for ($m=0; $m<count($newtags); $m++) {
			if ($newtags[$m]!=='') $blog->query("INSERT INTO `{$db_prefix}tags` VALUES ('{$currenttime}', '{$newtags[$m]}', 1, '<tag>,{$currentid},<end>', '')");
		}
	}
	@writetofile("data/cache_tags.php", trim($existtagall.' '.@implode(' ',$newtags))); //Update all tags cache

	if ($job=='store') {
		$blog->query("UPDATE `{$db_prefix}maxrec` SET maxblogid={$currentid}");
		$blog->query("UPDATE `{$db_prefix}counter` SET entries=entries+1");
		$newcym=gmdate("Ym", $finaltime+$config['timezone']*3600);
		$newcd=gmdate("d", $finaltime+$config['timezone']*3600);
		$blog->query("INSERT INTO `{$db_prefix}calendar` VALUES ('{$newcym}', '{$newcd}', '{$currentid}', '')");
		recache_currentmonthentries();
	}
	if ($job=='restore' && $changemytime==1) {
		$newcym=gmdate("Ym", $finaltime+$config['timezone']*3600);
		$newcd=gmdate("d", $finaltime+$config['timezone']*3600);
		$blog->query("UPDATE `{$db_prefix}calendar` SET cyearmonth='{$newcym}', cday='{$newcd}' WHERE `cid`='{$id}'");
		recache_currentmonthentries();
	}
	recache_latestentries (); //Update Latest Entry Cache
	recache_categories(); //Update Category counter
	
	if ($job=='restore' && $property!=$records['property']) recache_latestreplies();

	//if ($autoping==1) technorati();

	//Clear unsaved draft now
	@unlink('data/draftsaved.php');


	$backtowhere=($property==3) ? $backtodraft : $partbacktoart;
	if (($job=='store' && !$pinged) || ($job=='restore' && $resend!=1) || ($job=='restore' && !$pinged)) {
		catchsuccess ($finishok, array("{$backtowhere}|{$config['sulink']}{$currentid}{$config['sulinkext']}", $backtoaddnew));
	}
	else {
		if ($htmlstat==1) $excerpt=tb_convert($content);
		else $excerpt=tb_no_quote($content);
		$ping_show=@explode(' ', $pinged);
		for ($i=0; $i<count($ping_show); $i++) {
			$ping_urls.="<input type='hidden' name='pingurl[]' value='{$ping_show[$i]}'>";
		}
		$ping_url_show=@implode('<br>', $ping_show);
		$form="<div align=center><form action='admin.php?go=edit_sendtb' method='post'><input type='hidden' name='title' value=\"{$title}\"><input type='hidden' name='excerpt' value=\"{$excerpt}\"><input type='hidden' name='blog_name' value=\"{$config['blogname']}\"><input type='hidden' name='url' value='{$config['blogurl']}/{$config['sulink']}{$currentid}{$config['sulinkext']}'>{$ping_urls}<input type='submit' value='{$lna[310]}'> <input type='button' value='{$lna[311]}' onclick='window.location=(\"{$config['sulink']}{$currentid}{$config['sulinkext']}\");'></form></div>";
		$t=new template;
		$t->showtips($lna[312],$lna[313].$ping_url_show."<br><br>{$lna[314]}<br><br>".$form, "{$backtowhere}|{$config['sulink']}{$currentid}{$config['sulinkext']}");
	}
}


if ($job=='sendtb') {
	checkpermission('EditEntry');
	acceptrequest('title,excerpt,url,blog_name,pingurl');
	if (!is_array($pingurl)) catcherror($lna[315]);
	@header("Content-Type: text/html; charset=utf-8");
	foreach ($pingurl as $durl) {
		$result=sendping ($durl, $title, $excerpt, $url, $blog_name);
		if (!$result) $showp.="<b>{$lna[316]}</b>{$durl} ; <b>{$lna[317]}</b>{$lna[318]}";
		elseif ($result=='ok') $showp.="<b>{$lna[316]}</b>{$durl} ; <b>{$lna[317]}</b>{$lna[319]}<br>";
		elseif ($result=='unknown')  $showp.="<b>{$lna[316]}</b>{$durl} ; <b>{$lna[317]}</b>{$lna[949]}<br>";
		else  $showp.="<b>{$lna[316]}</b>{$durl} ; <br><b>{$lna[317]}</b>{$lna[950]}{$result}<br>";
	}
	$t=new template;
	$t->showtips("{$lna[320]}","{$lna[321]}<br><br>".$showp."<br><br>{$lna[322]}","{$partbacktoart}|{$url}");
}

function autoselect ($name, $arrayoption, $arrayvalue, $selectedid=0, $disabled=0) {
	if (empty($selectedid)) $selectedid=0;
	if ($disabled==1) $wdisabled=" disabled='disabled' ";
	$formcontent.="<select name='{$name}' id='{$name}' class='formselect' {$wdisabled}>";
	for ($i=0; $i<count($arrayoption); $i++) {
		if ($selectedid==$i) $wselected="selected='selected'";
		else $wselected='';
		$formcontent.="<option value='{$arrayvalue[$i]}' {$wselected}>{$arrayoption[$i]}</option>";
	}
	$formcontent.="</select>";
	return $formcontent;
}

function autoradio ($type, $name, $arraylabel, $arrayvalue, $arraychecked=array(), $arraydisabled=array()) {
	if ($type!='checkbox' && $type!='radio') return;
	for ($i=0; $i<count($arraylabel); $i++) {
		if ($arraychecked[$i]==1) $addcheck="checked='checked'";
		else $addcheck='';
		if ($arraydisabled[$i]==1) $disabled="disabled='disabled'";
		else $disabled='';
		$formcontent.="<label><input type='{$type}' name='{$name}' value='{$arrayvalue[$i]}' {$addcheck} class='formradiobox' {$disabled}/>{$arraylabel[$i]}</label> ";
	}
	return $formcontent;
}

function sendping ($url, $title, $excerpt, $blog_url, $blog_name) {
	$trackback_url=parse_url($url);
	$out="POST {$trackback_url['path']}".($trackback_url['query'] ? '?'.$trackback_url['query'] : '')." HTTP/1.0\r\n";
	$out.="Host: {$trackback_url['host']}\r\n";
	$out.="Content-Type: application/x-www-form-urlencoded; charset=utf-8\r\n";
	$query_string="nouse=nouse&title=".urlencode($title)."&url=".urlencode($blog_url)."&blog_name=".urlencode($blog_name)."&excerpt=".urlencode($excerpt);
	$out.='Content-Length: '.strlen($query_string)."\r\n";
	$out.="User-Agent: Bo-Blog\r\n\r\n";
	$out.=$query_string;
	if ($trackback_url['port']=='') $trackback_url['port']=80;
	$fs=fsockopen($trackback_url['host'], $trackback_url['port'], $errno, $errstr, 10);
	if (!$fs) return false;
	fputs($fs, $out);
	$http_response = '';
	while(!feof($fs)) {
		$http_response .= fgets($fs, 128);
	}
	@fclose($fs);
	@list($http_headers, $http_content) = @explode("\r\n\r\n", $http_response);
	if (strstr($http_content, "<error>0</error>")) return ("ok");
	elseif (preg_match("/<message>(.+?)<\/message>/is", $http_content, $messages)==1) {
		return (htmlspecialchars($messages[1]));
	}
	//writetofile("data/trackbacklog.txt", $http_content);
	else return (htmlspecialchars($http_content));
}

/*function technorati () {
	global $config;
	$query_string="<?xml version=\"1.0\"?>";
	$query_string.=<<<eot
<methodCall>
  <methodName>weblogUpdates.ping</methodName>
  <params>
    <param>
      <value>{$config['blogname']}</value>
    </param>
    <param>
      <value>{$config['blogurl']}/</value>
    </param>
  </params>
</methodCall>
eot;
	$out.='POST /rpc/ping HTTP/1.0'."\r\n";
	$out.="User-Agent: Bo-Blog\r\n\r\n";
	$out.="Host: rpc.technorati.com\r\n";
	$out.="Content-Type: text/xml\r\n";
	$out.="Content-length: ".strlen($query_string)."\r\n\r\n";
	$out.=$query_string;
	$fs=fsockopen("rpc.technorati.com/rpc/ping", 80, $errno, $errstr, 10);
	if (!$fs) return false;
	fputs($fs, $out);
	@fclose($fs);
	return true;
}
*/
function tb_convert ($str) {
	$str=tb_no_quote(strip_tags($str));
	$str=preg_replace("/&(.+?);/is", "", $str);
	$str=preg_replace("/\[(.+?)\]/is", "", $str);
	return $str;
}

function tb_no_quote($str) {
	$str=str_replace("'", '', $str);
	$str=str_replace("\"", '', $str);
	$str=str_replace("\\", '', $str);
	return $str;
}

?>