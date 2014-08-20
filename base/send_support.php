<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

$name = getArrayElement($_POST, "name");
$mail = getArrayElement($_POST, "mail");
$subject = getArrayElement($_POST, "subject");
$message = getArrayElement($_POST, "message");

try {
	if($message) {
		$mailer = new PHPMailer();
		$mailer->CharSet = 'utf-8';
		$mailer->From = $mail;
		$mailer->FromName = $name;
		$mailer->Subject = $subject;
		$mailer->Body = $message;
		$mailer->AddAddress(SUPPORT_MAIL_RECEIVER);
		$ok = $mailer->Send();
	} else {
		$ok = false;
	}
} catch(Exception $exception) {
	$ok = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('support.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('support.title') ?>" />
    <meta name="description" content="<?php loc('support.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('support.title') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
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
				<?php if ($ok) { ?>
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('support.ok.headline') ?></h1></div>
					<div class="blog-body">
						<?php loc('support.ok.text') ?><br /><br />
						<?php echo(nl2br(htmlentities($message))) ?>
					</div>
					<div class="blog-footer"></div>
				</div>
				<!-- Kasten | ENDE -->
				<?php } else { ?>
				<!-- Sprechblase | START -->
				<div class="sprechblase">
					<h2>&nbsp;<span>&nbsp;</span></h2>
					<div class="sprechblase-main">
				    	<div class="sprechblase-achtung">&nbsp;</div>
				        <div class="sprechblase-rechts">
				        	<div class="blase-header" id="eingabeblase-head">
				            	<div class="kurzerklaerung"><span><?php loc('support.error.headline') ?></span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php loc('support.error.text', encodeEMailAddress(SUPPORT_MAIL_RECEIVER)) ?>
									<br /><br />
									<a href="support.php" id="createLink"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('core.back') ?></a>
								</div>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Sprechblase | ENDE -->
				<?php } ?>
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
						              
				<!-- Icon-Bookmark Leiste | START -->
				<div class="bookmark-leiste" style="margin-left:40px;">
					<?php $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>
					<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($url); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=400&amp;font=arial" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:135px;height:23px;" allowTransparency="true"></iframe>
					<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo($url) ?>" data-count="horizontal" data-via="TwickIt" data-related="twickit_<?php echo(getLanguage()) ?>" data-lang="<?php echo(getLanguage()) ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				</div>  
			    <!-- Icon-Bookmark Leiste | START -->         
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>
