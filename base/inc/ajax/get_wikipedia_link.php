<?php
require_once("../../util/inc.php");

header("Content-Type: application/json; charset=utf-8"); 

$title = getArrayElement($_GET, "title");
$wikipediaLink = Topic::getWikipediaLink($title);

if (!$wikipediaLink) {
	exit;
}


echo(
	json_encode(
		array(
			"link" => (string)$wikipediaLink[0],
			"title" => (string)$wikipediaLink[1],
			"description" => str_replace("\n", "", $wikipediaLink[2])
		)
	)
);
?>