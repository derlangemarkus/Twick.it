<?php
/**
 *
 * Das Modul Cache ermöglicht das Cachen von Funktionsaufrufen.
 * Hierbei werden die Ergebnisse der Funktionen persistent in einer Datei gespeichert.
 * Der Cache hat eine vorgegebene Gültigkeit unnd kann so in frei definierbaren Abständen
 * aktualisiert werden.
 * Beim Modul Cache liegt das Augenmerk auf hoher Performance und einfache API für den
 * Entwickler.
 *
 * Name: PHP Cache
 * Version: 1.0
 * Autor: Michael Jentsch <M.Jentsch@web.de>
 * Webseite: http://www.m-software.de/
 * Lizenz: LGPL 2.0
 *
 **/

class Cache {

	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 * Maximales Alter einer Cache Datei in Sekunden wenn nicht anders angegeben
	 **/
	var $maxage = 1440; // = 1 Tag

	/**
	 * In diesem Vereichnis werden die Cachefiles abgelegt
	 **/
	var $cachedir;

	/**
	 * Endung der Cache Dateien
	 **/
	var $suffix = ".cache";


	// ---------------------------------------------------------------------
	// ----- Konstruktor ---------------------------------------------------
	// ---------------------------------------------------------------------
	function Cache() {
		$this->cachedir = DOCUMENT_ROOT . "/writable/cache";
	}


	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	function getCachedValue($inKey, $age = 0) {
		$cache = new Cache();
		return $cache->loadFromCache($inKey, $age);
	}
	
	
	/**
	 * Mit dieser Funktion wird eine belibige Variable im Cache gespeichert
	 * Folgende typen werden unterstützt
	 *  . array
	 *  . double
	 *  . integer
	 *  . object
	 *  . string
	 *
	 * Parameter:
	 *	String name => Über diese Variable wird ein Cache File eindeutig identifiziert
	 *	Mixed value => Diese Variable wird im Cache gespeichert. Hierbei kann es sich um einen der
	 * 		       folgenden Typen handeln. (array, double, integer, object, string)
	 *
	 * Return:
	 *	boolean  => true wenn erflogreich gespeichert
	 *
	 **/
	function saveInCache ($name, $value) {
		$file = $this->_getFilename($name);
		// unlink ($file);
		$data = $this->_var2string ($value);
		return $this->_saveData ($file, $data);
	}


	function reset($inName) {
		$file = $this->_getFilename($inName);
		if (file_exists($file)) {
			unlink($file);
		}
	}


	/**
	 * Mit dieser Funktion wird eine vorher gespeicherte Variable aus dem Cache geladen
	 * Folgende typen werden unterstützt
	 *  . array
	 *  . double
	 *  . integer
	 *  . object
	 *  . string
	 *
	 * Parameter:
	 *	String name => Über diese Variable wird ein Cache File eindeutig identifiziert
	 *	Integer age => Optionaler Parameter, mit dem man den Wert maxage übersteuern kann.
	 *
	 * Return:
	 *	Mixed => Die Variable aus dem Cache (z.B. ein array oder ein string)
	 *
	 **/
	function loadFromCache ($name, $age = 0) {
		if (DISABLE_CACHE) {
			return null;
		}
		if ($age == 0) {
			$age = $this->maxage;
		}
		$file = $this->_getFilename($name);
		$cacheAge = $this->getCacheAge($name);
		if ($cacheAge > 0 && $cacheAge < $age) {
			$data = $this->_loadData($file);
			$value = $this->_string2var($data);
		} else {
			$value = false;
			$this->reset($name);
		}
		return $value;
	}


	function exists($inName, $inAge=0) {
		if ($inAge == 0) {
			$inAge = $this->maxage;
		}
		$file = $this->_getFilename($inName);
		return file_exists($file) && $this->getCacheAge($inName) < $inAge;
	}


