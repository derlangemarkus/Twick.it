<?php 
require_once("inc.php");
$title = _loc("mobile.register.title");

$id = getArrayElement($_GET, "id");
$secret = substr(getArrayElement($_GET, "secret"), 1);

$success = false;
$user = User::fetchById($id);
if ($user) {
	if ($user->getSecretSecret() === $secret) {
		$success = true;
		$user->setApproved(1);
		$user->save();
		
		$_SESSION["userId"] = $user->getId();
	}
}

include("inc/header.php"); 
?>
<div class="class_content">
<h1><?php loc('registrationApproved.success.subline') ?></h1>
<br />
<?php loc('registrationApproved.success.text') ?><br />
<br />
<a href="<?php if($_SESSION["startpage"]) { echo($_SESSION["startpage"]); } else { ?>index.php<?php } ?>"><?php loc('registrationApproved.success.gotoHomepage') ?></a><br /><br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>