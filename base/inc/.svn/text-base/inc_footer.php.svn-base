        <!-- Footer | START -->
        <div class="footer unimportant">
            <div class="print">
            	<?php if (isset($footerMessage)) { ?>
            		<?php echo($footerMessage); ?>
            	<?php } else { ?>
					<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/agb/#disclaimer") ?>" style='padding-left:22px;float:left;'><?php loc('footer.disclaimer'); ?></a>
            	<?php } ?>
				<a rel="license" href="http://creativecommons.org/licenses/by/3.0/de/" target="_blank" onclick="this.blur();"><img alt="Creative Commons License" style="border-width:0;padding-top:1px;margin-right:-8px;" width="80" height="15" src="<?php echo(STATIC_ROOT) ?>/html/img/cc-by.png" /></a>
            </div>
            <div class="metanavi">
                <p>
					<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/faq/") ?>" title="<?php loc('footer.menu.faq') ?>">&gt;&nbsp;<?php loc('footer.menu.faq') ?></a>                	
					<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/twick.it-charta/") ?>" title="<?php loc('footer.menu.charta') ?>">&gt;&nbsp;<?php loc('footer.menu.charta') ?></a>                  	
                </p>
				<p>
                	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/api/") ?>" title="<?php loc('footer.menu.api') ?>">&gt;&nbsp;<?php loc('footer.menu.api') ?></a>
                  	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/category/tipps4twicks/") ?>" title="<?php loc('footer.menu.tipps4twicks') ?>">&gt;&nbsp;<?php loc('footer.menu.tipps4twicks') ?></a>
                </p>
                <p>
					<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/twitter/") ?>" title="<?php loc('footer.menu.twitter') ?>">&gt;&nbsp;<?php loc('footer.menu.twitter') ?></a>					
                  	<a href="<?php echo(HTTP_ROOT . "/support.php") ?>" title="<?php loc('footer.menu.support') ?>">&gt;&nbsp;<?php loc('footer.menu.support') ?></a>
                </p>
                <p>
                	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/agb/") ?>" title="<?php loc('footer.menu.terms') ?>">&gt;&nbsp;<?php loc('footer.menu.terms') ?></a>
                	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/impressum/") ?>" title="<?php loc('footer.menu.imprint') ?>">&gt;&nbsp;<?php loc('footer.menu.imprint') ?></a>
                </p>
                <p>
                	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/presse/") ?>" title="<?php loc('footer.menu.press') ?>">&gt;&nbsp;<?php loc('footer.menu.press') ?></a>
                	<a href="<?php echo("http://m.twick.it") ?>" title="<?php loc('footer.menu.mobile') ?>">&gt;&nbsp;<?php loc('footer.menu.mobile') ?></a>
                </p>
            </div>
        </div>
    	<!-- Footer | ENDE -->
    </div>
	
    <div class="clearbox"></div>
</div>
<?php 
if(isset($_GET["msg"])) {
	drillDown(_loc($_GET["msg"]));	
} else if(!isLoggedIn()) {
    if(externReferrer()) {
        drillDown(_loc("core.welcomeExtern", HTTP_ROOT . "/register_form.php"), 30000);
    }
}

if(externReferrer()) { 
?>
<script type="text/javascript">
function showUnimportants(inOpacity) {
	var unimportants = $$(".unimportant");
	for(var i=0; i<unimportants.length; i++) {
		unimportants[i].style.opacity=inOpacity;
	}	
	if(inOpacity < 1) {
		window.setTimeout("showUnimportants(" + (inOpacity+0.05) + ")", 100);
	}
}
window.setTimeout("showUnimportants(0.3)", 2700);
</script>
<?php
}
?>


<script type="text/javascript">
var previousMessageText = null;
new Ajax.PeriodicalUpdater(
	'message_counter', 
	'<?php echo(HTTP_ROOT) ?>/inc/ajax/check_messages.php', 
	{
		frequency: 30,
		onSuccess:function(inResponse) {
			if(<?php if(getArrayElement($_SESSION, "relogin")) { ?>previousMessageText == null || <?php } ?>previousMessageText != null && inResponse.responseText != previousMessageText) {
				window.setTimeout("if($('unread')) {$('unread').pulsate({pulses:12, duration:4, from:0.3});}", 1000);
			}
			previousMessageText = inResponse.responseText;
		}
	}
);
</script>


<?php
if(getArrayElement($_SESSION, "relogin")) {
    unset($_SESSION["relogin"]);
}

echo($footerContent);

#alert( getArrayElement($_COOKIE , "twickit_token", false));
?>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js">
  {lang: '<?php echo(getLanguage()) ?>'}
</script>