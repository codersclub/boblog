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
This file is used for URL optimization based on PHP
------------------------------------------------------- */

error_reporting(E_ALL);
//vot error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include_once("./data/config.php");
if ($config['urlrewritemethod'] != '1') {
    die("ACCESS DENIED.");
}

$q_url = $_SERVER["REQUEST_URI"];
@list($relativePath, $rawURL) = @explode('/go.php/', $q_url);
$rewritedURL = false;
$includeFile = '';

$RewriteRules = $RedirectTo = [];

$RewriteRules[] = "/page\/([0-9]+)\/([0-9]+)\/?/e";
$RewriteRules[] = "/starred\/([0-9]+)\/?([0-9]+)?\/?/e";
$RewriteRules[] = "/category\/([a-z|A-Z|0-9|_|-]+)\/?([0-9]+)?\/?([0-9]+)?\/?/e";
$RewriteRules[] = "/archiver\/([0-9]+)\/([0-9]+)\/?([0-9]+)?\/?([0-9]+)?\/?/e";
$RewriteRules[] = "/date\/([0-9]+)\/([0-9]+)\/([0-9]+)\/?([0-9]+)?\/?([0-9]+)?\/?/e";
$RewriteRules[] = "/user\/([0-9]+)\/?/e";
$RewriteRules[] = "/component\/id\/([0-9]+)\/?/e";
$RewriteRules[] = "/component\/([a-z|A-Z|0-9|_|-]+)\/?/e";
$RewriteRules[] = "/tags\/([a-z|A-Z|0-9|_|-|%]+)\/?([0-9]+)?\/?([0-9]+)?\/?/e";

$RedirectTo[] = "loadURL('index.php', ['mode'=>'\\1', 'page'=>'\\2']);";
$RedirectTo[] = "loadURL('star.php', ['mode'=>'\\1', 'page'=>'\\2']);";
$RedirectTo[] = "loadURL('index.php', ['go'=>'category_\\1', 'mode'=>'\\2', 'page'=>'\\3']);";
$RedirectTo[] = "loadURL('index.php', ['go'=>'archive', 'cm'=>'\\1', 'cy'=>'\\2', 'mode'=>'\\3', 'page'=>'\\4']);";
$RedirectTo[] = "loadURL('index.php', ['go'=>'showday_\\1-\\2-\\3', 'mode'=>'\\4', 'page'=>'\\5']);";
$RedirectTo[] = "loadURL('view.php', ['go'=>'user_\\1']);";
$RedirectTo[] = "loadURL('page.php', ['pageid'=>'\\1']);";
$RedirectTo[] = "loadURL('page.php', ['pagealias'=>'\\1']);";
$RedirectTo[] = "loadURL('tag.php', ['tag'=>'\\1', 'mode'=>'\\2', 'page'=>'\\3']);";

function loadURL($url, $pref)
{
    global $includeFile;
    if (!is_array($pref)) {
        return false;
    }
    $includeFile = basename($url);
    foreach ($pref as $p => $v) {
        global $$p;
        $$p = $v;
    }
    return true;
}

$i = 0;
foreach ($RewriteRules as $rule) {
    if (preg_match($rule, $rawURL)) {
        $rewritedURL = preg_replace($rule, $RedirectTo[$i], $rawURL, 1);
        break;
    }
    $i += 1;
}

if (!$rewritedURL || !$includeFile) {
    @header("HTTP/1.1 404 Not Found");
    if ($config['customized404']) {
        @header("Location: {$config['customized404']}");
        exit();
    } else {
        die("<html><head><title>Not Found</title></head><body><h1>HTTP/1.1 404 Not Found</h1></body></html>");
    }
}

include($includeFile);

