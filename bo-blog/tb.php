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
------------------------------------------------------- */

define("noCounter", 1);
require_once("global.php");
include_once("data/mod_config.php");

if ($mbcon['allowtrackback'] != 1) {
    tb_xml_error('Trackback is disabled.');
}

acceptrequest('t,extra');
$t = (integer)$t;
if ($t < 0) {
    tb_xml_error("Invalid ID.");
}
$v_id = $t;
unset($t);
//$rawdata=get_http_raw_post_data();
//die ($rawdata);

//Detect Charset
$charset_convert = 0;
$charset = strtolower($_SERVER['HTTP_ACCEPT_CHARSET']);
if ($charset && !strstr($charset, 'utf-8')) {
    if (strstr($charset, 'gb') || strstr($charset, 'big5')) {
        tb_xml_error("Your trackback uses a charset other than UTF-8.");
    }
}

$originblog = $blog->getbyquery("SELECT * FROM `{$db_prefix}blogs` WHERE `blogid`='{$v_id}' AND `property`=0 LIMIT 0,1");
if ($originblog['blogid'] != $v_id) {
    tb_xml_error("Invalid ID or the ID refers to a locked entry.");
}

//Anti-spam
$tbauthentic = tbcertificate($originblog['blogid'], $originblog['pubtime']);
if ($tbauthentic != $extra) {
    tb_xml_error("Verifying failed.");
}

acceptrequest('title,excerpt,url,blog_name');
$sourceforcheck = array('title' => $title, 'excerpt' => $excerpt, 'url' => $url, 'blog_name' => $blog_name);
if ($url == '') {
    tb_xml_error("Invalid URL.");
} else {
    $url = safe_convert($url);
}
if ($excerpt == '') {
    tb_xml_error("We require all Trackbacks to provide an excerption.");
} else {
    $excerpt = tb_convert($excerpt);
}
$title = mb_substr($title, 0, $mbcon['maxtblen']);
$blog_name = mb_substr($blog_name, 0, $mbcon['maxtblen']);
$excerpt = mb_substr($excerpt, 0, $mbcon['maxtblen']);
$title = ($title) ? tb_convert($title) : $lnc[13];
$blog_name = ($blog_name) ? tb_convert($blog_name) : $lnc[14];

//Check unacceptable words
$setspam = 0;
extract_forbidden();
if (check_ip($userdetail['ip'], $forbidden['banip'])) {
    tb_xml_error("Your IP address is banned from sending trackbacks.");
}
if (preg_search($excerpt, $forbidden['banword']) ||
    preg_search($title, $forbidden['banword']) ||
    preg_search($blog_name, $forbidden['banword'])) {
    tb_xml_error("The trackback content contains some words that are not welcomed on our site. You may edit your post and send it again. Sorry for the inconvenience.");
}
if ($mbcon['antispam'] == '1') {
    if (preg_search($excerpt, $forbidden['suspect'])) {
        $setspam = 1;
    }
}

//Trackback scoring defense mechanism
//The idea of this part is the result of discussion with Security Angel (www.4ngel.net). The original code was originally created by 4ngel.
//Under test
$point = 0;
if ($mbcon['tbfilter'] == 3) { //If manual review
    $setspam = 1;
} elseif ($mbcon['tbfilter'] != 0) { //If not open

    if ($mbcon['tbfilter'] == 2) {
        // Strong prevention: check the way
        $source_content = '';
        if (!empty($sourceforcheck['url'])) {
            $source_content = @fopen_url($sourceforcheck['url'], true);
        }
        if (empty($source_content)) {
            //-1 point if you don't get the original code
            $point -= 1;
        } else {
            if (strpos(strtolower($source_content), strtolower($this_server)) !== false) {
                //Comparing the link, if the hostname of this site is included in the original code then add +1 point, this may not be true
                $point += 1;
            }
            if (strpos(strtolower($source_content), strtolower($sourceforcheck['title'])) !== false) {
                //Comparing the title, if the original code contains the sent title, it will be +1 point, this basically can be established
                $point += 1;
            }
            if (strpos(strtolower($source_content), strtolower($sourceforcheck['excerpt'])) !== false) {
                //Comparing the content, if the original code contains the sent excerpt, then +1 point, this may not be true due to tags or other reasons
                $point += 1;
            }
        }
    }

    $tbinterval = ($mbcon['tbfilter'] == 1) ? '30' : '60';

    //Set the time interval according to the defense strength. If it is strong, it is found that the same IP is sent within 30 seconds. If it is weak, it is found that the same IP is sent within 60 seconds.
    $trytb = $blog->countbyquery("SELECT COUNT(*) FROM `{$db_prefix}replies` WHERE `repip`='{$userdetail['ip']}' AND `reproperty`>=4 AND `reptime`+{$tbinterval}>='" . time() . "'");

    //Number of times sent in the time period
    if ($trytb > 0) {
        //If it is found that the number of times the same IP is sent in a unit time is greater than 0, one point will be deducted. Is there any manual sending of trackbacks so quickly?
        $point -= 1;
    }

    if ($mbcon['tbfilter'] == 2) {
        // Strong prevention: CUT if the final score is less than 1 point!
        $setspam = (($point < 1) ? 1 : 0);
    } else {
        // Weak prevention: CUT is only when the final score is less than 0 points!
        $setspam = (($point < 0) ? 1 : 0);
    }
}

