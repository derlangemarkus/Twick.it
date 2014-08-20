<?php
/*
 * Created at 11.05.2011
 *
 * @author Markus Moeller - Twick.it
 */

require DOCUMENT_ROOT ."/entity/stubs/UserAlertStub.class.php";

class UserAlert extends UserAlertStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
    public static function create($inUserId, $inAuthorId) {
        $alert = self::fetchByUserAndAuthorId($inUserId, $inAuthorId);
        if(!$alert) {
            $alert = new UserAlert();
            $alert->setUserId($inUserId);
            $alert->setAuthorId($inAuthorId);
            $alert->save();
        }
    }


    public static function fetchByUserId($inUserId) {
        return self::fetch(array("user_id"=>$inUserId));
    }


    public static function fetchByAuthorId($inAuthorId) {
        return self::fetch(array("author_id"=>$inAuthorId));
    }


    public static function fetchByUserAndAuthorId($inUserId, $inAuthorId) {
        return self::fetch(array("user_id"=>$inUserId, "author_id"=>$inAuthorId));
    }


    public static function findAuthorsByUserId($inUserId) {
        $userAlerts = UserAlert::fetchByUserId($inUserId);
        $authors = array();
        foreach($userAlerts as $alert) {
            $authors[] = $alert->getAuthorId();
        }
        if($authors) {
            return User::fetchBySQL("id IN (" .implode("," , $authors) . ") ORDER BY login ASC");
        } else {
            return array();
        }
    }
	
	
	public function findUser() {
		return User::fetchById($this->getUserId());
	}
	
	
	public function findAuthor() {
		return User::fetchById($this->getAuthorId());
	}
}
?>