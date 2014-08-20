<?php
/*
 * Created at 12.04.2011
 *
 * @author Markus Moeller - Twick.it
 */

class MessageStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getId() {
		return $this->_getValueForKey("id");
	}

	public function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	public function getParentId() {
		return $this->_getValueForKey("parent_id");
	}

	public function setParentId($inParentId) {
		$this->_setValueForKey("parent_id", $inParentId);
	}


	public function getSendDate() {
		return $this->_getValueForKey("send_date");
	}

	public function setSendDate($inSendDate) {
		$this->_setValueForKey("send_date", $inSendDate);
	}


	public function getReadDate() {
		return $this->_getValueForKey("read_date");
	}

	public function setReadDate($inReadDate) {
		$this->_setValueForKey("read_date", $inReadDate);
	}


	public function getSenderId() {
		return $this->_getValueForKey("sender_id");
	}

	public function setSenderId($inSenderId) {
		$this->_setValueForKey("sender_id", $inSenderId);
	}


	public function getReceiverId() {
		return $this->_getValueForKey("receiver_id");
	}

	public function setReceiverId($inReceiverId) {
		$this->_setValueForKey("receiver_id", $inReceiverId);
	}


	public function getDeletedSender() {
		return $this->_getValueForKey("deleted_sender");
	}

	public function setDeletedSender($inDeletedSender) {
		$this->_setBooleanValueForKey("deleted_sender", $inDeletedSender);
	}


	public function getDeletedReceiver() {
		return $this->_getValueForKey("deleted_receiver");
	}

	public function setDeletedReceiver($inDeletedReceiver) {
		$this->_setBooleanValueForKey("deleted_receiver", $inDeletedReceiver);
	}


	public function getSubject() {
		return $this->_getValueForKey("subject");
	}

	public function setSubject($inSubject) {
		$this->_setValueForKey("subject", $inSubject);
	}


	public function getMessage() {
		return $this->_getValueForKey("message");
	}

	public function setMessage($inMessage) {
		$this->_setValueForKey("message", $inMessage);
	}


	public function getType() {
		return $this->_getValueForKey("type");
	}

	public function setType($inType) {
		$this->_setValueForKey("type", $inType);
	}


    public function getMeta() {
        return $this->_getValueForKey("meta");
	}

	public function setMeta($inMeta) {
		$this->_setValueForKey("meta", $inMeta);
	}


    public function getSpam() {
        return $this->_getValueForKey("spam");
	}

	public function setSpam($inSpam) {
		$this->_setValueForKey("spam", $inSpam);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(Message::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return Message::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return Message::_fetch(AbstractDatabaseObject::_buildSQL(Message::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return Message::_fetch("SELECT * FROM " . Message::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_messages";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY send_date ASC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, Message::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$message = new Message();
		$message->_setDatabaseValues($inResult);
		return $message;
	}


}
?>


