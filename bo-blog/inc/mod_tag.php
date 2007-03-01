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

if (!defined('VALIDREQUEST')) die ('Access Denied.');

if (!$job) $job='default';
else $job=basename($job);
$itemid=safe_convert($itemid);

acceptrequest('tag,rewrite');
if ($tag!=='') $job='show';
$tag=($config['smarturl']==1 && $config['urlrewrite']==1 && $rewrite==1) ? tagurldecode($tag) : $tag;

if ($job=='default') {
	$sequence=($mbcon['tagorder']=='1') ? 'tagcounter' : 'tagid';
	$alltags=$blog->getarraybyquery("SELECT tagid,tagname,tagcounter FROM `{$db_prefix}tags` ORDER BY {$sequence} DESC");
	$maxtagcounter=$blog->countbyquery("SELECT MAX(tagcounter) FROM `{$db_prefix}tags`");
	for ($i=0; $i<count($alltags['tagid']); $i++) {
		$bit_tag_size=get_tag_size($alltags['tagcounter'][$i], $maxtagcounter);
		if ($mbcon['tagunderlinetospace']==1) $eachtag=str_replace('_', ' ', $alltags['tagname'][$i]);
		else $eachtag=$alltags['tagname'][$i];
		$urlref="tag.php?tag=".urlencode($alltags['tagname'][$i]);
		$tag_show[]="<a href=\"{$urlref}\" title=\"{$lnc[188]}{$alltags['tagcounter'][$i]}\"><span style=\"font-size: {$bit_tag_size}px;\">{$eachtag}</span></a>";
	}
	if (is_array($tag_show)) {
		if ($mbcon['tagorder']=='0') shuffle($tag_show);
		$tagshow=@implode(" &nbsp; ", $tag_show);
	}
	else $tagshow="{$lnc[189]}";
	$t=new template;
	$section_tag=$t->set('taglist', array('tagcategory'=>$lnc[190], 'tagcontent'=>$tagshow, 'tagextra'=>"<div align='right'>{$lnc[191]}</div>"));
	$section_body_main=$t->set('contentpage', array('title'=>'Tags', 'contentbody'=>$section_tag));
	announcebar();
	$bodymenu=$t->set('mainpage', array('pagebar'=>'', 'iftoppage'=>'none', 'ifbottompage'=>'none', 'ifannouncement'=>$ifannouncement, 'topannounce'=>$topannounce, 'mainpart'=>$section_body_main, 'currentpage'=>'', 'previouspageurl'=>'', 'nextpageurl'=>'', 'turningpages'=>'', 'totalpages'=>'', 'previouspageexists'=>'', 'nextpageexists'=>''));
}

if ($job=='show') {
	acceptrequest('mode');
	if ($mode==1 || $mode==2) $mbcon['tag_list']=$mode-1;

	$m_b=new getblogs;
	if ($tag==='') catcherror($lnc[192]);
	$allentries=$blog->getgroupbyquery("SELECT * FROM `{$db_prefix}tags` WHERE `tagname`='{$tag}' LIMIT 0,1");
	if (!is_array($allentries[0]) || $allentries[0]['tagentry']=='<end>' || $allentries[0]['tagcounter']==0) {
		$section_body_main[]="<br/><div align='center'><span style='font-size: 14px;'>{$lnc[186]}</span></div><br/>";
	} else {
		$taginfo=$allentries[0];
		$entries_query=str_replace(',<end>', '', $taginfo['tagentry']);
		$entries_query=str_replace('<tag>,', '', $entries_query);
		$partialquery="WHERE `blogid` IN ({$entries_query}) AND `property`<>'2' AND `property`<>'3' ORDER BY  `sticky` DESC, `pubtime` DESC";
		if ($mbcon['tag_list']==1) {
			$records=$m_b->new_record_array($partialquery, $mbcon['listitemperpage'], $page);
			$listbody=$m_b->make_excerption($records, 'list');
			$section_body_main[]=$m_b->make_list(@implode('', $listbody));
			$perpagevalue=$mbcon['listitemperpage'];
		} else {
			$records=$m_b->new_record_array($partialquery, $mbcon['exceptperpage'], $page);
			$section_body_main=$m_b->make_excerption($records);
			$perpagevalue=$mbcon['exceptperpage'];
		}
		$counter_now=$blog->countbyquery("SELECT COUNT(blogid) FROM `{$db_prefix}blogs` WHERE `blogid` IN ({$entries_query}) AND `property`<>'2' AND `property`<>'3'");
		$urlref="tag.php?tag=".urlencode($tag)."&amp;mode={$mode}";
		$pagebar=$m_b->make_pagebar($page, $mbcon['pagebaritems'], $urlref, $counter_now, $perpagevalue);
		$pagebar.=" [ {$lnc[181]} <a href=\"{$urlref}&amp;mode=1\" title=\"{$lnc[182]}\">{$lnc[183]}</a> | <a href=\"{$urlref}&amp;mode=2\" title=\"{$lnc[184]}\">{$lnc[185]}</a> ]";
	}
	$iftoppage=($mbcon['pagebarposition']=='down') ? 'none' : 'block';
	$ifbottompage=($mbcon['pagebarposition']=='up') ? 'none' : 'block';

	if ($mbcon['tagunderlinetospace']==1) 	$allentries[0]['tagname']=str_replace('_', ' ', $allentries[0]['tagname']);
	if ($mbcon['tag_list']==1) $mainbody=$t->set('contentpage', array('title'=>"Tags：{$allentries[0]['tagname']}",  'contentbody'=>@implode('', $section_body_main)));
	else $mainbody=@implode('', $section_body_main);

	announcebar();
	$bodymenu=$t->set('mainpage', array('pagebar'=>$pagebar, 'iftoppage'=>$iftoppage, 'ifbottompage'=>$ifbottompage, 'ifannouncement'=>$ifannouncement, 'topannounce'=>$topannounce, 'mainpart'=>$mainbody, 'currentpage'=>$pageitems['currentpage'], 'previouspageurl'=>$pageitems['previouspageurl'], 'nextpageurl'=>$pageitems['nextpageurl'], 'turningpages'=>$pageitems['turningpages'], 'totalpages'=>$pageitems['totalpages'], 'previouspageexists'=>'', 'nextpageexists'=>''));
}
