<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/TwickInfoStub.class.php";

class TwickInfo extends TwickInfoStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function findNumberOfTwicks() {
		return Twick::findNumberOfTwicks();
	}

	
	public function fetchByMail($inMail) {
		return TwickInfo::fetch(array("mail"=>$inMail));
	}


	public function fetchByUserId($inUserId, $inAllLanguages=false, $inOptions=array()) {
		return TwickInfo::fetch(array("tbl_users.id"=>$inUserId), $inAllLanguages, $inOptions);
	}
	

	public function fetchByTitle($inTitle) {
		return TwickInfo::fetch(array("title"=>$inTitle));
	}


	public function fetchByTopicId($inTopicId) {
		static $__TWICKIT_TWICKS_CACHE;
		if (isset($__TWICKIT_TWICKS_CACHE[$inTopicId])) {
			return $__TWICKIT_TWICKS_CACHE[$inTopicId];
		} else {
			$twicks = TwickInfo::fetch(array("topic_id"=>$inTopicId), true);
			$__TWICKIT_TWICKS_CACHE[$inTopicId] = $twicks ? $twicks : false;
			return $twicks;
		}
	}

	
	public function fetchNewestFromRookies($inLimit=3, $inMaxTwicks=10, $inAllLanguages=false) {
		$sql = "SELECT * FROM " . TwickInfo::_getDatabaseName() . " WHERE user_id IN (SELECT distinct user_id FROM " . TwickInfo::_getDatabaseName() ." WHERE creation_date<'" . date("Y-m-d H:i:s", time() - 60*60*24) . "' GROUP BY user_id HAVING count(user_id) <= $inMaxTwicks)";
		if (!$inAllLanguages) {
			$sql .= " AND language_code='" . getLanguage() . "'";
		}
		$sql .= " ORDER BY creation_date DESC LIMIT $inLimit";
		
		return TwickInfo::_fetch($sql, true);
	}
	

	public function fetchRandom($inLimit=1, $inUsername=false, $inAllLanguages=false) {
        $bindings = array();
        if ($inUsername) {
            $bindings["login"] = $inUsername;
        }
		return TwickInfo::fetch($bindings, $inAllLanguages, array("ORDER BY"=>"rand()", "LIMIT"=>$inLimit));
	}

}
?>