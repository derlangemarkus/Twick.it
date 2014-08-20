<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */

class UserStub extends AbstractTaggedDatabaseObject {

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

	
	function getRegisterMail() {
		return $this->_getValueForKey("register_mail");
	}

	function setRegisterMail($inRegisterMail) {
		$this->_setValueForKey("register_mail", $inRegisterMail);
	}
	

	function getLogin($showDeleted=false) {
		if (!$showDeleted && $this->getDeleted()) {
			return _loc('misc.deletedUser');	
		} if ($this->isAnonymous()) {
			return _loc('misc.anonymousUser');	
		} else {
			return $this->_getValueForKey("login");
		}
	}

	function setLogin($inLogin) {
		$this->_setValueForKey("login", $inLogin);
	}


	function getPassword() {
		return $this->_getValueForKey("password");
	}

	function setPassword($inPassword) {
		$this->_setValueForKey("password", $inPassword);
	}


	function getName() {
		return $this->_getValueForKey("name");
	}

	function setName($inName) {
		$this->_setValueForKey("name", $inName);
	}


	function getBio() {
		return $this->_getValueForKey("bio");
	}

	function setBio($inBio) {
		$this->_setValueForKey("bio", $inBio);
	}


	function getCountry() {
		return $this->_getValueForKey("country");
	}

	function setCountry($inCountry) {
		$this->_setValueForKey("country", $inCountry);
	}


	function getLocation() {
		return $this->_getValueForKey("location");
	}

	function setLocation($inLocation) {
		$this->_setValueForKey("location", $inLocation);
	}


	function getLink() {
		return $this->_getValueForKey("link");
	}

	function setLink($inLink) {
		if ($inLink && !contains($inLink, "://")) {
			$inLink = "http://" . $inLink;
		}
		$this->_setValueForKey("link", $inLink);
	}
	
	
	function getTwitter() {
		if ($this->getDeleted()) {
			return "";
		} else {
			return $this->_getValueForKey("twitter");
		}
	}

	function setTwitter($inTwitter) {
		$this->_setValueForKey("twitter", substringAfterLast(substringAfterLast($inTwitter, "/"), "@"));
	}


	function getNewsletter() {
		return $this->_getValueForKey("newsletter");
	}

	function setNewsletter($inNewsletter) {
		$this->_setBooleanValueForKey("newsletter", $inNewsletter);
	}
	
	
	function getEnableMessages() {
		return $this->_getValueForKey("enable_messages");
	}

	function setEnableMessages($inEnableMessages) {
		$this->_setBooleanValueForKey("enable_messages", $inEnableMessages);
	}


	function getCreationDate() {
		return $this->_getValueForKey("creation_date");
	}

	function setCreationDate($inCreationDate) {
		$this->_setValueForKey("creation_date", $inCreationDate);
	}


	function getApproved() {
		return $this->_getValueForKey("approved");
	}

	function setApproved($inApproved) {
		$this->_setBooleanValueForKey("approved", $inApproved);
	}
	
	
	function getAdmin() {
		return $this->_getValueForKey("admin");
	}

	function setAdmin($inAdmin) {
		$this->_setBooleanValueForKey("admin", $inAdmin);
	}


    function getThirdpartyId() {
		return $this->_getValueForKey("thirdparty_id");
	}

	function setThirdpartyId($inThirdpartyId) {
		$this->_setValueForKey("thirdparty_id", $inThirdpartyId);
	}

	
	function getRegisterLanguageCode() {
		return $this->_getValueForKey("register_language_code");
	}

	function setRegisterLanguageCode($inRegisterLanguageCode) {
		$this->_setValueForKey("register_language_code", $inRegisterLanguageCode);
	}
	

	function getDeleted() {
		return $this->_getValueForKey("deleted");
	}

	function setDeleted($inDeleted) {
		$this->_setBooleanValueForKey("deleted", $inDeleted);
	}
	
	
	function getRatingSumCached($inLanguageCode=false) {
		if ($inLanguageCode === false) {
			$inLanguageCode = getLanguage();
		}
		return $this->_getValueForKey("rating_sum_" . $inLanguageCode);
	}

