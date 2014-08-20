<?php
/*
 * Created at 17.05.2011
 *
 * @author Markus Moeller - Twick.it
 */

class WallPostStub extends AbstractDatabaseObject {

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


	public function getMessage() {
		return $this->_getValueForKey("message");
	}

	public function setMessage($inMessage) {
		$this->_setValueForKey("message", $inMessage);
	}


	public function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	public function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


    public function getUpdateDate() {
		return $this->_getValueForKey("update_date");
	}

	public function setUpdateDate($inUpdateDate) {
		$this->_setValueForKey("update_date", $inUpdateDate);
	}


	public function getDeletedSender() {
		return $this->_getValueForKey("deleted_sender");
	}

	public function setDeletedSender($inDeletedSender) {
		$this->_setValueForKey("deleted_sender", $inDeletedSender);
	}


	public function getDeletedReceiver() {
		return $this->_getValueForKey("deleted_receiver");
	}

	public function setDeletedReceiver($inDeletedReceiver) {
		$this->_setValueForKey("deleted_receiver", $inDeletedReceiver);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(WallPost::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return WallPost::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return WallPost::_fetch(AbstractDatabaseObject::_buildSQL(WallPost::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return WallPost::_fetch("SELECT * FROM " . WallPost::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_wall_posts";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY update_date DESC, id DESC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, WallPost::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$wallpost = new WallPost();
		$wallpost->_setDatabaseValues($inResult);
		return $wallpost;
	}


}
?>
