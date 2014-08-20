<?php
/*
 * Created at 18.10.2011
 *
 * @author Markus Moeller - Twick.it
 */

class SearchStatStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getId() {
		return $this->_getValueForKey("id");
	}

	public function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	public function getLanguage() {
		return $this->_getValueForKey("language");
	}

	public function setLanguage($inLanguage) {
		$this->_setValueForKey("language", $inLanguage);
	}


	public function getQuery() {
		return $this->_getValueForKey("query");
	}

	public function setQuery($inQuery) {
		$this->_setValueForKey("query", $inQuery);
	}


	public function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	public function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


	public function getUserId() {
		return $this->_getValueForKey("user_id");
	}

	public function setUserId($inUserId) {
		$this->_setValueForKey("user_id", $inUserId);
	}


	public function getIp() {
		return $this->_getValueForKey("ip");
	}

	public function setIp($inIp) {
		$this->_setValueForKey("ip", $inIp);
	}
	
	
	public function getTag() {
		return $this->_getValueForKey("tag");
	}

	public function setTag($inTag) {
		$this->_setValueForKey("tag", $inTag);
	}

	
	public function getFound() {
		return $this->_getValueForKey("found");
	}

	public function setFound($inFound) {
		$this->_setValueForKey("found", $inFound);
	}

	
	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(SearchStat::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return SearchStat::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return SearchStat::_fetch(AbstractDatabaseObject::_buildSQL(SearchStat::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return SearchStat::_fetch("SELECT * FROM " . SearchStat::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_search_stats";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY creation_date DESC, ip ASC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, SearchStat::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$searchstat = new SearchStat();
		$searchstat->_setDatabaseValues($inResult);
		return $searchstat;
	}


}
?>