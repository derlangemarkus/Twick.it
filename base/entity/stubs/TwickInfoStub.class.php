<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */

class TwickInfoStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	private $twick;
	
	
	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getTitle() {
		return $this->_getValueForKey("title");
	}

	
	function getStemming() {
		return $this->_getValueForKey("stemming");
	}
	
	
	function getLanguageCode() {
		return $this->_getValueForKey("language_code");
	}


	function getLogin() {
		return $this->_getValueForKey("login");
	}
	
	function getFirstName() {
		return $this->_getValueForKey("first_name");
	}

	function getLastName() {
		return $this->_getValueForKey("last_name");
	}

	function getMail() {
		return $this->_getValueForKey("mail");
	}

	function getUserLink() {
		return $this->_getValueForKey("user_link");
	}


	function getRating() {
		$rating = $this->_getValueForKey("rating");
		if (!$rating) {
			$rating = 0;
		}
		return $rating;
	}

	
	function getRatingCount() {
		$rating = $this->_getValueForKey("rating_count");
		if (!$rating) {
			$rating = 0;
		}
		return $rating;
	}


	function getRatingRatio() {
		$count = $this->getRatingCount();
		
		if ($count == 0) {
			return 0;
		} else {
			$rating = $this->getRating();
			$diff = $count - $rating;
			
			$good = $count - ($diff/2);
			
			return 100 * $good / $count;
		}
	}

	function getUser() {
		$user = new User();
		$user->_setDatabaseValues($this->getDatabaseValues());
		return $user;
	}
	
	
	function __call($inName, $inArguments) {
		if(method_exists($this->twick, $inName)) {
			return call_user_func_array(array($this->twick, $inName), $inArguments);
		}	
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function delete() {
		$this->twick->delete();
	}
	
	
	public function fetchById($inId) {
		return array_pop(TwickInfo::fetch(array("tbl_twicks.id"=>$inId), true));
	}
	
	
	public function fetchAll($inAllLanguages=false, $inOptions=array()) {
		return TwickInfo::fetch(array(), $inAllLanguages, $inOptions);
	}

	
	public function fetch($inBindings, $inAllLanguages=false, $inOptions=array()) {
		AbstractDatabaseObject::_setDefaultOptions($inOptions, array("ORDER BY"=>"rating DESC, creation_date DESC"));		
		$sql = "SELECT ";
		$sql .= " tbl_topics.title, tbl_topics.language_code,";
		$sql .= " tbl_twicks.id, tbl_twicks.topic_id, tbl_twicks.acronym, tbl_twicks.text, tbl_twicks.link, tbl_twicks.user_id, tbl_twicks.creation_date,";
		$sql .= " tbl_users.login, tbl_users.name, tbl_users.mail, tbl_users.twitter, tbl_users.deleted, tbl_users.link AS user_link,";
		$sql .= " SUM(ifnull(tbl_twick_ratings.rating, 0)) AS rating, COUNT(DISTINCT tbl_twick_ratings.id) AS rating_count";
		$sql .= " FROM tbl_twicks";
		$sql .= " LEFT JOIN tbl_topics ON tbl_topics.id = tbl_twicks.topic_id";
		$sql .= " LEFT JOIN tbl_twick_ratings ON tbl_twick_ratings.twick_id = tbl_twicks.id";
		$sql .= " LEFT JOIN tbl_users ON tbl_users.id = tbl_twicks.user_id";
		
		$where = "";
		$separator = "";
		foreach($inBindings as $key=>$value) {
			$where .= $separator . " $key='$value' ";
			$separator = " AND ";
		}		
		if ($where) {
			$sql .= " WHERE $where";
		}

		$sql .= " GROUP BY tbl_twicks.id, tbl_topics.language_code";
		$sql .= " ORDER BY " . $inOptions["ORDER BY"];	
		
		if (isset($inOptions["LIMIT"])) {
			$sql .= " LIMIT " . $inOptions["LIMIT"];
		}
		
		if (isset($inOptions["OFFSET"])) {
			$sql .= " OFFSET " . $inOptions["OFFSET"];
		}
		
		return TwickInfo::_fetch($sql, $inAllLanguages);
	}


	public function fetchBySQL($inSQL, $inAllLanguages=false) {
		return TwickInfo::_fetch("SELECT * FROM " . TwickInfo::_getDatabaseName() . " WHERE $inSQL", $inAllLanguages);
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "view_twick_infos";
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

		//echo("$inSQL<br />");
		
		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}
		
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, TwickInfo::_createFromDB($result));
		}
		
		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);

		return $objects;
	}



	private function _createFromDB($inResult) {
		$twickinfo = new TwickInfo();
		$twickinfo->_setDatabaseValues($inResult);
		
		$twick = new Twick();
		$twick->_setDatabaseValues($inResult);
		$twickinfo->twick = $twick;
		
		return $twickinfo;
	}
}
?>