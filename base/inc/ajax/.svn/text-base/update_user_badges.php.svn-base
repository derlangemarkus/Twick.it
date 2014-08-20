<?php
require_once("../../util/inc.php");

$login = getArrayElement($_GET, "username");
if (startsWith($login, "Twitter-User-")) {
	$login = "Twitter-User: " . substringAfter($login, "Twitter-User-");
}
$user = User::fetchByLogin($login, true);

if ($user) {
	$badges = 
		array(
			Badge::getBubble($user->findNumberOfTwicks()),
			Badge::getStar($user->getRatingSumCached()),
			Badge::getThumb($user->findNumberOfRatings())
		);

	foreach($badges as $badge) {
		?><a href="badges.php?username=<?php echo($login) ?>#<?php echo($badge["name"]) ?>" onmouseover="$('<?php echo($badge["name"]) ?>').show();" onmouseout="$('<?php echo($badge["name"]) ?>').hide();"><img style="margin:8px;" src="<?php echo(STATIC_ROOT) ?>/html/img/badges/48/<?php echo($badge["img"]) ?>" alt="" width="48" height="48"/></a><?php
	}
	echo("<br style='clear:both;' />");
	foreach($badges as $badge) {
		?><div id="<?php echo($badge["name"]) ?>" class="badgepopup" style="display:none;"><img src="<?php echo(STATIC_ROOT) ?>/html/img/badges/200/<?php echo($badge["img"]) ?>" alt="" style="width:200px;height:200px"/><br /><?php echo($badge["text"]) ?></div><?php
	}
}
?>