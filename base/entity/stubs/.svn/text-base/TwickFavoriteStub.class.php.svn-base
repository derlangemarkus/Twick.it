<?php 
/*
 * Created at 12.06.2009
 *
 * @author Markus Moeller - Twick.it
 */

class TwickFavoriteStub extends AbstractDatabaseObject {

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
		return array_pop(TwickFavorite::fetch(array("id"=>$inId)));
	}
	
	
	public function fetchAll($inOptions=array()) {
		return TwickFavorite::fetch(array(), $inOptions);
	}
	
	
	public function fetch($inBindings, $inOptions=array()) {
		return TwickFavorite::_fetch(AbstractDatabaseObject::_buildSQL(TwickFavorite::_getDatabaseName(), $inBindings, $inOptions));
	}


	public function fetchBySQL($inSQL) {
		return TwickFavorite::_fetch("SELECT * FROM " . TwickFavorite::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_twick_favorites";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY twick_id ASC";
		}
		
		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, TwickFavorite::_createFromDB($result));
		}
		
		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);

		return $objects;
	}


	private function _createFromDB($inResult) {
		$twickfavorite = new TwickFavorite();
		$twickfavorite->_setDatabaseValues($inResult);
		return $twickfavorite;
	}
}
?>