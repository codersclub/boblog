<?PHP
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
<<A Bluview Technology Product>>
禁止使用Windows记事本修改文件，由此造成的一切使用不正常恕不解答！
PHP+MySQL blog system.
Code: Bob Shen
Offical site: http://www.bo-blog.com
Copyright (c) Bob Shen 中国－上海
In memory of my university life
------------------------------------------------------- */

require_once ("global.php");

$filedownload="data/downloadcounter.php";
$attachment=$_GET['f'];
if (!$attachment || !strstr($attachment, '.')) {
	die ("File does not exist.");
} else {
	$exitcount=0;
	$md5_file=md5($attachment);
	$dl=$_COOKIE['filedownloaded'];
	if ($dl) {
		$all_dl=@explode(',', $dl);
		if (@in_array($md5_file, $all_dl)) $exitcount=1;
	}
	if ($exitcount!=1) {
		$allcounts=readfromfile($filedownload);
		if (strstr($allcounts, "{$md5_file}|")) {
			$compare_str="/{$md5_file}\|([0-9]+?)>/ise";
			$allcounts=preg_replace($compare_str, "addcount('{$md5_file}', \\1)", $allcounts);
		} else $allcounts.="{$md5_file}|1>";
		writetofile ($filedownload, $allcounts);
		setcookie ('filedownloaded', $dl.','.$md5_file, time()+7200);
	}
	header ("Location: $attachment");
}


function addcount ($md5_file, $time) {
	return ("{$md5_file}|".($time+1).">");
}

