<?PHP
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
------------------------------------------------------- */

/*vot*/ error_reporting(E_ALL);
//*vot*/ error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$url=urldecode($_GET['go']);
setcookie ('adminuserid', '', time()-3600);
setcookie ('adminuserpsw', '', time()-3600);

@header("Location: {$url}");
exit();
