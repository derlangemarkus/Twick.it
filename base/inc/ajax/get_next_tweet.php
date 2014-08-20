<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php");

header("Content-Type: application/json; charset=utf-8"); 

$index = getArrayElement($_GET, "id", -1);

$reader = new TwitterReader();
list($index, $tweet) = $reader->getNext($index+1);

$author = strtolower(substringBetween($tweet->link, "twitter.com/", "/"));

echo(
	json_encode(
		array(
			"publish" => $tweet->pubDate,
			"link" => $tweet->link,
			"image" => TwitterReader::getTwitterAvatarUrl($author),
			"content" => str_replace("\n", "", nl2br($tweet->description)),
			"author_name" => $author,
			"author_url" => "http://twitter.com/$author",
			"id" => $index
		)
	)
);
?>
