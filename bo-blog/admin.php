<?php
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

define('VALIDADMIN', 1);
define("noCounter", 1);

// Init variables
$adminlogstat = 0;
$admskinsel = '';
$arraychecked_permitgp = '';
$blogalias = '';
$blogpsw = '';
$cancel = '';
$comefrom = '';
$disableinvert = '';
$display_overall = '';
$editorjs = '';
$editwarntime = '';
$entrysummary = '';
$entrysummaryplus0 = '';
$entrysummaryplus1 = '';
$entrysummaryplus2 = '';
$flset = [];
$formbody = '';
$initialjs = '';
$onloadjs = '';
$originsrc = '';
$pinged = '';
$puttingcates = '';
$puttingcates_after = '';
$puttingdetail = '';
$resendping = '';
$section = '';
$selectedid_category = '';
$selectedid_sticky = '';
$selectedid_weather = '';
$submitjs = '';
$tags = '';
$tagdisable = '';
$callaftersubmit = '';

// Init the blog record
$records = [
    'blogid'       => '0',
    'title'        => '',
    'pubtime'      => '0',
    'authorid'     => '',
    'replies'      => '',
    'tbs'          => '',
    'views'        => '0',
    'property'     => '0',
    'category'     => '0',
    'tags'         => '',
    'sticky'       => '0',
    'htmlstat'     => '1',
    'ubbstat'      => '1',
    'emotstat'     => '1',
    'content'      => '',
    'editorid'     => '1',
    'edittime'     => '0',
    'weather'      => '',
    'mobile'       => '0',
    'pinged'       => '0',
    'permitgp'     => '0',
    'starred'      => '0',
    'blogpsw'      => '',
    'frontpage'    => '0',
    'entrysummary' => '',
    'comefrom'     => '',
    'originsrc'    => '',
    'blogalias'    => '',
    'pagetitle'    => '',
    'pagealias'    => '',
];

$adminclassshow = [
    'entry'      => '',
    'category'   => '',
    'link'       => '',
    'reply'      => '',
    'user'       => '',
    'addon'      => '',
    'misc'       => '',
    'main'       => '',
    'carecenter' => '',
];

require_once("global.php");
include_once("lang/{$langback}/backend.php");
include_once("data/allmods.php");
include("data/cache_usergroup.php");
require_once("admin/cache_func.php");

$blogplugin = $plugin_onload = $plugin_header = null;

include_once("data/plugin_enabled.php");

if ($logstat !== 1) {
    @header("Location: ./login.php");
    exit();
}

if ($adminlogstat !== 1) {
    @header("Location: ./login.php?adminlogin=1");
    exit();
}

acceptrequest('act,go,page');

if (!isset($page) || !is_numeric($page) || $page <= 0) {
    $page = 1;
} else {
    $page = floor($page);
}

if ($go) {
    @list($act, $job, $itemid) = @explode('_', basename($go));
}

if (!$act) {
    $act = 'main';
} else {
    $act = basename($act);
}

if ($act == 'upload') {
    include("admin/cp_upload.php");
    exit();
}

$maxrecord = $blog->getsinglevalue("{$db_prefix}maxrec");

include_once("admin/admin_header.php");

//Start Loading Modules
if (file_exists("admin/cp_{$act}.php")) {
    if ($act != 'edit' && $act != 'entry') {
        checkpermission('CP');
    }
    include("admin/cp_{$act}.php");
} else {
    $realact = $actgoto = '';
    @list($realact, $actgoto) = @explode('::', $act);
    $actgotofile = ($actgoto) ? "plugin/" . basename($realact) . "/admin_" . basename($actgoto) . ".php" : "plugin/" . basename($realact) . "/admin.php";
    if (is_file($actgotofile)) {
        $display_overall .= highlightadminitems('plugin', 'addon');
        checkpermission('CP');
        include($actgotofile);
        $display_overall .= $plugin_return;
    } else {
        include("admin/cp_main.php");
    }
}

$display_overall = str_replace('<!--plugin_header-->', $plugin_header, $display_overall);
$display_overall = str_replace('<body', '<body ' . $plugin_onload, $display_overall);
include_once("admin/admin_footer.php");

