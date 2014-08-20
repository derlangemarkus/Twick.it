<?php
class RateTwickNotificator {

    public static function notify($inTwick, $inUser, $inPlusMinus) {
        Notificator::sendNotification(
            $inUser,
            _loc('alerts.message.rateTwick.title', $inTwick->getTitle()),
			// "<table><tr><td><img src='" . HTTP_ROOT . "/html/img/daumen_" . ($inPlusMinus > 0 ? "hoch" : "runter") .".gif' alt=''/></td><td>" . _loc($inPlusMinus > 0 ? 'alerts.message.rateTwick.plus' : 'alerts.message.rateTwick.minus', "<a href='" . $inTwick->getUrl() . "'>" . $inTwick->getTitle() . "</a>") . "</td></tr></table>"
            _loc($inPlusMinus > 0 ? 'alerts.message.rateTwick.plus' : 'alerts.message.rateTwick.minus', "<a href='" . $inTwick->getFixUrl() . "'>" . $inTwick->getTitle() . "</a>")
			,
            $inPlusMinus ? "up" : "down"
        );
    }
}

?>
