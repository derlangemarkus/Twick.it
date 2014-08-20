<?php
/*
 * Created at 26.05.2009
 *
 * @author Markus Moeller
 */
require_once("util/inc.php");
 
$shortUrlId = getArrayElement($_GET, "id");

$id = convertIdToLong($shortUrlId);

$topic = Topic::fetchById($id);

if ($topic) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: " . $topic->getUrl());
	exit;
} else {
	//echo("Beitrag $id nicht gefunden");
	redirect(HTTP_ROOT . "/404.php");
	exit;
}
?>