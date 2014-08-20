<?php
require_once("../../util/inc.php");

$user = getUser();
if ($user) {
	$unread = sizeof(Message::fetchReceived($user->getId(), array(), true));
	if($unread == 0) {
		loc('header.message.none');
	} else if($unread == 1) {
		loc('header.message.one', "<b id='unread'>$unread</b>");
	} else {
		loc('header.message.more', "<b id='unread'>$unread</b>");
	}
}
?>