<?php
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
<<A Bluview Technology Product>>
Prohibition of the Use Windows Notepad to modify the file, all the resulting answer will not be the use of non-normal!
PHP+MySQL blog system.
Code: Bob Shen
Offical site: http://www.bo-blog.com
Copyright (c) Bob Shen, China - Shanghai
In memory of my university life
------------------------------------------------------- */

if (!defined('VALIDREQUEST')) die ('Access Denied.');

/*vot*/ function inrss($inrss=null) {
/*vot*/	static $RSS = 0;
/*vot*/	if(!is_null($inrss)) {
/*vot*/		$RSS = $inrss;
/*vot*/	}
/*vot*/	return $RSS;
/*vot*/}

/*vot*/ function advanced($advanced=null) {
/*vot*/	static $ADV = 0;
/*vot*/	if(!is_null($advanced)) {
/*vot*/		$ADV = $advanced;
/*vot*/	}
/*vot*/	return $ADV;
/*vot*/}

function convert_ubb ($str, $advanced=0, $inrss=0) {
	global $logstat, $openidloginstat, $template, $mbcon, $lnc, $config;

/*vot*/	inrss($inrss);
/*vot*/	advanced($advanced);

	if ($logstat!=1) {
		$str=preg_replace("/\[hide\](.+?)\[\/hide\]/is", "<div class=\"quote hidebox\"><div class=\"quote-title\">{$lnc[311]}</div><div class=\"quote-content\">{$lnc[312]}  <a href=\"{$config['blogurl']}/login.php?job=register\">{$lnc[79]}</a> {$lnc[235]} <a href=\"{$config['blogurl']}/login.php\">{$lnc[89]}</a> </div></div>", $str);
	} else {
		$str=str_replace(array('[hide]','[/hide]'), '', $str);
	}
	$str=str_replace(array('{','}'), array('&#123;', '&#125;'), $str);
	$str=plugin_walk('ubbanalyse', $str);
	$basicubb_search=array('[hr]', '<br>');
	$basicubb_replace=array('<hr/>', '<br/>');
	$str=str_replace($basicubb_search, $basicubb_replace, $str);

	//[IMG]
	if ($advanced==1) {
/*vot*/		$str=preg_replace_callback("/\[url=([^\[]*)\]\[img( align=L| align=M| align=R)?( width=[0-9]+)?( height=[0-9]+)?\]\s*(\S+?)\s*\[\/img\]\[\/url\]/is","makeimgwithurl",$str);
/*vot*/		$str=preg_replace_callback("/\[img( align=L| align=M| align=R)?( width=[0-9]+)?( height=[0-9]+)?\]\s*(\S+?)\s*\[\/img\]/is","makeimg",$str);
	} else {
/*vot*/		$str=preg_replace_callback("/\[img( align=L| align=M| align=R)?( width=[0-9]+)?( height=[0-9]+)?\]\s*(\S+?)\s*\[\/img\]/is","makeimginrss",$str);
	}

/*vot*/	if ($mbcon['countdownload']=='1' && inrss()==0) {
/*vot*/		$str=preg_replace_callback("/\[(s)*file\]\s*\[attach\]([0-9]+)\[\/attach\]\s*\[\/(s)*file\]/is", "makedownatt", $str);
/*vot*/	}
	$str=preg_replace("/\[attach\]([0-9]+)\[\/attach\]/is", "attachment.php?fid=\\1", $str);
/*vot*/	$str=preg_replace_callback("/\[(s)*file\]\s*(\S+?)\s*\[\/(s)*file\]/is", "makedown", $str);

	//Auto add url link
	if ($mbcon['autoaddlink']==1) $str=preg_replace("/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp|gopher|news|telnet|rtsp|mms|callto|ed2k):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\()|]+)/i", "[autourl]\\1\\3[/autourl]", $str);


/*vot*/	$regubb_search = array(
				"/\s*\[quote\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s*/is",
				"/\s*\[quote=(.+?)\][\n\r]*(.+?)[\n\r]*\[\/quote\]\s*/is",
				"/\[email\]([^\[]*)\[\/email\]/is",
				"/\[acronym=([^\[]*)\](.+?)\[\/acronym\]/is",
				"/\[color=([a-zA-Z0-9#]+?)\](.+?)\[\/color\]/i",
				"/\[font=([^\[\<:;\(\)=&#\.\+\*\/]+?)\](.+?)\[\/font\]/i",
				"/\[p align=([^\[\<]+?)\](.+?)\[\/p\]/i",
				"/\[b\](.+?)\[\/b\]/i",
				"/\[i\](.+?)\[\/i\]/i",
				"/\[u\](.+?)\[\/u\]/i",
				"/\[strike\](.+?)\[\/strike\]/i",
				"/\[sup\](.+?)\[\/sup\]/i",
				"/\[sub\](.+?)\[\/sub\]/i",
	);
/*vot*/	$regubb_replace =  array(
				"<div class=\"quote\"><div class=\"quote-title\">{$lnc[265]}</div><div class=\"quote-content\">\\1</div></div>",
				"<div class=\"quote\"><div class=\"quote-title\">{$lnc[266]} \\1</div><div class=\"quote-content\">\\2</div></div>",
				"<a href=\"mailto:\\1\">\\1</a>",
				"<acronym title=\"\\1\">\\2</acronym>",
				"<span style=\"color: \\1;\">\\2</span>",
				"<span style=\"font-family: \\1;\">\\2</span>",
				"<p align=\"\\1\">\\2</p>",
				"<strong>\\1</strong>",
				"<em>\\1</em>",
				"<u>\\1</u>",
				"<del>\\1</del>",
				"<sup>\\1</sup>",
				"<sub>\\1</sub>",
	);
	$str=preg_replace($regubb_search, $regubb_replace, $str);

/*vot*/	$str=preg_replace_callback("/\[size=([^\[\<]+?)\](.+?)\[\/size\]/i", "makefontsize", $str);
/*vot*/	$str=preg_replace_callback("/\[tbl( width=[0-9]+)?(%)?( bgcolor=[^ ]*)?( border=[^ ]*)?\](.+?)\[\/tbl\]/is", "maketable", $str);
/*vot*/	$str=preg_replace_callback("/\s*\[code\][\n\r]*(.+?)[\n\r]*\[\/code\]\s*/i", "makecode", $str);
/*vot*/	$str=preg_replace_callback("/\[autourl\]([^\[]*)\[\/autourl\]/i", "makeurl", $str);
/*vot*/	$str=preg_replace_callback("/\[url\]([^\[]*)\[\/url\]/i", "makeurl", $str);
/*vot*/	$str=preg_replace_callback("/\[url=([^\[]*)\](.+?)\[\/url\]/i", "makeurl", $str);
/*vot*/	$str=preg_replace_callback("/\s*\[php\][\n\r]*(.+?)[\n\r]*\[\/php\]\s*/i", "xhtmlHighlightString", $str);

	//Multimedia Objects, dangerous, so visitors shall never be allowed to post such an object directly
	if ($advanced==1) {
/*vot*/		$str =(inrss()==0) ?  preg_replace("/\[(wmp|swf|real|flv)=([^\[\<]+?),([^\[\<]+?)\]\s*([^\[\<\r\n]+?)\s*\[\/(wmp|swf|real|flv)\]/is", "makemedia", $str) : preg_replace("/\[(wmp|swf|real|flv)=([^\[\<]+?),([^\[\<]+?)\]\s*([^\[\<\r\n]+?)\s*\[\/(wmp|swf|real|flv)\]/is", "<br/>{$lnc[267]}<br/>", $str);
		$str=plugin_walk('ubbanalyseadvance', $str);
	}
	return $str;

}

