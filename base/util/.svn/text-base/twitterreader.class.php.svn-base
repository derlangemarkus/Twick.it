<?php
class TwitterReader {
	
	private $data;
	
	public function TwitterReader() {
		$url = "http://api.twitter.com/1/favorites/twickit.rss";

        // Erst mal ganz olle Daten (bis zu 100 Tage alt) holen
        $oldContent = getCachedFileContent($url, 8640000);

        // Dann versuche, frische Werte zu bekommen (kann aber sein,
        // das das wegen Traffic-Begrenzung nicht geht)
        $content = getCachedFileContent($url, 3600);

        // Aha! Kein frisches XML bekommen, aber altes. Dann nehmen wir
        // halt erst mal das.
        if (!$content && $oldContent) {
            $content = $oldContent;
            $cache = new Cache();
            $cache->saveInCache($url, $content);
        }

		$xml = simplexml_load_string($content);
		
		foreach($xml->channel->children() as $child) {
			if($child->title) {
				$author = strtolower(substringBetween($child->link, "twitter.com/", "/"));
				if (!in_array($author, array("reimix", "derlangemarkus", "twckit", "twickit", "twickit_info", "twickit_de", "twickit_en", "twickit_fame","twickit_api"))) {
					$this->data[] = $child;
				}
			}		
		}
	}
	
	public function getData() {
		return $this->data;
	}
	
	
	public function getRandom() {
		$index = rand(0, sizeof($this->data)-1);
		return array($index, $this->data[$index]);
	}
	
	
	public function getNext($inIndex=-1) {
		if($inIndex == -1) {
			return $this->getRandom();
		} else {
			if ($inIndex >= sizeof($this->data)) {
				$index = 0;
			} else {
				$index = $inIndex;
			}
			return array($index, $this->data[$index]);
		}
	}
	
	
	public static function getTwitterAvatarUrl($inUserName, $inSize=32) {
		if ($inUserName == "") {
			return User::getDefaultAvatarUrl($inSize);
		} else {
			try {
                $infoUrl = TwitterReader::_getTwitterInfoUrl($inUserName);

                // Erst mal ganz olle Daten (bis zu 100 Tage alt) holen
                $oldXml = getCachedFileContent($infoUrl, 8640000, 2);

                // Dann versuche, frische Werte zu bekommen (kann aber sein,
                // das das wegen Traffic-Begrenzung nicht geht)
				$xml = getCachedFileContent($infoUrl, 86400, 2);
			
                // Aha! Kein frisches XML bekommen, aber altes. Dann nehmen wir
                // halt erst mal das.
                if (!$xml && $oldXml) {
                    $xml = $oldXml;
                    $cache = new Cache();
                    $cache->saveInCache($infoUrl, $xml);
                }

				if (!$xml) {
					return User::getDefaultAvatarUrl($inSize);
				}
				
				$twitter = simplexml_load_string($xml);
				return self::getTwitterAvatarUrlImage($twitter->profile_image_url, $inSize);
			} catch(Exception $e) {
				return User::getDefaultAvatarUrl($inSize);
			}
		} 
	}


    public static function getTwitterAvatarUrlImage($inImage, $inSize=32) {
        if (contains($inImage, "s.twimg.com")) {
            return User::getDefaultAvatarUrl();
        } else {
            foreach(array("jpg", "png", "gif", "bmp", "jpeg") as $format) {
                if (endsWith($inImage, "_normal.$format")) {
                    $inImage = substringBeforeLast($inImage, "_normal.$format") . ".$format";
                    break;
                }
            }
        }

        return HTTP_ROOT . "/util/thirdparty/phpThumb/phpThumb.php?w=$inSize&h=$inSize&far=1&src=" . urlencode($inImage) . "&err=" . urlencode(User::getDefaultAvatarUrl($inSize));
    }


    public static function getTwitterId($inUserName) {
		if ($inUserName == "") {
			return null;
		} else {
			try {
                $infoUrl = TwitterReader::_getTwitterInfoUrl($inUserName);

                // Erst mal ganz olle Daten (bis zu 100 Tage alt) holen
                $oldXml = getCachedFileContent($infoUrl, 8640000, 2);

                // Dann versuche, frische Werte zu bekommen (kann aber sein,
                // das das wegen Traffic-Begrenzung nicht geht)
				$xml = getCachedFileContent($infoUrl, 86400, 2);

                // Aha! Kein frisches XML bekommen, aber altes. Dann nehmen wir
                // halt erst mal das.
                if (!$xml && $oldXml) {
                    $xml = $oldXml;
                    $cache = new Cache();
                    $cache->saveInCache($infoUrl, $xml);
                }

				if (!$xml) {
					return null;
				}

				$twitter = simplexml_load_string($xml);
				return (string)$twitter->id;
			} catch(Exception $e) {
				return null;
			}
		}
	}

    
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	private static function _getTwitterInfoUrl($inUserName) {
		return "http://api.twitter.com/1/users/show.xml?screen_name=$inUserName";
	}
}
?>