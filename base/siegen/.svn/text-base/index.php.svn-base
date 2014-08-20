<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
$_SESSION["startpage"] = "siegen/index.php";
$activeTab = "start";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
	<meta name="google-site-verification" content="J0wbPBp478hZfTYDXu67X2sBh6A7qgEE1n6osQWWul4" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title><?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTwicks') ?>" href="interfaces/rss/latest.php?lng=<?php echo(getLanguage()) ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestTopics') ?>" href="interfaces/rss/latest_topics.php?lng=<?php echo(getLanguage()) ?>" />
	
    <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />
	
	<script language="javascript">AC_FL_RunContent = 0;</script>
	<script src="http://twick.it/siegen/AC_RunActiveContent.js" language="javascript"></script>

	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="html/js/twickit/twickit_twick_js.php"></script>
	<!--[if IE]>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/png.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/interfaces/js/popup/twickit.js"></script>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/TickerTape/TickerTape_js.php?v101"></script>
	<style type="text/css">
		.frog {float:left;display:block;width:370px;background-color:#FFF;font-size:14px;}
		.frog span {font-size:14px;width:310px;display:block;float:left;}
		a.btn {float:left;display:block;width:310px;font-size:25px;line-height:normal;background-image:url(siegen/img/btn_weiter.jpg);background-repeat:no-repeat;background-position:315px 10px;padding-right:60px;}
	</style>
</head>
<body>
	<?php 
if (!isset($activeTab)) {
	$activeTab = "";
}
$language = getLanguage();
?>
<div class="website">
	
	<?php if (isAdmin()) { ?>
	<div class="adminmenu">
		<h1>Admin-Men�:</h1>
		<ul>
			<li><a href="admin/bullshit.php">Bullshit</a></li>
			<li><a href="admin/url_stats.php">URL-Statistik</a></li>
			<li><a href="admin/newsletter.php">Newsletter-Empf�nger</a></li>
			<li><a href="admin/wiki_import.php">Wikipedia-Import</a></li>
		</ul>
	</div>
	<?php } ?>
	
    <!-- Main-Navigation | START -->
	<div class="navi">
		<?php if ($activeTab == "start") { ?>
		<a href="<?php if($_SESSION["startpage"]) { echo($_SESSION["startpage"]); } else { ?>index.php<?php } ?>" id="bt_start-aktiv" class="mainnavi"><div id="start-link" class="<?php echo($language) ?>"></div></a>
		<?php } else { ?>
		<a href="<?php if($_SESSION["startpage"]) { echo($_SESSION["startpage"]); } else { ?>index.php<?php } ?>" id="bt_start" class="mainnavi" onmouseover="hover('start')" onmouseout="reset('start')"><div id="start-link" class="<?php echo($language) ?>"></div></a>
		<?php }?>
        
        <?php if ($activeTab == "user") { ?>
        <a href="show_users.php" id="bt_benutzer-aktiv" class="mainnavi"><div id="benutzer-link" class="<?php echo($language) ?>"></div></a>
        <?php } else { ?>
		<a href="show_users.php" id="bt_benutzer" class="mainnavi" onmouseover="hover('benutzer')" onmouseout="reset('benutzer')"><div id="benutzer-link" class="<?php echo($language) ?>"></div></a>
		<?php }?>
		
		<?php if ($activeTab == "dashboard") { ?>
        <a href="dashboard.php" id="bt_dashboard-aktiv" class="mainnavi"><div id="dashboard-link" class="<?php echo($language) ?>"></div></a>
        <?php } else { ?>
        <a href="dashboard.php" id="bt_dashboard" class="mainnavi" onmouseover="hover('dashboard')" onmouseout="reset('dashboard')"><div id="dashboard-link" class="<?php echo($language) ?>"></div></a>
        <?php }?>
        
        <?php if(isLoggedIn()) { ?> 
        	<?php if ($activeTab == "favs") { ?>
	        <a href="show_favorites.php" id="bt_favoriten-aktiv" class="mainnavi"><div id="favoriten-link" class="<?php echo($language) ?>"></div></a>
	        <?php } else { ?>
	        <a href="show_favorites.php" id="bt_favoriten" class="mainnavi" onmouseover="hover('favoriten')" onmouseout="reset('favoriten')"><div id="favoriten-link" class="<?php echo($language) ?>"></div></a>
	        <?php } ?> 
		<?php } ?> 
		
		<?php if ($activeTab == "blog") { ?>
        <a href="../blog/<?php echo(getLanguage()) ?>/" id="bt_blog-aktiv" class="mainnavi"><div id="blog-link" class="<?php echo($language) ?>"></div></a>
        <?php } else { ?>
        <a href="../blog/<?php echo(getLanguage()) ?>/" id="bt_blog" class="mainnavi" onmouseover="hover('blog')" onmouseout="reset('blog')"><div id="blog-link" class="<?php echo($language) ?>"></div></a>
        <?php } ?>
    </div>
    <!-- Main-Navigation | ENDE -->
    
	<div class="main" id="main">
    	<!-- Header | START -->
            <!-- Login-Bereich | START -->
            <div class="header-login">
           
				<!-- Klapp-Menue - START -->
                <div class="klappmenue" id="sprachen" title="<?php loc('header.selectLanguage') ?>"><a href="#" target="_self" title="<?php loc('header.selectLanguage') ?>"><img src="<?php echo(STATIC_ROOT) ?>/html/img/sprache_<?php echo(getLanguage()) ?>.jpg" alt="<?php echo(getLanguage()) ?>"  /></a></div>  
                <div id="sprachwahl" class="ausgeklappt"> 
                    <!-- Klappmenue-Inhalt - START -->
					<?php foreach($languages as $languageData) { ?>
						<?php if ($activeTab == "blog") { ?>
                        <a href="<?php echo(HTTP_ROOT) ?>/blog/<?php echo($languageData["code"]) ?>/?lng=<?php echo($languageData["code"]) ?>" class="klapp_link" title="<?php echo($languageData["name"]) ?>"><img src="<?php echo(STATIC_ROOT) ?>/html/img/sprache_<?php echo($languageData["code"]) ?>.jpg" alt="<?php echo($languageData["name"]) ?>"  /><span>&nbsp;<?php echo($languageData["name"]) ?></span></a>
                        <?php } else { ?>
                        <a href="<?php echo(HTTP_ROOT) ?>/index.php?lng=<?php echo($languageData["code"]) ?>" class="klapp_link" title="<?php echo($languageData["name"]) ?>"><img src="<?php echo(STATIC_ROOT) ?>/html/img/sprache_<?php echo($languageData["code"]) ?>.jpg" alt="<?php echo($languageData["name"]) ?>"  /><span>&nbsp;<?php echo($languageData["name"]) ?></span></a>
                        <?php } ?>
                    <?php } ?> 
                    <!-- Klappmenue-Inhalt - ENDE -->
                </div>
                <script type="text/javascript">
                    at_attach("sprachen", "sprachwahl", "hover", "y", "pointer");
                </script>
                <!-- Klapp-Menue - ENDE -->

				<?php 
				$loggedInUser = getUser();
				$id = getArrayElement($_GET, "id");
				
				if ($loggedInUser) {
				?>
					<div class="anmelde-status">
	                	<a href="<?php echo($loggedInUser->getUrl()) ?>"><img src="<?php echo($loggedInUser->getAvatarUrl(22)) ?>" style="vertical-align:top" width="22" height="22" /></a> <?php loc('header.welcomeMessage', array($loggedInUser->getLogin())) ?>
	                </div>
	            	<div class="anmeldung">
	                    <a href="action/logout.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>&secret=<?php echo($loggedInUser->getSecret()) ?>" class="ausloggen-<?php echo($language) ?>" >&nbsp;</a>
	                </div>
	            	<div class="anmelde-link-box">
	            		<a href="show_favorites.php" title="<?php loc('header.favorites') ?>" id="logout-zusatz"><?php loc('header.favorites') ?></a>&nbsp;|&nbsp;
	                    <a href="user_data.php" title="<?php loc('header.editData') ?>"><?php loc('header.editData') ?></a>
	                </div>
				<?php 	
				} else {
				?>
	            	<div class="anmelde-status">
	                	<?php loc('header.loginMessage', 'register_form.php') ?>
	                </div>
	            	<div class="anmeldung">
	                	<form id="loginForm" action="action/login.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>" method="post">
	                    	<label for="login"><?php loc('header.label.user') ?>:&nbsp;</label><input type="text" name="login" id="loginField" onfocus="this.select()"/>
	                       	<label for="password"><?php loc('header.label.password') ?>:&nbsp;</label><input type="password" name="password" id="passwordField" onfocus="this.select()"/>
	                        <a href="javascript:;" onclick="$('loginForm').submit();" class="einloggen-<?php echo($language) ?>" >&nbsp;</a>
	                    </form>
	                </div>
	            	<div class="anmelde-link-box">
	                	<a href="forgot_password_form.php" title="<?php loc('header.forgotPassword') ?>"><?php loc('header.forgotPassword') ?></a>&nbsp;|&nbsp;
	                    <a href="resend_registration_mail_form.php" title="<?php loc('header.resendMail') ?>"><?php loc('header.resendMail') ?></a>&nbsp;|&nbsp;
	                    <a href="register_form.php" title="<?php loc('header.createAccount') ?>"><?php loc('header.createAccount') ?></a>
	                </div>
	                <script type="text/javascript">
	                	$("loginField").observe(
	                		'keyup', 
	                		function(inEvent) { 
	                			if (inEvent && inEvent.keyCode == 13) {
	                				$("passwordField").focus();
	                			}
	                		 }
	                	);
                	
	                	$("passwordField").observe(
	                		'keyup', 
	                		function(inEvent) { 
	                			if (inEvent && inEvent.keyCode == 13) {
	                				$("loginForm").submit();
	                			}
	                		 }
	                	);
	                </script>
                <?php 
				}
				?>
            </div>
            <!-- Login-Bereich | ENDE -->
            
           
              
        <!-- Header | ENDE -->

	
    <div id="contentFrame" style="background-color:#FFF;">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld" style="background-color:#FFF">
    		<div class="frog" style="padding:40px">
    			<a href="siegen/siegen.php"><img src="siegen/img/frosch_siegen.jpg" border="0" style="padding:0px 0px 11px 30px;"/></a><br />
    			<a href="siegen/siegen.php" class="btn">Du wohnst in Siegen? Erkläre Deine Stadt!</a>
    			<span>Wer könnte Dinge aus Siegen besser erklären als du? Mach mit beim Erklärwettbewerb und werde Siegens erster Erklärkönig.</span>
    		</div>
    		<div style="background-color:#FFF;float:left;display:block;width:10px;height:523px;background-image:url(siegen/img/trennlinie.jpg);background-repeat:no-repeat;background-position:0px 45px;"></div>
    		<div class="frog" style="padding:100px 40px 40px 40px; height:383px;background-repeat:no-repeat;background-image:url(html/img/logo.jpg);background-position:280px 43px;">
    			<a href="siegen/nrw.php"><img src="siegen/img/frosch_fragezeichen.jpg" border="0" style="padding:0px 0px 30px 30px;"/></a><br />
    			<a href="siegen/nrw.php" class="btn">Du möchtest den NRW-Tag besuchen?</a>
    			<span>Hier kannst du dir Siegen erklären lassen.</span>
    		</div>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links" style="width:920px;background-color:#EFEFEF;padding-top:10px;">
				<!-- Laufschrift | START  -->
				<script type="text/javascript">new TickerTape('/siegen/tickertape.php', 'horizontalTickerTape', 2000, true);</script>
				<!-- Laufschrift | ENDE -->
				
				<div style="width:68px;height:55px;display:block;position:absolute;margin-top:-60px;background-image:url(html/img/fade_l.png); background-repeat:repeat-y;"></div>
				<div style="width:68px;height:55px;display:block;position:absolute;margin-left:852px;margin-top:-60px;background-image:url(html/img/fade_r.png); background-repeat:repeat-y;"></div>

			</div>
			<!-- Linke Haelfte | ENDE -->
		
		
		<div class="clearbox" style="background-color:#FFF"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>

        <!-- Footer | START -->
        <div class="footer">
            <div class="print">
            	<?php if (isset($footerMessage)) { ?>
            		<?php echo($footerMessage); ?>
            	<?php } else { ?>
            	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/agb/#disclaimer") ?>" style="padding-left:22px;float:left;"><?php loc('footer.disclaimer'); ?></a>
            	<a rel="license" href="http://creativecommons.org/licenses/by/3.0/de/" target="_blank" onclick="this.blur();"><img alt="Creative Commons License" style="border-width:0;padding-top:1px;margin-right:-8px;" width="80" height="15" src="<?php echo(STATIC_ROOT) ?>/html/img/cc-by.png" /></a>
            	<?php } ?>
            </div>
            <div class="metanavi" style="background-image:url(http://twick.it/base/siegen/img/footer.gif);background-position:right 10px;">
                <p>
					<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/faq/") ?>" title="<?php loc('footer.menu.faq') ?>">&gt;&nbsp;<?php loc('footer.menu.faq') ?></a>                	
					<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/presse/") ?>" title="<?php loc('footer.menu.press') ?>">&gt;&nbsp;<?php loc('footer.menu.press') ?></a>
                </p>
                <p>
                	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/agb/") ?>" title="<?php loc('footer.menu.terms') ?>">&gt;&nbsp;<?php loc('footer.menu.terms') ?></a>
                	<a href="<?php echo(HTTP_ROOT . "/blog/" . getLanguage() . "/impressum/") ?>" title="<?php loc('footer.menu.imprint') ?>">&gt;&nbsp;<?php loc('footer.menu.imprint') ?></a>
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
}

include(DOCUMENT_ROOT . "/inc/inc_analytics.php"); 
?>


</body>
</html>