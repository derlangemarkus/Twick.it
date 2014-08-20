<?php
class Notificator {

	const NOTIFICATION_WALL_POST = 1;
	const NOTIFICATION_SAME_TOPIC = 2;
	const NOTIFICATION_TWICK_POSITION_CHANGED = 4;
	const NOTIFICATION_RATE_TWICK = 8;
	const NOTIFICATION_USER_RANKING_CHANGED = 16;

    const NOTIFICATION_DEFAULT = 1023;
	

    public static function rateTwick($inTwick, $inTopic, $inOwner, $inRateUser, $inPlusMinus) {
        // Trophäen
        require_once(DOCUMENT_ROOT . "/util/notifications/BadgeNotificator.class.php");
        BadgeNotificator::notify($inOwner, $inRateUser);

        // Erhaltene Bewertung
        if($inOwner->hasAlert(self::NOTIFICATION_RATE_TWICK)) {
            require_once(DOCUMENT_ROOT . "/util/notifications/RateTwickNotificator.class.php");
            RateTwickNotificator::notify($inTwick, $inOwner, $inPlusMinus);
        }

        // Positionsveränderung des Twicks
    }


    public static function deleteTwick($inTwick, $inUser) {
    }


    public static function saveTwick($inTwick, $inTopic, $inAuthor) {
        if($inAuthor) {
			// Gleiches Thema
            foreach($inTopic->findTwicks() as $twick) {
                $user = $twick->findUser();
                if($user->hasAlert(self::NOTIFICATION_SAME_TOPIC) && $user->getId() != $inAuthor->getId()) {
                    require_once(DOCUMENT_ROOT . "/util/notifications/SameTopicNotificator.class.php");
                    SameTopicNotificator::notify($user, $inAuthor, $inTwick);
                }
            }

			// Twicks von einem User
			foreach(UserAlert::fetchByAuthorId($inAuthor->getId()) as $alert) {
				require_once(DOCUMENT_ROOT . "/util/notifications/UserTwickNotificator.class.php");
                UserTwickNotificator::notify($alert->findUser(), $inAuthor, $inTwick);
			}
        }
    }

	
	public static function writeWallPost($inWallOwner, $inAuthor, $inWallPost) {
		require_once(DOCUMENT_ROOT . "/util/notifications/WallPostNotificator.class.php");
		
		if($inAuthor->getId() != $inWallOwner->getId() && $inWallOwner->hasAlert(self::NOTIFICATION_WALL_POST)) {
			WallPostNotificator::notifyOwner($inWallOwner, $inWallPost, $inAuthor);
		}
		
		
		$parentId = $inWallPost->getParentId();
		if($parentId) {
			$alreadyNotified = array($inWallOwner->getId()); // Pinnwand-Besitzer weiß schon Bescheid
			
			$siblings = WallPost::fetchByParentId($parentId);
			$siblings[] = WallPost::fetchById($parentId);
			
			foreach($siblings as $sibling) {
				if(
					$sibling->isDeleted() || 
					$sibling->getAuthorId() == $inAuthor->getId() ||
					in_array($sibling->getAuthorId(), $alreadyNotified) ||
					!$inAuthor->hasAlert(self::NOTIFICATION_WALL_POST)
				) {
					continue;
				}
				WallPostNotificator::notifySibling($sibling->findAuthor(), $inWallPost, $inAuthor, $inWallOwner);
				$alreadyNotified[] = $sibling->getAuthorId();
			}
		}
	}
	

    public static function sendNotification($inUser, $inSubject, $inText, $inMeta="") {
		if($inUser->getDeleted() || $inUser->isAnonymous()) {
			return true;
		}
		$htmlText1 = _loc('email.message.hello', htmlspecialchars($inUser->getLogin())) . "<br /><br />";
        $htmlText1 .= _loc('alerts.message.intro') . "<br /><br />";
        $htmlText1 .= '<table cellspacing="0" cellpadding="0" style="border-collapse:collapse;" width="100%" id="messagedetail">';
        $htmlText1 .= '	<tr>';
        $htmlText1 .= '    <td style="padding:10px;background-color:#DDD;border:1px solid #666666;font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;font-size: 16px">';

        $htmlText2 = '    </td>';
        $htmlText2 .= '  </tr>';
        $htmlText2 .= '</table>';
        $htmlText2 .= '<br />';
		$htmlText2 .= _loc('alerts.message.outro', $inUser->getUrl() . "/alerts");
		
		$text = _loc('email.message.hello', htmlspecialchars($inUser->getLogin())) . "\n\n";
        $text .= _loc('alerts.message.intro') . "\n\n";
        $text .= strip_tags($inText) . "\n\n";
		$text .= strip_tags(_loc('alerts.message.outro')) . " [" . $inUser->getUrl() . "/alerts" . "]";
		
        Message::send(
            Message::TYPE_NOTIFICATION,
            User::TWICKIT_USER_ID,
            $inUser->getId(),
            $inSubject,
            $htmlText1 . $inText . $htmlText2,
            $inMeta
        );
		
		if(!$inUser->getEnableMessages() || $inUser->getThirdpartyId()) {
			return true;
		}

        $htmlText = $htmlText1 . nl2br($inText) . $htmlText2;
        $htmlText = str_replace("<a ", "<a style='color:#638301;' ", $htmlText);
		
        $mailer = new TwickitMailer();
		$mailer->From = "message_" . getLanguage() . "@twick.it";
        $mailer->AddAddress($inUser->getMail());
		$mailer->Subject = $inSubject;
        $mailer->setPlainMessage($text);
		$mailer->setTitle($inSubject);
        $mailer->setHtmlMessage($htmlText);
		return $mailer->Send();
    }
}
?>
