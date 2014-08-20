<?php 
require_once("inc.php");
$title = _loc('mobile.home.title');
$canonical = "http://twick.it";

include("inc/header.php"); 
$user = getUser();

if(!$user) {
	redirect("index.php");
	exit;
}
$messages = Message::fetchSent($user->getId(), array("ORDER BY"=>"send_date DESC"));
?>
<style type="text/css">
#messagetable th, #messagetable td{border-bottom:1px solid #333;padding:5px 6px 15px 6px;color:#00000;}
#messagetable td a{color:#000000;}
#messagetable tr.c0{background-color:#EEE}
</style>
<table width="100%" style="padding-top:10px;">
<tr>
	<td width="50%" align="center" style="padding:5px;border:1px solid #333;"><a href="messages.php"><?php loc("mobile.mesages.received") ?></a></td>
	<td width="50%" align="center" style="padding:5px;border:1px solid #333;background-color:#638301;color:#FFF;font-weight:bold;"><?php loc("mobile.mesages.sent") ?></td>
</tr>
</table>	

<div class="class_content">
<h1><?php loc('messages.sent.headline', $user->getLogin()) ?></h1>
<table cellspacing="0" cellpadding="0" id="messagetable">
	<tr>
		<th><?php loc("messages.header.date") ?></th>
		<th><?php loc("messages.header.subject") ?></th>
		<th><?php loc("messages.header.receiver") ?></th>
	</tr>
<?php 
foreach($messages as $i=>$message) { 
	$receiver = $message->getReceiver();
	if (!$receiver) {
		continue;
	}
	$href="message.php?id=" . $message->getId();
?>
	<tr class="c<?php echo($i%2) ?>">
		<td><a href="<?php echo($href) ?>"><?php echo convertDate($message->getSendDate()) ?></a></td>
		<td><a href="<?php echo($href) ?>"><?php echo truncateString($message->getSubject(), 60) ?></a></td>
		<td><a href="<?php echo($href) ?>"><?php echo htmlspecialchars($receiver->getLogin()) ?></a></td>
	</tr>
<?php } ?>
</table>
<br style="clear:both;" />
<br />
<a href="write_message.php"><?php loc('messages.marginal.write') ?></a><br />
<br />

</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>