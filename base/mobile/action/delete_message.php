<?php 
require_once("../../util/inc.php");
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$secret = getArrayElement($_GET, "secret");
$message = Message::fetchById($id);
$user = getUser();

// Sicher ist sicher
if(
	!isAdmin() && (!$message->maySee() || $secret != $user->getSecret()) ||
	!$message
) {
	redirect(HTTP_ROOT . "/index.php");
	exit;
}

$message->delete();

$url = "messages.php";
if($user->getId() == $message->getSenderId()) {
    $url = "sent_messages.php";
}

redirect("../" . $url . "?msg=message.drilldown.deleted");
?>