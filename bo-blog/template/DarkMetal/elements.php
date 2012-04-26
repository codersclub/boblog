<?php
$elements['header']=<<<eot
<!DOCTYPE html>
<html lang="{language}">
<head>
<meta charset="UTF-8">
<meta content="all" name="robots">
<meta name="author" content="{blogname}">
<meta name="description" content="{blogdesc}">
<meta name="keywords" content="{blogkeywords}">
{baseurl}
<link rel="alternate" title="{blogname}" href="feed.php" type="application/rss+xml">
{csslocation}
<title>{pagetitle}{blogname} - {blogdesc}</title>
<script src="images/js/common.js?jsver={codeversion}"></script>
{ajax_js}
{extraheader}
</head>
<body id="{pageID}">
eot;

$elements['displayheader']=<<<eot
<div id="wrapper">
<div id="innerWrapper">
<div id="header">
<div id="innerHeader">

<div class="blogheader">
<div class="bloglogo"></div>
<div class="blogsearch">
<form method="post" action="visit.php">
<input name="job" type="hidden" value="search">
<input name="searchmethod" type="hidden" value="2">
<input name="keyword" value="" type="text">
<input class="button" name="searchsubmit" value="{$lnc[128]}" type="submit">
</form>
</div>
</div>

<div class="blogmenu">
<div class="blogmenuin">
<div id="menu">
<ul>
{section_head_components}
</ul>
</div>
</div>
</div>

<div class="mysidebar">
<div class="mysidebarin">
<div class="myentries">
<div class="mytitle">{$lnc[113]}</div>
<div class="mycontent"><!--global:{block_entries}--></div>
</div>
<div class="mycomments">
<div class="mytitle">{$lnc[114]}</div>
<div class="mycontent"><!--global:{block_replies}--></div>
</div>
<div class="mystatistics">
<div class="mytitle">{$lnc[105]}</div>
<div class="mycontent"><!--global:{block_statistics}--></div>
</div>
</div>
</div>

</div>
</div>
eot;

$elements['mainpage']=<<<eot
		<div id="mainWrapper">
			<div id="content" class="content">
				<div id="innerContent">
					<div class="announce" style="display: {ifannouncement}">
						<div class="announce-content">
						{topannounce}
						</div>
					</div>
					<div class="article-top" style="display: {iftoppage}">
						<div class="pages">
							{pagebar}
						</div>
					</div>
					{mainpart}
					<div class="article-bottom" style="display: {ifbottompage}">

						<div class="pages">
							{pagebar}
						</div>

					</div>
				</div>
			</div>
eot;


$elements['otherpage']=<<<eot
		<div id="mainWrapper">
			<div id="content" class="content">
				<div id="innerContent">
					<div class="formbox">
						{mainpart}
					</div>
				</div>
			</div>
eot;

$elements['displayfooter']=<<<eot
	</div>
		<div id="footer">
        <div id="innerFooter">Template By <a href="http://www.tabox.cn">Tabox.Cn </a>{section_foot_components}
				<div id="processtime">
				</div>
		</div>
	</div>
</div>
eot;

$elements['footer']=<<<eot
<script>
loadSidebar();
</script>
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
<div class="tips">{$lnc['tips']}:<br>{message}</div>
eot;

$elements['sideblock']=<<<eot
<div class="panel">
<h5 onclick='showhidediv("sidebar_{id}");'>{title}</h5>
<div class="panel-content" id="sidebar_{id}" style="display: {ifextend}">
{content}
</div>
</div>
eot;

$elements['sideblock_category']=<<<eot
<div id='panelCategory' class="panel">
<h5 style="cursor: pointer" onclick='showhidediv("sideblock_category");'>{title}</h5>
<div class="panel-content" id="sideblock_category" style="display: {ifextend}">
{content}
</div>
</div>
eot;

$elements['sideblock_search']='';

$elements['excerpt']=<<<eot
<div class="textbox">

<div class="textboxtop">

<div class="textbox-title">
<h4>{entrytitle}</h4>
<div class="textboxcalendar">{entrydatey} {entrydatemnameshort}.{entrydated} {entrytime}</div>
</div>

<div class="textbox-label">{$lnc['category']}: {entrycate} {$lnc[127]}: {alltags} {$lnc['other']}: {entrycomment} {entrytb} {entryviews} {ifadmin}</div>

</div>

{tbbar}
{adminbar}

<div class="textbox-content">{entrycontent}</div>
<div class="textbox-bottom"></div>

</div>
eot;

$elements['excerptontop']=<<<eot
<div class="textbox">

<div class="textboxtop">

