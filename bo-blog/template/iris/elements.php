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
				<div class="blog-header">
					<a href="index.php"><img src="{$template['images']}/logo.png" id="blogLogo" alt="{blogname}"/ border="0"></a>
					<div id="blog-desc">{blogdesc}</div>
					<div id="other">&nbsp;</div>
				</div>
				<div id="menu">
					<ul>
					{section_head_components}
					</ul>
				</div>
				<div id="menu-search">
				<form name="searchform" method="post" action="visit.php">
					<input name="job" type="hidden" value="search">
					<input name="searchmethod" type="hidden" value="2">
					<div id="search-text">
					    <input name="keyword" type="text" class="keyword" value="Search..." onclick="if (this.value=='Search...') this.value='';">
					</div>
					<div id="search-submit">
					    <input name="submit" type="image" class="search" title="Search" src="{$template['images']}/searchbutton.png" alt="Search" value="Go">
					</div>
				</form>
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
							<div class="previous-entries">
							    <a href="{nextpageurl}">{$lnc[70]}</a>
							</div>
							<div class="next-entries">
							    <a href="{previouspageurl}">{$lnc[69]}</a>
							</div>
							<div class="clear">&nbsp;</div>
						</div>
					</div>
					{mainpart}
					<div class="article-bottom" style="display: {ifbottompage}">
						<div class="pages">
							<div class="previous-entries">
							    <a href="{nextpageurl}">{$lnc[70]}</a>
							</div>
							<div class="next-entries">
							    <a href="{previouspageurl}">{$lnc[69]}</a>
							</div>
							<div class="clear">&nbsp;</div>
						</div>
					</div>
				</div>
			</div>
eot;

$elements['displayside']=<<<eot
		<div id="sidebar" class="sidebar">
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
	</div>
		<div id="footer">
			<div id="innerFooter">
			<!-- Please respect the labor of others, reservations about the author and copyright amendment -->
				{section_foot_components}
				| Design By <a href="http://livesino.net" target="_blank">Picturepan2</a>
				| Transplant by 404cn.com
			    <div id="processtime">
			    </div>
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

/*vot*/ $elements['msgbox']=<<<eot
<div class="tips">
  {$lnc['tips']}:
  <br>
  {message}
</div>
eot;

$elements['sideblock']=<<<eot
<div class="panel">
    <h5 onclick='showhidediv("sidebar_{id}");'>{title}</h5>
    <div class="panel-content" id="sidebar_{id}" style="display: {ifextend}">
        {content}
    </div>
</div>
eot;

$elements['sideblock_search']='';

$elements['displaybody']=<<<eot
<div id="sidebar" class="sidebar">
  <div id="innerSidebar">
    {section_side_components}
  </div>
</div>
eot;


$elements['excerpt']=<<<eot
<div class="textbox meta">
	<div class="post-date">
		<span class="post-month">{entrydatemnameshort}</span>
		<span class="post-day">{entrydated}</span>
		<span class="post-year">{entrydatey}</span>
	</div>
	<div class="textbox-title">
		<h4>{entrytitle}</h4>
		<div class="textbox-label">
			<span class="post-author">{entryauthor}</span>
            <span class="post-tag" style="display: {iftags}">{alltags}</span>
            <span class="add-comment">{entrycomment}</span>
            <span class="entryviews">{entryviews}&nbsp;</span>
		</div>
	</div>
	<div class="textbox-content">
	    {entrycontent}
	</div>
	{adminlink}
	{adminbar}
</div>
eot;

$elements['excerptontop']=<<<eot
<div class="textbox meta">
	<div class="post-date">
		<span class="post-month">{entrydatemnameshort}</span>
		<span class="post-day">{entrydated}</span>
		<span class="post-year">{entrydatey}</span>
	</div>
	<div class="textbox-title">
		<h4>
		<a href="javascript: showhidediv('{topid}');">{entrytitletext}</a>
		[{$lnc[33]}] 
		</h4>
		<div class="textbox-label">
			<span class="post-author">{entryauthor}</span>
            <span class="post-tag" style="display: {iftags}">{alltags}</span>
            <span class="add-comment">{entrycomment}</span>
		</div>
	</div>
	<div id="{topid}" style="display: none;">
	  <div class="textbox-content">
	    {entrycontent}
	  </div>
	  {adminlink}
	  {adminbar}
	</div>
	<div class="clear">&nbsp;</div>
</div>
eot;

$elements['viewentry']=<<<eot
<div class="article-top">
	<div class="prev-article">{previous}</div>
	<div class="next-article">{next}</div>
