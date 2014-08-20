<?php
class UserTwickNotificator {

    public static function notify($inUser, $inAuthor, $inTwick) {
		$text = _loc('alerts.message.user', "<a href='" . $inAuthor->getUrl() . "'>" . $inAuthor->getLogin() . "</a>") . "\n\n";
		$text .= "<i><b>" . $inTwick->getTitle() . "</b>\n";
		if($inTwick->getAcronym()) {
			$text .= _loc('twick.accronym') . $inTwick->getAcronym() . "\n";
		}
		$text .= $inTwick->getText() . "\n\n";
		$text .= "</i>";
        $text .= "<a href='" . $inTwick->getFixUrl() . "'>" . _loc('alerts.message.user.text', $inAuthor->getLogin()) . "</a>";

        Notificator::sendNotification(
            $inUser,
            _loc('alerts.message.user.title', $inAuthor->getDisplayName()),
            $text,
            $inTwick->getId()
        );
    }
}

?>
