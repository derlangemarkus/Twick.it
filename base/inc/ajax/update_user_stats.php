<?php
require_once("../../util/inc.php");

$login = getArrayElement($_GET, "username");
if (startsWith($login, "Twitter-User-")) {
	$login = "Twitter-User: " . substringAfter($login, "Twitter-User-");
}
$user = User::fetchByLogin($login, true);

if ($user) {
	$info = array();
	$info["position"] = $user->findRatingPosition();
	$info["sum"] = $user->getRatingSumCached();
	$info["count"] = $user->getRatingCountCached();
	
	echo(json_encode($info));
}
?>