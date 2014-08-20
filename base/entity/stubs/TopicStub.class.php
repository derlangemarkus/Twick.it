<?php
/*
 * Created at 26.05.2009
 *
 * @author Markus Moeller - Twick.it
 */

class TopicStub extends AbstractTaggedDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------	
	function getId() {
		return $this->_getValueForKey("id");
	}

	function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	function getTitle() {
		return $this->_getValueForKey("title");
	}

	function setTitle($inTitle) {
		$this->_setValueForKey("title", $inTitle);
	}
	
	
	function getCoreTitle() {
		return $this->_getValueForKey("core_title");
	}

	function setCoreTitle($inCoreTitle) {
		$this->_setValueForKey("core_title", $inCoreTitle);
	}


	function getStemming() {
		return $this->_getValueForKey("stemming");
	}

	function setStemming($inStemming) {
		$this->_setValueForKey("stemming", $inStemming);
	}
	
	
	function getLanguageCode() {
		return $this->_getValueForKey("language_code");
	}

	function setLanguageCode($inLanguageCode) {
		$this->_setValueForKey("language_code", $inLanguageCode);
	}

	
	function getUrlId() {
		return $this->_getValueForKey("url_id");
	}

	function setUrlId($inUrlId) {
		$this->_setValueForKey("url_id", $inUrlId);
	}


    function getLongitude() {
		return $this->_getValueForKey("longitude");
	}

	function setLongitude($inLongitude) {
		$this->_setValueForKey("longitude", $inLongitude);
	}


    function getLatitude() {
		return $this->_getValueForKey("latitude");
	}

	function setLatitude($inLatitude) {
		$this->_setValueForKey("latitude", $inLatitude);
	}

    public function hasCoordinates() {
        return $this->getLatitude() || $this->getLongitude();
    }


    function getGeoDate() {
		return $this->_getValueForKey("geo_date");
	}

	function setGeoDate($inGeoDate) {
		$this->_setValueForKey("geo_date", $inGeoDate);
	}


    function getNoGeo() {
		return $this->_getValueForKey("no_geo");
	}

	function setNoGeo($inNoGeo) {
		$this->_setValueForKey("no_geo", $inNoGeo);
	}


	function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchById($inId) {
		static $__TWICKIT_TOPIC_CACHE;
		if (isset($__TWICKIT_TOPIC_CACHE[$inId])) {
			return $__TWICKIT_TOPIC_CACHE[$inId];
		} else {
			$topic = array_pop(Topic::fetch(array("id"=>$inId), true));
			$__TWICKIT_TOPIC_CACHE[$inId] = $topic ? $topic : false;
			return $topic;
		}
	}


	public function fetchAll($inOptions=array()) {
		return Topic::fetch(array(), false, $inOptions);
	}
	
	
	public function fetch($inBindings, $inAllLanguages=false, $inOptions=array()) {
		return Topic::_fetch(AbstractDatabaseObject::_buildSQL(Topic::_getDatabaseName(), $inBindings, $inOptions), $inAllLanguages);
	}


	public function fetchBySQL($inSQL, $inAllLanguages=false) {
		return Topic::_fetch("SELECT * FROM " . Topic::_getDatabaseName() . " WHERE $inSQL", $inAllLanguages);
	}

	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_topics";
	}


	protected function _fetch($inSQL, $inAllLanguages=false) {
		$objects = array();
		if (!$inAllLanguages) {
			if (preg_match("/^(.*)\s*WHERE\s*(.*?)((LIMIT|GROUP BY|ORDER BY) .*)?$/", $inSQL, $matches)) {
				$select = $matches[1];
				$originalSQL = $matches[2];
				$orderBy = sizeof($matches)==5 ? $matches[3] : "";
				$inSQL = $select . " WHERE (language_code='" . getLanguage() . "') AND (" . $originalSQL . ") $orderBy";
			} else {
				$inSQL .= " WHERE language_code='" . getLanguage() . "'";
			}
		}

		if (false && !preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY title ASC";
		}
	
		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}
		
		
		$db =& DB::getInstance();
		$db->query($inSQL);
		
		while ($result = $db->getNextResult()) {
			array_push($objects, Topic::_createFromDB($result));
		}
		
		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		
		return $objects;
	}


	protected function _createFromDB($inResult) {
		$topic = new Topic();
		$topic->_setDatabaseValues($inResult);
		return $topic;
	}
}
?>