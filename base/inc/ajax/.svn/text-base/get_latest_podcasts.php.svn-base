<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php");

header("Content-Type: application/json; charset=utf-8"); 

$offset = getArrayElement($_GET, "offset", 0);

$podcasts = array();
foreach(Podcast::fetchLatest(10, $offset) as $podcast) {
    $podcasts[] = array("url"=>$podcast->getUrl(), "title"=>$podcast->getTitle());
}

echo(json_encode(array("data"=>$podcasts)));
?>
