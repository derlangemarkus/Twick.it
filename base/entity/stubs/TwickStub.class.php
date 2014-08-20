<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */

class TwickStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getId() {
		return $this->_getValueForKey("id");
	}

	function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	function getTopicId() {
		return $this->_getValueForKey("topic_id");
	}

	function setTopicId($inTopicId) {
		$this->_setValueForKey("topic_id", $inTopicId);
	}

	
	function getLanguageCode() {
		return $this->_getValueForKey("language");
	}

	function setLanguageCode($inLanguageCode) {
		$this->_setValueForKey("language", $inLanguageCode);
	}
	
	
	function getTitle() {
		return $this->_getValueForKey("title");
	}

	function setTitle($inTitle) {
		$this->_setValueForKey("title", $inTitle);
	}
	

	function getAcronym() {
		return $this->_getValueForKey("acronym");
	}

	function setAcronym($inAcronym) {
		$this->_setValueForKey("acronym", $inAcronym);
	}


	function getText() {
		return $this->_getValueForKey("text");
	}

	function setText($inText) {
		$this->_setValueForKey("text", $inText);
	}

	function getLink($inAffiliate=false) {
        if($inAffiliate) {
            return rewriteAmazonLinks($this->_getValueForKey("link"));
        } else {
            return $this->_getValueForKey("link");
        }
	}

	function setLink($inLink) {
		if ($inLink && !contains($inLink, "://")) {
			$inLink = "http://" . $inLink;
		}
		$this->_setValueForKey("link", $inLink);
	}


	function getUserId() {
		return $this->_getValueForKey("user_id");
	}

	function setUserId($inUserId) {
		$this->_setValueForKey("user_id", $inUserId);
	}


	function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}

	
	function getInputSource() {
		return $this->_getValueForKey("input_source");
	}

	function setInputSource($inInputSource) {
		$this->_setValueForKey("input_source", $inInputSource);
	}
	
	
	function getRatingSumCached() {
		return $this->_getValueForKey("rating_sum");
	}

	function setRatingSumCached($inRatingSum) {
		$this->_setValueForKey("rating_sum", $inRatingSum);
	}
	
	
	function getRatingCountCached() {
		return $this->_getValueForKey("rating_count");
	}

	function setRatingCountCached($inRatingCount) {
		$this->_setValueForKey("rating_count", $inRatingCount);
	}
	

	function isBlocked() {
		return BlockedUser::isUserBlocked($this->getUserId());
	}
	

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchById($inId) {
		return array_pop(Twick::fetch(array("id"=>$inId)));
	}
	

	public function fetchAll($inOptions, $inAllLanguages=false) {
		return Twick::fetch(array(), $inOptions, $inAllLanguages);
	}
	
	
	public function fetch($inBindings, $inOptions=array(), $inAllLanguages=false) {
		AbstractDatabaseObject::_setDefaultOptions($inOptions, array("ORDER BY"=>"rating_sum DESC, creation_date DESC"));		
		return Twick::_fetch(AbstractDatabaseObject::_buildSQL(Twick::_getDatabaseName(), $inBindings, $inOptions), $inAllLanguages);
	}


	public function fetchBySQL($inSQL, $inAllLanguages=false) {
		return Twick::_fetch("SELECT * FROM " . Twick::_getDatabaseName() . " WHERE $inSQL", $inAllLanguages);
	}

	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_twicks";
	}


	protected function _fetch($inSQL, $inAllLanguages=false) {
		$objects = array();

		if (!$inAllLanguages) {
			if (preg_match("/^(.*)\s*WHERE\s*(.*?)((LIMIT|ORDER BY|GROUP BY) .*)?$/", $inSQL, $matches)) {
				$select = $matches[1];
				$originalSQL = $matches[2];
				$orderBy = sizeof($matches)==5 ? $matches[3] : "";
				$inSQL = $select . " WHERE (language='" . getLanguage() . "') AND (" . $originalSQL . ") $orderBy";
			} else {
				$inSQL = substringBefore($inSQL, "GROUP BY") . " WHERE language='" . getLanguage() . "' GROUP BY " . substringAfter($inSQL, "GROUP BY") ;
			}
		}

		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}
		
		
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, Twick::_createFromDB($result));
		}
		
		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);

		return $objects;
	}


	private function _createFromDB($inResult) {
		$twick = new Twick();
		$twick->_setDatabaseValues($inResult);
		return $twick;
	}
}
?>