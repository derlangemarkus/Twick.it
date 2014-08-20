<?php
/*
 * Created at 03.04.2011
 *
 * @author Markus Moeller - Twick.it
 */

class TwickOfTheDayStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getId() {
		return $this->_getValueForKey("id");
	}

	public function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	public function getDate() {
		return $this->_getValueForKey("date");
	}

	public function setDate($inDate) {
		$this->_setValueForKey("date", $inDate);
	}


	public function getTwickId() {
		return $this->_getValueForKey("twick_id");
	}

	public function setTwickId($inTwickId) {
		$this->_setValueForKey("twick_id", $inTwickId);
	}


	public function getLanguageCode() {
		return $this->_getValueForKey("language_code");
	}

	public function setLanguageCode($inLanguageCode) {
		$this->_setValueForKey("language_code", $inLanguageCode);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(TwickOfTheDay::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return TwickOfTheDay::fetch(array(), false, $inOptions);
	}


	public public function fetch($inBindings, $inAllLanguages=false, $inOptions=array()) {
		return TwickOfTheDay::_fetch(AbstractDatabaseObject::_buildSQL(TwickOfTheDay::_getDatabaseName(), $inBindings, $inOptions), $inAllLanguages);
	}


	public public function fetchBySQL($inSQL, $inAllLanguages=false) {
		return TwickOfTheDay::_fetch("SELECT * FROM " . TwickOfTheDay::_getDatabaseName() . " WHERE $inSQL", $inAllLanguages);
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_twicks_of_the_day";
	}


	protected function _fetch($inSQL, $inAllLanguages=false) {
		$objects = array();
		if (!$inAllLanguages) {
			if (preg_match("/^(.*)\s*WHERE\s*(.*?)(ORDER BY .*)?$/", $inSQL, $matches)) {
				$select = $matches[1];
				$originalSQL = $matches[2];
				$orderBy = sizeof($matches)==4 ? $matches[3] : "";
				$inSQL = $select . " WHERE (language_code='" . getLanguage() . "') AND (" . $originalSQL . ") $orderBy";
			} else {
				$inSQL .= " WHERE language_code='" . getLanguage() . "'";
			}
		}


		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY date DESC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, TwickOfTheDay::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$twickoftheday = new TwickOfTheDay();
		$twickoftheday->_setDatabaseValues($inResult);
		return $twickoftheday;
	}


}
?>