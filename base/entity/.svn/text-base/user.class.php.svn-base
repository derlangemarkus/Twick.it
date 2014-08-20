<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/UserStub.class.php";

class User extends UserStub {

	// ---------------------------------------------------------------------
	// ----- Konstanten ----------------------------------------------------
	// ---------------------------------------------------------------------
	const TWICKIT_USER_ID = 1241;
	const ANONYMOUS_USER_ID = 1327;
	
	
    // ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
    private $avatar;


	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function isTwickit() {
		return $this->getId() == self::TWICKIT_USER_ID;
	}
		
	public function isAnonymous() {
		return $this->getId() == self::ANONYMOUS_USER_ID;
	}	
		
	
	public function hasAlert($inAlert) {
		return $this->getAlerts() & $inAlert;
	}
	
	
    public function setAvatar($inAvatar) {
        $this->avatar = $inAvatar;
    }
    
	
	public function getLogin($inShowTwickit=false) {
		if($inShowTwickit && $this->isTwickit()) {
			return "Twick.it";
		} else {
			return parent::getLogin();
		}
	}

	
	public function getDisplayName() {
		if($this->isTwickit()) {
			return "Twick.it";
		}
		
		if ($this->getDeleted()) {
			return _loc('misc.deletedUser');	
		} else {
			if ($this->getName()) {
				return $this->getLogin() . " (" . $this->getName() . ")";
			} else {
				return $this->getLogin();
			}
		}
	}


	public function getAvatarUrl($inSize=32) {
        if($this->avatar) {
            return $this->avatar;
        }

		if ($this->getDeleted()) {
			return $this->getDefaultAvatarUrl($inSize);	
		} else {
			if ($this->getThirdpartyId() && startsWith($this->getThirdpartyId(), "Facebook:")) {
				$defaultUrl = "https://graph.facebook.com/" . substringAfter($this->getThirdpartyId(), "Facebook:") . "/picture?type=large";
			} else {
				$defaultUrl = $this->getTwitterAvatarUrl($inSize);
			}
			
			if (!$defaultUrl) {
				$defaultUrl = $this->getDefaultAvatarUrl($inSize);
			}
			
			$url = "http://www.gravatar.com/avatar/";
			$url .= md5(strtolower($this->getMail()));
			$url .= '?s=' . $inSize;
			$url .= '&d=' . urlencode($defaultUrl);
			
			return $url;
		}
	}


	public function getTwitterAvatarUrl($inSize=32) {
		return TwitterReader::getTwitterAvatarUrl($this->getTwitter(), $inSize);
	}
	
	
	public function getDefaultAvatarUrl($inSize=32) {
        $available = array(20, 32, 38, 50, 64, 80, 100, 150, 200, 208, 300, 400, 500, 560);

        if (in_array($inSize, $available)) {
            return STATIC_ROOT . "/html/img/avatar/$inSize.jpg";
        } else {
            $url = STATIC_ROOT . "/html/img/avatar/560.jpg";
            $url = HTTP_ROOT . "/util/thirdparty/phpThumb/phpThumb.php?w=$inSize&h=$inSize&far=1&src=" . urlencode($url);
            return $url;
        }
	}
	
	
	public function getAvatar($inSize=32, $inStyle="") {
		$displayName = $this->getDisplayName();
		$url = $this->getAvatarUrl($inSize);
		return "<img src='$url' alt='$displayName' title='$displayName' width='$inSize' height='$inSize' style='$inStyle' />";
	}
	
	
	public function getSecret() {
		$salts = array("efuueVrJf", "lmfr5gkACtg", "qdDfhe5zgfd", "fdejfwse2h", "huHua23wed", "defuif2i43", "jiji883jhjhf", "KJdh38eruhnJ", "hfhruhHHdii12");
		return strrev(crypt("mm" . $this->getMail(), $salts[$this->getId() % sizeof($salts)] . $this->getId()));
	}
	
	
	/*
	 * Liefert das Secret, das nur in Mails und nicht in den Links der Weboberflaeche verwendet wird.
	 */
	public function getSecretSecret() {
		$salts = array("hzhY6DzP6zh6zh", "gtPMNBg5u7kolo", "asQKdwd3r4nTnn", "656DDFThzhzTj8", "grtgFFEedfrfYg", "gttgX323fvrgvXtrg", "43S54D56gtgtgt", "DDgtDtg54656gtgt", "gtghz6uiku4");
		return strrev(crypt("sk" . $this->getMail(), $salts[$this->getId() % sizeof($salts)] . $this->getId()));
	}

	
	public function getLoginToken() {
		return $this->getSecret();
	}

	
	public function getUrl($inHost=false) {
        if ($inHost) {
            return $inHost . "/user/" . convertForUrl($this->getLogin(true));
        } else {
            return HTTP_ROOT . "/user/" . convertForUrl($this->getLogin(true));
        }
	}
	
	
	public function getLinkOrUrl() {
		if ($this->getLink()) {
			return $this->getLink();
		} else {
			return $this->getUrl();
		}	
	}
	
	
	public function getName() {
		if ($this->isAnonymous()) {
			return _loc('misc.anonymousUser');	
		} else {
			return parent::getName();
		}
	}
	

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
    public function save() {
        if(!contains($this->getMail(), ":")) {
            if($this->getTwitter()) {
                $twitterId = TwitterReader::getTwitterId($this->getTwitter());
                if($twitterId) {
                    $this->setThirdpartyId("Twitter:" . $twitterId);
                }
            } else {
                $this->setThirdpartyId(null);
            }
        }
        parent::save();
    }


