<?php
/*
 * Created at 24.05.2007
 *
 * @author Markus Moeller - Twick.it
 */
define("UNKNOWN_DATE", "31.12.2035");

function isDateBetween($inStartDate, $inEndDate, $inDate="") {
	$startSeconds = _getEpochSeconds($inStartDate);
	$endSeconds = _getEpochSeconds($inEndDate);
	$seconds = $inDate ? _getEpochSeconds($inDate) : time();

	$result = true;

	if ($startSeconds > 0) {
		$result &= $startSeconds <= $seconds;
	}
	if ($endSeconds > 0) {
		$result &= $endSeconds >= $seconds;
	}

	return $result;
}


function getCurrentDate() {
	return date("Y-m-d H:i:s");
}


function getCurrentShortDate() {
	return date("Y-m-d");
}


function convertRelativeDate($inText, $inFormat="d.m.y", $inTime=true) {
	$date = convertDate($inText, "d.m.Y");
	$today = date("d.m.Y");
	$yesterday = date("d.m.Y", time() - 60 *60 * 24);
	
	if($date == $today) {
		$date = _loc("core.today");
		if($inTime) {
			$date .= " - " . convertDate($inText, "H:i");
		}
	} else if($date == $yesterday) {
		$date = _loc("core.yesterday");
		if($inTime) {
			$date .= " - " . convertDate($inText, "H:i");
		}
	} 
	return $date;
}


function convertDate($inText, $inFormat="d.m.y") {
	if ($inText =="") {
		return "";	
	} else {
		return date($inFormat, strtotime($inText));
	} 
}

function convertDateForSQL($inText) {
	if (contains($inText, "-")) {
		return $inText;
	}
	if(preg_match("/^(\d\d?)\.(\d\d?)\.(\d\d(\d\d))?$/", $inText, $matches)) {
		return convertDate($matches[3] . "/" .$matches[2] . "/" .$matches[1], "Y-m-d");
	} else {
		return convertDateForSQL(UNKNOWN_DATE);
	}
}

function convertDateForHuman($inText, $inShowTime=false) {
	if ($inText === UNKNOWN_DATE || $inText === convertDateForSQL(UNKNOWN_DATE)) {
		return "";
	} else if (contains($inText, ".")) {
		return $inText;
	} else {
		$date = convertDate($inText, "d.m.Y" . ($inShowTime ? " H:i" : ""));
		return $date === UNKNOWN_DATE ? "" : $date;
	}
}

function convertDateForICal($inText) {
	return convertDate($inText, "Ymd\THis");
}

function convertDateForRss($inText) {
	return convertDate($inText, "r");
}

function isDateInPast($inDate) {
	return _getEpochSeconds($inDate) < time();
}


function getElapsedTime($inDate) {
	$sec = time()-$inDate;
	if ($sec < 60) {
		return $sec . " sec";
	}
	
	$min = (int)($sec / 60);
	if ($min < 60) {
		return $min . " min";
	}
	
	$hours = (int)($min / 60);
	if ($hours < 24) {
		return $hours . " Stunde" . ($hours == 1 ? "" : "n");
	}
	
	$days = (int)($hours / 24);
	return $days . " Tag" . ($days == 1 ? "" : "e");
	
}


function _getEpochSeconds($inDate) {
	if(preg_match("/^(\d{2,4})-(\d{1,2})-(\d{1,2}) (\d\d):(\d\d):00$/", $inDate, $matches)) {
		return mktime($matches[4], $matches[5], 0, $matches[2], $matches[3], $matches[1]);
	} else {
		return -1;
	}
}

?>
