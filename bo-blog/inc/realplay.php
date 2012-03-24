<?php
@header("Content-Disposition: attachment; filename=\"realplayer.php\"");
@header("Content-Type: application/octet-stream");
/*vot*/ echo stripslashes($_GET['link']);
