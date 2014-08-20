<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 

$_SESSION["startpage"] = "siegen/index.php";
$activeTab = "start";

$user = getUser();
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
	<script type="text/javascript">
	function nextTwick() {
		$("randomNext").hide();
		$("randomWait").show();
		new Ajax.Request(
			"siegen/tickertape.php", 
			{
				method: 'GET',
			  	onSuccess: function(transport) {
					$("randomWait").hide();
					$("randomNext").show();
					var info = transport.responseText.evalJSON(true);
					
					$("randomAvatar").src = info[0].Avatar.replace(/&amp;/, "&");
					$("randomUser").update(info[0].User);
					$("randomTitle").href = info[0].Url;
					$("randomTitle").update(info[0].LinkText);
					$("randomText").update(info[0].Title + '<br /><a href="javascript:;" onclick="nextTwick()" class="teaser-link" id="randomNext"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9" style="padding-top:4px;" />N‰chster</a>');
					
		  		}	
			}
		);
	}
	</script>
	<style type="text/css">
		#toptext {width:430px;height:278px;display:block;float:left;padding:110px 20px 0px 40px;background-color:#FFF;font-size:14px;}
		#toptext h1 {font-size:22px; color:#709700;padding-left:0px;}
		#toptext h2 {font-size:27px; color:#323232;padding-left:0px;line-height:30px;}
		
		.infobox {display:block;float:left;width:210px;margin:30px 8px 0px 32px;}
		.infobox h1 {font-size:22px; color:#709700;padding-left:20px;}
		
		.infobox_klein {display:block;width:212px;height:417px;background-image:url(siegen/img/bg_box_kl.jpg);background-repeat:no-repeat;}
		.infobox_klein img {padding:15px 0px 0px 20px;}
		.infobox_gross {padding:19px 0px 0px 20px;display:block;width:352px;height:417px;background-image:url(siegen/img/bg_box_gross.jpg);background-repeat:no-repeat;}
		.infobox_gross span {display:block;float:left;width:306px;font-size:12px;line-height:normal;}
		
		.totenauswahl2 {width:334px!important}
		*+html .totenauswahl2 {width:334px!important;margin-left:-390px!important;}
		* html .totenauswahl2 {width:334px!important;margin-left:-390px!important;}
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
		<h1>Admin-Men?:</h1>
		<ul>
			<li><a href="admin/bullshit.php">Bullshit</a></li>
			<li><a href="admin/url_stats.php">URL-Statistik</a></li>
			<li><a href="admin/newsletter.php">Newsletter-Empf?nger</a></li>
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
			<div id="toptext">
				<h1>Unser Siegen</h1>
				<h2>Willkommen in Siegen</h2>
				Vom 17. bis zum 19. September feiert Siegen den NRW-Tag. Hier erkl&auml;ren Dir Siegener ihre Stadt in ihren Worten. <br />

				<form id="suche" action="find_topic.php" name="searchForm" style="padding-top:25px; padding-left:0px;">
                    <!-- Klapp-Menue - START -->
                    <div id="such-klappfeld"><input name="search" id="search" type="text" autocomplete="off" onblur="$('such-klappfeldinhalt').fade({duration: 2});" onfocus="this.select();" style="width:330px;"/></div>  
                    <a href="javascript:;" onclick="$('suche').submit();" class="suchestarten" ></a>
                   	<div id="such-klappfeldinhalt" class="totenauswahl totenauswahl2" style="display:none;""> 
                      	<!-- Klappmenue-Inhalt - START -->
                        <ul id="searchSuggest"></ul>
                        <div class="clearbox"></div>
                        <!-- Klappmenue-Inhalt - ENDE -->
                    </div>
                    <!-- Klapp-Menue - ENDE -->
                </form>
				<script type="text/javascript">
					$("search").onkeyup = searchUpDown;
					if (window.location.hash == null || window.location.hash == "") {
						Event.observe(
							window, 
							'load', 
							function() {
								$("search").focus();
							}
						);
					}
				</script>
				<br /><br /><br />
				<a href="siegen/all_topics.php">Klicke hier f&uuml;r eine alphabetische Auflistung der Erkl&auml;rungen</a>
			</div>    		
			<div style="padding:120px 0px 33px 20px;display:block;float:left;background-color:#FFF;background-repeat:no-repeat;background-image:url(html/img/logo.jpg);background-position:230px 43px;"><img src="siegen/img/frosch_fragezeichen.jpg" alt="" style="padding-right:100px"/></div>
   		</div>
   		
   		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links" style="width:920px;height:245px;background-image:url(siegen/img/bg_verlauf.jpg);background-repeat: repeat-x;">
				<div id="howto" class="infobox">
					<h1>So geht's:</h1>
					<div class="infobox_klein">
						<a href="javascript:;" onclick="$('film1').show();"><img src="/siegen/img/preview1.jpg" border="0" width="170"/></a>
					</div>
				</div>
				<div id="wdr" class="infobox">
					<h1>Das ist Twick.it:</h1>
					<div class="infobox_klein">
						<a href="javascript:;" onclick="$('film2').show();"><img src="/siegen/img/preview2.jpg" border="0" width="170"/></a>
					</div>
				</div>
				<div id="registernow" class="infobox" style="width:350px;">
					<h1 style="padding-left:7px;">So ist Siegen:</h1>
					<div class="infobox_gross">
						<?php 
						$favorites = TwickFavorite::fetchByUserId(710);
						shuffle ($favorites);
						$favorite = array_pop($favorites);
						$twick = $favorite->findTwick();
						$user = $twick->findUser();
						?>
						<div style="line-height:17px;padding-bottom:5px;">
							<img src="<?php echo($user->getAvatarUrl(32)) ?>" style="width:32px;height:32px;float:left;margin-right:10px;border:1px solid #709700;" id="randomAvatar"/>
							<b id="randomUser"><?php echo($user->getDisplayName()) ?></b> erkl&auml;rt <br />
							<a style="font-size:14px;font-weight:bold;color:#709700;" id="randomTitle" href="<?php echo($twick->getUrl()) ?>"><?php echo($twick->getTitle()) ?></a>
						</div>
					
						<div style="float:left;">
							<span id="randomText">
							<?php echo($twick->getText()) ?><br />
							<a href="javascript:;" onclick="nextTwick()" class="teaser-link" id="randomNext"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9" style="padding-top:4px;" />N&auml;chster</a>
							</span>
							<img src="<?php echo(STATIC_ROOT) ?>/html/img/ajax-loader.gif" alt="..." id="randomWait" style="margin-top:56px;margin-left:-30px;display:none;"/>
						</div>
					</div>
				</div>
			</div>
			<!-- Linke Haelfte | ENDE -->
		
			
			<div class="clearbox" style="background-color:#FFF"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links" style="width:920px;background-color:#EFEFEF;padding-top:10px;">
				<div id="film1" style="background-color:#000;width:640px;padding:8px;position:absolute;margin-top:-570px;margin-left:120px;z-index:9999;display:none;">
					<a href="javascript:;" onclick="$('film1').hide();">Schlieﬂen</a>	
					
					<object width="640" height="505"><param name="movie" value="http://www.youtube.com/v/KhgyvsGO_J4&hl=de_DE&fs=1&color1=0x3a3a3a&color2=0x999999"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/KhgyvsGO_J4&hl=de_DE&fs=1&color1=0x3a3a3a&color2=0x999999" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object>
					
				</div>
			
				<div id="film2" style="background-color:#000;width:640px;padding:8px;position:absolute;margin-top:-570px;margin-left:120px;z-index:9999;display:none;">
					<a href="javascript:;" onclick="$('film2').hide();">Schlieﬂen</a>	
					
					<object width="640" height="505"><param name="movie" value="http://www.youtube.com/v/zVa6YsRzbq0&hl=de_DE&fs=1&color1=0x3a3a3a&color2=0x999999"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/zVa6YsRzbq0&hl=de_DE&fs=1&color1=0x3a3a3a&color2=0x999999" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object>
				</div>
			
			
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