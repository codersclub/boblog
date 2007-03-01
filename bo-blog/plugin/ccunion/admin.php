<?PHP

if (!defined('VALIDADMIN')) die ('Access Denied.');
checkpermission('CP');

$definedfile="data/ccunion_setting.php";
acceptrequest('job');

if (!$job || $job=='default') {
	if (is_file($definedfile)) {
		$all=readfromfile ($definedfile);
		@list($unuse, $uid, $sorttype, $displaymode)=@explode('|', $all);
	}
	$checksta1=($sorttype==1) ? ' checked' : '';
	$checksta2=($sorttype==2) ? ' checked' : '';
	$checksta3=($displaymode==1) ? ' checked' : '';
	$checksta4=($displaymode==2) ? ' checked' : '';
	$plugin_return=<<<eot
<table class='tablewidth' align=center cellpadding=4 cellspacing=0>
<tr>
<form action="admin.php?act=ccunion&job=save" method="post">
<td width=160 class="sectstart">
CC视频联盟设置
</td>
<td class="sectend"></td>
</tr>
<tr>
<td colspan='2' class="sect">
您的CC视频联盟用户ID：<br>
<input type='text' name='uid' value='{$uid}'><br>
默认视频文件显示方式：<br>
<input type=radio name=displaymode value='1' $checksta3>直接显示 <input type=radio name=displaymode value='2' $checksta4>折叠播放器（等同于[swf]效果） <br>
视频展区排序方式：<br>
<input type=radio name=sorttype value='1' $checksta1>按时间排列 <input type=radio name=sorttype value='2' $checksta2>按点击率排列 <br><br>
<input type=submit value="{$lna[64]}"><br><br>
CC视频联盟用户ID可以在CC管理中心中看到。如果您还不是联盟用户，<a href="http://www.bokecc.com/" target='_blank'>点击这里</a>访问并注册。
</td>
</tr>
</form>
</table>
eot;
}

if ($job=='save') {
	acceptrequest('uid,sorttype,displaymode');
	$uid=floor($uid);
	$sorttype=floor($sorttype);
	$displaymode=floor($displaymode);
	$add="<?php exit();?>|{$uid}|{$sorttype}|{$displaymode}|";
	writetofile ($definedfile, $add);
	catchsuccess ("CC视频联盟设置完成。", "返回设置页|admin.php?act=ccunion");
}

?>