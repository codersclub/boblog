<?PHP
$elements['header']=<<<eot
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{language}">
<head>
<!--//votmeta http-equiv="Content-Type" content="text/html; charset=UTF-8" /-->
<!--//votmeta http-equiv="Content-Language" content="UTF-8" /-->
<meta http-equiv="Content-Type" content="text/html; charset={charset}" />
<meta http-equiv="Content-Language" content="{languagename}" />
<meta content="all" name="robots" />
<meta name="author" content="{blogname}" />
<meta name="description" content="{blogdesc}" />
<meta name="keywords" content="{blogkeywords}" />
{baseurl}
<script type="text/javascript" src="template/YeYo-Skin06/js/dfFlexiGrid_inc.js"></script>
<script type="text/javascript" src="template/YeYo-Skin06/js/dfFlexiGrid.js"></script>
<link rel="alternate" title="{blogname}" href="feed.php" type="application/rss+xml" />
{csslocation}
<title>{pagetitle}{blogname} - {blogdesc}</title>
<script type="text/javascript" src="images/js/common.js?jsver={codeversion}"></script>
{ajax_js}
{extraheader}
</head>
<body id="{pageID}" onload="mygrid=new dfGrid('wrapper','left_column','right_column');">
eot;

$elements['displayheader']=<<<eot
<div id="wrapper">
	<div class="Search">
		<form method="post" action="visit.php">
			<input name="job" type="hidden" value="search"/>
			<input name="searchmethod" type="hidden" value="2"/>
			<input name="keyword" type="text" id="search-text" alt="搜索" class="keyword" value="搜索..." onblur="if(this.value=='') this.value='搜索...';" onfocus="if(this.value=='搜索...') this.value='';" title="输入关键词后回车"/>
		</form>
	</div>
	<div id="header">
		<div id="innerHeader">
			<div class="blog-header">
				<div class="blog-title"><a href="./"><img src="{$template['images']}/logo.gif" width="165" height="45" border="0" title="{blogname} - {$lnc[88]}" alt="{blogname} - {$lnc[88]}"/></a></div>
				<div class="blog-desc">{blogdesc}</div>
			</div>
		</div>
	</div>
	<div id="menu">
		<ul>{section_head_components}</ul>
	</div>
	<div class="blockdivider">
		<div id="block1">
			<div id="top-ads">
				<span class="top-ads-left"></span>
				<div class="topAds"><div id="ads"><center><font color="#666666" size="4"><strong>内容正在载入中，请稍后……</strong></font></center></div></div>
				<span class="top-ads-right"></span>
			</div>
		</div>
	</div>
eot;

