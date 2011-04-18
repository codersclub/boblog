<?PHP
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
------------------------------------------------------- */

@error_reporting(0);

$url=urldecode($_GET['go']);
setcookie ('adminuserid', '', time()-3600);
setcookie ('adminuserpsw', '', time()-3600);

@header("Location: {$url}");
exit();
