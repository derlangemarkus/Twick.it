<?php
class StemmingFactory {

	public static function getStemmer($inLanguage=false) {
		$language = $inLanguage !== false ? $inLanguage : getLanguage();
		switch($language) {
			default:
				require_once(DOCUMENT_ROOT . "/util/thirdparty/stemming/PorterStemmer_de.php");
				return new PorterStemmer_de();
		}
	}
	
	
	public static function stem($inWord, $inLanguage=false) {
		$stemmer = StemmingFactory::getStemmer($inLanguage);
		return $stemmer->stem(getCoreTitle($inWord));
	}
	
	
	public static function deepStem($inWord, $inLanguage=false) {
		$stemmer = StemmingFactory::getStemmer($inLanguage);
		
		$result = "";
		$separator = "";
		foreach(explode(" ", $inWord) as $word) {
			$result .= $separator . $stemmer->stem(getCoreTitle($word));
			$separator = " ";
		}
		return $result;
	}
}
?>