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
			<li><a href="admin/walls.php">Quasselecken</a></li>
			<li><a href="admin/bullshit.php">Bullshit</a></li>
            <li><a href="admin/deleted.php">Gelöschte Twicks</a></li>
			<li><a href="admin/url_stats.php">URL-Statistik</a></li>
			<li><a href="admin/newsletter.php">Newsletter-Empfänger</a></li>
			<li><a href="admin/wiki_import.php">Wikipedia-Import</a></li>
		</ul>
	</div>
	<?php } ?>
	
    <!-- Main-Navigation | START -->
	<div class="navi unimportant">
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
        
        <?php if(false && $loggedInUser = getUser()) { ?>
        	<?php if ($activeTab == "favs") { ?>
	        <a href="<?php echo($loggedInUser->getUrl()) ?>/favorites" id="bt_favoriten-aktiv" class="mainnavi"><div id="favoriten-link" class="<?php echo($language) ?>"></div></a>
	        <?php } else { ?>
	        <a href="<?php echo($loggedInUser->getUrl()) ?>/favorites" id="bt_favoriten" class="mainnavi" onmouseover="hover('favoriten')" onmouseout="reset('favoriten')"><div id="favoriten-link" class="<?php echo($language) ?>"></div></a>
	        <?php } ?> 
		<?php } ?> 
		
		<?php if ($activeTab == "blog") { ?>
        <a href="http://twick.it/blog/<?php echo(getLanguage()) ?>/" id="bt_blog-aktiv" class="mainnavi"><div id="blog-link" class="<?php echo($language) ?>"></div></a>
        <?php } else { ?>
        <a href="http://twick.it/blog/<?php echo(getLanguage()) ?>/" id="bt_blog" class="mainnavi" onmouseover="hover('blog')" onmouseout="reset('blog')"><div id="blog-link" class="<?php echo($language) ?>"></div></a>
        <?php } ?>

        <?php if(getLanguage() == "de") { ?>
        <?php if ($activeTab == "podcast") { ?>
        <a href="podcast.php" id="bt_podcast-aktiv" class="mainnavi"><div id="podcast-link" class="<?php echo($language) ?>"></div></a>
        <?php } else { ?>
        <a href="podcast.php" id="bt_podcast" class="mainnavi" onmouseover="hover('podcast')" onmouseout="reset('podcast')"><div id="podcast-link" class="<?php echo($language) ?>"></div></a>
        <?php } ?>
        <?php } else { ?>
        <a href="javascript:" onclick="alert('Podcast is only available in German version')" id="bt_podcast" class="mainnavi" onmouseover="hover('podcast')" onmouseout="reset('podcast')"><div id="podcast-link" class="<?php echo($language) ?>"></div></a>
        <?php } ?>
    </div>
    <!-- Main-Navigation | ENDE -->
    
	<div class="main" id="main">
    	<!-- Header | START -->
            <!-- Login-Bereich | START -->
            <div class="header-login<?php if(isLoggedIn ()) { ?> header-loggedin<?php } ?> unimportant">
           
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
	                	<a href="<?php echo($loggedInUser->getUrl()) ?>" title="<?php loc('header.title.user') ?>" id="header_avatar"><img src="<?php echo($loggedInUser->getAvatarUrl(22)) ?>" style="vertical-align:top" width="22" height="22" /></a> <?php loc('header.welcomeMessage', array('<a href="' . $loggedInUser->getUrl() .'">' . $loggedInUser->getLogin() . '</a>')) ?>
                        <a rel="nofollow" href="messages" id="message_counter" title="<?php loc('header.title.messages') ?>"></a>
	                </div>
	            	<div class="anmeldung">
	                    <a rel="nofollow" href="action/logout.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>&secret=<?php echo($loggedInUser->getSecret()) ?>" class="ausloggen-<?php echo($language) ?>" >&nbsp;</a>
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
						&nbsp;<a rel="nofollow" href="action/twitter_login.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>"><img src="html/img/signin_twitter_s.png" title="<?php loc('oauth.twitter.login') ?>" alt=""/></a>
                        <a rel="nofollow" href="action/facebook_login.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>"><img src="html/img/signin_facebook_s.png" title="<?php loc('oauth.facebook.login') ?>" alt=""/></a>
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
            
            <!-- Suchfeld oder Wissensbaum | START -->
            <?php 
            $searchMode = getArrayElement($_COOKIE, "searchMode", "form");
            $searchMode = "form"; // Baum erst einmal ausschalten!
            ?>
            <div class="header-suchfeld unimportant" id="header-suchfeld">
            	<?php if($enableSearchSwitch) { ?>
            	<div class="suchnavigation">
                	<a href="javascript:;" onclick="showForm();this.blur();" id="searchModeButtonForm" class="bt_suchfeld-<?php echo($language) ?>"></a>
                    <a href="javascript:;" onclick="showTree();this.blur();" id="searchModeButtonTree" class="bt_wissensbaum-inaktiv-<?php echo($language) ?>"></a>
                    <div class="clearbox"></div>
                </div>

				<div id="baum" style="display:none;">
	            	<?php include("inc/inc_tree.php") ?>
	            </div>
	            <?php } else { ?>
	            <div class="suchnavigation">
                    <br />
                    <div class="clearbox"></div>
                </div>
	            <?php } ?>

                <form id="suche" action="find_topic.php" name="searchForm">
                    <!-- Klapp-Menue - START -->
                    <div id="such-klappfeld"><input name="search" id="search" type="text" autocomplete="off" onblur="$('such-klappfeldinhalt').fade({duration: 2});this.className='';if(this.value=='') {this.style.color='#C9C9C9';this.value='<?php loc('header.searchText') ?>'}" onfocus="if(this.value=='<?php loc('header.searchText') ?>') {this.value='';};this.style.color='#666';this.select(); " value="<?php loc('header.searchText') ?>" style="color:#C9C9C9" /></div>  
                    <a href="javascript:;" onclick="$('suche').submit();" class="suchestarten" ></a>
                   	<div id="such-klappfeldinhalt" class="totenauswahl" style="display:none;"> 
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
						$("search").focus();
					}
				</script>
				 
				<?php if($enableSearchSwitch) { ?> 
				<script type="text/javascript">
        			function showTree() {
        				$('suche').hide();
        				$('baum').show();
        				init();
						document.cookie='searchMode=tree;expires=' + inOneYear + ';';
						$("searchModeButtonTree").className = "bt_wissensbaum-<?php echo($language) ?>";
						$("searchModeButtonForm").className = "bt_suchfeld-inaktiv-<?php echo($language) ?>";
						$("header-suchfeld").style.backgroundImage = "none";
                        new Effect.Morph($("header-suchfeld"), {style:'height:300px;', duration:0.5});
            		}	

        			function showForm() {
        				$('suche').appear();
        				$('baum').hide();
						document.cookie='searchMode=form;expires=' + inOneYear + ';';
						$("searchModeButtonTree").className = "bt_wissensbaum-inaktiv-<?php echo($language) ?>";
						$("searchModeButtonForm").className = "bt_suchfeld-<?php echo($language) ?>";
						$("header-suchfeld").style.backgroundImage = "url(html/img/logo.jpg)";
                        new Effect.Morph($("header-suchfeld"), {style:'height:150px;', duration:0.5});
            		}	

        			<?php if($searchMode == "tree") { ?>
            		showTree();
            		<?php } ?>
            	</script>
            	<?php } ?>
            </div>
            <!-- Suchfeld oder Wissensbaum | ENDE -->
              
        <!-- Header | ENDE -->
