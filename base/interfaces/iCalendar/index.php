<?php
require_once("../../util/inc.php");

TwickOfTheDay::getTodaysTwickOfTheDay();
$twicksOfTheDay = TwickOfTheDay::fetchLatest(31);

function _renderIcs($inData) {
    header("Content-Type: text/calendar; charset=utf-8");
    echo("BEGIN:VCALENDAR\r\n");
    echo("VERSION:2.0\r\n");
	echo("CALSCALE:GREGORIAN\r\n");
	echo("PRODID:http://twick.it/interfaces/iCalendar\r\n");
    echo("X-WR-CALNAME:" . _loc('interfaces.icalendar.name') . "\r\n");
    echo("X-WR-CALDESC:" . _loc('interfaces.icalendar.desc') . "\r\n");
    foreach($inData as $data) {
        list($twick, $date) = $data;
		$topic = $twick->findTopic();
        echo("BEGIN:VEVENT\r\n");
        echo("UID:" . $twick->getId() . "@twick.it\r\n");
        echo("SEQUENCE:0\r\n");
        echo("SUMMARY:" . _escapeIcs($twick->getTitle()) . "\r\n");
        echo("DESCRIPTION:");
        if($twick->getAcronym()) {
            loc('twick.accronym');
            echo(" " . _escapeIcs($twick->getAcronym()) . ". \\n");
        }
        echo(_escapeIcs($twick->getText()) . "\\n");
        echo(_escapeIcs(_loc('interfaces.icalendar.by', array($twick->findUser()->getLogin(), $twick->getUrl()))) . "\r\n");
		echo("URL:" . _escapeIcs($twick->getUrl()) . "\r\n");
		if($topic && $topic->hasCoordinates()) {
            echo("GEO:" . $topic->getLatitude() . ";" . $topic->getLongitude(). "\r\n");
        }
        echo("CLASS:PUBLIC\r\n");
        echo("DTSTAMP:" . convertDate($date, "Ymd\THis") . "Z\r\n");
        echo("DTSTART;VALUE=DATE:" . convertDate($date, "Ymd") . "\r\n");
        echo("DTEND;VALUE=DATE:" . convertDate($date, "Ymd") . "\r\n");
        echo("END:VEVENT\r\n");
    }
    echo("END:VCALENDAR\r\n");
}


function _escapeIcs($inText) {
	return str_replace(";", "\\;", str_replace(",", "\\,", $inText));
}



$twicks = array();
foreach($twicksOfTheDay as $twickOfTheDay) {
    $twicks[] = array($twickOfTheDay->findTwick(), $twickOfTheDay->getDate());
}
_renderIcs($twicks);
