<?php
require_once("../../util/inc.php");

$notify = getArrayElement($_POST, "notify");
$secret = getArrayElement($_POST, "secret");
$user = getUser();

if ($user && $user->getSecret() == $secret) {
	$user->setEnableMessages($notify);
	$user->save();
}
?>