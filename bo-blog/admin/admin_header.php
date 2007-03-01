<?PHP
if (!defined('VALIDADMIN')) die ('Access Denied.');

include_once("data/cache_adminskinlist.php");

$csslocation="admin/theme/{$currentadminskin}/common.css";
$themename=$currentadminskin;
$adminitemperpage=20;
if (file_exists("lang/{$langback}/tips.php")) include_once("lang/{$langback}/tips.php");
else include_once("admin/tips.php");
$trmd=rand(0,9);
$daytip=$showtips[$trmd];
if ($act=='edit') {
	acceptrequest('useeditor');
	$useeditor=basename($useeditor);
	if ($useeditor && file_exists("editor/{$useeditor}/editordef.php")) {
		require("editor/{$useeditor}/editordef.php");
	}
	else {
		$useeditor=$mbcon['editortype'];
		require("editor/{$useeditor}/editordef.php");
	}
}

$display_overall.=<<<eot
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="UTF-8">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta name="robots" content="noindex, nofollow" />
<link rel="stylesheet" rev="stylesheet" href="{$csslocation}" type="text/css" media="all" />
<title>{$config['blogname']} - {$lna[0]} [Powered by Bo-Blog]</title>
$initialjs
<script type="text/javascript" src="lang/{$langback}/jslang.js"></script>
<script type="text/javascript" src="images/js/common.js"></script>
<script type="text/javascript" src="images/js/admin.js"></script>
<script type="text/javascript" src="images/js/ajax.js"></script>
$editorjs
<!--plugin_header-->
</head>
<body{$onloadjs}>
<div id='adminoverall'>
<div id="bloginfo">
<div id="bloginfoimg">
<img src="admin/theme/{$themename}/logo.gif" alt="Bo-Blog" />
</div>
<div id="bloginfotext">
{$lna[1]} {$daytip}
</div>
</div>
<div id="adminheader">
<div id="adminheaderbar">
<ul>
<li onmouseover="adminitemhover('main')"><a href="admin.php?act=main">{$lna[2]}</a></li>
<li onmouseover="adminitemhover('entry')"><a href="admin.php?act=entry">{$lna[3]}</a></li>
<li onmouseover="adminitemhover('category')"><a href="admin.php?act=category">{$lna[4]}</a></li>
<li onmouseover="adminitemhover('link')"><a href="admin.php?act=link">{$lna[5]}</a></li>
<li onmouseover="adminitemhover('reply')"><a href="admin.php?act=reply">{$lna[6]}</a></li>
<li onmouseover="adminitemhover('message')"><a href="admin.php?act=message">{$lna[7]}</a></li>
<li onmouseover="adminitemhover('user')"><a href="admin.php?act=user">{$lna[8]}</a></li>
<li onmouseover="adminitemhover('addon')"><a href="admin.php?act=addon">{$lna[9]}</a></li>
<li onmouseover="adminitemhover('misc')"><a href="admin.php?act=misc">{$lna[10]}</a></li>
<li onmouseover="adminitemhover('carecenter')"><a href="admin.php?act=carecenter">{$lna[11]}</a></li>
</ul>
</div>
</div>
eot;

$admin_item["main"]=array("default"=>$lna[12], "config"=>$lna[13], "mbcon"=>$lna[14], "module"=>$lna[15], "update"=>$lna[16], "langset"=>"Language");
$admin_item["category"]=array("default"=>$lna[4], "tags"=>$lna[17]);
$admin_item["link"]=array("default"=>$lna[18], "detail"=>$lna[19], "groupsorting"=>$lna[252], "add"=>$lna[20], "pending"=>$lna[21]);
$admin_item["entry"]=array("default"=>$lna[3], "write"=>$lna[22], "draft"=>$lna[23]);
//$admin_item["entry"]=array("default"=>$lna[3], "write"=>$lna[22], "draft"=>$lna[23], "pagewrite"=>$lna[1056], "pagemanage"=>$lna[1057]); //page write function is deterred
$admin_item["reply"]=array("default"=>$lna[6], "censor"=>$lna[24], "tb"=>$lna[25], "tbcensor"=>$lna[947]);
$admin_item["message"]=array("default"=>$lna[7], "censor"=>$lna[26]);
$admin_item["addon"]=array("skin"=>$lna[27], "plugin"=>$lna[28]);
$admin_item["misc"]=array("forbidden"=>$lna[30], "emot"=>$lna[29], "weatherset"=>$lna[31], "avatar"=>$lna[32], "sessiondir"=>$lna[935], "urlrewrite"=>$lna[527]);
$admin_item["user"]=array("usergroup"=>$lna[33], "users"=>$lna[8], "add"=>$lna[34]);
$admin_item["carecenter"]=array("recache"=>$lna[35], "adminattach"=>$lna[36], "mysql"=>MySQL, "export"=>$lna[37], "import"=>$lna[38]);

foreach ($admin_item as $k=>$v) {
	$rollall='<ul>';
	foreach ($v as $kk=>$vv) {
		$rollall.="<li class=\"normal\"><a href=\"admin.php?go={$k}_{$kk}\">{$vv}</a></li>";
	}
	$rollall.='</ul>';
	$display_overall.="<div id=\"hoveritem_{$k}\" style=\"display: none;\">{$rollall}</div>\n";
}

?>