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

$formbody = '';

if ($job == 'user') {
    checkpermission('ViewUserDetail');
    include_once("data/cache_usergroup.php");
    if ($itemid === '') {
        catcherror($lnc[193]);
    }
    $nowuser = $blog->getbyquery("SELECT * FROM `{$db_prefix}user` WHERE `userid`='$itemid'");
    if (!$nowuser) {
        catcherror($lnc[193]);
    }
    $usergp_tmp = $nowuser['usergroup'];
    $tmp_gender = $nowuser['gender'];
    $nowuser['email'] = (trim($nowuser['email']) == '') ? $lnc[141] : "<a href=\"mailto:{$nowuser['email']}\">{$lnc[18]}</a>";
    $nowuser['homepage'] = (trim($nowuser['homepage']) == '') ? $lnc[141] : "<a href=\"{$nowuser['homepage']}\" target=\"_blank\">{$lnc[19]}</a>";

    $t = new template;
    $formbody .= $t->set('form_eachline', [
        'text' => $lnc[132],
	'formelement' => $nowuser['username'] . " &nbsp; [" . $usergp[$usergp_tmp] . "]"
    ]);
    $formbody .= $t->set('form_eachline', [
	'text' => $lnc[139],
	'formelement' => $nowuser['email']
    ]);
    $formbody .= $t->set('form_eachline', [
	'text' => $lnc[140],
	'formelement' => $nowuser['homepage']
    ]);
    $sex_sel = [
	'0' => $lnc[141],
	'1' => $lnc[142],
	'2' => $lnc[143]
    ];
    $formbody .= $t->set('form_eachline', [
	'text' => $lnc[144],
	'formelement' => $sex_sel[$tmp_gender]
    ]);
    $formbody .= $t->set('form_eachline', [
	'text' => $lnc[145],
	'formelement' => stripslashes($nowuser['qq'])
    ]);
    $formbody .= $t->set('form_eachline', [
	'text' => 'MSN',
	'formelement' => stripslashes($nowuser['msn'])
    ]);
    $formbody .= $t->set('form_eachline', [
	'text' => 'Skype',
	'formelement' => stripslashes($nowuser['skype'])
	]);
    $formbody .= $t->set('form_eachline', [
        'text' => $lnc[146],
	'formelement' => stripslashes($nowuser['fromplace'])
    ]);
    $formbody .= $t->set('form_eachline', [
	'text' => $lnc[147],
	'formelement' => stripslashes($nowuser['intro'])
    ]);
    $section_table = $t->set('normaltable', [
	'tablebody' => $formbody
    ]);
    $section_body_main = $t->set('contentpage', [
	'title' => $lnc[194],
	'contentbody' => $section_table
    ]);
    announcebar();
    $bodymenu = $t->set('mainpage', [
        'pagebar'            => '',
        'iftoppage'          => 'none',
        'ifbottompage'       => 'none',
        'ifannouncement'     => $ifannouncement,
        'topannounce'        => $topannounce,
        'mainpart'           => $section_body_main,
        'currentpage'        => '',
        'previouspageurl'    => '',
        'nextpageurl'        => '',
        'turningpages'       => '',
        'totalpages'         => '',
        'previouspageexists' => '',
        'nextpageexists'     => '',
    ]);
}

