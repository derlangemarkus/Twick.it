<?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Bernhard Heindl
 **/

class Junaio {

	public static function checkAuthentication() {

		$_HEADERS = getallheaders();
		
		// Check if authorization header is there
		if (!isset($_HEADERS['Authorization'])) {
			return FALSE;
		}
		$sAuthentication = $_HEADERS['Authorization'];

		// Check if authorization header is of "junaio" type
		if(strpos($sAuthentication, 'junaio') != 0) {
			return FALSE;
		}

		// Check date header
		$sDate = $_HEADERS['Date'];
		$iParsedDate = strtotime($sDate);
		$iNow = time();
		if($iParsedDate < $iNow - AUTH_DATE_TOLERANCE || $iParsedDate > $iNow + AUTH_DATE_TOLERANCE) {
			// Header is outdated
			return FALSE;
		}

		// Prepare signature variables
		$aTokens = explode(' ', $sAuthentication);
		if (!isset($aTokens[1]) || trim($aTokens[1]) == '') {
			// No signature string there
			return FALSE;
		}
		$sRequestSignature = base64_decode(trim($aTokens[1]));

		// Build server request signature
		$sServerRequestSignature = sha1(
			JUNAIO_KEY . sha1(
				JUNAIO_KEY .
				$_SERVER['REQUEST_METHOD'] . "\n" .
				$_SERVER['REQUEST_URI'] . "\n" .
				'Date: ' . $sDate . "\n"
			)
		);

		// Compare request signature
		if(strcmp($sRequestSignature, $sServerRequestSignature) !== 0) {
			// Incorrect authentication
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

if (!function_exists('getallheaders'))
{
    function getallheaders()
    {
       foreach ($_SERVER as $name => $value)
       {
           if (substr($name, 0, 5) == 'HTTP_')
           {
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
           }
       }
       return $headers;
    }
}