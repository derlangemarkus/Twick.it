<?php
/*
 * Created at 13.07.2011
 *
 * @author Markus Moeller - Twick.it
 */

class PodcastStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getId() {
		return $this->_getValueForKey("id");
	}

	public function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	public function getTwickId() {
		return $this->_getValueForKey("twick_id");
	}

	public function setTwickId($inTwickId) {
		$this->_setValueForKey("twick_id", $inTwickId);
	}


	public function getSpeaker() {
		return $this->_getValueForKey("speaker");
	}

	public function setSpeaker($inSpeaker) {
		$this->_setValueForKey("speaker", $inSpeaker);
	}


	public function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	public function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


    public function getPublishDate() {
		return $this->_getValueForKey("publish_date");
	}

	public function setPublishDate($inPublishDate) {
		$this->_setValueForKey("publish_date", $inPublishDate);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(Podcast::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return Podcast::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return Podcast::_fetch(AbstractDatabaseObject::_buildSQL(Podcast::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return Podcast::_fetch("SELECT * FROM " . Podcast::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_podcast";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY id ASC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, Podcast::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$podcast = new Podcast();
		$podcast->_setDatabaseValues($inResult);
		return $podcast;
	}


}
?>
