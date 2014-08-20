<?php
/**
 * @copyright  Copyright 2010 metaio GmbH. All rights reserved.
 * @link       http://www.metaio.com
 * @author     Bernhard Heindl
 **/

// Set Zend Framework include path
set_include_path(
	implode(
		PATH_SEPARATOR,
		array(
			get_include_path(),
		)
	)
);

require_once '../config/config.php';
require_once 'Zend/Http/Client.php';

setlocale(LC_TIME, array('en_US.UTF-8', 'en_US.UTF8','en.UTF8','en.UTF-8', "En-Us"));

class JunaioApiClient {

	/**
	 * Execute request
	 * 
	 * @param $sUrl
	 * @param $sMethod
	 * @param $aParams
	 * @param $aAuth
	 * @param $aFiles
	 * @return Zend_Http_Response
	 */
	public function request($sUrl, $sMethod = 'GET', $aParams = array(), $aAuth = array(), $aFiles = array()) {

		// Instantiate http client
		$oClient = new Zend_Http_Client();

		// Determine request method
		switch ($sMethod) {
			case 'DELETE':
				$iMethod = Zend_Http_Client::DELETE;
				break;
			case 'POST':
				$iMethod = Zend_Http_Client::POST;
				break;
			case 'GET':
			default:
				$iMethod = Zend_Http_Client::GET;
				break;
		}

		// Set GET-Parameter
		if (!empty($aParams) && $iMethod === Zend_Http_Client::GET) {
			$aTokens = array();
			foreach ($aParams as $sKey => $mValue) {
				$aTokens[] = $sKey . '=' . $mValue;
			}
			$sUrl .= '?' . implode('&', $aTokens);
		}

		// Set POST-Parameter
		if (!empty($aParams) && $iMethod === Zend_Http_Client::POST) {
			foreach ($aParams as $sKey => $mParam) {
				$oClient->setParameterPost($sKey, $mParam);
			}
		}

		// Set files
		if (!empty($aFiles) && $iMethod === Zend_Http_Client::POST) {
			foreach ($aFiles as $sKey => $sFile) {
				$oClient->setFileUpload($sFile, $sKey);
			}
		}

		// Set authentication header
		if (!empty($aAuth)) {
			foreach ($aAuth as $sUser => $sPassword) {

				$sDate = strftime('%a, %d %b %Y %H:%M:%S GMT');
				$oClient->setHeaders('Date', $sDate);

				$sAccessKey = base64_encode(md5($sUser));
				$sSignatureString = base64_encode(md5(
					mb_convert_case(md5($sPassword), MB_CASE_LOWER) . "\n" .
					$iMethod . "\n" .
					$sUrl . "\n" .
					'Date: ' . $sDate . "\n"
				));

				$oClient->setHeaders('Authorization', 'metaioWorld ' . $sAccessKey . ':' . $sSignatureString);

			}
		}

		$oClient->setUri(JUNAIO_API_HOST . $sUrl);
		
		return $oClient->request($iMethod);

	}

}