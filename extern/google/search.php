<?php
apc_clear_cache();
header("Content-Type: text/html; charset=utf-8"); 
ini_set("display_errors", 1); 
$search = $_GET["q"];

function insertAfter($inText, $inSeparator, $inInsert) {
	$index = strpos($inText, $inSeparator);
	if ($index !== false) {
		$before = substr($inText, 0, $index+strlen($inSeparator));
		$after = substr($inText, $index+strlen($inSeparator));
		
		return $before . $inInsert . $after;
	}
}


function processXml($inXml) {
	global $twickit;
	if ($inXml && $inXml->topics->children()) {
	$topics = $inXml->topics->children();
	foreach($topics as $topic) {
		$text = str_replace("'", "&#27;", $topic->twicks->twick->text);
		$url = str_replace("'", "%27", $topic->twicks->twick->url);
		$link = $topic->twicks->twick->link;
		$title = $topic->title;
		
		$twickit .= "<div style='display:block;padding:2px;font-family:arial,sans-serif;font-size:small;'>";
		$twickit .= "<a href='$url' style='font-weight:bold;'>$title</a>: $text";
		if (trim($link)) {
			$twickit .= " (<a href='$link'>$link</a>)";
		}
		$twickit .= "</div>";
	}
} 
}

// Twick.it
$twickit = "";
$xml = simplexml_load_file("http://twick.it/interfaces/api/explain.xml?limit=-1&search=" . urlencode($search));
processXml($xml);

if (!$twickit) {
	$xml = simplexml_load_file("http://twick.it/interfaces/api/explain.xml?limit=-1&similar=1&search=" . urlencode($search));
	processXml($xml);
}

if ($twickit) {
	$twickit = "<div style='display:block;border:4px solid #84b204;padding:5px;margin:5px 0px 14px -5px;'><table><tr><td valign='top'>$twickit</td><td valign='top'><a href='http://twick.it'><img src='http://twick.it/extern/google/logo.jpg' border='0'/></a></td></tr></table></div>";
}

// Google
$google = utf8_encode(file_get_contents("http://www.google.de/search?q=" . urlencode($search)));


