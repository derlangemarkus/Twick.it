<?php 
require_once("inc.php");

$LIMIT = 10;

$offset = getArrayElement($_GET, "offset", 0);
$login = getArrayElement($_GET, "name");
$aUser = User::fetchByLogin($login);
 
if (!$aUser) {
	redirect("index.php");
}

$twicks = $aUser->findTwicks(false, array("LIMIT"=>$LIMIT+1, "OFFSET"=>$offset));
$title = htmlspecialchars($aUser->getDisplayName());
$canonical = $aUser->getUrl("http://twick.it");



$numberOfTwicks = $aUser->findNumberOfTwicks();
$ratingSum = $aUser->getRatingSumCached();
$numberOfRatings = $aUser->findNumberOfRatings();

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc('mobile.user.headline', htmlspecialchars($aUser->getDisplayName())) ?></h1>
<?php 
if($offset == 0) {
?>
<table>
	<?php if(!$aUser->getDeleted()) { ?>
	<tr>
		<td class="class_userinfo" colspan="2">
			<?php if ($aUser->getLink()) { ?>
			<label><?php loc('user.about.url') ?>:</label><a href="<?php echo($aUser->getLink()) ?>" target="_blank" title="<?php echo($aUser->getLink()) ?>"><?php echo(truncateString($aUser->getLink(), 32, true)) ?></a><br />
			<?php } ?>
			<?php if ($aUser->getTwitter()) { ?>
			<label><?php loc('user.about.twitter') ?>:</label><a href="https://twitter.com/<?php echo($aUser->getTwitter()) ?>" target="_blank">@<?php echo($aUser->getTwitter()) ?></a><br />
			<?php } ?>
			<?php if ($aUser->getCountry()) { ?>
			<label><?php loc('user.about.country') ?>:</label><?php echo($aUser->getCountry()) ?><br />
			<?php } ?>
			<?php if ($aUser->getLocation()) { ?>
			<label><?php loc('user.about.location') ?>:</label><?php echo($aUser->getLocation()) ?><br />
			<?php } ?>
			<?php if ($aUser->getBio()) { ?>
			<label><?php loc('user.about.bio') ?>:</label><?php echo($aUser->getBio()) ?><br />
			<?php } ?>
			<?php if (isAdmin()) { ?>
			<label style="color:#FF0000">E-Mail:</label><span style="color:#FF0000"><?php echo($aUser->getMail()) ?></span><br />
			<?php } ?>
			<br />
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td class="class_userinfo">
			<label><?php loc('user.about.numberOfTwicks') ?>:</label><?php echo($numberOfTwicks) ?><br />
			<label><?php loc('user.about.rank') ?>:</label><?php echo($aUser->findRatingPosition()) ?><br />
			<label><?php loc('user.about.rankingCount') ?>:</label><?php echo($aUser->getRatingCountCached()) ?><br />
			<label><?php loc('user.about.rankingSum') ?>:</label><?php echo($ratingSum) ?><br />
		</td>
		<td width="75"><a href="<?php echo($aUser->getAvatarUrl(350)) ?>"><?php echo($aUser->getAvatar(70)) ?></a></td>
	</tr>
	<tr>
		<td class="class_userinfo">
			<label><?php loc('user.badges.title') ?>:</label>
		</td>
		<td><?php
$badges =
	array(
		Badge::getBubble($numberOfTwicks),
		Badge::getStar($ratingSum),
		Badge::getThumb($numberOfRatings)
	);

foreach($badges as $badge) {
	?><img style="padding:1px;" src="<?php echo(STATIC_ROOT) ?>/html/img/badges/48/<?php echo($badge["img"]) ?>" alt="" width="22" height="22"/><?php
}
?></td>
	</tr>
</table>

<br />
<?php
}
?>
<table style="width:96%" cellpadding="0" cellspacing="0">
<?php 
$counter = 1;
foreach($twicks as $twick) {
	if ($counter <= $LIMIT) {
		showTwick($twick, 2, $login, true);
	}
	$counter++;
}
?>
</table>
</div> 
<?php if ($offset > 0 || sizeof($twicks) > $LIMIT) {?>
<br />
<div class="class_divider"></div>
<div class="class_content">
<?php loc('mobile.user.more') ?><br /><br />

<?php if ($offset > 0) { ?>
<a href="user.php?offset=<?php echo($offset-$LIMIT) ?>&name=<?php echo($login) ?>" class="class_rate" style="text-align:left;">&lt;&lt; <?php loc('mobile.core.prev') ?></a>
<?php } else { ?>
<div style="width:50%;display:block;float:left;">&nbsp;</div>
<?php } ?>
<?php if (sizeof($twicks) > $LIMIT) { ?>
<a href="user.php?offset=<?php echo($offset+$LIMIT) ?>&name=<?php echo($login) ?>" class="class_rate" style="text-align:right;"><?php loc('mobile.core.next') ?> &gt;&gt;&nbsp;&nbsp;&nbsp;</a>
<?php } ?>
</div>
<br />
<?php } ?>
<?php include("inc/footer.php"); ?>
</body>
</html>