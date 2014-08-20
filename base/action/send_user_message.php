<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

$receiverId = getArrayElement($_POST, "receiver");
$subject = getArrayElement($_POST, "subject");
$message = getArrayElement($_POST, "message");
$parentId = getArrayElement($_POST, "parent_id");

$receiver = User::fetchById($receiverId);
if ($receiver && trim($message) != "") {
	$receiver->sendUserMessageMail(getUser(), $subject, $message, $parentId);
	redirect(HTTP_ROOT . "/show_sent_messages.php?msg=message.drilldown.sent");
} else {
	die("Error");
	//TODO
}
?>