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
    <title>URL-Statistik | Twick.it</title>
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
			<h1><span id="topicTitle">URL-Statistik</span></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<div class="textcontent">
				<?php 
					$count = 0;
					$links = array();
					$tlds = array();
					$domains = array();
					$pureDomains = array();
					
					$db =& DB::getInstance();
					$db->query("SELECT link, count(link) AS c FROM tbl_twicks WHERE link<>'' GROUP BY link ORDER BY count(link) DESC");
					while ($result = $db->getNextResult()) {
                        try {
                            $count += $result["c"];
                            $links[$result["link"]] = $result["c"];
                            $host = getArrayElement(parse_url($result["link"]), "host");
                            $domains[$host] = getArrayElement($domains, $host, 0) + 1;
                            $tld = substringAfterLast($host, ".");
                            $tlds[$tld] = getArrayElement($tlds, $tld, 0) + 1;
                            $pureDomain = substringAfterLast(substringBeforeLast($host, "."), ".") . ".$tld";
                            $pureDomains[$pureDomain] = getArrayElement($pureDomains, $pureDomain, 0) + 1;
                        } catch(Exception $ignored) {}
					}
					
					arsort($tlds);
					arsort($domains);
					arsort($pureDomains);
					
					
					function printStats($inTitle, $inArray, $inParseUrl=false, $inLimit=30) {
						global $count;
						$counter = 1;
						?>
						<h1><?php echo($inTitle) ?></h1>
						<table cellpadding="4">
							<tr>
								<th>#</th><th></th><th>Anzahl</th><th>Prozent</th>
							</tr>
							<?php 
							foreach($inArray as $key=>$value) {
								if ($counter > $inLimit) {
									break;
								}

								/*
                                if($inParseUrl) {
                                    $info = @parse_url($key);
                                    $host = $info["host"];
                                } else {
                                    $host = $key;
                                }
								*/
							?>
							<tr>
								<td><?php echo($counter++) ?></td>
								<td><img src='http://getfavicon.appspot.com/<?php echo(startsWith($key, "http") ? $key : "http://" . $key) ?>' class='favicon'/><?php echo($key) ?></td>
								<td align="right"><?php echo($value) ?></td>
								<td align="right"><?php echo(round($value/$count*100, 0)) ?>%</td>
							</tr>
							<?php 
							} 
							?>
						</table>
						<hr />
						<?php 
					}
					
					
					printStats("TLDs", $tlds);
					printStats("Domains (ohne Subdomain)", $pureDomains);
					printStats("Domains (mit Subdomain)", $domains);
					printStats("Links", $links, true, 600);
					?>
					</div>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
						              
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>