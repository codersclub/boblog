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

//If you want to use persistant connection, please set the following variety as 1
$persistant_connect=0;

//If you don't want to discontinue the program when there is any database query error, set the following variety as  1
$ignore_db_errors=0;

global $dbh, $db_version;
$dbh = false;
$db_version = '';
$db_connected = false;

if (!defined('VALIDREQUEST')) die ('Access Denied.');

if (!function_exists("mysql_connect") &&
    !function_exists("mysqli_connect")) {
	die ("Your server does not seem to support MySQL, so Bo-Blog 2.x can not run at your server.");
}

function db_connect($dbhost, $dbuser, $dbpw, $dbname='') {
	global $db_type, $dbh, $db_version;
	global $db_410, $db_connected, $persistant_connect;

	if ($db_connected==1) return;

	if ($persistant_connect==1) {
		if($db_type == 'mysqli') {
			$dbh = @mysqli_pconnect($dbhost, $dbuser, $dbpw);
		} else {
			$dbh = @mysql_pconnect($dbhost, $dbuser, $dbpw);
		}
	} else {
		if($db_type == 'mysqli') {
			$dbh = @mysqli_connect($dbhost, $dbuser, $dbpw);
		} else {
			$dbh = @mysql_connect($dbhost, $dbuser, $dbpw);
		}
	}

	if(!$dbh) {
		db_halt('Can not connect to MySQL server');
	}

	$db_connected=1;

	if($db_type == 'mysqli') {
		$db_version = mysqli_get_server_info($dbh);
	} else {
		$db_version = mysql_get_server_info();
	}

	if ($db_410=='1') {
		db_query("SET NAMES 'utf8'");
	}

	if (!empty($dbname)) {
		if($db_type == 'mysqli') {
			$a_result=mysqli_select_db($dbh, $dbname);
		} else {
			$a_result=mysql_select_db($dbname);
		}
		if ($a_result) {
			return $a_result;
		} else {
			db_halt('Can not connect to MySQL server');
		}
	}
}

/*vot
function db_select_db($dbname) {
	global $db_type, $dbh;
	if($db_type == 'mysqli') {
		$a_result=mysqli_select_db($dbname);
	} else {
		$a_result=mysql_select_db($dbname);
	}
	if ($a_result) {
		if($db_type == 'mysqli') {
			mysqli_query($dbh, "SET NAMES 'utf8'");
		} else {
			mysql_query("SET NAMES 'utf8'");
		}
	}
	return $a_result;
}
*/

function db_fetch_array($query) {
	global $db_type;
	if($db_type == 'mysqli') {
		return mysqli_fetch_array($query, MYSQLI_ASSOC);
	} else {
		return mysql_fetch_array($query, MYSQL_ASSOC);
	}
}

function db_query($sql, $silence = 0) {
	global $db_type, $dbh;
	global $querynum, $allqueries, $ignore_db_errors;
	if($db_type == 'mysqli') {
		$query = mysqli_query($dbh, $sql);
	} else {
		$query = mysql_query($sql);
	}
	if($db_type == 'mysqli') {
		$errno = mysqli_errno($dbh);
		$errmess = mysqli_error($dbh);
	} else {
		$errno = mysql_errno();
		$errmess = mysql_error();
	}
	$querynum++;
/*vot*/	$allqueries[]=array( //For Debug Use Only
/*vot*/		'sql' => $sql,
/*vot*/		'err_code' => $errno,
/*vot*/		'err_message' => $errmess,
	);
	if(!$query && !$silence && !$ignore_db_errors) {
		db_halt('MySQL Query Error', $sql);
	}
	return $query;
}

function db_unbuffered_query($sql, $silence = 0) {
	global $querynum, $db_type;
	$func_unbuffered_query = @function_exists($db_type.'_unbuffered_query') ? $db_type.'_unbuffered_query' : $db_type.'_query';
	$query = $func_unbuffered_query($sql);
	if(!$query && !$silence) {
		db_halt('MySQL Query Error', $sql);
	}
	$querynum++;
	return $query;
}

function db_affected_rows() {
	global $db_type, $dbh;
	if($db_type == 'mysqli') {
		return mysqli_affected_rows($dbh);
	} else {
		return mysql_affected_rows();
	}
}

function db_error() {
	global $db_type, $dbh;
	if($db_type == 'mysqli') {
		return mysqli_error($dbh);
	} else {
		return mysql_error();
	}
}

function db_errno() {
	global $db_type, $dbh;
	if($db_type == 'mysqli') {
		return mysqli_errno($dbh);
	} else {
		return mysql_errno();
	}
}

function result($query, $row) {
	global $db_type;
	if($db_type == 'mysqli') {
		$query = @mysqli_result($query, $row);
	} else {
		$query = @mysql_result($query, $row);
	}
	return $query;
}

function db_num_rows($query) {
	global $db_type;
	if($db_type == 'mysqli') {
		$query = mysqli_num_rows($query);
	} else {
		$query = mysql_num_rows($query);
	}
	return $query;
}

function db_num_fields($query) {
	global $db_type;
	if($db_type == 'mysqli') {
		return mysqli_num_fields($query);
	} else {
		return mysql_num_fields($query);
	}
}

function db_free_result($query) {
	global $db_type;
	if($db_type == 'mysqli') {
		return mysqli_free_result($query);
	} else {
		return mysql_free_result($query);
	}
}

function db_insert_id() {
	global $db_type;
	if($db_type == 'mysqli') {
		$id = mysqli_insert_id();
	} else {
		$id = mysql_insert_id();
	}
	return $id;
}

function db_fetch_row($query) {
	global $db_type;
	if($db_type == 'mysqli') {
		$query = mysqli_fetch_row($query);
	} else {
		$query = mysql_fetch_row($query);
	}
	return $query;
}

function db_close() {
	global $db_type;
	if($db_type == 'mysqli') {
		mysqli_close();
	} else {
		mysql_close();
	}
}

function db_field_name($result, $field_offset) {
	global $db_type;
	if($db_type == 'mysqli') {
	        return mysqli_field_name($result, $field_offset);
	} else {
        	return mysql_field_name($result, $field_offset);
	}
}

function db_get_server_info() {
	global $db_type;
	if($db_type == 'mysqli') {
	        return mysqli_get_server_info();
	} else {
        	return mysql_get_server_info();
	}
}

function db_halt($message = '', $sql = '') {
    global $db_prefix, $config;
    $timestamp = time();
    $errmsg = '';

    $dberror = db_error();
    $dberrno = db_errno();
    $dberror=str_replace($db_prefix, '***', $dberror);
    $sql=str_replace($db_prefix, '***', $sql);


    $errmsg = "<b>Bo-Blog Database System Tips</b>: $message\n\n";
    $errmsg .= "<b>Time</b>: ".gmdate("Y-m-d H:i:s", $timestamp + ($config['timezone'] * 3600))."\n";
    $errmsg .= "<b>Script</b>: ".$_SERVER['PHP_SELF']."\n\n";

    if($sql) {
    	$errmsg .= "<b>SQL</b>: ".htmlspecialchars($sql)."\n";
    }

    $errmsg .= "<b>Error</b>: $dberror\n";
    $errmsg .= "<b>Errno.</b>: $dberrno";

    @header("Content-Type: text/html; charset=utf-8");
    echo "</table></table></table></table></table>\n";
    echo "<p style=\"font-family: Verdana, Tahoma; font-size: 11px; background: #FFFFFF;\">";
    echo nl2br($errmsg);
    echo '</p>';

    backtrace();

    exit;
}