$elements['mainpage']=<<<eot
	<div id="mainWrapper">
		<div id="left_column">
			<div class="sidebarOne">
				<!--global:{section_side_components_one}-->
			</div>
		</div>
		<div id="right_column">
			<div class="sidebarTwo">
				<!--global:{section_side_components_two}-->
			</div>
		</div>
		<div id="wrap">
			<div id="page-header">
				<span class="side-left"></span>
				<div id="page-header-inner">
					<div id="tools">
						<a href="#" onclick="mygrid.toggleBlock('block1');"><img src="{$template['images']}/close_top_ads.gif" alt="关闭横幅广告" title="关闭横幅广告" border="0"/></a> 
						<a href="#" onclick="mygrid.toggleLeft();"><img src="{$template['images']}/close_left_sidebar.gif" alt="关闭左侧栏" title="关闭左侧栏" border="0"/></a> 
						<a href="#" onclick="mygrid.toggleRight();"><img src="{$template['images']}/close_right_sidebar.gif" alt="关闭右侧栏" title="关闭右侧栏" border="0"/></a> 
						<a href="#" onclick="mygrid.resize(860,'px');"><img src="{$template['images']}/small_screen.gif" alt="窄屏幕" title="窄屏幕" border="0"/></a> 
						<a href="#" onclick="mygrid.resize(980,'px');"><img src="{$template['images']}/default_screen.gif" alt="默认屏幕" title="默认屏幕" border="0"/></a> 
						<a href="#" onclick="mygrid.resize(1236,'px');"><img src="{$template['images']}/wide_screen.gif" alt="宽屏幕" title="宽屏幕" border="0"/></a> 
						<a href="#" onclick="mygrid.resize(99,'%');"><img src="{$template['images']}/full_screen.gif" alt="自适应屏幕" title="自适应屏幕" border="0"/></a> 
						<a href="#" onclick="mygrid.resizeFont(0.05);"><img src="{$template['images']}/increase_size.gif" alt="增加字号" title="增加字号" border="0"/></a> 
						<a href="#" onclick="mygrid.resizeFont(-0.05);"><img src="{$template['images']}/reduction_size.gif" alt="减小字号" title="减小字号" border="0"/></a> 
						<!--global:{block_music}--> 
						<a href="feed.php"><img src="{$template['images']}/top_rss.gif" alt="订阅RSS" title="订阅RSS" border="0"/></a>
					</div>
				</div>
				<span class="side-right"></span>
			</div>
			<div id="content">
				<div id="innerContent">
					<div class="announce" style="display: {ifannouncement}">
						<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
						<div class="announce-content">{topannounce}</div>
						<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
					</div>
					<div class="article-top" style="display: {iftoppage}">
						<div class="pages">{pagebar}</div>
					</div>
					{mainpart}
					<div class="article-bottom" style="display: {ifbottompage}">
						<div class="pages">{pagebar}</div>
					</div>
				</div>
			</div>
			<div id="page-footer">
				<span class="fcorners-bottom">
					<span class="fcorners-bottom span"></span>
				</span>
			</div>
		</div>
eot;

$elements['otherpage']=<<<eot
		<div id="mainWrapper">
			<div id="content">
				<div id="innerContent">
					<div class="formbox">
						{mainpart}
					</div>
				</div>
			</div>
eot;

$elements['displayfooter']=<<<eot
	</div>
</div>
	<div id="footer">
		<div id="span_ads" style="display:none;"><!--global:{block_topads}--></div>
		<script type="text/javascript">
			document.getElementById("ads").innerHTML = document.getElementById("span_ads").innerHTML;
			document.getElementById("span_ads").innerHTML = "";
		</script>
		<div id="innerFooter">
			<div id="skin">
				Copyright © 2008 <!--global:{blogname}-->. All Rights Reserved. YeYo-Skin06 Skin Design by <a href="http://blog.nzye.com">YeYo</a>
			</div>
			<div id="w3c">
				<a href="feed.php"><img src="{$template['images']}/but-rss.gif" width="29" height="14" border="0" alt="feed" /></a>　
				<a href="http://jigsaw.w3.org/css-validator/"><img src="{$template['images']}/css.gif" width="29" height="14" border="0" alt="Valid CSS!" /></a>　
				<a href="http://validator.w3.org/check?uri=referer"><img src="{$template['images']}/xhtml10.gif" width="47" height="14" border="0" alt="Valid XHTML 1.0 Transitional" /></a>
			</div>
			{section_foot_components}
			<div id="processtime"></div>
		</div>
	</div>
eot;

$elements['footer']=<<<eot
</body>
</html>
eot;

$elements['displayall']=<<<eot
{headerhtml}
{headmenu}
{bodymenu}
{sidemenu}
{footmenu}
{footerhtml}
eot;

$elements['msgbox']=<<<eot
<div class="tips">{$lnc['tips']}:<br/>{message}</div>
eot;

$elements['sideblock']=<<<eot
<div class="panel">
	<h5 onclick='showhidediv("sidebar_{id}");'>{title}</h5>
	<div class="panel-content" id="sidebar_{id}" style="display: {ifextend}">
		{content}
	</div>
	<div class="panel-bot"></div>
</div>
eot;

