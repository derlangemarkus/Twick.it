<?php
require_once("../../../util/inc.php"); 
header("Content-Type: text/javascript; charset=utf-8");

$text = getArrayElement($_GET, "t");
$disableCreate = getArrayElement($_GET, "dc");
$disableGeo = getArrayElement($_GET, "dg");

$suggest = "";
$topics = Topic::fetchBySimilarTitle($text, 5, false, true);
$topics = array_merge($topics, Topic::findRelatedTopicsByStemming($text, false, 5));
$found = array();
foreach($topics as $topic) {
	if(in_array($topic->getId(), $found)) {
		continue;
	} else {
		$found[] = $topic->getId();
	}
	$twick = $topic->findBestTwick();
	$suggest .= "<a href='" . $topic->getUrl() . "' class='twick'>" . $topic->getTitle() . "</a>"; 
    if(!$disableGeo && $topic->hasCoordinates()) {
        $map = "http://maps.google.de/maps?z=12&q=" . $topic->getLatitude() . "," . $topic->getLongitude();
        $suggest .= "&nbsp;<a href='" . $map . "' target='_blank'><img src='http://static.twick.it/html/img/world.png' class='twicktip_geo'/></a>";
    }
    $suggest .= "<br />" . str_replace('"', '\"', $twick->getText()) . "<br />";
}

$closeLink = "<a href='javascript:;' onclick='document.getElementById(\\\"twicktip\\\").style.display=\\\"none\\\";' style='float:right;font-weight:bold;' id='twicktip_close'>&nbsp;</a>";

if ($suggest) {
	?>TwickitBubble.fill("<?php echo($closeLink . $suggest) ?>", false);<?php
} else {
    if ($disableCreate) {
    ?>TwickitBubble.fill("<?php loc('interfaces.js.popup.noMatches') ?>", true);<?php
    } else {
    ?>
    var link = "<a href='<?php echo(HTTP_ROOT) ?>/show_topic.php?title=<?php echo(urlencode($text)) ?>' target='_blank'><?php loc('interfaces.js.popup.create') ?></a>";
    TwickitBubble.fill("<?php echo($closeLink) ?><?php loc('interfaces.js.popup.noMatches') ?><br />" + link, false);
    <?php
    }
}
?>