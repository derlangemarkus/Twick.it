<?php 
require_once("inc.php");
$title = _loc("mobile.login.title");

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc("mobile.login.title") ?></h1>
<form action="action/login.php" method="post" id="loginform">
<input type="hidden" name="r" value="<?php echo(getArrayElement($_GET, "r")) ?>" />
<label for="l"><?php loc("mobile.login.user") ?></label>
<input type="text" name="l" /><br />
<label for="p"><?php loc("mobile.login.password") ?></label>
<input type="password" name="p" /><br /><br />
<input type="submit" value="<?php loc("mobile.login.button") ?>" class="class_button class_longbutton" />
</form>
<br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>