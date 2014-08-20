<?php 
require_once("inc.php");
if (!isLoggedIn()) {
	redirect("index.php");
}
$title = getArrayElement($_POST, "title");
$id = getArrayElement($_POST, "id", "");
$acronym = getArrayElement($_POST, "accronym");
$text = getArrayElement($_POST, "text");
$link = getArrayElement($_POST, "link");
$user = getUser();

$enableTwick = true; 
if (!SpamBlocker::check($_POST, 2)) { 
	$error = _loc('confirmTwick.error.spam', NOSPAM_MAIL_RECEIVER);
	$enableTwick = false;
} else if(mb_strlen($text, "utf8") > 140) { 
	$error = _loc('confirmTwick.error.140', mb_strlen($text, "utf8")-140);
	$enableTwick = false;
} else if(containsBlacklistWords($text)) { 
	$error = _loc('confirmTwick.error.blacklist');
	$enableTwick = false;
} else if(mb_strlen($text, "utf8") < 1) {
	$error = _loc('confirmTwick.error.noText');
	$enableTwick = false;
} else if(!$id && $topic && $topic->findNumberOfTwicksForUserInTheLastHours(getUserId()) >= 2) {
	$error = _loc('confirmTwick.error.limit');
	$enableTwick = false;
} 

include("inc/header.php"); 

?>
<div class="class_content">
<?php if ($enableTwick) { ?>
<h1><?php loc('mobile.confirm.headline') ?></h1>
<form action="action/save.php" method="get">
	<?php echo(SpamBlocker::printHiddenTags()) ?>
	<input type="hidden" name="secret" value="<?php echo($user->getSecret()) ?>" />
	<input type="hidden" name="id" value="<?php echo($id) ?>" />
	<input type="hidden" name="title" value="<?php echo(htmlspecialchars($title)) ?>" />
	<label for="acronym"><?php loc('mobile.yourTwick.accronym') ?>:</label>
	<input type="hidden" name="acronym" value="<?php echo(htmlspecialchars($acronym)) ?>"/><br />
	<?php echo($acronym ? $acronym : "<i>" . _loc('mobile.yourTwick.noAccronym', $title) . "</i>") ?>
	
	<label for="text"><?php loc('mobile.yourTwick.explanation') ?>:</label>
	<input type="hidden" name="text" value="<?php echo(htmlspecialchars($text)) ?>"/><br />
	<?php echo($text) ?>
	
	<label for="link"><?php loc('mobile.yourTwick.link') ?>:</label>
	<input type="hidden" name="link" value="<?php echo(htmlspecialchars($link)) ?>"/><br />
	<?php echo($link ? $link : "<i>" . _loc('mobile.yourTwick.noLink') . "</i>") ?>
	
	<br /><br />
	
	<input type="submit" value="<?php loc('mobile.confirm.submit') ?>" class="class_button class_longbutton" />
</form>
<?php } else { ?>
<h1><?php loc('mobile.confirm.error') ?></h1>
<span style="color:#F00;font-weight:bold;"><?php echo($error) ?></span>
<form action="confirm.php" method="post" id="your_twick">
	<?php echo(SpamBlocker::printHiddenTags()) ?>
	<input type="hidden" name="title" value="<?php echo(htmlspecialchars($title)) ?>" />
	<label for="accronym"><?php loc('mobile.yourTwick.accronym') ?>:</label>
	<input type="text" name="accronym" value="<?php echo(htmlspecialchars($acronym)) ?>"/><br />
	
	<label id="explanationLabel" for="text"><?php loc('mobile.yourTwick.explanation') ?> *:</label>
	<input id="explanationText" type="text" maxlength="140" name="text" value="<?php echo(htmlspecialchars($text)) ?>"/><br />
	
	<label for="link"><?php loc('mobile.yourTwick.link') ?>:</label>
	<input type="text" name="link" value="<?php echo(htmlspecialchars($link)) ?>"/><br />
	
	<br /><br />
	
	<input type="submit" value="<?php loc('mobile.yourTwick.preview') ?>" class="class_button class_longbutton" />
</form>
<?php include("inc/js_booster.php"); ?>
<?php } ?>
<br />
<a href="topic.php?search=<?php echo(urlencode($title)) ?>&accronym=<?php echo(urlencode($acronym)) ?>&text=<?php echo(urlencode($text)) ?>&link=<?php echo(urlencode($link)) ?>"><?php loc('mobile.confirm.back') ?></a>
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>