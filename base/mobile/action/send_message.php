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

$receiverId = getArrayElement($_POST, "receiver");
$subject = getArrayElement($_POST, "subject");
$message = getArrayElement($_POST, "message");
$parentId = getArrayElement($_POST, "parent_id", null);

$receiver = User::fetchById($receiverId);
if ($receiver) {
	$receiver->sendUserMessageMail(getUser(), $subject, $message, $parentId);
	redirect("../sent_messages.php?msg=message.drilldown.sent");
} else {
	die("Error");
	//TODO
}
?>