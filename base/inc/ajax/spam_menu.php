<?php 
require_once("../../util/inc.php");

$id = getArrayElement($_GET, "id");
$r = getArrayElement($_GET, "r");
$secret = getArrayElement($_GET, "secret");
?>
<form id="missbrauch<?php echo($id) ?>" name="missbrauch<?php echo($id) ?>" action="action/spam_twick.php?r=<?php echo($r) ?>&id=<?php echo($id) ?>&secret=<?php echo($secret) ?>" method="POST">
	<table>
		<tr><td valign="top"><input name="type" type="radio" value="1" /></td><td valign="top"><label><?php loc('twick.bullshit.illegal') ?></label></td></tr>
		<tr><td valign="top"><input name="type" type="radio" value="2" /></td><td valign="top"><label><?php loc('twick.bullshit.wrongPerson') ?></label></td></tr>
		<tr><td valign="top"><input name="type" type="radio" value="4" /></td><td valign="top"><label><?php loc('twick.bullshit.porn') ?></label></td></tr>
		<tr><td valign="top"><input name="type" type="radio" value="8" /></td><td valign="top"><label><?php loc('twick.bullshit.defamation') ?></label></td></tr>
		<tr><td valign="top"><input name="type" type="radio" value="16" /></td><td valign="top"><label><?php loc('twick.bullshit.wrongTopic') ?></label></td></tr>
		<tr><td valign="top"><input name="type" type="radio" value="32" /></td><td valign="top"><label><?php loc('twick.bullshit.wrongInfo') ?></label></td></tr>
		<tr><td valign="top"><input name="type" type="radio" value="64" /></td><td valign="top"><label><?php loc('twick.bullshit.spam') ?></label></td></tr>
		<tr><td valign="top"><input name="type" type="radio" value="1024" /></td><td valign="top"><label><?php loc('twick.bullshit.misc') ?></label></td></tr>
	</table>
	
	<?php if (isLoggedIn()) { ?>
	<a href="javascript:;" onclick="if(validateSpamForm(<?php echo($id) ?>)) { $('missbrauch<?php echo($id) ?>').submit(); } else {doPopup('<?php loc('twick.bullshit.noReason') ?>');}" class="teaser-link" ><?php loc('twick.bullshit.button') ?></a>
	<?php } else { ?>
	<a href="javascript:;" onclick="doPopup('<?php loc('twick.bullshit.button.notLoggedIn') ?>');" class="teaser-link" ><?php loc('twick.bullshit.button') ?></a>
	<?php } ?>
	<div class="clearbox"></div>
</form>
