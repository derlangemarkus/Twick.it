<?php
abstract class AbstractTaggedDatabaseObject extends AbstractDatabaseObject {
	
	// ---------------------------------------------------------------------
	// ----- Getter/Setter -------------------------------------------------
	// ---------------------------------------------------------------------
	public function getTags() {
		$result = array();

		foreach($this->fetchTags() as $tag) {
			$result[$tag->getTag()] = $tag->getCount();
		}

		return $result;
	}

	
	public function getTagsAsString($inQuot=false) {
		$result = "";

		$quot = $inQuot ? "'" : "";
		$separator = "";
		foreach($this->getTags() as $tag=>$count) {
			if ($tag != "") {
				$result .= $separator . $quot . $tag . $quot;
				$separator = ", ";
			}
		}

		return $result;
	}
	
	
	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function updateTagCloud($inSkipWord=false) {
		$this->_clearTags();
		
		require_once(DOCUMENT_ROOT . "/util/keywords/package_inc.php");
		$keywordFinder = new TwickKeywordFinder($this->findTwicks(), false);
		$keywords = $keywordFinder->getKeywordsAsArray();
		
		if ($inSkipWord !== false) {
			unset($keywords[StemmingFactory::stem(strtolower($inSkipWord))]);
		}
		$keywords = array_slice($keywords, 0, 10);
		foreach($keywords as $stemming=>$info) {
			$tagObject = new Tag();
			$tagObject->setEntity($this->_getTagType());
			$tagObject->setForeignId($this->getId());
			$tagObject->setTag($info["word"]);
			$tagObject->setStemming($stemming);
			$tagObject->setCount($info["count"]);
			$tagObject->save();
		}
		
		$this->save();
	}
	
	
	public function fetchTags() {
		return Tag::fetchByEntity($this);
	}
	
	
	public function delete() {
		$this->_clearTags();
		parent::delete();
	}
	
	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected function _clearTags() {
		// Vorhandene Tags loeschen
		foreach($this->fetchTags() as $tag) {
			$tag->delete();
		}
	}
	
	
	protected function _findRelatedEntitiesByTags($inAllLanguages=false) {
		$sql = "SELECT foreign_id, count(*) AS c FROM " . Tag::_getDatabaseName() . " WHERE entity='" . $this->_getTagType() . "' AND stemming IN (SELECT stemming FROM " . Tag::_getDatabaseName() . " WHERE foreign_id=" . $this->getId() . " AND entity=''" . $this->_getTagType() . "')";
		if (!$inAllLanguages) {
			$sql .= " AND language_code='" . getLanguage() . "'";
		}
		$sql .= " GROUP BY foreign_id ORDER BY c";
		$objects = array();
		$db =& DB::getInstance();
		$db->query($inSQL);
		while ($result = $db->getNextResult()) {
			$objects[$result["foreign_id"]] = $result["c"];
		}

		return $objects;
	}
	
	
	protected function _getTagType() {
		return strtolower(get_class($this));
	}
}