<?php
class BadgeNotificator {

    public static function notify($inAuthor, $inRatingUser) {
        $badge = Badge::reachedLevel(Badge::THUMB, $inRatingUser->findNumberOfRatings());
        if($badge) {
            $twitter = "https://twitter.com?status=" . _loc('badges.popup.thumb.share') . " " . $inRatingUser->getUrl();
            $facebook = "http://www.facebook.com/share.php?u=" . $inRatingUser->getUrl();

            if($badge == Badge::BRONZE) {
                $text = _loc("badges.popup.thumb.text.bronze", Badge::$levels[Badge::THUMB][Badge::BRONZE]) . "\n" . _loc("badges.popup.thumb.text2", array($twitter, $facebook));
                $meta = "thumb_bronze";
            } else if($badge == Badge::SILVER) {
                $text = _loc("badges.popup.thumb.text.silver", Badge::$levels[Badge::THUMB][Badge::SILVER]) . "\n" . _loc("badges.popup.thumb.text2", array($twitter, $facebook));
                $meta = "thumb_silver";
            } else if($badge == Badge::GOLD) {
                $text = _loc("badges.popup.thumb.text.gold", Badge::$levels[Badge::THUMB][Badge::GOLD]) . "\n" . _loc("badges.popup.thumb.text2", array($twitter, $facebook));
                $meta = "thumb_gold";
            } else if($badge == Badge::DIAMOND) {
                $text = _loc("badges.popup.thumb.text.diamond", Badge::$levels[Badge::THUMB][Badge::DIAMOND]) . "\n" . _loc("badges.popup.thumb.text2", array($twitter, $facebook));
                $meta = "thumb_diamond";
            }

            $message = Message::send(
                Message::TYPE_BADGE,
                User::TWICKIT_USER_ID,
                $inRatingUser->getId(),
                _loc("badges.popup.thumb.title"),
                $text,
                $meta
            );
			$message->mail();
        }

        $writerBadge = Badge::reachedLevel(Badge::STAR, $inAuthor->getRatingSumCached());
        if($writerBadge) {
            $twitter = "https://twitter.com?status=" . _loc('badges.mail.star.share') . " " . $inAuthor->getUrl();
            $facebook = "http://www.facebook.com/share.php?u=" . $inAuthor->getUrl();

            if($writerBadge == Badge::BRONZE) {
                $text = _loc("badges.mail.star.text.bronze", Badge::$levels[Badge::STAR][Badge::BRONZE]) . "\n" . _loc("badges.mail.star.text2", array($twitter, $facebook));
                $meta = "star_bronze";
            } else if($writerBadge == Badge::SILVER) {
                $text = _loc("badges.mail.star.text.silver", Badge::$levels[Badge::STAR][Badge::SILVER]) . "\n" . _loc("badges.mail.star.text2", array($twitter, $facebook));
                $meta = "star_silver";
            } else if($writerBadge == Badge::GOLD) {
                $text = _loc("badges.mail.star.text.gold", Badge::$levels[Badge::STAR][Badge::GOLD]) . "\n" . _loc("badges.mail.star.text2", array($twitter, $facebook));
                $meta = "star_gold";
            } else if($writerBadge == Badge::DIAMOND) {
                $text = _loc("badges.mail.star.text.diamond", Badge::$levels[Badge::STAR][Badge::DIAMOND]) . "\n" . _loc("badges.mail.star.text2", array($twitter, $facebook));
                $meta = "star_diamond";
            }

            Message::send(
                Message::TYPE_BADGE,
                User::TWICKIT_USER_ID,
                $inAuthor->getId(),
                _loc("badges.mail.star.title"),
                $text,
                $meta
            );
			$message->mail();
        }
    }
}
?>
