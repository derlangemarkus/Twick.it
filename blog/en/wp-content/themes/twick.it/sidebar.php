<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
?>
<!-- Rechte Haelfte | START -->
<div class="inhalte-rechts">

	<!-- Kategorien | START -->
    <div class="teaser">
    	<div class="teaser-head"><h2><?php _e('Categories:'); ?></h2></div>
        <div class="teaser-body nopadding">
        	<ul class="bullets">
        		<?php 
        			$categories = get_categories("hide_empty=1&hierarchical=1"); 
			      	foreach($categories as $linkcat) {
			      	  	$active = in_category($linkcat->term_id) && !is_home() ? "style='font-weight:bold;'" : "";
				      	echo "<li><a href='" . get_category_link($linkcat->term_id) . "' $active>{$linkcat->cat_name}</a></li>";
			      	}
				?> 
            </ul>
        </div>
        <div class="teaser-footer"></div>                        
    </div>
    <!-- Kategorien | ENDE -->  


	<!-- Seiten | START -->
    <div class="teaser">
    	<div class="teaser-head"><h2><?php _e('Pages:'); ?></h2></div>
        <div class="teaser-body nopadding">
        	<ul class="bullets">
			 	<?php
			 	$level = 0;
			 	$prevParent = null;
			 	$prevId = null;
			 	foreach(get_pages("sort_column=menu_order&exclude_tree=" . BLOG_DB_INTERNPOSTS) as $page) {
			 		if (strpos($page->post_title, "(Deutsch)") === 0) {
			 			continue;
			 		}
			 		
			 		$pageId = $page->ID;
			 		$parent = $page->post_parent;
			 		
			 		if (isAdmin()) {
			 			//echo("ID: $pageId, PA: $parent, PP: $prevParent, PI: $prevId<br />");
			 		}
			 		
			 		
			 		
			 		
			 		if ($parent && $post->ID != $parent && $post->ID != $pageId && $post->post_parent != $parent && $post->post_parent != $pageId) {
			 			$style .= "display:none;";
			 		} else {
				 		if ($parent) {
				 			if ($parent!=$prevParent) {
				 				if ($parent==$prevId) {
					 				$level++;
				 				} else {
				 					$level--;
				 				}
				 			}
				 		} else {
				 			$level = 0;
				 		}
			 			$prevParent = $parent;
			 			$prevId = $pageId;
			 			
			 			$style = "margin-left:" . (12*$level) . "px;";
			 		}
			 		
			 		if ($post->ID == $pageId) {
			 			$style .= "font-weight:bold;";
			 		}
			 		
			 		echo("<li style='$style'><a href='" . get_permalink($pageId) . "'>" . $page->post_title . "</a></li>");
			 	}
			 	?>
			 </ul>
        </div>
        <div class="teaser-footer"></div>                        
    </div>
    <!-- Seiten | ENDE -->  
    

	<!-- Suche | START -->
    <div class="teaser">
    	<div class="teaser-head"><h2><?php _e('Search:'); ?></h2></div>
        <div class="teaser-body">
        	<div>
			   	<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
					<input type="text" name="s" id="s"/><br />
				</form>
				<a href="javascript:;" onclick="$('searchform').submit();" class="teaser-link"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/><?php _e('Search'); ?></a><br />
            </div>
        </div>
        <div class="teaser-footer"></div>                        
    </div>
    <!-- Suche | ENDE -->  
    
    
    <!-- Kommentare | START -->
    <div class="teaser">
    	<div class="teaser-head"><h2><?php _e('Comments'); ?>:</h2></div>
        <div class="teaser-body nopadding">
        	<ul>
        		<?php 
        		foreach(get_comments(array("number"=>5, "status"=>"approve")) as $comment) {
        			if ($comment->comment_type == "pingback" || $comment->comment_type == "trackback") {
        				continue;
        			}
        			$permalink = get_permalink($comment->comment_post_ID);
        		?>
        		<li><a href="<?php echo($permalink . "#comment" . $comment->comment_ID) ?>" onclick="this.blur()"><?php echo(get_avatar($comment->comment_author_email, 32)) ?><b><?php echo($comment->comment_author) ?></b>: <?php echo(truncateString(str_replace("[/twickit]", "", str_replace("[twickit]", "", strip_tags($comment->comment_content))), 70)) ?></a></li>
        		<?php 
        		} 
        		?>
        	</ul>
        </div>
        <div class="teaser-footer"></div>                        
    </div>
    <!-- Kommentare | ENDE -->  
    
    
    <!-- Tagcloud | START -->
    <?php $is3dCloud = (getArrayElement($_COOKIE, "cloud", "2d") == "3d"); ?>
    <div class="teaser">
    	<div class="teaser-head"><h2>Tag-Cloud</h2></div>
        <div class="teaser-body">
        	<p id="tagcloud3d" <?php if(!$is3dCloud) { ?>style="display:none;"<?php } ?>>
			   	<?php wp_cumulus_insert(); ?>
				<a href="javascript:;" onclick="$('tagcloud3d').hide(); $('tagcloud2d').show();$('tagcloud2ddiv').show(); $('tagcloud2dLink').show(); document.cookie='cloud=2d;expires=' + inOneYear + ';';" class="teaser-link" title="2D"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/>2D</a><br /><br />
            </p>
        	<p id="tagcloud2d" <?php if($is3dCloud) { ?>style="display:none;"<?php } ?>>
			   	<div id="tagcloud2ddiv" style="width: 210px; margin-bottom: 5px;<?php if($is3dCloud) { ?>display:none;<?php } ?>"><?php wp_tag_cloud('smallest=12&largest=22&unit=px&number=20'); ?></div>
				<a href="javascript:;" onclick="$('tagcloud2d').hide(); $('tagcloud2ddiv').hide(); $('tagcloud2dLink').hide(); $('tagcloud3d').show();document.cookie='cloud=3d;expires=' + inOneYear + ';';" class="teaser-link" id="tagcloud2dLink" title="3D" <?php if($is3dCloud) { ?>style="display:none;"<?php } ?>><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/>3D</a>
            </p>
        </div>
        <div class="teaser-footer"></div>                        
    </div>
    <!-- Tagcloud | ENDE -->  
			         
			        
	<!-- RSS | START -->
    <div class="teaser">
    	<div class="teaser-head"><h2>RSS</h2></div>
        <div class="teaser-body nopadding">
        	<ul>
        		<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>"><?php loc('blog.rss.posts') ?></a></li>
				<li><img src="html/img/rss.gif" class="rss" /><a rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url'); ?>"><?php loc('blog.rss.comments') ?></a></li>
            </ul>
            <div class="clearbox"></div>
        </div>
        <div class="teaser-footer"></div>                        
    </div>
    <!-- RSS | ENDE --> 			         
			              
	<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>                

<br /></div>
<!-- Rechte Haelfte | ENDE -->

<div class="clearbox"></div>
