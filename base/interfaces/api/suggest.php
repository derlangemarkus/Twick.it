<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

// Parameter auslesen
$search = utf8encode(getArrayElement($_GET, "search"));
$type = strtolower(getArrayElement($_GET, "type", "xml"));
$limit = getArrayElement($_GET, "limit", "");

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(60);
}

$topics = Topic::fetchBySimilarTitle($search, $limit);

header("Content-Type: application/json; charset=utf-8");
$suggests = array();
foreach($topics as $topic) {
    $suggests[] = array("id"=>$topic->getId(), "title"=>$topic->getTitle(), "url"=>$topic->getUrl());
}
echo(json_encode(array("query"=>$search, "topics"=>$suggests)));
?>