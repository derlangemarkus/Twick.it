<!-- Daten | START -->
<div class="teaser">
    <div class="teaser-head"><h2><?php loc('user.about.title', $user->getLogin()) ?></h2></div>
    <div class="teaser-body">
        <p>
            <span class="bilderrahmen-gross" style="margin-bottom:0px;"><a href="<?php echo($user->getUrl()) ?>"><?php echo($user->getAvatar(208)); ?></a></span>
            <div id="badgeInfo" style="margin-bottom:8px;text-align:center;">
            <?php
            $badges =
                array(
                    Badge::getBubble($numberOfTwicks),
                    Badge::getStar($ratingSum),
                    Badge::getThumb($numberOfRatings)
                );

            foreach($badges as $badge) {
                ?><a href="badges.php?username=<?php echo($login) ?>#<?php echo($badge["name"]) ?>" onmouseover="$('<?php echo($badge["name"]) ?>').show();" onmouseout="$('<?php echo($badge["name"]) ?>').hide();"><img style="padding:8px;" src="<?php echo(STATIC_ROOT) ?>/html/img/badges/48/<?php echo($badge["img"]) ?>" alt="" width="48" height="48"/></a><?php
            }
            echo("<br style='clear:both;' />");
            foreach($badges as $badge) {
                ?><div id="<?php echo($badge["name"]) ?>" class="badgepopup" style="display:none;"><img src="<?php echo(STATIC_ROOT) ?>/html/img/badges/200/<?php echo($badge["img"]) ?>" alt="" style="width:200px;height:200px"/><br /><?php echo($badge["text"]) ?></div><?php
            }
            ?>
            </div>
            <?php if(!$user->getDeleted()) { ?>
                <?php if ($user->getName()) { ?>
                <label><?php loc('user.about.name') ?>:</label>
                <?php echo($user->getName()) ?><br />
                <?php } ?>
                <?php if ($user->getLink()) { ?>
                <label><?php loc('user.about.url') ?>:</label> <a href="<?php echo($user->getLink()) ?>" target="_blank" title="<?php echo($user->getLink()) ?>"><?php echo(truncateString($user->getLink(), 32, true)) ?></a><br />
                <?php } ?>
                <?php if ($user->getTwitter()) { ?>
                <label><?php loc('user.about.twitter') ?>:</label> <a href="https://twitter.com/<?php echo($user->getTwitter()) ?>" target="_blank">@<?php echo($user->getTwitter()) ?></a><br />
                <?php } ?>
                <?php if ($user->getCountry()) { ?>
                <label><?php loc('user.about.country') ?>:</label> <?php echo($user->getCountry()) ?><br />
                <?php } ?>
                <?php if ($user->getLocation()) { ?>
                <label><?php loc('user.about.location') ?>:</label> <?php echo($user->getLocation()) ?><br />
                <?php } ?>
                <?php if ($user->getBio()) { ?>
                <label><?php loc('user.about.bio') ?>:</label> <?php echo($user->getBio()) ?><br />
                <?php } ?>
                <?php if (isAdmin()) { ?>
                <label style="color:#FF0000">E-Mail:</label><span style="color:#FF0000"><?php echo($user->getMail()) ?></span><br />
                <?php } ?>
                <br />
            <?php } ?>
            <label><?php loc('user.about.numberOfTwicks') ?>:</label> <?php echo($numberOfTwicks) ?><br />
            <label><?php loc('user.about.rank') ?>:</label> <span id='ratingPosition'><?php echo($user->findRatingPosition()) ?></span><br />
            <label><?php loc('user.about.rankingCount') ?>:</label> <span id='ratingCount'><?php echo($user->getRatingCountCached()) ?></span><br />
            <label><?php loc('user.about.rankingSum') ?>:</label> <span id='ratingSum'><?php echo($ratingSum) ?></span><br />
            <?php
            if (getUserId() === $user->getId()) {
                ?><br /><a href="user_data.php" class="teaser-link"><img src="html/img/pfeil_weiss.gif" width="15" height="9" /><?php loc('header.editData') ?></a><br /><?php
            }

            if (isAdmin()) {
                if (BlockedMail::fetchByMail($user->getMail())) {
                ?><br /><a href="action/unblock_mail.php?id=<?php echo($user->getId()) ?>" class="teaser-link-admin"><img src="html/img/pfeil_weiss.gif" width="15" height="9" /><?php loc('user.unblock') ?></a><br /><?php
                } else {
                ?><br /><a href="action/block_mail.php?id=<?php echo($user->getId()) ?>" class="teaser-link-admin"><img src="html/img/pfeil_weiss.gif" width="15" height="9" /><?php loc('user.block') ?></a><br /><?php
                }
                ?><br /><a href="admin/user_ratings.php?login=<?php echo($user->getLogin()) ?>" class="teaser-link-admin"><img src="html/img/pfeil_weiss.gif" width="15" height="9" /><?php loc('user.ratings') ?></a><br /><?php
            }
            ?>
        </p>
    </div>
    <div class="teaser-footer"></div>
