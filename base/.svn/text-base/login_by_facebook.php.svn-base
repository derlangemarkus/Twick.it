<?php
require_once("util/inc.php");
require_once("util/thirdparty/facebook/src/facebook.php");

$facebook = new Facebook(array(
  'appId'  => FACEBOOK_APP_ID,
  'secret' => FACEBOOK_APP_SECRET,
  'cookie' => true,
));


$me = null;
if ($facebook->getSession()) {
    $me = $facebook->api('/me');
}

if ($me) {
	$_SESSION["facebook"] = $me;
} else {
	redirect("fail.php");
}

$login = str_replace(" ", "", toCamelWord(mapUnicodeToAscii($me["name"])));

$user = User::fetchByThirdpartyId("Facebook:" . $me["id"]);
if ($me["id"] && $user) {
    // Den Facebook-User gibt es schon. Login mit diesem Nutzer.
    redirect(login($user, false, true));

} else {
    $user = User::fetchByLogin($login);
    if ($user) {
		$counter = 2;
		while (User::fetchByLogin($login . $counter)) {
			$counter++;
		}
		$userName = $login . $counter;

    } else {
        $userName = $login;
    }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('oauth.facebook.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('oauth.facebook.title') ?>" />
    <meta name="description" content="<?php loc('oauth.facebook.title') ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
    <script type="text/javascript" src="html/js/twickit/twickit_userdata_js.php"></script>
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
			<h1><?php loc('oauth.facebook.headline') ?></h1>
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
				            <div class="bilderrahmen"><img src="https://graph.facebook.com/<?php echo $me["id"] ?>/picture?type=large" alt="" /></div>
                            <i><?php echo($me["name"]) ?></i>
				      	</div>
				        <div class="sprechblase-rechts">
				        	<div class="blase-header" id="eingabeblase-head">
				            	<div class="kurzerklaerung" style="width:320px;margin-bottom:10px;">
                                     <span><?php loc('oauth.facebook.text', $me["name"])?><br />
                                     </span>
                                </div>
				            </div>
				            <div class="blase-body">
                                <form class="eingabeblase" id="twickit-blase" action="action/register_by_facebook.php?url=<?php echo(urlencode(getArrayElement($_GET, "url")))?>" method="post" name="userForm" style="width:320px;margin-top:0px;">
                                    <?php echo(SpamBlocker::printHiddenTags()) ?>
                                    <noscript>
                                        <span style="color:#F00;font-size:14px;"><?php loc('userdata.register.noJS') ?></span>
                                    </noscript>
                                    <label for="login"><?php loc('userdata.username') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
                                    <input name="login" type="text" value="<?php echo($userName) ?>" onkeyup="checkLogin()" autocomplete="off"/>
                                    <div id="checkLogin"></div><br />

                                    <input type="checkbox" name="agb" class="checkbox" onclick="checkAgb()"/> <?php loc('userdata.terms', HTTP_ROOT . '/blog/agb/') ?>
                                    <div id="checkAgb"></div><br />
                                    <a href="javascript:;" onclick="doPopup('<?php loc('userdata.error') ?>')" id="createLink" class="disabled"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('oauth.facebook.login') ?></a><br style="clear:both;"/>
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
			    	<div class="teaser-head"><h2><?php loc('oauth.facebook.marginal.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('oauth.facebook.marginal.text') ?><br />
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