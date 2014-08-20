<?php
class SameTopicNotificator {

    public static function notify($inUser, $inAuthor, $inTwick) {
        $text = _loc('alerts.message.sameTopic', array("<a href='" . $inAuthor->getUrl() . "'>" . $inAuthor->getLogin() . "</a>", "<a href='" . $inTwick->getUrl() . "'>" . $inTwick->getTitle() . "</a>")) . "\n\n";
        $text .= "<i>";
		if($inTwick->getAcronym()) {
			$text .= _loc('twick.accronym') . ": " . $inTwick->getAcronym() . "\n";
		}
		$text .= $inTwick->getText() . "\n\n";
		$text .= "</i>";
        $text .= _loc('alerts.message.sameTopic.text', $inTwick->getFixUrl());

        Notificator::sendNotification(
            $inUser,
            _loc('alerts.message.sameTopic.title', $inTwick->getTitle()),
            $text,
            $inTwick->getId()
        );
    }
}

?>
