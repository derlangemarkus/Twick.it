<?php 
require_once("inc.php");
$title = _loc("support.title");
$error = getArrayElement($_GET, "error");

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc("support.headline") ?></h1>
<?php if($error) { ?>
<div style="background-color:#F00;color:#FFF;font-weight:bold;padding:10px;"><?php loc($error) ?></div>
<?php } ?>
<form action="action/support.php" method="post" id="loginform" name="support" onsubmit="return checkSupportForm();">
<?php echo(SpamBlocker::printHiddenTags()) ?>
<label for="n"><?php loc('support.name') ?></label>
<input type="text" name="n" value="<?php echo(getArrayElement($_GET, "n")) ?>" /><br />
<label for="m"><?php loc('support.mail') ?></label>
<input type="text" name="m" value="<?php echo(getArrayElement($_GET, "m")) ?>"/><br />
<label for="s"><?php loc('support.subject') ?></label>
<input type="text" name="s" value="<?php echo(getArrayElement($_GET, "s")) ?>"/><br />
<label for="t"><?php loc('support.message') ?></label>
<textarea cols="20" rows="10"  name="t"><?php echo(getArrayElement($_GET, "t")) ?></textarea><br />
<br />
<input type="submit" value="<?php loc("support.button") ?>" class="class_button class_longbutton" />
</form>
<br />
</div> 
<?php include("inc/footer.php"); ?>
<script type="text/javascript">
function checkSupportForm() {
    var error = "";
    if (document.support.n.value.strip() == "") {
        error += "<?php loc('support.error.name') ?>\n\n";
    }
    if (document.support.m.value.strip() == "" || !document.support.mail.value.strip().match(/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i)) {
        error += "<?php loc('support.error.mail') ?>\n\n";
    }
    if (document.support.s.value.strip() == "") {
        error += "<?php loc('support.error.subject') ?>\n\n";
    }
    if (document.support.t.value.strip() == "") {
        error += "<?php loc('support.error.message') ?>\n\n";
    }

    if (error != "") {
        alert(error);
        return false;
    }
}
</script>
</body>
</html>