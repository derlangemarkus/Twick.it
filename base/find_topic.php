<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

// Parameter auslesen
$search = trim(getArrayElement($_GET, "search"));

$stat = new SearchStat();
$stat->setLanguage(getLanguage());
$stat->setCreationDate(getCurrentDate());
$stat->setUserId(getUserId());
$stat->setIp($_SERVER["REMOTE_ADDR"]);
$stat->setQuery($search);
if (getArrayElement($_GET, "tag")) {
	$stat->setTag(1);
}

if ($search == "") {
	redirect(HTTP_ROOT . "/index.php");
}

$topic = Topic::fetchByTitle($search);
if(empty($topic)) {
	$coreTitle = getCoreTitle($search);
	#$topic = Topic::fetchByCoreTitle($coreTitle);
}

if (sizeof($topic)) {
	// Thema gefunden
	$stat->setFound(1);
	$stat->save();
	
	$topic = array_shift($topic);
	redirect($topic->getUrl());
} else {
	$stat->setFound(0);
	$stat->save();
	
	$url = HTTP_ROOT . "/show_topic.php?title=" . urlencode($search);
	if (getArrayElement($_GET, "tag")) {
		$url .= "&tag=1";
	}
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: $url");
	redirect($url);
}
?>