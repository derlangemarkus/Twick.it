<?php
function getRandomWikipediaEntry($inLanguage=false) {
	try {
		if ($inLanguage) {
			$language = $inLanguage;
		} else {
			$language = getLanguage();
		}
		ini_set('user_agent', 'Twick.it');
		$xml = getCachedFileContent("http://" . $language . ".wikipedia.org/w/api.php?action=query&list=random&rnnamespace=0&rnlimit=1&format=xml", 1, 2);
	
		$wikipedia = simplexml_load_string($xml);	
		return (string)$wikipedia->query->random->page->attributes()->title[0];
	} catch(Exception $ignored) {
		return null;
	}
}


function getWikipediaEntry($inTitle, $inLanguage=false) {
	try {
        $language = $inLanguage === false ? getLanguage() : $inLanguage;
		ini_set('user_agent', 'Twick.it');

		$xml = getCachedFileContent("http://" . $language . ".wikipedia.org/w/api.php?action=query&prop=revisions&titles=" . urlencode($inTitle) . "&rvprop=content&format=xml", 7200, 2);

		$wikipedia = simplexml_load_string($xml);
		return (string)$wikipedia->query->pages->page->revisions->rev;
	} catch(Exception $ignored) {
		return null;
	}
}


function getWikipediaSuggestion($inTitle, $inLanguage=false) {
	try {
		if ($inLanguage) {
			$language = $inLanguage;
		} else {
			$language = getLanguage();
		}
		ini_set('user_agent', 'Twick.it');
		$xml = getCachedFileContent("http://" . $language . ".wikipedia.org/w/api.php?action=opensearch&search=" . urlencode($inTitle) . "&format=xml", 1440, 2);
	
		$wikipedia = simplexml_load_string($xml);	
		return $wikipedia->Section;
	} catch(Exception $ignored) {
		return null;
	}
}


function getFirstWikipediaSuggestion($inTitle, $inLanguage=false) {
	$suggestion = getWikipediaSuggestion($inTitle, $inLanguage);
	$items = $suggestion->Item;
		
	return is_array($items) ? $items[0] : $items;
}


function getWikipediaSpellSuggestions($inTitle, $inLanguage=false) {
	$suggestion = getWikipediaSuggestion($inTitle, $inLanguage);
	if (!$suggestion) {
		return array();
	}	
	$items = $suggestion->children();
	
	$result = array();
	if ($items) {
		foreach($items as $item) {
			$title = $item->Text;
			if(strtolower($title) != strtolower($inTitle) && !contains($title, "(Begriffsklärung)")) {
				$result[(string)$title] = $item->Link;
			}
		}
	}
	return $result;
}


function getWikipediaHomonymSuggestions($inTitle, $inLanguage=false) {
	$suggestion = getWikipediaSuggestion(getCoreTitle($inTitle) . " (", $inLanguage);
	$items = $suggestion->children();
	
	$result = array();
	if ($items) {
		foreach($items as $item) {
			$title = $item->Text;
			$matches = array();
			if(preg_match('/^(.+)\s+\((.+)\)$/i', $title, $matches) && $matches[2] != "Begriffsklärung") {
				$result[] = $matches[2];
			}
		}
	}
	return $result;
}


function correctCapitalization($inTitle, $inLanguage=false) {
	try {
		$item = getFirstWikipediaSuggestion($inTitle, $inLanguage);
		$title = $item->Text;
		
		if (strtolower($title) == strtolower($inTitle)) {
			return (string)$title;
		} else {
			return $inTitle;
		}
	} catch(Exception $e) {
		return $inTitle;
	}
}
?>