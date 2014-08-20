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

$title = _loc('mobile.delete.title');

include("inc/header.php");
?>
<div class="class_content">
<h1><?php loc('mobile.delete.headline', $twick->getTitle()) ?></h1>
<?php loc('mobile.delete.text') ?><br />
<br />
<a href="topic.php?search=<?php echo(urlencode($twick->getTitle())) ?>" style="background-color:#3F3;color:#000;padding:35px 0px 35px 0px;width:100%;display:block;border-top:1px solid #ccc">&nbsp;&nbsp;<?php loc('mobile.delete.no') ?></a>
<br />
<a href="action/delete.php?id=<?php echo($id) ?>&secret=<?php echo($secret) ?>" style="background-color:#F33;color:#000;padding:20px 0px 20px 00px;width:100%;display:block;border-top:1px solid #ccc">&nbsp;&nbsp;<?php loc('mobile.delete.yes') ?></a> 
<br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>