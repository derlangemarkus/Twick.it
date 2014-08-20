<?php
/*
 * Created at 02.06.2009
 *
 * @author Markus Moeller - Twick.it
 */

class BlockedUserStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getId() {
		return $this->_getValueForKey("id");
	}

	function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	function getMyUserId() {
		return $this->_getValueForKey("my_user_id");
	}

	function setMyUserId($inMyUserId) {
		$this->_setValueForKey("my_user_id", $inMyUserId);
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
		return array_pop(BlockedUser::fetch(array("id"=>$inId)));
	}
	
	
	public function fetchAll($inOptions=array()) {
		return BlockedUser::fetch(array(), $inOptions);
	}
	
	
	public function fetch($inBindings, $inOptions=array()) {
		return BlockedUser::_fetch(AbstractDatabaseObject::_buildSQL(BlockedUser::_getDatabaseName(), $inBindings, $inOptions));
	}


	public function fetchBySQL($inSQL) {
		return BlockedUser::_fetch("SELECT * FROM " . BlockedUser::_getDatabaseName() . " WHERE $inSQL");
	}

	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_blocked_users";
	}


	protected function _fetch($inSQL) {
		$objects = array();
 
		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY creation_date ASC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, BlockedUser::_createFromDB($result));
		}

		return $objects;
	}


	private function _createFromDB($inResult) {
		$blockeduser = new BlockedUser();
		$blockeduser->_setDatabaseValues($inResult);
		return $blockeduser;
	}


}
?>