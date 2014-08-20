<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/TwickStub.class.php";
require DOCUMENT_ROOT ."/util/notifications/Notificator.class.php";

class Twick extends TwickStub {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getText() {
		return str_replace("\t", " ", parent::getText());
	}
	
	
	public function setText($inText) {
		return parent::setText(str_replace("\t", " ", $inText));
	}
	
	
	public function getLongText() {
		if (trim($this->getAcronym())) {
			$text = _loc('twick.accronym') . ' "' . $this->getAcronym() . '". ';
		} else {
			$text = "";
		}
		$text .= $this->getText();
		return $text;
	}
	
	
	public function isBlocked() {
		return false;
		//return BlockedUser::isUserBlocked($this->getUserId());
	}
	

    public function getFixUrl() {
        return $this->getUrl(false, "", "http://twick.it");
    }


	public function getUrl($inNew=false, $inQueryString="", $inHost=false) {
		$topic = $this->findTopic();
		$url = $topic->getUrl($inHost);
		if ($inNew) {
			$url .= "/new/" . $this->getId(); 
			$info = TwickInfo::fetchById($this->getId());
			if(false && $info && $info->findRatingPosition() == 1) {
				return $url . $inQueryString;
			}
			
		}
		return $url . $inQueryString . "#" . $this->getId();
	}

	
	public function isDeletable() {
		$userId = getUserId();
		return ($userId && $userId == $this->getUserId()) || isAdmin();
	}


    public function getMp3Url() {
		$file = "Twick_" . $this->getId() . ".mp3";
		if(file_exists(DOCUMENT_ROOT . "/../mp3/" . $file)) {
			return HTTP_ROOT . "/mp3/" . $file;
		} else {
			return null;
		}
    }
	
	
	public function getRatingRatio() {
		$count = $this->getRatingCountCached();
		
		if ($count == 0) {
			return 0;
		} else {
			$rating = $this->getRatingSumCached();
			$diff = $count - $rating;
			
			$good = $count - ($diff/2);
			
			return 100 * $good / $count;
		}
	}
    

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function getStandaloneUrl() {
		$url = createSeoUrl($this->getTitle());
		$languageCode = $this->getLanguageCode();
		return HTTP_ROOT . "/twick/$languageCode/$url/" . $this->getId();
	}
	
	
	public function save() {
		$isNew = !$this->getId();
		parent::save();
		$topic = $this->findTopic();
		$topic->updateTagCloud($topic->getTitle());
		
		sendAsynchronousPostRequest(HTTP_ROOT . "/action/update_user_tags.php", array("twick"=>$this->getId()));
        sendAsynchronousPostRequest(HTTP_ROOT . "/action/update_geo.php", array("topic"=>$topic->getId()));
        if($this->getLink()) {
            sendAsynchronousPostRequest(HTTP_ROOT . "/action/send_pingback.php", array("twick"=>$this->getId()));
        }
		
        $theUser = false;
		if ($isNew) {
			$theUser = $this->findUser();
			if($theUser && !$theUser->isAnonymous()) {
				sendAsynchronousPostRequest(HTTP_ROOT . "/action/update_hall_of_fame.php", array("id"=>$theUser->getId(), "secret"=>$theUser->getSecret()), "twickit:Tii1OE4c");
			}
		}

        Notificator::saveTwick($this, $topic, $theUser);
	}
	 		

    public function rate($inPlusMinus, $inUser) {
        $rate = TwickRating::fetchByUserAndTwickId($inUser->getId(), $this->getId());
        if (!$rate) {
            $rate = new TwickRating();
        }
        $rate->setTwickId($this->getId());
        $rate->setRating($inPlusMinus);
        $rate->setUserId($inUser->getId());
        $rate->setCreationDate(getCurrentDate());
        $rate->save();

        $this->updateCache();

        $topic = $this->findTopic();
        $topic->updateTagCloud($topic->getTitle());

        $user = $this->findUser();
        $user->updateCache();
		
		
        Notificator::rateTwick($this, $topic, $user, $inUser, $inPlusMinus);
    }


