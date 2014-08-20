<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkAdmin();

$subject = getArrayElement($_POST, "subject");
$text = getArrayElement($_POST, "message");
$mode = getArrayElement($_POST, "mode", "all");
$sender = User::fetchById(User::TWICKIT_USER_ID);

if(trim($text) != "") {
    switch($mode) {
        case "newsletter":
            $receivers = User::fetch(array("newsletter"=>1, "approved"=>1));
            break;
			
		case "no_newsletter":
            $receivers = User::fetch(array("newsletter"=>0, "approved"=>1));
            break;

        default:
            $receivers = User::fetch(array("approved"=>1));
    }

	$first = true;
	foreach($receivers as $receiver) {
		if ($receiver && !$receiver->getDeleted()) {
			$message = Message::send(
				Message::TYPE_TWICKIT,
				$sender->getId(),
				$receiver->getId(), 
				$subject, 
				$text
			);

			if(!$first) {
				$message->setDeletedSender(true);
				$message->save();
			}
			$first = false;
			
			if(!$receiver->getEnableMessages()) {
				continue;
			}
			
		
			
			$replyUrl = HTTP_ROOT . "/show_message.php?id=" . $message->getId();
		
			$separator = str_repeat("-", 70);
			$mailText = _loc('email.message.hello', $receiver->getLogin()) . "\n\n";
			$mailText .= _loc('email.message.text', $sender->getDisplayName()) . "\n\n\n$separator\n\n";
			$mailText .= strip_tags($subject) . "\n\n";
			$mailText .= strip_tags($text) . "\n\n";
			$mailText .= _loc('email.message.showMessage', $replyUrl);
			$mailText .= "\n\n";
			$mailText .= _loc('email.message.userPage', array($sender->getDisplayName(), $sender->getUrl()));
			$mailText .= "\n\n$separator\n\n\n";
			$mailText .= _loc('email.message.bye') ."\n";


			$htmlText = '
				<img src="' . $sender->getAvatarUrl(32) . '" style="float:right;border:1px solid #638301" alt=""/>
				' . _loc('email.message.hello', $receiver->getLogin()) . '<br />
				' . _loc('email.message.text', $sender->getDisplayName()) . '<br />
				<br />
				<table cellspacing="0" cellpadding="0" style="border-collapse:collapse;" width="100%">
					<tr>
						<td style="padding:10px;background-color:#DDD;border:1px solid #666666;font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;font-size: 16px">
							' . (subject ? '<b>' . htmlspecialchars($subject). '</b><br />' : '') .'
							' . nl2br(htmlspecialchars($text)) . '
						</td>
					</tr>
				</table>
				<br />
				' . _loc('email.message.showMessage', "<a href='$replyUrl' style='color:#638301;'>$replyUrl</a>") . '<br />
				' . _loc('email.message.userPage', array($sender->getDisplayName(), "<a href='" . $sender->getUrl() . "' style='color:#638301;'>" . $sender->getUrl() . "</a>")) . '
				<br />
				<br />
				' . _loc('email.message.bye');

			$mailer = new TwickitMailer();
			$mailer->AddAddress($receiver->getMail());
			$mailer->Subject = _loc('email.message.subject', $sender->getDisplayName());
			$mailer->setPlainMessage($mailText);
			$mailer->setTitle(_loc('email.message.subject', $sender->getDisplayName()));
			$mailer->setHtmlMessage($htmlText);
			$mailer->Send();
		}
	}
	
	redirect(HTTP_ROOT . "/show_sent_messages.php?msg=message.drilldown.sent");
} else {
	die("Error");
	//TODO
}
?>