	function setRatingSumCached($inRatingSum, $inLanguageCode=false) {
		if ($inLanguageCode === false) {
			$inLanguageCode = getLanguage();
		}
		$this->_setValueForKey("rating_sum_" . $inLanguageCode, $inRatingSum);
	}
	
	
	function getRatingCountCached($inLanguageCode=false) {
		if ($inLanguageCode === false) {
			$inLanguageCode = getLanguage();
		}
		return $this->_getValueForKey("rating_count_" . $inLanguageCode);
	}

	function setRatingCountCached($inRatingCount, $inLanguageCode=false) {
		if ($inLanguageCode === false) {
			$inLanguageCode = getLanguage();
		}
		$this->_setValueForKey("rating_count_" . $inLanguageCode, $inRatingCount);
	}
	
	
	function getReminder() {
		return $this->_getValueForKey("reminder");
	}

	function setReminder($inReminder) {
		$this->_setValueForKey("reminder", $inReminder);
	}


    function getSystemReminder() {
		return $this->_getValueForKey("system_reminder");
	}

	function setSystemReminder($inSystemReminder) {
		$this->_setValueForKey("system_reminder", $inSystemReminder);
	}


	function getAlerts() {
		return $this->_getValueForKey("alerts");
	}

	function setAlerts($inAlerts) {
		$this->_setValueForKey("alerts", $inAlerts);
	}
	
	
	function getEnableWall() {
		return $this->_getValueForKey("enable_wall");
	}

	function setEnableWall($inEnableWall) {
		$this->_setBooleanValueForKey("enable_wall", $inEnableWall);
	}

	
	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchById($inId) {
		static $__TWICKIT_USER_CACHE;
		if (isset($__TWICKIT_USER_CACHE[$inId])) {
			return $__TWICKIT_USER_CACHE[$inId];
		} else {
			$user = array_pop(User::fetch(array("id"=>$inId)));
			$__TWICKIT_USER_CACHE[$inId] = $user ? $user : false;
			return $user;
		}
	}
	
	
	public function fetchAll($inWithInactive=false, $inAllLanguages=false, $inOptions=array(), $inWithAnonymous=false) {
		$bindings = array();
		$bindings["deleted"] = 0;
		if (!$inWithInactive) {
			$bindings["approved"] = 1;
		}
		return User::fetch($bindings, $inAllLanguages, $inOptions, $inWithAnonymous);
	}
	
	
	public function fetch($inBindings, $inAllLanguages=false, $inOptions=array(), $inWithAnonymous=true) {
		if (!$inAllLanguages) {
			$order = "rating_sum_" . getLanguage();
		} else {
			$order = "rating_sum_de+rating_sum_en";
		}
		AbstractDatabaseObject::_setDefaultOptions($inOptions, array("ORDER BY"=>"$order DESC, id DESC"));
		$sql = AbstractDatabaseObject::_buildSQL(User::_getDatabaseName(), $inBindings, $inOptions);
		if(!$inWithAnonymous) {
			$sql = str_replace(" WHERE ",  " WHERE id<>" . User::ANONYMOUS_USER_ID . " AND ", $sql);
		}
		return User::_fetch($sql, $inAllLanguages);
	}
	

	public function fetchBySQL($inSQL) {
		return User::_fetch("SELECT * FROM " . User::_getDatabaseName() . " WHERE $inSQL");
	}

	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _getDatabaseName() {
		return "tbl_users";
	}


	protected function _fetch($inSQL) {
		$objects = array();

		if (!preg_match("/\s*ORDER\sBY\s*/", $inSQL)) {
			$inSQL .= " ORDER BY creation_date ASC";
		}
		
		if ($cached = AbstractDatabaseObject::_getCachedResult($inSQL)) {
			return $cached;
		}
		
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			array_push($objects, User::_createFromDB($result));
		}

		AbstractDatabaseObject::_setCachedResult($inSQL, $objects);
		
		return $objects;
	}


	private function _createFromDB($inResult) {
		$user = new User();
		$user->_setDatabaseValues($inResult);
		return $user;
	}
}
?>