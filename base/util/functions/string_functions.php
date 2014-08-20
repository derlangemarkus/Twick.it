<?php
/*
 * Created at 21.05.2007
 *
 * @author Markus Moeller - Twick.it
 */
function strrpos_string($inHaystack, $inNeedle, $inOffset=0) {
    if(trim($inHaystack) != "" && $inNeedle != "" && $inOffset <= strlen($inHaystack)) {
        $lastPos = $inOffset;
        $found = false;
        while(($curr_pos = strpos($inHaystack, $inNeedle, $lastPos)) !== false) {
            $found = true;
            $lastPos = $curr_pos+1;
        }
        if($found) {
            return $lastPos-1;
        } else {
            return false;
        }
    } else {
        return false;
    }
} 
 
  
function startsWith($inText, $inStart) {
	if ($inStart === "") {
		return true;
	} else {
		return strpos($inText, $inStart) === 0;
	}
}


/**
 * Ueberprueft, ob ein String mit einem anderen endet.
 * 
 * @param string inText	Der String, dessen Ende untersucht werden soll.
 * @param int inStart	Der String, mit dem der andere enden soll.
 * 
 * @return bool true, wenn der eine String mit dem anderen endet.
 * @see startsWith()
 */  
function endsWith($inText, $inEnd) {
	return substr($inText, strlen($inText)-strlen($inEnd)) == $inEnd;
}


function contains($inText, $inNeedle, $inIgnoreCase=false) {
	if ($inIgnoreCase) {
		$needle = str_replace("/", "\\/", $inNeedle);
		$needle = str_replace(".", "\\.", $needle);
		return preg_match("/$needle/i", $inText);
	} else {
		return strpos($inText, $inNeedle) !== false;
	}
}


function substringBefore($inText, $inDelimiter) {
	if ($inDelimiter === "") {
		return $inText;
	}
	$lastIndex = strpos($inText, $inDelimiter);
	if ($lastIndex === false) {
		return $inText;
	} else {
		return substr($inText, 0, $lastIndex);
	}
}


function substringBeforeLast($inText, $inDelimiter) {
	$lastIndex = strrpos_string($inText, $inDelimiter);
	if ($lastIndex === false) {
		return $inText;
	} else {
		return substr($inText, 0, $lastIndex);
	}
}


function substringAfterLast($inText, $inDelimiter) {
	$lastIndex = strrpos_string($inText, $inDelimiter);
	if ($lastIndex === false) {
		return $inText;
	} else {
		return substr($inText, $lastIndex+1);
	}
}


function substringAfter($inText, $inDelimiter) {
	if ($inDelimiter === "") {
		return $inText;
	}
	$index = strpos($inText, $inDelimiter);
	if ($index === false) {
		return $inText;
	} else {
		return substr($inText, $index+strlen($inDelimiter));
	}
}


function substringBetween($inText, $inStartDelimiter, $inEndDelimiter) {
	if (!$inText || strlen($inText) < strlen($inStartDelimiter || strlen($inText) < strlen($inEndDelimiter))) {
		return $inText;
	}
	$startIndex = strpos($inText, $inStartDelimiter) + strlen($inStartDelimiter);
	$endIndex = strpos($inText, $inEndDelimiter, $startIndex);
	return substr($inText, $startIndex, $endIndex-$startIndex);
}


function truncateString($inText, $inLength=72, $inCut=false, $inMoreText="&#8230;") {
	if (strlen($inText)<=$inLength) {
		return $inText;
	} else if ($inCut) {
		return substr($inText, 0, $inLength-strlen($inMoreText)) . $inMoreText;
	} else {
		$cut = strpos($inText, " ", $inLength);
		if ($cut == 0) {
			return $inText;
		} else {
			return substr($inText, 0, $cut) . $inMoreText;
		}
	}
}



function fillString($inString, $inWidth=30) {
    $result = $inString;
    for ($i = 0; i < $inWidth - strlen($inString); $i++) {
        $new_value .= " ";
    }
    return $result;
}


function fillStringLeft($inString, $inWidth=30, $inChar="0") {
    $result = $inString;
    for ($i = 0; i < $inWidth - strlen($inString); $i++) {
        $result = $inChar . $result;
    }
    return $result;
}


function stripLeadingAndTrailingDoubleQuotes($inString) {
 	$result = $inString;
    while (substr($result, -1) == '"' || substr($result, 0, 1) == '"') {
        if (substr($result, -1) == '"') {
            $result = substr($result, 0, strlen($result)-1);
        }
        if (substr($result, 0, 1) == '"') {
            $result = substr($result, 1, strlen($result)-1);
        }
    }
    return $result;
}


function toCamelWord($inWord, $inUcFirst=true) {
    $word = str_replace(" ", "_", $inWord);
	$parts = split('_', $word);
	$result = "";

	foreach($parts as $part) {
		if ($result || $inUcFirst) {
			$result .= ucfirst($part);
		} else {
			$result .= $part;
		}
	}

	$result2 = "";
	$parts = split('2', $result);
	foreach($parts as $part) {
		if ($result2) {
			$result2 .= "2" . ucfirst($part);
		} else {
			$result2 .= $part;
		}
	}

	return $result2;
}


function killNewlines($inText) {
	return str_replace("\r", "", str_replace("\n", '\n', $inText));
}


function encodeEMailAddress($inText) {
	$text = $inText;
	$matches = array();
	while(preg_match("/([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+\\.)+[a-z]{2,3})/i", $text, $matches)) {
		$tmp = substringBefore($text, $matches[0]);
		for($i=0; $i<strlen($matches[0]); $i++) {
			$tmp .= "&#" . ord(substr($matches[0], $i, 1)) . ";";
		}
		$tmp .= substringAfter($text, $matches[0]);
		$text = $tmp;
	}
	
	return str_replace("mailto:", "&#109;&#097;&#105;&#108;&#116;&#111;&#058;", $text);
}


function uglyPrint($inBuffer) {
	$result = $inBuffer;
	if (strtolower(getArrayElement($_GET, "type", "xml")) == "json") {
		try {
			$result = json_encode(json_decode($result));
		} catch(Exception $ignored) {}
	}
	$result = preg_replace('/^\s+$/m', '', $result);
	$result = preg_replace('/^\s+/m', '', $result);
	$result = preg_replace('/\s+$/m', '', $result);
	$result = preg_replace('/\n/', '', $result);
	$result = preg_replace('/\r/', '', $result);
	return $result;
}
?>
