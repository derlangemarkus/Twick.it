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
if (!$message || !$message->maySee()) {
    rememberLoginUrl();
    redirect("access_denied.php?id=" . $message->getReceiverId());
}

$message->read();

if($message->getType() == Message::TYPE_WALL && !getArrayElement($_GET, "navi")) {
    $linkId = substringBetween($message->getMessage(), '<a href="' . HTTP_ROOT . '/user/', '">');
    redirect(HTTP_ROOT  . "/user/$linkId");
}

$sender = $message->getSender();
$receiver = $message->getReceiver();

$isReceiver = ($receiver->getId() == $user->getId());
$nextMessageId = $message->findNextMessageId($isReceiver);
$previousMessageId = $message->findPreviousMessageId($isReceiver);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo htmlspecialchars($message->getSubject()) ?> | <?php loc('core.titleClaim') ?></title>
        <meta name="description" content="<?php echo htmlspecialchars($message->getSubject()) ?> | <?php loc('core.titleClaim') ?>" />
        <meta name="keywords" content="<?php loc('core.keywords') ?>" />
        <?php include("inc/inc_global_header.php"); ?>
    </head>

    <body>
        <?php include("inc/inc_header.php"); ?>

        <div id="contentFrame">

            <!-- Ergebnis-Feld -->
            <div class="header-ergebnisfeld" id="header-ergebnisfeld">
                <h1><?php loc('message.headline', array(truncateString($message->getSubject(), 40), htmlspecialchars($sender->getDisplayName()))) ?></h1>
            </div>

            <!-- Content-Bereich | START -->
            <div class="content">
                <!-- Linke Haelfte | START -->
                <div class="inhalte-links">
                    <br />
                    <div class="sprechblase">
                        <div class="sprechblase-main">
                            <div class="sprechblase-links"><i></i>
                                <div class="bilderrahmen"><a href="<?php echo($sender->getUrl()) ?>"><?php echo($sender->getAvatar(64)) ?></a></div>
                                <i><?php echo htmlspecialchars($sender->getDisplayName()) ?></i>
                            </div>
                            <div class="sprechblase-rechts">
                                <div style="height:36px;" id="eingabeblase-head" class="blase-header"></div>
                                <div style="padding-left:20px;width:330px;" class="blase-body">
                                    <h1><?php echo($message->getSubject()) ?></h1>
                                    <p><?php echo nl2br(insertAutoLinks($message->getMessage())) ?></p>
                                </div>
                                <div id="eingabeblase-footer" class="blase-footer"><?php echo convertDate($message->getSendDate(), "d.m.Y, H:i") ?></div>
                            </div>
                            <div class="clearbox">&nbsp;</div>
                        </div>
                    </div>

                    <?php
                    $receiverId = $message->getSenderId();
                    if($receiverId != $user->getId() && ($message->getSenderId() != User::TWICKIT_USER_ID || $message->getType() == Message::TYPE_TWICKIT)) {
                        $subject = _loc("message.write.re") . ": " . $message->getSubject();
                        $text = "";
                        $replyTo = $messageId;
                        include(DOCUMENT_ROOT . "/inc/inc_write_message.php");
                    }
                    ?>
                </div>
                <!-- Linke Haelfte | ENDE -->


                <!-- Rechte Haelfte | START -->
                <div class="inhalte-rechts">

                    <!-- Info | START -->
                    <div class="teaser">
                        <div class="teaser-head"><h2><?php loc('message.marginal.title') ?></h2></div>
                        <div class="teaser-body nopadding">
                            <div>
                                <ul class="message_icons">
                                    <li><a href="show_<?php if($message->getSenderId() == $user->getId()) { ?>sent_<?php } ?>messages.php"><img src="html/img/back.png"/><?php loc('message.marginal.back') ?></a></li>
									<?php if($previousMessageId) { ?>
									<li><a href="/message/<?php echo($previousMessageId) ?>?navi=1"><img src="html/img/prev.png" /><?php loc('message.marginal.previous') ?></a></li>
									<?php } ?>
									<?php if($nextMessageId) { ?>
									<li><a href="/message/<?php echo($nextMessageId) ?>?navi=1"><img src="html/img/next.png" /><?php loc('message.marginal.next') ?></a></li>
									<?php } ?>
                                    <?php if($message->getParentId() || $message->findChild()) { ?>
                                    <li><a href="show_conversation.php?id=<?php echo($messageId) ?>#<?php echo($messageId) ?>"><img src="html/img/comments.png" /><?php loc('message.marginal.view.conversation') ?></a></li>
                                    <?php } ?>
									<li><a href="write_message.php?fwd=<?php echo($messageId) ?>"><img src="html/img/email_go.png"/><?php loc('message.marginal.fwd') ?></a></li>
                                    <li><a href="javascript:;" onclick="confirmPopup('<?php loc('core.areYouSure') ?>', 'action/delete_message.php?id=<?php echo($messageId) ?>&secret=<?php echo($user->getSecret()) ?>');"><img src="html/img/icon_DeleteObject_on.gif" /><?php loc('message.marginal.delete') ?></a></li>
									<?php if($sender->getId() != $user->getId() && $sender->getId() != User::TWICKIT_USER_ID) { ?>
									<li><a href="javascript:;" onclick="confirmPopup('<?php loc('core.areYouSure') ?>', 'action/spam_message.php?id=<?php echo($messageId) ?>&secret=<?php echo($user->getSecret()) ?>');"><img src="html/img/spam.png" /><?php loc('message.marginal.spam') ?></a></li>
									<?php } ?>
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
