<?php
/*
Plugin Name: Target-Blank-Comment
Plugin URI: http://www.conception.cc
Description: Add target="_blank" to comments.
Author: Markus Moeller
Version: 1.0
Author URI: http://www.conception.cc
*/
if ( !is_admin() ) :

function add_target_blank($text = '')
{
	# Markus Moeller: Open Links in external window
	$text = str_replace('<a ', '<a target="_blank" ', $text);
	
	return $text;
} # strip_nofollow()

//add filters
//remove_filter('pre_comment_content', 'wp_rel_nofollow', 15);
add_filter('get_comment_author_link', 'add_target_blank', 15);
add_filter('comment_text', 'add_target_blank', 15);

endif;
?>