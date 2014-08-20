<?php 
require_once("inc.php");
$title = _loc("mobile.register.title");
$error = getArrayElement($_GET, "error");

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc("mobile.register.title") ?></h1>
<?php if($error) { ?>
<div style="background-color:#F00;color:#FFF;font-weight:bold;padding:10px;"><?php loc($error) ?></div>
<?php } ?>
<form action="action/register.php" method="post" id="loginform">
<?php echo(SpamBlocker::printHiddenTags()) ?>
<input type="hidden" name="r" value="<?php echo(getArrayElement($_GET, "r")) ?>" />
<label for="u"><?php loc("mobile.register.username") ?></label>
<input type="text" name="u" value="<?php echo(getArrayElement($_GET, "u")) ?>" /><br />
<label for="m"><?php loc("mobile.register.mail") ?></label>
<input type="text" name="m" value="<?php echo(getArrayElement($_GET, "m")) ?>"/><br />
<label for="p"><?php loc("mobile.register.password") ?></label>
<input type="password" name="p" value="<?php echo(getArrayElement($_GET, "p")) ?>"/><br />
<label for="p2"><?php loc("mobile.register.password2") ?></label>
<input type="password" name="p2" value="<?php echo(getArrayElement($_GET, "p2")) ?>"/><br /><br />
<input type="checkbox" name="n" style="width:auto;float:left;" <?php if(getArrayElement($_GET, "n")) { ?>checked="checked"<? } ?>/><label for="n" style="width:auto;float:left;padding-top:0px;">&nbsp;<?php loc("mobile.register.newsletter") ?></label><br /><br />
<input type="checkbox" name="t" style="width:auto;float:left;" <?php if(getArrayElement($_GET, "t")) { ?>checked="checked"<? } ?>/><label for="t" style="width:auto;float:left;padding-top:0px;">&nbsp;<?php loc("mobile.register.terms", "terms.php") ?></label><br /><br />
<input type="submit" value="<?php loc("mobile.register.button") ?>" class="class_button class_longbutton" />
</form>
<br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>