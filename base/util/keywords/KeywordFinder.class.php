<?php
/*
 * Created at 24.07.2008
 *
 * @author Markus Moeller - Twick.it
 */
class KeywordFinder {

	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	var $content;
	var $skipNummeric;
	var $minWordLength = array();
	var $minWordOccurrence = array();
	var $blacklist;


	// ---------------------------------------------------------------------
	// ----- Konstruktor ---------------------------------------------------
	// ---------------------------------------------------------------------
    function KeywordFinder($inContent, $inSkipNummeric=true) {
    	$this->content = $inContent;
    	$this->skipNummeric = $inSkipNummeric;
		$this->_initBlacklist();
    }
    
    
    // ---------------------------------------------------------------------
	// ----- Setter --------------------------------------------------------
	// ---------------------------------------------------------------------
	function setMinWordLength($inPhraseLenght, $inMinWordLength) {
		$this->minWordLength[$inPhraseLenght] = $inMinWordLength;
	}
	
	
	function setMinWordOccurrence($inPhraseLenght, $inMinWordOccurrence) {
		$this->minWordOccurrence[$inPhraseLenght] = $inMinWordOccurrence;
	}
	
    
    // ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
  	function getKeywordsAsArray($inUpToPhraseLength=3)	{
    	$keywords = array();
    	for ($i=$inUpToPhraseLength; $i>=1; $i--) {
    		$keywords = array_merge($keywords, $this->_getKeywords($i, array_keys($keywords)));
    	}
    	
    	uasort($keywords, array("KeywordFinder", "_occurenceSort"));
    	return $keywords;
    }
    
    
    // ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
    function _countWords($inPhraseLength, $inAlreadyFound=array())	{
		require_once(DOCUMENT_ROOT . "/util/thirdparty/stemming/StemmingFactory.class.php");
    	$contents = explode("\n", $this->_replaceCharacters($this->content));
    	
    	$occurrence = array();
    	foreach($contents as $content) {
    		$wordsInTwick = array();
			$words = split(" ", $content);		
					
	    	for($i=0; $i<sizeof($words)-($inPhraseLength-1); $i++) {
	    		$process = true;
	    		$word = "";
	    		$separator = "";
	    		
	    		// Phrase zusammensetzen
	    		for ($j=0; $j<$inPhraseLength; $j++) {
	    			$tmpWord = trim($words[$i+$j]);
	    			if(!$this->_filterWord($tmpWord)) {
	    				$process = false;
	    				break;
	    			}
					$word .= $separator . $tmpWord;
					$separator = " ";    			
	    		}
	    		
				if ($process) {
					$minWordLength = getArrayElement($this->minWordLength, $inPhraseLength, 2*$inPhraseLength+$inPhraseLength-1);
					$stemming = StemmingFactory::deepStem($word);
					if (
						mb_strlen($word) >= $minWordLength && 
						!$this->_isInList($stemming, $inAlreadyFound)
					) {
						if (in_array($stemming, $wordsInTwick)) {
							// Wort (besser: Stemming) wurde im selben Twick schon mal verwendet.
							// Nicht doppelt zaehlen, aber nachschauen, welches
							// Wort kuerzer ist.
							if (mb_strlen($word, "utf-8") < mb_strlen($occurrence[$stemming]["word"], "utf-8")) {
								$occurrence[$stemming]["word"] = $word;
							}
						} else {
							// Wort wurde noch nicht im selben Twick verwendet.
							$info = getArrayElement($occurrence, $stemming, array());
							$fullWord = getArrayElement($info, "word", false);
							
							$info["count"] = getArrayElement($info, "count", 0) + 1;
							if ($fullWord === false || mb_strlen($word, "utf-8") < mb_strlen($fullWord, "utf-8")) {
								$info["word"] = $word;
							}
							
		    				$occurrence[$stemming] = $info;
		    				$wordsInTwick[] = $stemming;
						}
					}
				}
	    	}
    	}
    	
    	uasort($occurrence, array("KeywordFinder", "_occurenceSort"));
    	return $occurrence;
    }
    
    
    function _getKeywords($inPhraseLength, $inAlreadyFound=array())	{
    	$occurrence = $this->_countWords($inPhraseLength, $inAlreadyFound);
    	
    	$keywords = array();
		$minWordOccurrence = getArrayElement($this->minWordOccurrence, $inPhraseLength, $inPhraseLength == 1 ? 1 : max(2, 3-$inPhraseLength));
    	foreach($occurrence as $stemming=>$info) {
    		$word = $info["word"];
    		$count = $info["count"];
    		if ($count >= $minWordOccurrence) {
	    		$keywords[$stemming] = array("word"=>$word, "count"=>$count);
    		} else {
    			break;
    		}
    	}
    	
    	return $keywords;
    }
    
    
    function _replaceCharacters($inText) {
    	global $SPECIALCHARS;
		$PUNCTUATIONS = array(',', ')', '(', '.', "'", '"', "„", "“", '<', '>', ';', '!', '?', '/', '-', '_', '[', ']', ':', '+', '=', '*', '#', '$', '%', '&quot;', '&copy;', '&gt;', '&lt;', chr(9), "&#8216;", "&#8217;", "&#8242;", "&#039;", "&#8220;", "&#8221;", "&#8243;", "&#034;");
		$text = mb_strtolower($inText, "UTF-8");
    	$text = strip_tags($text);
    	$text = @html_entity_decode($text, ENT_QUOTES, "UTF-8");
		$text = str_replace($PUNCTUATIONS, " ", $text);
		foreach($SPECIALCHARS as $specialChar) {
			$text = str_replace($specialChar, " $specialChar ", $text);
		}
		
		$text = preg_replace('/ {2,}/si', " ", $text);
		
		return $text;    	
    }
    
    
    function _filterWord($inWord) {
    	return !($this->skipNummeric && is_numeric($inWord) || in_array($inWord, $this->blacklist));
    }
    
    
    function _isInList($inWord, $inList) {
    	foreach($inList as $word) {
    		if (contains($word, " $inWord") || contains($word, "$inWord ")) {
    			return true;
    		}
    	}	
    	return false;
    }
    
    
    function _initBlacklist() {
    	include(DOCUMENT_ROOT . "/lang/" . getLanguage() . "/stopwords.php");
    	$this->blacklist = $STOPWORDS; 
    }
    
    
    function _occurenceSort($inData1, $inData2) {
    	$count1 = getArrayElement($inData1, "count");
    	$count2 = getArrayElement($inData2, "count");
    	return $count2-$count1;
    }
}

if(!function_exists("mb_internal_encoding")) {
	function mb_internal_encoding() {}
	
	function mb_strlen($inLength, $inEncoding="") {
		return strlen($inLength);
	}
	
	function mb_strtolower($inString, $inEncoding="") {
		return strtolower($inString);
	}
}
?>