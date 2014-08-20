<?php
class TwickitPathFinder {
	
	var $source;
	var $destination;
	var $maxDepth;
	var $visited = array();
	var $queue = array();
	
	
	function TwickitPathFinder($inSource, $inDestination, $inMaxDepth=10) {
		$this->source = $inSource;
		$this->destination = $inDestination;
		$this->maxDepth = $inMaxDepth;
	}
	
	
	function findPath($inTopic=false, $inPath=array()) {
		$topic = $inTopic !== false ? $inTopic : $this->source;
		$topic = mb_strtolower($topic, "UTF-8");
		$path = $inPath;
		$path[] = $topic;
		
		if (sizeof($path) > $this->maxDepth) {
			return array();  // Don't go to deep! Otherwise we will never stop in some cases!
		}
		
		if (mb_strtolower($topic, "UTF-8") == mb_strtolower($this->destination, "UTF-8")) {
			return $path;
		} 
		
		$this->visited[] = $topic; 
		$tags = $this->_findTags($topic);
		foreach($tags as $tag) {
			$tag = strtolower($tag);
			if (!in_array($tag, $this->visited)) {
				$this->queue[] = array($tag, $path);
			}
		}
		
		if(sizeof($this->queue)) {
			$next = array_shift($this->queue);
			return $this->findPath($next[0], $next[1]);
		}
	}
	
	
	function _findTags($inTopic) {
		$tags = array();		
		$xml = @simplexml_load_file("http://twick.it/interfaces/api/explain.xml?search=" . urlencode($inTopic));
		if ($xml && $xml->topics->children()) {
			foreach($xml->topics->children() as $topic) {
				foreach($topic->tags->children() as $tag) {
					$tags[] = (string)$tag;
				}
			}
		}
		return $tags;
	}
}
?>