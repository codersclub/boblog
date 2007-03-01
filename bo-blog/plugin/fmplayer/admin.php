<?PHP
if (!defined('VALIDADMIN')) die ('Access Denied.');
checkpermission('CP');


$plugin_address="plugin/{$act}";
if (!empty($langback)) include("{$plugin_address}/lang_{$langback}.php");
else include_once("{$plugin_address}/lang_en.php");

if(empty($lanfp[76])){exit;}
$backtoplugin="{$lna[28]}|admin.php?go=addon_plugin";
$backtofp_cfg="{$lanfp[0]}{$lanfp[1]}|admin.php?act={$act}";

acceptrequest('configjob');

if ($configjob=='save_list') {
	$savetext="<?PHP\n";
	$save_list=$_POST['fmp'];
	//if (count($save_list)<=0) catcherror ($lna[1013]);
	while (@list ($key, $val) = @each ($save_list)) {
		while (@list ($val_key, $val_value) = @each ($val)) {
			if($val_key=='title' && empty($val_value))break;
			if(!empty($val_value))$savetext.="\$fmp_list['{$key}']['{$val_key}']='".admin_convert($val_value)."';\n";
		}
	}
	//if ($savetext=='') catcherror ($lna[1013]);
	if (!writetofile("{$plugin_address}/fmp_list.php", $savetext)) catcherror("{$lna[66]}"."{$plugin_address}/fmp_list.php");
	else catchsuccess ($finishok, array($backtoplugin, $backtofp_cfg));
}
include("{$plugin_address}/fmp_list.php");

foreach($fmp_list as $fp_id => $fp_song){
	//$fmp_list_show .= "add_fpRow('{$fp_id}','{$fmp_list[$fp_id][title]}','{$fmp_list[$fp_id][creator]}','{$fmp_list[$fp_id][location]}','{$fmp_list[$fp_id][info]}','{$fmp_list[$fp_id][image]}','{$fmp_list[$fp_id][album]}','{$fmp_list[$fp_id][meta]}')\n";
	$fmp_list_show .= "add_fpRow('{$fp_id}','".htmlspecialchars($fmp_list[$fp_id][title]). "','" .htmlspecialchars($fmp_list[$fp_id][creator]). "','" .htmlspecialchars($fmp_list[$fp_id][location]). "','" .htmlspecialchars($fmp_list[$fp_id][info]). "','" .htmlspecialchars($fmp_list[$fp_id][image]). "','" .htmlspecialchars($fmp_list[$fp_id][album]). "','" .htmlspecialchars($fmp_list[$fp_id][meta])."')\n";
}
if ($configjob=='save_config') {
	$savetext="<?PHP\n";
	$save_config=$_POST['prefconfig'];
	if (count($save_config)<=1) catcherror ($lna[1013]);
	while (@list ($key, $val) = @each ($save_config)) {
		if($key=="file")$val=str_replace("http%3A%2F%2F","http://",urlencode($val));
		$savetext.="\$fmp_cfg['{$key}']='".admin_convert($val)."';\n";
	}
	if ($savetext=='') catcherror ($lna[1013]);
	if (!writetofile ("{$plugin_address}/fmp_cfg.php", $savetext)) catcherror ("{$lna[66]}"."{$plugin_address}/fmp_cfg.php");
	else catchsuccess ($finishok, array($backtoplugin, $backtofp_cfg));
}

$plugin_header=<<<eot
<script type="text/javascript">
var dyn_t,divi;
var jslanfp = Array('{$act}','{$lna[64]}','{$lna[65]}','{$lanfp[10]}','{$lanfp[14]}','{$lanfp[11]}','{$lanfp[12]}','{$lanfp[15]}','{$lanfp[16]}','{$lanfp[3]}','{$lanfp[4]}','{$lanfp[5]}','{$lanfp[6]}','{$lanfp[7]}','{$lanfp[8]}','{$lanfp[9]}');
</script>
<script type="text/javascript" src="{$plugin_address}/dyn_table.js"></script>
eot;

	$pref_leftchar="200";
	$pref_variable="fmp_cfg";
	include("{$plugin_address}/fmp_cfg.php");
	$fmp_cfg['file'] = urldecode($fmp_cfg['file']);
	include ("{$plugin_address}/fmp_pref.php");
	$pref_result_show=@implode('', $pref_result);

$plugin_return=<<<eot
<table class="tablewidth" align="center" cellpadding="4" cellspacing="0">
	<tr>
		<td width="280" class="sectstart">{$lanfp[0]}</td>
		<td class="sectend">{$lanfp[1]}</td>
	</tr>
</table>
<table class="tablewidth" cellpadding="4" cellspacing="1" align="center">
	<form action="admin.php?go={$act}" method="post">
	<tr><td class="prefsection" align="center" colspan="2"><a name="top"></a>{$lna[500]}</td></tr>
$pref_result_show
	<tr><td align="center" colspan="2"><input type="hidden" value="save_config" name="configjob" /><input type="submit" value="{$lna[64]}"/> <input type="reset" value="{$lna[65]}" /></form></td></tr>
	<tr><td class="prefsection" align="center" colspan="2">{$lanfp[0]} {$lanfp[13]}{$lanfp[1]} <a href="#top">[top]</a></td></tr>
</table>
<div align="right" class="prefsection">{$lanfp[75]}<input type="button" value="{$lanfp[2]}" onclick="add_fpRow('','','','','','','','')"></div>
<div id="form_div">
	<div id="input_div"></div>
</div>
<script type="text/javascript">
creatFrom();
creatSubmit();
dyn_t = document.getElementById("tbl_setList");
{$fmp_list_show}
</script>
<div id="copyright" align="right">$lanfp[76]</div>
eot;
?>