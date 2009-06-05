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
<link rel="alternate" title="{blogname}" href="feed.php" type="application/rss+xml" />
<link rel="Shortcut Icon" href="favicon.ico" /> 
{csslocation}
<title>{pagetitle}{blogname} - {blogdesc}</title>
<script type="text/javascript" src="images/js/common.js"></script>
 <!--[if lt IE 7.]>
<script language="javascript"> 
function correctPNG()  
{ 
for(var i=0; i<document.images.length; i++) 
{ 
  var img = document.images[i] 
  var imgName = img.src.toUpperCase() 
  if (imgName.substring(imgName.length-3, imgName.length) == "PNG") 
  { 
   var imgID = (img.id) ? "id='" + img.id + "' " : "" 
   var imgClass = (img.className) ? "class='" + img.className + "' " : "" 
   var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' " 
   var imgStyle = "display:inline-block;" + img.style.cssText  
   if (img.align == "left") imgStyle = "float:left;" + imgStyle 
   if (img.align == "right") imgStyle = "float:right;" + imgStyle 
   if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle   
   var strNewHTML = "<span " + imgID + imgClass + imgTitle 
   + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";" 
  + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader" 
   + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"  
   img.outerHTML = strNewHTML 
   i = i-1 
  } 
} 
} 
window.attachEvent("onload", correctPNG); 
 </script>
<![endif]-->
{ajax_js}
{extraheader}
</head>
<body>
eot;

$elements['displayheader']=<<<eot
<div id="wrapper">
	<div id="innerWrapper">
		<div id="header">
			<div id="innerHeader">
				<div id="blogLogo">
				</div>
				   <div class="blog-header">
				   <h1 class="blog-title"><a href="index.php">{blogname}</a></h1>
					<div class="blog-desc">{blogdesc}</div>
				   </div> 
			 </div>
         <div id="innerHeadershadow"></div>
	    </div>
	</div>
eot;

$elements['mainpage']=<<<eot
		<div id="mainWrapper">
			<div id="content" class="content">
				<div id="innerContent">
					<div class="article-top" style="display: {iftoppage}">
						<div class="pages">
<a href="{previouspageurl}">« Previous Entries</a>&nbsp;&nbsp;&nbsp;<a href="{nextpageurl}">Next Entries »</a>
						</div>
					</div>
					{mainpart}
					<div class="article-bottom" style="display: {ifbottompage}">
						<div class="pages">
<a href="{previouspageurl}">« Previous Entries</a>&nbsp;&nbsp;&nbsp;<a href="{nextpageurl}">Next Entries »</a>
						</div>
					</div>
				</div>
			</div>
eot;

$elements['displayside']=<<<eot
		 <div id="sidebar" class="sidebar">
		 <a href="feed.php"><img src="{$template['images']}/feedicon.png" border="0" alt="Feed!" /></a> 
         <div id="navigation">
		 <div class="panel">
         <div class="innerpanel">
         <h5 style="cursor: pointer">Navigation</h5>
         <div class="panel-content2">
		 <ul><!--global:{section_head_components}--></ul>
         </div>
         </div>
         </div>
         <div class="panelshadow"></div> 
         </div>
			<div id="innerSidebar">
					{section_side_components}
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
		<div id="footer"></div></div>
			<div id="innerFooter">
    Theme by <a href="http://www.marshal.sh.cn" target="_blank">Marshal</a>.
	{section_foot_components}
    <div id="processtime">
			</div>
		</div>
	</div>
</div>
eot;

$elements['footer']=<<<eot
<script type="text/javascript">
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
<div class="tips">{$lnc['tips']}:<br/>{message}</div>
eot;

$elements['sideblock']=<<<eot
<div class="panel">
<div class="innerpanel">
<h5 onclick='showhidediv("sidebar_{id}");'>{title}</h5>
<div class="panel-content" id="sidebar_{id}" style="display: {ifextend}">
{content}
</div>
</div>
</div>
<div class="panelshadow"></div>
eot;

