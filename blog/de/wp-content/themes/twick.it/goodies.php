<?php
/**
 * @package WordPress
 * @subpackage Twick.it_Theme
 * Template Name: Goodies
 */
get_header();
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
?>
<style type="text/css">
    form#categories input {vertical-align: middle;}
</style>
<!-- Ergebnis-Feld -->
<div class="header-ergebnisfeld" id="header-ergebnisfeld">
	<h1><a href="<?php bloginfo('home'); ?>">Twick.it-Blog</a></h1>
</div>

<!-- Content-Bereich | START -->
<div class="content">
	
	<!-- Linke Haelfte | START -->
	<div class="inhalte-links">
		<!-- Kasten | START -->
		<div class="blog-kasten intro">
			<div class="blog-head">
                <h1>Willkommen auf der Spielwiese</h1>
			</div>
			<div class="blog-body goodies">
				Hier listen wir Dinge auf, die man mit Twick.it noch machen kann. Egal, ob 
				Anzeige auf dem Handy, in Google Earth oder als gesprochener Podcast. Selbst
				für Software-Entwickler ist etwas dabei. <br />
				Wenn ihr selbst coole Erklärmaschinen-Erweiterungen programmieren wollt, 
				solltet ihr einen <a href="/blog/de/api/" target="_blank">Blick auf die API</a> 
				werfen.
			</div>
			<div class="blog-footer goodies-footer"></div>
		</div>
		<div class="clearbox" style="border-bottom:1px solid #FFFFFF;"></div>
		<!-- Kasten | ENDE -->
	
        <?php
        the_post();
        $posts = get_posts("post_type=page&numberposts=-1&post_parent=" . get_the_ID());
        shuffle($posts);
		foreach($posts as $post) {
            if ($post->post_status != "publish" && !isAdmin()) {
                continue;
            }
            $category = get_post_meta($post->ID, 'category', true);
			$qr = get_post_meta($post->ID, 'qr', true);
        ?>
		<!-- Kasten | START -->
		<div class="blog-kasten <?php echo $category ?>">
			<div class="blog-head">
				<?php if($qr) { ?>
				<h1 onmouseover="$('qr<?php echo($post->ID) ?>').show();" onmouseout="$('qr<?php echo($post->ID) ?>').hide();"><?php echo($post->post_title) ?><img src="<?php echo(get_bloginfo('template_directory')) ?>/img/qr/icon.png" alt="QR-Code" style="width:16px;height:16px;margin-left:20px;"/></h1>
                <div style="margin-left:260px;position:absolute;z-index:3000;display:none;" id="qr<?php echo($post->ID) ?>"><img src="<?php echo(get_bloginfo('template_directory')) ?>/img/qr/<?php echo($qr) ?>" alt="QR-Code"/></div>
				<?php } else { ?>
                <h1><?php echo($post->post_title) ?></h1>
                <?php } ?>
			</div>
			<div class="blog-body goodies">
				<?php
                    $content = $post->post_content;
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
					echo($content);
				?>
			</div>
			<div class="blog-footer goodies-footer"></div>
		</div>
		<div class="clearbox" style="border-bottom:1px solid #FFFFFF;"></div>
		<!-- Kasten | ENDE -->
        <?php
        }
        ?>
	</div>
	<!-- Linke Haelfte | ENDE -->
			
	<!-- Rechte Haelfte | START -->
<div class="inhalte-rechts">

	<!-- Kategorien | START -->
    <div class="teaser">
    	<div class="teaser-head"><h2><?php _e('Categories'); ?>:</h2></div>
        <div class="teaser-body">
            Die Einträge kannst du nach Kategorien filtern. Wähle dazu aus,
            welche Themen du sehen möchtest:<br /><br />
            <form action="#" name="categories" id="categories">
				<?php 
				$categories = 
					array(
						"ar" => "Augmented Reality",
						"browser" => "Browser", 
						"geo" => "Geo-Kodierung",
						"handy" => "Handy / Mobil",
						"mac" => "Mac OS X",
						"mashup" => "Mashup",
						"plugin" => "Plugin",
						"programming" => "Programmierer-Zeugs",
						"game" => "Spiele",
						"search" => "Suchen",
						"twitter" => "Twitter",
						"windows" => "Windows"
					);
				foreach($categories as $id=>$name) { 
				?>
				<input type="checkbox" value="<?php echo($id) ?>" checked onclick="updateCategories()" id="check_<?php echo($id) ?>" /> <label for="check_<?php echo($id) ?>"><?php echo($name) ?></label><br />
				<?php 
				} 
				?>
            </form>
        </div>
        <div class="teaser-footer"></div>
    </div>
    <!-- Kategorien | ENDE -->

	<!-- Icon-Bookmark Leiste | START -->
	<div class="bookmark-leiste" style="margin-left:25px;">
	<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo($url) ?>" data-count="horizontal" data-via="TwickIt" data-related="twickit_<?php echo(getLanguage()) ?>" data-lang="<?php echo(getLanguage()) ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<div style="padding-top:2px;margin-left:1px;width:65px;display:inline-block;float:left;"><g:plusone size="small"></g:plusone></div>
	<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($url); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=400&amp;font=arial" scrolling="no" frameborder="0" style="border:none;overflow:hidden;width:80px;height:20px;" allowTransparency="true"></iframe>
</div>      
    <!-- Icon-Bookmark Leiste | START -->

<br /></div>
<!-- Rechte Haelfte | ENDE -->

<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->

<script type="text/javascript">
    function updateCategories() {
		var checked = new Array();
		var elems = document.categories.elements;
		for(var i=0; i<elems.length; i++) {
			var elem = elems[i];
			if(elem.checked) {
				checked[elem.value] = true;
			}
		}
	
		var items = $$(".blog-kasten");
        for(var i=0; i<items.length; i++) {
			var visible = false;
			var item = items[i];
			var classNames = item.className.split(" ");
			for(var j=0; j<classNames.length; j++) {
				if(classNames[j] == "intro" || checked[classNames[j]]) {
					item.style.display = "block";
					visible = true;
					break;
				}
			}
			if (!visible) {
				item.style.display = "none";
			}
        }
    }
</script>

<?php get_footer(); ?>