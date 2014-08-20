<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

$limit = getArrayElement($_GET, "limit");
$offset = getArrayElement($_GET, "offset");

$users = User::fetchAll(false, false, array("LIMIT"=>$limit+1, "OFFSET"=>$offset));
if (sizeof($users) > $limit) {
	echo(1);   // Es gibt noch mehr User	
} else {
	echo(0);   // Es kommen keine User mehr
}
	
foreach(array_slice($users, 0, $limit) as $aUser) {
	?><a href="<?php echo($aUser->getUrl()) ?>"><img src='<?php echo($aUser->getAvatarUrl(38)) ?>' alt='<?php echo htmlspecialchars($aUser->getDisplayName()) ?>' title='<?php echo htmlspecialchars($aUser->getDisplayName()) ?>: <?php echo($aUser->getRatingSumCached()) ?>' style='width:38px;height:38px;float:left;' /></a><?php
}
?>