if ($job == 'links') {
    $t = new template;
    $linkgp = $blog->getgroupbyquery("SELECT * FROM `{$db_prefix}linkgroup` ORDER BY `linkgporder`");
    $links = $blog->getgroupbyquery("SELECT * FROM `{$db_prefix}links` ORDER BY `linkorder`");
    if ($links && is_array($links)) {
        $mbcon['linkperpage'] = ($mbcon['linkperpage'] > 0) ? floor($mbcon['linkperpage']) : 2;
        $linkeachcloumn = floor(100 / $mbcon['linkperpage']) . '%';
        $rowcount = [];
        foreach ($links as $linkeachitem) {
            unset ($tmp_gp, $tmp_displayitem);
            $tmp_gp = $linkeachitem['linkgptoid'];
            $alllinks[$tmp_gp] = '';
            if ($linkeachitem['linklogo']) {
                $displayitemlogo = "<img src=\"{$linkeachitem['linklogo']}\" alt=\"{$linkeachitem['linkname']}\" border=\"0\">";
            } else {
                $displayitemlogo = '';
            }
            if (empty($rowcount[$tmp_gp])) {
                $rowcount[$tmp_gp] = 1;
                $alllinks[$tmp_gp] .= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
            }
            if ($rowcount[$tmp_gp] % $mbcon['linkperpage'] == 1) {
                $alllinks[$tmp_gp] .= "  <tr valign=\"top\">\n";
            }
            $alllinks[$tmp_gp] .= "    <td width=\"{$linkeachcloumn}\">\n";
            $alllinks[$tmp_gp] .= $t->set('eachlink', [
                'logo'  => $displayitemlogo,
                'title' => "<a href=\"{$linkeachitem['linkurl']}\" target=\"_blank\">{$linkeachitem['linkname']}</a>",
                'desc'  => $linkeachitem['linkdesc'],
            ]);
            $alllinks[$tmp_gp] .= "    </td>\n";
            if ($rowcount[$tmp_gp] % $mbcon['linkperpage'] == 0) {
                $alllinks[$tmp_gp] .= "  </tr>\n";
            }
            $rowcount[$tmp_gp] += 1;
        }
    }

    if ($linkgp && is_array($linkgp)) {
        foreach ($linkgp as $linkgpeachitem) {
            unset ($tmp_gp);
            $tmp_gp = $linkgpeachitem['linkgpid'];
            $alllinks[$tmp_gp] .= ($alllinks[$tmp_gp]) ? '</table>' : '';
            $displaygp[$tmp_gp] = $t->set('linkdiv', [
                'title' => $linkgpeachitem['linkgpname'],
		'tablebody' => $alllinks[$tmp_gp]
	    ]);
        }
    } else {
        $displaygp[] = $lnc[195];
    }
    $section_table = @implode('', $displaygp);
    $section_body_main = $t->set('contentpage', [
	'title' => $lnc[94],
	'contentbody' => $section_table
    ]);
    announcebar();
    $bodymenu = $t->set('mainpage', [
        'pagebar'            => '',
        'iftoppage'          => 'none',
        'ifbottompage'       => 'none',
        'ifannouncement'     => $ifannouncement,
        'topannounce'        => $topannounce,
        'mainpart'           => $section_body_main,
        'currentpage'        => '',
        'previouspageurl'    => '',
        'nextpageurl'        => '',
        'turningpages'       => '',
        'totalpages'         => '',
        'previouspageexists' => '',
        'nextpageexists'     => '',
    ]);
}

if ($job == 'comment') {
    $start_id = ($page - 1) * $mbcon['replyperpage'];
    $records = $blog->getgroupbyquery("SELECT t1.*, t2.title, t2.blogalias FROM `{$db_prefix}replies` t1 INNER JOIN `{$db_prefix}blogs` t2 ON t2.blogid=t1.blogid WHERE t1.reproperty<=1 AND t2.property<2 ORDER BY t1.reptime DESC LIMIT {$start_id}, {$mbcon['replyperpage']}");
    for ($i = 0; $i < count($records); $i++) {
        $records[$i]['repcontent'] = "<strong>{$lnc[71]}</strong>
            <a href=\"" . getlink_entry($records[$i]['blogid'], $records[$i]['blogalias']) . "\">{$records[$i]['title']}</a>
            <br>
            <strong>{$lnc[76]}</strong>\n" . $records[$i]['repcontent'];
    }
    $m_b = new getblogs;
    if (is_array($records)) {
        $section_body_main[] = $m_b->make_replies($records);
        $innerpages = $m_b->make_pagebar($page, $mbcon['pagebaritems'], "view.php?go=comment", $statistics['replies'],
            $mbcon['replyperpage']);
    }

    $iftoppage = ($mbcon['pagebarposition'] == 'down') ? 'none' : 'block';
    $ifbottompage = ($mbcon['pagebarposition'] == 'up') ? 'none' : 'block';

    announcebar();
    $bodymenu = $t->set('mainpage', [
        'pagebar'            => $innerpages,
        'iftoppage'          => $iftoppage,
        'ifbottompage'       => $ifbottompage,
        'ifannouncement'     => $ifannouncement,
        'topannounce'        => $topannounce,
        'mainpart'           => @implode('', $section_body_main),
        'currentpage'        => $pageitems['currentpage'],
        'previouspageurl'    => $pageitems['previouspageurl'],
        'nextpageurl'        => $pageitems['nextpageurl'],
        'turningpages'       => $pageitems['turningpages'],
        'totalpages'         => $pageitems['totalpages'],
        'previouspageexists' => $pageitems['previouspageexists'],
        'nextpageexists'     => $pageitems['nextpageexists'],
    ]);
    $pagetitle = "{$lnc[196]} - ";
}