<div class="textbox-title">
<h4>[{$lnc[33]}] <a href="javascript: showhidediv('{topid}');">{entrytitletext}</a></h4>
<div class="textboxcalendar">{entrydatey} {entrydatemnameshort}.{entrydated} {entrytime}</div>
</div>

<div class="textbox-label">{$lnc['category']}: {entrycate} {$lnc[127]}: {alltags} {$lnc['other']}: {entrycomment} {entrytb} {entryviews} {ifadmin}</div>

</div>

{tbbar}
{adminbar}
	
<div id="{topid}" style="display: none;">

<div class="textbox-content">{entrycontent}</div>

<div class="textbox-bottom"></div>

</div>
	
<div class="textbox-top"></div>

</div>
eot;

$elements['viewentry']=<<<eot
<div class="textbox">

<div class="textboxtop">

<div class="textbox-title">
<h4>{entrytitle}</h4>
<div class="textboxcalendar">{entrydatey} {entrydatemnameshort}.{entrydated} {entrytime}</div>
</div>

<div class="textbox-label">{$lnc['category']}: {entrycate} {$lnc[127]}: {alltags} {$lnc['other']}: {entrycomment} {entrytb} {entryviews} {ifadmin}</div>

</div>

{tbbar}
{adminbar}

<div class="textbox-content" id="zoomtext">{entrycontent} {ifedited}</div>

<div class="article-bottom">
<div class="prev-article">{previous}</div>
<div class="next-article">{next}</div>
</div>
	
<div class="textbox-bottom"></div>

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
		<td class="listbox-entry" width="96" >{entryauthor}</td>
		<td class="listbox-entry" width="96" >{entrydate}</td>
	</tr>
eot;

$elements['listbody']=<<<eot
<div class="listbox">
	<div class="listbox-table">
	<table cellpadding="2" cellspacing="0" width="100%">
	<tr>
		<td class="listbox-header" >
			{$lnc[237]}
		</td>
		<td class="listbox-header" width="96" >{$lnc[238]}</td>
		<td class="listbox-header" width="96" >{$lnc[239]}</td>
	</tr>
	{listbody}
	</table>
	</div>
</div>
eot;

$elements['comment']=<<<eot
	<div class="commentbox commentbox-{oddorcouplecss}">
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
		<div id="{commentid}" style="display: none">{adminreplybody}
		</div>
	</div>
eot;

$elements['trackback']=<<<eot
	<div class="trackbackbox">
		<div class="trackbackbox-title">
		 {tbtitle} 
			<div class="trackbackbox-label">
			[{tbtime}] {delreply}
			</div>
		</div>
		<div class="trackbackbox-content">
		 {$lnc[240]}<a href="{tburl}" target="_blank">{tbblogname}</a><br>
		 {$lnc[76]}{tbcontent}
		</div>
	</div>
eot;


$elements['form_reply']=<<<eot
<a name="reply"></a>
<div id="commentForm">
  <form name="visitorinput" id="visitorinput" method="post" action="javascript: ajax_submit('{jobnow}');">
  <div class="formbox-comment-title">{formtitle}</div>
  <div class="formbox-comment-info">
   {if_neednopsw_begin}
   {$lnc[246]} <input name="v_replier" id="v_replier" type="text" size="20" class="text" value="{replier}" {disable_replier}>  {additional}<br>
   {$lnc[133]} <input name="v_password" id="v_password" type="password" size="20" class="text"  value="{password}" {disable_password}>  {$lnc[247]} <br>
   {$lnc[170]} <input name="v_repurl" id="v_repurl" type="text" size="20" class="text" value="{repurl}"> <br>
   {$lnc[248]} <input name="v_repemail" id="v_repemail" type="text" size="20" class="text"  value="{repemail}">  {if_neednopsw_end}<br>
   <div style="padding:5px 0 5px 0;">
    <input name="stat_html" id="stat_html" type="checkbox" value="1" {disable_html}> {$lnc[242]} 
    <input name="stat_ubb" id="stat_ubb" type="checkbox" value="0" onclick="showhidediv('ubbid')"> {$lnc[243]} 
    <input name="stat_emot" id="stat_emot" type="checkbox" value="0" onclick="showhidediv('emotid')"> {$lnc[244]} 
    <input name="stat_property" id="stat_property" type="checkbox" value="1" onclick="promptreppsw();"> {$lnc[245]} 
    {if_neednopsw_begin}
    <input name="stat_rememberme" id="stat_rememberme" type="checkbox" value="1" {checked_rememberme} onclick="quickremember();">  {$lnc[284]} {if_neednopsw_rawend}
   </div>
  </div>
  <div id="ubbid" class="formbox-comment-ubb" style="display: none;">{ubbcode}</div>
  <div id="emotid" class="formbox-comment-smilies" style="display: none;">{emots}</div>
  {if_securitycode_begin}
  <script>
    securitycodejs="{$lnc[249]} <span id='securityimagearea'><img src='inc/securitycode.php?rand={rand}' alt='' title='{$lnc[250]}'></span> <input name='v_security' id='v_security' type='text' size='4' maxlength='4' class='text'> {$lnc[251]}   [<a href=\"javascript: refreshsecuritycode('securityimagearea', 'v_security');\">{$lnc[283]}</a>]";
  </script>
  {if_securitycode_end}
  <div class="formbox-comment-content">
  <textarea name="v_content" id="v_content" cols="79" rows="8" onkeydown="ctrlenterkey(event);" onfocus="if (securitycodejs!=null) {document.getElementById('showsecuritycode').innerHTML=securitycodejs; securitycodejs=null;}"></textarea>
  </div>
  <span id="showsecuritycode"></span>
  {hidden_areas}
  <div style="padding: 5px 0 10px 5px;">
   <input type="button" name="btnSubmit" id="btnSubmit" value="{$lnc[25]}" class="button" style="width: 50px;" onclick="ajax_submit('{jobnow}'); return false;"> 
   <input name="reset" id="reset" type="reset" value="{$lnc[252]}" class="button" style="width: 50px;">
  </div>
  </form>
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
<div class="readmore">{readmore}
</div>
eot;