/*vot*/ function makeurl($match) { //2011/2/20 Force admin quit
	global $mbcon, $config;

/*vot*/	$url=$match[1];
/*vot*/	$linktext=@$match[2]; // [url=$url]$linktext[/url]

/*vot*/	if (advanced()==0) {
		$gotoreallink="{$config['blogurl']}/urlredirect.php?go=".(substr(strtolower($url), 0, 4) == 'www.' ? urlencode("http://$url") : urlencode($url));
	} else {
		$gotoreallink=substr(strtolower($url), 0, 4) == 'www.' ? "http://$url" : $url;
	}

	$urllink="<a href=\"{$gotoreallink}\" target=\"_blank\">";

	if ($linktext) {
		$url = $linktext;
	}
	else {
		if($mbcon['shortenurl']=='1' && strlen($url) > $mbcon['urlmaxlen']) {
			$halfmax=floor($mbcon['urlmaxlen']/2);
			$url = substr($url, 0, $halfmax).'...'.substr($url, 0-$halfmax);
		}
	}
	$urllink .= $url.'</a>';
	return $urllink;
}

/*vot*/function makefontsize ($match) {
/*vot*/	$size = $match[1];
/*vot*/	$word = $match[2];
	$word=stripslashes($word);
	$sizeitem=array (0, 8, 10, 12, 14, 18, 24, 36);
	$size=$sizeitem[$size];
	return "<span style=\"font-size: {$size}px;\">{$word}</span>";
}

