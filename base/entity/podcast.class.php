<?php
/*
 * Created at 13.07.2011
 *
 * @author Markus Moeller - Twick.it
 */

require DOCUMENT_ROOT ."/entity/stubs/PodcastStub.class.php";

class Podcast extends PodcastStub {

    private $twick;
    private $author;

    function __call($inName, $inArguments) {
        $this->getTwick();
        if(method_exists($this->twick, $inName)) {
			return call_user_func_array(array($this->twick, $inName), $inArguments);
		}
	}


    public function getUrl() {
        return HTTP_ROOT . "/podcast.php?id=" . $this->getId();
    }


    public function getSize($inUseKB=true) {
        $info = stat(DOCUMENT_ROOT . "/../mp3/" . $this->getMp3File());
		$size = $info["size"];
        return $inUseKB ? round($size / 1024) : $size;
    }


    public function getMp3File() {
        return "Twick_" . $this->getTwickId() . ".mp3";
    }


    public function getTopicUrl() {
        return substringBefore($this->getTwick()->getUrl(), "#");
    }


    // ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
    public function getTwick() {
        if(!$this->twick) {
            $this->twick = Twick::fetchById($this->getTwickId());
        }
        return $this->twick;
    }


    public function getAuthor() {
        if(!$this->author) {
            $this->author = User::fetchById($this->getTwick()->getUserId());
        }
        return $this->author;
    }

    public static function fetchByTwickId($inTwickId) {
		return self::fetch(array("twick_id"=>$inTwickId));
	}


    public static function fetchLatest($inLimit=10, $inOffset=0) {
        return self::fetchBySQL("publish_date IS NOT NULL ORDER BY publish_date DESC LIMIT $inOffset, $inLimit");
    }
    

	public function findNumberOfPodcasts() {
		$sql = "SELECT count(*) c FROM " . self::_getDatabaseName() . " WHERE publish_date IS NOT NULL";
		
		$counter = array();
		$db =& DB::getInstance();
		$db->query($sql);
		if ($result = $db->getNextResult()) {
			return $result["c"];
		} else {
			return 0;
		}
	}
	
	
    public static function publish() {
        $sql = "publish_date IS NULL ORDER BY rand() LIMIT 1";
        $podcast = array_pop(self::fetchBySQL($sql));

        $podcast->setPublishDate(getCurrentDate());
        $podcast->save();

        return $podcast;
    }
}
?>