<?php
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
------------------------------------------------------- */

error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$url = urldecode($_GET['go']);
setcookie('adminuserid', '', time() - 3600);
setcookie('adminuserpsw', '', time() - 3600);

@header("Location: {$url}");
exit();
