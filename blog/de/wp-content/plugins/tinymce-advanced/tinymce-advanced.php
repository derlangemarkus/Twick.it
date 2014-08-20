<?php
/*
Plugin Name: TinyMCE Advanced
Plugin URI: http://www.laptoptips.ca/projects/tinymce-advanced/
Description: Enables advanced features and plugins in TinyMCE, the visual editor in WordPress.
Version: 3.2.7
Author: Andrew Ozz
Author URI: http://www.laptoptips.ca/

Some code and ideas from WordPress(http://wordpress.org/). The options page for this plugin uses jQuery (http://jquery.com/).

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
*/

if ( ! function_exists('tadv_admin_head') ) {
	function tadv_admin_head() { ?>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/tinymce-advanced/js/tadv.js"></script>
<?php
	}
} // end tadv_admin_head

if ( ! function_exists('tadv_add_scripts') ) {
	function tadv_add_scripts() {
		wp_enqueue_script( 'jquery-ui-sortable' ); ?>
<link rel="stylesheet" href="<?php echo WP_PLUGIN_URL; ?>/tinymce-advanced/css/tadv-styles.css?ver=3.1" type="text/css" />
<?php
	}
} // end tadv_add_scripts


if ( ! function_exists('tadv_activate') ) {
	function tadv_activate() {

		@include_once('tadv_defaults.php');
		$tadv_options = array( 'advlink' => 1, 'advimage' => 1, 'importcss' => 0, 'contextmenu' => 0, 'fix_autop' => 0 );

		if ( isset($tadv_toolbars) ) {
			add_option( 'tadv_toolbars', $tadv_toolbars, '', 'no' );
			add_option( 'tadv_options', $tadv_options, '', 'no' );
			add_option( 'tadv_plugins', $tadv_plugins, '', 'no' );
			add_option( 'tadv_btns1', $tadv_btns1, '', 'no' );
			add_option( 'tadv_btns2', $tadv_btns2, '', 'no' );
			add_option( 'tadv_btns3', $tadv_btns3, '', 'no' );
			add_option( 'tadv_btns4', $tadv_btns4, '', 'no' );
			add_option( 'tadv_allbtns', $tadv_allbtns, '', 'no' );
		}
	}
}
add_action( 'activate_tinymce-advanced/tinymce-advanced.php', 'tadv_activate' );

if ( ! function_exists('tdav_css') ) {
	function tdav_css($wp) {
		$tadv_options = get_option('tadv_options', array());

		if ( $tadv_options['importcss'] == '1' )
			$wp .= ',' . get_bloginfo('stylesheet_url');

		$wp .= ',' . WP_PLUGIN_URL . '/tinymce-advanced/css/tadv-mce.css';
		return trim($wp, ' ,');
	}
}
add_filter( 'mce_css', 'tdav_css' );

if ( ! function_exists('tdav_get_file') ) {
	function tdav_get_file($path) {
	
		if ( function_exists('realpath') )
			$path = realpath($path);
	
		if ( ! $path || ! @is_file($path) )
			return '';
	
		if ( function_exists('file_get_contents') )
			return @file_get_contents($path);
	
		$content = '';
		$fp = @fopen($path, 'r');
		if ( ! $fp )
			return '';
	
		while ( ! feof($fp) )
			$content .= fgets($fp);
	
		fclose($fp);
		return $content;
	}
}

$tadv_allbtns = array();
$tadv_hidden_row = 0;

if ( is_admin() && !defined('DOING_AJAX') && !defined('DOING_CRON') ) {
	get_option('tadv_options');
	get_option('tadv_toolbars');
	get_option('tadv_plugins');
	get_option('tadv_btns1');
	get_option('tadv_btns2');
	get_option('tadv_btns3');
	get_option('tadv_btns4');
	get_option('tadv_allbtns');
}

if ( ! function_exists('tadv_mce_btns') ) {
	function tadv_mce_btns($orig) {
		global $tadv_allbtns, $tadv_hidden_row;
		$tadv_btns1 = (array) get_option('tadv_btns1', array());
		$tadv_allbtns = (array) get_option('tadv_allbtns', array());

		if ( in_array( 'wp_adv', $tadv_btns1 ) )
			$tadv_hidden_row = 2;

		if ( is_array($orig) && ! empty($orig) ) {
			$orig = array_diff( $orig, $tadv_allbtns );
			$tadv_btns1 = array_merge( $tadv_btns1, $orig );
		}
		return $tadv_btns1;
	}
}
add_filter( 'mce_buttons', 'tadv_mce_btns', 999 );

if ( ! function_exists('tadv_mce_btns2') ) {
	function tadv_mce_btns2($orig) {
		global $tadv_allbtns, $tadv_hidden_row;
		$tadv_btns2 = (array) get_option('tadv_btns2', array());

		if ( in_array( 'wp_adv', $tadv_btns2 ) )
			$tadv_hidden_row = 3;

		if ( is_array($orig) && ! empty($orig) ) {
			$orig = array_diff( $orig, $tadv_allbtns );
			$tadv_btns2 = array_merge( $tadv_btns2, $orig );
		}
		return $tadv_btns2;
	}
}
add_filter( 'mce_buttons_2', 'tadv_mce_btns2', 999 );

