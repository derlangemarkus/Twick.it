<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

// Parameter auslesen
$refferer = getArrayElement($_POST, "r");
$login = getArrayElement($_POST, "u");
$mail = getArrayElement($_POST, "m");
$password = getArrayElement($_POST, "p");
$password2 = getArrayElement($_POST, "p2");
$newsletter = getArrayElement($_POST, "n");
$terms = getArrayElement($_POST, "t");

$queryString = "";
foreach($_POST as $key=>$value) {
	if (in_array($key, array("r", "u", "m", "p", "p2", "n", "t"))) {
		$queryString .= "&$key=$value";
	}
}


if (startsWith($login, "-") || !preg_match('/^[a-zA-Z_\d]+$/', $login)) {
	redirect("../register.php?error=userdata.error.login.invalidChars$queryString");
}
if (!$terms) {
	redirect("../register.php?error=userdata.error.terms.accept$queryString");
}
if (trim($password) == "") {
	redirect("../register.php?error=userdata.error.email.invalidOrEmpty$queryString");
}
if(User::fetchByMail($mail)) {
	redirect("../register.php?error=userdata.error.login.duplicateMail$queryString");
}
if(User::fetchByLogin($login)) {
	redirect("../register.php?error=userdata.error.login.taken$queryString");
}
if($password != $password2) {
	redirect("../register.php?error=userdata.error.password.repeat$queryString");
}

if (BlockedMail::isBlocked($mail)) {
	redirect("../register.php?error=userdata.error.login.blocked$queryString");
}

if (SpamBlocker::check($_POST)) {
	$user = new User();
	$user->setLogin($login);
	$user->setMail($mail);
	$user->setRegisterMail($mail);
	$user->setPassword(md5($password));
	$user->setEnableMessages(true);
	$user->setCreationDate(getCurrentDate());
	$user->setRegisterLanguageCode(getLanguage());
	$user->setNewsletter($newsletter);
	$user->save();
	
	if (!$user->sendRegistrationMail()) {
		redirect("../register.php?msg=userdata.error.couldNotSend$queryString");
	}
} else {
	alert(_loc('confirmTwick.error.spam', NOSPAM_MAIL_RECEIVER));
	redirect("../register.php?error=" . urlencode(_loc('confirmTwick.error.spam', NOSPAM_MAIL_RECEIVER)) . $queryString);
}
redirect("../register_ok.php?login=$login");	
?>
