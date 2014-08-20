<?php
require_once("../../../util/inc.php");
header("Content-Type: text/javascript; charset=utf-8");

$id = getArrayElement($_GET, "id");
$text = getArrayElement($_GET, "text");
$target = getArrayElement($_GET, "target", "_blank");
$minLength = getArrayElement($_GET, "minlength", 3);
$disableGeo = getArrayElement($_GET, "disableGeo", false);

$result = array();


if (preg_match('/\w+/', $text) && mb_strlen($text, "utf8") >= $minLength) {
	$topics = Topic::findHomonymsByTitle($text);
	if (sizeof($topics)) {
		$multiple = sizeof($topics) > 1;
		$firstTopic = $topics[0];
		foreach ($topics as $topic) {
			$twick = $topic->findBestTwick();
			$description = str_replace("'", "&x27", $twick->getText());
			$info = array("t"=>$topic->getTitle(), "d"=>$description, "u"=>$topic->getUrl());
			
			if(!$disableGeo && $topic->hasCoordinates()) {
				$info["g"] = $topic->getLatitude() . "," . $topic->getLongitude();
			}
			
			$result[] = $info;
		}
	} 
} 

?>
TwickitAutolink.callback("<?php echo($id) ?>", "<?php echo($target) ?>", <?php echo(json_encode($result)) ?>);