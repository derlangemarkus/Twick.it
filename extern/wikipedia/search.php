<?php
header("Content-Type: text/html; charset=utf-8"); 

$search = isset($_GET["q"]) ? $_GET["q"] : $_GET["search"];

function insertAfter($inText, $inSeparator, $inInsert) {
	$index = strpos($inText, $inSeparator);
	if ($index !== false) {
		$before = substr($inText, 0, $index+strlen($inSeparator));
		$after = substr($inText, $index+strlen($inSeparator));
		
		return $before . $inInsert . $after;
	} else {
		return $inText;
	}
}


function processXml($inXml) {
	global $twickit;
	if ($inXml && $inXml->topics->children()) {
	$topics = $inXml->topics->children();
	foreach($topics as $topic) {
		$text = str_replace("'", "&#27;", $topic->twicks->twick->text);
		$url = str_replace("'", "%27", $topic->twicks->twick->url);
		$link = $topic->twicks->twick->link;
		$title = $topic->title;
		
		$twickit .= "<div style='display:block;padding:2px;font-family:arial,sans-serif;font-size:small;'>";
		$twickit .= "<a href='$url' style='font-weight:bold;'>$title</a>: $text";
		if (trim($link)) {
			$twickit .= " (<a href='$link'>$link</a>)";
		}
		$twickit .= "</div>";
	}
} 
}

// Twick.it
$twickit = "";
$xml = simplexml_load_file("http://twick.it/interfaces/api/explain.xml?limit=-1&search=" . urlencode($search));
processXml($xml);

if (!$twickit) {
	$xml = simplexml_load_file("http://twick.it/interfaces/api/explain.xml?limit=-1&similar=1&search=" . urlencode($search));
	processXml($xml);
}

if ($twickit) {
	$twickit = "<div style='display:block;border:4px solid #84b204;padding:5px;margin:5px 0px 10px 0px;'><table width='100%'><tr><td valign='top'>$twickit</td><td valign='top' align='right'><a href='http://twick.it'><img src='http://twick.it/extern/wikipedia/logo.jpg' border='0'/></a></td></tr></table></div>";
}

// Wikipedia
ini_set('user_agent', 'Twick.it');
$wikipedia = simplexml_load_file("http://de.wikipedia.org/w/api.php?action=opensearch&search=" . urlencode($search) . "&format=xml");	
$items = $wikipedia->Section->Item;
$item = is_array($items) ? $items[0] : $items;
$link = $item->Url;
$wikipedia = file_get_contents($link ? $link : "http://de.wikipedia.org/wiki/Spezial:Search?fulltext=Suche&search=" . urlencode($search));

$wikipedia = insertAfter($wikipedia, '<a id="top"></a>', $twickit);
$wikipedia = insertAfter($wikipedia, "<head>", "<base href='http://de.wikipedia.org/wiki/' /><script type='text/javascript' src='http://twick.it/html/js/scriptaculous/lib/prototype.js'></script><script type='text/javascript' src='http://twick.it/interfaces/js/popup/twickit.js'></script>");
$wikipedia = str_replace('action="/w/index.php"', 'action="http://'. $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . '"', $wikipedia);


echo($wikipedia);
?>