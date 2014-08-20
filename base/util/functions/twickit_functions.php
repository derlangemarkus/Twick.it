<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
function externReferrer() {
	if(isset($_SERVER["HTTP_REFERER"])) {
		$referrer = parse_url($_SERVER["HTTP_REFERER"]);
		return $referrer && !isLoggedIn() && (getArrayElement($_GET, "ext") || !in_array($referrer["host"], array("twick.it", "m.twick.it", "test.twick.it", "erklaermaschine.de", "explainengine.com", "twickit.de", "localhost")));
	} else {
		return $_SERVER["REQUEST_URI"] != "/" && !isset($_GET["new"]) && !isLoggedIn();
	}
}
 
 
function rewriteAmazonLinks($inLink) {
    if($inLink && startsWith($inLink, "http://www.amazon.de") && !contains($inLink, "creative=")) {
        $link = $inLink;
        if (contains($link, "ref=")) {
            $link = substringBefore($link, "ref=") . substringAfter($link, "?");
        }
        return "http://www.amazon.de/gp/redirect.html?ie=UTF8&location=" . urlencode($link) . "&site-redirect=de&tag=wwwtwickitde-21&linkCode=ur2&camp=1638&creative=6742";
    } else {
        return $inLink;
    }
}


function containsBlacklistWords($inText) {
	global $BLACKLIST;
	$text = strtolower($inText);
	foreach($BLACKLIST as $blacklistWord) {
		if (preg_match('/\b' . strtolower($blacklistWord) . '\b/i', $text)) {
			return true;
		}
	}	
	return false;
}


function printXMLHeader() {
	echo("<" . "?xml version=\"1.0\" encoding=\"utf-8\"?" . ">");
}


function createSeoUrl($inTitle, $inLanguageCode="") {
	$siteName = convertForUrl($inTitle);
	
	if ($inLanguageCode) {
		return $inLanguageCode . "/" . $siteName;
	} else {
		return $siteName;
	}
}


function convertForUrl($inTitle) {
	$siteName = trim($inTitle);
	$siteName = mapUnicodeToAscii($siteName);
	//$siteName = htmlentities($siteName);
	$replace = array(
					" "=>"-", 
					"/"=>"-", 
					"+"=>"_", 
					"#"=>"-", 
					"*"=>"-",
					"\\"=>"-",
					"?"=>"", 
					"!"=>"", 
					"."=>"", 
					","=>"", 
					";"=>"",
					":"=>"",  
					"'"=>"",  
					'"'=>"", 
					"&"=>"-"
				);
	$siteName = strtr($siteName, $replace);
	$siteName = trim($siteName, "-");
	$siteName = str_replace("--", "-", $siteName);
	
	$siteName = truncateString($siteName, 100, false, "");
	
	return $siteName;
}


function custombase_convert($str, $basesrc, $basedst) {
  $lensrc=strlen($basesrc);
  $lendst=strlen($basedst);

  $val=0;
  for($i=0;$i<strlen($str);$i++) {
    $val=bcadd($val,bcmul(strpos($basesrc,substr($str,$i,1)),bcpow($lensrc,strlen($str)-1-$i)));
  }

  $i=0;
  while(1) {
    $nb=bcpow($lendst,$i);
    if(bcsub($val,$nb)<0) {
      $i--;
      break;
    }
    $i++;
  }
  $powmax=$i;

  $result="";
  $reste=$val;

  for($i=$powmax;$i>=0;$i--) {
    $j=$lendst-1;
    while($j>=0) {
      $nb=bcmul($j,bcpow($lendst,$i));
      if(bcsub($reste,$nb)>=0) {
        $result.=substr($basedst,$j,1);
        $reste=bcsub($reste,$nb);
        break;
      }
      $j--;
    }
  }

  return $result;
}

function _custombase_convert($numstring, $baseFrom, $baseTo) {
	$numstring = (string) $numstring;
	$baseFromLen = strlen($baseFrom);
	$baseToLen = strlen($baseTo);
	$decVal = 0;
	
	for ($len = (strlen($numstring) - 1); $len >= 0; $len--) {
		$char = substr($numstring, 0, 1);
		$pos = strpos($baseFrom, $char);
		if ($pos !== FALSE) {
			$decVal += $pos * ($len > 0 ? pow($baseFromLen, $len) : 1);
		}
		$numstring = substr($numstring, 1);
	}	

	$numstring = FALSE;
	$nslen = 0;
	$pos = 1;
	while ($decVal > 0)	{
		$valPerChar = pow($baseToLen, $pos);
		$curChar = floor($decVal / $valPerChar);
		if ($curChar >= $baseToLen)	{
			$pos++;
		} else {
			$decVal -= ($curChar * $valPerChar);
			if ($numstring === FALSE)
			{
				$numstring = str_repeat($baseTo{1}, $pos);
				$nslen = $pos;
			}
			$numstring = substr($numstring, 0, ($nslen - $pos)) . $baseTo{$curChar} . substr($numstring, (($nslen - $pos) + 1));
			$pos--;
		}
	}
	if ($numstring === FALSE) $numstring = $baseTo{1};

	return $numstring;
}


function convertIdToShort($inNumber) {
	return custombase_convert($inNumber, "0123456789", "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
}

function convertIdToLong($inNumber) {
	return custombase_convert($inNumber, "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", "0123456789");
}


function getCoreTitle($inTitle) {
	$matches = array();
	if(preg_match('/^(.+)\s+\(.+\)$/i', $inTitle, $matches)) {
		return $matches[1];
	} else {
		return $inTitle;
	}
}


function getBlogUrl() {
	$url = "blog";
	if(getLanguage() != "de") { 
		$url .= "/" . getLanguage();
	}
	return $url;
}
?>