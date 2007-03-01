<?php
if (!defined('VALIDREQUEST')) die ('Access Denied.');
$definedfile="data/ccunion_setting.php";
if (is_file($definedfile)) {
	$all=readfromfile ($definedfile);
	@list($unuse, $uid, $sorttype)=@explode('|', $all);
	$uid=floor($uid);
	$sorttype=floor($sorttype);
}

if (!$uid) $plugincode="<script type='text/javascript'>alert(\"请先在插件管理中配置CC视频联盟插件，您现在尚未绑定用户ID号！\");</script>";
else $plugincode="<script type='text/javascript' src='http://union.bokecc.com/ccplugin.bo?userID={$uid}&type=boblog'></script>";

global $plugin_ubbeditor_functions, $plugin_ubbeditor_buttons;

$plugin_ubbeditor_functions.=''; //This plugin doesn't need to introduce any new functions
$plugin_ubbeditor_buttons.=$plugincode;

