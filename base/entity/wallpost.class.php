<?php
/*
 * Created at 17.05.2011
 *
 * @author Markus Moeller - Twick.it
 */

require DOCUMENT_ROOT ."/entity/stubs/WallPostStub.class.php";

class WallPost extends WallPostStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function getUrl() {
		$author = $this->findUser();
		$url = $author->getUrl();
		$url .= "/wall";
		$url .= "#" . $this->getId();
		return $url;
	}
	
	
	public function isDeletable() {
        $userId = getUserId();
		return $this->getUserId() === $userId || $this->getAuthorId() === $userId;
	}


    public function isDeleted() {
		return $this->getDeletedSender() || $this->getDeletedReceiver();
	}
	
	
	public function findAuthor() {
		return User::fetchById($this->getAuthorId());
	}

	
	public function findUser() {
		return User::fetchById($this->getUserId());
	}
	
	
	public function findChildren() {
		return self::fetchByParentId($this->getId());
	}
	
	
	public function findParent() {
		return self::fetchById($this->getParentId());
	}
	
	
	public static function fetchByUserId($inUserId) {
		return self::fetch(array("user_id"=>$inUserId));
	}

	
	public static function fetchByParentId($inParentId) {
		return self::fetch(array("parent_id"=>$inParentId), array("ORDER BY"=>"id ASC"));
	}

	
    public function save($inSkipUpdate=false) {
        if(!$inSkipUpdate) {
            $now = getCurrentDate();
            $this->setUpdateDate($now);

            if($this->getParentId()) {
                $parent = $this->findParent();
                $parent->setUpdateDate($now);
                $parent->save();
            }
        }
        parent::save();
    }


    public function delete() {
        $userId = getUserId();
        if($userId == $this->getUserId()) {
            $this->setDeletedReceiver(true);
        }
        if($userId == $this->getAuthorId()) {
            $this->setDeletedSender(true);
        }
        $this->save(true);

        foreach($this->findChildren() as $child) {
            $child->delete();
        }
    }
}
?>