<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

if(isLoggedIn()) {
	redirect("user_data.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('userdata.registration.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('userdata.registration.title') ?>" />
    <meta name="description" content="<?php loc('userdata.registration.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
	<script type="text/javascript" src="html/js/twickit/twickit_userdata_js.php"></script>
	<?php include("inc/inc_global_header.php"); ?>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
	    <!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('userdata.registration.headline') ?></h1>
		</div>
    
	   	<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
			
				<!-- EINGABE-Sprechblase | START -->
                <div class="sprechblase">
					<h2><?php loc('userdata.headline') ?>:</h2>
					
					<div class="sprechblase-main">
						<div class="sprechblase-links"><i>&nbsp;</i>
				            <div class="bilderrahmen"><img src="html/img/avatar.jpg" alt="" /></div>
				            <i><a href="<?php echo(getBlogUrl()) ?>/faq/#foto" target="_blank"><?php loc('userdata.changeImage') ?></a></i>
				      	</div>
				        <div class="sprechblase-rechts">
				        <div class="blase-header" id="eingabeblase-head"></div>
				            <div class="blase-body">
				                <form class="eingabeblase" id="twickit-blase" action="register.php" method="post" name="userForm" style="width:320px;">
				              		<?php echo(SpamBlocker::printHiddenTags()) ?>
                                    <noscript>
                                        <span style="color:#F00;font-size:14px;"><?php loc('userdata.register.noJS') ?></span>
                                    </noscript>
				                    <label for="login"><?php loc('userdata.username') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
				                    <input name="login" type="text" onkeyup="checkLogin()" autocomplete="off"/>
				                    <div id="checkLogin"></div>
				                    
				                    <label for="mail"><?php loc('userdata.email') ?> <span>(<?php loc('userdata.required') ?>) - <?php loc('userdata.email.noSpam') ?></span></label>
				                    <input name="mail" type="text" onkeyup="checkMail()"/>
				                    <div id="checkMail"></div>
				                    
				                    <label for="password"><?php loc('userdata.password') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
				                    <input name="password" type="password" onkeyup="checkPassword();"/>
				                    <div id="checkPassword"></div>
				                    
				                    <label for="password2"><?php loc('userdata.password2') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
				                    <input name="password2" type="password"  onkeyup="comparePasswords()"/>
				                    <div id="checkPassword2"></div>
				                    
				                    <label for="newsletter"><?php loc('userdata.newsletter') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
				                    <input type="checkbox" class="checkbox" name="newsletter" /> <?php loc('userdata.newsletter') ?><br />
				                    
				                    <label for="agb"><?php loc('userdata.terms', '/blog/agb/') ?></label>
				                    <input type="checkbox" name="agb" class="checkbox" onclick="checkAgb()"/> <?php loc('userdata.terms', HTTP_ROOT . '/blog/agb/') ?>
				                    <div id="checkAgb"></div><br />
				                   				                    
				                    <a href="javascript:;" onclick="doPopup('<?php loc('userdata.error') ?>')" id="createLink" class="disabled"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('userdata.register') ?></a><br style="clear:both;"/>
				                    
				                    <br /> 
				                    <?php loc('userdata.changeText') ?>
				                </form>    
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer"></div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- EINGABE-Sprechblase | ENDE -->
	
				<script type="text/javascript">
					checkPassword();
					checkMail();
					checkLogin();
					checkAgb();
				</script>
			
			
				<?php if($error = getArrayElement($_GET, "error")) {
					popup(_loc($error) . "<br /><br /><br />");
					drillDown(loc('userdata.error.occure'));
				}?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Login | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('userdata.login.title') ?></h2></div>
			        <div class="teaser-body">
			        	<p>
			                <form id="loginForm" action="action/login.php?url=<?php echo urlencode(getArrayElement($_GET, "url")) ?>" method="post">
		                    	<label for="login" style="width:70px;display:block;float:left;"><?php loc('userdata.login.login') ?>:&nbsp;</label><input type="text" name="login" onfocus="this.select()"/>
		                       	<label for="password" style="width:70px;display:block;float:left;"><?php loc('userdata.login.password') ?>:&nbsp;</label><input type="password" name="password" onfocus="this.select()"/>
		                    </form>
		                    <br />
	                        <a href="javascript:;" onclick="$('loginForm').submit();" title="login" class="teaser-link" ><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" witdh="15" height="9"/><?php loc('userdata.login.button') ?></a><br />
			            </p>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Login | ENDE -->  
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('userdata.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			                <ol>
			                	<li><?php loc('userdata.info.text.1') ?></li>
			                	<li><?php loc('userdata.info.text.2') ?></li>
			                	<li><?php loc('userdata.info.text.3') ?></li>
			                	<li><?php loc('userdata.info.text.4') ?></li>
			                	<li><?php loc('userdata.info.text.5') ?></li>
			                </ol> 
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