/*vot*/ function makemedia ($match) {
/*vot*/	$mediatype=$match[1];
/*vot*/	$url=$match[4];
/*vot*/	$width=$match[2];
/*vot*/	$height==$match[3];
	global $template, $lnc, $config;
	$mediatype=strtolower($mediatype);
	$id=rand(1000, 99999);
	$typedesc=array('wmp'=>'Windows Media Player', 'swf'=>'Flash Player', 'real'=>'Real Player', 'flv'=>'Flash Video Player');
	$mediapic=array('wmp'=>'wmp.gif', 'swf'=>'swf.gif', 'real'=>'real.gif', 'flv'=>'swf.gif');
	$url=($mediatype=='flv') ? urlconvert ($url, $config['blogurl'].'/') : $url;
	$url=urlencode($url);
	$str="<div class=\"quote mediabox\"><div class=\"quote-title\"><img src=\"{$template['images']}/{$mediapic[$mediatype]}\" alt=\"\"/>{$typedesc[$mediatype]}{$lnc[268]}</div><div class=\"quote-content\"><a href=\"javascript: playmedia('player{$id}', '{$mediatype}', '{$url}', '{$width}', '{$height}');\">{$lnc[269]}</a><div id='player{$id}' style='display:none;'></div></div></div>";
	return $str;
}

/*vot*/ function makecode ($match) {
/*vot*/	$str = $match[1];
	$str=str_replace('[autourl]', '', $str);
	$str=str_replace('[/autourl]', '', $str);
	return "<div class=\"code\">{$str}</div>";
}

/*vot*/ function makeimg ($match) {
	global $lnc, $mbcon, $config;
/*vot*/	$show = '';
/*vot*/ $aligncode  = $match[1];
/*vot*/ $widthcode  = $match[2];
/*vot*/ $heightcode = $match[3];
/*vot*/ $src        = $match[4];
	$align=str_replace(' align=', '', strtolower($aligncode));
	if ($align=='l') $show=' align="left"';
	elseif ($align=='r') $show=' align="right"';
	else $alignshow='';
	$width=str_replace(' width=', '', strtolower($widthcode));
	if (!empty($width)) $show.=" width=\"{$width}\"";
	$height=str_replace(' height=', '', strtolower($heightcode));
	if (!empty($height)) $show.=" height=\"{$height}\"";
/*vot*/	if (inrss()==1) $src=(substr(strtolower($src), 0, 4) == 'http') ? $src : $config['blogurl'].'/'.$src;
/*vot*/	$onloadact=(inrss()==0 && !empty($mbcon['autoresizeimg'])) ? " onload=\"if(this.width>{$mbcon['autoresizeimg']}) {this.resized=true; this.width={$mbcon['autoresizeimg']};}\"" : '';
	$code="<a href=\"{$src}\" target=\"_blank\"><img src=\"{$src}\" class=\"insertimage\" alt=\"{$lnc[231]}\" title=\"{$lnc[231]}\" border=\"0\"{$onloadact}{$show}/></a>";
	return $code;
}

/*vot*/ function makeimgwithurl ($match) {
	global $lnc, $mbcon, $config;
/*vot*/	$url        = $match[1];
/*vot*/ $aligncode  = $match[2];
/*vot*/ $widthcode  = $match[3];
/*vot*/ $heightcode = $match[4];
/*vot*/ $src        = $match[5];
	$align=str_replace(' align=', '', strtolower($aligncode));
	if ($align=='l') $show=' align="left"';
	elseif ($align=='r') $show=' align="right"';
	else $alignshow='';
	$width=str_replace(' width=', '', strtolower($widthcode));
	if (!empty($width)) $show.=" width=\"{$width}\"";
	$height=str_replace(' height=', '', strtolower($heightcode));
	if (!empty($height)) $show.=" height=\"{$height}\"";
/*vot*/	if (inrss()==1) $src=(substr(strtolower($src), 0, 4) == 'http') ? $src : $config['blogurl'].'/'.$src;
/*vot*/	$onloadact=(inrss()==0 && !empty($mbcon['autoresizeimg'])) ? " onload=\"if(this.width>{$mbcon['autoresizeimg']}) {this.resized=true; this.width={$mbcon['autoresizeimg']};}\"" : '';
	$code="<a href=\"{$url}\" target=\"_blank\"><img src=\"{$src}\" class=\"insertimage\" alt=\"{$lnc[231]}\" title=\"{$lnc[231]}\" border=\"0\"{$onloadact}{$show}/></a>";
	return $code;
}


/*vot*/ function makeimginrss($match) {
/*vot*/	$src = $match[4];
	global $config, $lnc, $template;
	$src=(substr(strtolower($src), 0, 4) == 'http') ? $src : $config['blogurl'].'/'.$src;
	$str="<br/><img src=\"{$config['blogurl']}/{$template['images']}/viewimage.gif\" alt=\"\"/>{$lnc[231]}<br/>[url]{$src}[/url]<br/>";
	return $str;
}

