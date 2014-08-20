<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkAdmin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title>Bullshit | Twick.it</title>
    <meta name="description" content="<?php echo($title) ?>| twick.it - die Wissensmaschine im Netz" />   
    <meta name="keywords" content="<?php echo($title) ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />
	
    <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="html/js/swfobject.js"></script>
	<script type="text/javascript" src="html/js/twickit/twickit_twick_js.php"></script>
	<script type="text/javascript" src="html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src="html/js/scriptaculous/src/scriptaculous.js"></script>
	<script type="text/javascript" src="html/js/png.js"></script>
	<script type="text/javascript" src="html/js/dropdown.js"></script>
	<script type="text/javascript" src="interfaces/js/popup/twickit.js"></script>
</head>

<body>
	<?php include("../inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1>Gemeldeter <span id="topicTitle">Bullshit</span></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<div class="textcontent">
					<table style="border:1px solid #000;" cellspacing="2">
					<?php
					$types = 
						array(
							1 => "rechtswidrige",
							2 => "Personfake",
							4 => "vulgär",
							8 => "Verunglimpfung",
							16 => "falsches Thema",
							32 => "falsche Info",
							64 => "Werbung",
							128 => "",
							256 => "",
							512 => "",
							1024 => "Sonstiges",
							2048 => "",
							4096 => ""
						); 
					$bullshits = TwickSpamRating::findWorst();	
					$user = getUser();
					$secret = $user->getSecret();
					foreach($bullshits as $id=>$info) {
						$twick = TwickInfo::fetchById($id);
						$theUser = $twick->getUser();
						if ($twick) {
							echo("<tr style='background-color:#BCE051;'><td colspan='5'><div style='float:left;'><b>" . $info["total"] . "x als Bullshit bewertet:</b> ");
							for ($i=0; $i<10; $i++) {
								$type = pow(2, $i);
								if ($info[$type]) {
									$typeName = getArrayElement($types, $type, "");
									if (!$typeName) {
										$typeName = type;
									}
									echo("$typeName: " . $info[$type] . "x; ");
								}
							}
							?>
								</div>
								<div style="float:right;">
									<a href="<?php echo(confirmLink(HTTP_ROOT . "/action/delete_twick.php?bullshit=1&id=$id&secret=$secret")) ?>">Twick löschen</a>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="<?php echo(confirmLink(HTTP_ROOT . "/action/delete_spam_rating.php?id=$id")) ?>">Dies ist kein Spam!</a>
								</div>
							</td></tr>
							<tr>
								<td valign="top"><a href="<?php echo($theUser->getUrl()) ?>" style="white-space: nowrap;"><?php echo($theUser->getAvatar(32, 'float:left; padding-right:3px;')) ?><?php echo htmlspecialchars($theUser->getDisplayName()) ?></a></td>
								<td valign="top" style="border-left:1px solid #000;"><a href="<?php echo($twick->getUrl()) ?>"><?php echo($twick->getTitle()) ?></a></td>
								<td valign="top" style="border-left:1px solid #000;"><?php echo($twick->getLanguageCode()) ?></td>
								<td valign="top" style="border-left:1px solid #000;"><?php echo($twick->getText()) ?></td>
								<td valign="top" style="border-left:1px solid #000;"><?php echo($twick->getRating()) ?></td>
							</tr>
						<?php 
						}
					}
					?>
					</table>
				</div>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>Übersicht</h2></div>
			        <div class="teaser-body">
			        	<div>
			        		Es wurden <b><?php echo(sizeof($bullshits)) ?></b> Twicks als Spam bewertet.<br />
			        		<br />
			        		Insgesamt wurden <b><?php echo(sizeof(TwickSpamRating::fetchAll())) ?></b> Bullshit-Stimmen abgegeben.<br /><br />
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
						              
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>