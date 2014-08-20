<?php
class TwickKeywordFinder extends KeywordFinder {
	
	function TwickKeywordFinder($inTwicks, $inDistinctUser=true, $inSkipNummeric=true) {
		$processedUsers = array();
		$content = "";
		if (
			sizeof($inTwicks) >= MIN_TWICKS_FOR_CLOUD ||
			sizeof($inTwicks) == 1 && $inTwicks[0]->findUser()->getAdmin()  // Wenn es nur einen Twick gibt und dieser von einem Admin kommt, wird er auch beruecksichtigt
		) {
			foreach($inTwicks as $twick) {
				if ($twick->getRatingSumCached() <= 0) {
					$user = $twick->findUser();
					if (!$user->getAdmin() && false) {
						continue;
					}
				}
				if (!$inDistinctUser || !in_array($twick->getUserId(), $processedUsers)) {
					$content .= $twick->getText() . "\n";
					$processedUsers[] = $twick->getUserId();
				}
			}
			
			if (
				sizeof($processedUsers) < MIN_TWICKS_FOR_CLOUD &&
				(sizeof($processedUsers) != 1 || !User::fetchById($processedUsers[0])->getAdmin())
			) {
				$content = "";
			}
		}
		
		KeywordFinder::KeywordFinder($content, $inSkipNummeric);
	}
}