$elements['sideblock_topads']='';
$elements['sideblock_music']='';

$elements['excerpt']=<<<eot
<div class="textbox">
	<div class="textbox-calendar">
		<span class="textbox-calendar-day">{entrydated}</span>
		<span class="textbox-calendar-month">{entrydatemnameshort}.{entrydatey}</span>
	</div>
	<div class="textbox-title">
		<h4>{entrytitle} {entrystar} {entryicon} </h4>
		<div class="textbox-label">
			{$lnc[238]}: {entryauthor} &nbsp;&nbsp;{$lnc[96]}：{entrycate} &nbsp;&nbsp;{$lnc[72]}{entrysourcewithlink} &nbsp;&nbsp;{adminlink}
		</div>
	</div>
	{adminbar}
	<div class="textbox-content">{entrycontent}</div>
	<div class="textbox-bottom">
		{$lnc[73]}{entrytime}　{entrycomment}　{entrytb}　{entryviews}　{tags}{alltags}
	</div>
	{tbbar}
</div>
eot;

$elements['excerptontop']=<<<eot
<div class="textbox">
	<div class="textbox-calendar">
		<span class="textbox-calendar-day">{entrydated}</span>
		<span class="textbox-calendar-month">{entrydatemnameshort}.{entrydatey}</span>
	</div>
	<div class="textbox-title">
		<h4>
			[{$lnc[33]}] <a href="javascript: showhidediv('{topid}');">{entrytitletext}</a> {entrystar} {entryicon}
		</h4>
		<div class="textbox-label">
			{$lnc[238]}: {entryauthor} &nbsp;&nbsp;{$lnc[96]}：{entrycate} &nbsp;&nbsp;{$lnc[72]}{entrysourcewithlink} &nbsp;&nbsp;{adminlink}
		</div>
	</div>
	{adminbar}
	<div id="{topid}" style="display: none;">
		<div class="textbox-content">
			{entrycontent}
		</div>
	<div class="textbox-bottom">
		{$lnc[73]}{entrytime}　{entrycomment}　{entrytb}　{entryviews}　{tags}{alltags}
	</div>
	{tbbar}
	</div>
</div>
eot;

$elements['viewentry']=<<<eot
<div class="article-top">
	<div class="prev-article">{previous}</div>
	<div class="next-article">{next}</div>
</div>
<div class="textbox">
	<div class="textbox-calendar">
		<span class="textbox-calendar-day">{entrydated}</span>
		<span class="textbox-calendar-month">{entrydatemnameshort}.{entrydatey}</span>
	</div>
	<div class="textbox-title">
		<h4>{entrytitle} {entrystar} {entryicon} </h4>
		<div class="textbox-label">
			{$lnc[238]}: {entryauthor} &nbsp;&nbsp;{$lnc[96]}：{entrycate} &nbsp;&nbsp;{$lnc[72]}{entrysourcewithlink} &nbsp;&nbsp;{adminlink}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{toolbar}
		</div>
	</div>
	{adminbar}
	<div class="textbox-content" id="zoomtext">
	 	{entrycontent} {ifedited}
	</div>
	<div class="textbox-bottom">
		{$lnc[73]}{entrytime}　{entrycomment}　{entrytb}　{entryviews}　{tags}{alltags}
	</div>
	{tbbar}
</div>
<div id="commentWrapper" class="comment-wrapper">
	<a name="topreply"></a>
	<div id="addnew"></div>
eot;


$elements['list']=<<<eot
	<tr>
		<td class="listbox-entry">
			[{entrycate}] {entrytitle}
		</td>
		<td class="listbox-entry" style="word-break: normal;" align="center">{entryauthor}</td>
		<td class="listbox-entry" width="70" align="center">{entrydate}</td>
	</tr>
eot;