	public function getDummy() {
		$user = new User();
		return $user;
	}
	
	
	public function getAnonymous() {
		return self::fetchById(self::ANONYMOUS_USER_ID);
	}
	
	
	public function updateCache() {
		$info = UserInfo::fetchById($this->getId());
        if($info) {
            $this->setRatingSumCached($info->getRatingSum(), $info->getLanguageCode());
            $this->setRatingCountCached($info->getRatingCount(), $info->getLanguageCode());
            $this->save();
        }
	}
	
	
	public function isBlocked() {
		return BlockedMail::isBlocked($this->getMail());	
	}

	
	public function sendUserMessageMail($inSender, $inSubject, $inMessage, $inParentId=null) {
		$message = Message::send(
			Message::TYPE_USER_MESSAGE,
			$inSender->getId(),
			$this->getId(), 
			$inSubject, 
			$inMessage
		);
		$message->setParentId($inParentId);
		$message->save();

		if(!$this->getEnableMessages() || $this->getThirdpartyId()) {
			return true;
		}
		
        $replyUrl = HTTP_ROOT . "/show_message.php?id=" . $message->getId();
	
		$separator = str_repeat("-", 70);
        $mailText = _loc('email.message.hello', $this->getLogin()) . "\n\n";
		$mailText .= _loc('email.message.text', $inSender->getDisplayName()) . "\n\n\n$separator\n\n";
		$mailText .= strip_tags($inSubject) . "\n\n";
		$mailText .= strip_tags($inMessage) . "\n\n";
		$mailText .= _loc('email.message.showMessage', $replyUrl);
		$mailText .= "\n\n";
		$mailText .= _loc('email.message.userPage', array($inSender->getDisplayName(), $inSender->getUrl()));
		$mailText .= "\n\n$separator\n\n\n";
		$mailText .= _loc('email.message.bye') ."\n";


        $htmlText = '
            <img src="' . $inSender->getAvatarUrl(32) . '" style="float:right;border:1px solid #638301" alt=""/>
            ' . _loc('email.message.hello', $this->getLogin()) . '<br />
            ' . _loc('email.message.text', $inSender->getDisplayName()) . '<br />
            <br />
            <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;" width="100%">
                <tr>
                    <td style="padding:10px;background-color:#DDD;border:1px solid #666666;font-family: Trebuchet MS, Arial, Tahoma, Verdana, Helvetica;font-size: 16px">
                        ' . ($inSubject ? '<b>' . htmlspecialchars($inSubject). '</b><br />' : '') .'
                        ' . nl2br(htmlspecialchars($inMessage)) . '
                    </td>
                </tr>
            </table>
            <br />
            ' . _loc('email.message.showMessage', "<a href='$replyUrl' style='color:#638301;'>$replyUrl</a>") . '<br />
            ' . _loc('email.message.userPage', array($inSender->getDisplayName(), "<a href='" . $inSender->getUrl() . "' style='color:#638301;'>" . $inSender->getUrl() . "</a>")) . '
            <br />
            <br />
            ' . _loc('email.message.bye');

		$mailer = new TwickitMailer();
		$mailer->From = "message_" . getLanguage() . "@twick.it";
        $mailer->AddAddress($this->getMail());
		$mailer->Subject = _loc('email.message.subject', $inSender->getDisplayName());
        $mailer->setPlainMessage($mailText);
		$mailer->setTitle(_loc('email.message.subject', $inSender->getDisplayName()));
        $mailer->setHtmlMessage($htmlText);
		return $mailer->Send();
	}
	
	
	public function sendRegistrationMail() {
		srand((double)microtime() * 1000008);
		$rand = rand(65, 99);
		if ($rand > 90) {
			$char = $rand-90;
		} else {
			$char = chr($rand);
		}

        $mailText = _loc('email.message.hello', $this->getLogin()) . "\n\n";
		$mailText .= _loc('email.registration.welcome') . "\n\n";
		$mailText .= _loc('email.registration.text') . "\n";
		$mailText .= HTTP_ROOT . "/register_approve.php?id=" . $this->getId() . "&secret=$char" . urlencode($this->getSecretSecret()) . "&lng=" . getLanguage();
		$mailText .= "\n\n";
		$mailText .= _loc('email.registration.bye') . "\n";
		
		$mailer = new TwickitMailer();
		$mailer->Subject = _loc('email.registration.subject');
		$mailer->setPlainMessage($mailText);
		$mailer->AddAddress($this->getMail());
		return $mailer->Send();
	}
	
	
	public function sendPasswortResetMail() {
		srand((double)microtime() * 1000008);
		$rand = rand(65, 99);
		if ($rand > 90) {
			$char = $rand-90;
		} else {
			$char = chr($rand);
		}

        $mailText = _loc('email.message.hello', $this->getLogin()) . "\n\n";
		$mailText .= _loc('email.resetPassword.text') . "\n";
		$mailText .= HTTP_ROOT . "/request_new_password.php?id=" . $this->getId() . "&secret=$char" . urlencode($this->getSecretSecret()) . "&lng=" . getLanguage();
		$mailText .= "\n\n";
		$mailText .= _loc('email.resetPassword.bye') . "\n";
		
		$mailer = new TwickitMailer();
		$mailer->Subject = _loc('email.resetPassword.subject');
		$mailer->setPlainMessage($mailText);
		$mailer->AddAddress($this->getMail());
		return $mailer->Send();
	}
	
	
	public function sendNewPasswordMail() {
		$newPassword = "";
		srand((double)microtime() * 1000008);
		for($i=0; $i<12; $i++) {
			$rand = rand(65, 99);
			if ($rand > 90) {
				$char = $rand-90;
			} else {
				$char = chr($rand);
			}
	        $newPassword .= strtolower($char);
		}
		
		$this->setPassword(md5($newPassword));
		$this->save(); 

        $mailText = _loc('email.message.hello', $this->getLogin()) . "\n\n";
		$mailText .= _loc('email.newPassword.text') . "\n";
		$mailText .= $newPassword;
		$mailText .= "\n\n";
		$mailText .= _loc('email.newPassword.bye') . "\n";
		
		$mailer = new TwickitMailer();
		$mailer->Subject = _loc('email.newPassword.subject');
		$mailer->setPlainMessage($mailText);
		$mailer->AddAddress($this->getMail());
		return $mailer->Send();
	}
	

