<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
get_header();
?>

<!-- Ergebnis-Feld -->
<div class="header-ergebnisfeld" id="header-ergebnisfeld">
	<h1><a href="<?php bloginfo('home'); ?>">Twick.it-Blog</a></h1>
</div>

<!-- Content-Bereich | START -->
<div class="content">
	
	<!-- Linke Haelfte | START -->
	<div class="inhalte-links">
	
		<?php 
		if (have_posts()) {
			while (have_posts()) { 
				the_post(); 
			?>
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1></div>
					<div class="blog-body">
						<?php echo get_avatar(get_the_author_ID(), 48, get_bloginfo('template_directory') . "/html/img/thumb_person.jpg"); ?><i><?php if(get_the_author() != "admin") { ?><a href="<?php the_author_url() ?>" title="<?php the_author() ?>"><?php the_author() ?></a><?php } ?></i>
						<?php the_content('<b>' . _loc('blog.readMore') . '&gt;&gt;</b>'); ?><br />
						<?php the_tags(__('Tags: '), ', '); ?>
						<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;show_faces=false&amp;width=400&amp;font=arial" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px;padding-top:20px;height:30px;" allowTransparency="true"></iframe>
					</div>
					<div class="blog-footer">
						<br /><span><?php loc('blog.created', get_the_time(__('d.m.Y', 'kubrick'))) ?></span> | 
						<?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)', "pfeil-link")); ?>
						<?php edit_post_link(__('Edit This'), ' | '); ?>
					</div>
				</div>
				<div class="clearbox" style="border-bottom:1px solid #FFFFFF;"></div>
				<!-- Kasten | ENDE -->
			<?php 
			}
			
			
			comments_template(); 
			
		} else { 
		?>
		<!-- Sprechblase | START -->
		<div class="sprechblase">
			<h2>&nbsp;<span>&nbsp;</span></h2>
			<div class="sprechblase-main">
		    	<div class="sprechblase-achtung">&nbsp;</div>
		        <div class="sprechblase-rechts">
		        	<div class="blase-header" id="eingabeblase-head">
		            	<div class="kurzerklaerung"></div>
		            </div>
		            <div class="blase-body">
						<div class="twick-link">
							<?php loc('blog.nothingFound'); ?>
						</div>
		            </div>
		            <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
		        </div>
		        <div class="clearbox">&nbsp;</div>
		    </div>
		</div>
		<!-- Sprechblase | ENDE -->
		
		<?php 
		}
		?>
		
		<div class="textcontent" style="margin-bottom: 30px;">
			<?php
			if (function_exists("wp_pagebar")) {
				wp_pagebar(array("before"=>"", "tooltip_text"=>_loc('blog.page'), "next"=>"&raquo;", "prev"=>"&laquo;"));	
			} else {
				posts_nav_link(' &#8212; ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); 
			}
			?>
		</div>
	</div>
	<!-- Linke Haelfte | ENDE -->
			
	<?php get_sidebar(); ?>		
	</div>
	<!-- Content-Bereich | ENDE -->

<?php get_footer(); ?>
