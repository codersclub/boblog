<?PHP

if (!defined('VALIDADMIN')) {
    die ('Access Denied.');
}

$display_overall .= "
  </div>
</div>

<div id=\"adminfooter\">
  <div id=\"copyright\">
    Ver <a href=\"http://www.bo-blog.com\">{$blogversion}</a> ({$codeversion})
    [<a href=\"index.php\">{$lna[41]}</a>]
    [<a href=\"admin.php\">{$lna[39]}</a>]
    [<a href=\"login.php?job=logout\">{$lna[40]}</a>]
  </div>
</div>
";

if (defined('VALIDADMIN') && $adminlogstat) {
    if ($config['debug'] == '1') {
        $display_overall .= "DEBUG:<br><table border=1 cellpadding=4 width='100%'>\n";
        $display_overall .= "<tr><th>#</th><th>SQL</th><th>Err.code</th><th>Err.Msg</th></tr>\n";

        foreach ($allqueries as $i => $query) {
            $display_overall .= "<tr><td>{$i}</td><td align=\"left\">{$query['sql']}</td><td>{$query['err_code']}</td><td>{$query['err_message']}</td></tr>\n";
        }

        $display_overall .= "</table>\n<br>\n";
    }
}

$display_overall .= "</body></html>";

@header("Content-Type: text/html; charset=utf-8");
echo($display_overall);