$elements['sideblock_category']=<<<eot
<div id='panelCategory' class="panel">
<div class="innerpanel">
<h5 style="cursor: pointer" onclick='showhidediv("sideblock_category");'>{title}</h5>
<div class="panel-content" id="sideblock_category" style="display: {ifextend}">
{content}
</div>
</div>
</div>
<div class="panelshadow"></div>
eot;

$elements['displaybody']=<<<eot
<div id="sidebar" class="sidebar">
<div id="innerSidebar">
{section_side_components}
</div>
</div>
eot;


$elements['excerpt']=<<<eot
<div class="textdate">{entrydate}</div>
<div class="textbox">
<div class="innertext">
	<div class="textbox-title">
		<h4>
		{entrytitle}
		</h4>
	</div>
	<div class="textbox-content">
	{entrycontent}
	</div>
	<div class="tags" style="display: {iftags}"> {tags} {alltags} </div>
	</div>
	</div>
		{adminbar}
eot;

$elements['excerptontop']=<<<eot
<div class="textdate">{entrydate}</div>
<div class="textbox">
	<div class="textbox-title2">
		<div style="float: left; width: 95%;">
		<h4>
		{entrytitle}
		</h4>
		</div> 
		<div style="float: right; text-align:right; width: 5%;"><a href="javascript: showhidediv('{topid}');"><img src="{$template['images']}/folder.gif" border="0" alt="" title="{$lnc[236]}" /></a></div>
	    </div>
   <div class="innertext">
	<div id="{topid}" style="display: none;">
	<div class="textbox-content">
	{entrycontent}
	</div>
	<div class="textbox-label">
		{entryicon} {entrydate} {entrytime}, {entryauthor}, {entrycate}, {entrycomment}, {entryviews}
	</div>
	<div class="tags2" style="display: {iftags}"> {tags} {alltags}
	</div>
</div>
</div></div>
eot;

$elements['list']=<<<eot
	<tr>
		<td class="listbox-entry">
			[{entrycate}] {entrytitle}
		</td>
		<td class="listbox-entry" style="word-break: normal;" align="center">{entryauthor}</td>
		<td class="listbox-entry" width="120" align="center">{entrydate}</td>
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
		<td class="listbox-header" width="120" align="center">{$lnc[239]}</td>
	</tr>
	{listbody}
	</table>
	</div>
</div>
eot;

$elements['viewentry']=<<<eot
<div class="textdate">{entrydate}</div>
<div class="textbox">
<div class="innertext">
	<div class="textbox-title">
		<h4>
		{entrytitle}
		</h4>
	</div><div class="textbox-fontsize">
		{toolbar}
		</div>
	<div class="textbox-content" id="zoomtext">
		{entrycontent} {ifedited}
		<div class="tags2" style="display: {iftags}">{tags} {alltags}</div>
	</div>
	<div class="textbox-label">
		{entryicon} {entrydate} {entrytime}, {entryauthor}, {entrycate}, {entrycomment}, {entryviews} {ifadmin} 
	</div>
	{adminbar}
</div></div>
<div class="article-content">
    <div class="topic-previous">{previous}</div>
	<div class="topic-next">{next}</div>
</div>
<div id="commentWrapper" class="comment-wrapper">
	<a name="topreply"></a>
	<div id="addnew"></div>
eot;

$elements['comment']=<<<eot
	<div class="commentbox">
	<div class="commentbox-content commentbox-content-{oddorcouplecss}">
		<div class="commentbox-title">
		{replier} {replieremail} {replierip}
			<div class="commentbox-label">{replytime} {addadminreply} {deladminreply} {delreply} {blockreply}</div>
		</div>
			{replycontent}
			<div class="quote-comment" style="display: {ifadminreplied}"  id="replied_{commentid}">
				<div class="quote-comment-title">{adminrepliershow}</div>
				<div class="quote-comment-content">{adminreplycontent}</div>
			</div>
		</div>
		<div id="{commentid}" style="display: none">{adminreplybody}
		</div>
	</div>
eot;

