<?php
require '../src/facebook.php';


$facebook = new Facebook(array(
  'appId'  => '130627500322456',
  'secret' => '9d7be2f88e71e954976ce5df5489293b',
  'cookie' => true,
));


$me = null;
if ($facebook->getSession()) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

?>
<!doctype html>
<html>
  <head>
    <title>php-sdk</title>
  </head>
  <body>
    <?php if ($me) { ?>
    <a href="<?php echo $facebook->getLogoutUrl(); ?>">
      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
    </a>
    <?php } else { ?>
    <div>
      <a href="javascript:;" onclick="window.open('<?php echo $facebook->getLoginUrl(array("display"=>"popup")); ?>', 'facebook')">
        <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
      </a>
    </div>
    <?php } ?>

    <h3>Session</h3>
    <?php if ($me) { ?>
     <h3>You</h3>
    <img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
    <?php echo $me['name']; ?>

    <h3>Your User Object</h3>
    <pre><?php print_r($me); ?></pre>
    <?php } else { ?>
    <strong><em>You are not Connected.</em></strong>
    <?php } ?>

  </body>
</html>