$css = "
<style type='text/css'>
body {
color:#000000;
margin:3px 0;
}
body, #leftnav, #tbd, #atd, #tsf, #hidden_modes, #hmp {
background:none repeat scroll 0 0 #FFFFFF;
}
#gog {
background:none repeat scroll 0 0 #FFFFFF;
}
#gbar, #guser {
font-size:13px;
padding-top:1px !important;
}
#gbar {
float:left;
height:22px;
}
#guser {
padding-bottom:7px !important;
text-align:right;
}
.gbh, .gbd {
border-top:1px solid #C9D7F1;
font-size:1px;
}
.gbh {
height:0;
position:absolute;
top:24px;
width:100%;
}
#gbs, .gbm {
background:none repeat scroll 0 0 #FFFFFF;
left:0;
position:absolute;
text-align:left;
visibility:hidden;
z-index:1000;
}
.gbm {
border-color:#C9D7F1 #3366CC #3366CC #A2BAE7;
border-style:solid;
border-width:1px;
z-index:1001;
}
.gb1 {
margin-right:0.5em;
}
.gb1, .gb3 {
}
.gb2 {
display:block;
padding:0.2em 0.5em;
}
.gb2, .gb3 {
border-bottom:medium none;
text-decoration:none;
}
a.gb1, a.gb2, a.gb3, a.gb4 {
color:#0000CC !important;
}
a.gb2:hover {
background:none repeat scroll 0 0 #3366CC;
color:#FFFFFF !important;
}
a.gb1, a.gb2, a.gb3, .link {
color:#1111CC !important;
}
.ts {
border-collapse:collapse;
}
.ts td {
padding:0;
}
.ti, .bl, form, #res h3 {
display:inline;
}
.ti {
display:inline-table;
}
.fl, .fl a, .flt, .gl a:link, a.mblink, .mblink b {
color:#4272DB !important;
}
#tads a.mblink, #tads a.mblink b, #rhs a.mblink, #rhs a.mblink b {
color:#4272DB !important;
}
a:link, .w, #prs a:visited, #prs a:active, .q:active, .q:visited {
color:#1111CC;
}
.mblink:visited, a:visited {
color:#551A8B;
}
a:active {
color:#CC1111;
}
.vst:link {
color:#551A8B;
}
.cur, .b {
font-weight:bold;
}
.j {
font-size:82%;
width:42em;
}
.s {
max-width:42em;
}
.sl {
font-size:82%;
}
#gb {
margin:0;
padding:1px 0 7px;
text-align:right;
}
.hd {
height:1px;
overflow:hidden;
position:absolute;
top:-1000em;
width:1px;
}
.gl, .f, .m, .c h2, #mbEnd h2, #tads h2, .descbox {
color:#767676;
}
.a, cite, cite a:link, cite a:visited, .cite, .cite:link, #mbEnd cite b, #tads cite b {
color:#228822;
font-style:normal;
}
.ng {
color:#CC1111;
}
h1, ol, ul, li {
margin:0;
padding:0;
}
li.g, body, html, .std, .c h2, #mbEnd h2, h1 {
font-family:arial,sans-serif;
font-size:small;
}
.c h2, #mbEnd h2, h1 {
font-weight:normal;
}
.clr {
clear:both;
margin:0 8px;
}
.blk a {
color:#000000;
}
#nav a {
display:block;
}
#nav .i {
color:#A90A08;
font-weight:bold;
}
.csb, .ss, #logo span, .play_icon, .mini_play_icon, .micon, .close_btn, #tbp, .lsb, .mbi {
background:url('/images/srpr/nav_logo13.png') no-repeat scroll 0 0 transparent;
overflow:hidden;
}
.csb, .ss {
background-position:0 0;
display:block;
height:40px;
}
.ss {
background-position:0 -91px;
left:0;
position:absolute;
top:0;
}
.cps {
height:18px;
overflow:hidden;
width:114px;
}
.mbi {
background-position:-153px -70px;
display:inline-block;
float:left;
height:13px;
margin-right:3px;
margin-top:1px;
width:13px;
}
#nav td {
padding:0;
text-align:center;
}
#logo {
display:block;
height:49px;
margin:11px 0 7px;
overflow:hidden;
position:relative;
width:137px;
}
#logo img {
border:medium none;
left:0;
position:absolute;
top:-41px;
}
.ws, .wsa, .wxs, .wpb {
background:url('/images/srpr/nav_logo13.png') no-repeat scroll 0 0 transparent;
border:0 none;
cursor:pointer;
display:none;
height:0;
margin-right:3px;
vertical-align:bottom;
width:0;
}
.ws, .wsa {
display:inline;
height:14px;
margin-left:5px;
vertical-align:6px;
width:14px;
}
.ws {
background-position:-117px -117px;
}
.wsa {
background-position:-102px -117px;
}
.wxs {
cursor:default;
display:inline;
margin-left:8px;
}
.wpb {
background-position:-153px -70px;
display:inline;
height:13px;
vertical-align:5px;
width:13px;
}
.wcd {
margin-top:2px;
max-width:42em;
}
button::-moz-focus-inner {
border:0 none;
}
.link {
color:#0000CC;
cursor:pointer;
text-decoration:underline;
}
.link:active {
color:red;
}
#logo span, .ch {
cursor:pointer;
}
h3, .med {
font-size:medium;
font-weight:normal;
margin:0;
padding:0;
}
.e {
margin:2px 0 0.75em;
}
.slk div {
padding-left:12px;
text-indent:-10px;
}
.fc {
margin-top:0.5em;
padding-left:16px;
}
#mbEnd cite {
display:block;
text-align:left;
}
#rhs_block {
margin-bottom:-20px;
}
#bsf, .blk {
background:none repeat scroll 0 0 #F0F7F9;
border-top:1px solid #6B90DA;
}
#bsf {
border-bottom:1px solid #6B90DA;
}
#cnt {
clear:both;
}
#res {
margin:0 16px;
padding-right:1em;
}
.c {
background:none repeat scroll 0 0 #FFF8E7;
margin:0 8px;
}
.c li {
margin:0;
padding:0 3px 0 8px;
}
#mbEnd li {
margin:1em 0;
padding:0;
}
.xsm {
font-size:x-small;
}
ol li {
list-style:none outside none;
}
#ncm ul li {
list-style-type:disc;
}
.sm li {
margin:0;
}
.gl, #foot a, .nobr {
white-space:nowrap;
}
#mbEnd .med {
white-space:normal;
}
.sl, .r {
display:inline;
font-weight:normal;
margin:0;
}
.r {
font-size:medium;
}
h4.r {
font-size:small;
}
.mr {
margin-top:6px;
}
h3.tbpr {
margin-bottom:1.2em;
margin-top:0.4em;
}
img.tbpr {
border:0 none;
height:15px;
margin-right:3px;
width:15px;
}
.jsb {
display:block;
}
.nojsb {
display:none;
}
.nwd {
font-size:10px;
padding:16px;
text-align:center;
}
.rt1 {
background:url('/images/bubble1.png') no-repeat scroll 0 0 transparent;
}
.rt2 {
background:url('/images/bubble2.png') repeat scroll 0 0 transparent;
}
.sb {
background:url('/images/scrollbar.png') repeat scroll 0 0 transparent;
cursor:pointer;
width:14px;
}
.rtdm:hover {
text-decoration:underline;
}
#rtr .g {
margin:1em 0;
}
#ss-box {
background:none repeat scroll 0 0 #FFFFFF;
border-color:#C9D7F1 #3366CC #3366CC #A2BAE7;
border-style:solid;
border-width:1px;
left:0;
margin-top:0.1em;
position:absolute;
visibility:hidden;
z-index:101;
}
#ss-box a {
display:block;
padding:0.2em 0.31em;
text-decoration:none;
}
#ss-box a:hover {
background:none repeat scroll 0 0 #3366CC;
color:#FFFFFF !important;
}
a.ss-selected {
color:#000000 !important;
font-weight:bold;
}
a.ss-unselected {
color:#4273DB !important;
}
.ss-selected .mark {
display:inline;
}
.ss-unselected .mark {
visibility:hidden;
}
#ss-barframe {
background:none repeat scroll 0 0 #FFFFFF;
left:0;
position:absolute;
visibility:hidden;
z-index:100;
}
.ri_cb {
left:0;
margin:6px;
position:absolute;
top:0;
z-index:1;
}
.ri_sp {
display:inline-block;
margin-bottom:6px;
text-align:center;
vertical-align:top;
}
.ri_sp img {
vertical-align:bottom;
}
.mbl {
margin:1em 0 0;
}
em {
font-style:normal;
font-weight:bold;
}
li .ws {
opacity:0.5;
}
li:hover .ws {
opacity:1;
}
ol, ul, li {
border:0 none;
margin:0;
padding:0;
}
li {
line-height:1.2;
}
li.g {
margin-bottom:12px;
margin-top:0;
}
.ibk, #productbox .fmg {
display:inline-block;
vertical-align:top;
}
.tsw {
width:595px;
}
#cnt {
max-width:1144px;
min-width:780px;
padding-top:17px;
}
.gbh {
top:24px;
}
#gbar {
height:20px;
margin-left:8px;
}
#guser {
margin-right:8px;
padding-bottom:5px !important;
}
#logo {
height:49px;
margin:9px 0 0;
width:137px;
}
.lst {
-moz-box-sizing:content-box;
border-color:#CCCCCC #CCCCCC -moz-use-text-color;
border-style:solid solid none;
border-width:1px 1px medium;
float:left;
font:18px arial,sans-serif;
height:26px;
padding:4px 10px 0 6px;
vertical-align:top;
width:100%;
}
.lst-td {
border-bottom:1px solid #999999;
padding-right:16px;
}
.ds {
border-right:1px solid #E7E7E7;
height:32px;
position:relative;
z-index:100;
}
.lsbb {
background:none repeat scroll 0 0 #EEEEEE;
border-color:#CCCCCC #999999 #999999 #CCCCCC;
border-right:1px solid #999999;
border-style:solid;
border-width:1px;
height:30px;
}
.lsb {
background-position:center bottom;
border:medium none;
cursor:pointer;
font:15px arial,sans-serif;
height:30px;
margin:0;
vertical-align:top;
}
.lsb:active {
background:none repeat scroll 0 0 #CCCCCC;
}
.lst:focus {
outline:medium none;
}
.lsd {
font-size:11px;
height:32px;
position:absolute;
right:0;
top:12px;
width:256px;
}
.mbi {
margin-bottom:-1px;
}
.tsf-p {
margin-left:168px;
margin-right:272px;
max-width:711px;
}
.uc {
margin-left:159px;
}
#center_col, #foot {
margin-left:159px;
margin-right:264px;
padding:0 8px;
}
#subform_ctrl {
font-size:11px;
margin-left:176px;
margin-right:272px;
max-width:695px;
min-height:26px;
padding-top:3px;
position:relative;
z-index:11;
}
#center_col {
border-left:1px solid #D3E1F9;
clear:both;
}
#brs p {
margin:0;
padding-top:5px;
}
.brs_col {
display:inline-block;
float:left;
font-size:small;
padding-right:16px;
position:relative;
top:-1px;
white-space:nowrap;
}
#tads {
margin-bottom:8px !important;
}
#tads li {
padding:1px 0;
}
#tads li.taf {
padding:1px 0 0;
}
#tads li.tam {
padding:12px 0 0;
}
#tads li.tal {
padding:12px 0 1px;
}
#res {
border:0 none;
margin:0;
padding:4px 8px 0;
}
#ires {
padding-top:1px;
}
#wrz .link, #wsz .link {
color:#4272DB !important;
text-decoration:none;
}
#wrz .link:hover, #wsz .link:hover {
text-decoration:underline;
}
.mbl {
margin-top:5px;
}
.play_icon {
margin-left:64px;
margin-top:44px;
}
#leftnav li {
display:block;
}
.micon, .close_btn {
border:0 none;
}
#leftnav h2 {
color:#767676;
font-size:small;
font-weight:normal;
margin:8px 0 0;
padding-left:8px;
width:143px;
}
#tbbc dfn {
padding:4px;
}
.close_btn {
background-position:-138px -84px;
float:right;
height:14px;
width:14px;
}
.videobox {
padding-bottom:3px;
}
#leftnav a {
text-decoration:none;
}
#leftnav a:hover {
text-decoration:underline;
}
.mitem, #showmodes {
font-size:15px;
line-height:24px;
padding-left:8px;
}
.mitem {
margin-bottom:2px;
}
.mitem .q {
display:block;
}
.msel {
font-weight:bold;
height:22px;
margin-bottom:0;
padding-bottom:2px;
}
.micon {
float:left;
height:19px;
margin-right:5px;
margin-top:2px;
outline:medium none;
padding-right:1px;
width:19px;
}
#showmodes .micon {
background-position:-150px -114px;
height:17px;
margin-left:1px;
margin-right:5px;
width:17px;
}
.open #showmodes .micon {
background-position:-132px -114px;
}
.open .msm, .msl {
display:none;
}
.open .msl {
display:inline;
}
.open #hidden_modes, .open #hmp {
display:block;
}
#swr li {
border:0 none;
font-size:13px;
line-height:1.2;
margin:0 8px 4px 0;
padding-left:1px;
}
#tbd, #atd {
display:block;
margin-top:8px;
min-height:1px;
}
.tbt {
font-size:13px;
line-height:1.2;
}
.tbou, .tbos, .tbots, .tbotu {
margin-right:8px;
padding-bottom:3px;
padding-left:16px;
text-indent:-8px;
}
.tbos, .tbots {
font-weight:bold;
}
#leftnav .tbots a {
color:#000000 !important;
cursor:default;
text-decoration:none;
}
.tbfo .tbt, .tbpd {
margin-bottom:8px;
}
.tbpc, .tbpo {
font-size:13px;
}
.tbpc, .tbo .tbpo {
display:inline;
}
.tbo .tbpc, .tbpo {
display:none;
}
.tbo #tbp {
background-position:-138px -99px !important;
}
#prc_opt label, #prc_ttl {
display:block;
font-weight:normal;
margin-right:2px;
white-space:nowrap;
}
#cdr_opt, #loc_opt {
padding-left:8px;
text-indent:0;
}
.tbou #cdr_frm, .tbou #cloc_frm {
display:none;
}
#cdr_frm, #cdr_min, #cdr_max {
width:88%;
}
#cdr_opt label {
display:block;
font-weight:normal;
margin-right:2px;
white-space:nowrap;
}
.bksg {
font-size:82%;
line-height:130%;
padding:2px;
vertical-align:top;
}
.bkst div {
background-color:#F9F9F9;
border:1px solid #E0E0E0;
color:#666666;
font-size:small;
text-align:center;
}
#mbEnd, .rhss {
margin:0 0 32px 8px;
}
#mbEnd h2 {
color:#767676;
}
#mbEnd li {
margin:12px 0 0;
}
a:link, .w, .q:active, .q:visited, .tbotu {
color:#1111CC;
cursor:pointer;
}
.osl a, .gl a, #tsf a, a.mblink, a.gl, a.fl, .slk a, .bc a, .flt, a.flt u, .oslk a {
text-decoration:none;
}
.osl a:hover, .gl a:hover, #tsf a:hover, a.mblink:hover, a.gl:hover, a.fl:hover, .slk a:hover, .bc a:hover, .flt:hover, a.flt:hover u, .oslk a:hover, .tbotu:hover {
text-decoration:underline;
}
.hpn, .osl {
color:#767676;
}
div#gbi, div#gbg {
border-color:#A2BFF0 #558BE3 #558BE3 #A2BFF0;
}
div#gbi a.gb2:hover, div#gbg a.gb2:hover, .mi:hover {
background-color:#558BE3;
}
#guser a.gb2:hover, .mi:hover, .mi:hover * {
color:#FFFFFF !important;
}
#guser {
color:#000000;
}
#imagebox_big img {
padding:2px !important;
}
#productbox table.ts {
color:#767676;
}
#productbox table.ts a {
text-decoration:underline;
}
#productbox .fmg {
margin-top:7px;
padding-right:8px;
text-align:left;
}
#foot .ftl {
margin-right:12px;
}
#foot a.slink {
color:#4272DB;
text-decoration:none;
}
#fll a, #bfl a {
color:#4272DB;
margin:0 12px;
text-decoration:none;
}
#foot a:hover {
text-decoration:underline;
}
#foot a.slink:visited {
color:#551A8B;
}
#blurbbox_bottom {
color:#767676;
}
.nvs a {
text-decoration:underline;
}
.stp {
margin:7px 0 17px;
}
.ssp {
margin:0.33em 0 17px;
}
</style>
";


$google = insertAfter($google, '<div id="ires">', $twickit);
$google = insertAfter($google, "<head>", "<base href='http://www.google.de' /><script type='text/javascript' src='http://twick.it/html/js/scriptaculous/lib/prototype.js'></script><script type='text/javascript' src='http://twick.it/interfaces/js/popup/twickit.js'></script>");
//$google = str_replace('/images/srpr/nav_logo13.png', 'http://google.de/images/srpr/nav_logo13.png', $google);
$google = str_replace('src="/images/', 'src="http://google.de/images/', $google);
$google = str_replace('action="/search"', 'action="http://'. $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . '"', $google);


echo($google);
?>