	public function findNumberOfTwicks($inAllLanguages=false) {
		$sql = "SELECT count(*) AS c FROM " .  Twick::_getDatabaseName() . " t, " .  Topic::_getDatabaseName() . " o WHERE t.topic_id=o.id and t.user_id=" . $this->getId();
		if (!$inAllLanguages) {
			$sql .= " AND o.language_code='" . getLanguage() . "'";
		}
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$count = $result["c"];
		} else {
			$count = 0;
		}

		return $count;
	}
	
	
	public function findNumberOfRatings() {
		$sql = "SELECT count(*) AS c FROM " . TwickRating::_getDatabaseName() . " WHERE user_id=" . $this->getId();
				
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$count = $result["c"];
		} else {
			$count = 0;
		}

		return $count;
	}
	
	
	public function fetchByLocation($inLocation, $inLimit=100) {
		return User::fetch(array("location"=>$inLocation), array("ORDER BY"=>"id DESC", "LIMIT"=>$inLimit));
	}
	
	
	public function fetchByMail($inMail) {
		return array_pop(User::fetch(array("mail"=>$inMail)));
	}


    public function fetchByThirdpartyId($inThirdpartyId) {
		return array_pop(User::fetch(array("thirdparty_id"=>$inThirdpartyId)));
	}


	public function fetchByLogin($inLogin) {
		return array_pop(User::fetch(array("login"=>$inLogin)));
	}
	

	public function fetchByLoginAndPassword($inLogin, $inPassword) {
		return array_pop(User::fetch(array("mail"=>$inLogin, "password"=>$inPassword)));
	}


    public function fetchRandom($inLimit=1, $inAllLanguages=false) {
		return User::fetch(array(), $inAllLanguages, array("ORDER BY"=>"rand()", "LIMIT"=>$inLimit));
	}


	public function search($inSearch, $inExact=false, $inLimit=0) {
		if ($inExact) {
			$user = User::fetchByLogin($inSearch);
			if ($user && !$user->isAnonymous()) {
				return array(User::fetchByLogin($inSearch));
			} else {
				return array();
			}
		} else {
			$sql = "login LIKE '%$inSearch%' AND deleted<>1 AND id<>".User::ANONYMOUS_USER_ID;
			if ($inLimit > 0) {
				$sql .= " ORDER BY login LIMIT $inLimit";
			}
			
			$usersByLogin = User::fetchBySQL($sql);
			if ($inLimit <= 0 || sizeof($usersByLogin) < $inLimit) {
				$usersByName = User::fetchBySQL("name LIKE '%$inSearch%' AND login NOT LIKE '%$inSearch%' AND deleted<>1 AND id<>".User::ANONYMOUS_USER_ID);
				$usersByLogin = array_merge($usersByLogin, $usersByName);
				if ($inLimit >= 0) {
					$usersByLogin = array_slice($usersByLogin, 0, $inLimit);
				}
			}
			return $usersByLogin;
		}	
	}
	
	
	public function delete() {
		$this->setDeleted(true);
		$this->setLogin("-" . $this->getLogin(true));
		$this->setMail("-" . $this->getMail());
		$this->save();
	}

	
	public function findTwicks($inAllLanguages=false, $inOptions=array()) {
		return Twick::fetchByUserId($this->getId(), $inAllLanguages, $inOptions);
	}

	
	public function findTopicSuggestions($inLimit=6) {
		global $SPECIALCHARS;
		$specialChars = "'" . implode("', '", $SPECIALCHARS) ."'";
		
		$sql = "SELECT tag, count(tag) AS c FROM " . Topic::_getDatabaseName() . " t, " . Twick::_getDatabaseName() . " x, " . Tag::_getDatabaseName() . " g WHERE t.language_code='" .getLanguage() . "' AND t.id=x.topic_id AND g.entity='topic' AND g.foreign_id=t.id AND x.user_id=" . $this->getId() . " AND tag NOT IN (SELECT word FROM " . NoWord::_getDatabaseName() . " WHERE user_id=x.user_id) AND tag NOT IN ($specialChars) AND tag NOT IN (SELECT title FROM " . Topic::_getDatabaseName() . " WHERE language_code='" . getLanguage() . "') GROUP BY tag ORDER BY count(tag) DESC LIMIT $inLimit";
		
		$objects = array();
		$db =& DB::getInstance();
		$db->query($sql);
		while ($result = $db->getNextResult()) {
			$objects[$result["tag"]] = $result["c"];
		}

		return $objects;
	}
	
	
	public function findRelatedUsersByTags($inMinimumMatches=2, $inAllLanguages=false) {
		$sql = "SELECT t3.* FROM " . Tag::_getDatabaseName() . " t1, " . Tag::_getDatabaseName() . " t2, " . User::_getDatabaseName() . " t3 WHERE t3.id<>" . $this->getId() . " AND t3.id=t1.foreign_id AND t2.foreign_id=" . $this->getId() . " AND t1.entity='" . $this->_getTagType() . "' AND t2.entity=t1.entity AND t1.tag=t2.tag GROUP BY t1.foreign_id HAVING count(*) >= $inMinimumMatches ORDER BY count(*) DESC LIMIT 5";
		return User::_fetch($sql, $inAllLanguages);
	}
	
	
	public function findRelatedUsersByLocation($inLimit=10) {
		$sql = "SELECT * FROM " . User::_getDatabaseName() . " WHERE id<>" . $this->getId() . " AND location='" . $this->getLocation() . "' ORDER BY rand() LIMIT $inLimit"; 
		return User::_fetch($sql, $inAllLanguages);
	}
	
	
	public function findRatingPosition() {
		$language = getLanguage();
		$sql = "SELECT count(*)+1 AS position FROM " . User::_getDatabaseName() . " WHERE rating_sum_$language > (SELECT rating_sum_$language FROM " . User::_getDatabaseName() . " WHERE id=" . $this->getId() . ")";
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$position = $result["position"];
		} else {
			$position = -1;
		}

		return $position;
	}
}
?>