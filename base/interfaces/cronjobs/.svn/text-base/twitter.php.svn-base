<?php
require_once("../../util/inc.php");
require_once("../../util/thirdparty/oauth/TwitterOAuth.php");

checkCronjobLogin();

$topics = array();
for($i=0; $i<1; $i++) {
	$oldest = null;
	$found = false;
	foreach(Topic::fetchRandom(2500) as $topic) {
		$twick = $topic->findBestTwick();
		if (strtotime($twick->getCreationDate()) < (time()-60*60*24*21)) {
            $txt = $twick->getTitle() . ": " . $twick->getText();
            if(mb_strlen($txt, "utf8") <= 140) {
                $topics[] = $topic;
                $found = true;
                break;
            }
		}
		
		if ($oldest == null || $topic->getCreationDate() < $oldest->getCreationDate()) {
			$oldest = $topic;
		}
	}
	
	if (!$found) {
		// Wenn ich kein Thema gefunden habe, dass aelter als 21 Tage ist, dann nimm das aelteste, das gefunden wurde.
		$topics[] = $oldest;
	}
	
}

#$topics = Topic::fetchByTitle("Nikosia");

print_rr($topics);

$result = "";
foreach($topics as $topic) { 
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
	
	if(mb_strlen($txtWithLink, "utf8") <= 140) {
		$txt = $txtWithLink;
	}
	
	if(trim($twick->getAcronym()) && mb_strlen($txtWithAccronym, "utf8") <= 140) {
		$txt = $txtWithAccronym;
	}
	
	if (getLanguage() == "de") {
		$oauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_TOPIC_DE_OAUTH, TWITTER_TOPIC_DE_OAUTH_SECRET);
	} else {
		$oauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_TOPIC_EN_OAUTH, TWITTER_TOPIC_EN_OAUTH_SECRET);
	}
	$infos = array('status' => $txt);
	if ($topic->hasCoordinates()) {
		$infos["lat"] = $topic->getLatitude();
		$infos["long"] = $topic->getLongitude();
	}

	$oauth->post('statuses/update', $infos);
}

echo($result);
?>
Fertig