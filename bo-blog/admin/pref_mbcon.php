<?PHP
if (!defined('VALIDADMIN')) die ('Access Denied.');
addpref("sec", "{$lna[532]}");
addpref("r", "displayannounce|{$lna[533]}|{$lna[534]}|{$lna[535]}");
addpref("ta", "announce|{$lna[536]}");
addpref("sec", "{$lna[537]}");
addpref("t", "entrynum|{$lna[538]}#|{$lna[539]}");
addpref("t", "replynum|{$lna[540]}#|{$lna[539]}");
addpref("t", "entrylength|{$lna[541]}#|{$lna[542]}<br>{$lna[1029]}");
addpref("t", "replylength|{$lna[543]}#|{$lna[542]}<br>{$lna[1029]}");
addpref("r", "extend_category|{$lna[544]}|{$lna[545]}|{$lna[546]}");
addpref("r", "extend_link|{$lna[547]}|{$lna[545]}|{$lna[546]}");
addpref("r", "extend_statistics|{$lna[548]}|{$lna[545]}|{$lna[546]}");
addpref("r", "extend_archive|{$lna[549]}|{$lna[545]}|{$lna[546]}");
addpref("t", "archivemonths|{$lna[550]}|{$lna[551]}");
addpref("r", "showcateartnum|{$lna[902]}|{$lna[534]}|{$lna[535]}");
addpref("sec", "{$lna[552]}");
addpref("r", "stattotal|{$lna[553]}|{$lna[534]}|{$lna[535]}");
addpref("r", "stattoday|{$lna[554]}|{$lna[534]}|{$lna[535]}");
addpref("r", "statentries|{$lna[555]}|{$lna[534]}|{$lna[535]}");
addpref("r", "statreplies|{$lna[556]}|{$lna[534]}|{$lna[535]}");
addpref("r", "stattb|{$lna[557]}|{$lna[534]}|{$lna[535]}");
/*vot*/ if (@$flset['guestbook']!=1) addpref("r", "statmessages|{$lna[558]}|{$lna[534]}|{$lna[535]}");
addpref("r", "statusers|{$lna[559]}|{$lna[534]}|{$lna[535]}");
addpref("r", "statonline|{$lna[560]}|{$lna[534]}|{$lna[535]}");
addpref("sec", "{$lna[561]}");
addpref("t", "miinum|{$lna[562]}");
addpref("r", "runtime|{$lna[563]}|{$lna[534]}|{$lna[535]}");
addpref("sec", "{$lna[564]}");
addpref("t", "linklength|{$lna[1028]}|{$lna[542]}<br>{$lna[1029]}");
addpref("sel", "prevnextshowsamecate|{$lna[1141]}|0>>{$lna[1142]}<<1>>{$lna[1143]}");
addpref("ta", "extraheader|{$lna[565]}|<br>{$lna[566]}");
addpref("sel", "editortype|{$lna[567]}|quicktags>>QuickTags<<ubb>>{$lna[568]}<<fckeditor>>FCKeditor {$lna[1017]}<<tinymce>>TinyMCE {$lna[1017]}<<custom>>{$lna[711]}");
addpref("t", "exceptperpage|{$lna[569]}|{$lna[570]}");
addpref("t", "listitemperpage|{$lna[571]}|{$lna[570]}");
addpref("sel", "pagebarposition|{$lna[572]}|up>>{$lna[573]}<<down>>{$lna[574]}<<all>>{$lna[959]}");
addpref("t", "pagebaritems|{$lna[575]}|{$lna[576]}");
addpref("t", "replyperpage|{$lna[577]}|{$lna[570]}");
addpref("t", "messageperpage|{$lna[578]}|{$lna[570]}");
addpref("sel", "replyorder|{$lna[579]}|0>>{$lna[580]}<<1>>{$lna[581]}");
addpref("r", "showtoolbar|{$lna[582]}|{$lna[534]}|{$lna[535]}");
addpref("r", "txtdown|{$lna[1015]}|{$lna[511]}|{$lna[512]}");
addpref("r", "tidyhtml|{$lna[1144]}|{$lna[511]}|{$lna[512]}|<br>{$lna[1145]}");
addpref("t", "ipsearch|{$lna[583]}|<br>{$lna[584]}");
addpref("r", "showeditor|{$lna[585]}|{$lna[534]}|{$lna[535]}");
addpref("r", "shortenurl|{$lna[586]}|{$lna[511]}|{$lna[512]}");
addpref("t", "urlmaxlen|{$lna[587]}|{$lna[542]}");
addpref("r", "autoaddlink|{$lna[588]}|{$lna[511]}|{$lna[512]}");
//addpref("r", "protectemail|{$lna[589]}|{$lna[511]}|{$lna[512]}|<br>{$lna[590]}");
addpref("r", "anticorrupturl|{$lna[591]}|{$lna[511]}|{$lna[512]}|<br>{$lna[592]}");
addpref("t", "autoresizeimg|{$lna[878]}|{$lna[879]}<br>{$lna[880]}");
addpref("t", "linkperpage|{$lna[1153]}");
addpref("sec", "{$lna[593]}");
addpref("t", "emotperline|{$lna[679]}#|{$lna[680]}");
addpref("t", "emotperpage|{$lna[1146]}#|{$lna[680]}<br>{$lna[1147]}");
addpref("r", "censorall|{$lna[752]}|{$lna[511]}|{$lna[512]}");
addpref("r", "antispam|{$lna[594]}|{$lna[511]}|{$lna[512]}|<br><a href='admin.php?go=misc_forbidden#f_suspect'><b>{$lna[595]}</b></a><br>{$lna[596]}");
addpref("t", "susurlnum|{$lna[597]}<br>{$lna[598]}|{$lna[539]}");
addpref("t", "susminchar|{$lna[597]}<br>{$lna[599]}|{$lna[542]}");
addpref("t", "editcomment|{$lna[1078]}|{$lna[296]}<br>{$lna[1079]}");
addpref("r", "allowtrackback|{$lna[1016]}|{$lna[511]}|{$lna[512]}");
addpref("t", "maxtblen|{$lna[600]}|{$lna[542]}");
addpref("sel", "tbfilter|{$lna[941]}|0>>{$lna[942]}<<1>>{$lna[943]}<<2>>{$lna[944]}<<3>>{$lna[945]}|<br>{$lna[946]}");
addpref("r", "tburlexpire|{$lna[1049]}|{$lna[511]}|{$lna[512]}|<br>{$lna[1050]}");
addpref("r", "tburljs|{$lna[1053]}|{$lna[511]}|{$lna[512]}|<br>{$lna[1054]}");
addpref("r", "tburlmath|{$lna[1051]}|{$lna[511]}|{$lna[512]}|<br>{$lna[1052]}");

