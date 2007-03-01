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

error_reporting(0);
chdir ('..');
require_once ("function.php");
if ($permission['AddEntry']!=1 && $permission['EditEntry']!=1) die ('Error!'); 
$title=$_POST['title'];
$content=$_POST['content'];
$idforsave=$_POST['idforsave'];

if (!$title && !$content && !$idforsave) die('ok');
if (get_magic_quotes_gpc()) {
	$content=stripslashes($content);
	$title=stripslashes($title);
}


$writetocookie=($idforsave.'||'.base64_encode($title).'||'.base64_encode($content));

writetofile ('data/draftsaved.php', '<?php exit;?>'.$writetocookie, time()+3600*240, "/");
die('ok');
?>