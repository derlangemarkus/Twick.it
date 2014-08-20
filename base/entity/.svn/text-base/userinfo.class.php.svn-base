<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/UserInfoStub.class.php";

class UserInfo extends UserInfoStub {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getAvatar($inSize=32, $inStyle="") {
		$displayName = htmlspecialchars($this->getDisplayName());
		$url = $this->getAvatarUrl($inSize);
		return "<img src='$url' alt='$displayName' title='$displayName: " . _loc('user.about.rankingSum') . " " . $this->getRatingSum() . "' width='$inSize' height='$inSize' style='$inStyle' />";
	}
	

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByLogin($inLogin, $inAllLanguages=false) {
		$users = UserInfo::fetch(array("login"=>$inLogin), $inAllLanguages);
		if ($inAllLanguages) {
			$lang = getLanguage();
			foreach($users as $aUser) {
				if ($aUser->getLanguageCode() == $lang) {
					$users = array($aUser);
					break;
				}
			}
		}
		return array_pop($users);
	}


	public function fetchMostActiveUsers($inLimit=3, $inOffset=0) {
		return UserInfo::fetchAll(false, false, array("ORDER BY"=>"twick_count DESC", "LIMIT"=>$inLimit, "OFFSET"=>$inOffset));
	}


	public function fetchBestSumUsers($inLimit=3) {
		return UserInfo::fetchAll(false, false, array("ORDER BY"=>"rating_sum DESC", "LIMIT"=>$inLimit));
	}
	
	
	public function findNumberOfTwicks($inAllLanguages=false) {
		$sql = "SELECT count(*) AS c FROM " . Twick::_getDatabaseName() . " x";
		if (!$inAllLanguages) {
			$sql .= ", " . Topic::_getDatabaseName() . " t WHERE t.id=x.topic_id AND t.language_code='" . getLanguage() . "'";
		}
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$count = $result["c"];
		} else {
			$count = 0;
		}

		return $count;
	}
	
	
	function findNumberOfUsers($inAllLanguages=false) {
		if($inAllLanguages) {
			$sql = "SELECT count(*) AS c FROM " . User::_getDatabaseName();
		} else {
			$sql = "SELECT count(*) AS c FROM " . UserInfo::_getDatabaseName() . " x WHERE language_code='" . getLanguage() . "'";
		}
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$count = $result["c"];
		} else {
			$count = 0;
		}

		return $count;
	}
	
	
	function findRatingPosition() {
		$sql = "SELECT count(*)+1 AS position FROM " . UserInfo::_getDatabaseName() . " WHERE ifnull(rating_sum, 0) > (SELECT max(ifnull(rating_sum, 0)) FROM " . UserInfo::_getDatabaseName() . " WHERE id=" . $this->getId() . " AND (language_code='" . getLanguage() . "' OR language_code IS NULL)) AND (language_code='" . getLanguage() . "' OR language_code IS NULL)";
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$position = $result["position"];
		} else {
			$position = -1;
		}

		return $position;
	}
	
	
	function findTwicksForUsersTopics($inLimit=false, $inAllLanguages=false) {
		return Twick::findTwicksForUsersTopics($this->getId(), $inLimit, $inAllLanguages);
	}


    public function fetchRandom($inLimit=1, $inAllLanguages=false) {
		return UserInfo::fetch(array(), $inAllLanguages, array("ORDER BY"=>"rand()", "LIMIT"=>$inLimit));
	}
}
?>