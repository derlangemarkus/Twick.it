<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkAdmin();
ini_set("display_errors", 1);
$login = getArrayElement($_GET, "login");
$user = User::fetchByLogin($login);
$userId = $user->getId();

$db =& DB::getInstance();
$db->query("SELECT DISTINCT u.login, count(*) AS c FROM tbl_twicks t, tbl_twick_ratings r, tbl_users u WHERE u.id=r.user_id AND t.id=r.twick_id AND t.user_id=$userId GROUP BY r.user_id ORDER BY count(r.user_id) DESC");
$sum = 0;
$count = array();
while ($result = $db->getNextResult()) {
	$sum += $result["c"];
	$count[$result["login"]] = $result["c"];
}
$db->query("SELECT DISTINCT u.login, count(*) AS c FROM tbl_twicks t, tbl_twick_ratings r, tbl_users u WHERE rating=1 AND u.id=r.user_id AND t.id=r.twick_id AND t.user_id=$userId GROUP BY r.user_id");
$good = array();
while ($result = $db->getNextResult()) {
	$good[$result["login"]] = $result["c"];
}


$db->query("SELECT DISTINCT u.login, count(*) AS c FROM tbl_twicks t, tbl_twick_ratings r, tbl_users u WHERE u.id=t.user_id AND t.id=r.twick_id AND r.user_id=$userId GROUP BY t.user_id ORDER BY count(r.user_id) DESC");
$givenSum = 0;
$givenCount = array();
while ($result = $db->getNextResult()) {
	$givenSum += $result["c"];
	$givenCount[$result["login"]] = $result["c"];
}
$db->query("SELECT DISTINCT u.login, count(*) AS c FROM tbl_twicks t, tbl_twick_ratings r, tbl_users u WHERE rating=1 AND u.id=t.user_id AND t.id=r.twick_id AND r.user_id=$userId GROUP BY t.user_id");
$givenGood = array();
while ($result = $db->getNextResult()) {
	$givenGood[$result["login"]] = $result["c"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title><?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="Twick.it" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTwicks') ?>" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTopics') ?>" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>" />
	
    <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src="html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="html/js/swfobject.js"></script>
	<script type="text/javascript" src="html/js/twickit/twickit_twick_js.php"></script>
	<!--[if IE]>
	<script type="text/javascript" src="html/js/png.js"></script>
	<![endif]-->
	<script type="text/javascript" src="interfaces/js/popup/twickit.js"></script>
	<style type="text/css">
	.cell0 { border-bottom:1px solid #000; background-color:#FFF; }
	.cell1 { border-bottom:1px solid #000; }
	.total { font-weight:bold; background-color:#CCC; }
	th { vertical-align: bottom; }
	</style>
	
</head>
<body>
	<?php include("../inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1>Bewertungs-Statistik für <a href="user/<?php echo($user->getLogin()) ?>"><?php echo htmlspecialchars($user->getDisplayName()) ?></a></h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links" style="width:880px;background-color:#EFEFEF;padding:20px;">
				<h1>So wurde <?php echo htmlspecialchars($user->getDisplayName()) ?> bewertet</h1>
				<?php 
				echo("Insgesamt wurde der Nutzer $sum mal bewertet");
				if ($count) { 
				?>
				<table>
					<tr>
						<th>User</th>
						<th>Stimmen</th>
						<th>Anteil an<br />allen Stimmen</th>
						<th>davon schlecht</th>
						<th>davon gut</th>
					</tr>
				<?php 
				$i=0;
				$greenSum = 0;
				foreach($count as $login=>$c) {
					$i++;
					$green = $good[$login];
					$red = $c-$green;
					$greenSum += $green;
					
					$greenPercent = $green / $c * 100;
					$redPercent = 100-$greenPercent;
					
					$ratingPercent = $sum == 0 ? 0 : $c / $sum * 100;
					
					$class = "cell" . ($i%2);
					?><tr>
						<td align="left" class="<?php echo($class) ?>"><a href="admin/user_ratings.php?login=<?php echo($login) ?>"><?php echo($login) ?></a></td>
						<td align="right" class="<?php echo($class) ?>"><?php echo($c) ?></td>
						<td align="right" class="<?php echo($class) ?>"><?php echo(number_format($ratingPercent, 0, _loc('format.number.decimal'), _loc('format.number.thousand'))) ?>%</td>
						<td align="right" class="<?php echo($class) ?>"><img src="html/img/red.gif" height="10" width="<?php echo(3*$redPercent) ?>" title="<?php echo($red) ?> (<?php echo($redPercent) ?>%)" /></td>
						<td align="left" class="<?php echo($class) ?>"><img src="html/img/green.gif" height="10" width="<?php echo(3*$greenPercent) ?>" title="<?php echo($green) ?> (<?php echo($greenPercent) ?>%)" /></td>
					</tr><?php 
				}
				
				$greenSumPercent = $greenSum / $sum * 100;
				$redSumPercent = 100 - $greenSumPercent;
				?>
					<tr>
						<td align="left" class="<?php echo($class) ?> total">TOTAL</td>
						<td align="right" class="<?php echo($class) ?> total"><?php echo($sum) ?></td>
						<td align="right" class="<?php echo($class) ?> total">100%</td>
						<td align="right" class="<?php echo($class) ?> total"><img src="html/img/red.gif" height="10" width="<?php echo(3*$redSumPercent) ?>" title="<?php echo($sum-$greenSum) ?> (<?php echo($redSumPercent) ?>%)" /></td>
						<td align="left" class="<?php echo($class) ?> total"><img src="html/img/green.gif" height="10" width="<?php echo(3*$greenSumPercent) ?>" title="<?php echo($greenSum) ?> (<?php echo($greenSumPercent) ?>%)" /></td>
					</tr>
				</table>
				<?php } ?>
				<br /><br />
				<hr />
				
				
				<h1>So hat <?php echo htmlspecialchars($user->getDisplayName()) ?> bewertet</h1>
				<?php 
				echo("Insgesamt hat der Nutzer $givenSum mal bewertet");
				if ($givenCount) { 
				?>
				<table>
					<tr>
						<th>User</th>
						<th>Stimmen</th>
						<th>Anteil an<br />allen Stimmen</th>
						<th>davon schlecht</th>
						<th>davon gut</th>
					</tr>
				<?php
				$greenSum = 0; 
				$i=0;
				foreach($givenCount as $login=>$c) {
					$i++;
					$green = $givenGood[$login];
					$red = $c-$green;
					$greenSum += $green;
					
					$greenPercent = $green / $c * 100;
					$redPercent = 100-$greenPercent;
					
					$ratingPercent = $givenSum == 0 ? 0 : $c / $givenSum * 100;
					
					$class = "cell" . ($i%2);
					?><tr>
						<td align="left" class="<?php echo($class) ?>"><a href="admin/user_ratings.php?login=<?php echo($login) ?>"><?php echo($login) ?></a></td>
						<td align="right" class="<?php echo($class) ?>"><?php echo($c) ?></td>
						<td align="right" class="<?php echo($class) ?>"><?php echo(number_format($ratingPercent, 0, _loc('format.number.decimal'), _loc('format.number.thousand'))) ?>%</td>
						<td align="right" class="<?php echo($class) ?>"><img src="html/img/red.gif" height="10" width="<?php echo(3*$redPercent) ?>" title="<?php echo($red) ?> (<?php echo($redPercent) ?>%)" /></td>
						<td align="left" class="<?php echo($class) ?>"><img src="html/img/green.gif" height="10" width="<?php echo(3*$greenPercent) ?>" title="<?php echo($green) ?> (<?php echo($greenPercent) ?>%)" /></td>
					</tr><?php 
				}
				
				
				$greenSumPercent = $greenSum / $givenSum * 100;
				$redSumPercent = 100 - $greenSumPercent;
				?>
					<tr>
						<td align="left" class="<?php echo($class) ?> total">TOTAL</td>
						<td align="right" class="<?php echo($class) ?> total"><?php echo($givenSum) ?></td>
						<td align="right" class="<?php echo($class) ?> total">100%</td>
						<td align="right" class="<?php echo($class) ?> total"><img src="html/img/red.gif" height="10" width="<?php echo(3*$redSumPercent) ?>" title="<?php echo($givenSum-$greenSum) ?> (<?php echo($redSumPercent) ?>%)" /></td>
						<td align="left" class="<?php echo($class) ?> total"><img src="html/img/green.gif" height="10" width="<?php echo(3*$greenSumPercent) ?>" title="<?php echo($greenSum) ?> (<?php echo($greenSumPercent) ?>%)" /></td>
					</tr>
				</table>
				<?php 
				}
				?>
			</div>
			<!-- Linke Haelfte | ENDE -->
		
		
		<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>

<?php
$footerMessage = "<a href='all_topics.php'>". _loc('homepage.summary', number_format(TwickInfo::findNumberOfTwicks(true), 0, _loc('format.number.decimal'), _loc('format.number.thousand'))) . "</a>";
include(DOCUMENT_ROOT . "/inc/inc_footer.php"); 
?>

</body>
</html>