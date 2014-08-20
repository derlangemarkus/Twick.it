<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 

$secret = getArrayElement($_GET, "secret");
$language = getLanguage();

$user = getUser();
if ($user && $user->getSecret() == $secret) {
	session_start();
	
	$targetUrl = $_SESSION["login.targetPage"];
	
	$_SESSION["userId"] = "";
	unset($_SESSION["userId"]);
	session_destroy();
	
	setcookie("twickit_token", "", time(), "/");
	unset($_COOKIE["twickit_token"]);


	if($targetUrl) {
		session_start();
		// Das ist die einige Session-Info, die wir weiterhin benoetigen!
		$_SESSION["login.targetPage"] = $targetUrl;
	}
	
	$url = HTTP_ROOT . str_replace(CONTEXT_PATH, "", getArrayElement($_GET, "url"));
	if (contains($url, "?")) {
		$url .= "&";
	} else {
		$url .= "?";
	}

	redirect($url . "msg=login.logout&lng=" . $language);
} else {
	redirect(HTTP_ROOT . "/index.php?lng=" . $language);
}
?>