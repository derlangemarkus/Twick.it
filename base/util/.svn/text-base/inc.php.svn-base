<?php
ini_set('display_errors', 1);

if (get_magic_quotes_gpc()) {
    if(!function_exists("stripslashes_deep")) {
		function stripslashes_deep($value) {
	        $value = is_array($value) ?
	                    array_map('stripslashes_deep', $value) :
	                    stripslashes($value);
	
	        return $value;
	    }
    }
    
    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}

if (!defined("CONTEXT_PATH")) {
	function _substringBetween($inText, $inStartDelimiter, $inEndDelimiter) {
		$startIndex = strpos($inText, $inStartDelimiter) + strlen($inStartDelimiter);
		$endIndex = strpos($inText, $inEndDelimiter, $startIndex);
	
		if (!$endIndex || !$startIndex) {
			return "";
		} else {
			return substr($inText, $startIndex, $endIndex-$startIndex);
		}
	}
	
	if (strpos($_SERVER["DOCUMENT_ROOT"], "\\") === false) {
		$dirSeparator = "/";	// Unix
	} else {
		$dirSeparator = "\\";	// Windows
	}

	$tmp = _substringBetween($_SERVER["SCRIPT_FILENAME"], $_SERVER["DOCUMENT_ROOT"], $dirSeparator . "base");
	if (!$tmp && strpos($_SERVER["SCRIPT_NAME"], $dirSeparator . "base") === false) {
		$tmp = _substringBetween($_SERVER["SCRIPT_FILENAME"], $_SERVER["DOCUMENT_ROOT"], $dirSeparator . "blog");
		
		//$tmp = _substringBetween($_SERVER["SCRIPT_FILENAME"], $_SERVER["DOCUMENT_ROOT"], $dirSeparator . "index.php");
		if ($tmp == '\base' || $tmp == '/base') {
			$tmp = "";
		}
	}

	$contextPath = str_replace("\\", "/", str_replace("\\\\", "/", $tmp));
	if (substr($contextPath, strlen($contextPath)-1) === "/") {
		$contextPath = substr($contextPath, 0, strlen($contextPath)-1);
	}
	
	define("CONTEXT_PATH" , $contextPath);
}

if (!defined("DOCUMENT_ROOT")) {
	define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"] . CONTEXT_PATH . "/base");
}

define("HTTP_ROOT" , "http://" . $_SERVER["SERVER_NAME"] . CONTEXT_PATH);

session_start();
function twickitErrorHandler($inNumber, $inMessage, $inFile, $inLine, $inContext) {
	throw new Exception($inMessage . " in $inFile:$inLine", $inNumber);
}
set_error_handler("twickitErrorHandler", E_ALL - E_NOTICE);

$footerContent = "";
if(isset($_GET["apc"])) {
	apc_clear_cache();
}

require_once(DOCUMENT_ROOT . '/util/config.php');
ini_set('display_errors', DISPLAY_ERRORS);
error_reporting(E_ALL ^ E_NOTICE);

require_once(DOCUMENT_ROOT . '/util/constants.php');

set_include_path(
	get_include_path() . 
	PATH_SEPARATOR . DOCUMENT_ROOT . "/entity" .
	PATH_SEPARATOR . DOCUMENT_ROOT . "/util" . 
	PATH_SEPARATOR . DOCUMENT_ROOT . "/util/thirdparty/cache" .
	PATH_SEPARATOR . DOCUMENT_ROOT . "/util/thirdparty/phpmailer" .
	PATH_SEPARATOR . DOCUMENT_ROOT . "/util/thirdparty/fsbb" 
);
spl_autoload_extensions('.class.php');
spl_autoload_register();

if(isset($_GET["msg"]) && $_GET["msg"] == "login.logout") {
	setcookie("twickit_token", "", time(), "/");
	unset($_COOKIE["twickit_token"]);
}

require_once(DOCUMENT_ROOT . '/util/functions/package_inc.php');

$TEXT = array();
$language = getLanguage();

includeLanguageFile();
//define("STATIC_ROOT" , "http://" . STATIC_SUBDOMAIN . $_SERVER["SERVER_NAME"] . CONTEXT_PATH);
//define("STATIC_ROOT" , "http://www.explain-engine.com/" . CONTEXT_PATH);
define("STATIC_ROOT" , "http://static.twick.it");
?>
