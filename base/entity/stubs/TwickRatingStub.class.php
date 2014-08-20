<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */

class TwickRatingStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getId() {
		return $this->_getValueForKey("id");
	}

	function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	function getTwickId() {
		return $this->_getValueForKey("twick_id");
	}

	function setTwickId($inTwickId) {
		$this->_setValueForKey("twick_id", $inTwickId);
	}


	function getRating() {
		return $this->_getValueForKey("rating");
	}

	function setRating($inRating) {
		$this->_setValueForKey("rating", $inRating);
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


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchById($inId) {
		return array_pop(TwickRating::fetch(array("id"=>$inId)));
	}
	
	
	public function fetchAll($inOptions=array()) {
		return TwickRating::fetch(array(), $inOptions);
	}
	
	
	public function fetch($inBindings, $inOptions=array()) {
		return TwickRating::_fetch(AbstractDatabaseObject::_buildSQL(TwickRating::_getDatabaseName(), $inBindings, $inOptions));
	}


	public function fetchBySQL($inSQL) {
		return TwickRating::_fetch("SELECT * FROM " . TwickRating::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_twick_ratings";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY creation_date ASC";
		}

		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}
		
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, TwickRating::_createFromDB($result));
		}
		
		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);

		return $objects;
	}


	private function _createFromDB($inResult) {
		$twickrating = new TwickRating();
		$twickrating->_setDatabaseValues($inResult);
		return $twickrating;
	}
}
?>