	/**
	 * Diese Funktion ermittelt das Alter der Datei in Sekunden
	 *
	 * Parameter:
	 *	String => Name des Variable im Cache
	 *
	 * Return:
	 *	Integer value => Alter der Cache Datei in Sekunden
	 *
	 **/
	function getCacheAge ($name) {
		$now = time ();
		$file = $this->_getFilename($name);
		if (!file_exists($file)) {
			return -1;
		}
		$time = filemtime($file);
		$age = $now - $time;
		if ($age < 0) $age = 0;
		return intval ($age);

	}


	function clearCacheDir() {
		if($dir = opendir($this->cachedir)) {
	 		while($file=readdir($dir)) {
	 			if ($file != ".." && $file != ".") {
			  		$result = unlink($this->cachedir . "/" . $file);
	 			}
		 	}
			closedir($dir);
		}
	}


	function getCacheFiles() {
		$result = array();
		if($dir = opendir($this->cachedir)) {
	 		while($file=readdir($dir)) {
	 			if ($file != ".." && $file != ".") {
			  		array_push($result, $file);
	 			}
		 	}
			closedir($dir);
		}
		return $result;
	}


	function setMaxAge($inMaxAge) {
		$this->maxage = $inMaxAge;
	}


	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 * Diese Funktion wandelt einen String in eine bel. Variable um
	 *
	 * Parameter:
	 *	String => Inhalt der Variable als String
	 *
	 * Return:
	 *	Mixed value => Diese Variable wird aus dem String erzeugt
	 *
	 **/
	function _string2var ($data) {
		$value = @unserialize($data);
		return $value;
	}


	/**
	 * Diese Funktion wandelt eine bel. Variable in einen String um
	 *
	 * Parameter:
	 *	Mixed value => Diese Variable wird im einen String umgewandelt
	 *
	 * Return:
	 *	String => Inhalt der Variable als String
	 *
	 **/
	function _var2string ($value) {
		$data = serialize($value);
		return $data;
	}


	/**
	 * Diese Funktion erzeugt den Dateinamen für die Identifikation des Cache
	 *
	 * Parameter:
	 *	String name => Name unter dem die Daten im Cache gespeichert werden sollen
	 *
	 * Return:
	 *	String => Dateiname für die Identifikation der Cache Datei
	 *
	 **/
	function _getFilename ($name) {
		$crc = str_replace("-", "_" , crc32($name));
		$md5 = md5($name);
		
		$filename = $crc . "_" . $md5;
		
		$dir1 = substr($filename, 0, 2);
		if(!file_exists($this->cachedir . "/" . $dir1)) {
			mkdir($this->cachedir . "/" . $dir1, 0777);
			chmod($this->cachedir . "/" . $dir1, 0777);
		}
		$dir2 = substr($filename, 2, 2);
		if(!file_exists($this->cachedir . "/" . $dir1 . "/" . $dir2)) {
			mkdir($this->cachedir . "/" . $dir1 . "/" . $dir2, 0777);
			chmod($this->cachedir . "/" . $dir1 . "/" . $dir2, 0777);
		}
		
		return $this->cachedir . "/" . $dir1 . "/" . $dir2 . "/" . $filename . $this->suffix;
	}


	/**
	 * Diese Funktion speichert die Daten im Cachedir
	 *
	 * Parameter:
	 *	String file => Dateiname unter dem die Daten im Cache gespeichert werden sollen
	 *	String value => In einem String gespeicherte Daten der zu sichernden Variable
	 *
	 * Return:
	 *	boolean  => true wenn erflogreich gespeichert
	 *
	 **/
	function _saveData($file, $value) {
		$ret = false;
		$fp = fopen($file,"w");
		fwrite($fp,$value);
		fclose($fp);
		return $ret;
	}


	/**
	 * Diese Funktion lädt die Daten aus dem Cachedir
	 *
	 * Parameter:
	 *	String file => Dateiname unter dem die Daten im Cache vorliegen muss
	 *
	 * Return:
	 *	string  => String Inhalt des Cache
	 *
	 **/
	function _loadData($file) {
        $fp = fopen($file,"r");
		$data = fread($fp, filesize($file));
        fclose($fp);
		return $data;
	}
}

?>
