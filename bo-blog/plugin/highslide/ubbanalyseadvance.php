<?php
if (!defined('VALIDREQUEST')) die ('Access Denied.');
function plugin_highslide_run ($str) {

/*vot*/	$highslide_search =	"/<a href=\"(\S+?)\" target=\"_blank\"><img src=\"(\S+?)\"((.+?)|\S*)\/><\/a>/is";
	
/*vot*/	$highslide_replace ="makeslideimg";

/*vot*/		$str=preg_replace_callback($highslide_search, $highslide_replace, $str);
		return $str;
}
function makeslideimg($match){
/*vot*/ $url = @$match[1];
/*vot*/ $src = @$match[2];
/*vot*/ $other = @$match[3];

if ($url==$src){
		$imgcode="<a href=\"{$src}\" class=\"highslide\" onclick=\"return hs.expand(this)\"><img src=\"{$src}\" class=\"insertimage\" alt=\"Highslide JS\" title=\"Нажмите для увеличения\" border=\"0\"{$other}/></a>";
	}
	else{
		$imgcode="<a href=\"{$url}\" target=\"_blank\"><img src=\"{$src}\" class=\"insertimage\" alt=\"{$alt}\" title=\"{$title}\" border=\"0\"{$other}/></a>";
	}
	$imgcode=str_replace('\"','"',$imgcode);
	return $imgcode;
}