    public function spam($inUser, $inType) {
        $rate = TwickSpamRating::fetchByTwickAndUserId($this->getId(), $inUser->getId());
        if (!$rate) {
            $rate = new TwickSpamRating();
        }
        $rate->setTwickId($this->getId());
        $rate->setUserId($inUser->getId());
        $rate->setType($inType);
        $rate->setCreationDate(getCurrentDate());
        $rate->save();

        // Direkt auch negativ bewerten
        $this->rate(-1, $inUser);
    }

	
	public function updateCache() {
		$info = TwickInfo::fetchById($this->getId());
        if($info) {
            $this->setRatingSumCached($info->getRating());
            $this->setRatingCountCached($info->getRatingCount());
            $this->save();
        }
	}
	
	
	public function search($inTitle, $inLimit=false, $inAllLanguages=false) {
		$title = sec_mysql_input($inTitle);
		$sql = "SELECT distinct * FROM " . Twick::_getDatabaseName() . " WHERE text LIKE '%$title%' ORDER BY text";
		if ($inLimit > 0) {
			$sql .= " LIMIT $inLimit";
		}
		return Twick::_fetch($sql, $inAllLanguages);
	}


    public static function findTwicksForUsersTopics($inUserId, $inLimit=false, $inAllLanguages=false) {
		$sql = "SELECT x.* FROM " . Topic::_getDatabaseName() . " t, " . Twick::_getDatabaseName() . " x WHERE x.topic_id=t.id AND x.user_id<>$inUserId AND t.id IN (SELECT topic_id FROM " . Twick::_getDatabaseName() . " WHERE user_id=$inUserId)";
		if (!$inAllLanguages) {
			$sql .= " AND t.language_code='" . getLanguage() . "'";
		}

		$sql .= " ORDER BY t.creation_date DESC";

		if ($inLimit) {
			$sql .= " LIMIT $inLimit";
		}

		return Twick::_fetch($sql, true);
	}


	public function findRatingPosition() {
        $sql = "SELECT tbl_twicks.id, sum(ifnull(rating, 0)) AS rating ";
		$sql .= "FROM tbl_twicks ";
		$sql .= "LEFT JOIN tbl_twick_ratings ON tbl_twick_ratings.twick_id = tbl_twicks.id ";
        $sql .= "WHERE topic_id=" . $this->getTopicId() . " ";
        $sql .= "GROUP BY tbl_twicks.id ";
        $sql .= "HAVING rating > " . $this->getRatingSumCached();
		
		$db =& DB::getInstance();
        return $db->query($sql)->num_rows + 1;
	}


	public function findSiblingCount() {
		$sql = "SELECT count(*) AS c FROM " . Twick::_getDatabaseName() . " WHERE topic_id=" . $this->getTopicId();
		
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$count = $result["c"];
		} else {
			$count = 0;
		}