//Starting Admin-only functions
function highlightadminitems($itemhighlight, $itemsrow)
{
    global $admin_item;
    $str = "<script>
	function adminitemhover(hovername, obj) {
		if (document.getElementById('dropmenudiv') && document.getElementById('hoveritem_'+hovername)) {
		    document.getElementById('dropmenudiv').innerHTML=document.getElementById('hoveritem_'+hovername).innerHTML;
		}
		if ((is_ie || is_ie4) && !is_ie8) {
		    document.getElementById('dropmenudiv').innerHTML+=\"<iframe src='javascript:false' style='position:absolute; visibility:inherit; top:0px; left:0px; width:128px; height:200px; z-index:-1; filter=progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0);'></iframe>\";
		}
		dropdownmenu(obj);
	}
	</script>";
    return ("\n{$str}\n<div id=\"adminmain\" onmouseover=\"hidemenu();\"><div id=\"admininner\">");
}

function addpref($pref_type, $pref_content)
{ //This will generate the complete config form body
    global $pref_leftchar, $pref_variable, $pref_result, $pref_quicksel, $prefseccounter;
    if ($pref_leftchar == '') {
        $pref_leftchar = 200;
    }
    global $$pref_variable;
    $prefvalue = $$pref_variable;
    $prefs = @explode("|", $pref_content);

    if (!isset($prefs[1])) {
        $prefs[1] = '';
    }
    if (!isset($prefs[2])) {
        $prefs[2] = '';
    }
    if (!isset($prefs[3])) {
        $prefs[3] = '';
    }
    if (!isset($prefs[4])) {
        $prefs[4] = '';
    }

    if (!isset($prefvalue[$prefs[0]])) {
        $prefvalue[$prefs[0]] = '';
    }

    switch ($pref_type) {
        case 't': //text input
            $output = "  <tr>
    <td class=\"prefleft\" valign=\"top\" width='$pref_leftchar'>{$prefs[1]}</td>
    <td class=\"prefright\">
      <input type='text' name='prefconfig[{$prefs[0]}]' id='{$prefs[0]}' value=\"" . stripslashes($prefvalue[$prefs[0]]) . "\" size='40'>
      {$prefs[2]}
    </td>
  </tr>\n";
            break;
        case 'ta': //textarea
            $output = "  <tr>
    <td class=\"prefleft\" valign=\"top\" width='$pref_leftchar'>{$prefs[1]}</td>
    <td class=\"prefright\">
      <textarea  name='prefconfig[{$prefs[0]}]' id='{$prefs[0]}' cols='90' rows='6'>" . stripslashes($prefvalue[$prefs[0]]) . "</textarea>
      {$prefs[2]}
    </td>
  </tr>\n";
            break;
        case 'r': //radio button
            $check1 = ($prefvalue[$prefs[0]] == 1) ? " checked='checked' " : '';
            $check2 = ($prefvalue[$prefs[0]] == 1) ? '' : " checked='checked' ";
            $output = "  <tr>
    <td class=\"prefleft\" valign=\"top\" width='$pref_leftchar'>{$prefs[1]}</td>
    <td class=\"prefright\">
      <input type='radio' name='prefconfig[{$prefs[0]}]' id='{$prefs[0]}' value='1' {$check1}>{$prefs[3]}
      <input type='radio' name='prefconfig[{$prefs[0]}]' id='{$prefs[0]}' value='0' {$check2}>{$prefs[2]} {$prefs[4]}
    </td>
  </tr>\n";
            break;
        case 'sel': //selection
            $tmp_sel = "  <tr>
    <td class=\"prefleft\" valign=\"top\" width='$pref_leftchar'>{$prefs[1]}</td>
    <td class=\"prefright\">
      <select name='prefconfig[{$prefs[0]}]' id='{$prefs[0]}'>\n";

            $current_sel_all = @explode("<<", $prefs[2]);
            for ($i = 0; $i < count($current_sel_all); $i++) {
                $current_sel = @explode(">>", $current_sel_all[$i]);
                if ($current_sel[0] == $prefvalue[$prefs[0]]) {
                    $seled = " selected";
                } else {
                    $seled = '';
                }
                $tmp_sel .= "        <option value='{$current_sel[0]}' {$seled}>{$current_sel[1]}</option>";
            }
            $tmp_sel .= "      </select> {$prefs[3]}
    </td>
  </tr>\n";
            $output = $tmp_sel;
            unset($tmp_sel, $current_sel_all);
            break;
        case 'sec': //A separator
            $output = "  <tr>
    <td class=\"prefsection\" align=\"center\" colspan='2'>
      <a name=\"pref{$prefseccounter}\"></a>{$prefs[0]}
      [
      <a href=\"#top\">
        <img src=\"images/arrows/singleup.gif\" alt=\"\" title=\"TOP\" align=\"absmiddle\" border=\"0\">
      </a>
      <a href=\"#bottom\">
        <img src=\"images/arrows/singledown.gif\" alt=\"\" title=\"BOTTOM\" align=\"absmiddle\" border=\"0\">
      </a>
      ]
    </td>
  </tr>\n";
            if ($prefseccounter % 5 == 0) {
                $pref_quicksel .= "  <tr align='left'>\n";
            }
            $pref_quicksel .= "    <td width=20%>
      [<a href=\"#pref{$prefseccounter}\">{$prefs[0]}</a>]
    </td>\n";
            if ($prefseccounter % 5 == 4) {
                $pref_quicksel .= "  </tr>\n";
            }
            $prefseccounter += 1;
            break;
    }
    $pref_result[] = $output;
}

// Change a single value for config
function changesingleconfig($configname, $value, $configtype = 'mbcon', $configfile = 'data/mod_config.php')
{
    global $$configtype, $lnc;
    $rar = $$configtype;
    $rar[$configname] = $value;
    $savetext = "<?php\n";
    foreach ($rar as $key => $val) {
        $savetext .= "\${$configtype}['{$key}']='" . safe_convert(stripslashes($val)) . "';\n";
    }
    if (writetofile($configfile, $savetext)) {
        return true;
    } else {
        catcherror($lnc[7] . $configfile);
    }
}

//Partially change the content of a file
function replaceblock($filename, $blockidentifier, $newvalues)
{
    $oldfilecontent = @file_get_contents($filename);
    $inthebeginning = "//[Start]{$blockidentifier}";
    $intheend = "//[End]{$blockidentifier}";
    @list($thebeginningpart, $tobereplaced) = @explode($inthebeginning, $oldfilecontent);
    @list($tobereplaced, $theendpart) = @explode($intheend, $oldfilecontent);
    $newvalues = $inthebeginning . "\r\n" . $newvalues . "\r\n" . $intheend . "\r\n";
    $newcontent = $thebeginningpart . $newvalues . $theendpart;
    $newcontent = str_replace("\r\n\r\n", "\r\n", $newcontent);
    return writetofile($filename, $newcontent);
}

function mod_append($value)
{
    global $lnc;
    $filename = "data/modules.php";
    $filecontent = @file_get_contents($filename);
    $value = "/*--APPENDAREA--*/\n" . $value . "\n";
    $filecontent = str_replace("/*--APPENDAREA--*/", $value, $filecontent);
    $filecontent = str_replace("\n\n", "\n", $filecontent);
    if (writetofile($filename, $filecontent)) {
        return true;
    } else {
        catcherror($lnc[7] . $filename);
    }
}

function mod_replace($name, $value, $mustchange = false)
{
    global $lnc;
    $filename = "data/modules.php";
    $filecontent = @file($filename);
    $changed = false;
    for ($i = 0; $i < count($filecontent); $i++) {
        if (strstr($filecontent[$i], "\$blogitem['{$name}']=")) {
            $filecontent[$i] = $value;
            $changed = true;
            break;
        }
    }
    if ($mustchange && !$changed) {
        $filecontent[] = $value;
    }
    $newfilecontent = @implode('', $filecontent);
    if (writetofile($filename, $newfilecontent)) {
        return true;
    } else {
        catcherror($lnc[7] . $filename);
    }
}

function gen_page($page, $numperline, $returnurl, $totalvolume, $perpagevolume)
{
    global $lnc;
    $conxer = (strstr($returnurl, '?')) ? '&amp;' : '?';
    $total_pages = floor(($totalvolume - 1) / $perpagevolume) + 1;
    if (empty($total_pages)) {
        return '';
    }
    $pagebar = '';
    $firstindexpage = floor($page / $numperline) * $numperline + 1;
    $lastindexpage = min(($firstindexpage + $numperline - 1), $total_pages);
    $pagebar .= " {$lnc[8]} {$page}/{$total_pages} ";
    $pagebar .= " <a href=\"{$returnurl}{$conxer}page=1\"><img src=\"images/arrows/doubleleft.gif\" alt=\"{$lnc[9]}\" title=\"{$lnc[9]}\" border=\"0\"></a> ";
    if ($page != 1) {
        $pagebar .= " <a href=\"{$returnurl}{$conxer}page=" . ($page - 1) . "\"><img src=\"images/arrows/singleleft.gif\" alt=\"{$lnc[10]}\" title=\"{$lnc[10]}\" border=\"0\"></a> ";
    }
    for ($i = $firstindexpage; $i <= $lastindexpage; $i++) {
        if ($i != $page) {
            $pagebar .= " <a href=\"{$returnurl}{$conxer}page={$i}\">[{$i}]</a> ";
        } else {
            $pagebar .= " <span class=\"pagelink-current\">[{$i}]</span> ";
        }
    }
    if ($page != $total_pages) {
        $pagebar .= " <a href=\"{$returnurl}{$conxer}page=" . ($page + 1) . "\"><img src=\"images/arrows/singleright.gif\" alt=\"{$lnc[11]}\" title=\"{$lnc[11]}\" border=\"0\"></a> ";
    }
    $pagebar .= " <a href=\"{$returnurl}{$conxer}page={$total_pages}\"><img src=\"images/arrows/doubleright.gif\" alt=\"{$lnc[12]}\" title=\"{$lnc[12]}\" border=\"0\"></a> ";
    return $pagebar;
}

function check_upload_file($filename)
{ //Check if the file contains dangerous characters
    $danger = ['fopen', 'fsockopen', 'writetofile', 'unlink', 'exec', 'eval'];
    if (!file_exists($filename)) {
        return true;
    }
    $content = @file_get_contents($filename);
    foreach ($danger as $checker) {
        if (stristr($content, $checker)) {
            return false;
        }
    }
    return $content;
}

function phpcode($match)
{ //Convert HTML chars into entities for [CODE]
    //Note: string in the result of preg_match will be partly escaped
    //Strangely, only double quotes are added with a slash
    $str = $match[1];
    $str = str_replace("\\\"", '"', $str);

    //Now continue to escape other characters
    $str = htmlspecialchars($str, ENT_QUOTES);
    $str = str_replace('[', '&#91;', $str);
    $str = str_replace(']', '&#93;', $str);
    return "[code]{$str}[/code]";
}

function phpcode2($match)
{ //Convert HTML chars into entities for [CODE]
    $str = $match[1];
    $str = str_replace("\\\"", '"', $str);
    $str = str_replace('[', '&#91;', $str);
    $str = str_replace(']', '&#93;', $str);
    return "[code]{$str}[/code]";
}

function phpcode3($match)
{ //Encode the code for highlight purpose
    $str = $match[1];
    $str = str_replace("\\\"", '"', $str);
    $str = base64_encode($str);
    return "[php]{$str}[/php]";
}

function phpcode4($match)
{ //Encode the code for highlight purpose
    $str = $match[1];
    $str = base64_decode($str);
    $str = htmlspecialchars($str);
    return "[php]{$str}[/php]";
}

function admin_convert($str)
{
    global $mqgpc_status;
    $str = stripslashes($str);
    $str = str_replace("\r", '', $str);
    $str = str_replace("\n", '', $str);
    $str = str_replace("'", "\'", $str);
    return $str;
}

function confirmpsw()
{ //Temporarily discarded
    /*	global $logstat, $config, $ajax, $lna, $db_tmpdir, $userdetail, $db_defaultsessdir;
        if ($config['noadminsession']=='1') return;
        if ($db_defaultsessdir!=1) session_save_path("./{$db_tmpdir}");
        session_cache_limiter("private, must-revalidate");
        session_start();
        if ($_SESSION['admin_userid']!==$userdetail['userid'] || $_SESSION['admin_psw']!==$userdetail['userpsw']) {
            if ($ajax=='on') catcherror ($lna[951]);
            $loginjob=($logstat==1) ? 'adminlog' : '';
            header ("Location: login.php?job={$loginjob}");
            exit();
        }
    */
    return;
}

function checksafe($str)
{
    $array_searches = [
        'fopen',
        'eval',
        'fsockopen',
        '_COOKIE',
        '_SESSION',
        'writetofile',
        'fwrite',
        'fput',
        'exec',
        'Location',
        'opendir',
        'readdir',
        'unlink',
        'rmdir',
        'mkdir',
        'chmod',
        'rename',
        'mysql_',
        'mysqli_',
        'file_get_contents',
        'file_put_contents',
        'tmpfile',
        'copy',
    ];
    return preg_search($str, $array_searches);
}

function reArrayFiles($file_post)
{
    $file_ary = [];
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}

function blogalias_convert($str, $rewrite = 0)
{
    if ($rewrite == 0) {
        $str = str_replace([' ', "'", '"'], '', $str);
        $str = urlencode($str);
    } else {
        $str = str_replace(['_', '.'], ["\\_", "\\."], $str);
    }
    return $str;
}
