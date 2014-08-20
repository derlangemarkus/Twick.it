<?php 
class Bookmarker {
	
	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	private $title;
	private $url;
	private $description;
	private $tags;
	
	
	// ---------------------------------------------------------------------
	// ----- Konstruktor ---------------------------------------------------
	// ---------------------------------------------------------------------
	function __construct($inTitle="Twick.it", $inUrl="http://twick.it", $inDescription="", $inTags="") {
		$this->title = $inTitle;
		$this->url = $inUrl;
		$this->description = $inDescription;
		$this->tags = $inTags;
	}
	
	
	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function printBookmarks($inServices=false) {
		echo($this->getBookmarks($inServices));
	}
	
	
	public function getBookmarks($inServices=false) {
		return implode("\n", $this->getBookmarksAsArray($inServices));
	}
	
	
	public function getBookmarksAsArray($inServices=false) {
		$result = array();
		include_once DOCUMENT_ROOT . "/util/socialbookmarks/bookmark_config.php";

		foreach($onlineBookmarkingSites as $onlineBookmarkSite => $config) {
			if ($inServices === false || in_array($onlineBookmarkSite, $inServices)) {
				$url = $this->getBookmarkLink($onlineBookmarkSite);
				$result[] = "<a class='socialbookmark' target='_blank' href='$url'><img src='" . HTTP_ROOT . "/util/socialbookmarks/images/" . $config["icon"] . "' alt='$onlineBookmarkSite' title='$onlineBookmarkSite'></a>";
			}
		}
		
		return $result;
	}
	
	
	public function getBookmarkLink($inService) {
		include DOCUMENT_ROOT . "/util/socialbookmarks/bookmark_config.php";
		
		$config = $onlineBookmarkingSites[$inService];
		
		$url = $config["url"];
		$url = str_replace("{DESC}", urlencode($this->description), $url);
		$url = str_replace("{TITLE}", urlencode($this->title), $url);
		$url = str_replace("{PERMALINK}", urlencode($this->url), $url);
		$url = str_replace("{TAGS}", urlencode($this->tags), $url);
		return $url;
	}
	
	public function printBookmarkLink($inService) {
		echo($this->getBookmarkLink($inService));
	}
}
?>