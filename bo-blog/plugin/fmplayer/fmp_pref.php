<?php

if (!defined('VALIDADMIN')) {
    die ('Access Denied.');
}

addpref("t", "file|{$lanfp[18]}|{$lanfp[51]}");
//addpref("t", "image|{$lanfp[42]}|image");
addpref("t", "displayheight|{$lanfp[19]}|{$lna[879]},{$lanfp[52]}");
//addpref("t", "displaywidth|displaywidth|");
//addpref("sel", "shownavigation|{$lanfp[21]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[54]}");
//addpref("sel", "transition|{$lanfp[20]}|fade>>Fade<<bgfade>>bgfade<<blocks>>blocks<<circles>>circles<<fluids>>fluids<<lines>>lines<<random>>random|{$lanfp[53]}");
addpref("t", "fmp_w|{$lanfp[22]}|{$lna[879]}");
addpref("t", "fmp_h|{$lanfp[23]}|{$lna[879]}");
addpref("sel", "wmode|{$lanfp[97]}|transparent>>{$lna[512]}<<>>{$lanfp[17]}|{$lanfp[98]}");
addpref("t", "backcolor|{$lanfp[24]}|{$lanfp[55]}");
addpref("t", "frontcolor|{$lanfp[25]}|{$lanfp[55]}");
addpref("t", "lightcolor|{$lanfp[26]}|{$lanfp[55]}");
addpref("sec", "{$lanfp[73]}{$lanfp[1]}");
addpref("sel",
    "autoscroll|{$lanfp[33]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[62]}{$lanfp[72]}");
//addpref("t", "kenburns|kenburns|");
addpref("sel",
    "largecontrols|{$lanfp[92]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[93]}{$lanfp[72]}");
addpref("t", "logo|{$lanfp[29]}|{$lanfp[58]}");
addpref("sel",
    "overstretch|{$lanfp[28]}|none>>{$lanfp[66]}<<true>>{$lanfp[68]}<<false>>{$lanfp[67]}<<fit>>{$lanfp[69]}<<>>{$lanfp[17]}|{$lanfp[57]}{$lanfp[72]}");
addpref("sel",
    "showdigits|{$lanfp[31]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[60]}{$lanfp[72]}");
addpref("sel", "showeq|{$lanfp[30]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[59]}{$lanfp[72]}");
addpref("sel", "showicons|{$lanfp[27]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[56]}{$lanfp[72]}");
addpref("sel",
    "showvolume|{$lanfp[94]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[95]}{$lanfp[72]}");
addpref("sel",
    "thumbsinplaylist|{$lanfp[32]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[61]}{$lanfp[72]}");
addpref("sec", "{$lanfp[74]}{$lanfp[1]}");
//addpref("t", "audio|{$lanfp[49]}|");
//addpref("t", "bwfile|{$lanfp[81]}|");
//addpref("t", "bwstreams|{$lanfp[82]}|");
//addpref("t", "callback|{$lanfp[44]}|callback");
//addpref("t", "captions|{$lanfp[83]}|");
//addpref("sel", "enablejs|{$lanfp[45]}|true>>{$lna[512]}<<false>>{$lna[511]}|enablejs");
//addpref("t", "fsbuttonlink|{$lanfp[46]}|");
//addpref("t", "id|{$lanfp[47]}|");
//addpref("t", "javascriptid|{$lanfp[48]}|");
//addpref("t", "link|{$lanfp[43]}|link");
addpref("sel",
    "linkfromdisplay|{$lanfp[34]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[63]}{$lanfp[72]}");
addpref("sel",
    "linktarget|{$lanfp[35]}|_self>>{$lanfp[70]}<<_blank>>{$lanfp[71]}<<>>{$lanfp[17]}|{$lanfp[64]}{$lanfp[72]}");
//addpref("t", "streamscript|{$lanfp[50]}|streamscript");
//addpref("t", "type|{$lanfp[84]}|");
//addpref("sel", "useaudio|{$lanfp[85]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[72]}");
//addpref("sel", "usecaptions|{$lanfp[86]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[72]}");
//addpref("sel", "usefullscreen|{$lanfp[87]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[72]}");
addpref("sel", "usekeys|{$lanfp[88]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[72]}");
addpref("sel", "autostart|{$lanfp[36]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[72]}");
//addpref("t", "bufferlength|{$lanfp[40]}|{$lanfp[91]}");
addpref("sel", "repeat|{$lanfp[39]}|true>>true<<false>>false<<list>>list<<>>{$lanfp[17]}|{$lanfp[72]}");
//addpref("sel", "rotatetime|{$lanfp[41]}|15>>15<<10>>10<<5>>5<<>>{$lanfp[17]}|{$lanfp[72]}");
addpref("sel", "shuffle|{$lanfp[38]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[72]}");
addpref("sel", "smoothing|{$lanfp[89]}|true>>{$lna[512]}<<false>>{$lna[511]}<<>>{$lanfp[17]}|{$lanfp[72]}");
//addpref("t", "start|{$lanfp[90]}|");
addpref("t", "volume|{$lanfp[37]}|{$lanfp[65]}");