$elements['listbody']=<<<eot
<div class="listbox">
	<div class="listbox-table">
		<table cellpadding="2" cellspacing="0" width="100%">
			<tr>
				<td class="listbox-header">{$lnc[237]}</td>
				<td class="listbox-header" style="word-break: normal;">{$lnc[238]}</td>
				<td class="listbox-header">{$lnc[239]}</td>
			</tr>
			{listbody}
		</table>
	</div>
</div>
eot;

$elements['comment']=<<<eot
	<div class="commentbox commentbox-{oddorcouplecss}">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
		<div class="commentbox-title">
			{replier} {replieremail} {replierhomepage} {replierip}
			<div class="commentbox-label">{replytime} {addadminreply} {deladminreply} {delreply} {blockreply}</div>
		</div>
		<div class="commentbox-content">
			{replycontent}
			<div class="quote" style="display: {ifadminreplied}"  id="replied_{commentid}">
				<div class="quote-title">{adminrepliershow}</div>
				<div class="quote-content">{adminreplycontent}</div>
			</div>
		</div>
		<div id="{commentid}" style="display: none">{adminreplybody}</div>
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>
eot;

$elements['trackback']=<<<eot
	<div class="trackbackbox">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
		<div class="trackbackbox-title">
		 {tbtitle} 
			<div class="trackbackbox-label">
			[{tbtime}] {delreply}
			</div>
		</div>
		<div class="trackbackbox-content">
		 {$lnc[240]}<a href="{tburl}" target="_blank">{tbblogname}</a><br/>
		 {$lnc[76]}{tbcontent}
		</div>
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>
eot;

$elements['form_reply']=<<<eot
	<a name="reply"></a>
	<div id="commentForm">
		<b class="rtop"><b class="r1"></b><b class="r2"></b><b class="r3"></b><b class="r4"></b></b>
		<form name="visitorinput" id="visitorinput" method="post" action="javascript: ajax_submit('{jobnow}');">
			<div class="formbox-comment">
				<div class="formbox-comment-title">{formtitle}</div>
				<div class="formbox-comment-input">
					{if_neednopsw_begin}
					<input name="v_replier" id="v_replier" type="text" size="30" class="text" value="{replier}" {disable_replier}/>&nbsp; {$lnc[246]} {additional}
					<br />
					<input name="v_password" id="v_password" type="password" size="30" class="text"  value="{password}" {disable_password}/>&nbsp; {$lnc[133]} ({$lnc[247]})
					<br />
					<input name="v_repurl" id="v_repurl" type="text" size="30" class="text" value="{repurl}" />&nbsp; {$lnc[170]}
					<br />
					<input name="v_repemail" id="v_repemail" type="text" size="30" class="text"  value="{repemail}" />&nbsp; {$lnc[248]} 
					{if_neednopsw_end}
					{if_openid_begin}
					<div id="commentbox-openid" style="display: none;">
						<input name="openid_url" id="openid_url" type="text" size="28" class="text" value="{repopenurl}" {disable_openurl}/>&nbsp; {$lnc[314]}
					</div>
        			{if_openid_end}
				</div>
				<div class="formbox-comment-tool">
					<div id="choose-options-panel">
						<a onclick="showhidediv('commentbox-openid')" style="cursor:hand;cursor:pointer;"><img src="{$template['images']}/openid.png" alt="OpenID登入" title="OpenID登入" border="0"/></a>
						<a onclick="showhidediv('set')" style="cursor:hand;cursor:pointer;"><img src="{$template['images']}/options.png" alt="权限选项" title="{$lnc[242]}, {$lnc[243]}, {$lnc[38]}{$lnc[245]}, {$lnc[284]}" border="0"/></a>
						<a onclick="showhidediv('emots')" style="cursor:hand;cursor:pointer;"><img src="{$template['images']}/emots.png" alt="{$lnc[241]}" title="{$lnc[244]}" border="0"/></a>
					</div>
					<div id="set" class="choose-options" style="display: none;">
						<div class="choose-options-content">
							<input name="stat_html" id="stat_html" type="checkbox" value="1" style="background-color: #eee" {disable_html} /> {$lnc[242]}
							<input name="stat_ubb" id="stat_ubb" type="checkbox" value="1" style="background-color: #eee" {disable_ubb} /> {$lnc[243]}
							<input name="stat_emot" id="stat_emot" type="checkbox" value="1" style="background-color: #eee" {disable_emot} /> {$lnc[244]}
							<input name="stat_property" id="stat_property" type="checkbox" value="1" onclick="promptreppsw();" style="background-color: #eee"/> {$lnc[38]}{$lnc[245]}
							{if_neednopsw_begin}
							<input name="stat_rememberme" id="stat_rememberme" type="checkbox" value="1" {checked_rememberme} onclick="quickremember();" style="background-color: #eee"/>  {$lnc[284]} {if_neednopsw_rawend}
						</div>
					</div>
					<div id="emots" class="choose-options" style="display: none;">
						<div class="choose-options-content">
							{emots}
						</div>
					</div>
					<div id="ubb">{ubbcode}</div>
			    </div>
				{if_securitycode_begin}<script type="text/javascript">securitycodejs="{$lnc[249]} <span id='securityimagearea'><img src='inc/securitycode.php?rand={rand}' alt='' title='{$lnc[250]}'/></span> <input name='v_security' id='v_security' type='text' size='4' maxlength='4' class='text' /> {$lnc[251]}   [<a href=\"javascript: refreshsecuritycode('securityimagearea', 'v_security');\">{$lnc[283]}</a>]";</script>  {if_securitycode_end}
				<textarea name="v_content" id="v_content" cols="70" rows="10" onkeydown="ctrlenterkey(event);" onfocus="if (securitycodejs!=null) {document.getElementById('showsecuritycode').innerHTML=securitycodejs; securitycodejs=null;}"></textarea><br />	<span id="showsecuritycode"></span>
				<div style="padding-top:10px">
					{hidden_areas}
					<input type="button" name="btnSubmit" id="btnSubmit" value="{$lnc[25]}" class="button" onclick="ajax_submit('{jobnow}'); return false;"/>&nbsp;
					<input name="reset" id="reset" type="reset" value="{$lnc[252]}" class="button" />
				</div>
			</div>
		</form>
		<b class="rbottom"><b class="r4"></b><b class="r3"></b><b class="r2"></b><b class="r1"></b></b>
	</div>