</div>
<div class="textbox">
	<div class="post-date">
		<span class="post-month">{entrydatemnameshort}</span>
		<span class="post-day">{entrydated}</span>
		<span class="post-year">{entrydatey}</span>
	</div>
	<div class="textbox-title">
		<h4>
		{entrytitle}
		</h4>
		<div class="textbox-label">
			<span class="post-author">{entryauthor}</span>
            <span class="post-tag" style="display: {iftags}">{alltags}</span>
            <span class="post-entrycate">{entrycate}</span>
		</div>
	</div>
	<div class="textbox-content" id="zoomtext">
	  {entrycontent}
	  {ifedited}
	</div>
	<div class="textbox-bottom">
		<span class="entrysource">{$lnc[240]}: {entrysourcewithlink}</span>
		{adminlink}
		<span class="entrytb">{entrytb}</span>
		<span class="entryviews">{entryviews}</span>
		<div class="clear">&nbsp;</div>
	</div>
	{tbbar}
	{adminbar}
</div>

<div id="commentWrapper" class="comment-wrapper">
	<h5 id="comments">{$lnc['article']} &laquo;{entrytitletext}&raquo; {$lnc['has']} {entrycommentnum} {$lnc['comments']}</h5>
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
	<div class="commentbox comment-{oddorcouplecss}">
		<div class="commentbox-title">
    		<span class="commentbox-author">{replier}</span> {$lnc['said']}: {deladminreply} {delreply} {blockreply}
    		</br>
	    	<span class="commentbox-label">{replytime}</span> {replierhomepage} {replierip} {addadminreply}
		</div>
		<div class="commentbox-content">
			{replycontent}
			<div class="quote" style="display: {ifadminreplied}"  id="replied_{commentid}">
			{adminrepliershow}:
			<br>
			{adminreplycontent}
			</div>
		</div>
		<div id="{commentid}" style="display: none">
		    {adminreplybody}
		</div>
	</div>
eot;

$elements['trackback']=<<<eot
	<div class="trackbackbox">
		<div class="trackbackbox-title">
		{tbtitle}
		</br>
		[{tbtime}] {delreply}
		</div>
		<div class="trackbackbox-content">
		 IP: {repip}
		 <br>
		 {$lnc[240]}<a href="{tburl}" target="_blank">{tbblogname}</a>
		 <br>
		 {$lnc[76]}{tbcontent}
		</div>
	</div>
eot;

$elements['form_reply']=<<<eot
	<a name="reply"></a>
	<div id="commentForm">
		<form name="visitorinput" id="visitorinput" method="post" action="javascript: ajax_submit('{jobnow}');">
		<div class="formbox-comment">
			<div class="formbox-comment-title">{formtitle}</div>
			<div class="formbox-comment-content">
				<div class="formbox-comment-input">
					{if_neednopsw_begin}
					<input name="v_replier" id="v_replier" type="text" size="42" class="text" value="{replier}" {disable_replier}> {$lnc[246]}<br>
					<br>
					<input name="v_repurl" id="v_repurl" type="text" size="42" class="text" value="{repurl}"> {$lnc[170]}
					<br>
					<br>
					<input name="v_repemail" id="v_repemail" type="text" size="42" class="text"  value="{repemail}"> {$lnc[248]}
					<input name="v_password" id="v_password" type="hidden" size="42" class="text"  value="{password}" {disable_password}>
					{if_neednopsw_end}
				</div>
				<div class="formbox-comment-tool">
					<input name="stat_html" id="stat_html" type="checkbox" value="1" {disable_html}> {$lnc[242]}
					<input name="stat_ubb" id="stat_ubb" type="checkbox" value="0" onclick="showhidediv('ubbid')"> {$lnc[243]}
					<input type="checkbox" value="0" onclick="showhidediv('emotid')"> {$lnc[241]}
					<input name="stat_emot" id="stat_emot" type="checkbox" value="1" {disable_emot}>{$lnc[244]}
					<input name="stat_property" id="stat_property" type="checkbox" value="1" onclick="promptreppsw();"> {$lnc[245]}
					{if_neednopsw_begin}
					<input name="stat_rememberme" id="stat_rememberme" type="checkbox" value="1" {checked_rememberme} onclick="quickremember();">  {$lnc[284]} {if_neednopsw_rawend}{additional}
				</div>
				<div id="ubbid" class="formbox-comment-ubb" style="display: none;">{ubbcode}</div>
				<div id="emotid" class="panel-smilies" style="display: none;">
					<div class="panel-smilies-content">
						{emots}
					</div>
				</div>
				{if_securitycode_begin}
				<script>
				securitycodejs="{$lnc[249]} <span id='securityimagearea'><img src='inc/securitycode.php?rand={rand}' alt='' title='{$lnc[250]}' style='cursor: pointer;' onclick=\"refreshsecuritycode('securityimagearea', 'v_security');\"></span> <input name='v_security' id='v_security' type='text' size='4' maxlength='4' class='text' style='ime-mode: disabled'> ";
				</script>
				{if_securitycode_end}
				<textarea name="v_content" id="v_content" cols="100%" rows="10" onkeydown="ctrlenterkey(event);" onfocus="if (securitycodejs!=null) {document.getElementById('showsecuritycode').innerHTML=securitycodejs; securitycodejs=null;}"></textarea>
				<br>
				<span id="showsecuritycode"></span>
				<div style="padding-top:10px">
					{hidden_areas}
					<div class="btnborder">
					    <input type="buttom" name="btnSubmit" id="btnSubmit" value="{$lnc[25]}" class="button" onclick="ajax_submit('{jobnow}'); return false;">
					</div>
					<div class="clear" style="width:10px">&nbsp;</div>
				</div>
			</div>
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
<div class="entrymore">
  {readmore}
