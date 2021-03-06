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
<title>{pagetitle}{blogname}</title>
<script src="images/js/common.js?jsver={codeversion}"></script>
{ajax_js}
{extraheader}
	
</head>
<body id="{pageID}">
eot;

$elements['displayheader']=<<<eot
 <div id="wrapper">
<div id="head">
	<h1><a href="index.php" title="{blogname}"><span>{blogname}</span></a><p>{blogdesc}</p></h1>
	<ul id="nav">
		{section_head_components}
	</ul>
</div>
eot;

$elements['mainpage']=<<<eot

	<div id="contain">

		<div id="col">

				<div id="maincontent">
				
					<div class="announce" style="display: {ifannouncement}">
						<div class="announce-content">
						{topannounce}
						</div>
					</div>
					{mainpart}
					<div class="article-bottom" style="display: {ifbottompage}">
						<div class="pages">
							{pagebar}
						</div>
					</div>
				</div>
eot;

$elements['displayside']=<<<eot
		<div id="side">
			<div id="sidecontent">
					{section_side_components_one}
					{section_side_components_two}
					<span id="search"><!--global:{block_search}--></span>
					<!--global:{section_foot_components}-->
				<div id="processtime">
				</div>
			</div>
		</div>
eot;

$elements['otherpage']=<<<eot
	<div id="contain">

		<div id="col">

				<div id="maincontent">
					<div class="formbox">
						{mainpart}
					</div>
				</div>
eot;

$elements['displayfooter']=<<<eot
		</div>
   </div>


	<div id="foot"></div>
	<div id="Copyright">
		<p>Copyright &copy; Lyfon.com 2006-2008, logs since 2005. Sys powered by <a href="http://www.bo-blog.com" title="boblog" rel="nofollow">boblog</a>.<br> Feeling blue skin designed and xhtml/css developed by <a href="http://lyfon.com" title="Spoon and Cat-Old W">J.Lyfon Fabacat</a>, Jan 6, 2008.</p>
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
<h4>{title}</h4>
{content}
eot;

$elements['sideblock_category']=<<<eot
<h4>{title}</h4>
{content}
eot;

$elements['sideblock_search']='';

$elements['excerpt']=<<<eot
	
	<div class="entrypost">
	<p class="date">{entrytime} {entrydatemnameshort} {entrydated}, {entrydatey}<span>{entrystar}&nbsp;&nbsp;edit by: {entryauthor}</span></p>
	<h1>{entrytitle}</h1>
	<p class="text">
	{entrycontent}
	</p>	
	<p class="tags" style="display: {iftags}">{tags} <strong>{alltags}</strong></p>
	<p class="category">Category: <strong>{entrycate}</strong><span></span></p>
	</div>	

eot;

$elements['excerptontop']=<<<eot

	<div class="entrypost">
	<p class="date">{entrytime} {entrydatemnameshort} {entrydated}, {entrydatey}<span>edit by: {entryauthor}</span></p>
	<h1>[{$lnc[33]}] <a href="javascript: showhidediv('{topid}');">{entrytitletext}</a></h1>
	<p class="text" id="{topid}" style="display: none;">
	{entrycontent}
	</p>
	<p class="tags" style="display: {iftags}">{tags} <strong>{alltags}</strong></p>
	<p class="category">Category: <strong>{entrycate}</strong><span>{entryviews} {entrycomment} {ifadmin} </span></p>{tbbar} {adminbar}
	</div>	

eot;

$elements['viewentry']=<<<eot
<div class="article-top">
	<div class="prev-article">{previous}</div>
	<div class="next-article">{next}</div>
</div>
	<div class="entrypost">
	<p class="date">{entrytime} {entrydatemnameshort} {entrydated}, {entrydatey}<span>{entrystar}&nbsp;&nbsp;edit by: {entryauthor}</span></p>
	<h1>{entrytitle}</h1>
	<p class="text">
	 	{entrycontent} {ifedited}
	</p>
	<p class="tags" style="display: {iftags}">{tags} <strong>{alltags}</strong></p>
	<p class="category">Category: <strong>{entrycate}</strong><span>{entryviews} {entrycomment} {ifadmin} </span></p>{tbbar} {adminbar}
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
		<td class="listbox-header" align="center">
			{$lnc[237]}
		</td>
		<td class="listbox-header" style="word-break: normal;" align="center">{$lnc[238]}</td>
		<td class="listbox-header" width="70" align="center">{$lnc[239]}</td>
	</tr>
	{listbody}
	</table>
	</div>
</div>
eot;

