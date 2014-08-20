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
    <title>Quasselecken | Twick.it</title>
    <meta name="description" content="<?php echo($title) ?>| twick.it - die Wissensmaschine im Netz" />   
    <meta name="keywords" content="<?php echo($title) ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.walls') ?>" href="interfaces/rss/walls.php"/>
    
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
			<h1>Quasselecken-Übersicht</h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<div class="textcontent">
					<table border="1" cellspacing="2">
						<tr>
							<th>Quasselecke von X</th>
							<th>schreibt Y</th>
							<th>das hier</th>
						</tr>
					<?php 
						$owners = array();
						$authors = array();
						$counter = 0;
						foreach(WallPost::fetchAll() as $post) { 
							$counter++;
							$owner = $post->findUser();
							$author = $post->findAuthor();
							
							$owners[$owner->getLogin()] = getArrayElement($owners, $owner->getLogin())+1;
							$authors[$author->getLogin()] = getArrayElement($authors, $author->getLogin())+1;
					?>
						<tr <?php if($post->isDeleted()) { ?>style="text-decoration:line-through"<?php } ?>>
							<td><a href="/user/<?php echo($owner->getLogin()) ?>/wall"><?php echo($owner->getAvatar(20)) ?><?php echo($owner->getLogin()) ?></a></td>
							<td><a href="/user/<?php echo($author->getLogin()) ?>"><?php echo($author->getAvatar(20)) ?><?php echo($author->getLogin()) ?></a></td>
							<td><a href="<?php echo($post->getUrl()) ?>"><?php echo(nl2br(htmlspecialchars($post->getMessage()))) ?></a></td>
						</tr>
					<?php 
						} 
						
						arsort($authors);
						arsort($owners);
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
			        		Es wurden <b><?php echo($counter) ?></b> Quasseleckeneinträge geschrieben.<br />
			        		<br />
							Es haben <b><?php echo(sizeof($authors)) ?></b> Nutzer Nachrichten in <b><?php echo(sizeof($owners)) ?></b> Quasselecken geschrieben.
			        		<br /><br />
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
						              
				<!-- Schreiber | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>Die Schreiber</h2></div>
			        <div class="teaser-body">
			        	<div>
							<table>
			        		<?php foreach($authors as $author=>$count) { ?>
								<tr>
									<td><?php echo($author) ?></td>
									<td><?php echo($count) ?></td>
								</tr>
							<?php } ?>
							</table>
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Schreiber | ENDE -->  
				
				<!-- Leser | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2>Quasseleckenbesitzer</h2></div>
			        <div class="teaser-body">
			        	<div>
							<table>
			        		<?php foreach($owners as $owner=>$count) { ?>
								<tr>
									<td><a href="/user/<?php echo($owner) ?>/wall"><?php echo($owner) ?></a></td>
									<td><?php echo($count) ?></td>
								</tr>
							<?php } ?>
							</table>
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Leser | ENDE --> 
				
				<!-- RSS | START -->
				<div class="teaser">
					<div class="teaser-head"><h2>RSS</h2></div>
					<div class="teaser-body nopadding">
						<ul>
							<li><img src="<?php echo(STATIC_ROOT) ?>/html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="interfaces/rss/walls.php"><?php loc('rss.walls') ?></a></li>
						</ul>
						<div class="clearbox"></div>
					</div>
					<div class="teaser-footer"></div>                        
				</div>
				<!-- RSS | ENDE --> 
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>