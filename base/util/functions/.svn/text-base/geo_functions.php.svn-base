<?php
function convertArcminToAngle($inDegree, $inMinutes, $inSeconds, $inDirection) {
	$degree = $inDegree + $inMinutes/60 + $inSeconds/3600;

	if ($inDirection == "S" || $inDirection == "W") {
		return -1 * $degree;
	} else {
		return $degree;
	}
}


function findGeoCoordinates($inTitle) {
    $coordinates = findWikipediaGeoCoordinates($inTitle);
    if (!$coordinates) {
        // $coordinates = findOpenStreetMapGeoCoordinates($inTitle);
    }

    return $coordinates;
}


function findOpenStreetMapGeoCoordinates($inTitle) {
    try {
        $url = "http://nominatim.openstreetmap.org/search?format=xml&q=" . urlencode($inTitle);
        $xml = @simplexml_load_file($url);

        if ($xml) {
            $attributes = $xml->place->attributes();
            $displayName = trim(array_shift(explode(",", $attributes["display_name"])));
            $lat = $attributes["lat"];
            $long = $attributes["lon"];

            if (
                $lat && $long &&
                startsWith(
                    _normalizeForOpenStreetMap($displayName),
                    _normalizeForOpenStreetMap(getCoreTitle($inTitle))
                )
            ) {
                return array((float)$lat, (float)$long);
            }
        }

        return false;
    } catch(Exception $exception) {
        return false;
    }
}


function findWikipediaGeoCoordinates($inTitle) {
	$wikipediaEntry = getWikipediaEntry($inTitle);
	if (!$wikipediaEntry) {
		return false;
	}

    $oneLiners =
        array(
            array(
                "BREITENGRAD"=>1,
                "L(Ä|ä|AE)NGENGRAD"=>2,
				"(.+)" => 3
            ),
            array(
                "LATITUDE"=>1,
                "LONGITUDE"=>1,
				"(.+)" => 3
            ),
	
			array(
                "BREITE"=>1,
                "L(Ä|ä|AE)NGE"=>2,
				'(\d+\/\d+\/\d*\/.)' => 3
            ),
			
        );

    foreach($oneLiners as $oneLiner) {
        $keys = array_keys($oneLiner);
        $latRe = $keys[0];
        $latPos = $oneLiner[$latRe];
        $longRe = $keys[1];
        $longPos = $oneLiner[$longRe];
		$valuePattern = $keys[2];

        if(preg_match('/\|\s*' . $latRe . '\s*=\s*' . $valuePattern . '\n/i', $wikipediaEntry, $matches)) {
            $lat = trim($matches[$latPos]);
        }
        if(preg_match('/\|\s*' . $longRe . '\s*=\s*' . $valuePattern . '\n/i', $wikipediaEntry, $matches)) {
            $long = trim($matches[$longPos]);
        }

        if ($lat && $long) {
            break;
        }
    }


    if(!$lat || !$long) {
		if(preg_match('/{{Coordinate\s*\|(.+)}}/', $wikipediaEntry, $matches)) {
			$infos = explode("|", $matches[1]);
			foreach($infos as $info) {
				list($key, $value) = explode("=", $info);
                if(trim($key) == "name" && trim($value)) {
					// Beim name-Attribute kommt die Koordinate im Fließtext vor
                    $long = $lat = null;
					break;
				}
				if (trim($key) == "EW") {
					$long = trim($value);
				} else if (trim($key) == "NS") {
					$lat = trim($value);
				}
			}
		} else {
            $multiliners =
                array(
                    array(
                        "lat_deg", "lat_min", "lat_sec",
                        "lon_deg", "lon_min", "lon_sec"
                    ),
                    array(
                        "latitudineGradi", "latitudineMinuti", "latitudineSecondi",
                        "longitudineGradi", "longitudineMinuti", "longitudineSecondi",
                    ),
                );

            foreach($multiliners as $multiliner) {
                if(preg_match('/\|\s*' . $multiliner[0] . '\s*=\s*(-?\d+)\s*\|\s*' . $multiliner[1] . '\s*=\s*(\d+)\s*\|\s*' . $multiliner[2] . '\s*=\s*(\d+)/i', $wikipediaEntry, $matches)) {
                    $lat = convertArcminToAngle($matches[1], $matches[2], $matches[3], "");
                }
                if (preg_match('/\|\s*' . $multiliner[3] . '\s*=\s*(-?\d+)\s*\|\s*' . $multiliner[4] . '\s*=\s*(\d+)\s*\|\s*' . $multiliner[5] . '\s*=\s*(\d+)/i', $wikipediaEntry, $matches)) {
                    $long = convertArcminToAngle($matches[1], $matches[2], $matches[3], "");
                }
            }
        }
	}


	if ($lat && $long) {
		list($degree, $min, $sec, $dir) = explode("/", $lat);
		$lat = convertArcminToAngle($degree, $min, $sec, $dir);

		list($degree, $min, $sec, $dir) = explode("/", $long);
		$long = convertArcminToAngle($degree, $min, $sec, $dir);

		return array($lat, $long);
	}

    return false;
}


function _normalizeForOpenStreetMap($inTitle) {
    $title = strtolower($inTitle);
    $title = str_replace("-", " ", $title);
    return $title;
}
?>