</div>
<!-- Daten | ENDE -->

<?php if($me && $me->getId() == $user->getId()) { ?>
<!-- Pinnwand | START -->
<div class="teaser">
	<div class="teaser-head"><h2><?php loc('wall.marginal.enableWall.title') ?></h2></div>
	<div class="teaser-body">
		<div>
			<?php loc('wall.marginal.enableWall.text') ?><br />
			<br />
			<form action="#">
				<table>
					<tr>
						<td valign="top" style="padding-right:8px;"><input type="checkbox" id="enableWall" <?php if($me->getEnableWall()) { ?>checked<?php } ?> onchange="enableUserWall()"/></td>
						<td><label for="enableWall"><?php loc('wall.marginal.enableWall.checkbox') ?></label></td>
					</tr>
				</table>
			</form>
			<div id="enableWall_saved" style='display:none;padding:5px;font-weight:bold;background-color:#6E9018;color:#FFF'><?php loc('userdata.success.saved') ?></div>
		</div>
	</div>
	<div class="teaser-footer"></div>                        
</div>
<!-- Pinnwand | ENDE -->  
<?php } ?>

<?php
if(false) {
if (sizeof($twicks) > 1) {
    $keywords = $user->getTags();
?>
<!-- Tagcloud | START -->
<div class="teaser">
    <div class="teaser-head"><h2><?php loc('core.tagCloud') ?></h2></div>
    <div class="teaser-body">
        <?php include(DOCUMENT_ROOT . "/inc/inc_cloud.php"); ?>
    </div>
    <div class="teaser-footer"></div>
</div>
<!-- Tagcloud | ENDE -->
<?php
}
?>

<?php

$relatedUsers = $user->findRelatedUsersByTags();
if (sizeof($relatedUsers)) {
?>
<!-- Andere User | START -->
<div class="teaser">
    <div class="teaser-head"><h2><?php loc('user.otherUsers.title') ?></h2></div>
    <div class="teaser-body nopadding">
        <ul>
            <?php
            foreach($relatedUsers as $related) {
                ?><li><a href="<?php echo($related->getUrl()) ?>"><img src="<?php echo($related->getAvatarUrl(40)) ?>" class="userfoto" /></a><a href="<?php echo($related->getUrl()) ?>" style="font-weight:bold;color:#638301;font-size:13px;"><?php echo htmlspecialchars($related->getDisplayName()) ?></a><br /><?php echo truncateString($related->getBio()) ?></li><?php
            }
            ?>
        </ul>
        <div class="clearbox"></div>
    </div>
    <div class="teaser-footer"></div>
</div>
<!-- Andere User | ENDE -->
<?php
}
?>

<?php
if ($user->getLocation()) {
    $relatedUsers = $user->findRelatedUsersByLocation();
    if (sizeof($relatedUsers)) {
?>
<!-- Ort | START -->
<div class="teaser">
    <div class="teaser-head"><h2><?php loc('user.location.title', $user->getLocation()) ?></h2></div>
    <div class="teaser-body nopadding">
        <ul>
            <?php
            foreach(array_slice($relatedUsers, 0, 10) as $related) {
                ?><li><img src="<?php echo($related->getAvatarUrl(40)) ?>" class="userfoto" /><a href="<?php echo($related->getUrl()) ?>"><?php echo htmlspecialchars($related->getDisplayName()) ?></a><br /><?php echo($related->getBio()) ?></li><?php
            }
            ?>
        </ul>
        <div class="clearbox"></div>
    </div>
    <div class="teaser-footer"></div>
</div>
<!-- Ort | ENDE -->
<?php
    }
}

} //auskommentiert
?>


<!-- RSS | START -->
<div class="teaser">
    <div class="teaser-head"><h2>RSS</h2></div>
    <div class="teaser-body nopadding">
        <ul>
            <li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/user.php?username=<?php echo($login) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.twicksFromUser', $displayName) ?></a></li>
            <li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/user_topics.php?username=<?php echo($login) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.userTopics', $displayName) ?></a></li>
			<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/wall.php?username=<?php echo($login) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.wall', $displayName) ?></a></li>
            <?php if ($user->getLocation()) { ?>
            <li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/location.php?location=<?php echo(urlencode($user->getLocation())) ?>&lng=<?php echo(getLanguage()) ?>"><?php loc('rss.usersByLocation', $user->getLocation()) ?></a></li>
            <?php } ?>
        </ul>
        <div class="clearbox"></div>
    </div>
    <div class="teaser-footer"></div>
</div>
<!-- RSS | ENDE -->


<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>  