/*vot*/ if (@$flset['tags']!=1) {
	addpref("sec", "{$lna[601]}");
	addpref("t", "tagminsize|{$lna[602]}|px");
	addpref("t", "tagmaxsize|{$lna[603]}|px");
	addpref("sel", "tagorder|{$lna[960]}|0>>{$lna[961]}<<1>>{$lna[962]}<<2>>{$lna[963]}|");
	addpref("r", "tagunderlinetospace|{$lna[1077]}|{$lna[511]}|{$lna[512]}");
	addpref("t", "tagperpage|{$lna[1148]}");
}

addpref("sec", "{$lna[604]}");
addpref("r", "regadvance|{$lna[605]}|{$lna[606]}|{$lna[607]}|");
addpref("t", "minusenamelen|{$lna[611]}|{$lna[612]}");
addpref("t", "maxusenamelen|{$lna[613]}|{$lna[612]}");
addpref("t", "minpswlen|{$lna[614]}|{$lna[612]}");
addpref("r", "enableopenid|{$lna[1189]}|{$lna[511]}|{$lna[512]}|<br>{$lna[1190]}");
addpref("sec", "{$lna[615]}");
addpref("r", "searchon|{$lna[616]}|{$lna[511]}|{$lna[512]}|^global^<br><a href='admin.php?go=misc_forbidden#f_nosearch'>{$lna[617]}</a>");
addpref("t", "keymin|{$lna[618]}|{$lna[612]}");
addpref("t", "keymax|{$lna[619]}|{$lna[612]}");
addpref("t", "maxresults|{$lna[620]}|{$lna[539]}<br>{$lna[621]}");
addpref("sec", "{$lna[622]}");
addpref("t", "maxrssitem|{$lna[623]}|{$lna[570]}");
addpref("r", "wholerss|{$lna[624]}|{$lna[625]}|{$lna[626]}");
addpref("sec", "{$lna[627]}");
addpref("r", "main_list|{$lna[628]}|{$lna[629]}|{$lna[630]}");
addpref("r", "cate_list|{$lna[631]}|{$lna[629]}|{$lna[630]}");
addpref("r", "tag_list|{$lna[632]}|{$lna[629]}|{$lna[630]}");
addpref("r", "archive_list|{$lna[633]}|{$lna[629]}|{$lna[630]}");
addpref("r", "showday_list|{$lna[634]}|{$lna[629]}|{$lna[630]}");
addpref("r", "starred_list|{$lna[635]}|{$lna[629]}|{$lna[630]}");
addpref("r", "extendcategory|{$lna[955]}|{$lna[956]}|{$lna[957]}");
addpref("sel", "parentcatenum|{$lna[966]}|0>>{$lna[967]}<<1>>{$lna[968]}<<2>>{$lna[969]}");
addpref("sec", "{$lna[983]}");
addpref("r", "uploadfolders|{$lna[970]}|{$lna[971]}|{$lna[972]}|<br>{$lna[973]}");
addpref("r", "countdownload|{$lna[1011]}|{$lna[511]}|{$lna[512]}|<br>{$lna[1012]}");
addpref("sel", "antileech|{$lna[1154]}|0>>{$lna[1155]}<<1>>{$lna[1156]}<<2>>{$lna[1158]}|<br>{$lna[1157]}");
addpref("ta", "alloweddomain|{$lna[1159]}|<br>{$lna[1160]}");
addpref("r", "wmenable|{$lna[984]}|{$lna[511]}|{$lna[512]}|<br>{$lna[985]}");
addpref("t", "wmsize|{$lna[986]}|{$lna[987]}");
addpref("sel", "wmposition|{$lna[988]}|0>>{$lna[989]}<<3>>{$lna[990]}<<1>>{$lna[991]}<<2>>{$lna[992]}<<4>>{$lna[993]}<<5>>{$lna[994]}");
addpref("t", "wmpadding|{$lna[995]}|{$lna[996]}");
addpref("t", "wmtrans|{$lna[997]}|<br>{$lna[998]}");

