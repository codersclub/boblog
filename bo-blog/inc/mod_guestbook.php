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

if (@$flset['guestbook'] == 1) {
    getHttp404($lnc[313]);
}

$m_b = new getblogs;

if ($permission['LeaveMessage'] == 1) {
    $section_body_main = $m_b->make_visit_form($lnc[129], '', "visit.php?job=addmessage");
    $section_body_main .= "<a name='topreply'></a><div id='addnew'></div>";
}

$replyrecords = $m_b->reply_record_array($mbcon['messageperpage'], $page);
if ($replyrecords[0]['repid'] != '') {
    $section_body_main .= $m_b->make_messages($replyrecords);
    $innerpages = $m_b->make_pagebar(
        $page,
        $mbcon['pagebaritems'],
        "guestbook.php",
        $statistics['messages'],
        $mbcon['messageperpage']
    );
}
if ($page == 1) {
    announcebar();
} else {
    $ifannouncement = 'none';
}
$bodymenu = $t->set('mainpage', [
    'pagebar'            => $innerpages,
    'iftoppage'          => 'none',
    'ifbottompage'       => 'display',
    'ifannouncement'     => $ifannouncement,
    'topannounce'        => $topannounce,
    'mainpart'           => $section_body_main,
    'currentpage'        => $pageitems['currentpage'],
    'previouspageurl'    => $pageitems['previouspageurl'],
    'nextpageurl'        => $pageitems['nextpageurl'],
    'turningpages'       => $pageitems['turningpages'],
    'totalpages'         => $pageitems['totalpages'],
    'previouspageexists' => $pageitems['previouspageexists'],
    'nextpageexists'     => $pageitems['nextpageexists'],
]);

$pagetitle = "{$lnc[91]} - ";

LRSC_init('guestbook'); //2011/2/20
