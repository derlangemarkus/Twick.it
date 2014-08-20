<?php
/*
 * Created at 18.04.2011
 *
 * @author Markus Moeller - Twick.it
 */

class SpamMessageStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getId() {
		return $this->_getValueForKey("id");
	}

	public function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	public function getMessageId() {
		return $this->_getValueForKey("message_id");
	}

	public function setMessageId($inMessageId) {
		$this->_setValueForKey("message_id", $inMessageId);
	}


	public function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	public function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(SpamMessage::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return SpamMessage::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return SpamMessage::_fetch(AbstractDatabaseObject::_buildSQL(SpamMessage::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return SpamMessage::_fetch("SELECT * FROM " . SpamMessage::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_spam_messages";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY id ASC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, SpamMessage::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$spammessage = new SpamMessage();
		$spammessage->_setDatabaseValues($inResult);
		return $spammessage;
	}


}
?>