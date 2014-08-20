<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php");

// Parameter auslesen
$type = strtolower(getArrayElement($_GET, "type", "xml"));
$size = strtolower(getArrayElement($_GET, "size"));
$prettyPrint = getArrayElement($_GET, "prettyPrint", 0) == 1;


function getImage($inImage, $inSize) {
	$available = array(48, 80, 200);
	$size = $inSize==false ? 80 : $inSize;
	
	if (in_array($size, $available)) {
		return STATIC_ROOT . "/html/img/badges/$size/" . $inImage;
	} else {
		$url = STATIC_ROOT . "/html/img/badges/80/" . $inImage;
		
		if ($inSize > 0) {
			$url = HTTP_ROOT . "/util/thirdparty/phpThumb/phpThumb.php?w=$inSize&h=$inSize&far=1&src=" . urlencode($url);
		}
		return $url;
	}
}

$infos = Badge::getInfos();

if (!$prettyPrint) {
	ob_start("uglyPrint");
}

if ($type == "json") {
	header("Content-Type: application/json; charset=utf-8"); 
?>
[
<?php
$outerSeparator = "";
foreach($infos as $title=>$info) {
    echo($outerSeparator);
    ?>
	{
		"id":"<?php jecho($info["id"]) ?>",
		"name":"<?php jecho(_loc($title)) ?>",
		"description":"<?php jecho(_loc($info["info"])) ?>",
		"levels": [
			<?php
			$innerSeparator = "";
			foreach(array_reverse($info["levels"]) as $level) {
				echo($innerSeparator);
			?>
			{
				"id":"<?php jecho($level["id"]) ?>",
				"count":"<?php jecho($level["count"]) ?>",
				"name":"<?php jecho(_loc($level["text"])) ?>",
				"img":"<?php jecho(getImage($level["img"], $size)) ?>"
			}
			<?php 
				$innerSeparator = ",";
			}
			?>
		]
	}
    <?php 
    $outerSeparator = ",";
} ?>
   ]

<?php
} else {
	header("Content-Type: text/xml; charset=utf-8");
	printXMLHeader(); 
?>
<badges>
    <?php foreach($infos as $title=>$info) { ?>
	<badge>
		<id><?php xecho($info["id"]) ?></id>
		<name><?php xecho(_loc($title)) ?></name>
		<description><?php xecho(_loc($info["info"])) ?></description>
		<levels>
            <?php foreach(array_reverse($info["levels"]) as $level) { ?>
			<level>
				<id><?php xecho($level["id"]) ?></id>
                <count><?php xecho($level["count"]) ?></count>
				<name><?php xecho(_loc($level["text"])) ?></name>
				<img><?php xecho(getImage($level["img"], $size)) ?></img>
			</level>
            <?php } ?>
		</levels>
	</badge>
    <?php } ?>
</badges>
<?php
}
ob_end_flush();
?>