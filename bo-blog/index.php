<?php
/* -----------------------------------------------------
Bo-Blog 2 : The Blog Reloaded.
<<A Bluview Technology Product>>
Prohibition of the Use Windows Notepad to modify the file, all the resulting answer will not be the use of non-normal!
PHP+MySQL blog system.
Code: Bob Shen
Offical site: http://www.bo-blog.com
Copyright (c) Bob Shen
In memory of my university life
------------------------------------------------------- */

define('isIndex', 1);
$begintime = getmicrotime();
$blogplugin = $section_header = $section_footer = $section_sidebar = $section_prebody = $dlstat = $blogitem = $flset = [];

require_once("global.php");
include_once("data/allmods.php");
include_once("data/weather.php");
include_once("data/cache_emot.php");
include_once("data/cache_emsel.php");
include_once("data/cache_adminlist.php");

$isSafeMode = (@$_REQUEST['safemode'] == 1 || @$_COOKIE['safemode'] == 1) ? true : false;
if (!$isSafeMode) {
    include_once("data/modules.php");
    include_once("data/plugin_enabled.php");
}

acceptrequest('act,go,page,part');
if (empty($page)) {
    $page = 1;
} elseif (!is_numeric($page) || $page <= 0) {
    getHttp404($lnc[313]);
} else {
    $page = floor($page);
}

if (empty($part)) {
    $part = 1;
} elseif (!is_numeric($part) || $part <= 0) {
    getHttp404($lnc[313]);
} else {
    $page = floor($page);
}

$pageitems = '';

if ($config['blogopen'] != 1 && !defined('isLogin')) {
    if ($permission['CP'] == 1) {
        $config['message_off'] .= "<br>\n<ul><li><a href='admin.php'>{$lnc[107]}</a></li></ul>\n";
    }
    catcherror($config['message_off']);
}

if ($go) {
    @list($job, $itemid) = @explode('_', basename($go));
}

if (!@$itemid) {
    $itemid = 0;
}

if (!@$job) {
    $job = '';
}

$topannounce = '';

if (!$act) {
    $act = 'main';
} else {
    $act = basename($act);
}
$itemid = safe_convert($itemid);

//Load Template info
$csslocation = '';
for ($i = 0; $i < count($template['css']); $i++) {
    $csslocation .= "<link rel=\"stylesheet\" href=\"{$template['css'][$i]}\">\n";
}
$mbcon['images'] = $template['images'];

if ($permission['CP'] == '1') {
    define("ADMIN_LOGIN", 1);
}

//Scheduled publishing
scheduledpublish();

//Start Template Analyzing
$t = new template;

//Start Loading Modules
if (file_exists("inc/mod_{$act}.php")) {
    include("inc/mod_{$act}.php");
} else {
    $valid_plugins = @explode(',', $blogplugin['page']);
    if (@in_array($act, $valid_plugins) && is_file("plugin/{$act}/page.php")) { //Load whole page plugin
        include("plugin/{$act}/page.php");
        if ($plugin_closesidebar == 1) {
            $elements['mainpage'] = str_replace("class=\"content\"", "class=\"content-wide\"", $elements['mainpage']);
        }
        $bodymenu = $t->set('mainpage', [
            'pagebar'            => '',
            'iftoppage'          => 'none',
            'ifbottompage'       => 'none',
            'ifannouncement'     => 'none',
            'topannounce'        => '',
            'mainpart'           => $plugin_return,
            'previouspageexists' => '',
            'nextpageexists'     => '',
        ]);
    } else {
        include("inc/mod_main.php");
    }
}

//Section: <head>..<body>
$ajax_js = "<link rel=\"EditURI\" type=\"application/rsd+xml\" title=\"RSD\" href=\"{$config['blogurl']}/inc/rsd.php\">
<script src=\"lang/{$langfront}/jslang.js?jsver={$codeversion}\"></script>
<script src=\"images/js/ajax.js?jsver={$codeversion}\"></script>
<script src=\"images/js/swfobject.js?jsver={$codeversion}\"></script>
";

$shutajax = ($config['closeajax'] == '1') ? 1 : 0;

$ajax_js .= "<script>
var moreimagepath=\"{$template['moreimages']}\";
var shutajax={$shutajax};
var absbaseurl='{$config['blogurl']}/';
</script>
<link title=\"{$lnc[128]} {$config['blogname']}\" rel=\"search\"  type=\"application/opensearchdescription+xml\"  href=\"{$config['blogurl']}/inc/opensearch.php\">
";

$ajax_js = plugin_walk('firstheader', $ajax_js);

include_once("inc/mod_basic.php");
include_once("data/mods.php");
$extraheader = $mbcon['extraheader'] . "\n" . @implode("\n", $section_prebody);
if (!isset($pagetitle)) {
    $pagetitle = '';
}
$headerhtml = $t->set('header', [
    'blogname'     => $config['blogname'],
    'blogdesc'     => $config['blogdesc'],
    'csslocation'  => $csslocation,
    'pagetitle'    => $pagetitle,
    'ajax_js'      => $ajax_js,
    "extraheader"  => $extraheader,
    "blogkeywords" => '<!--global:{additionalkeywords}-->' . $config['blogkeywords'],
    'baseurl'      => $baseurl,
    'language'     => $langname['languagename'],
    'codeversion'  => $codeversion,
]);

//Admin notification
//$headerhtml.=$headerhtml_notifyadmin;

