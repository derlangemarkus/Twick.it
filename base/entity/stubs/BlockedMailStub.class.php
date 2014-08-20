<?php
/*
 * Created at 26.05.2009
 *
 * @author Markus Moeller - Twick.it
 */

class BlockedMailStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getId() {
		return $this->_getValueForKey("id");
	}

	function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	function getMail() {
		return $this->_getValueForKey("mail");
	}

	function setMail($inMail) {
		$this->_setValueForKey("mail", $inMail);
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
		return array_pop(BlockedMail::fetch(array("id"=>$inId)));
	}


	public function fetchAll($inOptions=array()) {
		return BlockedMail::fetch(array(), $inOptions);
	}
	
	
	public function fetch($inBindings, $inOptions=array()) {
		return BlockedMail::_fetch(AbstractDatabaseObject::_buildSQL(BlockedMail::_getDatabaseName(), $inBindings, $inOptions));
	}


	public function fetchBySQL($inSQL) {
		return BlockedMail::_fetch("SELECT * FROM " . BlockedMail::_getDatabaseName() . " WHERE $inSQL");
	}

	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_blocked_mails";
	}


	protected function _fetch($inSQL) {
		$objects = array();
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, BlockedMail::_createFromDB($result));
		}

		return $objects;
	}


	private function _createFromDB($inResult) {
		$blockedmail = new BlockedMail();
		$blockedmail->_setDatabaseValues($inResult);
		return $blockedmail;
	}
}
?>