if ( ! function_exists('tadv_mce_btns3') ) {
	function tadv_mce_btns3($orig) {
		global $tadv_allbtns, $tadv_hidden_row;
		$tadv_btns3 = (array) get_option('tadv_btns3', array());

		if ( in_array( 'wp_adv', $tadv_btns3 ) )
			$tadv_hidden_row = 4;

		if ( is_array($orig) && ! empty($orig) ) {
			$orig = array_diff( $orig, $tadv_allbtns );
			$tadv_btns3 = array_merge( $tadv_btns3, $orig );
		}
		return $tadv_btns3;
	}
}
add_filter( 'mce_buttons_3', 'tadv_mce_btns3', 999 );

if ( ! function_exists('tadv_mce_btns4') ) {
	function tadv_mce_btns4($orig) {
		global $tadv_allbtns;
		$tadv_btns4 = (array) get_option('tadv_btns4', array());

		if ( is_array($orig) && ! empty($orig) ) {
			$orig = array_diff( $orig, $tadv_allbtns );
			$tadv_btns4 = array_merge( $tadv_btns4, $orig );
		}
		return $tadv_btns4;
	}
}
add_filter( 'mce_buttons_4', 'tadv_mce_btns4', 999 );

if ( ! function_exists('tadv_mce_options') ) {
	function tadv_mce_options($init) {
		global $tadv_hidden_row;
		$tadv_options = get_option('tadv_options', array());

		if ( $tadv_hidden_row > 0 )
			$init['wordpress_adv_toolbar'] = 'toolbar' . $tadv_hidden_row;
		else
			$init['wordpress_adv_hidden'] = false;

		if ( isset($tadv_options['fix_autop']) && $tadv_options['fix_autop'] == 1 )
			$init['apply_source_formatting'] = true;

		return $init;
	}
}
add_filter( 'tiny_mce_before_init', 'tadv_mce_options' );

if ( ! function_exists('tadv_htmledit') ) {
	function tadv_htmledit($c) {
		$tadv_options = get_option('tadv_options', array());

		if ( isset($tadv_options['fix_autop']) && $tadv_options['fix_autop'] == 1 ) {
			$c = str_replace( array('&amp;', '&lt;', '&gt;'), array('&', '<', '>'), $c );
			$c = wpautop($c);
			$c = htmlspecialchars($c, ENT_NOQUOTES);
		}
		return $c;
	}
}
add_filter('htmledit_pre', 'tadv_htmledit', 999);

if ( ! function_exists('tmce_init') ) {
	function tmce_init() {
		global $wp_scripts;
		$tadv_options = get_option('tadv_options', array());

		if ( ! isset($tadv_options['fix_autop']) || $tadv_options['fix_autop'] != 1 )
			return;

		$queue = $wp_scripts->queue;
		if ( is_array($queue) && in_array( 'editor', $queue, true ) )
			wp_enqueue_script( 'tadv_replace', WP_PLUGIN_URL . '/tinymce-advanced/js/tadv_replace.js', array('editor'), '20080425' );
	}
}
add_action( 'admin_enqueue_scripts', 'tmce_init', 25 );

if ( ! function_exists('tadv_load_plugins') ) {
	function tadv_load_plugins($plug) {
		$tadv_plugins = (array) get_option('tadv_plugins');
		if ( empty($tadv_plugins) || !is_array($tadv_plugins) )
			return $plug;

		$plugpath = WP_PLUGIN_URL . '/tinymce-advanced/mce/';

		$plug = (array) $plug;
		foreach( $tadv_plugins as $plugin )
			$plug["$plugin"] = $plugpath . $plugin . '/editor_plugin.js';

		return $plug;
	}
}
add_action( 'mce_external_plugins', 'tadv_load_plugins', 999 );

if ( ! function_exists('tadv_load_langs') ) {
	function tadv_load_langs($langs) {
		$tadv_plugins = get_option('tadv_plugins');
		if ( empty($tadv_plugins) || !is_array($tadv_plugins) )
			return $langs;

		$langpath = WP_PLUGIN_DIR . '/tinymce-advanced/mce/';
		$nolangs = array( 'bbcode', 'contextmenu', 'insertdatetime', 'layer', 'nonbreaking', 'print', 'visualchars', 'emotions', 'tadvreplace' );

		$langs = (array) $langs;
		foreach( $tadv_plugins as $plugin ) {
			if ( in_array( $plugin, $nolangs ) )
				continue;

			$langs["$plugin"] = $langpath . $plugin . '/langs/langs.php';
		}
		return $langs;
	}
}
add_filter( 'mce_external_languages', 'tadv_load_langs' );

if ( ! function_exists('tadv_page') ) {
	function tadv_page() {
		include_once( WP_PLUGIN_DIR . '/tinymce-advanced/tadv_admin.php');
	}
}

if ( ! function_exists('tadv_menu') ) {
	function tadv_menu() {
		if ( function_exists('add_options_page') ) {
			$page = add_options_page( 'TinyMCE Advanced', 'TinyMCE Advanced', 9, 'tinymce-advanced', 'tadv_page' );
			add_action( "admin_print_scripts-$page", 'tadv_add_scripts' );
			add_action( "admin_head-$page", 'tadv_admin_head' );
		}
	}
}
add_action( 'admin_menu', 'tadv_menu' );