//Section: Top
$section_head_components = "<li>" . @implode("</li>\r\n<li>", $section_header) . "</li>";
$headmenu = $t->set('displayheader', [
    'blogname'                => $config['blogname'],
    'blogdesc'                => $config['blogdesc'],
    'section_head_components' => $section_head_components,
]);

//Where am I now?
if (defined('whereAmI')) {
    $currentpagelocation = whereAmI;
} else {
    $nav = $_SERVER["REQUEST_URI"];
    $currentpagelocation = strrchr($nav, '/');
    $spanid = str_replace('%', '_', urlencode(str_replace('.php', '', ltrim($currentpagelocation, '/'))));
    @list($currentpagelocation, $unused) = @explode('.', substr($currentpagelocation, 1));
    if ($currentpagelocation == '') {
        $currentpagelocation = 'index';
    }

    $currentpagelocation = $spanid;
}

$headmenu_tmp = str_replace([
    "<span id=\"nav_{$currentpagelocation}\">",
    "<span id=\"navitem_{$currentpagelocation}\">",
], [
    "<span id=\"nav_{$currentpagelocation}\" class=\"activepage\">",
    "<span id=\"navitem_{$currentpagelocation}\" class=\"activepageitem\">",
], $headmenu);
$headmenu = ($headmenu_tmp == $headmenu) ? str_replace(["<span id=\"nav_index\">", "<span id=\"navitem_index\">"],
    ["<span id=\"nav_index\" class=\"activepage\">", "<span id=\"navitem_index\" class=\"activepageitem\">"],
    $headmenu) : $headmenu_tmp;
//Assign an ID for current page
$currentpage_cssid = 'pagelocation-' . $currentpagelocation;
$headerhtml = str_replace('{pageID}', $currentpage_cssid, $headerhtml);

//Section: Side
if (@$plugin_closesidebar != 1) {
    if (is_array($section_sidebar)) {
        $siderbarcounter = 0;
        $sidebarcolumn = 1;
        foreach ($section_sidebar as $blocker) {
            if ($blocker['name'] == 'columnbreak') {
                $sidebarcolumn = 2;
                continue;
            }
            $blockname = "sideblock_{$blocker['name']}";
            if (isset($elements[$blockname])) {
                $sideblock = $blockname;
            } else {
                $sideblock = "sideblock";
            }

            $ifextend = @$blocker['extend'] ? 'block' : 'none';
            $decodedcontent = evalmycode(@$blocker['content']);
            $section_side_column[$sidebarcolumn][] = $t->set($sideblock, [
                'title'    => $blocker['title'],
                'content'  => $decodedcontent,
                'id'       => $blocker['name'],
                'ifextend' => $ifextend,
            ]);
            $tptvalue["block_{$blocker['name']}"] = $decodedcontent;
            $siderbarcounter += 1;
            unset($decodedcontent);
        }
        $section_side_components_one = @implode('', $section_side_column[1]);
        $section_side_components_two = @implode('', $section_side_column[2]);
        $section_side_components = $section_side_components_one . $section_side_components_two;
    }
    $sidemenu = $t->set('displayside', [
        'section_side_components_one' => $section_side_components_one,
        'section_side_components_two' => $section_side_components_two,
        'section_side_components'     => $section_side_components,
        'siderbarcounter'             => $siderbarcounter,
    ]);
} else {
    $sidemenu = '';
}

//Section: Bottom
$section_foot_components = @implode('', $section_footer);
$footmenu = $t->set('displayfooter', ['section_foot_components' => $section_foot_components]);

//Section: ..</body>
$footerhtml = $t->set('footer', []);

$displayall = [
    'headerhtml' => $headerhtml,
    'headmenu'   => $headmenu,
    'footmenu'   => $footmenu,
    'bodymenu'   => $bodymenu,
    'sidemenu'   => $sidemenu,
    'footerhtml' => $footerhtml,
];
$tt = $t->set('displayall', $displayall);

//Supplementary elements
$tptvalue['categoryplainshow'] = $categoryplainshow;

//Download time displayer
if (count($dlstat) != 0) {
    $dlchecker = @implode(',', $dlstat);
    $dlstatarray = $blog->getarraybyquery("SELECT * FROM `{$db_prefix}upload` WHERE `fid` in ($dlchecker)");
    foreach ($dlstat as $dlfid) {
        $tmp_fid = floor(array_search($dlfid, $dlstatarray['fid']));
        $tptvalue["dlstat_{$dlfid}"] = $dlstatarray['dltime'][$tmp_fid];
        $tptvalue["dlfname_{$dlfid}"] = urldecode($dlstatarray['originalname'][$tmp_fid]);
    }
}

$tt = $t->publish($tt); //2006-10-20 Add global setting support
//die($tt);

@header("Content-Type: text/html; charset=utf-8");
//vot if ($config['gzip']==1 && $act!='tag') ob_start("ob_gzhandler");

//Running time
if ($mbcon['runtime'] == 1) {
    $endtime = getmicrotime();
    $runtimeamount = $endtime - $begintime;
    $runtimeamount = floor($runtimeamount * 1000);
    $gzipplus = ($config['gzip'] == 1) ? ', Gzip enabled' : '';
    $runtimedisplay = "<script>
if (document.getElementById('processtime')) {
  document.getElementById('processtime').innerHTML=\"<span class='runtimedisplay'>Run in {$runtimeamount} ms, {$querynum} Queries{$gzipplus}.</span>\";
}
</script>";
    $tt = str_replace('</body>', $runtimedisplay . '</body>', $tt);
}
echo $tt;

//vot if ($config['gzip']==1 && $act!='tag') ob_end_flush();

function getmicrotime()
{ //Time Counting
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

