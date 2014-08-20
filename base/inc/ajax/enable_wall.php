<?php
require_once("../../util/inc.php");

$enable = getArrayElement($_POST, "enable");
$secret = getArrayElement($_POST, "secret");
$user = getUser();

if ($user && $user->getSecret() == $secret) {
	$user->setEnableWall($enable);
	$user->save();
}
?>