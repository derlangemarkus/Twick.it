<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */

class UserInfoStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	private $user;


	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getAvatarUrl($inSize=32) {
		return $this->user->getAvatarUrl($inSize);
	}

	function getUrl() {
		return $this->user->getUrl();
	}
	
	function getTags() {
		return $this->user->getTags();
	}

	function getLanguageCode() {
		return $this->_getValueForKey("language_code");
	}

	function getRatingSum() {
		return $this->_getValueForKey("rating_sum");
	}

	function getRatingCount() {
		return $this->_getValueForKey("rating_count");
	}

	function getTwickCount() {
		return $this->_getValueForKey("twick_count");
	}


	function __call($inName, $inArguments) {
		if(method_exists($this->user, $inName)) {
			return call_user_func_array(array($this->user, $inName), $inArguments);
		}	
	}
	
	
	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchById($inId) {
		static $__TWICKIT_USERINFO_CACHE;
		if (isset($__TWICKIT_USERINFO_CACHE[$inId])) {
			return $__TWICKIT_USERINFO_CACHE[$inId];
		} else {
			$user = array_pop(UserInfo::fetch(array("tbl_users.id"=>$inId)));
			$__TWICKIT_USERINFO_CACHE[$inId] = $user ? $user : false;
			return $user;
		}
	}
	
	
	public function fetchAll($inWithInactive=false, $inAllLanguages=false, $inOptions=array()) {
		$bindings = array();
		$bindings["deleted"] = 0;
		if (!$inWithInactive) {
			$bindings["approved"] = 1;
		}
		return UserInfo::fetch($bindings, $inAllLanguages, $inOptions);
	}
	
	
	public function fetch($inBindings, $inAllLanguages=false, $inOptions=array()) {
		AbstractDatabaseObject::_setDefaultOptions($inOptions, array("ORDER BY"=>"rating_sum DESC, id DESC"));
		
		$sql = "SELECT";
		$sql .= " tbl_users.*, ";
		$sql .= " tbl_topics.language_code,";
		$sql .= " sum(ifnull(tbl_twick_ratings.rating, 0)) AS rating_sum, ";
		$sql .= " count(distinct tbl_twick_ratings.id) AS rating_count,";
		$sql .= " count(distinct tbl_twicks.id) as twick_count";
		$sql .= " FROM tbl_users";
		$sql .= " LEFT JOIN tbl_twicks ON tbl_twicks.user_id=tbl_users.id"; 
		$sql .= " LEFT JOIN tbl_topics ON tbl_topics.id=tbl_twicks.topic_id"; 
		$sql .= " LEFT JOIN tbl_twick_ratings ON tbl_twick_ratings.twick_id=tbl_twicks.id"; 
		
		$where = "";
		$separator = "";
		foreach($inBindings as $key=>$value) {
			$where .= $separator . " $key='$value' ";
			$separator = " AND ";
		}		
		if ($where) {
			$sql .= " WHERE $where";
		}
		
		$sql .= " GROUP BY tbl_users.mail, tbl_topics.language_code";
		$sql .= " ORDER BY " . $inOptions["ORDER BY"];	
		
		if (isset($inOptions["LIMIT"])) {
			$sql .= " LIMIT " . $inOptions["LIMIT"];
		}

        if (isset($inOptions["OFFSET"])) {
			$sql .= " OFFSET " . $inOptions["OFFSET"];
		}
		
		return UserInfo::_fetch($sql, $inAllLanguages);
	}


	public function fetchBySQL($inSQL, $inAllLanguages=false) {
		return UserInfo::_fetch("SELECT * FROM " . UserInfo::_getDatabaseName() . " WHERE $inSQL", $inAllLanguages);
	}

	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "view_user_infos";
	}


	protected function _fetch($inSQL, $inAllLanguages=false) {
		$objects = array();
		if (!$inAllLanguages) {
			if (preg_match("/^(.*)\s*WHERE\s*(.*?)((LIMIT|ORDER BY|GROUP BY) .*)?$/", $inSQL, $matches)) {
				$select = $matches[1];
				$originalSQL = $matches[2];
				$orderBy = sizeof($matches)==5 ? $matches[3] : "";
				$inSQL = $select . " WHERE (language_code='" . getLanguage() . "') AND (" . $originalSQL . ") $orderBy";
			} else {
				$inSQL = substringBefore($inSQL, "GROUP BY") . " WHERE language_code='" . getLanguage() . "' GROUP BY " . substringAfter($inSQL, "GROUP BY") ;
			}
		}

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY rating_sum DESC, id DESC";
		}
		
		//echo("$inSQL<br />");
		
		
		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, UserInfo::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		
		return $objects;
	}


	private function _createFromDB($inResult) {
		$userinfo = new UserInfo();
		$userinfo->_setDatabaseValues($inResult);
		
		$user = new User();
		$user->_setDatabaseValues($inResult);
		$userinfo->user = $user;
		
		return $userinfo;
	}
}
?>