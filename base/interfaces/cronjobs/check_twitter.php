<?php
require_once("../../util/inc.php"); 

checkCronjobLogin();

$userName = TWITTER_LOGIN  . "_" . getLanguage();
if (getArrayElement($_GET, "test")) {
	$userName .= "_test";	
}

$result = "";
foreach(Topic::fetchRandom(1) as $topic) { 
	$twick = $topic->findBestTwick();

	$title = "";
	$words = explode(" ", $twick->getTitle());
	$separator = "";
	foreach($words as $word) {
		if ($word == " " || $word == "") {
			$title .= $separator . $word;
		} else if (startsWith($word, "(") && endsWith($word, ")")) {
			$title .= "$separator(#" . substringBetween($word, "(", ")") . ")";
		} else {
			$title .= "$separator#$word";
		}
		$separator = " ";
	}
	//$txt = "#" . str_replace(" ", " #", $topic->getTitle()) . ": " . $twick->getText();
	$txt = $title . ": " . $twick->getText();
	$txtWithLink = $txt . " " . $topic->getShortUrl();
	$txtWithAccronym = $title . ": (" . $twick->getAcronym() . ") " . $twick->getText() . " " . $topic->getShortUrl();
	
	if(mb_strlen($txtWithLink, "utf8") < 200) {
		$txt = $txtWithLink;
	}
	
	if(trim($twick->getAcronym()) && mb_strlen($txtWithAccronym, "utf8") < 200) {
		$txt = $txtWithAccronym;
	}
	
	$data = "status=" . urlencode(stripslashes(urldecode($txt)));
	$fp = fsockopen("twitter.com", 80);
	fputs($fp, "POST /statuses/update.xml HTTP/1.1\r\n");
	fputs($fp, "Host: twitter.com\r\n");
	fputs($fp, "Authorization: Basic " . base64_encode($userName . ":" . TWITTER_PASSWORD) . "\r\n");
	fputs($fp, "Referer: Twick.it\r\n");
	fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs($fp, "Content-length: ". strlen($data) ."\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	fputs($fp, $data);
	while(!feof($fp)) {
		$result .= fgets($fp, 128);
	}
	fclose($fp);
}

?>
