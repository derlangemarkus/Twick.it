<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

// Parameter auslesen
$secret = getArrayElement($_POST, "secret");
$action = getArrayElement($_POST, "bulkaction");
$sent = getArrayElement($_POST, "sent");
$user = getUser();

if($user->getSecret() == $secret) {
	foreach($_POST as $key=>$value) {
		if(startsWith($key, "mark_"))  {
			$messageId = substringAfter($key, "mark_");
			if(is_numeric($messageId)) {
				$message = Message::fetchById($messageId);
				if($message->maySee()) {
					if($action == "delete") {
						if($message->getReceiverId() == $user->getId()) {
							$message->setDeletedReceiver(true);
							$message->save();
						} else if($message->getSenderId() == $user->getId()) {
							$message->setDeletedSender(true);
							$message->save();
						}
					} else {
						if($message->getReceiverId() == $user->getId()) {
							$message->read();
						}
					}
				}
			}
		}
	}
}

if($sent) {
	redirect(HTTP_ROOT . "/show_sent_messages.php");
} else {
	redirect(HTTP_ROOT . "/messages");
}
?>
