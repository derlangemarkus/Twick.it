<?php
/*
Plugin Name: Unfancy Quote
Plugin URI: http://www.semiologic.com/software/unfancy-quote/
Description: Removes WordPress fancy quotes, which is very useful if you post code snippets to your site.
Version: 3.0
Author: Denis de Bernardy
Author URI: http://www.getsemiologic.com
Text Domain: sem-unfancy-quote
Domain Path: /lang
*/

/*
Terms of use
------------

This software is copyright Mesoconcepts (http://www.mesoconcepts.com), and is distributed under the terms of the GPL license, v.2.

http://www.opensource.org/licenses/gpl-2.0.php
**/


/**
 * strip_fancy_quotes()
 *
 * @param string $text
 * @return string $text
 **/

function strip_fancy_quotes($text = '') {
	$text = str_replace(array("&#8216;", "&#8217;", "&#8242;"), "&#039;", $text);
	$text = str_replace(array("&#8220;", "&#8221;", "&#8243;"), "&#034;", $text);

	return $text;
} # strip_fancy_quotes()

add_filter('category_description', 'strip_fancy_quotes', 20);
add_filter('list_cats', 'strip_fancy_quotes', 20);
add_filter('comment_author', 'strip_fancy_quotes', 20);
add_filter('comment_text', 'strip_fancy_quotes', 20);
add_filter('single_post_title', 'strip_fancy_quotes', 20);
add_filter('the_title', 'strip_fancy_quotes', 20);
add_filter('the_content', 'strip_fancy_quotes', 20);
add_filter('the_excerpt', 'strip_fancy_quotes', 20);
add_filter('bloginfo', 'strip_fancy_quotes', 20);
add_filter('widget_text', 'strip_fancy_quotes', 20);
?>