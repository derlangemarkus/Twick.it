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
	function updateCharCounter2(inId) {
		var counterId = "charCounter";
		if (inId != null) {
			counterId += inId;
		}

		var textfieldId = "textfield";
		if (inId != null) {
			textfieldId += inId;
		}

		
		var textLength = $(textfieldId).value.length;
		var charsLeft = 140-textLength;
		$(counterId).update(charsLeft);
		
		if (charsLeft < 0) {
			disableTwickitButton(inId);
			$(counterId).className = "charCounterError";
			$(textfieldId).className = "error";
		} else if (charsLeft == 140) {
			disableTwickitButton(inId);
		} else {
			enableTwickitButton(inId);
			$(counterId).className = "charCounterOK";
			$(textfieldId).className = "ok";
		}

		if ($("topictitle").value == "") {
			disableTwickitButton(inId);
		}
	}
	</script>
	<style type="text/css">
		#toptext {width:430px;height:230px;display:block;float:left;padding:110px 20px 0px 40px;background-color:#FFF;font-size:14px;}
		#toptext h1 {font-size:22px; color:#709700;padding-left:0px;}
		#toptext h2 {font-size:27px; color:#323232;padding-left:0px;line-height:30px;}
		
		.infobox {display:block;float:left;width:210px;margin:30px 8px 0px 32px;}
		.infobox h1 {font-size:22px; color:#709700;padding-left:20px;}
		
		.infobox_klein {display:block;width:212px;height:417px;background-image:url(siegen/img/bg_box_kl.jpg);background-repeat:no-repeat;}
		.infobox_klein img {padding:15px 0px 0px 20px;}
		.infobox_gross {padding:19px 0px 0px 20px;display:block;width:352px;height:417px;background-image:url(siegen/img/bg_box_gross.jpg);background-repeat:no-repeat;}
		.infobox_gross span {display:block;float:left;width:306px;font-size:14px;}
		.infobox_gross a {display:block;float:left;font-size:22px; color:#709700;padding:20px 55px 20px 130px;background-image:url(siegen/img/btn_weiter_kl.jpg);background-repeat:no-repeat;background-position:260px 10px;}
		.infobox_gross a:hover, .infobox_gross a:active {color:#323232;}
		
		#toptextblase {width:430px;height:330px;display:block;float:left;padding:65px 20px 0px 40px;background-color:#FFF;font-size:14px;background-image:url(siegen/img/sprechblase.jpg);background-repeat:no-repeat;background-position:40px 40px;}
		#toptextblase h1 {font-size:20px; color:#709700;padding-left:20px;}
		#toptextblaselinks {padding-left:20px;width:60px;height:300px;float:left;display:block;}
		#toptextblaselinks img {padding:1px; border:1px solid #709700}
		#toptextblase form input, #toptextblase form textarea {width:300px;}
		#charCounter {margin-left:250px;}
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
		<h1>Admin-Menü:</h1>
		<ul>
			<li><a href="admin/bullshit.php">Bullshit</a></li>
			<li><a href="admin/url_stats.php">URL-Statistik</a></li>
			<li><a href="admin/newsletter.php">Newsletter-Empfänger</a></li>
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
			<?php if (isLoggedIn()) { ?>
			<div id="toptextblase">
				<div id="toptextblaselinks"><a href="<?php echo($user->getUrl()) ?>" title="<?php echo($user->getDisplayName()) ?>"><?php echo($user->getAvatar(54)) ?></a></div>
				<div style="float:left;width:300px;margin-left:0px!important;">
				<h1>Deine Erklärung in 140 Zeichen</h1>
				<form class="eingabeblase" id="twickit-blase" action="confirm_twick.php" method="get" name="twickForm" style="margin-top:-11px;">
                    <?php echo(SpamBlocker::printHiddenTags()) ?>
                    <label for="title"><?php loc('yourTwick.topic') ?> <span>(<?php loc('yourTwick.required') ?>)</span>:</label>
  					<input type="text" name="title" value="<?php echo($title) ?>" id="topictitle" onkeyup="updateCharCounter2()" onkeypress="updateCharCounter2()"/>
                    <label for="text"><?php loc('yourTwick.text') ?> <span>(<?php loc('yourTwick.required') ?>)</span>:</label>
					<div id="charCounter" class="charCounterOK"><?php echo(140 - mb_strlen(getArrayElement($_GET, "new_text", ""), "utf8")) ?></div>
                    <textarea name="text" id="textfield" onkeyup="updateCharCounter2()" onkeypress="updateCharCounter2()"><?php echo(getArrayElement($_GET, "new_text", "")) ?></textarea>
                    <label for="link"><?php loc('yourTwick.url') ?> <span>(<?php loc('yourTwick.optional') ?>)</span>:</label>
                    <input name="link" type="text" value="<?php echo(htmlspecialchars(getArrayElement($_GET, "new_link", ""))) ?>" />
                </form>    
                <br />
				<a href="javascript:;" id="twickit" class="twickitpreview-off" style="padding-left:235px;"><?php loc('yourTwick.preview') ?></a>
				</div>
			</div>
			<?php } else { ?>
			<div id="toptext">
				<h1>Unser Siegen</h1>
				<h2>Willkommen zum Erklär- wettbewerb der Stadt Siegen</h2>
				Am NRW-Tag vom 17.-19.09. werden ca. 300.000 Besucher in Siegen erwartet. Zeige den Gästen deine Stadt und erkläre Begriffe rund um Siegen in max. 140 Zeichen. Als Gewinn winken exklusive VIP-Tickets.
			</div>    		
			<?php } ?>
			<div style="padding:120px 0px <?php if (isLoggedIn()) { ?>88px<?php } else { ?>33px<?php } ?> 20px;display:block;float:left;background-color:#FFF;background-repeat:no-repeat;background-image:url(html/img/logo.jpg);background-position:230px 43px;"><img src="siegen/img/frosch_liegend.jpg" alt="" /></div>
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
					<?php if (isLoggedIn()) { ?>
					<h1 style="padding-left:7px;">Der Erklärwettbewerb:</h1>
					<div class="infobox_gross">
						<span>Am NRW-Tag vom 17.-19.09. werden ca. 300.000 Besucher in Siegen erwartet. Zeige den Gästen deine Stadt und erkläre Begriffe rund um Siegen in max. 140 Zeichen. Als Gewinn winken exklusive VIP-Tickets.</span>
					</div>
					<?php } else { ?>
					<h1 style="padding-left:7px;">Jetzt registrieren &amp; mitmachen:</h1>
					<div class="infobox_gross">
						<span>Wie im Video bereits erklärt, musst Du Dich registrieren, um mitzumachen. Keine Angst, 
						es dauert nicht lange und tut auch gar nicht weh.</span><br />
						<a href="register_form.php">Registrieren</a>
					</div>
					<?php } ?>
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
					<a href="javascript:;" onclick="$('film1').hide();">Schließen</a>	
					
					<script language="javascript">
					if (AC_FL_RunContent == 0) {
						alert("Diese Seite erfordert die Datei \"AC_RunActiveContent.js\".");
					} else {
						AC_FL_RunContent(
							'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
							'width', '640',
							'height', '480',
							'src', 'http://twick.it/siegen/film1',
							'quality', 'best',
							'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
							'align', 'middle',
							'play', 'true',
							'loop', 'true',
							'scale', 'showall',
							'wmode', 'window',
							'devicefont', 'false',
							'id', 'film1',
							'bgcolor', '#ffffff',
							'name', 'http://twick.it/siegen/film1',
							'menu', 'true',
							'allowFullScreen', 'false',
							'allowScriptAccess','sameDomain',
							'movie', 'http://twick.it/siegen/film1',
							'salign', ''
							); //end AC code
					}
					</script>
					<noscript>
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="640" height="480" id="film1" align="middle">
						<param name="allowScriptAccess" value="sameDomain" />
						<param name="allowFullScreen" value="false" />
						<param name="movie" value="http://twick.it/siegen/film1.swf" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" />	<embed src="film1.swf" quality="best" bgcolor="#ffffff" width="640" height="480" name="film1" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
						</object>
					
					</noscript>
				</div>
			
				<div id="film2" style="background-color:#000;width:640px;padding:8px;position:absolute;margin-top:-570px;margin-left:120px;z-index:9999;display:none;">
					<a href="javascript:;" onclick="$('film2').hide();">Schließen</a>	
					
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