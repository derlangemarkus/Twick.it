<?php
/*
 * Created at 13.07.2009
 *
 * @author Markus Moeller - Twick.it
 */

class NoWordStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getId() {
		return $this->_getValueForKey("id");
	}

	function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	function getUserId() {
		return $this->_getValueForKey("user_id");
	}

	function setUserId($inUserId) {
		$this->_setValueForKey("user_id", $inUserId);
	}


	function getWord() {
		return $this->_getValueForKey("word");
	}

	function setWord($inWord) {
		$this->_setValueForKey("word", $inWord);
	}


	function getReason() {
		return $this->_getValueForKey("reason");
	}

	function setReason($inReason) {
		$this->_setValueForKey("reason", $inReason);
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
		return array_pop(NoWord::fetch(array("id"=>$inId)));
	}
	
	
	public function fetchAll($inOptions=array()) {
		return NoWord::fetch(array(), $inOptions);
	}
	
	
	public function fetch($inBindings, $inOptions=array()) {
		return NoWord::_fetch(AbstractDatabaseObject::_buildSQL(NoWord::_getDatabaseName(), $inBindings, $inOptions));
	}


	public function fetchBySQL($inSQL) {
		return NoWord::_fetch("SELECT * FROM " . NoWord::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_no_words";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY word ASC";
		}

		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}
		
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, NoWord::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		
		return $objects;
	}


	private function _createFromDB($inResult) {
		$noword = new NoWord();
		$noword->_setDatabaseValues($inResult);
		return $noword;
	}
}
?>