//Final result
$tbproperty = ($setspam == 1) ? 5 : 4;

//Input
define('REPLYSPECIAL', 1);
include("admin/cache_func.php");
$maxrecord = $blog->getsinglevalue("{$db_prefix}maxrec");
$currentmaxid = $maxrecord['maxrepid'] + 1;
$reptime = time();
$blog->query("INSERT INTO  `{$db_prefix}replies` VALUES ('{$currentmaxid}', '{$tbproperty}', '{$v_id}', '{$reptime}', '-1', '{$blog_name}', '{$title}', '{$url}', '{$userdetail['ip']}', '{$excerpt}', '0', '0', '0', '0', '', '0', '', '0', '', '0', '', '', '', '', '', '', '', '')");
$blog->query("UPDATE `{$db_prefix}maxrec` SET `maxrepid`='{$currentmaxid}'");
if ($setspam == 0) {
    $blog->query("UPDATE `{$db_prefix}counter` SET `tb`=`tb`+1");
    $blog->query("UPDATE `{$db_prefix}blogs` SET `tbs`=`tbs`+1 WHERE `blogid`='{$v_id}'");
    recache_latestreplies();
}

tb_xml_success();

function tb_xml_error($error)
{
    header("Content-type:application/xml");
    echo "<?xml version=\"1.0\" ?>";
    print <<<eot
<response>
<error>1</error>
<message>{$error}</message>
</response>
eot;
    exit;
}

function tb_xml_success()
{
    header("Content-type:application/xml");
    echo "<?xml version=\"1.0\" ?>";
    print <<<eot
<response>
<error>0</error>
</response>
eot;
    exit;
}

function tb_convert($str)
{
    $str = safe_convert($str);
    $str = preg_replace("/&(.+?);/is", "", $str);
    $str = preg_replace("/\[(.+?)\]/is", "", $str);
    $str = str_replace("\\", "", $str);
    return $str;
}

function fopen_url($url, $convert_case = false)
{
    $file_content = '';

    $surl = parse_url($url);
    if ($surl['port'] == '') {
        $surl['port'] = 80;
    }
    $fp = fsockopen($surl['host'], $surl['port'], $errno, $errstr, 8);
    if ($fp) {
        $out = "GET {$surl['path']}" . ($surl['query'] ? '?' . $surl['query'] : '') . " HTTP/1.1\r\n";
        $out .= "Host: {$surl['host']}\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        while (!feof($fp)) {
            $file_content .= fgets($fp, 128);
        }
        fclose($fp);
    }

//Alternatives using fopen instead of fsockopen, not activated by default
    /*	if($file = @fopen($url, 'r')){
            $i = 0;
            while (!feof($file) && $i++ < 1000) {
                if ($convert_case) {
                    $file_content .= strtolower(fread($file, 4096));
                } else {
                    $file_content .= fread($file, 4096);
                }
            }
            fclose($file);
        } elseif (function_exists('file_get_contents')) {
            $file_content = @file_get_contents($url);
        }
        elseif (function_exists('curl_init')) {
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT,2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl_handle, CURLOPT_FAILONERROR,1);
              curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Trackback Spam Check');
            $file_content = curl_exec($curl_handle);
            curl_close($curl_handle);
        }
        else {
            $file_content = '';
        }
    */
    return $file_content;
}
