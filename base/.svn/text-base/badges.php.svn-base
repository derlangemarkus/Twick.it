<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

$activeTab = "user";

$login = getArrayElement($_GET, "username");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('badges.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('badges.title') ?>" />
    <meta name="description" content="<?php loc('badges.title') ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
	<style type="text/css">
		.badgeInfo {
			margin-top:12px;
		}
		.badgeInfo img {
			vertical-align:top;
			padding-right:30px;
			float:left;
			width:80px;
			height:80px;
		}
		.badgeInfo div {
			float:left;
			width:400px;
            height:60px;
            padding-top:15px;
            font-size:12px;
		}
		.badgeInfo br {
			clear:both;
		}
	</style>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php
				foreach(Badge::getInfos() as $title=>$infos) {
					?>
					<a name="<?php echo($infos["name"]) ?>"></a>
					<!-- Kasten | START -->
					<div class="blog-kasten">
						<div class="blog-head"><h1><?php loc($title) ?></h1></div>
						<div class="blog-body">
						<?php
						loc($infos["info"]);
						foreach($infos["levels"] as $level) {
						?>
						<div class="badgeInfo">
							<img src="<?php echo(STATIC_ROOT) ?>/html/img/badges/80/<?php echo($level["img"]) ?>"/>
							<div><?php echo($level["text"]) ?></div>
							<br />
						</div>
						<?php
						}
						?>
						</div>
						<div class="blog-footer"></div>
					</div>
					<!-- Kasten | ENDE -->
				<?php
				}
				?>
					
				
				<div class="haupt-buttonfeld">
					<?php if($login) { ?>
                    <a id="userTwicksMoreLink" href="<?php echo(HTTP_ROOT . "/user/$login") ?>"><?php loc('badges.back') ?></a>
					<?php } ?>
                </div>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
		
		    	<!-- RSS | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('badges.teaser.title') ?></h2></div>
			        <div class="teaser-body">
			        	<?php loc('badges.teaser.text1') ?><br />
						<br />
						<?php loc('badges.teaser.text2') ?>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- RSS | ENDE --> 
			                 
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>
			
			<br />
		</div>
		<!-- Rechte Haelfte | ENDE -->
		
		<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>

<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

</body>
</html>