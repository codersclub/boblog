<?PHP
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

//If you want to use persistant connection, please set the following variety as 1
$persistant_connect=0;

//If you don't want to discontinue the program when there is any database query error, set the following variety as  1
$ignore_db_errors=0;

if (!defined('VALIDREQUEST')) die ('Access Denied.');

if (!function_exists("mysql_connect")) {
	die ("Your server does not seem to support MySQL, so Bo-Blog 2.x can not run at your server.");
}

function db_connect($dbhost, $dbuser, $dbpw, $dbname='') {
	global $db_410, $db_connected, $persistant_connect;
	if ($db_connected==1) return;
	if ($persistant_connect==1) {
		$dbh=@mysql_pconnect($dbhost, $dbuser, $dbpw);
	} else {
		$dbh=@mysql_connect($dbhost, $dbuser, $dbpw);
	}

/*vot*/	if(!$dbh) {
/*vot*/		db_halt('Can not connect to MySQL server');
/*vot*/	}

	$db_connected=1;

	if ($db_410=='1') {
		db_query("SET NAMES 'utf8'");
	}

	if (!empty($dbname)) {
		$a_result=mysql_select_db($dbname);
		if ($a_result) {
			return $a_result;
		} else {
/*vot*/			db_halt('Can not connect to MySQL server');
		}
	}
}

/*vot
function db_select_db($dbname) {
	$a_result=mysql_select_db($dbname);
	if ($a_result) {
		if (mysql_get_server_info()>='4.1.0') {
			mysql_query("SET NAMES 'utf8'");
		}
	}
	return $a_result;
}
*/

function db_fetch_array($query, $result_type = MYSQL_ASSOC) {
/*vot*/	$res = mysql_fetch_array($query, $result_type);
/*vot*/	return $res;
}

function db_query($sql, $silence = 0) {
	global $querynum, $allqueries, $ignore_db_errors;
	$query = mysql_query($sql);
	if(!$query && !$silence && !$ignore_db_errors) {
		db_halt('MySQL Query Error', $sql);
	}
	$querynum++;
/*vot*/	$allqueries[]=array( //For Debug Use Only
/*vot*/		'sql' => $sql,
/*vot*/		'err_code' => mysql_errno(),
/*vot*/		'err_message' => mysql_error(),
	);
	return $query;
}

function db_unbuffered_query($sql, $silence = 0) {
	global $querynum;
	$func_unbuffered_query = @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
	$query = $func_unbuffered_query($sql);
	if(!$query && !$silence) {
		db_halt('MySQL Query Error', $sql);
	}
	$querynum++;
	return $query;
}

function db_affected_rows() {
	return mysql_affected_rows();
}

function db_error() {
	return mysql_error();
}

function db_errno() {
	return mysql_errno();
}

function result($query, $row) {
	$query = @mysql_result($query, $row);
	return $query;
}

function db_num_rows($query) {
	$query = mysql_num_rows($query);
	return $query;
}

function db_num_fields($query) {
	return mysql_num_fields($query);
}

function db_free_result($query) {
	return mysql_free_result($query);
}

function db_insert_id() {
	$id = mysql_insert_id();
	return $id;
}

function db_fetch_row($query) {
	$query = mysql_fetch_row($query);
	return $query;
}

function db_close() {
	mysql_close();
}

function db_halt($message = '', $sql = '') {
global $db_prefix;
$timestamp = time();
$errmsg = '';

$dberror = db_error();
$dberrno = db_errno();
$dberror=str_replace($db_prefix, '***', $dberror);
$sql=str_replace($db_prefix, '***', $sql);


$errmsg = "<b>Bo-Blog Database System Tips</b>: $message\n\n";
$errmsg .= "<b>Time</b>: ".gmdate("Y-n-j g:ia", $timestamp + ($GLOBALS["timeoffset"] * 3600))."\n";
$errmsg .= "<b>Script</b>: ".$GLOBALS['PHP_SELF']."\n\n";
if($sql) {
	$errmsg .= "<b>SQL</b>: ".htmlspecialchars($sql)."\n";
}
$errmsg .= "<b>Error</b>:  $dberror\n";
$errmsg .= "<b>Errno.</b>:  $dberrno";

@header("Content-Type: text/html; charset=utf-8");
echo "</table></table></table></table></table>\n";
echo "<p style=\"font-family: Verdana, Tahoma; font-size: 11px; background: #FFFFFF;\">";
echo nl2br($errmsg);
	
echo '</p>';
exit;
}
