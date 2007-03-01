<?PHP
if (!defined('VALIDREQUEST')) die ('Access Denied.');
$definedfile="data/ccunion_setting.php";
if (is_file($definedfile)) {
	$all=readfromfile ($definedfile);
	@list($unuse, $uid, $sorttype)=@explode('|', $all);
}
$uid=floor($uid);
$sorttype=floor($sorttype);
$cc_safesource.='http://union.bokecc.com/bbslist.bo?id='.$uid.'&od='.$sorttype.'&sys=boblog&cc_code=2'; 



$plugin_return="<div style='clear: both;'><table width='100%' style='PADDING: 0px; MARGIN: 0px;align:center;overflow-x:hidden;'><tr><td>";
$plugin_return.="<iframe style='PADDING: 0px; MARGIN: 0px;align:center;overflow-x:hidden;' src='{$cc_safesource}' frameBorder='0' width='100%' scrolling='auto' height='950px' allowTransparency='true' id='cc_frame'><a href='{$cc_safesource}' target='_blank' title='视频展区' >精彩视频荟萃</a></iframe>";
$plugin_return.="</td></tr></table></div>";
$plugin_closesidebar=1;