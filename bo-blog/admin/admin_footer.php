<?PHP
if (!defined('VALIDADMIN')) die ('Access Denied.');
$display_overall.="</div></div>
<div id=\"copyright\">[<a href=\"index.php\">{$lna[41]}</a>] [<a href=\"admin.php\">{$lna[39]}</a>] [<a href=\"login.php?job=logout\">{$lna[40]}</a>] <br/>{$config['blogname']}<br/>Powered by <a href=\"http://www.bo-blog.com\">Bo-Blog</a> {$blogversion}
</body></html>";
@header("Content-Type: text/html; charset=utf-8");
echo ($display_overall);