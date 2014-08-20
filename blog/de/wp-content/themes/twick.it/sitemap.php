<?php
/**
 * @package WordPress
 * @subpackage Twick.it_Theme
 * Template Name: Sitemap
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
		<!-- Kasten | START -->
		<div class="blog-kasten">
			<div class="blog-head"><h1><?php loc('blog.overview') ?></h1></div>
			<div class="blog-body">
				<ol>
				<?php 
				foreach(get_posts("numberposts=500") as $post) {
					echo("<li><a href='" . get_permalink($post->ID) . "'>" . $post->post_title . "</a></li>");	
				}
				?>
				</ol>
			</div>
			<div class="blog-footer"></div>
		</div>
		<div class="clearbox" style="border-bottom:1px solid #FFFFFF;"></div>
		<!-- Kasten | ENDE -->
	</div>
	<!-- Linke Haelfte | ENDE -->
			
	<?php get_sidebar(); ?>		
	</div>
	<!-- Content-Bereich | ENDE -->

<?php get_footer(); ?>