<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

// Parameter auslesen
$search = getArrayElement($_GET, "search");
$type = strtolower(getArrayElement($_GET, "type", "xml"));
$size = strtolower(getArrayElement($_GET, "size", 32));
$prettyPrint = getArrayElement($_GET, "prettyPrint", 0) == 1;
$limit = getArrayElement($_GET, "limit", -1);
$exact = getArrayElement($_GET, "exact", false);

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(3600);
}

$users = User::search($search, $exact, $limit);

if (!$prettyPrint) {
	ob_start("uglyPrint");
}

if ($type == "json") {
	header("Content-Type: application/json; charset=utf-8"); 
	$outerSeperator = "";
?>
{
	"query":"<?php jecho($_SERVER["QUERY_STRING"]) ?>",
	"users":[ 
<?php 
	foreach($users as $aUser) {
		if ($aUser->getDeleted()) {
			continue;
		}
		$numberOfTwicks = $aUser->findNumberOfTwicks();
		$ratingSum = $aUser->getRatingSumCached();
		$numberOfRatings = $aUser->findNumberOfRatings();
		
		echo($outerSeperator);
?>
		{
			"id":"<?php jecho($aUser->getId()) ?>",
			"display_name":"<?php jecho($aUser->getDisplayName()) ?>",
			"avatar":"<?php jecho($aUser->getAvatarUrl($size)) ?>",
			"user_name":"<?php jecho($aUser->getLogin()) ?>",
			"name":"<?php jecho($aUser->getName()) ?>",
			"country":"<?php jecho($aUser->getCountry()) ?>",
			"location":"<?php jecho($aUser->getLocation()) ?>", 
			"bio":"<?php jecho($aUser->getBio()) ?>",
			"link":"<?php jecho($aUser->getLink()) ?>",
			"twitter":"<?php jecho($aUser->getTwitter()) ?>",
			"url":"<?php jecho($aUser->getUrl()) ?>",
			"badges": [
				<?php
				$badges = 
					array(
						Badge::getBubble($numberOfTwicks),
						Badge::getStar($ratingSum),
						Badge::getThumb($numberOfRatings)
					);

				$innerSeparator = "";
				foreach($badges as $badge) {
					echo($innerSeparator);
				?>
				{
					"id":<?php jecho($badge["id"]) ?>,
					"level":<?php jecho($badge["level"]) ?>
				}
				<?php
					$innerSeparator = ",";
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
	<users>
		<?php 
		foreach($users as $aUser) { 
			if ($aUser->getDeleted()) {
				continue;
			}
			$numberOfTwicks = $aUser->findNumberOfTwicks();
			$ratingSum = $aUser->getRatingSumCached();
			$numberOfRatings = $aUser->findNumberOfRatings();
		?>
		<user>
			<id><?php xecho($aUser->getId()) ?></id>
			<display_name><?php xecho($aUser->getDisplayName()) ?></display_name>
			<avatar><?php xecho($aUser->getAvatarUrl()) ?></avatar>
			<username><?php xecho($aUser->getLogin()) ?></username>
			<name><?php xecho($aUser->getName()) ?></name>
			<country><?php xecho($aUser->getCountry()) ?></country>
			<location><?php xecho($aUser->getLocation()) ?></location>
			<bio><?php xecho($aUser->getBio()) ?></bio>
			<link><?php xecho($aUser->getLink()) ?></link>
			<twitter><?php xecho($aUser->getTwitter()) ?></twitter>
			<url><?php xecho($aUser->getUrl()) ?></url>
			<badges>
				<?php
				$badges = 
					array(
						Badge::getBubble($numberOfTwicks),
						Badge::getStar($ratingSum),
						Badge::getThumb($numberOfRatings)
					);

				foreach($badges as $badge) {
				?>
				<badge>
					<id><?php xecho($badge["id"]) ?></id>
					<level><?php xecho($badge["level"]) ?></level>
				</badge>
				<?php
				}
				?>
			</badges>
		</user>
		<?php } ?>	
	</users>
</result>
<?php
}
ob_end_flush();
?>