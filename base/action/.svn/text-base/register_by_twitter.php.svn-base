<?php
require_once("../util/inc.php");

$twitter = $_SESSION["twitter"];

$login = getArrayElement($_POST, "login");
$mail = "Twitter:$login";

if (startsWith($login, "-") || !preg_match('/^[a-zA-Z_\d]+$/', $login)) {
	redirect("../login_by_twitter.php?error=userdata.error.login.invalidChars");
}
if (!getArrayElement($_POST, "agb")) {
	redirect("../login_by_twitter.php?error=userdata.error.terms.accept");
}
if(User::fetchByLogin($login)) {
	redirect("../login_by_twitter.php?error=userdata.error.login.taken");
}

if (BlockedMail::isBlocked($mail)) {
	redirect("../login_by_twitter.php?error=userdata.error.login.blocked");
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

    $user->setTwitter($twitter->screen_name);
    $user->setBio($twitter->description);
    $user->setLocation($twitter->location);
    $user->setName($twitter->name);
    $user->setLink($twitter->url);
    $user->setThirdpartyId("Twitter:" . $twitter->id);
    $user->save();

    unset($_SESSION["twitter"]);

    redirect(login($user, false, true));
} else {
	redirect("spam.php");
}
?>