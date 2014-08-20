<?php
require_once("../../util/inc.php"); 

$secret = getArrayElement($_GET, "secret");

$user = getUser();
if ($user && $user->getSecret() == $secret) {
	setcookie("twickit_token", "", 0, "/");
	unset($_COOKIE["twickit_token"]);

	$_SESSION["userId"] = "";
	unset($_SESSION["userId"]);
}


$refferer = getArrayElement($_GET, "r", "../index.php");
$url = $refferer;
if (contains($url, "?")) {
	$url .= "&";
} else {
	$url .= "?";
}
redirect($url . "msg=" . urlencode(_loc("login.logout")));
?>