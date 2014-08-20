<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 
if (!isLoggedIn()) {
	redirect("index.php");
}

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$title = trim(getArrayElement($_GET, "title"));
$acronym = trim(getArrayElement($_GET, "acronym"));
$text = trim(trim(getArrayElement($_GET, "text")));
$link = trim(getArrayElement($_GET, "link"));
$secret = getArrayElement($_GET, "secret");

if(mb_strlen($text, "utf8") > 140) {
	die ("An error accoured. Please contact support@twick.it");
}

if (strtolower($title) == strtolower($acronym)) {
	$acronym = "";
}

#$title = htmlspecialchars($title);
#$acronym = htmlspecialchars($acronym);
#$text = htmlspecialchars($text);
#$link = htmlspecialchars($link);


$user = getUser();
if ($user->getSecret() != $secret) {
	redirect("/index.php");
	exit;
}

if(SpamBlocker::check($_GET, 0)) {
	if ($id) {
		$twick = Twick::fetchById($id);
		$twickInfo = TwickInfo::fetchById($id);
		if ($twickInfo->isEditable()) {
			$twick->setAcronym($acronym);
			$twick->setText($text);
			$twick->setLink($link);
			$twick->save();
		}
		
	} else {
		if (trim($title) != "") {
			$topic = array_pop(Topic::fetchByTitle($title));
			if (!$topic) {
				$topic = new Topic();
				$topic->setTitle($title);
				$topic->updateStemming();
				$topic->updateCoreTitle();	
				$topic->setLanguageCode(getLanguage());
				$topic->setCreationDate(getCurrentDate());
				$topic->setUrlId($topic->createUrlId());
				$topic->save();
			}
			
			if (sizeof(Twick::fetchByTextAndTopicId($text, $topic->getId()))) {
				redirect("../topic.php?duplicate=true&search=" . urlencode($title));
			} else {
				$twick = new Twick();
				$twick->setTopicId($topic->getId());
				$twick->setTitle($title);
				$twick->setLanguageCode(getLanguage());
				$twick->setAcronym($acronym);
				$twick->setText($text);
				$twick->setLink($link);
				$twick->setCreationDate(getCurrentDate());
				$twick->setUserId(getUserId());
				$twick->setInputSource("mobile");
				$twick->save();
			}
		}
	}
	
	redirect("../topic.php?search=" . urlencode($title));
} else {
	alert(_loc('confirmTwick.error.spam', NOSPAM_MAIL_RECEIVER));
	redirect("../topic.php?search=" . urlencode($title));
}
	
?>
