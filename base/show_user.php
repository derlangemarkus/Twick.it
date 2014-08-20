<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");

$activeTab = "user";
$LIMIT = 5;

$include = getArrayElement($_GET, "inc", "start");
if(!in_array($include, array("start", "twicks", "favorites", "alerts", "wall"))) {
    $include = "start";
}

$login = getArrayElement($_GET, "username");
if (startsWith($login, "Twitter-User-")) {
	$login = "Twitter-User: " . substringAfter($login, "Twitter-User-");
}

if (getArrayElement($_GET, "nomobile")) {
    setMobileCookie(false);
}
redirectMobile("http://m.twick.it/user.php?name=$login");

$me = getUser();
$user = User::fetchByLogin($login, true);

if ($user && !$user->isAnonymous()) {
	$id = $user->getId();
	$displayName = $user->getDisplayName();
    $canonical = $user->getUrl() . "?inc=$include";
} else {
	redirect("../unknown_user.php?name=" . urlencode($login));
}


$headlines = array(
    "start" => _loc('user.title', htmlspecialchars($user->getDisplayName())),
    "twicks" => _loc('user.headline', htmlspecialchars($user->getDisplayName())),
    "favorites" => _loc('favorites.headline', htmlspecialchars($user->getDisplayName())),
    "alerts" => _loc('alerts.title'),
    "wall" => _loc("wall.title", htmlspecialchars($user->getDisplayName())),
);

$numberOfTwicks = $user->findNumberOfTwicks();
$ratingSum = $user->getRatingSumCached();
$numberOfRatings = $user->findNumberOfRatings();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('user.title', $user->getLogin()) ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('user.title', $login) ?>" />
    <meta name="description" content="<?php loc('user.title', $login) ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <link rel="canonical" href="<?php echo($canonical) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.twicksFromUser', $displayName) ?>" href="interfaces/rss/user.php?username=<?php echo($login) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.userTopics', $displayName) ?>" href="interfaces/rss/user_topics.php?username=<?php echo($login) ?>&lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.wall', $displayName) ?>" href="interfaces/rss/wall.php?username=<?php echo($login) ?>&lng=<?php echo(getLanguage()) ?>" />
	<?php if ($user->getLocation()) { ?>
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.usersByLocation', $user->getLocation()) ?>" href="interfaces/rss/location.php?location=<?php echo(urlencode($user->getLocation())) ?>&lng=<?php echo(getLanguage()) ?>" />
	<?php } ?>
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript">
		if(isMobile()) {
			document.location.href="http://m.twick.it/user.php?name=<?php echo($login) ?>&msg=mobile.switchMessage";
		}
	</script>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
    	<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php echo($headlines[$include]) ?></h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php if($user->isTwickit()) { ?>
					<!-- Sprechblase | START -->
					<div class="sprechblase">
						<h2>&nbsp;<span>&nbsp;</span></h2>
						<div class="sprechblase-main">
							<div class="sprechblase-achtung">&nbsp;</div>
							<div class="sprechblase-rechts">
								<div class="blase-header" id="eingabeblase-head">
									<div class="kurzerklaerung"><h1 style="font-size:20px;"><?php loc('user.twickit.title') ?></h1></div>
								</div>
								<div class="blase-body">
									<div class="twick-link">
										<?php loc('user.twickit.text') ?><br />
										<br />
										<a href='write_message.php?receiver=<?php echo($user->getLogin()) ?>'class="teaser-link"><img width="15" height="9" src="html/img/pfeil_weiss.gif"><?php loc('user.twickit.write') ?></a>
									</div>
								</div>
								<div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
							</div>
							<div class="clearbox">&nbsp;</div>
						</div>
					</div>
					<!-- Sprechblase | ENDE -->
				<?php 
				} else { 
					include(DOCUMENT_ROOT . "/inc/user/inc_" . $include . ".php"); 
				}
				?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			    <?php include(DOCUMENT_ROOT . "/inc/inc_user_sidebar.php"); ?>
				<br />
			</div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->	
		
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

	<script type="text/javascript">
	expandPageTitles();
	
	function rateTwickCallback(inTwickId, inRating, inSum, inCount) {
		new Ajax.Request("<?php echo(HTTP_ROOT) ?>/inc/ajax/update_user_stats.php?username=<?php echo($login) ?>", {
			method: 'get',
			onSuccess: function(transport) {
				var response = transport.responseText;
				if (response) {
					var info = response.evalJSON(true);
					$("ratingPosition").update(info.position);
					$("ratingSum").update(info.sum);
					$("ratingCount").update(info.count);
				} 
			}
		});
	
		new Ajax.Request("<?php echo(HTTP_ROOT) ?>/inc/ajax/update_user_badges.php?username=<?php echo($login) ?>", {
			method: 'get',
			onSuccess: function(transport) {
				var response = transport.responseText;
				if (response) {
					$("badgeInfo").update(response);
				} 
			}
		});
	}
	
	<?php if($me && $me->getId() == $user->getId()) { ?>
	function enableUserWall() {
		new Ajax.Request(
			"<?php echo(HTTP_ROOT) ?>/inc/ajax/enable_wall.php", {
				method: 'post',
				parameters: 'enable=' + ($('enableWall').checked ? "1" : "0") + "&secret=<?php echo($me->getSecret()) ?>",
				onSuccess: function() {
					$("enableWall_saved").appear();
					$("enableWall_saved").pulsate({"from":0.9, "pulses":2});
					window.setTimeout('$("enableWall_saved").fade()', 2000);
				}
			}
		);
	}
	<?php } ?>
	</script>
</body>
</html>