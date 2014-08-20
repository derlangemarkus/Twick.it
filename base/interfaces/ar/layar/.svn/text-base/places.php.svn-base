<?php
require_once("../../../util/inc.php");
ini_set("display_errors", 1);

 
$value = array();
foreach(array("layerName", "lat", "lon", "radius") as $key) {
    $value[$key] = $_GET[$key];
}

$response = array();
$response["layer"] = $value["layerName"];
$response["hotspots"] = array();

$topics = Topic::findNear($value["lat"], $value["lon"], $value["radius"]);
foreach($topics as $infos) {
    $topic = $infos[1];
	$twick = $topic->findBestTwick();
    $user = $twick->findUser();
        
    if (!$topic->hasCoordinates()) {
        continue;
    }
    $longitude = $topic->getLongitude();
    $latitude = $topic->getLatitude();
    
    $lines = array();
    $line = "";
    foreach(preg_split('/\b/', $twick->getText()) as $word) {
    	if (strlen($line . $word) <= 80) {
    		$line .= $word;
    	} else {
    		$lines[] = $line;
    		$line = $word;
    	}
    }
    $lines[] = $line;
    
    $hotspot = array(
		"id" => $topic->getId(),
		"attribution" => "erklärt von " . $user->getLogin(),
		"title" => $twick->getTitle(),
    	"line2" => $lines[0],
    	"line3" => $lines[1],
    	"line4" => $lines[2],
		"lon" => $longitude * 1000000,
		"lat" => $latitude * 1000000,
		"actions" => array(array("uri"=>$topic->getUrl(), "label"=>"Twick.it öffnen")),
		"type" => "1",
		"inFocus"=>"1",
    	"imageURL"=>$user->getAvatarUrl(75)
	);
	
	$response["hotspots"][] = $hotspot;
}
$response["errorCode"] = 0;
$response["errorString"] = "ok";


header( "Content-type: application/json; charset=utf-8" );
echo json_encode($response);
?>