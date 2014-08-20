<?php 
require_once("inc.php");
checkLogin();

// Parameter auslesen
$id = getArrayElement($_GET, "id");
$message = Message::fetchById($id);
$user = getUser();

if(!$user || !$message || !$message->maySee()) {
	redirect("index.php");
	exit;
}

$title = _loc('message.marginal.delete');

include("inc/header.php");
?>
<div class="class_content">
<h1><?php loc('message.marginal.delete') ?></h1>
<?php loc('mobile.message.delete.confirm', "&quot;<i>" . $message->getSubject() . "</i>&quot;") ?><br />
<br />
<a href="message.php?id=<?php echo($id) ?>" style="background-color:#3F3;color:#000;padding:35px 0px 35px 0px;width:100%;display:block;border-top:1px solid #ccc">&nbsp;&nbsp;<?php loc('mobile.delete.no') ?></a>
<br />
<a href="action/delete_message.php?id=<?php echo($id) ?>&secret=<?php echo($user->getSecret()) ?>" style="background-color:#F33;color:#000;padding:20px 0px 20px 00px;width:100%;display:block;border-top:1px solid #ccc">&nbsp;&nbsp;<?php loc('mobile.delete.yes') ?></a>
<br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>