<?php
require_once("../util/inc.php");
require_once("../util/thirdparty/oauth/TwitterOAuth.php");

$oauth = new TwitterOAuth(TWITTER_SSO_CONSUMER_KEY, TWITTER_SSO_CONSUMER_SECRET);
$requestToken = $oauth->getRequestToken();

/* Save tokens for later */
$_SESSION['oauth_request_token'] = $requestToken['oauth_token'];
$_SESSION['oauth_request_token_secret'] = $requestToken['oauth_token_secret'];
$_SESSION['oauth_state'] = "start";

redirect($oauth->getAuthorizeURL($requestToken) . "&url=" . urlencode(getArrayElement($_GET, "url")));
?>