<?php if(!getArrayElement($_GET, "plain")) { ?>
<div class="class_footer">
	<a href="#top" style="border-top: 1px solid #638301;margin-top:15px;"><b>&nbsp;</b> <?php loc('mobile.menu.top') ?> &raquo;</a>
	<?php if($user) { ?>
	<a href="messages.php" accesskey="1"><b>1</b> <?php loc('mobile.menu.messages') ?> &raquo;</a>
    <?php } else { ?>
	<a href="index.php" accesskey="1"><b>1</b> <?php loc('mobile.menu.home') ?> &raquo;</a>
	<?php } ?>
	<a href="nearby.php" accesskey="2"><b>2</b> <?php loc('mobile.menu.nearest') ?> &raquo;</a>
	<a href="latest.php" accesskey="3"><b>3</b> <?php loc('mobile.menu.latest') ?> &raquo;</a>
    <a href="http://twick.it/blog/<?php echo(getLanguage()) ?>" accesskey="4"><b>4</b> Blog &raquo;</a>
    <a href="support.php" accesskey="5"><b>5</b> <?php loc('mobile.menu.support') ?> &raquo;</a>
    <?php if($user) { ?>
    <a href="user_data.php" accesskey="6"><b>6</b> <?php loc('mobile.menu.userData') ?> &raquo;</a>
	<a href="action/logout.php?secret=<?php echo($user->getSecret()) ?>&r=<?php echo(urlencode($_SERVER["REQUEST_URI"])) ?>" accesskey="7"><b>7</b> <?php loc('mobile.menu.logout') ?> &raquo;</a>
	<?php } else { ?>
    <a href="register.php" accesskey="6"><b>6</b> <?php loc('mobile.menu.register') ?> &raquo;</a>
	<a href="login.php?r=<?php echo(urlencode($_SERVER["REQUEST_URI"])) ?>" accesskey="7"><b>7</b> <?php loc('mobile.menu.login') ?> &raquo;</a>
	<?php } ?>
    <a href="impress.php" accesskey="8"><b>8</b> <?php loc('mobile.menu.imprint') ?> &raquo;</a>
    <a href="languages.php" accesskey="9"><b>9</b> <?php loc('mobile.menu.language') ?> <img src="<?php echo(STATIC_ROOT) ?>/html/img/sprache_<?php echo(getLanguage()) ?>.jpg" alt="<?php echo(getLanguage()) ?>" style="border:none;vertical-align:middle;width:12px;" /> &raquo;</a>
    <a href="<?php echo($noMobileUrl) ?>&lng=<?php echo(getLanguage()) ?>" accesskey="0"><b>0</b> <?php loc('mobile.menu.quitMobile') ?> &raquo;</a>
	<br /><div style="font-size:10px;padding:5px;"><?php loc('mobile.footer.licence') ?></div>
</div>
<?php } ?>
<?php if(!isAdmin()) { ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-9717715-2']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php } ?>