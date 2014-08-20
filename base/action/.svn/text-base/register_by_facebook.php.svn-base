<?php
require_once("../util/inc.php");
require_once("../util/thirdparty/facebook/src/facebook.php");

$facebook = $_SESSION["facebook"];

$login = getArrayElement($_POST, "login");
$mail = "Facebook:$login";

if (startsWith($login, "-") || !preg_match('/^[a-zA-Z_\d]+$/', $login)) {
	redirect("../login_by_facebook.php?error=userdata.error.login.invalidChars");
}
if (!getArrayElement($_POST, "agb")) {
	redirect("../login_by_facebook.php?error=userdata.error.terms.accept");
}
if(User::fetchByLogin($login)) {
	redirect("../login_by_facebook.php?error=userdata.error.login.taken");
}

if (BlockedMail::isBlocked($mail)) {
	redirect("login_by_facebook.php?error=userdata.error.login.blocked");
}

if (SpamBlocker::check($_POST)) {
    $user = new User();
    $user->setLogin($login);
    $user->setMail($mail);
    $user->setRegisterMail($mail);
    $user->setPassword(md5(time()));
    $user->setEnableMessages(false);
    $user->setCreationDate(getCurrentDate());
    $user->setRegisterLanguageCode(getLanguage());
    $user->setNewsletter(false);
    $user->setApproved(true);

    $user->setBio(getArrayElement($facebook, "about"));
    $user->setLocation(getArrayElement(getArrayElement($facebook, "location", array()), "name"));
    $user->setName(getArrayElement($facebook, "name"));
    $user->setLink(getArrayElement($facebook, "link"));
    $user->setThirdpartyId("Facebook:" . getArrayElement($facebook, "id"));
    $user->save();

    unset($_SESSION["facebook"]);

    redirect(login($user, false, true));
} else {
	redirect("spam.php");
}
?>