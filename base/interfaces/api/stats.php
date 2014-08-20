<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

// Parameter auslesen
$type = strtolower(getArrayElement($_GET, "type", "xml"));
$prettyPrint = getArrayElement($_GET, "prettyPrint", 0) == 1;

$numberOfTopics = Topic::findNumberOfTopics(true);
$numberOfTopicsInLanguage = Topic::findNumberOfTopics(false);

$numberOfTwicks = Twick::findNumberOfTwicks(true);
$numberOfTwicksInLanguage = Twick::findNumberOfTwicks(false);

$numberOfUsers = UserInfo::findNumberOfUsers(true);
$numberOfUsersInLanguage = UserInfo::findNumberOfUsers(false);

if (!$prettyPrint) {
	ob_start("uglyPrint");
}

if ($type == "json") {
	header("Content-Type: application/json; charset=utf-8"); 
?>
{
	"query":"<?php jecho($_SERVER["QUERY_STRING"]) ?>",
	"numberOfTopics":<?php jecho($numberOfTopics) ?>,
	"numberOfTopicsInLanguage":<?php jecho($numberOfTopicsInLanguage) ?>,
	"numberOfTwicks":<?php jecho($numberOfTwicks) ?>,
	"numberOfTwicksInLanguage":<?php jecho($numberOfTwicksInLanguage) ?>,
	"numberOfUsers":<?php jecho($numberOfUsers) ?>,
	"numberOfUsersInLanguage":<?php jecho($numberOfUsersInLanguage) ?>
}
<?php
} else {
	header("Content-Type: text/xml; charset=utf-8");
	printXMLHeader(); 
?>
<result>
	<query><?php xecho($_SERVER["QUERY_STRING"]) ?></query>
	<numberOfTopics><?php xecho($numberOfTopics) ?></numberOfTopics>
	<numberOfTopicsInLanguage><?php xecho($numberOfTopicsInLanguage) ?></numberOfTopicsInLanguage>
	<numberOfTwicks><?php xecho($numberOfTwicks) ?></numberOfTwicks>
	<numberOfTwicksInLanguage><?php xecho($numberOfTwicksInLanguage) ?></numberOfTwicksInLanguage>
	<numberOfUsers><?php xecho($numberOfUsers) ?></numberOfUsers>
	<numberOfUsersInLanguage><?php xecho($numberOfUsersInLanguage) ?></numberOfUsersInLanguage>
</result>
<?php
}
ob_end_flush();
?>