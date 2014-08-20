<?php
/*
Plugin Name: Twickit-Link-Corrector
Plugin URI: http://twick.it
Description: Corrects automatic linked urls in comments
Author: Markus Moeller
Version: 1.0
Author URI: http://twick.it/user/derlangemarkus
*/
if (!is_admin()) {
	ini_set("display_errors", 1);
	function correctTwickitLinks($inText = '') {
//		return $inText;
		$text = preg_replace('#(<a href="http://twick.it/.+)\)" rel="nofollow">#U', '$1">', $inText);
		$text = preg_replace('#(<a href="http://twick.it/.+)\)\.?" rel="nofollow">#U', '$1">', $text);
		return $text;
	} 
	
	add_filter('get_comment_author_link', 'correctTwickitLinks', 15);
	add_filter('comment_text', 'correctTwickitLinks', 15);

}
?>