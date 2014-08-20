<?php
/*
Plugin Name: Pagebar2
Plugin URI: http://www.elektroelch.de/hacks/wp/pagebar
Description: Adds an advanced page navigation to Wordpress.
Version: 2.59
Author: Lutz Schr&ouml;er
Author URI: http://elektroelch.de/blog
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* -------------------------------------------------------------------------------------------- */

function postbar() {
		global $paged, $wp_query;
		require_once('class-postbar.php');
		$pagebar = new Postbar($paged, intval($wp_query->max_num_pages));
}

/* -------------------------------------------------------------------------------------------- */
function pagebar() {  // for compatibility with pagebar v2.21
		postbar();
}
/* -------------------------------------------------------------------------------------------- */
function wp_pagebar() {  // for compatibility with pagebar v2.21
		postbar();
}
/* -------------------------------------------------------------------------------------------- */
function multipagebar () {
		global $page, $numpages;
		require_once('class-multipagebar.php');
		$multipagebar = new Multipagebar($page, $numpages);
} //multipagebar()
/* -------------------------------------------------------------------------------------------- */
function commentbar() {
		global $wp_query;
		require_once('class-commentbar.php');
		$paged = intval(get_query_var('cpage'));
		$max_page = intval($wp_query->max_num_comment_pages);
		$commentbar = new Commentbar($paged, $max_page);
}
// -------------------------------------------------------------------------
// determine the path of the plugin
// stolen from Commentmix
if (!defined('PLUGIN_URL'))
    define('PLUGIN_URL', get_option('siteurl').'/wp-content/plugins/');
if (!defined('PLUGIN_PATH'))
    define('PLUGIN_PATH', ABSPATH.'wp-content/plugins/');
define('PAGEBAR_URL', PLUGIN_URL . dirname(plugin_basename(__FILE__)).'/');
define('PAGEBAR_PATH', PLUGIN_PATH . dirname(plugin_basename(__FILE__)).'/');
/* -------------------------------------------------------------------------- */

function pagebar_registerStylesheet($url, $handle, $pluginurl = "") {
	wp_register_style($handle, $pluginurl . $url);
	wp_enqueue_style($handle);
	wp_print_styles();
}
/* -------------------------------------------------------------------------- */
function pagebar_addUserStylesheet() {
  global $pbOptions;
	if ($pbOptions["stylesheet"] != "styleCss")
		pagebar_registerStylesheet(get_bloginfo('stylesheet_directory')
											 . '/' . $pbOptions["cssFilename"],
											 'pagebar-stylesheet');
}
/* -------------------------------------------------------------------------- */
function pagebar_activate() {
		require_once "activate.php";
} //pagebar_activate()
/* -------------------------------------------------------------------------- */
/* add Settings link to plugin page                                           */
function pagebar_addConfigureLink( $links ) {  // add Settings link to plugin page
  $settings_link = '<a href="options-general.php?page=pagebar_options.php">'. __('Settings').'</a>';
  array_unshift( $links, $settings_link );
  return $links;
} //addConfigureLink()
/* -------------------------------------------------------------------------- */
// pagebar >= v2.5 requires PHP>=5 and WP>=2.7, check and disable update if
// necessary.

function pagebar_plugin_prevent_upgrade($opt) {
    global $wp_version, $min_wp, $min_php;
		$min_php = '5.0.0';
		$min_wp  = '2.7';
		if ( (version_compare(PHP_VERSION, $min_php, '<')) || (version_compare($wp_version, $min_wp, '<')) ) {
				$plugin = plugin_basename(__FILE__);
				if ( $opt && isset($opt->response[$plugin]) ) {
						//Theres an update. Remove automatic upgrade:
						$opt->response[$plugin]->package = '';

						//Now we've prevented the upgrade taking place, It might be worth to give users a note that theres an update available:
						add_action("after_plugin_row_$plugin", 'pagebar_plugin_update_disabled_notice');
				} //if
		} //if
		return $opt;
}  //plugin_prevent_update()
/* -------------------------------------------------------------------------- */
function pagebar_plugin_update_disabled_notice() {
		global $wp_version, $min_wp, $min_php;
		echo '<tr><td class="plugin-update" colspan="5">';
    echo 'There is an update available for this plugin. However the plugin requires';

		if (version_compare(PHP_VERSION, $min_php, '<'))
				echo ' PHP v'.$min_php.' or newer';

		if ( (version_compare(PHP_VERSION, $min_php, '<')) && (version_compare($wp_version, $min_wp, '<')) )
		  echo ' and';

		if (version_compare($wp_version, $min_wp, '<'))
				echo  ' WordPress v'.$min_wp.' or newer.';

		echo '</td></tr>';
} //plugin_update_disabled_notice()

