<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php");
checkAdmin();

$deletedTwicks = DeletedTwick::fetchAll();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Gelöschte Twicks</title>
	<?php include("../inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("../inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1>Gelöschte Twicks</h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php 
				foreach($deletedTwicks as $deletedTwick) {
                    $deleter = User::fetchById($deletedTwick->getDeleterId());
                    echo("<h1 style='padding:20px 0 0 20px;'>Gelöscht von " . htmlspecialchars($deleter->getDisplayName()) . ":</h1>");
                    $twick = $deletedTwick->asTwick();
					$twick->display(false, 0);
				} 
				?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts unimportant">
						              
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>     
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>
	<script type="text/javascript">
		expandPageTitles();
	</script>	
</body>
</html>
