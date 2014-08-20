<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
checkLogin();

$secret = getArrayElement($_GET, "secret");
$user = getUser();

if($user->getSecret() == $secret) {
	foreach(Message::fetchReceived($user->getId(), array(), true) as $message) {
		$message->read();
	}
}
redirect(HTTP_ROOT . "/messages");
?>