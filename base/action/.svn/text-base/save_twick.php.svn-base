<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
#checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$title = trim(getArrayElement($_GET, "title"));
$acronym = trim(getArrayElement($_GET, "acronym"));
$text = trim(getArrayElement($_GET, "text"));
$link = trim(getArrayElement($_GET, "link"));
$secret = getArrayElement($_GET, "secret");

if(mb_strlen($text, "utf8") > 140) {
	die ("An error accoured. Please contact help@twick.it");
}

if (strtolower($title) == strtolower($acronym)) {
	$acronym = "";
}

$user = getUser(true);
if ($user->getSecret() != $secret) {
	redirect(HTTP_ROOT . "/index.php");
	exit;
}

if(SpamBlocker::check($_GET, 2)) {
	if ($id) {
		$twick = Twick::fetchById($id);
		if ($twick->isEditable()) {
			$twick->setTitle($title);
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
				redirect($topic->getUrl() . "?duplicate=true");
			} else {
				$twick = new Twick();
				$twick->setTopicId($topic->getId());
				$twick->setTitle($title);
				$twick->setLanguageCode(getLanguage());
				$twick->setAcronym($acronym);
				$twick->setText($text);
				$twick->setLink($link);
				$twick->setCreationDate(getCurrentDate());
				$twick->setUserId($user->getId());
				$twick->setInputSource("web");
				if ($user->getReminder()==2) {
					$user->setReminder(0);
					$user->save();
				}
				$twick->save();
			}
		}
	}
	
	redirect($twick->getUrl(true));
} else {
	alert(_loc('confirmTwick.error.spam', NOSPAM_MAIL_RECEIVER));
	redirect("../show_topic.php?title=$title");
}
	
?>
