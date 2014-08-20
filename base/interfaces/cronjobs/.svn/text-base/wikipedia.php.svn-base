<?php
require_once("../../util/inc.php"); 
require_once("../../util/thirdparty/wikimate/lib/curl.php"); 
require_once("../../util/thirdparty/wikimate/config.php"); 
require_once("../../util/thirdparty/wikimate/Wikimate.php"); 
require_once("../../util/thirdparty/wikimate/lib/curl_response.php"); 

header("Content-Type: text/plain; charset=UTF-8");

checkCronjobLogin();


$content = "Diese Seite zeigt Themen, die bei Wikipedia fehlen, bei [[Twick.it]] aber bereits erklärt wurden. Stand: " . date("d.m.Y H:i:s");
$content .= "\n== Zahlen ==\n";
$counter = 0;
$queue = array();
$prevChar = null;
foreach(Topic::fetchAll(array("ORDER BY"=>"title")) as $topic) {
	$title = $topic->getTitle();
	$wikipedia = Topic::getWikipediaLink($title);
	if(!$wikipedia) {
		$char = strtoupper(substr($title, 0, 1));
		if ($prevChar != $char) {
			if(!is_numeric($char)) {
				$prevChar = $char;
				$content .= "* [[" . implode("]]\n* [[", $queue) . "]]\n\n";
				$content .= "\n== $char ==\n";
				$queue = array();
			}
		}

		$queue[] = $title;
		
		$counter ++;
		if($counter > 2000) {
			break;
		}
	}
}
$content .= "* [[" . implode("]]\n* [[", $queue) . "]]\n\n";
echo($content);

$wiki = new Wikimate();
$page = $wiki->getPage('Benutzer:Derlangemarkus/test');
$page->getText(1);
$page->setText($content);


?>