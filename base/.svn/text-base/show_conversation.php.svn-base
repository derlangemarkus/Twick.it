<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");
checkLogin();

$user = getUser();
$messageId = getArrayElement($_GET, "id");
$message = Message::fetchById($messageId);
if(!$message || $message->getReceiverId() != $user->getId() && $message->getSenderId() != $user->getId()) {
	rememberLoginUrl();
    redirect("access_denied.php?id=" . $message->getReceiverId());
}
$message->read();


// Erst mal im Strang ganz nach unten gehen
while($child = $message->findChild()) {
    $message = $child;
}


// Nachrichtenstrang von unten nach oben durchgehen
$messages = array();
array_unshift($messages, $message);
addParentMessage($message);

function addParentMessage($inMessage) {
    global $messages;
    $parent = $inMessage->findParent();
    if($parent) {
        array_unshift($messages, $parent);
        addParentMessage($parent);
    }
}

$sender = $message->getSender();
$receiver = $message->getReceiver();

$title = _loc('message.conversation.title', array($sender->getLogin(), $receiver->getLogin()));
$title2 = _loc('message.conversation.title', array($sender->getAvatar(20) . "&nbsp;" . $sender->getLogin(), $receiver->getAvatar(20) . "&nbsp;" . $receiver->getLogin()));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo($title) ?> | <?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php echo($title) ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
            <h1><?php echo($title2) ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
                <br />
                <?php 
                foreach($messages as $message) {
                    $sender = $message->getSender();
                ?>
                <a name="<?php echo($message->getId()) ?>"></a>
                <div class="sprechblase">
                    <div class="sprechblase-main">
                        <div class="sprechblase-links"><i></i>
                            <div class="bilderrahmen"><?php echo($sender->getAvatar(64)) ?></div>
                            <i><a class="url" href="<?php echo($sender->getUrl()) ?>" target="_blank"><?php echo htmlspecialchars($sender->getDisplayName()) ?></a></i>
                        </div>
                        <div class="sprechblase-rechts">
                            <div style="height:36px;" id="eingabeblase-head" class="blase-header"></div>
                            <div style="padding-left:20px;width:330px;" class="blase-body">
                                <h1><?php echo($message->getSubject()) ?></h1>
                                <p><?php echo(insertAutoLinks($message->getMessage())) ?></p>
                            </div>
                            <div id="eingabeblase-footer" class="blase-footer"><?php echo convertDate($message->getSendDate(), "d.m.Y, H:i") ?></div>
                        </div>
                        <div class="clearbox">&nbsp;</div>
                    </div>
                </div>
				
				<?php
                }
				$receiverId = $message->getSenderId(); 
				$subject = _loc("message.write.re") . ": " . $message->getSubject();
				$text = "";
				$replyTo = $message->getId();
				include(DOCUMENT_ROOT . "/inc/inc_write_message.php"); 
				?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('message.marginal.title') ?></h2></div>
			        <div class="teaser-body">
                        <div>
                            <?php loc('message.marginal.conversation.info', array("<a href='" . $sender->getUrl() . "'>" . $sender->getLogin() . "</a>", "<a href='" . $receiver->getUrl() . "'>" .$receiver->getLogin() . "</a>")) ?><br />
                            <br />
                            <ul class="bullets">
                                <li><a href="show_messages.php"><?php loc('message.marginal.back') ?></a></li>
                                <li><a href="show_message.php?id=<?php echo($messageId) ?>#<?php echo($messageId) ?>"><?php loc('message.marginal.view.single') ?></a></li>
                            </ul>
                        </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
		
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>