$elements['trackback']=<<<eot
	<div class="trackbackbox">
		<div class="trackbackbox-title">
		<img src="{$template['images']}/trackback.gif" alt="" title="{$lnc[60]}"/> {tbtitle} 
			<div class="trackbackbox-label">
			[{tbtime}] {delreply}
			</div>
		</div>
		<div class="trackbackbox-content">
		 {$lnc[240]}<a href="{tburl}" target="_blank">{tbblogname}</a><br/>
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
				<td colspan="2" class="formbox-comment-title">{formtitle}</td>
			</tr>
			<tr>
				<td class="formbox-comment-rowheader" width="140">
					<div class="panel-smilies">
						<div class="panel-smilies-title">{$lnc[241]}</div>
							<div class="panel-smilies-content">
								{emots}
							</div>
						</div>
						<div style="text-align: left;">
							<input name="stat_html" id="stat_html" type="checkbox" value="1" {disable_html} /> {$lnc[242]}<br />
							<input name="stat_ubb" id="stat_ubb" type="checkbox" value="1" {disable_ubb} /> {$lnc[243]}<br />
							<input name="stat_emot" id="stat_emot" type="checkbox" value="1" {disable_emot} /> {$lnc[244]}<br />
							<input name="stat_property" id="stat_property" type="checkbox" value="1" onclick="promptreppsw();"/> {$lnc[245]}
							{if_neednopsw_begin}<br />
							<input name="stat_rememberme" id="stat_rememberme" type="checkbox" value="1" {checked_rememberme} onclick="quickremember();"/>  {$lnc[284]} {if_neednopsw_rawend}
						</div>
				</td>
				<td class="formbox-comment-content" valign="top">
					<div style="padding-bottom:5px">
					{if_neednopsw_begin}
					{$lnc[246]} <input name="v_replier" id="v_replier" type="text" size="12" class="text" value="{replier}" {disable_replier}/>&nbsp;
					 {$lnc[133]} <input name="v_password" id="v_password" type="password" size="12" class="text"  value="{password}" {disable_password}/>&nbsp; {$lnc[247]} 
					<br/>
					{$lnc[170]} <input name="v_repurl" id="v_repurl" type="text" size="12" class="text" value="{repurl}" />&nbsp;
					{$lnc[248]} <input name="v_repemail" id="v_repemail" type="text" size="12" class="text"  value="{repemail}" />&nbsp; {if_neednopsw_end}{additional}
					</div>
					{ubbcode}
					{if_securitycode_begin}<script type="text/javascript">securitycodejs="{$lnc[249]} <span id='securityimagearea'><img src='inc/securitycode.php?rand={rand}' alt='' title='{$lnc[250]}'/></span> <input name='v_security' id='v_security' type='text' size='4' maxlength='4' class='text' /> {$lnc[251]}   [<a href=\"javascript: refreshsecuritycode('securityimagearea', 'v_security');\">{$lnc[283]}</a>]";</script>  {if_securitycode_end}
					<textarea name="v_content" id="v_content" cols="64" rows="10" onkeydown="ctrlenterkey(event);" onfocus="if (securitycodejs!=null) {document.getElementById('showsecuritycode').innerHTML=securitycodejs; securitycodejs=null;}"></textarea> <br/>	<span id="showsecuritycode"></span>
					<div style="padding-top:10px">
					    {hidden_areas}
						<input type="button" name="btnSubmit" id="btnSubmit" value="{$lnc[25]}" class="button" onclick="ajax_submit('{jobnow}'); return false;"/>&nbsp;
						<input name="reset" id="reset" type="reset" value="{$lnc[252]}" class="button" />
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
<div class="readmore">{readmore}</div>
</div>
eot;

$elements['login']=<<<eot
<form name="register" method="post" action="login.php?job=verify">
<table cellspacing="1" width="500px" align="center" class="formbox">
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
<div class="textbox">
	<div class="textbox-title"><h4>{title}</h4></div>
	<div class="textbox-content">
		{contentbody}
	</div>
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
<table cellspacing="1" width="500px" align="center" class="formbox">
  <tr><td class="formbox-title" colspan="2">{title} {$lnc[262]}</td></tr>
  {registerbody}
  <tr><td colspan="2" align="center"><input type="submit" value="{$lnc[25]}" class="button"/> <input type="reset" value="{$lnc[252]}" class="button"/></td></tr>
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