/*vot*/ function xhtmlHighlightString($watch) {
/*vot*/	$str=base64_decode($watch[1]);
	if (PHP_VERSION<'4.2.0') return "<div class=\"code\" style=\"overflow: auto;\">$str</div>";
	$hlt = highlight_string($str, true);
	if (PHP_VERSION>'5') return "<div class=\"code\" style=\"overflow: auto;\">$hlt</div>";
	$fon = str_replace(array('<font ', '</font>'), array('<span ', '</span>'), $hlt);
	$ret = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $fon);
	return "<div class=\"code\" style=\"overflow: auto;\">$ret</div>";
}

/*vot*/ function makedownatt ($match) {
/*vot*/	$sfile = intval(($match[1] == 's')); // $match[1] = (s)*file
/*vot*/	$url = $match[2];
	return makedownload ($url, $sfile, true);
}

/*vot*/ function makedown ($match) {
/*vot*/	$sfile = intval(($match[1] == 's')); // $match[1] = (s)*file
/*vot*/	$url = $match[2];
/*vot*/	return makedownload ($url, $sfile, false);
/*vot*/}

/*vot*/function makedownload ($url, $sfile, $isattached=false) {
	global $logstat, $openidloginstat, $template, $lnc, $mbcon, $dlstat, $config;
	if ($isattached) {
		$downloadtime=" ({$lnc[280]} <!--global:{dlstat_{$url}}--> {$lnc[281]})";
		$downloadtime2=": <!--global:{dlfname_{$url}}-->";
		$dlstat[]=$url;
		$url="attachment.php?fid={$url}";
	}
/*vot*/	if (inrss()==0) {
		if (($logstat==1 || $openidloginstat==1) || $sfile!=1) $str="<div class=\"quote downloadbox\"><div class=\"quote-title\"><img src=\"{$template['images']}/download.gif\" alt=\"\"/>{$lnc[232]} {$downloadtime}</div><div class=\"quote-content\"><a href=\"{$url}\">{$lnc[233]}{$downloadtime2}</a></div></div>";
		else  $str="<div class=\"quote\"><div class=\"quote-title\"><img src=\"{$template['images']}/download.gif\" alt=\"\"/>{$lnc[232]}{$downloadtime}</div><div class=\"quote-content\">{$lnc[234]} <a href=\"{$config['blogurl']}/login.php?job=register\">{$lnc[79]}</a> {$lnc[235]} <a href=\"{$config['blogurl']}/login.php\">{$lnc[89]}</a> </div></div>";
	} else {
		if ($sfile==1) $str="{$lnc[234]} <a href=\"{$config['blogurl']}/login.php?job=register\">{$lnc[79]}</a> {$lnc[235]} <a href=\"{$config['blogurl']}/login.php\">{$lnc[89]}</a>";
		else $str="<a href=\"{$url}\">{$lnc[233]}</a>";
	}
	return $str;
}

/*vot*/ function maketable ($match) {
/*vot*/	$tablebody = $match[5];
/*vot*/	$widthcode = $match[1];
/*vot*/	$ifpercentage = $match[2];
/*vot*/	$bgcolorcode = $match[3];
/*vot*/	$bordercolorcode = $match[4];
	$tablebody=stripslashes($tablebody);
	$show="<table";
	$width=str_replace(' width=', '', strtolower($widthcode));
	if ($ifpercentage=='%') $width.='%';
	if (!empty($width)) $show.=" width=\"{$width}\"";
	$show.=" cellpadding=\"0\" cellspacing=\"0\">\n<tr>\n";
	$bgcolor=str_replace(' bgcolor=', '', strtolower($bgcolorcode));
	$bordercolor=str_replace(' border=', '', strtolower($bordercolorcode));
	if (!$bordercolor) $bordercolor="#000000";
	if (!$bgcolor) $bgcolor="#ffffff";
	$show.="<td bgcolor=\"{$bordercolor}\">\n";
	$show.="<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\">\n<tr><td bgcolor=\"{$bgcolor}\">";
	$tablebody=str_replace(',', "</td>\n<td bgcolor=\"{$bgcolor}\">", $tablebody);
	$tablebody=str_replace('<br/>', "</td></tr>\n<tr><td bgcolor=\"{$bgcolor}\">", $tablebody);
	$tablebody=str_replace('<br />', "</td></tr>\n<tr><td bgcolor=\"{$bgcolor}\">", $tablebody);
	$show.=$tablebody;
	$show.="</td></tr>\n</table>\n</td></tr>\n</table>";
	return $show;
}
