<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

$login = getArrayElement($_POST, "l");
$password = getArrayElement($_POST, "p");
$refferer = getArrayElement($_POST, "r", "../index.php");
$msg = "";

$user = User::fetchByMail($login);
if (!$user) {
	$user = User::fetchByLogin($login);
}

if ($user) {
	$msg = _loc('login.success', $user->getLogin());
}

if ($user && !$user->getDeleted() && md5($password) === $user->getPassword() && !contains($login, ":")) {
	if ($user->getApproved()) {
		if ($user->isBlocked()) {
			$msg = 'login.blocked';
		} else {
			$_SESSION["userId"] = $user->getId();
			setcookie("twickit_token", $user->getId() . "@" . md5($user->getSecret()), time()+60*60*24*600, "/");
			if ($user->getReminder()==2) {
				$user->setReminder(0);
				$user->save();
			}
		}
	} else {
		$msg = 'login.notApproved';
	}
}  else {
	$msg = 'login.accessDenied';
}

$url = $refferer;
if (contains($url, "?")) {
	$url .= "&";
} else {
	$url .= "?";
}
redirect($url . "msg=$msg");
?>
