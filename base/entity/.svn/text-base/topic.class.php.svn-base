<?php
/*
 * Created at 26.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/TopicStub.class.php";

class Topic extends TopicStub {

	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------	
	function getNumberOfTwicks() {
		return sizeof(Topic::findTwicks());
	}


	function getUrl($inHost=false) {
        if($inHost) {
            return $inHost . "/" . $this->getUrlId();
        } else {
            return HTTP_ROOT . "/" . $this->getUrlId();
        }
	}
	
	
	function getShortUrl($inHost=false) {
        if($inHost) {
            return $inHost . "/" . convertIdToShort($this->getId());
        } else {
            return HTTP_ROOT . "/" . convertIdToShort($this->getId());
        }
	}


	function getWikipediaLink($inTitle) {
		$firstItem = getFirstWikipediaSuggestion($inTitle);	

		$link = $firstItem->Url;
		$title = $firstItem->Text;
		$description = $firstItem->Description;

		if ($link) {
			return array($link, $title, $description);
		} else {
			return false;
		}
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function __toString() {
        return $this->getTitle();
    }
    
    
	public function updateStemming() {
		require_once(DOCUMENT_ROOT . "/util/thirdparty/stemming/StemmingFactory.class.php");
		$this->setStemming(StemmingFactory::stem($this->getTitle()));
	} 
	
	
	public function updateCoreTitle() {
		$this->setCoreTitle(getCoreTitle($this->getTitle()));
	} 


    public function updateCoordinates() {
        if(!$this->getNoGeo() && !$this->hasCoordinates()) {
            $geo = findGeoCoordinates($this->getTitle());
            $this->setGeoDate(getCurrentDate());
            if ($geo) {
                $this->setLongitude($geo[1]);
                $this->setLatitude($geo[0]);
            }
            $this->save();
        } 
    }
    
	
	public function createUrlId() {
		$urlId = createSeoUrl($this->getTitle(), $this->getLanguageCode());
		$counter = 2;
		
		$newUrlId = $urlId;
		while(Topic::fetchByUrlId($newUrlId)) {
			$newUrlId = $urlId . "_" . $counter;
			$counter++;
		}
		return $newUrlId;
	}
	

	public function fetchByTitle($inTitle, $inAllLanguages=false) {
		return Topic::fetch(array("title"=>$inTitle), $inAllLanguages);
	}

	
	public function fetchByStemming($inStemming, $inAllLanguages=false, $inOptions=array()) {
		return Topic::fetch(array("stemming"=>$inStemming), $inAllLanguages, $inOptions);
	}
	
	
	public function fetchByCoreTitle($inCoreTitle, $inAllLanguages=false) {
		return Topic::fetch(array("core_title"=>$inCoreTitle), $inAllLanguages, array("ORDER BY"=>"title ASC"));
	}
	
	
	public function fetchByUrlId($inUrlId) {
		return array_pop(Topic::fetch(array("url_id"=>$inUrlId), true));
	}
	

	public function fetchBySimilarTitle($inTitle, $inLimit="", $inAllLanguages=false, $inSkipWhenMatchExactly=false) {
		$sql = "SELECT * FROM " . Topic::_getDatabaseName() . " WHERE title LIKE '" . sec_mysql_input($inTitle) . "%'";
		
		if(!$inAllLanguages) {
			$sql .= " AND language_code='" . getLanguage() . "'";
		}
		
		$sql .= " ORDER BY title ASC";
		
		if ($inLimit && is_numeric($inLimit) && $inLimit > 0) {
			$sql .= " LIMIT $inLimit";
		}

		$topics = Topic::_fetch($sql, true);
		
		if (sizeof($topics)) {
			if ($inSkipWhenMatchExactly && isAdmin()) {
				 $first = $topics[0];
				 $core = strtolower($inTitle);
				 if (strtolower($first->getTitle()) == $core || strtolower($first->getCoreTitle()) == $core) {
				 	return array($first);
				 }
			}
		} else {
			$topics = Topic::search($inTitle, $inAllLanguages, $inLimit);
		}

		return $topics;
	}


	function search($inTitle, $inAllLanguages=false, $inLimit="", $inWithLike=true) {
		$title = sec_mysql_input($inTitle);
		$sql = "SELECT distinct * FROM " . Topic::_getDatabaseName() . " WHERE (MATCH title AGAINST('$title') OR title LIKE '$title (%)'";
		if ($inWithLike) {
			$sql .= " OR title LIKE '%$title%'";
		}
		$sql .= ") ORDER BY title";
		if ($inLimit && is_numeric($inLimit)) {
			$sql .= " LIMIT $inLimit";
		}
		return Topic::_fetch($sql, $inAllLanguages);
	}


	function findTopicsForUserId($inUserId, $inAllLanguages=false) {
		$sql = "SELECT distinct t.* FROM tbl_topics t, tbl_twicks x WHERE t.id=x.topic_id AND x.user_id=" . sec_mysql_input($inUserId);
		return Topic::_fetch($sql, $inAllLanguages);
	}


	function findTwicks() {
		return Twick::fetchByTopicId($this->getId());
	}


	function findBestTwick() {
		return array_shift($this->findTwicks());
	}


	function findNumberOfTopics($inAllLanguages=false) {
		$sql = "SELECT count(*) AS c FROM " . Topic::_getDatabaseName();
		if (!$inAllLanguages) {
			$sql .= " WHERE language_code='" . getLanguage() . "'";
		}

		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			return $result["c"];
		} else {
			return 0;
		}
	}


	public function fetchNewest($inLimit=3, $inAllLanguages=false) {
		return Topic::fetch(array(), $inAllLanguages, array("ORDER BY"=>"creation_date desc", "LIMIT"=>$inLimit));
	}


	public function fetchMostTwicked($inLimit=3, $inAllLanguages=false) {
		$sql = "SELECT t.*, count(t.title) as c FROM " . Topic::_getDatabaseName() . " t, " . Twick::_getDatabaseName() . " x WHERE t.id=x.topic_id";
		if (!$inAllLanguages) {
			$sql .= " AND t.language_code='" . getLanguage() . "'";
		}
		$sql .= " GROUP BY topic_id ORDER BY count(t.title) DESC LIMIT $inLimit";

		$db =& DB::getInstance();
		$db->query($sql);
		
		$info = array();
		for($i=0; $i<$inLimit; $i++) {
			if ($result = $db->getNextResult()) {
				$topic = new Topic();
				$topic->_setDatabaseValues($result);
				$info[] = array($topic, $result["c"]);
			} else {
				return $info;
			}
		}
		
		return $info;
	}


	public function fetchLessTwicked($inLimit=3, $inAllLanguages=false) {
		$sql = "SELECT t.*, count(t.title) as c FROM " . Topic::_getDatabaseName() . " t, " . Twick::_getDatabaseName() . " x WHERE t.id=x.topic_id";
		if (!$inAllLanguages) {
			$sql .= " AND t.language_code='" . getLanguage() . "'";
		}
		
		$sql .= " GROUP BY topic_id ORDER BY count(t.title) ASC LIMIT $inLimit";

		$db =& DB::getInstance();
		$db->query($sql);
		
		$info = array();
		for($i=0; $i<$inLimit; $i++) {
			if ($result = $db->getNextResult()) {
				$topic = new Topic();
				$topic->_setDatabaseValues($result);
				$info[] = array($topic, $result["c"]);
			} else {
				return $info;
			}
		}
		
		return $info;
	}


	public function fetchRandom($inLimit=1, $inAllLanguages=false) {
		return Topic::fetch(array(), $inAllLanguages, array("ORDER BY"=>"rand()", "LIMIT"=>$inLimit));
	}
	
	
	public function fetchRandomNew($inLimit=1, $inAllLanguages=false) {
		$sql = "SELECT count(*) AS c FROM " . Topic::_getDatabaseName();
		if (!$inAllLanguages) {
			$sql .= " WHERE language_code='" . getLanguage() . "'";
		}
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			$count = $result["c"];
		} else {
			$count = 0;
		}
		
		$topics = array();
		for ($i=0; $i<$inLimit; $i++) {
			$index = rand(1, $count);
			$sql = "SELECT * FROM " . Topic::_getDatabaseName();
			if (!$inAllLanguages) {
				$sql .= " WHERE language_code='" . getLanguage() ."'";
			}
			$sql .= " LIMIT 1, $index";
		
			$topics[] = Topic::_fetch($sql, true);
		}
		
		return $topics; 
	}

	
	function findRelatedTopics($inMax=false, $inAllLanguages=false) {
		$topics = Topic::findRelatedTopicsByTitle($this->getTitle());
		if (!$inMax || sizeof($topics) < $inMax) {
			$topics = array_merge($topics, $this->findRelatedTopicsByTags(4, $inAllLanguages));
			$topics = array_unique($topics);
		}

		return $topics;
	}

	
	function findRelatedTopicsByTitle($inTitle, $inLimit=false, $inAllLanguages=false) {
		// Seltsame Extrawurst bei ß. Hier wurde "Bart Simpson" wegen "ay" (= "Ay caramba" aber auch Falschkodierung für ß) gefunden
		if ($inTitle == "ß") {
			$inTitle = "ss";
		}
		if (getArrayElement($_GET, "stem")) {
			$sql = "SELECT t.* FROM " . Topic::_getDatabaseName() . " t, " . Tag::_getDatabaseName() . " x WHERE t.id=x.foreign_id AND x.stemming='" . sec_mysql_input(StemmingFactory::stem($inTitle)) . "' AND x.entity='topic' AND t.title<>'" . sec_mysql_input($inTitle) . "'";
		} else {
			$sql = "SELECT t.* FROM " . Topic::_getDatabaseName() . " t, " . Tag::_getDatabaseName() . " x WHERE t.id=x.foreign_id AND x.tag='" . sec_mysql_input($inTitle) . "' AND x.entity='topic' AND t.title<>'" . sec_mysql_input($inTitle) . "'";			
		}
		if ($inLimit > 0) {
			$sql .= " LIMIT $inLimit";
		}
		return Topic::_fetch($sql, $inAllLanguages);
	}


	function findRelatedTopicsByTags($inMinimumMatches=4, $inAllLanguages=false) {
		if (getArrayElement($_GET, "stem")) {
			$sql = "SELECT t3.* FROM " . Tag::_getDatabaseName() . " t1, " . Tag::_getDatabaseName() . " t2, " . Topic::_getDatabaseName() . " t3 WHERE t3.id<>" . $this->getId() . " AND t3.id=t1.foreign_id AND t2.foreign_id=" . $this->getId() . " AND t1.entity='" . $this->_getTagType() . "' AND t2.entity='" . $this->_getTagType() . "' AND t1.stemming=t2.stemming GROUP BY t1.foreign_id HAVING count(*) >= $inMinimumMatches ORDER BY count(*) DESC";			
		} else {
			$sql = "SELECT t3.* FROM " . Tag::_getDatabaseName() . " t1, " . Tag::_getDatabaseName() . " t2, " . Topic::_getDatabaseName() . " t3 WHERE t3.id<>" . $this->getId() . " AND t3.id=t1.foreign_id AND t2.foreign_id=" . $this->getId() . " AND t1.entity='" . $this->_getTagType() . "' AND t2.entity='" . $this->_getTagType() . "' AND t1.tag=t2.tag GROUP BY t1.foreign_id HAVING count(*) >= $inMinimumMatches ORDER BY count(*) DESC";
		}
		return Topic::_fetch($sql, $inAllLanguages);
	}
	
	
	function findRelatedTopicsByStemming($inTitle, $inAllLanguages=false, $inLimit=false) {
		require_once(DOCUMENT_ROOT . "/util/thirdparty/stemming/StemmingFactory.class.php");
        $sql = "stemming='" . sec_mysql_input(StemmingFactory::stem($inTitle)) . "' AND core_title<>'" . sec_mysql_input(getCoreTitle($inTitle)) . "'";
        if($inLimit) {
            $sql .= " LIMIT " . (int)$inLimit;
        }
		return Topic::fetchBySQL($sql, $inAllLanguages);
	}
	
	
	function findHomonyms() {
		return Topic::findHomonymsByTitle($this->getTitle(), $this->getId());
	}
	
	
	function findHomonymsByTitle($inTitle, $inExcludeTopicId=false) {
		$title = getCoreTitle($inTitle);
		$sql = "core_title='" . sec_mysql_input($title) . "'";
		if ($inExcludeTopicId) {
			$sql .= " AND id<>" . sec_mysql_input($inExcludeTopicId);
		}
		return Topic::fetchBySQL($sql, false);
	}
	
	
	public function findNumberOfTwicksForUserInTheLastHours($inUserId, $inHours=24) {
		$date = date("Y-m-d H:i:s", time() - $inHours * 3600);
		$sql = "SELECT count(*) as c FROM " . Twick::_getDatabaseName() . " WHERE topic_id=" . $this->getId() . " AND user_id=$inUserId AND creation_date>='$date'";
	
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			return $result["c"];
		} else {
			return 0;
		}
	}
	
	
	public function findNumberOfTwicksForCharacter($inChar) {
		$sql = "SELECT count(*) AS c FROM " . Topic::_getDatabaseName() . " WHERE title LIKE '$inChar%' AND language_code='" . getLanguage() . "'";
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			return $result["c"];
		} else {
			return 0;
		}
	}

	
	public static function findSuggestions($inTitle) {
		$suggestions = array();
				
		// Suche in Twick.it
		$topics = Topic::search($inTitle, false, "", mb_strlen($inTitle)>=2);

		$maxDistance =  mb_strlen($inTitle) / 1.1;
		if($maxDistance > 7) {
			 $maxDistance = mb_strlen($inTitle) / 2.2;
		}

		foreach($topics as $topic) {
			$distance = levenshtein(strtolower($topic->getTitle()), strtolower($inTitle));
			if ($distance > $maxDistance) {
				continue;
			}
			$suggestions[$topic->getTitle()] = 3 + 10/$distance;
			if(strtolower($topic->getCoreTitle()) == strtolower($inTitle)) {
				$suggestions[$topic->getTitle()] += 2;
			}
		}

		// Suche in Wikipedia
		foreach(getWikipediaSpellSuggestions($inTitle) as $wikiSuggestion=>$link) {
			$distance = levenshtein(strtolower($wikiSuggestion), strtolower($inTitle));
			if ($distance > $maxDistance) {
				continue;
			}
			$suggestions[$wikiSuggestion] = getArrayElement($suggestions, $wikiSuggestion, 0) + 1 + 10/$distance;
		}

		arsort($suggestions);
		return $suggestions;
	}
	

    public function findNearest($inRadius=false, $inLimit=false) {
        return self::findNear($this->getLatitude(), $this->getLongitude(), $inRadius, $inLimit);
    }

    public function findNear($inLatitude, $inLongitude, $inRadius=false, $inLimit=false, $inAllLanguages=false) {
        $longitude = sec_mysql_input($inLongitude);
        $latitude = sec_mysql_input($inLatitude);
       
		// Einige Zwischenwerte berechnen, damit die Datenbank das nicht machen muss
		$pi180 = M_PI / 180;
		$v180pi = 180 / M_PI;
		$latitudePi180 = $latitude * $pi180;
	   
		$sql = "SELECT *, (((acos(sin($latitudePi180) * sin(latitude * $pi180) +
                         cos($latitudePi180) * cos(latitude * $pi180) *
                       cos(($longitude  - longitude) * $pi180))
                      ) * $v180pi) * 111189.57696) as distance
            FROM " . Topic::_getDatabaseName() . "
			WHERE latitude IS NOT NULL AND longitude IS NOT NULL"
			;
			
        if (!$inAllLanguages) {
            $sql .= " AND language_code='" . sec_mysql_input(getLanguage()) . "'";
        }

        if ($inRadius) {
            $radius = sec_mysql_input($inRadius);
            $sql .= " HAVING distance <= $radius";
        }
        $sql .= " ORDER BY distance ASC";

        if ($inLimit) {
            $sql .= " LIMIT " . sec_mysql_input($inLimit);
        }

        $near = array();
        $db =& DB::getInstance();
		$db->query($sql);
		while ($result = $db->getNextResult()) {
            $distance = $result["distance"];
            $topic = self::_createFromDB($result);
            $near[] = array($distance, $topic);
        }
        return $near;
    }


    public function findInArea($inNorth, $inEast, $inSouth, $inWest, $inLimit=false, $inAllLanguages=false) {
        $north = sec_mysql_input($inNorth);
        $east = sec_mysql_input($inEast);
        $south = sec_mysql_input($inSouth);
        $west = sec_mysql_input($inWest);

		return Topic::fetchBySQL("latitude<=$north AND latitude>=$south AND longitude>=$east AND longitude<=$west");
    }
}
?>