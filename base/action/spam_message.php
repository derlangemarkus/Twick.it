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

if ($user && message && $user->getSecret() == $secret && $user->getId() == $message->getReceiverId()) {
    $message->setSpam(true);
    $message->setDeletedReceiver(true);
    $message->save();
    redirect(HTTP_ROOT . "/show_messages.php?msg=message.drilldown.spam");
}
redirect(HTTP_ROOT . "/show_messages.php");
?>