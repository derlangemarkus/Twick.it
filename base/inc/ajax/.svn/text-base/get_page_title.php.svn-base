<?php
require_once("../../util/inc.php");
header("Content-Type: application/json; charset=utf-8"); 

$url = getArrayElement($_GET, "url");
$id = getArrayElement($_GET, "id");
try {
	$title = @getPageTitle($url);
} catch(Exception $e) {
	$title = $url;
}
$host = strtolower(parse_url($url, PHP_URL_HOST));
$hosts = explode(".", $host);
$domain = $hosts[sizeof($hosts)-2];
$fileType = strtolower(substringAfterLast($url, "."));

$output = 
	array(
		"t" => $title,
		"u" => $url,
		"i" => $id
	);

if(in_array($fileType, array("jpg", "gif", "jpeg", "png", "bmp", "ico")) && getimagesize($url)) {
    $html = "<img id='previewImageLoader" . $id . "' src='" . HTTP_ROOT . "/html/img/ajax-loader.gif' alt='" . _loc('core.pleaseWait') . "' style='margin:10px'/>";
    $html .= "<img src='" . HTTP_ROOT . "/util/thirdparty/phpThumb/phpThumb.php?w=300&h=200&src=" . urlencode($url) . "' onload='$(\"previewImageLoader" . $id . "\").hide();'/>";
    $output["p"] = "Standard";
    $output["h"] = $html;

} else if($domain == "simpsonspedia") {	
	$content = getCachedFileContent($url, 60*60*24*100);
	$pattern = '/<img .*? src="(\/images\/thumb\/.+)" .*? class="thumbimage"/U';

	if(preg_match($pattern, $content, $matches)) {
		$image = "http://simpsonspedia.net" . $matches[1];

		$html = "<img id='previewImageLoader" . $id . "' src='" . HTTP_ROOT . "/html/img/ajax-loader.gif' alt='" . _loc('core.pleaseWait') . "' style='margin:10px'/>";
		$html .= "<img src='" . HTTP_ROOT . "/util/thirdparty/phpThumb/phpThumb.php?w=300&h=200&src=" . urlencode($image) . "' onload='$(\"previewImageLoader" . $id . "\").hide();'/>";
		$output["p"] = "Standard";
		$output["h"] = $html;
	}
	
} else if($domain == "imdb") {	
	$movie = substringBetween($url, "/title/", "/");
	if($movie) {
		$content = getCachedFileContent("http://www.imdbapi.com/?i=" . $movie, 60*60*24*100);
		$infos = json_decode($content, true);
		
		if($infos["Title"]) {
			$html = "<table border='0' cellspacing='0' cellpadding='0' class='imdb_preview'>";
			$html .= "<tr><td rowspan='7'>";
			$html .= "<img id='previewImageLoader" . $id . "' src='" . HTTP_ROOT . "/html/img/ajax-loader.gif' alt='" . _loc('core.pleaseWait') . "' style='margin:10px'/>";
			$html .= "<img src='" . HTTP_ROOT . "/util/thirdparty/phpThumb/phpThumb.php?w=300&h=180&src=" . urlencode($infos["Poster"]) . "' alt='' onload='$(\"previewImageLoader" . $id . "\").hide();'></td>";
			$html .= "<td colspan='2'><h1>" . $infos["Title"] . " (" . $infos["Year"] .")</h1></td></tr>";
			$html .= "<tr class='odd'><td><b>" . _loc('inside.imdb.released') . ":</b></td><td>" . convertDate($infos["Released"], "d.m.Y") ."</td></tr>";
			$html .= "<tr><td><b>" . _loc('inside.imdb.genre') . ":</b></td><td>" . $infos["Genre"] ."</td></tr>";
			$html .= "<tr class='odd'><td><b>" . _loc('inside.imdb.director') . ":</b></td><td>" . $infos["Director"] ."</td></tr>";
			$html .= "<tr><td><b>" . _loc('inside.imdb.writer') . ":</b></td><td>" . $infos["Writer"] ."</td></tr>";
			$html .= "<tr class='odd'><td><b>" . _loc('inside.imdb.actors') . ":</b></td><td>" . $infos["Actors"] ."</td></tr>";
			$html .= "<tr><td><b>" . _loc('inside.imdb.runtime') . ":</b></td><td>" . $infos["Runtime"] ."</td></tr>";
			$html .= "</table>";
			
			$output["p"] = "Standard";
			$output["h"] = $html;
		}
	}
		
	
} else if($domain == "youtube") {
    parse_str(substringAfter($url, "?"), $queries);
    if(getArrayElement($queries, "v")) {
        $html = "
            <script type='text/javascript'>
                youtubeMovies['movie" . $id . "'] = '" . $queries["v"] . "';
            </script>
            <embed id='movie" . $id . "' name='movie" . $id . "' width='200' height='150' src='http://www.youtube.com/apiplayer?enablejsapi=1&playerapiid=movie" . $id . "' allowscriptaccess='always' type='application/x-shockwave-flash'/>
        ";
        $output["p"] = "Youtube";
        $output["h"] = $html;
    }
    
} else if($domain == "amazon") {
    if (contains($url, "redirect.html")) {
        parse_str(substringAfter($url, "?"), $queries);
        $url = $queries["location"];
    } 
    $path = explode("/", parse_url($url, PHP_URL_PATH));
    $foundNext = false;
    foreach($path as $p) {
        if($foundNext) {
            $productNumber = $p;
            break;
        }
        if(in_array($p, array("dp", "product"))) {
            $foundNext = true;
        }
    }

    if($productNumber) {
        $output["p"] = "Standard";
        $output["h"] = "<img src='http://images.amazon.com/images/P/" . $productNumber . ".01._THUMBZZZ_PU_PU-6_.jpg' />";
    }

} 

echo(json_encode($output));
?>