<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");
checkLogin();

$subject = "";
$text = "";
$user = getUser();
$replyTo = getArrayElement($_GET, "reply");
$twickId = getArrayElement($_GET, "twick");
$fwd = getArrayElement($_GET, "fwd");

if($twickId) {
    $twick = Twick::fetchById($twickId);
    $receiver = $twick->findUser();
    $subject = _loc('message.write.twick', $twick->getTitle());
	$text = $twick->getStandaloneUrl();
} else {
    $receiver = User::fetchByLogin(getArrayElement($_GET, "receiver"));
}

$headline = _loc('message.write.title');
if($receiver) {
    $receiverId = $receiver->getId();
    $headline = _loc('message.write.headline', $receiver->getLogin(true));
    if($replyTo) {
        $parent = Message::fetchById($replyTo);
        if(!$parent->maySee()) {
            $parent = false;
        }
        if($parent) {
            $subject = _loc("message.write.re") . ": " . $parent->getSubject();
            $text = "";
        }
    }
} else if($fwd) {
	$fwdMessage = Message::fetchById($fwd);
	if($fwdMessage && $fwdMessage->maySee()) {
		$subject = _loc("message.write.fwd") . ": " . $fwdMessage->getSubject();
        $text = "\n\n----------- " . _loc("message.write.fwd.header") . " -----------\n";
		$text .= _loc('messages.header.subject') . ": " . $fwdMessage->getSubject() . "\n";
		$text .= _loc('messages.header.date') . ": " . convertDate($fwdMessage->getSendDate()) . "\n";
		$text .= _loc('messages.header.sender') . ": " . htmlspecialchars($fwdMessage->getSender()->getDisplayName()) . "\n";
		$text .= _loc('messages.header.receiver') . ": " . htmlspecialchars($fwdMessage->getReceiver()->getDisplayName()) . "\n";
		$text .= "\n";
		$text .= htmlspecialchars_decode($fwdMessage->getMessage());
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('message.write.title') ?> | <?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('message.write.title') ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
            <h1><?php echo($headline) ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
                <?php include(DOCUMENT_ROOT . "/inc/inc_write_message.php"); ?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('message.marginal.title') ?></h2></div>
			        <div class="teaser-body">
			        	<p>
                            <?php if($receiver) { ?>
                                <?php loc('message.write.marginal.text1', "<a href='" . $receiver->getUrl() . "'>" . htmlspecialchars($receiver->getDisplayName()) . "</a>") ?><br />
                                <br />
                                <span class="bilderrahmen-gross"><a href="<?php echo($receiver->getUrl()); ?>"><?php echo($receiver->getAvatar(208)); ?></a></span>
                                <?php loc('message.write.marginal.text2') ?><br />
                                <br />
                            <?php } ?>
			        		<a href="show_messages.php"><img src="html/img/back.png" style="vertical-align:middle;padding-right:3px;"/><?php loc('message.marginal.back') ?></a><br />
			            </p>
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
