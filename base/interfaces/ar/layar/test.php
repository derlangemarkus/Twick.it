<?php
require_once("../../../util/inc.php");
#apc_clear_cache();
ini_set("display_errors", 1);


$response = array();
$response["layer"] = $value["layerName"];
$response["hotspots"] = array();

$titles =
    array(
        "Vier Mädchen auf der Brücke" => "maedchen",
        "Mona Lisa" => "monalisa",
        "Die Beständigkeit der Erinnerung" => "bestaendigkeit",
        "Zwölf Sonnenblumen in einer Vase" => "sonnenblumen",
        "Der Tiger" => "tiger",
        "Die Erschaffung Adams" => "erschaffung",
        "Der Schrei" => "schrei",
        "Nachtcafé" => "nachtcafe"
    );
foreach($titles as $title=>$reference) {
    $topic = array_pop(Topic::fetchByTitle($title));
    $twick = $topic->findBestTwick();
    $user = $twick->findUser();
    
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
        "showBiwOnClick" => true,
        "showSmallBiw" => true,
        "text" => array(
            "title" => $title,
            "description" => $twick->getText(),
            "footnote" => "erklärt von " . $user->getLogin()
        ),

        "anchor" => array(
            "referenceImage" => $reference
        ),
        "object" => array(
            "contentType" => "image/png",
            "url" => "http://twick.it/interfaces/ar/icon_38.png",
            "size" => 0.1
        ),
        "transform" => array(
            "rotate" => array(
                "rel" => false,
                "axis" => array(
                    "x" => 1,
                    "y" => 1,
                    "z" => 1
                )
            )
        ),
        "actions" => array(
            array(
                "uri" => $topic->getUrl(),
                "label" => "Twick.it öffnen"
            )
        ),
    	"imageURL"=>$user->getAvatarUrl(75),
        
	);
	
	$response["hotspots"][] = $hotspot;
}
$response["errorCode"] = 0;
$response["errorString"] = "ok";


header( "Content-type: application/json; charset=utf-8" );
echo json_encode($response);
?>