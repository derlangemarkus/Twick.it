<form action="confirm.php" method="post" id="your_twick">
	<?php echo(SpamBlocker::printHiddenTags()) ?>
	<input type="hidden" name="title" value="<?php echo(htmlspecialchars($title)) ?>" />
	<label for="accronym"><?php loc('mobile.yourTwick.accronym') ?>:</label>
	<input type="text" name="accronym" value="<?php echo(htmlspecialchars(getArrayElement($_GET, "accronym", ""))) ?>" /><br />
	
	<label for="text" id="explanationLabel"><?php loc('mobile.yourTwick.explanation') ?> *:</label>
	<input id="explanationText" type="text" maxlength="140" name="text" value="<?php echo(htmlspecialchars(getArrayElement($_GET, "text", ""))) ?>"/><br />
	
	<label for="link"><?php loc('mobile.yourTwick.link') ?>:</label>
	<input type="text" name="link" value="<?php echo(htmlspecialchars(getArrayElement($_GET, "link", ""))) ?>"/><br />
	<br />
	<input type="submit" value="<?php loc('mobile.yourTwick.preview') ?>" class="class_button class_longbutton" />
</form>
<?php include("js_booster.php"); ?>
