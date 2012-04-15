<?PHP

error_reporting(E_ALL);
$v = @$_REQUEST['v'];

if (!$v) {
    template("<div class='log'>Upgrade confirmation</div>
<form action='updateto210.php?v=1' method='post'>
    <div class='mes'>
        <div>
            This program can upgrade the data format of version 2.0.3 sp1 / 2.1.0 alpha to the latest data format of 2.1.0 beta/official version.
            It is recommended that you back up your data before upgrading. This operation is irreversible!
            <br/><br/>
            If your blog is currently closed, please open it and continue.
        </div>
        <br/>
        <div align='center'>
            <input type='submit' value='Upgrade now' class='inbut'>
        </div>
    </div>
 </form>");
}

if ($v == '1') {
    include("function.php");
    $queries = array();
    if ($db_410 == 1) {
        $sqlcharset = "  CHARSET=utf8";
    }

    $try = $blog->getbyquery("SELECT * FROM `{$db_prefix}blogs` LIMIT 1");
    if (!array_key_exists('comefrom', $try)) {
        $queries[] = "ALTER TABLE `{$db_prefix}blogs` ADD `entrysummary` TEXT NULL , ADD `comefrom` VARCHAR( 255 ) NULL , ADD `originsrc` VARCHAR( 255 ) NULL , ADD `blogalias` VARCHAR( 100 ) NULL";
    }

    $try = $blog->getbyquery("SELECT * FROM `{$db_prefix}mods` WHERE `name`='columnbreak' LIMIT 1");
    if ($try['name'] != 'columnbreak') {
        $queries[] = "INSERT INTO `{$db_prefix}mods` VALUES ('sidebar', 'columnbreak', 'The dividing line between sidebar 1 and sidebar 2', '1', '1', 'system')";
    }

    $try = $blog->getbyquery("SELECT * FROM `{$db_prefix}user` LIMIT 1");
    if (array_key_exists('empty2', $try)) {
        $queries[] = "ALTER TABLE `{$db_prefix}user` DROP `empty2` ,DROP `empty3` ,DROP `empty4` ,DROP `empty5` ,DROP `empty6` ,DROP `empty7` ,DROP `empty8`";
    }
    if (array_key_exists('from', $try)) {
        $queries[] = "ALTER TABLE `{$db_prefix}user` CHANGE `from` `fromplace` TEXT NULL DEFAULT NULL";
    }


    $try = $blog->getbyquery("SELECT * FROM `{$db_prefix}mods` LIMIT 1");
    if (array_key_exists('order', $try)) {
        $queries[] = "ALTER TABLE `{$db_prefix}mods` CHANGE `order` `modorder` INT( 5 ) NOT NULL";
    }

    $try = $blog->getbyquery("SELECT * FROM `{$db_prefix}categories` LIMIT 1");
    if (array_key_exists('empty1', $try)) {
        $queries[] = "ALTER TABLE `{$db_prefix}categories` CHANGE `empty1` `cateurlname` VARCHAR( 100 ) NULL";
    }

    $queries[] = "CREATE TABLE IF NOT EXISTS `{$db_prefix}pages` (
`pageid` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pagetitle` VARCHAR( 255 ) NULL ,
`pagecontent` TEXT NULL ,
`pageauthor` INT( 8 ) NOT NULL DEFAULT '0',
`pagetime` INT( 11 ) NOT NULL DEFAULT '0',
`pageedittime` INT( 11 ) NOT NULL DEFAULT '0',
`closesidebar` TINYINT( 1 ) NOT NULL DEFAULT '0',
`htmlstat` TINYINT( 1 ) NOT NULL DEFAULT '0',
`ubbstat` TINYINT( 1 ) NOT NULL DEFAULT '0',
`emotstat` TINYINT( 1 ) NOT NULL DEFAULT '0',
`pagealias` VARCHAR( 255 ) NULL,
INDEX ( `pageauthor` )
) ENGINE = MYISAM{$sqlcharset}";

    $queries[] = "CREATE TABLE IF NOT EXISTS `{$db_prefix}upload` (
`fid` int(6) NOT NULL auto_increment,
`filepath` varchar(255) default NULL,
`originalname` VARCHAR( 255 ) NULL,
`dltime` int(8) NOT NULL default '0',
`uploadtime` int(11) default NULL,
`uploaduser` int(6) NOT NULL default '0',
PRIMARY KEY  (`fid`)
) ENGINE=MyISAM";

    foreach ($queries as $singlequery) {
        $blog->query($singlequery);
    }

    writetofile("data/cache_adminskinlist.php", "<?PHP\n\$adminskin[]='default';\n\$currentadminskin='default';");

    template("<div class='log'>Upgrade completed</div><div class='mes'>The data format of 2.0.3 sp1 / 2.1.0 alpha version has been upgraded to the data format of 2.1.0 beta/official version.<br/><br/>Please go to the &laquo;Parameter settings&raquo; in the background to set new options such as the number of tag pages, the number of emoticons per page, anti-theft link, etc., and give the administrator to create a custom page in the &laquo;User Group Authority&raquo; setting And refresh all caches at the same time, otherwise the blog display may be abnormal.<br/><br/>Please delete this file from the server immediately.</div><br/></div>");
}


function template($body)
{
    $bbb = <<<eot
<html xmlns="http://www.w3.org/1999/xhtml" lang="UTF-8">
<head>
<style><!--
body {
	margin: 15px;
	background-color: #EEE;
	font-family: Verdana,Tahoma,sans-serif;
	text-align: center;
}
#tips {
	margin-left: auto;
	margin-right: auto;
	width: 600px;
	height: auto;
	background-color: #fff;
	font-size: 9pt;
	border: 1px solid #ccc;
	text-align: left;
	padding-bottom: 5px;
}
#tips	a {
	color: #000;
	text-decoration: none;
}
#tips	a:hover {
	color: #000;
	text-decoration: underline;
}

#titles {
	margin-left: auto;
	margin-right: auto;
	margin-top: 50px;
	width: 600px;
	height: 30px;
	font-size: 14px;
	color: #3F68A6;
	font-weight: bold;
	text-align: left;
}

div, textarea, option, input {
	font-size: 9pt;
	font-family: Verdana,Tahoma,sans-serif;
}

.log {
	display: block;
	background-color: #4971AD;
	color: #fff;
	height: 20px;
	padding-top: 5px;
	padding-bottom: 5px;
	padding-left: 20px;
}

.mes {
	display: block;
	padding-left: 20px;
	padding-top: 5px;
	min-height: 100px;
}

.inbut {
	border-color: #EEE;
	background-color: #fff;
}
--></style>
<title>Bo-Blog Update</title>
</head>
<body>
<div id="titles">
    Bo-Blog Update
</div>

<div id="tips">
$body
</div>
</body>
</html>
eot;
    @header("Content-Type: text/html; charset=utf-8");
    print($bbb);
    exit();
}
