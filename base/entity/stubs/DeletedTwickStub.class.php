<?php
/*
 * Created at 09.08.2011
 *
 * @author Markus Moeller - Twick.it
 */

class DeletedTwickStub extends AbstractDatabaseObject {

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


	public function getTitle() {
		return $this->_getValueForKey("title");
	}

	public function setTitle($inTitle) {
		$this->_setValueForKey("title", $inTitle);
	}


	public function getAcronym() {
		return $this->_getValueForKey("acronym");
	}

	public function setAcronym($inAcronym) {
		$this->_setValueForKey("acronym", $inAcronym);
	}


	public function getText() {
		return $this->_getValueForKey("text");
	}

	public function setText($inText) {
		$this->_setValueForKey("text", $inText);
	}


	public function getLink() {
		return $this->_getValueForKey("link");
	}

	public function setLink($inLink) {
		$this->_setValueForKey("link", $inLink);
	}


	public function getUserId() {
		return $this->_getValueForKey("user_id");
	}

	public function setUserId($inUserId) {
		$this->_setValueForKey("user_id", $inUserId);
	}


	public function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	public function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


	public function getDeleteDate() {
		return $this->_getValueForKey("delete_date");
	}

	public function setDeleteDate($inDeleteDate) {
		$this->_setValueForKey("delete_date", $inDeleteDate);
	}


	public function getInputSource() {
		return $this->_getValueForKey("input_source");
	}

	public function setInputSource($inInputSource) {
		$this->_setValueForKey("input_source", $inInputSource);
	}


	public function getRatingSum() {
		return $this->_getValueForKey("rating_sum");
	}

	public function setRatingSum($inRatingSum) {
		$this->_setValueForKey("rating_sum", $inRatingSum);
	}


	public function getRatingCount() {
		return $this->_getValueForKey("rating_count");
	}

	public function setRatingCount($inRatingCount) {
		$this->_setValueForKey("rating_count", $inRatingCount);
	}


	public function getDeleterId() {
		return $this->_getValueForKey("deleter_id");
	}

	public function setDeleterId($inDeleterId) {
		$this->_setValueForKey("deleter_id", $inDeleterId);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(DeletedTwick::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return DeletedTwick::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return DeletedTwick::_fetch(AbstractDatabaseObject::_buildSQL(DeletedTwick::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return DeletedTwick::_fetch("SELECT * FROM " . DeletedTwick::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_deleted_twicks";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY id DESC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, DeletedTwick::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$deletedtwick = new DeletedTwick();
		$deletedtwick->_setDatabaseValues($inResult);
		return $deletedtwick;
	}


}
?>