<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
checkLogin();

$user = getUser();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('userdata.title', $user->getLogin()) ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('userdata.title', $user->getLogin()) ?>" />
	<meta name="description" content="<?php loc('userdata.title', $user->getLogin()) ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
    <script type="text/javascript" src="html/js/twickit/twickit_userdata_js.php"></script>
	<script type="text/javascript">
		var userDataValidationLogin = true;
		var userDataValidationPassword = true;
		var userDataValidationPassword2 = true;
		var userDataValidationMail = true;
		var userDataValidationAgb = true;
		login = "<?php echo($user->getLogin()) ?>";
		skipPasswordTest = true;
	</script>
</head>
<body>
<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
	    <!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><span id="topicTitle"><?php echo($user->getLogin()) ?></span> - <?php loc('userdata.headline') ?></h1>
		</div>
    
	   	<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
			
				<!-- EINGABE-Sprechblase | START -->
                <div class="sprechblase">
                	<br />
					<div class="sprechblase-main">
						<div class="sprechblase-links"><i>&nbsp;</i>
				            <div class="bilderrahmen"><a href="<?php echo($user->getUrl()) ?>"><?php echo($user->getAvatar(64)) ?></a></div>
				            <i><a href="<?php echo(getBlogUrl()) ?>/faq/#foto" target="_blank"><?php loc('userdata.changeImage') ?></a></i>
				      	</div>
				        <div class="sprechblase-rechts">
				        <div class="blase-header" id="eingabeblase-head"></div>
				            <div class="blase-body">
								<form class="eingabeblase" action="action/save_user_data.php" name="userForm" method="post" id="twickit-blase" style="width:320px;">
									<label for="login"><?php loc('userdata.username') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
									<input type="text" name="login" value="<?php echo($user->getLogin()) ?>" autocomplete="off" onkeyup="checkLogin()"/>
									<div id="checkLogin"></div>

                                    <?php if($user->getThirdpartyId()) { ?>
                                    <?php } else { ?>
									<label for="mail"><?php loc('userdata.email') ?> <span> (<?php loc('userdata.required') ?>) - <?php loc('userdata.email.noSpam') ?></span></label>
									<input type="text" name="mail" value="<?php echo($user->getMail()) ?>" onkeyup="checkMail()"/>
									<div id="checkMail"></div>
									
									<label for="password"><?php loc('userdata.password') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
									<input type="password" name="password" value="" onkeyup="checkPassword()" autocomplete="off"/>
									<div id="checkPassword"></div>
									
									<label for="password2"><?php loc('userdata.password2') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
									<input type="password" name="password2" value="" onkeyup="comparePasswords()" autocomplete="off"/>
									<div id="checkPassword2"></div>
                                    <?php } ?>
									
									<label for="name"><?php loc('userdata.name') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
									<input type="text" name="name" value="<?php echo($user->getName()) ?>"/>
									
									<label for="link"><?php loc('userdata.url') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
									<input type="text" name="link" value="<?php echo($user->getLink()) ?>"/>
									
									<label for="twitter"><?php loc('userdata.twitter') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
									<input type="text" name="twitter" value="<?php echo($user->getTwitter()) ?>"/>
									
									<label for="country"><?php loc('userdata.country') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
									<input type="text" name="country" value="<?php echo($user->getCountry()) ?>"/>
									
									<label for="location"><?php loc('userdata.location') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
									<input type="text" name="location" value="<?php echo($user->getLocation()) ?>"/>
									
									<label for="bio"><?php loc('userdata.bio') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
									<input type="text" name="bio" value="<?php echo($user->getBio()) ?>" size="250"/>
									<br />
									<br />
                                    <?php if(!$user->getThirdpartyId()) { ?>
									<input type="checkbox" class="checkbox" name="newsletter" id="newsletter" <?php if($user->getNewsletter()) { ?>checked="checked"<?php } ?>/> <label for="newsletter" class="inline"><?php loc('userdata.newsletter') ?></label><br />
									<input type="checkbox" class="checkbox" name="enableMessages" id="enableMessages" <?php if($user->getEnableMessages()) { ?>checked="checked"<?php } ?>/> <label for="enableMessages" class="inline"><?php loc('userdata.message') ?></label><br />
                                    <?php } ?>
                                    <input type="checkbox" class="checkbox" name="enableWall" id="enableWall" <?php if($user->getEnableWall()) { ?>checked="checked"<?php } ?>/> <label for="enableWall" class="inline"><?php loc('userdata.wall', $user->getUrl() . "/wall") ?></label><br />
                                    <br />
									<?php loc('userdata.changeText') ?><br />
									<br />
									<a href="javascript:;" onclick="$('twickit-blase').submit();" id="createLink"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('userdata.save') ?></a>
								</form>
  							</div>
				            <div class="blase-footer" id="eingabeblase-footer"></div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- EINGABE-Sprechblase | ENDE -->
			
				<?php 
				if($error = getArrayElement($_GET, "error")) {
					popup(_loc($_GET["error"]));
				}
				?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Loeschen | START -->
			    <div class="teaser" id="wikipedia-teaser">
			    	<div class="teaser-head"><h2><?php loc('userdata.delete.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('userdata.delete.text') ?><br />
			        		<br />
			        		<a href="delete_user_form.php"><?php loc('userdata.delete.link') ?></a>
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Loeschen | ENDE -->  
			    
				<?php 
				$url = $user->getUrl();
				include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") 
				?>        
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>