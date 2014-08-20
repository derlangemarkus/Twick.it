<?php
require_once("../../util/inc.php");
checkLogin();

// Parameter auslesen
$id = getArrayElement($_POST, "id");
$secret = getArrayElement($_POST, "secret");
$user = getUser();

$message = Message::fetchById($id);

if ($user && message && $user->getSecret() == $secret) {
    if($user->getId() == $message->getReceiverId()) {
        $message->setDeletedReceiver(true);
        $message->save();
    } else if($user->getId() == $message->getSenderId()) {
        $message->setDeletedSender(true);
        $message->save();
    }
}
?>