if ($job == 'tb') {
    $start_id = ($page - 1) * $mbcon['replyperpage'];
    $records = $blog->getgroupbyquery("SELECT t1.*, t2.title, t2.blogalias FROM `{$db_prefix}replies` t1 INNER JOIN `{$db_prefix}blogs` t2 ON t2.blogid=t1.blogid WHERE t1.reproperty='4' ORDER BY t1.reptime DESC LIMIT {$start_id}, {$mbcon['replyperpage']}");
    for ($i = 0; $i < count($records); $i++) {
        $records[$i]['repemail'] = "{$lnc[197]} <a href=\"" . getlink_entry($records[$i]['blogid'],
                $records[$i]['blogalias']) . "\">{$records[$i]['title']}</a>";
    }
    $m_b = new getblogs;
    if (is_array($records)) {
        $section_body_main[] = $m_b->make_replies($records);
        $innerpages = $m_b->make_pagebar($page, $mbcon['pagebaritems'], "view.php?go=tb", $statistics['tb'],
            $mbcon['replyperpage']);
    }

    $iftoppage = ($mbcon['pagebarposition'] == 'down') ? 'none' : 'block';
    $ifbottompage = ($mbcon['pagebarposition'] == 'up') ? 'none' : 'block';

    announcebar();
    $bodymenu = $t->set('mainpage', [
        'pagebar'            => $innerpages,
        'iftoppage'          => $iftoppage,
        'ifbottompage'       => $ifbottompage,
        'ifannouncement'     => $ifannouncement,
        'topannounce'        => $topannounce,
        'mainpart'           => @implode('', $section_body_main),
        'currentpage'        => $pageitems['currentpage'],
        'previouspageurl'    => $pageitems['previouspageurl'],
        'nextpageurl'        => $pageitems['nextpageurl'],
        'turningpages'       => $pageitems['turningpages'],
        'totalpages'         => $pageitems['totalpages'],
        'previouspageexists' => $pageitems['previouspageexists'],
        'nextpageexists'     => $pageitems['nextpageexists'],
    ]);
    $pagetitle = "{$lnc[198]} - ";
}

