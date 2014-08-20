<?php
/*
 * Created at 28.11.2008
 *
 * @author Markus Moeller - Twick.it
 */


/**
 * Suche in den im Browser eingestellten Lieblings-Sprachen nach einer 
 * installierten Backend-Sprache. Sind mehrere Lieblings-Sprachen im CMS
 * installiert, wird diejenige zurueckgegeben, die im Browser am hoechsten
 * eingestufft wurde. Wurden keine Uebereinstimmungen zwischen Browser-Sprachen
 * und CMS-Sprachen gefunden, wird null zurueckgegeben.
 * 
 * @return string 	Sprachcode der gefundenen Libelings-Sprache bzw. null bei 
 * 					keinem Treffer.
 */
function getPreferredBrowserLanguage() {
    if (empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    	return null;  // Keine Sprachinformationen vom Browser
    }

    // Den Header auftrennen
    $acceptLanguagesFromBrowser = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

    // Die Standardwerte einstellen
    $currentLanguage = null;
    $currentLanguageQualitiy = 0;

    // Nun alle mitgegebenen Sprachen abarbeiten
    foreach ($acceptLanguagesFromBrowser as $acceptLanguageFromBrowser) {
        // Alle Infos über diese Sprache rausholen
        $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)'.
                           '(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $acceptLanguageFromBrowser, $matches);

        // war die Syntax gültig?
        if (!$res) {
            // Nein? Dann ignorieren
            continue;
        }
        
        // Sprachcode holen und dann sofort in die Einzelteile trennen
        $langCode = explode ('-', $matches[1]);

        // Wurde eine Qualität mitgegeben?
        if (isset($matches[2])) {
            // die Qualität benutzen
            $langQuality = (float)$matches[2];
        } else {
            // Als Standard-Qualität 1 annehmen
            $langQuality = 1.0;
        }

        // Bis der Sprachcode leer ist...
        while (count ($langCode)) {
            // mal sehen, ob der Sprachcode angeboten wird
            $tmp = strtolower (join ('-', $langCode));
            if (isLanguageInstalled($tmp)) {
                // Qualität anschauen
                if ($langQuality > $currentLanguageQualitiy) {
                    // diese Sprache verwenden
                    $currentLanguage = $tmp;
                    $currentLanguageQualitiy = $langQuality;
                    // Hier die innere while-Schleife verlassen
                    break;
                }
            }

            // den rechtesten Teil des Sprachcodes abschneiden
            array_pop ($langCode);
        }
    }

    // die gefundene Sprache zurückgeben
    return $currentLanguage;
}


/**
 * Liefert einen lokalisierten Text. Es koennen Platzhalter
 * verwendet werden. So kann in der Sprachdatei mit {1} auf den ersten
 * Platzhalter, mit {2} auf den zweiten Platzhalter usw. verwiesen werden.
 * Die Platzhalter werden der Methode in einem Array uebergeben. Gibt es
 * nur einen Platzhalter, kann er direkt (ohne Array) uebergeben werden.
 * 
 * @param string inTextKey 		Der Name des Textes.
 * @param mixed inPlaceholders	Platzhalter, die in den Text eingebettet 
 * 								werden sollen.
 * @see loc()
 */
function _loc($inTextKey, $inPlaceholders=false) {
	global $TEXT;
	if (isset($TEXT[$inTextKey])) {
		$text = $TEXT[$inTextKey];
		if ($inPlaceholders!==false) {
			if (is_array($inPlaceholders)) {
				for($i=1; $i<=sizeof($inPlaceholders); $i++) {
					$text = str_replace("{" . $i . "}", $inPlaceholders[$i-1], $text);
				}
			} else {
				$text = str_replace("{1}", $inPlaceholders, $text);
			}		
		}
		
		if (isset($_GET["translationmode"])) {
			$text = "[$inTextKey]$text";
		}
		
		return $text;
	} else {
		return $inTextKey;
	}	
}


/**
 * Gibt einen lokalisierten Backend-Text aus. Es koennen Platzhalter
 * verwendet werden. So kann in der Sprachdatei mit {1} auf den ersten
 * Platzhalter, mit {2} auf den zweiten Platzhalter usw. verwiesen werden.
 * Die Platzhalter werden der Methode in einem Array uebergeben. Gibt es
 * nur einen Platzhalter, kann er direkt (ohne Array) uebergeben werden.
 * 
 * @param string inTextKey 		Der Name des Textes.
 * @param mixed inPlaceholders	Platzhalter, die in den Text eingebettet 
 * 								werden sollen.
 * @see _loc()
 */