eot;

$elements['endviewentry']=<<<eot
	<div class="comment-pages">
	{innerpages}
	</div>
</div>
{form_reply}
eot;

$elements['entryadditional']=<<<eot
<div style="margin-top: 9px;">
<img src="{$template['images']}/readmore.gif" alt=""/>{readmore}
</div>
eot;

$elements['login']=<<<eot
<form name="register" method="post" action="login.php?job=verify">
<table cellspacing="1" width="500" align="center" class="formbox">
  <tr><td class="formbox-title" colspan="2">{$lnc[253]} [<a href="login.php?job=register">{$lnc[254]}</a>]</td></tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[132]}</td>
    <td class="formbox-content"><input name="username" type="text" id="username" size="24" class="text" />
  </tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[133]}</td>
    <td class="formbox-content"><input name="password" type="password" id="password" size="16" class="text" />
  </tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[255]}</td>
    <td class="formbox-content"><input name="savecookie" type="radio" id="savecookie" value="0"/>{$lnc[256]} <input name="savecookie" type="radio" id="savecookie" value="3600"/>{$lnc[257]} <input name="savecookie" type="radio" id="savecookie" value="86400"/>{$lnc[258]}  <input name="savecookie" type="radio" id="savecookie" value="604800"/>{$lnc[259]}  <input name="savecookie" type="radio" id="savecookie" value="2592000"/>{$lnc[260]}   <input name="savecookie" type="radio" id="savecookie" value="31104000"/>{$lnc[261]}   
  </tr>
  {lvstart}
  <tr>
    <td class="formbox-rowheader">{$lnc[249]}</td>
    <td class="formbox-content"><span id='securityimagearea'><img src="inc/securitycode.php?rand={rand}" alt="" title="{$lnc[250]}"/></span> <input name="securitycode" type="text" id="securitycode" size="16" class="text" /> {$lnc[251]}  [<a href="javascript: refreshsecuritycode('securityimagearea', 'securitycode');">{$lnc[283]}</a>]
  </tr>
  {lvend}
  <tr>
    <td class="formbox-content"></td>
    <td class="formbox-content">
    <input name="Submit" type="submit" id="Submit" value="{$lnc[25]}" class="button" /> &nbsp;
    <input name="Reset" type="reset" id="Reset" value="{$lnc[252]}" class="button" />
    </td>
  </tr>
