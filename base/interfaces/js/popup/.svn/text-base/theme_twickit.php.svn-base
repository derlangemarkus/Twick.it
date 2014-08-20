<?php
require_once("../../../util/inc.php");
$color = getArrayElement($_GET, "color");
$color = $color && !in_array($color, array("null", "undefined")) ? $color : "B3D361";
$text = getArrayElement($_GET, "text");
$text = $text && !in_array($text, array("null", "undefined")) ? $text : "000";

$title = getArrayElement($_GET, "title");
$title = $title && !in_array($title, array("null", "undefined")) ? $title : "FFF";

header("Content-Type: text/css; charset=utf-8"); 
?>div#twicktip{position:absolute;padding:8px;width:320px;height:auto;font-weight:normal;color:#<?php echo($text) ?>;text-align:left;z-index:9999}
div#twicktip table{border:none}
div#twicktip td, div#twicktip th, div#twicktip tr{padding:0px;margin:0px;border:none;background-color:transparent}
div#twicktip a.twick, div#twicktip a.twick:link, div#twicktip a.twick:active, div#twicktip a.twick:visited, div#twicktip a.twick:hover{font-weight:bold;padding-top:7px;color:#<?php echo($title) ?>}
div#twicktip #twicktip_tl{background-color:transparent;}
div#twicktip #twicktip_tm{background-color:transparent;height:7px;background-image:url(http://twick.it/interfaces/js/popup/triangle.php?color=<?php echo($color) ?>);background-repeat:no-repeat;background-position:3px 0px}
div#twicktip #twicktip_tr{background-color:transparent;}
div#twicktip #twicktip_ul{width:10px;height:10px;background-color:#<?php echo($color) ?>;border-top-left-radius:10px;-moz-border-radius-topleft:10px;-webkit-border-radius-topleft:10px}
*+html div#twicktip #twicktip_ul{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:0px 0px}
*+html div#twicktip #twicktip_ul{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:0px 0px}
div#twicktip #twicktip_um{height:10px;display:block;background-color:#<?php echo($color) ?>}
div#twicktip #twicktip_ur{width:10px;height:10px;background-color:#<?php echo($color) ?>;border-top-right-radius:10px;-moz-border-radius-topright:10px;-webkit-border-radius-topright:10px}
*+html div#twicktip #twicktip_ur{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:10px 0px}
* html div#twicktip #twicktip_ur{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:10px 0px}
div#twicktip #twicktip_ml{width:10px;background-color:#<?php echo($color) ?>}
div#twicktip #twicktip_mm{background-color:#<?php echo($color) ?>}
div#twicktip #twicktip_mr{width:10px;background-color:#<?php echo($color) ?>}
div#twicktip #twicktip_ll{width:10px;height:10px;background-color:#<?php echo($color) ?>;border-bottom-left-radius:10px;-moz-border-radius-bottomleft:10px;-webkit-border-radius-bottomleft:10px}
*+html div#twicktip #twicktip_ll{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:0px 10px}
* html div#twicktip #twicktip_ll{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:0px 10px}
div#twicktip #twicktip_lm{height:10px;display:block;background-color:#<?php echo($color) ?>}
div#twicktip #twicktip_lr{width:10px;height:10px;background-color:#<?php echo($color) ?>;border-bottom-right-radius:10px;-moz-border-radius-bottomright:10px;-webkit-border-radius-bottomright:10px}
*+html div#twicktip #twicktip_lr{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:10px 10px}
* html div#twicktip #twicktip_lr{width:10px;height:10px;background-image:url(http://twick.it/interfaces/js/popup/circle.php?color=<?php echo($color) ?>);background-position:10px 10px}
div#twicktip_wait{background-image:url(http://static.twick.it/html/img/ajax-loader.gif);background-repeat:no-repeat;background-position:top left;width:16px;height:11px}
a#twicktip_close{text-decoration:none;width:12px;background-image:url(http://static.twick.it/interfaces/js/popup/img/close.gif);background-repeat:no-repeat}
img.twicktip_geo{border:0;width:16px;height:16px;margin-left:7px;vertical-align:middle}