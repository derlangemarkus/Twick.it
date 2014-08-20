<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
checkAdmin();

if (!getArrayElement($_GET, "skipExcel")) {
	header("Pragma: public"); // wichtig
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="newsletter_empfaenger.xls"');
	header("Content-Transfer-Encoding: binary");
}

$users = User::fetch(array("newsletter"=>1, "approved"=>1));
?>
<table>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>E-Mail</th>
		<th>secret</th>
        <th>Meister</th>
        <th>Sammler</th>
        <th>Wächter</th>
	</tr>
<?php
	foreach($users as $user) {
        if($user->getDeleted()) {
            continue;
        }
		srand((double)microtime() * 1000008);
		$rand = rand(65, 99);
		if ($rand > 90) {
			$char = $rand-90;
		} else {
			$char = chr($rand);
		}

        $bubble = Badge::getBubble($user->findNumberOfTwicks());
        $star = Badge::getStar($user->getRatingSumCached());
        $thumb = Badge::getThumb($user->findNumberOfRatings());
?>
	<tr>
		<td><?php echo($user->getId()) ?></td>
		<td><?php echo($user->getLogin()) ?></td>
		<td><?php echo($user->getMail()) ?></td>
		<td><?php echo($char . $user->getSecret() . ($user->getId()*2)) ?></td>
        <td><?php echo($star["text"]) ?></td>
        <td><?php echo($bubble["text"]) ?></td>
        <td><?php echo($thumb["text"]) ?></td>
	</tr>
<?php } ?>
</table>
