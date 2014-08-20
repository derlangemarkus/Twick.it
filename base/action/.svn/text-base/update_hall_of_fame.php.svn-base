<?php
require_once("../util/inc.php");
require_once("../util/thirdparty/oauth/TwitterOAuth.php"); 

//checkCronjobLogin();
   
$userId = getArrayElement($_POST, "id");
$secret = getArrayElement($_POST, "secret");

$user = User::fetchById($userId);
if($user->getSecret() != $secret) {
	die("Access denied");
}

$count = $user->findNumberOfTwicks(true);
$userName = $user->getLogin();
if ($user->getTwitter()) {
	$userName .= " (@" . $user->getTwitter() . ")";
}

$msg = false;
switch($count) {
	case 10:
		$msg = "Cool! User $userName hat die ersten 10 Erklärungen geschrieben. Weiter so.";
		break;
	case 100:
		$msg = "Wow, schon 100! User $userName hat gerade Erklärungen Nummer 100 geschrieben.";
		break;	
	case 200:
		$msg = "Erklärung #200 von $userName ist da.";
		break;	
	case 300:
		$msg = "300 Erklärungen und kein Stückchen müde. Weiter so, $userName!";
		break;	
	case 400:
		$msg = "$userName haben wir schon 400 Erklärungen zu verdanken!";
		break;	
	case 500:
		$msg = "500 Erklärungen sind geschafft, $userName. Go for 1000!";
		break;
	case 600:
		$msg = "Mit 600 Twicks ernennen wir $userName zum Erklärer erster Kajüte.";
		break;
	case 700:
		$msg = "Twick.it wäre nur halb so schön, ohne die 700 Erklärungen von $userName.";
		break;
	case 800:
		$msg = "Großartig! Gerade ist 800. Erklärung von $userName eingetroffen.";
		break;
	case 900:
		$msg = "$userName, die 1000 Erklärungen sind zum greifen nah. Nur noch 100 Twicks.";
		break;
	case 1000:
		$msg = "Bombastisch! User $userName hat soeben die ersten 1000 Twicks voll gemacht. Gratulation!";
		break;	
}

if ($count > 1000 && !$count%1000) {
	$msg = "$userName ist nicht zu stoppen. Schon $count Erklärungen bei Twick.it.";
}

if ($msg) {
	$msg .= " " . $user->getUrl();
	
	$oauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_TOPIC_FAME_OAUTH, TWITTER_TOPIC_FAME_OAUTH_SECRET);
	$oauth->post('statuses/update', array('status' => $msg));
    echo($msg);
}
?>