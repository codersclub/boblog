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

if (!defined('VALIDREQUEST')) {
    die ('Access Denied.');
}

acceptrequest('pageid,pagealias');
$itemid = ($pagealias) ? safe_convert($pagealias) : floor($pageid);

$m_b = new getblogs;
$records = ($pagealias) ? $m_b->getgroupbyquery("SELECT * FROM `{$db_prefix}pages` WHERE `pagealias`='{$itemid}'") : $m_b->getgroupbyquery("SELECT * FROM `{$db_prefix}pages` WHERE `pageid`='{$itemid}'");

if (is_array($records)) {
    $section_body_main = $m_b->output_page($records[0]);
} else {
    catcherror($lnc[186]);
}

//Load plugins
$section_body_main[0] = plugin_get('custompagebegin') . $section_body_main[0];
$section_body_main[] = plugin_get('custompageend');

$plugin_closesidebar = ($records[0]['closesidebar'] == 1) ? 0 : 1;

if ($plugin_closesidebar == 1) {
    $elements['mainpage'] = str_replace("class=\"content\"", "class=\"content-wide\"", $elements['mainpage']);
}

$ifannouncement = "none";
$bodymenu = $t->set('mainpage', [
    'pagebar'            => '',
    'iftoppage'          => 'none',
    'ifbottompage'       => 'none',
    'ifannouncement'     => 'none',
    'topannounce'        => '',
    'mainpart'           => @implode('', $section_body_main),
    'previouspageexists' => '',
    'nextpageexists'     => '',
]);

$pagetitle = "{$records[0]['pagetitle']} - ";
