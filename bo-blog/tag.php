<?PHP
//禁止使用Windows记事本修改文件，由此造成的一切使用不正常恕不解答！
@error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once ("data/config.php");
//Auto detect mirror site
$tmp_host=($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_ENV['HTTP_HOST'];
$config['blogurl']=str_replace('{host}', $tmp_host, $config['blogurl']);
if (!$config['blogurl'] || $config['blogurl']=='http://') { // $config['blogurl'] not set, installation is not complete
	@header("Content-Type: text/html; charset=utf-8");
	die ("Please set blog path in the admin center! <br/>您的blog路径设置错误！请返回首页，进入后台blog设置中，填写正确的blog路径！否则RSS、google sitemaps等大部分功能都无法使用！");
} else $baseurl="<base href=\"{$config['blogurl']}/\" />";
define ('whereAmI', 'tag');
//Very Simple Re-direct
$act='tag';
require ("index.php");
?>