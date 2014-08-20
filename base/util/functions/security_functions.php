<?php
// {{{ array_func()

/**
 * Wendet Funktionen auf Strings UND komplette Arrays an
 *
 * @param string $func Funktionsname
 * @param var	 &$var  String- oder Array-Variabel
 */
function array_func($func, &$var)
{
	if(is_string($var)) {
		$var = $func($var);
	} else {
		if(is_array($var)) {
			foreach($var AS $key => $value) {
				array_func($var[$key]);
			}
		}
	}
}

// }}}
// {{{ sec_start()

/**
 * Führt auf alle Benutzer-Eingaben die Funktionen trim und
 * falls magic_quotes_gpc aus ist auch stripslashes an
 */
function sec_start()
{
	array_func('trim', $_GET);
	array_func('trim', $_POST);
	array_func('trim', $_COOKIE);

	if(get_magic_quotes_gpc()) {
		array_func('stripslashes', $_GET);
		array_func('stripslashes', $_POST);
		array_func('stripslashes', $_COOKIE);
	}
}

// }}}
// {{{ sec_output()

/**
 * Sichert Benutzer-Inputs gegen XSS bei Outputs ab
 *
 * @param	var	&$input	Variable mit dem Benutzer-Input
 *
 * @return	var	Gibt den gegen XSS geschützte Benutzer-Input zurück
 */
function sec_output(&$input)
{
	$input = htmlentities(strip_tags($input), ENT_QUOTES);
	return $input;
}

// }}}
// {{{ sec_mysql_input()

/**
 * Sichert Benutzer-Inputs gegen SQL-Injection bei SQL-Abfragen ab
 *
 * @param	var	&$input	Variable mit dem Benutzer-Input
 *
 * @return	var	Gibt den gegen SQL-Injection geschützte Benutzer-Input zurück
 */
function sec_mysql_input($input)
{
	$db =& DB::getInstance();
	$input = $db->realEscapeString($input);
	
	return $input;
}
?>