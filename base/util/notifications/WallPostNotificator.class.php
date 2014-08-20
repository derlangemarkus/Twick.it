<?php
class WallPostNotificator {

	public static function notifyOwner($inUser, $inWallPost, $inAuthor) {
		$subject = _loc('wall.message.subject', $inAuthor->getLogin());

		$htmlText1 = _loc('email.message.hello', htmlspecialchars($inUser->getLogin())) . "<br /><br />";
		$htmlText1 .= _loc('wall.message.intro') . "<br /><br />";
		$htmlText1 .= '<table cellspacing="0" cellpadding="0" style="border-collapse:collapse;" width="100%" id="messagedetail">';
		$htmlText1 .= '	<tr>';
		$htmlText1 .= '    <td style="padding:10px;background-color:#DDD;border:1px solid #666666;font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;font-size: 16px">';

		$htmlText2 = '    </td>';
		$htmlText2 .= '  </tr>';
		$htmlText2 .= '</table>';
		$htmlText2 .= '<br />';
		$htmlText2 .= _loc('wall.message.outro', $inWallPost->getUrl());
		
		$text = _loc('email.message.hello', htmlspecialchars($inUser->getLogin())) . "\n\n";
		$text .= _loc('wall.message.intro') . "\n\n";
		$text .= strip_tags($inWallPost->getMessage()) . "\n\n";
		$text .= strip_tags(_loc('wall.message.outro')) . " [" . $inWallPost->getUrl() . "]";
		
		Message::send(
			Message::TYPE_WALL,
			User::TWICKIT_USER_ID,
			$inUser->getId(),
			$subject,
			$htmlText1 . htmlspecialchars($inWallPost->getMessage()) . $htmlText2,
			$inAuthor->getId()
		);

		$htmlText = $htmlText1 . nl2br(htmlspecialchars($inWallPost->getMessage())) . $htmlText2;
		$htmlText = str_replace("<a ", "<a style='color:#638301;'", $htmlText);
		
		$mailer = new TwickitMailer();
		$mailer->From = "message_" . getLanguage() . "@twick.it";
		$mailer->AddAddress($inUser->getMail());
		$mailer->Subject = $subject;
		$mailer->setPlainMessage($text);
		$mailer->setTitle($subject);
		$mailer->setHtmlMessage($htmlText);
		return $mailer->Send();
	}


	public static function notifySibling($inUser, $inWallPost, $inAuthor, $inWallOwner) {
		$subject = _loc('wall.message.sibling.subject', array($inAuthor->getLogin(), $inWallOwner->getLogin()));

		$htmlText1 = _loc('email.message.hello', htmlspecialchars($inUser->getLogin())) . "<br /><br />";
		$htmlText1 .= _loc('wall.message.sibling.intro', $inWallOwner->getLogin()) . "<br /><br />";
		$htmlText1 .= '<table cellspacing="0" cellpadding="0" style="border-collapse:collapse;" width="100%" id="messagedetail">';
		$htmlText1 .= '	<tr>';
		$htmlText1 .= '    <td style="padding:10px;background-color:#DDD;border:1px solid #666666;font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;font-size: 16px">';

		$htmlText2 = '    </td>';
		$htmlText2 .= '  </tr>';
		$htmlText2 .= '</table>';
		$htmlText2 .= '<br />';
		$htmlText2 .= _loc('wall.message.sibling.outro', $inWallPost->getUrl());
		
		$text = _loc('email.message.hello', htmlspecialchars($inUser->getLogin())) . "\n\n";
		$text .= _loc('wall.message.sibling.intro', $inWallOwner->getLogin()) . "\n\n";
		$text .= strip_tags($inWallPost->getMessage()) . "\n\n";
		$text .= strip_tags(_loc('wall.message.sibling.outro')) . " [" . $inWallPost->getUrl() . "]";
		
		Message::send(
			Message::TYPE_WALL,
			User::TWICKIT_USER_ID,
			$inUser->getId(),
			$subject,
			$htmlText1 . htmlspecialchars($inWallPost->getMessage()) . $htmlText2,
			$inAuthor->getId()
		);

		$htmlText = $htmlText1 . nl2br(htmlspecialchars($inWallPost->getMessage())) . $htmlText2;
		$htmlText = str_replace("<a ", "<a style='color:#638301;'", $htmlText);
		
		$mailer = new TwickitMailer();
		$mailer->From = "message_" . getLanguage() . "@twick.it";
		$mailer->AddAddress($inUser->getMail());
		$mailer->Subject = $subject;
		$mailer->setPlainMessage($text);
		$mailer->setTitle($subject);
		$mailer->setHtmlMessage($htmlText);
		return $mailer->Send();
	}
}
?>
