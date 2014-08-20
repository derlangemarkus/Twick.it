<?php
require_once("../../util/inc.php");
require_once("../../util/thirdparty/oauth/TwitterOAuth.php");

checkCronjobLogin();

$podcast = Podcast::publish();
$twick = $podcast->getTwick();
$topic = $twick->findTopic();
$user = $twick->findUser();


// Flüsterpost
$subject = "Dein Twick wurde im Podcast gelesen";
$message = "Hallo " . $user->getLogin() . ",<br />\n";
$message .= "Dein Twick zum Thema &quot;" . $twick->getTitle() . "&quot; wurde heute im Twick.it-Podcast von " . $podcast->getSpeaker() . " gelesen.<br />\n<br />\n";
$message .= "Hör doch mal rein: <a style='color:#638301;' href='" . $podcast->getUrl() . "'>" . $podcast->getUrl() . "</a><br />\n<br />\n";
$message .= "Vielen Dank für deine tolle Erklärung.<br />\n";
$message .= "Twick.it - deine Erklärmaschine";
Message::send(
    Message::TYPE_NOTIFICATION,
    User::TWICKIT_USER_ID,
    $user->getId(),
    $subject,
    nl2br(strip_tags($message)),
    $podcast->getId()
);

if($user->getEnableMessages() && !$user->getThirdpartyId()) {
	$mailer = new TwickitMailer();
	$mailer->From = "message_de@twick.it";
	$mailer->AddAddress($user->getMail());
	$mailer->Subject = $subject;
	$mailer->setTitle($inSubject);
	$mailer->setHtmlMessage($message);
	$mailer->Send();
}


// Twitter
$author = $user->getTwitter() ? "@" . $user->getTwitter() : $twick->findUser()->getLogin();
$txt = "♫ Thema: " . $twick->getTitle() . " // Autor: " . $author . " // Gelesen von: " . $podcast->getSpeaker() . " " . HTTP_ROOT . "/p/" . $podcast->getId();

$infos = array('status' => $txt);
if ($topic->hasCoordinates()) {
    $infos["lat"] = $topic->getLatitude();
    $infos["long"] = $topic->getLongitude();
}


$oauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_TOPIC_PODCAST_OAUTH, TWITTER_TOPIC_PODCAST_OAUTH_SECRET);
$oauth->post('statuses/update', $infos);
?>