/* -------------------------------------------------------------------------- */
// add filter for displaying complete paged page
add_filter('the_content', 'pb_allpage_show', 0);
function pb_allpage_show($content) {
		global $multipage, $page, $posts, $numpages, $page_comments, $wp_query;

		if ($multipage && $all_page = get_query_var('all')) {
				$content = $posts[0]->post_content;
		}
		return $content;
}

/* -------------------------------------------------------------------------- */
// add filter to override the paging of comments if the user
// clicked "all comments"
//add_filter('pre_option_page_comments','override_page_comments');
//function override_page_comments() {
//		return (is_singular() && $all_page = get_query_var('all')) ? 0 : 1;
//}
/* -------------------------------------------------------------------------- */
// add filter to allow URL parameter "all"
add_action('init', 'pb_allpage_permalink', 99);
function pb_allpage_permalink() {
	global $wp_rewrite;
	$wp_rewrite->add_endpoint("all", EP_ALL);
	$wp_rewrite->flush_rules(false);
}
/* -------------------------------------------------------------------------- */
function pb_remove_nav() {
	if (! is_single ())
		echo "\n<style type=\"text/css\">.navigation{display: none;}</style>\n";
}
/* -------------------------------------------------------------------------- */
// add filter to allow URL parameter "all"
add_filter('query_vars', 'pb_AllPageEndpointQueryVarsFilter');
function pb_AllPageEndpointQueryVarsFilter($vars){
	$vars[] = 'all';
	return $vars;
}

/* -------------------------------------------------------------------------- */
function register_pagebar_settings() {
		register_setting('pagebar-options', 'postbar');
		register_setting('pagebar-options', 'multipagebar');
		register_setting('pagebar-options', 'commentbar');
}
/* -------------------------------------------------------------------------- */
/* main()                                                                     */

// load language file
$pagebar_dir = trailingslashit(WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)));
$locale = get_locale();
$mofile = $pagebar_dir.'language/pagebar-'.$locale.'.mo';
load_textdomain('pagebar', $mofile);

if (is_admin()) {
		require ('pagebar_options.php');
		add_action ( 'admin_print_scripts', array(&$pagebaroptions, 'pb_load_jquery'));
		//$pagebaroptions->pb_load_jquery();
		$plugin = plugin_basename(__FILE__);
		add_filter("plugin_action_links_$plugin", 'pagebar_addConfigureLink' );
		add_action('admin_init', 'register_pagebar_settings');
}

// add filter to prevent updates if PHP<5 and Wp<2.7
if (in_array($pagenow, array("plugins.php")))
  add_filter('option_update_plugins', 'pagebar_plugin_prevent_upgrade');

// we need to load the postbar option outside the classes since the actions
// need to be started. There may be an different solution but I did not find one.
if (! $pbOptions = get_option ( 'postbar' )) {
		pagebar_activate();
		$pbOptions = get_option('postbar');
};
// add_action ( 'activate_'.dirname(plugin_basename(__FILE__)).'/pagebar.php', 'pagebar_activate' );
// register_activation_hook( __FILE__, 'pagebar_activate' );

add_action ( 'wp_head', 'pagebar_addUserStylesheet');

if ($pbOptions ['auto'] && in_array($pagenow, array("index.php"))) {
	if ($pbOptions ["bef_loop"] == "on")
		add_action ( 'loop_start', 'pagebar' );
	if ($pbOptions ["aft_loop"] == "on")
		add_action ( 'loop_end', 'pagebar' );
	if ($pbOptions ["footer"] == "on")
				add_action ( 'wp_footer', 'pagebar' );
	if ($pbOptions ["remove"] == "on")
		add_action ( 'wp_head', 'pb_remove_nav' );
} //if
