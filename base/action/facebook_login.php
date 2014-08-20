<?php
require_once("../util/inc.php");
require_once("../util/thirdparty/facebook/src/facebook.php");

$facebook = new Facebook(array(
  'appId'  => FACEBOOK_APP_ID,
  'secret' => FACEBOOK_APP_SECRET,
  'cookie' => true,
));

$url = getArrayElement($_GET, "url");

redirect($facebook->getLoginUrl(array("next"=>HTTP_ROOT . "/login_by_facebook.php?url=" . urlencode($url))));
?>