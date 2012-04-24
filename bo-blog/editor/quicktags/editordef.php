<?php

if (!defined('VALIDADMIN')) {
    die ('Access Denied.');
}

$editorjs = <<<eot
<script src="editor/quicktags/js_quicktags.js"></script>
eot;

$onloadjs = "";
$editorbody = <<<eot
<script>edToolbar();</script>
<textarea name='content' id='content' rows='20' cols='100' class='formtextarea'>{content}</textarea>
<script>var edCanvas = document.getElementById('content');</script>
<br>
{$lna[745]}
<br>
</div>
eot;
