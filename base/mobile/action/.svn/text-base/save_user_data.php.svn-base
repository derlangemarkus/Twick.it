<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php");
ini_set("display_errors", 1);
checkLogin();

// Parameter auslesen
$user = getUser();
$login = getArrayElement($_POST, "login");
$mail = strtolower(trim(getArrayElement($_POST, "mail")));
$password = getArrayElement($_POST, "password");
$password2 = getArrayElement($_POST, "password2");

if ($login != $user->getLogin()) {
	if (startsWith($login, "-") || !preg_match('/^[a-zA-Z_\d]+$/', $login)) {
		redirect("../user_data.php?error=userdata.error.login.invalidChars");
	}
}

$existUser = User::fetchByMail($mail);
if($mail != $user->getMail() && $existUser && $existUser->getId() != $user->getId()) {
	redirect("../user_data.php?error=userdata.error.email.taken"); 
}
if($login != $user->getLogin() && $existUser = User::fetchByLogin($mail)) {
	redirect("../user_data.php?error=userdata.error.login.taken");
}
if($password != $password2) {
	redirect("../user_data.php?error=userdata.error.password.repeat");
}

if (BlockedMail::isBlocked($mail)) {
	redirect("../user_data.php?error=userdata.error.login.blocked");
}

$oldPassword = $user->getPassword();
$user->setNewsletter(false);
$user->setEnableMessages(false);
copyArrayInClassWithSpecialChars($user, $_POST);
$user->setPassword($password != "" ? md5($password) : $oldPassword);
$user->save();

redirect("../user_data.php?msg=userdata.success.saved");
?>