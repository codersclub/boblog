<?php
/*vot*/ error_reporting(E_ALL);
//*vot*/ error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
include ("../../../../data/cache_emot.php");

print<<<eot
<!doctype html>
<html>
<head>
	<title>Emots</title>
	<script src="../../tiny_mce_popup.js"></script>
	<script src="jscripts/functions.js"></script>
	<base target="_self" />
</head>
<body>
<div align="center">
		<table border="0" cellspacing="0" cellpadding="4" width="100%">
eot;

$perline=15;
$selbody='';
if (is_array($myemots)) {
	$i=0;
	foreach ($myemots as $emotcode => $emott) {
		$emotthumb=$emott['thumb'];
		$emotorigin=$emott['image'];
		$selbody.="<td><a href=\"javascript:insertEmotion('{$emotorigin}','{$emotcode}');\"><img src=\"../../../../images/emot/{$emotthumb}\" border=\"0\" alt=\"{$emotcode}\" /></a></td>";
		$i+=1;
		if ($i%$perline==0) $selbody.="</tr><tr>";
		unset ($emotcode, $emotthumb);
	}
}

print<<<eot
<tr>
$selbody
</tr>
		</table>
	</div>
</body>
</html>
eot;
