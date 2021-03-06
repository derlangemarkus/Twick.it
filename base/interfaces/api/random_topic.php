<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

// Parameter auslesen
$type = strtolower(getArrayElement($_GET, "type", "xml"));
$limit = getArrayElement($_GET, "limit", 1);
$prettyPrint = getArrayElement($_GET, "prettyPrint", 0) == 1;

$topics = Topic::fetchRandom($limit);

if (!$prettyPrint) {
	ob_start("uglyPrint");
}

if ($type == "json") {
	header("Content-Type: application/json; charset=utf-8"); 
	$outerSeperator = "";
?>
{
	"query":"<?php jecho($_SERVER["QUERY_STRING"]) ?>",
	"topics":[ 
<?php 
	foreach($topics as $topic) {
		echo($outerSeperator);
?>
		{
			"id":"<?php jecho($topic->getId()) ?>",
			"title":"<?php jecho($topic->getTitle()) ?>",
			"url":"<?php jecho($topic->getUrl()) ?>",
			"geo":{
				"latitude":"<?php jecho($topic->getLatitude()) ?>",
				"longitude":"<?php jecho($topic->getLongitude()) ?>"
			},
			"tags":[
			<?php 
			$separator = "";
			foreach($topic->getTags() as $tag=>$count) { 
				if(trim($tag) != "") {
					jecho($separator);
			?>
				{
					"tag":"<?php jecho($tag) ?>",
					"count":"<?php jecho($count) ?>"
				}
			<?php
					$separator = ", "; 
				}
			}
		?>
			]
		}
<?php
		$outerSeperator = ", ";
	}
?>
	]
}
<?php 
} else {
	header("Content-Type: text/xml; charset=utf-8");
	printXMLHeader();
?>
<result>
	<query><?php xecho($_SERVER["QUERY_STRING"]) ?></query>
	<topics>
<?php foreach($topics as $topic) { ?>
		<topic>
			<id><?php xecho($topic->getId()) ?></id>
			<title><?php xecho($topic->getTitle()) ?></title>
			<url><?php xecho($topic->getUrl()) ?></url>
			<geo>
				<latitude><?php xecho($topic->getLatitude()) ?></latitude>
				<longitude><?php xecho($topic->getLongitude()) ?></longitude>
			</geo>
			<tags>
			<?php 
			foreach($topic->getTags() as $tag=>$count) { 
				if(trim($tag) != "") {
			?>
				<tag count="<?php xecho($count) ?>"><?php xecho($tag) ?></tag>
			<?php 
				}
			}
			?>
			</tags>
		</topic>
<?php } ?>	
	</topics>
</result>
<?php
}
ob_end_flush();
?>