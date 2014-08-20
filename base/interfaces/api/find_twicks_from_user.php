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
$prettyPrint = getArrayElement($_GET, "prettyPrint", 0) == 1;
$limit = getArrayElement($_GET, "limit", 10);

$user = User::fetchByLogin($search);
if (!$user) {
	exit;
}

$twicks = Twick::fetchByUserId($user->getId(), false, array("LIMIT"=>$limit));


if (!$prettyPrint) {
	ob_start("uglyPrint");
}

if ($type == "json") {
	header("Content-Type: application/json; charset=utf-8"); 
?>
{
	"query":"<?php jecho($_SERVER["QUERY_STRING"]) ?>",
	"topics":[ 
	<?php 
	$separator = "";
	foreach($twicks as $twick) {
		$topic = $twick->findTopic();
		$user = $twick->findUser();
		echo($separator); 
	?>
		{
			"topic":{
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
							"count":<?php jecho($count) ?>
						}
					<?php
							$separator = ", "; 
						}
					}
				?>
				],
				"twick":{
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
			}
		}
	<?php
		$separator = ","; 
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
<?php 
foreach($twicks as $twick) {
	$topic = $twick->findTopic();
	$user = $twick->findUser(); 
?>
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
			<twick>
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
		</topic>
<?php } ?>	
	</topics>
</result>
<?php
}
ob_end_flush();
?>