/*vot*/ if (@$flset['avatar']!=1) {
	addpref("sec", "{$lna[881]}");
	addpref("r", "avatar|{$lna[608]}|{$lna[609]}|{$lna[610]}|<br><a href='admin.php?go=misc_avatar'>{$lna[891]}</a>");
	addpref("r", "usergravatar|{$lna[883]}|{$lna[609]}|{$lna[610]}|");
	addpref("r", "visitorgravatar|{$lna[884]}|{$lna[609]}|{$lna[610]}|");
	addpref("t", "gravatarurl|{$lna[885]}");
	addpref("r", "leftavatar|{$lna[886]}|{$lna[888]}|{$lna[887]}|");
	addpref("t", "avatarwidth|{$lna[889]}|{$lna[879]}");
	addpref("t", "avatarheight|{$lna[890]}|{$lna[879]}");
}

addpref("sec", "{$lna[1045]}");
addpref("sel", "lunarcalendar|{$lna[1030]}#|0>>{$lna[534]}<<1>>{$lna[1031]}<<2>>{$lna[1032]}");
addpref("sel", "timeformat|{$lna[1035]}|Y/m/d>>{$lna[1036]}<<m/d/Y>>{$lna[1037]}<<d/m/Y>>{$lna[1038]}<<Y-n-j>>{$lna[1039]}<<F j, Y>>{$lna[1040]}<<custom>>{$lna[1041]}");
addpref("t", "customtimeformat|{$lna[1042]}|<br>{$lna[1043]}");
addpref("sel", "archiveformat|{$lna[1044]}|Y/m>>{$lna[1046]}<<F Y>>{$lna[1047]}<<custom>>{$lna[1041]}");
addpref("t", "customarchiveformat|{$lna[1048]}|<br>{$lna[1043]}");
