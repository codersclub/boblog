<?PHP
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
error_reporting(E_ALL);

if (function_exists('set_magic_quotes_runtime')) {
    @set_magic_quotes_runtime(0);
}

$v = $_REQUEST['v'];

if ($v != 2 && $v != 3) {
    @header("Content-Type: text/html; charset=utf-8");
    print<<<eot
Bo-Blog 2.0.1 Emergency recovery procedure
<br>
<B><font color='red'>Warning: This program is quite dangerous, please upload and use it only in an emergency state, and delete it immediately after use!</font></B>
<br>
<br>
<br>
<form action='emergency.php' method='post'><input type='hidden' value='3' name='v'>
<b>User Group: reset all the permissions of Administrator and Guest group to default</b>
<br>
<input type='submit' value='Start'>
</form>
<hr>
<form action='emergency.php' method='post'><input type='hidden' value='2' name='v'>
<b>General: Please tick and fill in the necessary options before the operation that needs to be performed</b>
<br>
<input type='checkbox' name='act[]' value='psw'> Restore for admin: <input type='text' name='oldadmin'> Password: <input type='text' name='newpsw'>
<br>
<input type='checkbox' name='act[]' value='nologinval'> Require verification code when canceling login
<br>
<input type='checkbox' name='act[]' value='changeuser'> Reset the identity of the following user as an administrator,
username: <input type='text' name='newadmin'> Use correct capitalization!
<br>
<input type='checkbox' name='act[]' value='open'> Restore the blog status to open
<br>
<input type='submit' value='OK'>
</form>
eot;

    exit();
} elseif ($v != 3) {
    require_once("data/config.php");
    require_once("global.php");
    require_once("inc/db.php");
    require_once("inc/boblog_class_run.php");
}

if ($v == 2) {
    $act = $_POST['act'];
    $newpsw = $_REQUEST['newpsw'];
    $oldadmin = $_REQUEST['oldadmin'];
    $newadmin = $_REQUEST['newadmin'];
    if (!is_array($act)) {
        header("Location: emergency.php");
        exit();
    }

    if (in_array('psw', $act)) {
        $newpsw = md5($newpsw);
        $blog->query("UPDATE `{$db_prefix}user` SET `userpsw`='{$newpsw}' WHERE `username`='{$oldadmin}'");
    }
    if (in_array('changeuser', $act)) {
        $blog->query("UPDATE `{$db_prefix}user` SET `usergroup`='2' WHERE `username`='{$newadmin}'");
    }

    $content = readfromfile("data/config.php");
    if (in_array('nologinval', $act)) {
        $content .= "\$config['loginvalidation']='0';\n";
    }
    if (in_array('open', $act)) {
        $content .= "\$config['blogopen']='1';\n";
    }

    writetofile("data/config.php", $content);
    @header("Content-Type: text/html; charset=utf-8");
    die ("Bo-Blog 2.0.1 emergency recovery procedure completed the requested action.
<br>
<B><font color='red'>Warning: Please delete this file immediately!!</font></B>");
}

if ($v == 3) {
    $usorigin0 = <<<eot
<?PHP
\$permission['gpname']='Guest';
\$permission['visit']='1';
\$permission['ViewPHPError']='0';
\$permission['SeeSecretCategory']='0';
\$permission['SeeHiddenEntry']='0';
\$permission['SeeHiddenReply']='0';
\$permission['SeeIP']='0';
\$permission['ViewUserList']='1';
\$permission['ViewUserDetail']='0';
\$permission['ApplyLink']='1';
\$permission['AddEntry']='0';
\$permission['EditEntry']='0';
\$permission['EditSafeMode']='0';
\$permission['AddTag']='0';
\$permission['Reply']='1';
\$permission['ReplyReply']='0';
\$permission['LeaveMessage']='1';
\$permission['MaxPostLength']='5000';
\$permission['MinPostInterval']='5';
\$permission['NoSpam']='0';
\$permission['Html']='0';
\$permission['Ubb']='1';
\$permission['Emot']='1';
\$permission['PinEntry']='0';
\$permission['CP']='0';
\$permission['XMLRPC']='0';
\$permission['AllowSearch']='1';
\$permission['FulltextSearch']='0';
\$permission['SearchInterval']='15';
\$permission['Upload']='0';
\$permission['MaxSize']='0';
\$permission['AllowedTypes']='';
eot;

    $usorigin2 = <<<eot
<?PHP
\$permission['gpname']='Administrator';
\$permission['visit']='1';
\$permission['ViewPHPError']='1';
\$permission['SeeSecretCategory']='1';
\$permission['SeeHiddenEntry']='1';
\$permission['SeeHiddenReply']='1';
\$permission['SeeIP']='1';
\$permission['ViewUserList']='1';
\$permission['ViewUserDetail']='1';
\$permission['ApplyLink']='1';
\$permission['AddEntry']='1';
\$permission['EditEntry']='1';
\$permission['EditSafeMode']='1';
\$permission['AddTag']='1';
\$permission['Reply']='1';
\$permission['ReplyReply']='1';
\$permission['LeaveMessage']='1';
\$permission['MaxPostLength']='99999999';
\$permission['MinPostInterval']='-1';
\$permission['NoSpam']='1';
\$permission['Html']='1';
\$permission['Ubb']='1';
\$permission['Emot']='1';
\$permission['PinEntry']='1';
\$permission['CP']='1';
\$permission['XMLRPC']='1';
\$permission['AllowSearch']='1';
\$permission['FulltextSearch']='1';
\$permission['SearchInterval']='-1';
\$permission['Upload']='1';
\$permission['MaxSize']='2048';
\$permission['AllowedTypes']='zip rar gz bz2 jpg jpeg gif bmp png swf mp3 wma rm htm html txt doc xml css wmv';
eot;

    writetofile2("data/usergroup0.php", $usorigin0);
    writetofile2("data/usergroup2.php", $usorigin2);
    @header("Content-Type: text/html; charset=utf-8");
    die ("Bo-Blog 2.0.1 emergency recovery procedure completed the requested action.
<br>
<B><font color='red'>Warning: Please delete this file immediately!!</font></B>");
}

function writetofile2($filename, $data)
{
    $filenum = @fopen($filename, "w");
    if (!$filenum) {
        return false;
    }
    flock($filenum, LOCK_EX);
    $file_data = fwrite($filenum, $data);
    fclose($filenum);
    return true;
}