		return $count;
	}	
	
	
	public static function fetchRandom($inLimit=1, $inUsername=false, $inAllLanguages=false) {
        $bindings = array();
        if ($inUsername) {
            $bindings["login"] = $inUsername;
        }
		return Twick::fetch($bindings, array("ORDER BY"=>"rand()", "LIMIT"=>$inLimit), $inAllLanguages);
	}

	
	public static function fetchNewest($inLimit=3, $inAllLanguages=false) {
		$sql = "SELECT * FROM " . Twick::_getDatabaseName();
		if (!$inAllLanguages) {
			$sql .= " WHERE language='" . getLanguage() . "'";
		}
		$sql .= " ORDER BY creation_date DESC, id DESC LIMIT $inLimit";
		return Twick::_fetch($sql);
	}
	
	public static function fetchNewestFromRookies($inLimit=3, $inMaxRating=10) {
		$sql = "SELECT t.* FROM " . Twick::_getDatabaseName() . " t, " . User::_getDatabaseName() . " u WHERE t.user_id=u.id AND (u.id=" . User::ANONYMOUS_USER_ID . " OR u.rating_sum_" . getLanguage() . "<$inMaxRating)";
		$sql .= " AND language='" . getLanguage() . "'";
		$sql .= " ORDER BY creation_date DESC, id DESC LIMIT $inLimit";
		return Twick::_fetch($sql);
	}
	
	
	public static function fetchByUserId($inUserId, $inAllLanguages=false, $inOptions=array()) {
		return Twick::fetch(array("user_id"=>$inUserId), $inOptions, $inAllLanguages);
	}
	
	
	public static function fetchByMail($inMail) {
		return Twick::fetch(array("mail"=>$inMail));
	}
	
	
	public static function fetchByTextAndTopicId($inText, $inTopicId) {
		return Twick::fetch(array("text"=>$inText, "topic_id"=>$inTopicId));
	}
	
	
	public static function fetchByTopicId($inTopicId) {
		return Twick::fetch(array("topic_id"=>$inTopicId));
	}
	
	
	public function findUser() {
		return User::fetchById($this->getUserId());
	}
	

	public function findRatings($inOptions=array()) {
		return TwickRating::fetchByTwickId($this->getId(), $inOptions);
	}
	
	
	public function findSpamRatings($inOptions=array()) {
		return TwickSpamRating::fetchByTwickId($this->getId(), $inOptions);
	}


	public function findTopic() {
		return Topic::fetchById($this->getTopicId());
	}


	public function findTwickInfo() {
		return TwickInfo::fetchById($this->getId());
	}
	
	
	public function delete() {
		DeletedTwick::create($this);

        foreach($this->findRatings() as $rating) {
			$rating->delete();
		}
		
		foreach($this->findSpamRatings() as $rating) {
			$rating->delete();
		}
		
		foreach(TwickFavorite::fetchByTwickId($this->getId()) as $favorite) {
			$favorite->delete();
		}
		
		parent::delete();
		
		$topic = $this->findTopic();
		if (sizeof($topic->findTwicks())) {
			$topic->updateTagCloud($topic->getTitle());
		} else {
			$topic->delete();
		}
		
		$user = $this->findUser();
		$user->updateTagCloud();
		$user->updateCache();

        Notificator::deleteTwick($this, $user);
	}
	
	
	public function isEditable() {
		 $isEditable = $this->getUserId() == getUserId() && $this->getRatingSumCached() <= 0;
		 if (!$isEditable) {
		 	$isEditable = isAdmin(); 
		 }
		 return $isEditable;
	}
	
	
	public function findNumberOfTwicks($inAllLanguages=true) {
		$sql = "SELECT count(*) c FROM " . Twick::_getDatabaseName();
		if (!$inAllLanguages) {
			$sql .= " WHERE language='" . getLanguage() . "'";
		}
		
		$counter = array();
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			return $result["c"];
		} else {
			return 0;
		}
	}

    
	public function fetchRandomNew($inLimit=1, $inAllLanguages=false) {
		$sql = "SELECT count(*) AS c FROM " . Twick::_getDatabaseName();
		if (!$inAllLanguages) {
			$sql .= " WHERE language='" . getLanguage() . "'";
		}
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$count = $result["c"];
		} else {
			$count = 0;
		}

		$twicks = array();
		for ($i=0; $i<$inLimit; $i++) {
			$index = rand(1, $count);
			$sql = "SELECT * FROM " . Twick::_getDatabaseName();
			if (!$inAllLanguages) {
				$sql .= " WHERE language='" . getLanguage() ."'";
			}
			$sql .= " LIMIT 1, $index";

			$twicks[] = array_pop(Twick::_fetch($sql, true));
		}

		return $twicks;
	}
	
	
	public function display($inFollowLink=true, $inAbout=0, $inBig=false, $inSingleView=false, $inAdditionalRatingParameters="") {
		if($loggedIn = getUser()) {
			$secret = $loggedIn->getSecret();
		}
		$user = $this->findUser();
		if ($user->getDeleted()) {
			$user->setLogin(_loc('misc.deletedUser'));
		}
		$text = $this->getText();
		
		$rating = $this->getRatingSumCached();
		$ratingCount = $this->getRatingCountCached();
		
		$inFollowLink = $inFollowLink && $rating >= 0;
		/*
		$topic = $this->findTopic();
	 	foreach($topic->getTags() as $tag=>$count) {
			$text=preg_replace("/\\b($tag)\\b/i", "<a href='" . HTTP_ROOT . "/find_topic.php?search=" . urlencode($tag) . "'>$1</a>", $text);
		}
		*/
		?>
		<!-- Sprechblase | START -->
		<a name="<?php echo($this->getId()) ?>"></a>
	    <div class="sprechblase">
	    	<h2>
	    		<?php 
				if($inAbout) { 
					$topic = $this->findTopic();
	    			loc('twick.about', array($user->getLogin(), htmlspecialchars($this->getTitle()), $this->getUrl()));
					if(isGeo()) {
						?> <a href="admin/geo.php?id=<?php echo($topic->getId()) ?>" target="_blank"><img width="16" height="16" src="<?php echo(STATIC_ROOT) ?>/html/img/world<?php if(!$topic->hasCoordinates()) { echo("_off"); } ?>.png" /></a><?php
					}
		    	} else{ 
		    		loc('twick.says', array($user->getLogin(), htmlspecialchars($this->getTitle())));
		    	} 
				?>
		    </h2>
	
	    	<div class="sprechblase-main">
	        	<div class="sprechblase-links">
	        		<?php if ($user->getDeleted() || $user->isAnonymous()) { ?>
						<div class="bilderrahmen"><img src="html/img/avatar/anonymous64.jpg" alt="" /></div>
	                <?php } else { ?>
	                	<?php if(trim($user->getName()) != "") { ?><i>(<?php echo($user->getName()) ?>)</i><?php } ?>
		                <div class="bilderrahmen"><a href="<?php echo($user->getUrl()) ?>" title="<?php echo htmlspecialchars($user->getDisplayName()) ?>"><?php echo($user->getAvatar(64)) ?></a></div>
	                <?php }  ?>
	                <br />
	                <div id="rating-text<?php echo($this->getId()) ?>" class="anzahl-<?php echo($rating < 0 ? "schlecht" : "gut") ?>">
	                	<?php 
	                	if ($ratingCount == 1) {
	                		if ($rating == 1) {
	                			loc('twick.points.1.1');
	                		} else {
	                			loc('twick.points.-1.1');
	                		}
	                	} else {
	                		if ($rating == 1) {
	                			loc('twick.points.1.n', array($rating, $ratingCount));
	                		} else {
	                			loc('twick.points.n.n', array($rating, $ratingCount));
	                		}
	                	} 
	                	?>
	                </div>
					<?php 	
					if(isAdmin()) {
						global $languages;
						$currentLanguage = getLanguage();
						foreach($languages as $languageInfos) {
							if ($languageInfos["code"] != $currentLanguage) {
							?><a href="javascript:if(confirm('<?php loc('core.areYouSure') ?>')) { location.href='<?php echo(HTTP_ROOT) ?>/action/change_twick_language.php?id=<?php echo($this->getId()) ?>&lng=<?php echo($languageInfos["code"]) ?>'; }"><?php echo($languageInfos["name"]) ?></a><br /><?php
							}
						}	
						?><a href="" onclick="var t=prompt('Neues Thema');if(t!=''&&t!=null) {window.location.href='<?php echo(HTTP_ROOT) ?>/action/move_twick.php?id=<?php echo($this->getId()) ?>&title=' + encodeURIComponent(t);} return false;">Thema &auml;ndern</a><?php
					}
					?> 
	            </div>
	            <div class="sprechblase-rechts" id="twick<?php echo($this->getId()) ?>">
	            	<div class="blase-header">
	                	<?php if($this->getAcronym()) { ?><div class="kurzerklaerung"><span><?php loc('twick.accronym') ?>:</span><span class="acronym"><?php echo htmlspecialchars($this->getAcronym()) ?></span></div><?php } ?>
	                	<?php if($this->getUserId() == getUserId()) { ?>
	                	<div class="daumen-box">
	                        <a href="javascript:;" onclick="doPopup('<?php loc('twick.rating.ownTwick') ?>')" class="negativ-aus" title="<?php loc('twick.bad') ?>"></a>
	                        <a href="javascript:;" onclick="doPopup('<?php loc('twick.rating.ownTwick') ?>')" class="positiv-aus" title="<?php loc('twick.good') ?>"></a>
	                        <div class="clearbox"></div>
	                    </div>
	                    <?php } else if(!isLoggedIn()) { ?>
	                    <div class="daumen-box">
	                        <a href="javascript:;" onclick="doLoginPopup('<?php loc('twick.rating.notLoggedIn') ?>')" class="negativ-button" title="<?php loc('twick.bad') ?>"></a>
	                        <a href="javascript:;" onclick="doLoginPopup('<?php loc('twick.rating.notLoggedIn') ?>')" class="positiv-button" title="<?php loc('twick.good') ?>"></a>
	                        <div class="clearbox"></div>
	                    </div>
	                    <?php } else if($rating = TwickRating::fetchByUserAndTwickId(getUserId(), $this->getId())) { 
	                    			if($rating->getRating() < 0) {
	                    				?>
	                    				<div class="daumen-box">
					                        <a id="thumb-down<?php echo($this->getId()) ?>" href="javascript:;" onclick="doPopup('<?php loc('twick.rating.alreadyNegative') ?>')" class="negativ-button" title="<?php loc('twick.bad') ?>"></a>
					                        <a id="thumb-up<?php echo($this->getId()) ?>" href="javascript:;" onclick="rateTwick(<?php echo($this->getId()) ?>, 1, <?php echo($this->getRatingSumCached()+2) ?>, <?php echo($this->getRatingCountCached()) ?>)" class="positiv-aus" title="<?php loc('twick.good') ?>"></a>
					                        <div class="clearbox"></div>
					                    </div>
					                    <?php 
	                    			} else {
	                    				?>
	                    				<div class="daumen-box">
					                        <a id="thumb-down<?php echo($this->getId()) ?>" href="javascript:;" onclick="rateTwick(<?php echo($this->getId()) ?>, -1, <?php echo($this->getRatingSumCached()-2) ?>, <?php echo($this->getRatingCountCached()) ?>)" class="negativ-aus" title="<?php loc('twick.bad') ?>"></a>
					                        <a id="thumb-up<?php echo($this->getId()) ?>" href="javascript:;" onclick="doPopup('<?php loc('twick.rating.alreadyPositive') ?>')" class="positiv-button" title="<?php loc('twick.good') ?>"></a>
					                        <div class="clearbox"></div>
					                    </div>
					                    <?php
	                    			}	
						?>	                  
	                	<?php } else { ?>
	                    <div class="daumen-box">
	                        <a id="thumb-down<?php echo($this->getId()) ?>" href="javascript:;" onclick="rateTwick(<?php echo($this->getId()) ?>, -1, <?php echo($this->getRatingSumCached()-1) ?>, <?php echo($this->getRatingCountCached()+1) ?>)" class="negativ-button" title="<?php loc('twick.bad') ?>"></a>
	                        <a id="thumb-up<?php echo($this->getId()) ?>" href="javascript:;" onclick="rateTwick(<?php echo($this->getId()) ?>, 1, <?php echo($this->getRatingSumCached()+1) ?>, <?php echo($this->getRatingCountCached()+1) ?>)" class="positiv-button" title="<?php loc('twick.good') ?>"></a>
	                        <div class="clearbox"></div>
	                    </div>
	                    <?php } ?>
	                </div>
	
	                <div class="blase-body">
	                    <dl>
	                        <dt><?php echo htmlspecialchars($this->getTitle()) ?>:</dt>
	                        <dd><?php echo htmlspecialchars($this->getText()) ?></dd>
	                    </dl>
	                    <?php if($this->getLink()) { ?><div class="twick-link"><?php loc('twick.url') ?>: <a href="<?php echo htmlspecialchars($this->getLink(true)) ?>" title="<?php echo($this->getLink()) ?>" target="_blank" class="moreinfos" id="moreinfos<?php echo($this->getId()) ?>" <?php if(!$inFollowLink) { ?>rel="nofollow"<?php } ?>><?php echo (str_replace("/", "/<wbr />", str_replace("?", "?<wbr />", str_replace("&", "&<wbr />", $this->getLink())))) ?></a></div><?php } ?>
	                </div>
	
	                <div class="blase-footer">
	                	<?php if (isLoggedIn()) { ?>
	                		<?php if(TwickFavorite::fetchByUserAndTwickId(getUserId(), $this->getId())) { ?>
								<a href="javascript:;" onclick="removeFavorite(<?php echo($this->getId()) ?>);this.blur();" class="stern-aktiviert" id="fav<?php echo($this->getId()) ?>" title="<?php loc('twick.removeFavorite') ?>"></a>	                			
	                		<?php } else { ?>
		                		<a href="javascript:;" onclick="addFavorite(<?php echo($this->getId()) ?>);this.blur();" class="stern" id="fav<?php echo($this->getId()) ?>" title="<?php loc('twick.addFavorite') ?>"></a>
		                	<?php } ?>	
	                	<?php } else { ?>
	                	<a href="javascript:;" onclick="doPopup('<?php loc('twick.addFavorite.notLoggedIn') ?>')" class="stern"  title="<?php loc('twick.addFavorite') ?>"></a>
	                	<?php } ?>
	                    
	                    <!-- Klapp-Menue - START -->
	                    <div id="totenkopf<?php echo($this->getId()) ?>" title="<?php loc('twick.bullshit.button') ?>"><a href="#" class="totenkopf"></a></div>  
	                    <script type="text/javascript">
                        <!--
	                    at_attach_spam(<?php echo($this->getId()) ?>, "<?php echo($inAbout . $inAdditionalRatingParameters) ?>", "<?php echo($secret) ?>");
                        //-->
	                    </script>
	                	<!-- Klapp-Menue - ENDE -->
	
	                    <span><?php
                            if($inSingleView) {
                            ?><a href="<?php echo("find_topic.php?search=" . urlencode($this->getTitle())) ?>" title="<?php loc('twick.topicView') ?>" style="color:#666"><?php loc('twick.creationDate', convertDate($this->getCreationDate())) ?></a><?php
                            } else {
                            ?><a href="<?php echo($this->getStandaloneUrl()) ?>" title="<?php loc('twick.singleView') ?>" style="color:#666"><?php loc('twick.creationDate', convertDate($this->getCreationDate())) ?></a><?php
                            }
                        ?></span>


	                    <?php if ($this->isEditable()) { ?>
	                    <a href="javascript:showEditor(<?php echo($this->getId()) ?>)" class="stift" title="<?php loc('twick.edit') ?>" /></a>
	                    <?php } else if($user->getId() == getUserId()) { ?>
	                    <a href="javascript:doPopup('<?php loc('twick.edit.off') ?>')" class="stift_aus" title="<?php loc('twick.edit') ?>" /></a>
	                    <?php } ?>
	                    <?php
	                    $style = "style='margin-left:70px;'"; 
	                    if ($this->isDeletable()) { 
	                    	$style = "";
	                    ?>
	                    <a href="javascript:confirmPopup('<div style=\'width:100%;text-align: center; font-size:20px;\'><?php loc('core.areYouSure') ?></div><br /><?php loc('twick.delete.confirm') ?>', '<?php echo(HTTP_ROOT) ?>/action/delete_twick.php?id=<?php echo($this->getId()) ?>&secret=<?php echo($secret) ?>');" class="muelleimer" title="<?php loc('twick.delete') ?>" /></a>
	                    <?php } ?>

						<?php if(!$user->isAnonymous()) { ?>
                        <!-- Klapp-Menue - START -->
	                    <div id="message<?php echo($this->getId()) ?>" title="<?php loc('twick.message') ?>"><a href="#" class="themenbrief"></a></div>
	                    <script type="text/javascript">
                        <!--
	                    at_attach_message(<?php echo($this->getId()) ?>, "<?php echo($user->getLogin()) ?>");
                        //-->
	                    </script>
	                	<!-- Klapp-Menue - ENDE -->
						<?php } ?>
	                </div>
	            </div>
	            
	            <?php 
				if ($this->isEditable()) {
					$text = $this->getText();
					$link = $this->getLink();
					$acronym = $this->getAcronym(); 
					if (getArrayElement($_GET, "edit") === $this->getId()) {
						$text = htmlspecialchars($_GET["text"]);
						$link = htmlspecialchars($_GET["link"]);
						$acronym = htmlspecialchars($_GET["acronym"]);
					}
				?>
	            <div class="sprechblase-rechts" id="twick_editor<?php echo($this->getId()) ?>" style="display:none">
		            <div class="blase-header" id="eingabeblase-head"></div>
		            <div class="blase-body">
		                <form class="eingabeblase" id="twickit-blase<?php echo($this->getId()) ?>" action="confirm_twick.php" method="get" name="twickForm">
		                    <?php echo(SpamBlocker::printHiddenTags()) ?>
		                    <input type="hidden" name="id" value="<?php echo($this->getId()) ?>" />
		  					<input type="hidden" name="title" value="<?php echo($this->getTitle()) ?>" />
		                    <label for="acronym"><?php loc('yourTwick.acronym') ?> <span>(<?php loc('yourTwick.optional') ?>)</span>:</label>
		                    <input name="acronym" type="text" value="<?php echo($acronym) ?>"/>
		                    <label for="text"><?php loc('yourTwick.text') ?> <span>(<?php loc('yourTwick.required') ?>)</span>:</label>
							<div id="charCounter<?php echo($this->getId()) ?>" class="charCounterOK"><?php echo(140 - mb_strlen(html_entity_decode($this->getText()), "utf8")) ?></div>
		                    <textarea name="text" id="textfield<?php echo($this->getId()) ?>" onkeyup="updateCharCounter(<?php echo($this->getId()) ?>)" onkeypress="updateCharCounter(<?php echo($this->getId()) ?>)"><?php echo($text) ?></textarea>
		                    <label for="link"><?php loc('yourTwick.url') ?> <span>(<?php loc('yourTwick.optional') ?>)</span>:</label>
		                    <input name="link" type="text" value="<?php echo($link) ?>" />
		                </form>    
		            </div>
		            <div class="blase-footer" id="eingabeblase-footer">
		                <a href="javascript:;" onclick="$('twickit-blase<?php echo($this->getId()) ?>').submit();"  id="twickit<?php echo($this->getId()) ?>" class="twickitpreview"><?php loc('yourTwick.preview') ?></a>
		                <a href="javascript:hideEditor(<?php echo($this->getId()) ?>)" style="margin-top:-20px;display:block;"><?php loc('core.cancel') ?></a>
		            </div>
		        </div>
	            <?php 
				}
				?>
	
	            <div class="clearbox">&nbsp;</div>
	        </div>
	    </div>
	    <!-- Sprechblase | ENDE -->
	    <?php 
		flush();
	}
}
?>