</div>
eot;

$elements['login']=<<<eot
<form name="register" method="post" action="login.php?job=verify">
<table cellspacing="1" width="500px" align="center" class="formbox">
  <tr>
    <td class="formbox-title" colspan="2">
      {$lnc[253]}
      [<a href="login.php?job=register">{$lnc[254]}</a>]
    </td>
  </tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[132]}</td>
    <td class="formbox-content">
      <input name="username" type="text" id="username" size="24" class="text">
    </td>
  </tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[133]}</td>
    <td class="formbox-content">
      <input name="password" type="password" id="password" size="16" class="text">
    </td>
  </tr>
  <tr>
    <td class="formbox-rowheader">{$lnc[255]}</td>
    <td class="formbox-content">
      <input name="savecookie" type="radio" id="savecookie" value="0">{$lnc[256]}
      <input name="savecookie" type="radio" id="savecookie" value="3600">{$lnc[257]}
      <input name="savecookie" type="radio" id="savecookie" value="86400">{$lnc[258]}
      <input name="savecookie" type="radio" id="savecookie" value="604800">{$lnc[259]}
      <input name="savecookie" type="radio" id="savecookie" value="2592000">{$lnc[260]}
      <input name="savecookie" type="radio" id="savecookie" value="31104000">{$lnc[261]}
    </td>
  </tr>
  {lvstart}
  <tr>
    <td class="formbox-rowheader">{$lnc[249]}</td>
    <td class="formbox-content">
      <span id='securityimagearea'>
        <img src="inc/securitycode.php?rand={rand}" alt="" title="{$lnc[250]}">
      </span>
      <input name="securitycode" type="text" id="securitycode" size="16" class="text">
      {$lnc[251]}
      [<a href="javascript: refreshsecuritycode('securityimagearea', 'securitycode');">{$lnc[283]}</a>]
    </td>
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
<div class="textbox">
	<div class="textbox-title"><h4>{title}</h4></div>
	<div class="textbox-content">
		{contentbody}
	</div>
</div>
eot;

$elements['taglist']=<<<eot
<table width="98%" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td>{tagcategory}</td>
  </tr>
  <tr>
    <td style="word-break: none; word-wrap: break-word;">{tagcontent}</td>
  </tr>
  <tr>
    <td>{tagextra}</td>
  </tr>
</table>

<br><br>
eot;

$elements['register']=<<<eot
<form name="register" method="post" action="{job}">
<table cellspacing="1" width="500px" align="center" class="formbox">
  <tr>
    <td class="formbox-title" colspan="2">{title} {$lnc[262]}</td>
  </tr>
  {registerbody}
  <tr>
    <td colspan="2" align="center">
      <input type="submit" value="{$lnc[25]}" class="button">
      <input type="reset" value="{$lnc[252]}" class="button">
    </td>
  </tr>
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
  <tr>
    <td class="formbox-title" colspan="6">{title}</td>
  </tr>
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
  <div class="linktxt">
    <span class="linktitle">{title}</span>
    <br>
    <span class="linkdesc">{desc}</span>
  </div>
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
    <h4>{entrytitle}</h4>
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

<body style="border:0!important;border:0;">
<center>
<div class="messagebox">
  <div class="messagebox-title">{title}</div>
  <div class="messagebox-content">
    {tips}
  </div>
  <div class="messagebox-bottom">
    <a href="javascript: window.history.back();">{$lnc[263]}</a>
    | <a href="index.php">{$lnc[88]}</a>
    {admin_plus}
  </div>
</div>
</center>
</div>

</body>
</html>
eot;
