<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

$user = getUser();
$userName = $user ? $user->getDisplayName() : "";
$mail = $user && !$user->getThirdpartyId() ? $user->getMail() : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('support.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('support.title') ?>" />
    <meta name="description" content="<?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript">
	function checkSupportForm() {
		var error = "";
		if (document.support.name.value.strip() == "") {
			error += "<?php loc('support.error.name') ?><br /><br />";
		}
		if (document.support.mail.value.strip() == "" || !document.support.mail.value.strip().match(/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i)) {
			error += "<?php loc('support.error.mail') ?><br /><br />";
		}
		if (document.support.subject.value.strip() == "") {
			error += "<?php loc('support.error.subject') ?><br /><br />";
		}
		if (document.support.message.value.strip() == "") {
			error += "<?php loc('support.error.message') ?><br /><br />";
		}

		if (error == "") {
			$("supportForm").submit();
		} else {
			doPopup(error);
		}
	}
	</script>
	<style type="text/css">
	#supportForm input {width:500px; margin-bottom: 10px; }
	</style>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('support.headline') ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
			
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head" style="height:auto;"><h1><?php loc('support.subline') ?></h1></div>
					<div class="blog-body">
						<?php loc('support.text') ?><br />
						<br />
						
						<form action="send_support.php" name="support" id="supportForm" method="post">
							<label><?php loc('support.name') ?>:</label><br />
							<input type="text" name="name" value="<?php echo htmlspecialchars($userName) ?>"/><br />
							<label><?php loc('support.mail') ?>:</label><br />
							<input type="text" name="mail" value="<?php echo($mail) ?>"/><br />
							<label><?php loc('support.subject') ?>:</label><br />
							<input type="text" name="subject" value=""/><br />
							<label><?php loc('support.message') ?>:</label><br />
							<textarea rows="9" cols="70" style="width:500px" name="message"></textarea><br />
							<br />
							<a href="javascript:;" onclick="checkSupportForm()" id="createLink"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('support.button') ?></a>
						</form>
					</div>
					<div class="blog-footer"></div>
				</div>
				<!-- Kasten | ENDE -->
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('support.marginal.howto.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('support.marginal.howto.text') ?><br />
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
		
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('support.marginal.more.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('support.marginal.more.text') ?><br />
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
						              
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>  
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>
