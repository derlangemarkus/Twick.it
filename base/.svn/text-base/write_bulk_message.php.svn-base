<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");
checkAdmin();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('message.write.title') ?> | <?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('message.write.title') ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
            <h1>Megamail - Diese Nachricht geht an ganz, ganz viele Leute!!!</h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
                <br />
				<div class="sprechblase">
					<div class="sprechblase-main">
						<div class="sprechblase-links">
							<i>&nbsp;</i>
							<div class="bilderrahmen" style="background-color:red;color:#FFF;">Twick.it</div>
							<i>Twick.it an ALLE</i>
						</div>
						<div class="sprechblase-rechts">
							<div class="blase-header" id="eingabeblase-head">&nbsp;</div>
							<div class="blase-body">
								<form class="eingabeblase" id="message-blase" action="admin/send_bulk_message.php" method="post" name="twickForm">
									<?php echo(SpamBlocker::printHiddenTags()) ?>
                                    <select name="mode">
                                        <option value="newsletter">Alle Newsletter-Empfänger</option>
                                        <option value="all">Alle Nutzer</option>
                                    </select>
									<label for="subject"><?php loc('message.write.subject') ?>:</label>
									<input name="subject" type="text" value="<?php echo(htmlspecialchars($subject)) ?>"/>
									<label for="textfield"><?php loc('message.write.message') ?>:</label>
									<textarea name="message" id="textfield" style="height:210px;" onkeyup="checkUserMessageLength()" onkeypress="checkUserMessageLength()"><?php echo(htmlspecialchars($text)) ?></textarea>
								</form>    
							</div>
							<div class="blase-footer" id="eingabeblase-footer">
								<a href="javascript:;" id="sendButton" class="twickitpreview-off"><?php loc('message.write.send') ?></a>
							</div>
						</div>
						<div class="clearbox">&nbsp;</div>
					</div>
				</div>
				<script type="text/javascript">
				function checkUserMessageLength() {
					if($("textfield").value.length > 0) {
						var button = $("sendButton");
						button.className = "twickitpreview";
						button.onclick = function() { $('message-blase').submit(); };
					} else {
						var button = $("sendButton");
						button.className = "twickitpreview-off";
						button.onclick = null;
					}
				}
				</script>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('message.marginal.title') ?></h2></div>
			        <div class="teaser-body">
			        	<p>
			        		<a href="show_messages.php" class="teaser-link"><?php loc('message.marginal.back') ?></a><br />
			            </p>
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