$elements['comment']=<<<eot
	<div class="commentbox commentbox-{oddorcouplecss}">
		<div class="commentbox-title">
		<a  >{replier} {replieremail} {replierhomepage} {replierip}</a><small>{replytime}</small>
			<div class="commentbox-label">{addadminreply} {deladminreply} {delreply} {blockreply}</div>
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
		<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="formbox-comment">
			<tr>
				<td colspan="2" class="formbox-comment-title"  style="display:none;">{formtitle}</td>
			</tr>
			<tr>
				<td class="formbox-comment-rowheader" width="140" valign="top"  style="display:none;">
					<div class="panel-smilies">
						<div class="panel-smilies-title">{$lnc[241]}</div>
							<div class="panel-smilies-content">
								{emots}
							</div>
						</div>
						<div style="text-align: left;"  style="display:none;">
							<input name="stat_html" id="stat_html" type="checkbox" value="1" {disable_html}> {$lnc[242]}<br>
							<input name="stat_ubb" id="stat_ubb" type="checkbox" value="1" {disable_ubb}> {$lnc[243]}<br>
							<input name="stat_emot" id="stat_emot" type="checkbox" value="1" {disable_emot}> {$lnc[244]}<br>
							<input name="stat_property" id="stat_property" type="checkbox" value="1" onclick="promptreppsw();"> {$lnc[245]}
							{if_neednopsw_begin}<br>
							<input name="stat_rememberme" id="stat_rememberme" type="checkbox" value="1" {checked_rememberme} onclick="quickremember();">  {$lnc[284]} {if_neednopsw_rawend}
						</div>
				</td>
				<td class="formbox-comment-content" valign="top">
					<div style="padding-bottom:5px">
					{if_neednopsw_begin}
					{$lnc[246]} <input name="v_replier" id="v_replier" type="text" size="12" class="text" value="{replier}" {disable_replier}>&nbsp;
					 {$lnc[133]} <input name="v_password" id="v_password" type="password" size="12" class="text"  value="{password}" {disable_password}>&nbsp; {$lnc[247]} 
					<br>
					{$lnc[170]} <input name="v_repurl" id="v_repurl" type="text" size="12" class="text" value="{repurl}">&nbsp;
					{$lnc[248]} <input name="v_repemail" id="v_repemail" type="text" size="12" class="text"  value="{repemail}">&nbsp; {if_neednopsw_end}{additional}
					</div>
					{if_securitycode_begin}
					<script>
					securitycodejs="{$lnc[249]} <span id='securityimagearea'><img src='inc/securitycode.php?rand={rand}' alt='' title='{$lnc[250]}'></span> <input name='v_security' id='v_security' type='text' size='4' maxlength='4' class='text'> {$lnc[251]}   [<a href=\"javascript: refreshsecuritycode('securityimagearea', 'v_security');\">{$lnc[283]}</a>]";
					</script>
					{if_securitycode_end}
					<textarea name="v_content" id="v_content" cols="43" rows="10" onkeydown="ctrlenterkey(event);" onfocus="if (securitycodejs!=null) {document.getElementById('showsecuritycode').innerHTML=securitycodejs; securitycodejs=null;}"></textarea> <br>	<span id="showsecuritycode"></span>
					<div style="padding-top:10px">
					{hidden_areas}
						<input type="button" name="btnSubmit" id="btnSubmit" value="{$lnc[25]}" class="button" onclick="ajax_submit('{jobnow}'); return false;">&nbsp;
						<input name="reset" id="reset" type="reset" value="{$lnc[252]}" class="button">
					</div>
				</td>
			</tr>
		</table>
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
<div style="margin-top: 9px;">
{readmore}
</div>
eot;

$elements['login']=<<<eot
<form name="register" method="post" action="login.php?job=verify">
<table cellspacing="1" width="500px" align="center" class="formbox">
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
<table width="98%" align="center" cellpadding="4" cellspacing="0">
<tr><td>{tagcategory}</td></tr>
<tr><td style="word-break: none; word-wrap: break-word;">{tagcontent}</td></tr>
<tr><td>{tagextra}</td></tr>
</table>
<br><br>
eot;

$elements['register']=<<<eot
<form name="register" method="post" action="{job}">
<table cellspacing="1" width="500px" align="center" class="formbox">
  <tr><td class="formbox-title" colspan="2">{title} {$lnc[262]}</td></tr>
  {registerbody}
  <tr><td colspan="2" align="center"><input type="submit" value="{$lnc[25]}" class="button"> <input type="reset" value="{$lnc[252]}" class="button"></td></tr>
</table>
</form>
eot;

$elements['normaltable']=<<<eot
<table cellspacing="0" width="500px" align="center" class="formbox">
  {tablebody}
</table>
eot;

$elements['normaltablewithtitle']=<<<eot
<table cellspacing="0" width="500px" align="center" class="formbox">
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
