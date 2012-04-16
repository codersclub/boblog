<?PHP

error_reporting(E_ALL);
$v = @$_REQUEST['v'];

if (!$v) {
    template("<div class='log'>Upgrade confirmation</div>
<form action='updateto203.php?v=1' method='post'>
    <div class='mes'>
        <div>
            This program can upgrade the data format of the 2.0.2 sp2 / 2.0.3 alpha version to the 2.0.3 beta/official version data format.
            It is recommended that you back up your data before upgrading. This operation is irreversible!
            <br/>
            <br/>
            If your blog is currently closed, please open it and continue.
        </div>
        <br/>
        <div align='center'>
            <input type='submit' value='Upgrade now' class='inbut'>
        </div>
</form>
</div>");
}

if ($v == '1') {
    include("function.php");
    $queries = array();
    if ($codeversion < '2.0.3.1203.2') {
        $queries[] = "ALTER TABLE `{$db_prefix}blogs`  DROP `empty2`,  DROP `empty3`,  DROP `empty4`,  DROP `empty5`,  DROP `empty6`,  DROP `empty7`,  DROP `empty8`,  DROP `empty9`,  DROP `empty10`";
        $queries[] = "ALTER TABLE `{$db_prefix}blogs` ADD `blogpsw` TINYTEXT, ADD `frontpage` TINYINT( 1 ) DEFAULT '0' NOT NULL";
    }
    if ($codeversion < '2.0.3.1209.0') {
        $queries[] = "ALTER TABLE `{$db_prefix}replies` CHANGE `empty1` `reppsw` TINYTEXT";
        $queries[] = "ALTER TABLE `{$db_prefix}messages` CHANGE `empty1` `reppsw` TINYTEXT";
    }
    if ($codeversion >= '2.0.3.1209.0') {
        template("<div class='log'>Upgrade terminated</div><div class='mes'>The program detects that the files on your server have been upgraded already to 2.0.3. <br><br>Have you uploaded the main program file first without executing this update program, replacing or overwriting the original program file of the old version? <br><br>If this is the case, please change back to the old version of the global.php file and re-execute the upgrade procedure. <br><br>If not, you are already in the 2.0.3 data format, no need to upgrade, please exit. <br/><br/>Please delete this file from the server immediately.</div><br/></div>");
    }
    for ($i = 0; $i < count($queries); $i++) {
        $blog->query($queries[$i]);
    }
    template("<div class='log'>Upgrade completed</div><div class='mes'>The data format of 2.0.2 sp2 / 2.0.3 alpha version has been upgraded to the data format of 2.0.3 beta/official version. <br/><br/>Please go to the background parameter settings to set options such as custom date format, otherwise the blog display may not be normal. <br/><br/>Please delete this file from the server immediately.</div><br/></div>");
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
	font-family: Tahoma;
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
