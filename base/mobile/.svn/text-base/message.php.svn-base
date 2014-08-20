<?php 
require_once("inc.php");
$title = _loc('mobile.home.title');
$canonical = "http://twick.it";

include("inc/header.php"); 
$user = getUser();
$message = Message::fetchById(getArrayElement($_GET, "id"));

if(!$user || !$message || !$message->maySee()) {
	redirect("index.php");
	exit;
}

$message->read();
$sender = $message->getSender();
$receiver = $message->getReceiver();
?>
<div class="class_content">
<h1><?php loc('message.headline', array(truncateString($message->getSubject(), 40), htmlspecialchars($sender->getDisplayName()))) ?></h1>
<?php echo nl2br(insertAutoLinks($message->getMessage())) ?>
<br /><br />
<i><?php echo convertDate($message->getSendDate(), "d.m.Y, H:i") ?></i><br />
<br /><br />
<?php if($receiver->getId() == $user->getId()) { ?>
	<?php if(!$sender->isTwickit()) { ?>
	<a href="write_message.php?reply=<?php echo($message->getId()) ?>">&lt;&lt; <?php loc('message.write.marginal.text1', htmlspecialchars($sender->getDisplayName())) ?></a><br /><br />
	<?php } ?>
<a href="messages.php">&lt;&lt; <?php loc('message.marginal.back') ?></a>
<?php } else { ?>
<a href="sent_messages.php">&lt;&lt; <?php loc('message.marginal.back') ?></a>
<?php } ?>
<br style="clear:both;" />
<br />
<br />
<a href="delete_message.php?id=<?php echo($message->getId()) ?>"><?php loc('message.marginal.delete') ?> &gt;&gt;</a>
<br />
<br />

</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>