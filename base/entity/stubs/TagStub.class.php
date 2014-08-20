<?php
/*
 * Created at 25.06.2009
 *
 * @author Markus Moeller - Twick.it
 */

class TagStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	function getId() {
		return $this->_getValueForKey("id");
	}

	function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	function getEntity() {
		return $this->_getValueForKey("entity");
	}

	function setEntity($inEntity) {
		$this->_setValueForKey("entity", $inEntity);
	}


	function getForeignId() {
		return $this->_getValueForKey("foreign_id");
	}

	function setForeignId($inForeignId) {
		$this->_setValueForKey("foreign_id", $inForeignId);
	}


	function getTag() {
		return $this->_getValueForKey("tag");
	}

	function setTag($inTag) {
		$this->_setValueForKey("tag", $inTag);
	}
	
	
	function getStemming() {
		return $this->_getValueForKey("stemming");
	}

	function setStemming($inStemming) {
		$this->_setValueForKey("stemming", $inStemming);
	}


	function getCount() {
		return $this->_getValueForKey("count");
	}

	function setCount($inCount) {
		$this->_setValueForKey("count", $inCount);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchById($inId) {
		return array_pop(Tag::fetch(array("id"=>$inId)));
	}
	
	
	public function fetchAll($inOptions=array()) {
		return Tag::fetch(array(), $inOptions);
	}
	
	
	public function fetch($inBindings, $inOptions=array()) {
		return Tag::_fetch(AbstractDatabaseObject::_buildSQL(Tag::_getDatabaseName(), $inBindings, $inOptions));
	}


	public function fetchBySQL($inSQL) {
		return Tag::_fetch("SELECT * FROM " . Tag::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_tags";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY count DESC";
		}

		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}
		
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, Tag::_createFromDB($result));
		}
		
		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);

		return $objects;
	}


	private function _createFromDB($inResult) {
		$tag = new Tag();
		$tag->_setDatabaseValues($inResult);
		return $tag;
	}
}
?>