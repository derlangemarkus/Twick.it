<?php
require_once("util/inc.php");
require_once("util/thirdparty/oauth/TwitterOAuth.php");

$twitter = $_SESSION["twitter"];
if (true || !$twitter || !$twitter->screen_name) {
    $oauth = new TwitterOAuth(TWITTER_SSO_CONSUMER_KEY, TWITTER_SSO_CONSUMER_SECRET, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
    $token = $oauth->getAccessToken();

    // Infos auslesen
    $oauth = new TwitterOAuth(TWITTER_SSO_CONSUMER_KEY, TWITTER_SSO_CONSUMER_SECRET, $token['oauth_token'], $token['oauth_token_secret']);
    $twitter = $oauth->get('account/verify_credentials');

    $_SESSION["twitter"] = $twitter;
}

$login = $twitter->screen_name;

$user = User::fetchByThirdpartyId("Twitter:" . $twitter->id);
if ($twitter->id && $user) {
    // Wenn der Twitter-Name geändert wurde, dann wird das jetzt nachgezogen.
    if ($user->getTwitter() != $login) {
        $user->setTwitter($login);
        $user->save();
    }

    // Den Twitter-User gibt es schon. Login mit diesem Nutzer.
    redirect(login($user, false, true));

} else {
    $user = User::fetchByLogin($login);
    if ($user) {
        $exists = true;

        $name = str_replace(" ", "", toCamelWord(mapUnicodeToAscii($twitter->name)));
        if ($name == "") {
            $counter = 2;
            while (User::fetchByLogin($login . $counter)) {
                $counter++;
            }
            $userName = $login . $counter;
        } else {
            if (User::fetchByLogin($name)) {
                $counter = 2;
                while (User::fetchByLogin($name . $counter)) {
                    $counter++;
                }
                $userName = $name . $counter;
            } else {
                $userName = $name;
            }
        }
    } else {
        $exists = false;
        $userName = $login;
    }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('oauth.twitter.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('oauth.twitter.title') ?>" />
    <meta name="description" content="<?php loc('oauth.twitter.title') ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <script type="text/javascript" src="html/js/twickit/twickit_userdata_js.php"></script>
	<?php include("inc/inc_global_header.php"); ?>
    <script type="text/javascript">
		var userDataValidationPassword = true;
		var userDataValidationPassword2 = true;
		var userDataValidationMail = true;
		skipPasswordTest = true;
	</script>
</head>

<body onload="checkLogin();">
	<?php include("inc/inc_header.php"); ?>

    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('oauth.twitter.headline') ?></h1>
		</div>

		<!-- Content-Bereich | START -->
		<div class="content">

			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<!-- Sprechblase | START -->
				<div class="sprechblase">
					<h2>&nbsp;<span>&nbsp;</span></h2>
					<div class="sprechblase-main">
						<div class="sprechblase-links"><i>&nbsp;</i>
				            <div class="bilderrahmen"><img src="<?php echo(TwitterReader::getTwitterAvatarUrlImage($twitter->profile_image_url, 64)) ?>" alt="" /></div>
				      	</div>
				        <div class="sprechblase-rechts">
				        	<div class="blase-header" id="eingabeblase-head">
				            	<div class="kurzerklaerung" style="width:320px;margin-bottom:10px;">
                                     <span><?php loc('oauth.twitter.text', $twitter->screen_name)?><br />
                                     <?php
                                    if($exists) {
                                        loc('oauth.twitter.exists', $twitter->screen_name);
                                    } else {
                                        loc('oauth.twitter.new', $twitter->screen_name);
                                    }
                                ?></span>
                                </div>
				            </div>
				            <div class="blase-body">
                                <form class="eingabeblase" id="twickit-blase" action="action/register_by_twitter.php?url=<?php echo(urlencode(getArrayElement($_GET, "url")))?>" method="post" name="userForm" style="width:320px;margin-top:0px;">
                                    <?php echo(SpamBlocker::printHiddenTags()) ?>
                                    <noscript>
                                        <span style="color:#F00;font-size:14px;"><?php loc('userdata.register.noJS') ?></span>
                                    </noscript>
                                    <label for="login"><?php loc('userdata.username') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
                                    <input name="login" type="text" value="<?php echo($userName) ?>" onkeyup="checkLogin()" autocomplete="off"/>
                                    <div id="checkLogin"></div><br />

                                    <input type="checkbox" name="agb" class="checkbox" onclick="checkAgb()"/> <?php loc('userdata.terms', HTTP_ROOT . '/blog/agb/') ?>
                                    <div id="checkAgb"></div><br />
                                    <a href="javascript:;" onclick="doPopup('<?php loc('userdata.error') ?>')" id="createLink" class="disabled"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('oauth.twitter.login') ?></a><br style="clear:both;"/>
                                    <br />
                                    <?php loc('userdata.changeText') ?>
                                </form>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Sprechblase | ENDE -->
			</div>
			<!-- Linke Haelfte | ENDE -->

			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('oauth.twitter.marginal.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('oauth.twitter.marginal.text') ?><br />
			            </div>
			        </div>
			        <div class="teaser-footer"></div>
			    </div>
			    <!-- Info | ENDE -->

				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>

			<br /></div>
			<!-- Rechte Haelfte | ENDE -->

			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->

	</div>
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>
</body>
</html>