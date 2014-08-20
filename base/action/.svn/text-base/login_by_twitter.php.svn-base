<?php
require_once("../util/inc.php");
require_once("../util/thirdparty/facebook/src/facebook.php");
 
$oauth = new TwitterOAuth(TWITTER_SSO_CONSUMER_KEY, TWITTER_SSO_CONSUMER_SECRET, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
$token = $oauth->getAccessToken();

// Infos auslesen
$oauth = new TwitterOAuth(TWITTER_SSO_CONSUMER_KEY, TWITTER_SSO_CONSUMER_SECRET, $token['oauth_token'], $token['oauth_token_secret']);
$twitter = $oauth->get('account/verify_credentials');

$login = $twitter->screen_name;

$target = "";
$user = User::fetchByThirdpartyId("Twitter:" . $twitter->id);
if ($user) {
    // Den Twitter-User gibt es schon. Login mit diesem Nutzer.
    $target = login($user, false, true);

    // Wenn der Twitter-Name geändert wurde, dann wird das jetzt nachgezogen.
    if ($user->getTwitter() != $login) {
        $user->setTwitter($login);
        $user->save();
    }
} else {
    $user = User::fetchByLogin($login);
    if ($user) {
        // Es existiert schon ein Twick.it-Nutzer mit diesem Nickname
        die ("Error: Username exists!");
    } else {
        // User existiert noch nicht.
        $user = new User();
        $user->setLogin($login);
        $user->setMail("Twitter:$login");
        $user->setRegisterMail("Twitter:$login");
        $user->setPassword($token['oauth_token_secret']);
        $user->setEnableMessages(true);
        $user->setCreationDate(getCurrentDate());
        $user->setRegisterLanguageCode(getLanguage());
        $user->setNewsletter(false);
        $user->setApproved(true);

        $user->setTwitter($login);
        $user->setBio($twitter->description);
        $user->setLocation($twitter->location);
        $user->setName($twitter->name);
        $user->setLink($twitter->url);
        $user->setThirdpartyId("Twitter:" . $twitter->id);
        $user->save();

        $target = login($user, false, true);
    }
}

redirect($target);
?>