</table>
</form>
eot;

$elements['contentpage']=<<<eot
<div class="pagebox-title"><h4>{title}</h4></div>
<div class="pagebox-content">
{contentbody}
</div>
eot;

$elements['taglist']=<<<eot
<table width="98%" align="center" cellpadding="4" cellspacing="0">
<tr><td>{tagcategory}</td></tr>
<tr><td style="word-break: none; word-wrap: break-word;">{tagcontent}</td></tr>
<tr><td>{tagextra}</td></tr>
</table>
<br/><br/>
eot;

$elements['register']=<<<eot
<form name="register" method="post" action="{job}">
<table cellspacing="1" width="500" align="center" class="formbox">
  <tr><td class="formbox-title" colspan="2">{title} {$lnc[262]}</td></tr>
  {registerbody}
  <tr><td colspan="2" align="center"><input type="submit" value="{$lnc[25]}" class="button"/> <input type="reset" value="{$lnc[252]}" class="button"/></td></tr>
</table>
</form>
eot;

$elements['normaltable']=<<<eot
<table cellspacing="0" width="500" align="center" class="formbox">
  {tablebody}
</table>
eot;

$elements['normaltablewithtitle']=<<<eot
<table cellspacing="0" width="500" align="center" class="formbox">
  <tr><td class="formbox-title" colspan="6">{title}</td></tr>
  {tablebody}
</table>
eot;

$elements['form_eachline']=<<<eot
  <tr>
    <td class="formbox-rowheader">{text}</td>
    <td class="formbox-content">{formelement}</td>
  </tr>
eot;

$elements['eachlink']=<<<eot
<div class="linkbody">
<div class="linkimg">{logo}</div>
<div class="linktxt"><span class="linktitle">{title}</span><br/>
<span class="linkdesc">{desc}</span></div>
</div>
eot;

$elements['linkdiv']=<<<eot
<div class="linkover">
<div class="linkgroup">{title}</div>
<div class="linkgroupcontent">{tablebody}</div>
</div>
eot;

$elements['viewpage']=<<<eot
<div class="pagebox">
	<div class="pagebox-title">
		<h4>
		{entrytitle}
		</h4>
	</div>
	<div class="pagebox-content">
		{entrycontent}
	</div>
</div>
eot;


//Message page
$elements['tips']=<<<eot
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{language}">
<head>
<!--//votmeta http-equiv="Content-Type" content="text/html; charset=UTF-8" /-->
<!--//votmeta http-equiv="Content-Language" content="UTF-8" /-->
<meta http-equiv="Content-Type" content="text/html; charset={charset}" />
<meta http-equiv="Content-Language" content="{languagename}" />
{csslocation}
<title>{blogname} - {blogdesc}</title>
<script type="text/javascript" src="images/js/common.js"></script>
</head>
<body>
<center>
<div class="messagebox">
  <div class="messagebox-title">{title}</div>
  <div class="messagebox-content">
  {tips}
  </div>
  <div class="messagebox-bottom"><a href="javascript: window.history.back();">{$lnc[263]}</a> | <a href="index.php">{$lnc[88]}</a> {admin_plus}</div>
</div>
</center>
</div>
</body>
</html>
eot;
