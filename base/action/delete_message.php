<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$secret = getArrayElement($_GET, "secret");
$user = getUser();

$message = Message::fetchById($id);

if ($user && message && $user->getSecret() == $secret) {
    if($user->getId() == $message->getReceiverId()) {
        $message->setDeletedReceiver(true);
        $message->save();
        redirect(HTTP_ROOT . "/show_messages.php?msg=message.drilldown.deleted");
    } else if($user->getId() == $message->getSenderId()) {
        $message->setDeletedSender(true);
        $message->save();
        redirect(HTTP_ROOT . "/show_sent_messages.php?msg=message.drilldown.deleted");
    }
}
?>