<?php
/*
 * Created at 29.07.2008
 *
 * @author Markus Moeller - Twick.it
 */
 
/**
 * Vereinfacht eine URL in der Form, dass "/./" entfernt wird und relative
 * Pfade innerhalb der URL ("/../") aufgeloest werden.
 * 
 * @param string inUrl	Die zu vereinfachende URL.
 * @return string Die vereinfachte URL.
 */ 
function simplifyUrl($inUrl) {
	$simply = $inUrl;
	while(contains($simply, "/../")) {
		$simply = substringBeforeLast(substringBefore($simply, "/../"), "/") . "/" . substringAfter($simply, "../");
	}
	$simply = str_replace("./", "", $simply);
	return $simply;
}


/**
 * Sendet einen HTTP-POST-Request.
 * 
 * @param string inHost		Der Host, an den der Request gesendet werden soll. 
 * @param string inPath		Der Pfad des Hosts.
 * @param string inData		Die Daten, die gesendet werden sollen.						
 * @param string inReferer	Der Referer.
 * @param int inPort		Der Port, an den der Request gestellt wird.
 * @return string Die Antwort auf den HTTP-Request.
 */
function sendPostRequest($inHost, $inPath, $inData, $inReferer, $inAuthorization=false, $inPort=80) {
	$result = "";
  	$fp = fsockopen($inHost, $inPort);
  	fputs($fp, "POST $inPath HTTP/1.1\r\n");
  	fputs($fp, "Host: $inHost\r\n");
  	if ($inAuthorization) {
  		fputs($fp, "Authorization: Basic $inAuthorization\r\n");
  	}
  	fputs($fp, "Referer: $inReferer\r\n");
	fputs($fp, "User-Agent: Twick.it\r\n");
  	fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
  	fputs($fp, "Content-length: ". strlen($inData) ."\r\n");
  	fputs($fp, "Connection: close\r\n\r\n");
  	fputs($fp, $inData);
  	while(!feof($fp)) {
    	$result .= fgets($fp, 128);
  	}
  	fclose($fp);

  	return $result;
}


function getPageTitle($inUrl) {
	$url = str_replace("<wbr />", "", $inUrl);
	
	$cache = new Cache();
	$title = $cache->loadFromCache("title_" . $inUrl, 2880);
	if($title == null) {
		$content = getCachedFileContent($url);
		if (mb_detect_encoding($content, "UTF-8, UTF-7, ASCII, EUC-JP,SJIS, eucJP-win, SJIS-win, JIS, ISO-2022-JP, ISO-8859-1, GBK") != "UTF-8") {
			$content = utf8_encode($content);
		}
		// Bei zu langen Texten gibt es Probleme mit der RegEx. Deshalb nur die
		// ersten 200.000 Zeichen ansehen. Sollte reichen :-)
		$content = substr($content, 0, 200000);
		if (preg_match("/<title>(.*?)<\\/title>/si", $content, $title)) {
			$result = trim(str_replace("<", "&lt;", str_replace(">", "&gt;", $title[1]))); // . "[" . mb_detect_encoding($content). "]";
			if ($result == "") {
				$title = truncateString($inUrl, 70, true);
			} else {
				$title = truncateString($result, 100, true);;
			}
		} else {
			$title = truncateString($inUrl, 70, true);
		}
		
		$cache->saveInCache("title_" . $inUrl, $title);
	}
	return $title;
}


function getCachedFileContent($inUrl, $inMaxAge=0, $inTimeout=3) {
	$cache = new Cache();
	$content = $cache->loadFromCache($inUrl, $inMaxAge);
	if ($content == null) {
		$old = ini_set('default_socket_timeout', $inTimeout);
		ini_set("user_agent", "Twick.it");
		if ($stream = fopen($inUrl, 'r')) {
			ini_set('default_socket_timeout', $old);
			stream_set_timeout($stream, $inTimeout);
    		$content = stream_get_contents($stream);
	    	fclose($stream);
		}
		$cache->saveInCache($inUrl, $content);
	}
	return $content;
}


function sendAsynchronousPostRequest($inUrl, $inParameter, $inAuthorization=false) {
    foreach ($inParameter as $key => &$val) {
      	if (is_array($val)) { 
      		$val = implode(',', $val);
      	}
        $params[] = $key . '=' . urlencode($val);
    }
    $post = implode('&', $params);

    $parts = parse_url($inUrl);
    $fp = 
    	fsockopen(
    		$parts['host'],
        	isset($parts['port']) ? $parts['port'] : 80,
        	$errno, 
        	$errstr, 
        	30
        );

    $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
    $out .= "Host: " . $parts['host'] . "\r\n";
    if ($inAuthorization) {
  		$out .= "Authorization: Basic $inAuthorization\r\n";
  	}
    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out .= "Content-Length: " . strlen($post) . "\r\n";
    $out .= "Connection: Close\r\n\r\n";
    if (isset($post)) {
    	$out .= $post;
    }

    fwrite($fp, $out);
    fclose($fp);
}
?>
