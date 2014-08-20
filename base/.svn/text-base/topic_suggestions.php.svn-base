<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

checkLogin();
$user = getUser();

$limit = getArrayElement($_GET, "limit", 20);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('topicSuggestions.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('topicSuggestions.title') ?>" />
    <meta name="description" content="<?php loc('topicSuggestions.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript">
	function noWord(inWord) {
		$("suggestion_" + inWord).fade();
		new Ajax.Request(
			"<?php echo(HTTP_ROOT) ?>/action/add_noword.php", {
				method: 'post',
				parameters: 'count=<?php echo($limit) ?>&word=' + encodeURIComponent(inWord),
			  	onSuccess: function(transport) {
					var json = transport.responseText.evalJSON(true);
	
					if (json.suggestion != "") {
						var a = new Element('a', {'href': 'show_topic.php?title=' + encodeURIComponent(json.suggestionWord)}).update(json.suggestionWord);
						var li = new Element('li', {'id': 'suggestion_' + json.suggestion});
						li.appendChild(a);
						li.appendChild(document.createTextNode(" "));
						
						var x = new Element('a', {'href': 'javascript:;'}).update("[x]");
						x.onclick = function() {noWord(json.suggestion); };
						li.appendChild(x);
						
						$("suggestions").appendChild(li);
					}
				}
			}
		);
	}
	</script>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
    	<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php loc('topicSuggestions.title') ?></h1>
   		</div>
    
  		<!-- Content-Bereich | START -->
		<div class="content">
	    	<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('topicSuggestions.headline') ?></h1></div>
					<div class="blog-body">
						<ul class="bulletsbig" id="suggestions">
						<?php 
						foreach($user->findTopicSuggestions($limit) as $suggestion=>$count) {
							$correct = correctCapitalization($suggestion); 
							echo("<li id='suggestion_$suggestion'><a href='show_topic.php?title=" . urlencode($correct) . "'>$correct</a> [<a href='javascript:;' onclick=\"noWord('" . str_replace("'", "\\'", $suggestion) . "')\">x</a>]</li>");
						}
						?>
						</ul>
					</div>
					<div class="blog-footer"></div>
				</div>
				<!-- Kasten | ENDE -->
					
				<div class="haupt-buttonfeld">
	            	<a id="userTwicksMoreLink" href="dashboard.php"><?php loc("core.back") ?></a>
	            </div>	    
			</div>
			<!-- Linke Haelfte | ENDE -->
				
				
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			   	<!-- Infobox | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('topicSuggestions.info.title') ?></h2></div>
			        <div class="teaser-body">
			        	<p>
			        		<?php loc('topicSuggestions.info.text.1') ?><br />
							<br />
							<?php loc('topicSuggestions.info.text.2') ?>
						</p>
						<div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Infobox | ENDE --> 
			   	
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
