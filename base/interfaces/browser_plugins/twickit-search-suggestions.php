<?php
require_once("../../util/inc.php"); 
header("Content-Type: application/json; charset=utf-8"); 

$search = getArrayElement($_GET, "search");
$topics = Topic::fetchBySimilarTitle($search);

$titles = "";
$tags = "";
$separator = "";

foreach($topics as $topic) {
	$titles .= $separator . "\"" . $topic->getTitle() . "\"";
	$tags .= $separator . "\"" . $topic->getTagsAsString() . "\"";
	$separator = ", ";
}

?>
["<?php jecho($search) ?>", [<?php echo($titles)?>], [<?php echo($tags)?>]]
