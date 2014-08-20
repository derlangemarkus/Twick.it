<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

$rightUserId = getArrayElement($_GET, "id");

$user = getUser();
$rightUser = User::fetchById($rightUserId);

$targetPage = $_SESSION["login.targetPage"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('access_denied.title') ?> | <?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('access_denied.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('access_denied.headline') ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<!-- Sprechblase | START -->
				<div class="sprechblase">
					<h2>&nbsp;<span>&nbsp;</span></h2>
					<div class="sprechblase-main">
				    	<div class="sprechblase-achtung">&nbsp;</div>
				        <div class="sprechblase-rechts">
				        	<div class="blase-header" id="eingabeblase-head">
				            	<div class="kurzerklaerung"><span><?php loc('access_denied.sorry')?></span></div>
				            </div>
				            <div class="blase-body">
								<div class="twick-link">
									<?php 
									if($rightUser && $user) {
										loc(
											'access_denied.text.wrongUser', 
											array(
												"<div style='font-size:22px;white-space:nowrap;margin:10px 0px 10px 0px;'>" . $rightUser->getAvatar(20) . "&nbsp;" . $rightUser->getLogin() . "</div>", 
												"<div style='font-size:22px;white-space:nowrap;margin:10px 0px 10px 0px;'>" . $user->getAvatar(20) . "&nbsp;" . $user->getLogin() . "</div>"
											)
										);
									} else {
										?>
										<form id="loginForm2" action="action/login.php?url=<?php echo urlencode($targetPage) ?>" method="post">
											<label for="login" style="width:80px;display:block;float:left;"><?php loc('header.label.user') ?>:&nbsp;</label><input type="text" name="login" id="loginField2" onfocus="this.select()"/><br />
											<label for="password" style="width:80px;display:block;float:left;"><?php loc('header.label.password') ?>:&nbsp;</label><input type="password" name="password" id="passwordField2" onfocus="this.select()"/><br />
											<a href="javascript:;" onclick="$('loginForm2').submit();" class="einloggen-<?php echo($language) ?>" style="margin: 5px 0px 0px 80px;">&nbsp;</a>
										</form>
										<script type="text/javascript">
										$("loginField2").observe(
											'keyup', 
											function(inEvent) { 
												if (inEvent && inEvent.keyCode == 13) {
													$("passwordField2").focus();
												}
											 }
										);
									
										$("passwordField2").observe(
											'keyup', 
											function(inEvent) { 
												if (inEvent && inEvent.keyCode == 13) {
													$("loginForm2").submit();
												}
											 }
										);
										</script>
										<br style="clear:both;" />
										<a href="register_form.php" style="margin: 10px 0px; display: block;"><?php loc('yourTwick.notRegistered') ?></a>
										<span><?php loc('yourTwick.oauth') ?></span>
										<br />
										<a rel="nofollow" href="action/twitter_login.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>"><img src="html/img/signin_twitter_s.png" title="<?php loc('oauth.twitter.login') ?>" style="vertical-align:middle"/> Twitter</a>
										<a rel="nofollow" style="margin-left:30px;" href="action/facebook_login.php?url=<?php echo urlencode($_SERVER["REQUEST_URI"]) ?>"><img src="html/img/signin_facebook_s.png" title="<?php loc('oauth.facebook.login') ?>" style="vertical-align:middle"/> Facebook</a>
										<?php
									}
									?>
								</div>
				            </div>
				            <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
				        </div>
				        <div class="clearbox">&nbsp;</div>
				    </div>
				</div>
				<!-- Sprechblase | ENDE -->
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('access_denied.marginal.oups.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php loc('access_denied.marginal.oups.text1') ?><br />
			        		<br />
			        		<?php loc('access_denied.marginal.oups.text2', '<b><a href="mailto:' . encodeEMailAddress(SUPPORT_MAIL_RECEIVER) . '">' . encodeEMailAddress(SUPPORT_MAIL_RECEIVER) . '</a></b>') ?><br />
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
