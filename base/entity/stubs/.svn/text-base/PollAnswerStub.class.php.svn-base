<?php
/*
 * Created at 12.12.2011
 *
 * @author Markus Moeller - Twick.it
 */

class PollAnswerStub extends AbstractDatabaseObject {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getId() {
		return $this->_getValueForKey("id");
	}

	public function setId($inId) {
		$this->_setValueForKey("id", $inId);
	}


	public function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	public function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


	public function getUserId() {
		return $this->_getValueForKey("user_id");
	}

	public function setUserId($inUserId) {
		$this->_setValueForKey("user_id", $inUserId);
	}


	public function getIp() {
		return $this->_getValueForKey("ip");
	}

	public function setIp($inIp) {
		$this->_setValueForKey("ip", $inIp);
	}


	public function getGewinnspiel() {
		return $this->_getValueForKey("gewinnspiel");
	}

	public function setGewinnspiel($inGewinnspiel) {
		$this->_setValueForKey("gewinnspiel", $inGewinnspiel);
	}


	public function getCent() {
		return $this->_getValueForKey("cent");
	}

	public function setCent($inCent) {
		$this->_setValueForKey("cent", $inCent);
	}


	public function getWeltreise() {
		return $this->_getValueForKey("weltreise");
	}

	public function setWeltreise($inWeltreise) {
		$this->_setValueForKey("weltreise", $inWeltreise);
	}


	public function getSeo() {
		return $this->_getValueForKey("seo");
	}

	public function setSeo($inSeo) {
		$this->_setValueForKey("seo", $inSeo);
	}


	public function getTagesschau() {
		return $this->_getValueForKey("tagesschau");
	}

	public function setTagesschau($inTagesschau) {
		$this->_setValueForKey("tagesschau", $inTagesschau);
	}


	public function getGadgets() {
		return $this->_getValueForKey("gadgets");
	}

	public function setGadgets($inGadgets) {
		$this->_setValueForKey("gadgets", $inGadgets);
	}


	public function getAdminrechte() {
		return $this->_getValueForKey("adminrechte");
	}

	public function setAdminrechte($inAdminrechte) {
		$this->_setValueForKey("adminrechte", $inAdminrechte);
	}


	public function getVorschlag() {
		return $this->_getValueForKey("vorschlag");
	}

	public function setVorschlag($inVorschlag) {
		$this->_setValueForKey("vorschlag", $inVorschlag);
	}


	public function getStars() {
		return $this->_getValueForKey("stars");
	}

	public function setStars($inStars) {
		$this->_setValueForKey("stars", $inStars);
	}


	public function getKinder() {
		return $this->_getValueForKey("kinder");
	}

	public function setKinder($inKinder) {
		$this->_setValueForKey("kinder", $inKinder);
	}


	public function getMailing() {
		return $this->_getValueForKey("mailing");
	}

	public function setMailing($inMailing) {
		$this->_setValueForKey("mailing", $inMailing);
	}


	public function getText() {
		return $this->_getValueForKey("text");
	}

	public function setText($inText) {
		$this->_setValueForKey("text", $inText);
	}


    public function getMail() {
		return $this->_getValueForKey("mail");
	}

	public function setMail($inMail) {
		$this->_setValueForKey("mail", $inMail);
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public public function fetchById($inId) {
		return array_pop(PollAnswer::fetch(array("id"=>$inId)));
	}


	public public function fetchAll($inOptions=array()) {
		return PollAnswer::fetch(array(), $inOptions);
	}


	public public function fetch($inBindings, $inOptions=array()) {
		return PollAnswer::_fetch(AbstractDatabaseObject::_buildSQL(PollAnswer::_getDatabaseName(), $inBindings, $inOptions));
	}


	public public function fetchBySQL($inSQL) {
		return PollAnswer::_fetch("SELECT * FROM " . PollAnswer::_getDatabaseName() . " WHERE $inSQL");
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_poll_answers";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY creation_date ASC";
		}

		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, PollAnswer::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		return $objects;
	}


	private function _createFromDB($inResult) {
		$pollanswer = new PollAnswer();
		$pollanswer->_setDatabaseValues($inResult);
		return $pollanswer;
	}


}
?>