$elements['login']=<<<eot
<form name="register" method="post" action="login.php?job=verify">
<table cellspacing="1" width="500px" class="formbox">
  <tr><td class="formbox-title" colspan="2">{$lnc[253]} [<a href="login.php?job=register">{$lnc[254]}</a>]</td></tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[132]}</td>
    <td class="formbox-content"><input name="username" type="text" id="username" size="24" class="text">
  </tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[133]}</td>
    <td class="formbox-content"><input name="password" type="password" id="password" size="16" class="text">
  </tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[255]}</td>
    <td class="formbox-content"><input name="savecookie" type="radio" id="savecookie" value="0">{$lnc[256]} <input name="savecookie" type="radio" id="savecookie" value="3600">{$lnc[257]} <input name="savecookie" type="radio" id="savecookie" value="86400">{$lnc[258]}  <input name="savecookie" type="radio" id="savecookie" value="604800">{$lnc[259]}  <input name="savecookie" type="radio" id="savecookie" value="2592000">{$lnc[260]}   <input name="savecookie" type="radio" id="savecookie" value="31104000">{$lnc[261]}   
  </tr>
  {lvstart}
  <tr>
    <td class="formbox-rowheader">{$lnc[249]}</td>
    <td class="formbox-content"><span id='securityimagearea'><img src="inc/securitycode.php?rand={rand}" alt="" title="{$lnc[250]}"></span> <input name="securitycode" type="text" id="securitycode" size="16" class="text"> {$lnc[251]}  [<a href="javascript: refreshsecuritycode('securityimagearea', 'securitycode');">{$lnc[283]}</a>]
  </tr>
  {lvend}
  <tr>
    <td class="formbox-content"></td>
    <td class="formbox-content">
    <input name="Submit" type="submit" id="Submit" value="{$lnc[25]}" class="button"> &nbsp;
    <input name="Reset" type="reset" id="Reset" value="{$lnc[252]}" class="button">
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
<table width="100%" align="center" cellpadding="4" cellspacing="0">
<tr><td>{tagcategory}</td></tr>
<tr><td style="word-break: none; word-wrap: break-word;">{tagcontent}</td></tr>
<tr><td>{tagextra}</td></tr>
</table>
<br><br>
eot;

$elements['register']=<<<eot
<form name="register" method="post" action="{job}">
<table cellspacing="1" width="500px"  class="formbox">
  <tr><td class="formbox-title" colspan="2">{title} {$lnc[262]}</td></tr>
  {registerbody}
  <tr><td colspan="2" ><input type="submit" value="{$lnc[25]}" class="button"> <input type="reset" value="{$lnc[252]}" class="button"></td></tr>
</table>
</form>
eot;

$elements['normaltable']=<<<eot
<table cellspacing="0" width="500px"  class="formbox">
  {tablebody}
</table>
eot;

$elements['normaltablewithtitle']=<<<eot
<table cellspacing="0" width="500px"  class="formbox">
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
<div class="linktxt"><span class="linktitle">{title}</span><br>
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
<!DOCTYPE html>
<html lang="{language}">
<head>
<meta charset="UTF-8">
{csslocation}
<title>{blogname} - {blogdesc}</title>
<script src="images/js/common.js"></script>
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
