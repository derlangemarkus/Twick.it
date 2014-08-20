<?php
require_once("../../../util/inc.php"); 
header("Content-Type: text/javascript; charset=utf-8");

$text = getArrayElement($_GET, "text");

$suggest = "";
$topics = Topic::fetchBySimilarTitle($text, 25, false, true);
foreach($topics as $topic) {
	$twick = $topic->findBestTwick();
	$suggest .= "<div><a href='" . $topic->getUrl() . "' class='twick' target='_blank'>" . $topic->getTitle() . "</a><br />" . str_replace('"', '\"', $twick->getText()) . "</div>";
}
?>TwickitSearchInclude.callback("<?php echo($suggest) ?>");