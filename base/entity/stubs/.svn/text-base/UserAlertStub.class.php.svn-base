<?php
/*
 * Created at 11.05.2011
 *
 * @author Markus Moeller - Twick.it
 */

class UserAlertStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getId() {
		return $this->_getValueForKey("id");
	}

	public function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	public function getUserId() {
		return $this->_getValueForKey("user_id");
	}

	public function setUserId($inUserId) {
		$this->_setValueForKey("user_id", $inUserId);
	}


	public function getAuthorId() {
		return $this->_getValueForKey("author_id");
	}

	public function setAuthorId($inAuthorId) {
		$this->_setValueForKey("author_id", $inAuthorId);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(UserAlert::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return UserAlert::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return UserAlert::_fetch(AbstractDatabaseObject::_buildSQL(UserAlert::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return UserAlert::_fetch("SELECT * FROM " . UserAlert::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_user_alerts";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY id ASC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, UserAlert::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$useralert = new UserAlert();
		$useralert->_setDatabaseValues($inResult);
		return $useralert;
	}


}
?>