if ($job == 'userlist') {
    checkpermission('ViewUserList');
    acceptrequest('usergroup,ordered');
    include_once("data/cache_usergroup.php");
    $queryplus = ($usergroup === "") ? '' : "WHERE `usergroup`='{$usergroup}'";
    if ($ordered !== '') {
        $allorder = [
		'`username` ASC',
		'`username` ASC',
		'`username` DESC',
		'`regtime` DESC',
		'`regtime` ASC'
	];
        $ordernow = $allorder[$ordered];
    } else {
        $ordernow = '`username` ASC';
    }
    $start_id = ($page - 1) * $mbcon['listitemperpage'];
    $detail_array = $blog->getgroupbyquery("SELECT * FROM `{$db_prefix}user` {$queryplus}  ORDER BY {$ordernow} LIMIT $start_id, {$mbcon['listitemperpage']}");
    for ($i = 0; $i < count($detail_array); $i++) {
        $tmp_gp = $detail_array[$i]['usergroup'];
        $tmp_sgp = $usergp[$tmp_gp];
        $tmp_tm = zhgmdate("{$mbcon['timeformat']} H:i", $detail_array[$i]['regtime'] + 3600 * $config['timezone']);
        $tablebody .= "  <tr>
    <td width='42%' class=\"listbox-entry\">{$detail_array[$i]['username']}</td>
    <td width='10%'  align='center' class=\"listbox-entry\">{$tmp_sgp}</td>
    <td width='40%' align='center' class=\"listbox-entry\">{$tmp_tm}</td>
    <td width='5%' align='center' class=\"listbox-entry\">
      <a href=\"" . getlink_user($detail_array[$i]['userid']) . "\" title='{$lnc[194]}'>
        <img src='{$mbcon['images']}/detail.gif' alt='{$lnc[194]}' border='0'>
      </a>
    </td>
  </tr>\n";
    }
    $tablelist = "  <tr>
    <td class=\"listbox-header\" width='42%' align='center'>{$lnc[132]}</td>
    <td class=\"listbox-header\" width='13%'  align='center'>{$lnc[199]}</td>
    <td class=\"listbox-header\" width='40%' align='center'>{$lnc[200]}</td>
    <td class=\"listbox-header\" width='5%' align='center'></td>
  </tr>\n" . $tablebody;
    foreach ($usergp as $i => $value) {
        if ($i == 0) {
            continue;
        }

        $selected = ($i == $usergroup) ? ' selected="selected"' : '';
        $puttingcate[] = "<a href=\"view.php?go=userlist&amp;usergroup={$i}&amp;ordered={$ordered}\">{$value}</a>";
    }
    $puttingcates = "{$lnc[201]} 
        <a href=\"view.php?go=userlist&amp;ordered={$ordered}\">{$lnc[202]}</a> 
        | " . @implode(' | ', $puttingcate);
    $tablelist .= "  <tr>
    <td colspan='5' align='left'></td>
  </tr>\n";

    $m_b = new getblogs;

    $innerpages = $m_b->make_pagebar($page, $mbcon['pagebaritems'], "view.php?go=userlist", $statistics['users'] + 1,
        $mbcon['listitemperpage']);

    $innerpages .= "<br>
{$puttingcates}
<br> 
{$lnc[203]} 
  <a href=\"view.php?go=userlist&amp;usergroup={$usergroup}&amp;ordered=1\">{$lnc[204]}</a> 
| <a href=\"view.php?go=userlist&amp;usergroup={$usergroup}&amp;ordered=2\">{$lnc[205]}</a> 
| <a href=\"view.php?go=userlist&amp;usergroup={$usergroup}&amp;ordered=3\">{$lnc[206]}</a> 
| <a href=\"view.php?go=userlist&amp;usergroup={$usergroup}&amp;ordered=4\">{$lnc[207]}</a>\n";

    $iftoppage = ($mbcon['pagebarposition'] == 'down') ? 'none' : 'block';
    $ifbottompage = ($mbcon['pagebarposition'] == 'up') ? 'none' : 'block';

    $section_table = $t->set('normaltable', ['tablebody' => $tablelist]);
    $section_body_main = $t->set('contentpage', [
	'title' => $lnc[208],
	'contentbody' => $section_table
    ]);
    announcebar();
    $bodymenu = $t->set('mainpage', [
        'pagebar'            => $innerpages,
        'iftoppage'          => $iftoppage,
        'ifbottompage'       => $ifbottompage,
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
    $pagetitle = "{$lnc[208]} - ";
}

if ($job == 'archivelist') {
    $allvaliddates = $blog->getarraybyquery("SELECT `pubtime` FROM `{$db_prefix}blogs` ORDER BY `pubtime` DESC");
    $allvaliddates = $allvaliddates['pubtime'];
    $resultdates = [];
    $result = "<table width=\"100%\">\n";
    if (is_array($allvaliddates)) {
        foreach ($allvaliddates as $time) {
            $y = gmdate('Y', $time + 3600 * $config['timezone']);
            $m = gmdate('n', $time + 3600 * $config['timezone']);
            if (!isset($resultdates[$y][$m])) {
                $resultdates[$y][$m] = 0;
            };
            $resultdates[$y][$m] += 1;
        }

        $uniquedates = array_keys($resultdates);
        for ($i = 0; $i < count($uniquedates); $i++) {
            $y = $uniquedates[$i];
            $result .= "  <tr>
    <td colspan=\"4\"><strong>{$y}{$lnc[299]}</strong></td>
  </tr>
  <tr>\n";
            for ($j = 1; $j < 13; $j++) {
                $mnt = $lnlunarcalendar['month'];
                if (!isset($resultdates[$y][$j])) {
                    $resultdates[$y][$j] = 0;
                }
                $resultdates[$y][$j] = floor($resultdates[$y][$j]);
                $result .= "    <td>
      <a href=\"" . getlink_archive($j, $y) . "\" rel=\"noindex,nofollow\">
        <strong>{$mnt[$j]}{$lnc[298]}</strong>
      </a> 
      ({$resultdates[$y][$j]})
    </td>\n";
                if ($j % 4 == 0) {
                    $result .= "  </tr>\n  <tr>\n";
                }
            }
            $result .= "  </tr>\n";
        }
    }
    $result .= "</table>\n";
    $section_body_main = $t->set('contentpage', [
        'title'       => $lnc[106],
        'contentbody' => $result,
    ]);
    announcebar();
    $bodymenu = $t->set('mainpage', [
        'pagebar'            => '',
        'iftoppage'          => 'none',
        'ifbottompage'       => 'none',
        'ifannouncement'     => $ifannouncement,
        'topannounce'        => $topannounce,
        'mainpart'           => $section_body_main,
        'currentpage'        => '',
        'previouspageurl'    => '',
        'nextpageurl'        => '',
        'turningpages'       => '',
        'totalpages'         => '',
        'previouspageexists' => '',
        'nextpageexists'     => '',
    ]);
}
