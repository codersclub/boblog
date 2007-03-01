<?php
if (!defined('VALIDREQUEST')) die ('Access Denied.');
global $cc_displaymode;

if (!$cc_displaymode) {
	$definedfile="data/ccunion_setting.php";
	$all=readfromfile ($definedfile);
	@list($unuse, $uid, $sorttype, $displaymode)=@explode('|', $all);
	$cc_displaymode=floor($displaymode);
}

function plugin_ccunion_run ($str) {
	global $cc_displaymode;
	if ($cc_displaymode==1) {
		$str=preg_replace ("/\[cc\]\s*([^\[\<\r\n]+?)\s*\[\/cc\]/is", "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='438' height='387'><param name='movie' value='http://union.bokecc.com/\\1'/><param name='quality' value='high' /><embed src='http://union.bokecc.com/\\1' quality='high' type='application/x-shockwave-flash' width='438' height='387'></embed></object>", $str);
	} else {
		$str=preg_replace ("/\[cc\]\s*([^\[\<\r\n]+?)\s*\[\/cc\]/ise", "makemedia('swf', 'http://union.bokecc.com/\\1', '438', '387')", $str);
	}
	return $str;
}

?>