function loc($inTextKey, $inPlaceholders=false) {
	echo(_loc($inTextKey, $inPlaceholders));
}


/**
 * Inkludiert die Sprachdatei der aktuellen Backend-Sprache. 
 * 
 * @param string inDir	Verzeichnis, in dem die Sprachdateien abgelegt wurden.
 */
function includeLanguageFile($inDir="lang") {
	// Deutsch immer einspielen. Ist am vollstaendigsten
	_includeLanguageFileIfExists(DOCUMENT_ROOT . "/$inDir/de/lang.php");
	_includeLanguageFileIfExists(DOCUMENT_ROOT . "/$inDir/de/blacklist.php");
	
	// Dann die gewuenschte Datei einspielen. Als Fallback sicherheitshalber auch Englisch einbinden.
	$lng = getLanguage();
	if ($lng != DEFAULT_LANGUAGE) {
		_includeLanguageFileIfExists(DOCUMENT_ROOT . "/$inDir/en/lang.php");
		_includeLanguageFileIfExists(DOCUMENT_ROOT . "/$inDir/en/blacklist.php");
		_includeLanguageFileIfExists(DOCUMENT_ROOT . "/$inDir/" . $lng . "/lang.php");
		_includeLanguageFileIfExists(DOCUMENT_ROOT . "/$inDir/" . $lng . "/blacklist.php");
	}
}


/**
 * Liefert den Code der Backend-Sprache. Dabei wird zunaechst
 * uberprueft, ob die Sprache in einem Cookie abgelegt wurde. Ist das nicht 
 * der Fall, wird in der Session nachgeschaut. Wird auch hier nichts gefunden,
 * wird ueberprueft, ob eine im Browser konfigurierte Lieblings-Sprache im
 * CMS installiert ist. Gibt es auch hier keine Treffer, wird die Default-Sprache
 * (DEFAULT_BACKEND_LANGUAGE aus der config.php) zurueckgeliefert.
 * 
 * @return string Code der Backend-Sprache.
 */
function getLanguage() {
	if ($lng = getArrayElement($_GET, "lng")) {
		return setLanguage(strtolower($lng));
	} else {
		$cookie = getArrayElement($_COOKIE, "lng");
		if ($cookie && isLanguageInstalled($cookie)) {
			// Zuerst nach Cookie suchen
			$_SESSION["lng"] = $cookie;
			return $cookie;
		}

		$session = getArrayElement($_SESSION, "lng");
        if ($session && isLanguageInstalled($session)) {
			// Dann die Session-Information verwenden
			return $session;
		}

		$browser = getPreferredBrowserLanguage();
        if ($browser && isLanguageInstalled($browser)) {
			// Liefert der Browser die Lieblings-Sprache?
			return $browser;
		}

        // Wenn gar keine Information ueber die gewuenschte Sprache gefunden wurde,
        // wird die Default-Sprache verwendet.
		return DEFAULT_LANGUAGE;
	}
}


function setLanguage($inLanguage, $inIncludeLanguageFile=false) {
	if(isLanguageInstalled($inLanguage)) {
		$_SESSION["lng"] = $inLanguage;
		$_COOKIE["lng"] = $inLanguage;
		
		if ($inIncludeLanguageFile) {
			includeLanguageFile();
		}
		return $inLanguage;
	}
}

/**
 * Ueberprueft, ob eine Sprache installiert ist.
 * 
 * @param string inLanguage	Der Code der zu ueberpruefenden Sprache.
 * @param bool true, wenn die Sprache installiert ist. 
 */
function isLanguageInstalled($inLanguage) {
	global $languages;
	foreach($languages as $language) {
		if($language["code"] == $inLanguage) {
			return true;
		} 
	}
	return false;
} 


/**
 * Inkludiert eine Sprachdatei, falls sie existiert.
 * 
 * @param string inFile Der Dateiname der Sprachdatei.
 */
function _includeLanguageFileIfExists($inFile) {
	global $TEXT, $BLACKLIST;
	if (file_exists($inFile)) {
		require($inFile);
	}
}
?>
