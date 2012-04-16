<?PHP
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
<<A Bluview Technology Product>>
Prohibition of the Use Windows Notepad to modify the file, all the resulting answer will not be the use of non-normal!
PHP+MySQL blog system.
Code: Bob Shen
Offical site: http://www.bo-blog.com
Copyright (c) Bob Shen, China - Shanghai
In memory of my university life
Modified by Valery Votintsev
------------------------------------------------------- */

if (!defined('VALIDADMIN')) {
    die ('Access Denied.');
}

acceptrequest('blogid,ajax');
checkpermission('CP');

if ($ajax == 'on') {
    $in_ajax_mode = 1;
}

checkpermission('AddEntry');

if ($ajax == 'on' && $cancel != '') {
    die ($cancel);
}

$blogid = floor($blogid);
$blog->query("UPDATE `{$db_prefix}blogs` SET `starred`=`starred`+1 WHERE `blogid`='{$blogid}'");

if ($ajax != 'on') {
    $urlreturn = ($_SERVER['HTTP_REFERER'] == '') ? "index.php" : $_SERVER['HTTP_REFERER'];
    header("Location: $urlreturn");
} else {
    die('ok');
}
