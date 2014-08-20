<?php
/*
 * Created at 12.04.2011
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT . "/entity/stubs/MessageStub.class.php";

class Message extends MessageStub {

    // ---------------------------------------------------------------------
    // ----- Konstanten ----------------------------------------------------
    // ---------------------------------------------------------------------
    const TYPE_USER_MESSAGE = "USER_MESSAGE";
    const TYPE_NEWSLETTER = "NEWSLETTER";
    const TYPE_BADGE = "BADGE";
    const TYPE_NOTIFICATION = "NOTIFICATION";
    const TYPE_TWICKIT = "TWICKIT";
    const TYPE_WALL = "WALL";


    // ---------------------------------------------------------------------
    // ----- Getter/Setter -------------------------------------------------
    // ---------------------------------------------------------------------
    public function getSubject() {
        $subject = parent::getSubject();
		if(trim($subject) == "") {
            $subject = _loc('message.noSubject');
        }
        return $subject;
    }


    public function getMessage() {
        if($this->getType() == "USER_MESSAGE") {
            return htmlspecialchars(parent::getMessage());
        } else {
            return parent::getMessage();
        }
    }


    public function getImage() {
        return "html/img/message_" . strtolower($this->getType()) . ".jpg";
    }


    public function getSender() {
		$sender = clone User::fetchById($this->getSenderId());
		if($sender) {
			if($this->getType() == Message::TYPE_BADGE) {
				$sender->setAvatar(HTTP_ROOT . "/html/img/badges/80/" . $this->getMeta() . ".png");
			} else if($this->getType() == Message::TYPE_WALL) {
				$author = User::fetchById($this->getMeta());
				#$sender->setAvatar($author->getAvatarUrl(64));
				$sender = $author;
			}
		}
		
		return $sender;
    }


    public function getReceiver() {
        return User::fetchById($this->getReceiverId());
    }
    

	public function maySee() {
		$userId = getUserId();
		return $userId && ($this->getReceiverId() == $userId  || $this->getSenderId() == $userId);
	}
	
	
    // ---------------------------------------------------------------------
    // ----- Oeffentliche Methoden -----------------------------------------
    // ---------------------------------------------------------------------
    public function findParent() {
        if($this->getParentId()) {
            return self::fetchById($this->getParentId());
        } else {
            return null;
        }
    }


    public function findChild() {
        return array_pop(self::fetch(array("parent_id"=>$this->getId())));
    }

	
	public function findNextMessageId($inInbound) {
		$field = $inInbound ? "receiver_id" : "sender_id";
		$sql = "SELECT id FROM " . self::_getDatabaseName() . " WHERE $field=" . getUserId() . " AND send_date>'" . $this->getSendDate() . "' ORDER BY send_date ASC LIMIT 1";
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			return $result["id"];
		} else {
			return null;
		}
	}
	
	
	public function findPreviousMessageId($inInbound) {
		$field = $inInbound ? "receiver_id" : "sender_id";
		$sql = "SELECT id FROM " . self::_getDatabaseName() . " WHERE $field=" . getUserId() . " AND send_date<'" . $this->getSendDate() . "' ORDER BY send_date DESC LIMIT 1";
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			return $result["id"];
		} else {
			return null;
		}
	}
	

    public static function send($inType, $inSenderId, $inReceiverId, $inSubject, $inMessage, $inMeta=null) {
        $message = new Message();
        $message->setSenderId($inSenderId);
        $message->setReceiverId($inReceiverId);
        $message->setSendDate(getCurrentDate());
        $message->setType($inType);
        $message->setSubject($inSubject);
        $message->setMessage($inMessage);
        $message->setMeta($inMeta);
        $message->save();
        return $message;
    }

	
	public function mail() {
		$receiver = $this->getReceiver();
		if($receiver && $receiver->getEnableMessages() && !$receiver->getThirdpartyId()) {
			$mailer = new TwickitMailer();
			$mailer->Subject = $this->getSubject();
			$mailer->setPlainMessage(self::convertHtmlToPlain($this->getMessage()));
			$mailer->setHtmlMessage(nl2br($this->getMessage()));
			$mailer->AddAddress($receiver->getMail());
			return $mailer->Send();
		} else {
			return true;
		}
	}
	
    
	public static function convertHtmlToPlain($inHtml) {
		$plain = str_replace("<br />", "\n", $inHtml);
		$plain = htmlspecialchars_decode($plain);
		$plain = strip_tags($plain);
		return $plain;
	}
	
	
    public static function fetchReceived($inUserId, $inOptions=array(), $inJustNew=false) {
        $bindings =
                array(
                "receiver_id"=>$inUserId,
                "deleted_receiver"=>0
        );

        if($inJustNew) {
            $bindings["read_date"] = "@@null@@";
        }

        return self::fetch($bindings, $inOptions);
    }

	
    public static function fetchSent($inUserId, $inOptions=array("ORDER BY"=>"send_date DESC")) {
        $sql = "sender_id=" . sec_mysql_input($inUserId) . " AND deleted_sender=0 AND receiver_id<>" . sec_mysql_input($inUserId);
        AbstractDatabaseObject::_addOptions($sql, $inOptions);
        return self::fetchBySql($sql, $inOptions);
    }
	

    public function read() {
        $this->setReadDate(getCurrentDate());
        $this->save();
    }
}
?>