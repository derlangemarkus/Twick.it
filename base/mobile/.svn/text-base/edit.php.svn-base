<?php 
require_once("inc.php");
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$secret = getArrayElement($_GET, "secret");
$twick = TwickInfo::fetchById($id);
$user = getUser();

// Sicher ist sicher
if($user->getId() != $twick->getUserId() && !isAdmin() || $secret != $user->getSecret()) {
	redirect(HTTP_ROOT . "/index.php");
	exit;
}

$title = _loc('mobile.edit.title');

include("inc/header.php");
?>
<div class="class_content">
<h1><?php loc('mobile.edit.headline', $twick->getTitle()) ?></h1>
<?php if ($twick->isEditable()) { ?>
<form action="confirm.php" method="post" id="your_twick">
	<?php echo(SpamBlocker::printHiddenTags()) ?>
	<input type="hidden" name="id" value="<?php echo($twick->getId()) ?>" />
	<input type="hidden" name="title" value="<?php echo(htmlspecialchars($twick->getTitle())) ?>" />
	<label for="accronym"><?php loc('mobile.yourTwick.accronym') ?>:</label>
	<input type="text" name="accronym" value="<?php echo(htmlspecialchars($twick->getAccronym())) ?>" /><br />
	
	<label for="text" id="explanationLabel"><?php loc('mobile.yourTwick.explanation') ?>:</label>
	<input  id="explanationText" type="text" maxlength="140" name="text" value="<?php echo(htmlspecialchars($twick->getText())) ?>"/><br />
	
	<label for="link"><?php loc('mobile.yourTwick.link') ?>:</label>
	<input type="text" name="link" value="<?php echo(htmlspecialchars($twick->getLink())) ?>"/><br />
	<br />
	<input type="submit" value="<?php loc('mobile.yourTwick.preview') ?>" class="class_button class_longbutton" />
</form> 
<?php include("inc/js_booster.php"); ?>
<?php } else { ?>
<?php loc('mobile.edit.notEditable') ?><br />
<br />
<a href="topic.php?search=<?php echo(urlencode($twick->getTitle())) ?>" style="padding:35px 0px 35px 0px;width:100%;display:block;border-top:1px solid #ccc">&nbsp;&nbsp;<?php loc('mobile.core.back') ?></a>
<?php }  ?>
<br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>