<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

// Parameter auslesen
$user = getArrayElement($_GET, "user");
$type = strtolower(getArrayElement($_GET, "type", "xml"));
$limit = getArrayElement($_GET, "limit", -1);
$prettyPrint = getArrayElement($_GET, "prettyPrint", 0) == 1;

if (!getArrayElement($_GET, "noCache")) {
	setDBCacheTimeout(3600);
}

$user = User::fetchByLogin($user);
$favorites = TwickFavorite::fetchByUserId($user->getId());
$favorites = array_slice($favorites, 0, $limit >= 0 ? $limit : sizeof($favorites));

if (!$prettyPrint) {
	ob_start("uglyPrint");
}

if ($type == "json") {
	header("Content-Type: application/json; charset=utf-8"); 
?>
{
	"query":"<?php jecho($_SERVER["QUERY_STRING"]) ?>",
	"twicks":[
	<?php 
	$separator = "";
	foreach($favorites as $favorite) { 
		$twick = $favorite->findTwick();
        if(!$twick) {
            continue;
        }
 		$user = $twick->findUser();
		echo($separator);
	?>
		{
            "topic":"<?php jecho($twick->getTitle()) ?>",
			"id":<?php jecho($twick->getId()) ?>,
			"acronym":"<?php jecho($twick->getAcronym()) ?>",
			"text":"<?php jecho($twick->getText()) ?>",
			"link":"<?php jecho($twick->getLink()) ?>",
			"url":"<?php jecho($twick->getUrl()) ?>",
			"standalone_url":"<?php jecho($twick->getStandaloneUrl) ?>",
			"creation_date":"<?php jecho($twick->getCreationDate()) ?>",
			"rating":{
				"count":<?php jecho($twick->getRatingCountCached()) ?>,
				"sum":<?php jecho($twick->getRatingSumCached()) ?>,
				"ratio":<?php jecho($twick->getRatingRatio()) ?>
			},
			"user":{
				"gravatar":"<?php jecho($user->getAvatarUrl()) ?>",
				"name":"<?php jecho($user->getDisplayName()) ?>",
				"username":"<?php jecho($user->getLogin()) ?>",
				"url":"<?php jecho($user->getUrl()) ?>"
			}
		}
	<?php
		$separator = ", "; 
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
	<twicks>
	<?php 
	foreach($favorites as $favorite) { 
		$twick = $favorite->findTwick();
		if (!$twick) {
			continue;
		}
		$user = $twick->findUser();
	?>
			<twick>
                <topic><?php xecho($twick->getTitle()) ?></topic>
				<id><?php xecho($twick->getId()) ?></id>
				<acronym><?php xecho($twick->getAcronym()) ?></acronym>
				<text><?php xecho($twick->getText()) ?></text>
				<link><?php xecho($twick->getLink()) ?></link>
				<url><?php xecho($twick->getUrl()) ?></url>
				<standalone_url><?php xecho($twick->getStandaloneUrl()) ?></standalone_url>
				<creation_date><?php xecho($twick->getCreationDate()) ?></creation_date>
				<rating>
					<count><?php xecho($twick->getRatingCountCached()) ?></count>
					<sum><?php xecho($twick->getRatingSumCached()) ?></sum>
					<ratio><?php xecho($twick->getRatingRatio()) ?></ratio>
				</rating>
				
				<user>
					<gravatar><?php xecho($user->getAvatarUrl()) ?></gravatar>
					<name><?php xecho($user->getDisplayName()) ?></name>
					<username><?php xecho($user->getLogin()) ?></username>
					<url><?php xecho($user->getUrl()) ?></url>
				</user>
			</twick>
	<?php 
	}
	?>		
	</twicks>
</result>
<?php
}
ob_end_flush();
?>