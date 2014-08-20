<?php
/*
Plugin Name: HTML Purified
Plugin URI: http://urbangiraffe.com/plugins/html-purified/
Description: Replaces default HTML filters with <a href="http://htmlpurifier.org/">HTML Purifier</a>
Author: John Godley
Version: 0.4
Author URI: http://urbangiraffe.com/
============================================================================================================
See included file license.txt for details of the license
============================================================================================================ */

require dirname( __FILE__ ).'/plugin.php';

/**
 * The HTML Purifier plugin
 *
 * @package HTML Purified
 **/
class PurifiedPlugin extends HP_Plugin {
	var $doctype;
	var $is_bbpress = false;

	/**
	 * Constructor hooks into all appropriate filters and actions
	 *
	 * @return void
	 **/
	function PurifiedPlugin() {
		$this->register_plugin( 'html-purified', __FILE__ );

		if ( is_admin() ) {
			$this->add_action( 'admin_menu' );
			$this->add_action( 'bb_admin_menu_generator', 'bb_admin_menu' );
			$this->add_action( 'bb_admin_head' );
			$this->register_plugin_settings( __FILE__ );
			
			$this->doctype = array(
				'html-strict'  => __( 'HTML 4.01 Strict', 'html-purified' ),
		    'html-trans'   => __( 'HTML 4.01 Transitional', 'html-purified' ),
		    'xhtml-strict' => __( 'XHTML 1.0 Strict', 'html-purified' ),
		    'xhtml-trans'  => __( 'XHTML 1.0 Transitional', 'html-purified' ),
		    'xhtml-11'     => __( 'XHTML 1.1', 'html-purified' ),
			);
		}

		remove_action( 'init', 'kses_init' );
		remove_action( 'set_current_user', 'kses_init' );

		if ( defined( 'BBPATH' ) )
			$this->add_action( 'bb_init' );
		else {
			$this->add_action( 'init' );
			$this->add_action( 'set_current_user', 'init' );
		}

		$this->add_action( 'wp_footer' );
		$this->add_action( 'bb_foot', 'wp_footer' );
	}

	function plugin_settings( $links ) {
		$settings_link = '<a href="options-general.php?page='.basename( __FILE__ ).'">'.__( 'Settings', 'html-purified' ).'</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Add an options menu page in administration section
	 *
	 * @return void
	 **/
	function admin_menu() {
   	add_options_page( __( 'HTML Purified', 'html-purified' ), __( 'HTML Purified', 'html-purified' ), 'administrator', basename( __FILE__ ), array( &$this, 'admin_screen' ) );
	}

	function bb_admin_menu() {
		bb_admin_add_submenu( __( 'HTML Purified' ), 'administrate', 'bb_html_purifier_admin' );
	}
	
	function bb_admin_head() {
		if ( isset( $_GET['plugin'] ) == 'bb_html_purifier_admin' )
			$this->render_admin( 'head' );
	}

	function submenu( $inwrap = false ) {
		// Decide what to do
		$sub = isset( $_GET['sub'] ) ? $_GET['sub'] : '';
	  $url = explode( '&', $_SERVER['REQUEST_URI'] );
	  $url = $url[0];

		if ( $inwrap )
			$this->render_admin( 'submenu', array( 'url' => $url, 'sub' => $sub ) );
		return $sub;
	}

	/**
	 * Decide which administration page to display
	 *
	 * @return void
	 **/
	function admin_screen() {
		// Decide what to do
		$sub = $this->submenu();

		// Display screen
		if ( $sub == '' )
			$this->admin_general();
		elseif ( $sub == 'purifier' )
			$this->admin_purifier();
	}

	/**
	 * Sort a set of allowed tags
	 *
	 * @param string $tags Newline-delimited tags
	 * @return string Ordered newline-delimited tags
	 **/
	function order_tags( $tags ) {
		$lines = preg_split( '/[\r\n]+/', $tags );
		sort( $lines );
		return implode( "\r\n", $lines );
	}

	/**
	 * The general settings admin page
	 *
	 * @return void
	 **/
	function admin_general() {
		if ( isset( $_POST['save-general'] ) ) {
			$options = $this->get_options();

			$options['filter']         = $_POST['filter'];
			$options['force_filter']   = isset( $_POST['force_filter'] ) ? true : false;
			$options['auto_php']       = isset( $_POST['auto_php'] ) ? true : false;
			$options['back_tick']      = isset( $_POST['back_tick'] ) ? true : false;
			$options['footer_message'] = isset( $_POST['footer_message'] ) ? true : false;

			if ( $_POST['allowed_tags'] != 'reset' )
				$options['allowed_tags'] = $this->order_tags( $_POST['allowed_tags'] );

			// Save
			update_option( 'html_purified', $options );

			$this->clear_cache();
			$this->render_message( __( 'Your options have been saved', 'html-purified' ) );
		}

		$filters = array(
			'purifier' => __( 'HTML Purifier', 'html-purified' ),
			'kses'     => __( 'KSES', 'html-purified' )
		);

		$this->render_admin( 'options-general', array( 'filters' => $filters, 'options' => $this->get_options() ) );
	}

	/**
	 * The HTML purifier admin page
	 *
	 * @return void
	 **/
	function admin_purifier() {
		if ( isset( $_POST['save-purifier'] ) )	{
			$options = $this->get_options();

			$options['uri_blacklist'] = $_POST['uri_blacklist'];
			$options['cache']         = isset( $_POST['cache'] ) ? true : false;
			$options['bbcode']        = isset( $_POST['bbcode'] ) ? true : false;
			$options['encoding']      = $_POST['encoding'];
			$options['tidy']          = $_POST['tidy'];

			update_option( 'html_purified', $options );

			$this->clear_cache();
			$this->render_message( __( 'Your options have been saved', 'html-purified' ) );
		}

		$tidy = array(
			'none'   => __( 'None', 'html-purified' ),
			'light'  => __( 'Light', 'html-purified' ),
			'medium' => __( 'Medium', 'html-purified' ),
			'heavy'  => __( 'Heavy', 'html-purified' ),
		);

		$options = $this->get_options();
		if ( $options['cache'] === true && !is_writeable( $this->cache_directory() ) )
			$this->render_error( sprintf( __( 'The cache directory <code>%s</code> is not writeable.', 'html-purified' ), $this->dir_relative_wp( $this->cache_directory() ) ) );

		$this->render_admin( 'options-purifier', array( 'encodings' => $this->doctype, 'tidy' => $tidy, 'options' => $options ) );
	}

	function dir_relative_wp( $dir ) {
		return str_replace( ABSPATH, '', $dir );
	}

	/**
	 * Get all HTML Purified options
	 *
	 * @return array
	 **/
	function get_options() {
		global $allowedposttags;

		$options = get_option( 'html_purified' );
		if ( $options === false)
			$options = array();

		$default = array(
			'filter'            => 'purifier',
			'force_filter'      => true,
			'encoding'          => 'xhtml-trans',
			'tidy'              => 'medium',
			'uri_blacklist'     => '',
			'cache'             => false,
			'auto_php'          => true,
			'back_tick'         => true,
			'bbcode'            => true,
			'footer_message'    => true,
		);

		foreach ( $default AS $key => $value ) {
			if ( !isset( $options[$key] ) )
				$options[$key] = $value;
		}

		if ( !isset( $options['allowed_post_tags'] ) || $options['allowed_post_tags'] == '' )
			$options['allowed_post_tags'] = implode( "\r\n", $this->convert_kses_to_purifier( $allowedposttags ) );

		return $options;
	}

	function get_allowed_tags() {
		$options = $this->get_options();

		if ( !isset( $options['allowed_tags'] ) || strtolower( $options['allowed_tags'] ) == 'reset' || $options['allowed_tags'] == '' ) {
			global $allowedtags;

			// Check for bbPress
			if ( $this->is_bbpress ) {
				remove_filter( 'bb_allowed_tags', array( $this, 'bb_allowed_tags' ) );
				$allowedtags = bb_allowed_tags();
				remove_filter( 'bb_allowed_tags', array( $this, 'bb_allowed_tags' ) );
			}

			return implode( "\r\n", $this->convert_kses_to_purifier( $allowedtags ) )."\r\np";
		}

		return $options['allowed_tags'];
	}

	/**
	 * Get an HTML Purifier object with all settings already configured
	 *
	 * @param boolean $for_post Whether the purifier is for posts or comments
	 * @param boolean $tags Override configured tags
	 * @return HTMLPurifier
	 **/
	function get_purifier( $for_post = false, $tags = '' ) {
		include_once dirname( __FILE__ ).'/lib/HTMLPurifier.auto.php';

		$options = $this->get_options();

	 	$config = HTMLPurifier_Config::createDefault();

		// Set base options
		if ( $this->is_bbpress )
			$config->set( 'Core.Encoding', get_option( 'charset' ) );
		else
			$config->set( 'Core.Encoding', get_option( 'blog_charset' ) );

		$config->set( 'HTML.Doctype', $this->doctype[$options['encoding']] );
		$config->set( 'HTML.TidyLevel', $options['tidy'] );

		// If we have Tidy enabled, make sure it pretty-prints
		if ( $options['tidy'] != 'none' )
			$config->set( 'Output.TidyFormat', true );

		// Add any URL blacklist
		if ( $options['uri_blacklist'] )
			$config->set( 'URI.HostBlacklist', preg_split( '/[\r\n]+/', $options['uri_blacklist'] ) );

		// If we can write to the cache directory then set it(directory is same as used by WP-Cache and WP object cache)
		if ( $options['cache'] === true && is_writeable( dirname( $this->cache_directory() ) ) ) {
			if ( !file_exists( $this->cache_directory() ) )
				@mkdir( $this->cache_directory() );

			$config->set( 'Cache.SerializerPath', $this->cache_directory() );
		}
		else
			$config->set( 'Cache.DefinitionImpl', null );

		// Set the allowed tags
		if ( $tags == '' ) {
			if ( $for_post === true )
				$tags = $this->tags_for_purifier( $options['allowed_post_tags'] );
			else
				$tags = $this->tags_for_purifier( $this->get_allowed_tags() );
		}

		$config->set( 'HTML.Allowed', $tags );

		$count = get_option( 'html_purified_count' );
		if ( $count === false )
			$count = 0;

		update_option( 'html_purified_count', $count + 1 );
		return new HTMLPurifier( $config );
	}

	/**
	 * Return the cache directory
	 *
	 * @return string
	 **/
	function cache_directory() {
		if ( $this->is_bbpress )
			return $this->realpath( BBPATH . 'bb-cache/html-purified' );
		else
			return $this->realpath( dirname( __FILE__ ).'/../../cache/html-purified' );
	}

	/**
	 * Clears any cached data
	 *
	 * @return void
	 **/
	function clear_cache() {
		$dir = $this->cache_directory();
		if ( $this->is_bbpress && !file_exists( $dir ) )
			@mkdir( $this->cache_directory() );

		if ( is_writeable( $dir ) ) {
			$files = glob( $dir.'/*' );

			if ( !empty( $files) )	{
				foreach( $files AS $file )
					$this->unlink( $file );
			}
		}
	}

	/**
	 * Recursively delete a directory
	 *
	 * @return boolean
	 **/
	function unlink( $path ) {
		if ( !file_exists( $path ) )
			return false;

		if ( is_file( $path ) || is_link( $path ) )
			return unlink( $path );

		$files = glob( $path.'/*' );
		foreach ( (array)$files as $filename ) {
			if ( $filename == '.' || $filename == '..' )
				continue;

			$this->unlink( $filename );
		}

		if ( !@rmdir( $path ) )
			return false;
		return true;
  }

	function bbcode_tag( $data ) {
		return str_replace( '"', ';quot;', $data[0] );
	}

	function filter( $data ) {
		$purifier = $this->get_purifier();
		$options  = $this->get_options();

		if ( $options['bbcode'] )
			$data = preg_replace_callback( '/\[(.*?)\]/', array( &$this, 'bbcode_tag' ), $data );

		if ( $this->is_bbpress )
			$data = @$purifier->purify( stripslashes( $data ) );
		else
			$data = addslashes( @$purifier->purify( stripslashes( $data ) ) );

		if ( $options['bbcode'])
			$data = str_replace( ';quot;', '"', $data );
		return $data;
	}

	/**
	 * WordPress hook to filter posts
	 *
	 * @param string Post text
	 * @return string Purified text
	 **/
	function filter_post( $data ) {
		$purifier = $this->get_purifier( true );
		return addslashes( @$purifier->purify( stripslashes( $data ) ) );
	}

	/**
	 * Convert KSES tags into purifier tags
	 *
	 * @param array Array of KSES-style tags
	 * @return array Array of HTML purifier tags
	 **/
	function convert_kses_to_purifier( $tags ) {
		$newtags = array();

		if ( count( $tags ) > 0 ) {
			foreach ( $tags AS $tag => $attributes ) {
				if ( count( $attributes ) > 0 )
					$newtags[] = $tag.'['.implode( '|', array_keys( $attributes ) ).']';
				else
					$newtags[] = $tag;
			}
		}

		return $newtags;
	}

	/**
	 * Convert newline-delimited tags into HTML purifier style tags
	 *
	 * @param string $tags Newline-delimited tags
	 * @return string Tags
	 **/
	function tags_for_purifier( $tags ) {
		// Convert newline-delimited tags into purifier-style string
		return preg_replace( '/[\r\n]+/', ',', $tags );
	}

	/**
	 * Convert newline-delimited tags into KSES-style array
	 *
	 * @param string $tags Newline-delimited tags
	 * @return array KSES-style array
	 **/
	function tags_for_kses( $tags ) {
		// Convert newline-delimited tags into KSES-style array
		$allowed = array();
		$tags    = preg_split( '/[\r\n]+/', $tags );

		foreach ( $tags AS $tag ) {
			$attr = array();

			if ( preg_match( '/(\w+)\[(.*?)\]/', $tag, $attributes ) > 0 ) {
				$parts = explode( '|', $attributes[2] );
				foreach( $parts AS $part )
					$attr[$part] = array();

				$allowed[$attributes[1]] = $attr;
			}
			else
				$allowed[$tag] = array();
		}

		return $allowed;
	}


	function bb_init() {
		$this->is_bbpress = true;

		$options = $this->get_options();
		if ( $options['force_filter'] == true || !bb_current_user_can( 'administrate' ) )
		{
			if ( $options['auto_php'] )
				$this->add_filter( 'pre_post', 'auto_php', 2 );

			if ( $options['back_tick'] )
				$this->add_filter( 'pre_post', 'back_tick', 1 );

			if ( $options['filter'] == 'purifier' ) {
				remove_filter( 'pre_post', 'bb_code_trick' );
				remove_filter( 'pre_post', 'bb_encode_bad' );
				remove_filter( 'pre_post', 'bb_filter_kses', 50 );

				$this->add_filter( 'pre_post', 'filter' );
			}
		}

		$this->add_filter( 'bb_allowed_tags' );
	}

	function bb_allowed_tags( $tags ) {
		return $this->tags_for_kses( $this->get_allowed_tags() );
	}

	/**
	 * Hook into core of WordPress to override the allowed tags, and to inject our own filtering routine
	 *
	 * @return void
	 **/
	function init() {
		$options = $this->get_options();

		// Change $allowedtags and $allowedposttags
		global $allowedtags, $allowedposttags;

		if ( $this->get_allowed_tags() != '' )
			$allowedtags = $this->tags_for_kses( $this->get_allowed_tags() );

		if ( $options['allowed_post_tags'] != '' )
			$allowedposttags = $this->tags_for_kses( $options['allowed_post_tags'] );

		// Remove standard KSES filters
		kses_remove_filters();

		// Now inject our own stuff
		if ( $options['force_filter'] === true || current_user_can( 'unfiltered_html' ) == false ) {
			if ( $options['auto_php'] )
				$this->add_filter( 'pre_comment_content', 'auto_php', 2 );

			if ( $options['back_tick'] )
				$this->add_filter( 'pre_comment_content', 'back_tick', 1 );

			if ( $options['filter'] == 'kses' )
				kses_init_filters();
			elseif ( $options['filter'] == 'purifier' ) {
				// Normal filtering.
				$this->add_filter( 'pre_comment_content', 'filter' );
				$this->add_filter( 'title_save_pre',      'filter' );
			}

			if ( current_user_can( 'unfiltered_html' ) == false ) {
				add_filter( 'content_save_pre', 'wp_filter_post_kses' );
				add_filter( 'excerpt_save_pre', 'wp_filter_post_kses' );
				add_filter( 'content_filtered_save_pre', 'wp_filter_post_kses' );
			}
		}
	}

	function escape_html_code( $matches ) {
		return '<code>'.htmlspecialchars( html_entity_decode( $matches[1] ) ).'</code>';
	}
	
	function escape_html_pre( $matches ) {
		$multi = ( substr_count( $matches[1], "\n" ) > 1 ) ? true : false;
		
		if ( strpos( $matches[1], '?php' ) !== false ) {
			$pre = '<pre class="singlephp">';
			if ( $multi )
				$pre = '<pre class="multiphp">';
		}
		else {
			$pre = '<pre class="singlehtml">';
			if ( $multi )
				$pre = '<pre class="multihtml">';
		}

		return $pre.htmlspecialchars( html_entity_decode( $matches[1] ) )."</pre>\n";
	}

	function back_tick( $comments ) {
		$comments = preg_replace_callback( '@^ *`(.*?)` *@m', array( &$this, 'escape_html_pre' ), $comments );
		$comments = preg_replace_callback( '@`(.*?)`@m', array( &$this, 'escape_html_code' ), $comments );
		$comments = preg_replace_callback( '@`(.*?)`@s', array( &$this, 'escape_html_pre' ), $comments );
		return $comments;
	}

	function auto_php( $comment ) {
		$comment = preg_replace_callback( '@^ *(<\?php.*?\?>) *@m', array( &$this, 'escape_html_pre' ), $comment );
		$comment = preg_replace_callback( '@(<\?php.*?\?>)@mi', array( &$this, 'escape_html_code' ), $comment );
		$comment = preg_replace_callback( '@(<\?php.*?\?>)@si', array( &$this, 'escape_html_pre' ), $comment );
		return $comment;
	}

	/**
	 * Inject footer statistics
	 *
	 * @return void
	 **/
	function wp_footer() {
		$options = $this->get_options();

		if ( $options['footer_message'] === true ) {
			$count = get_option( 'html_purified_count' );

			if ( $count > 0 )
				$end = sprintf( _n( '%d item has been purified.', '%d items have been purified.', $count, 'html-purified' ), $count );

			$end .= '</p></div>';
			$str  = __( 'This site is protected with <a style="color: #ddd; background-color: #333" href="http://urbangiraffe.com/">Urban Giraffe\'s</a> plugin \'<a style="color: #ddd; background-color: #333" href="http://urbangiraffe.com/plugins/html-purified/">HTML Purified</a>\' and Edward Z. Yang\'s <a href="http://htmlpurifier.org/"><img src="http://htmlpurifier.org/live/art/powered.png" align="middle" alt="Powered by HTML Purifier" border="0" width="80" height="15"/></a>', 'html-purified' );
			echo '<div style="font-size: 1em; border-top: 1px solid #666; padding-left: 2px; text-align: center; background-color: #333; color: #999; line-height: 1.6"><p style="padding: 2px 0px; margin: 0">'.$str.'. '.$end;
		}
	}
}

function bb_html_purifier_admin() {
	global $html_purifier;

	$html_purifier->admin_screen();
}

// bbPress compatible commands
if ( !function_exists( 'is_admin' ) ) {
	function is_admin() {
		return is_bb_admin();
	}

	function get_option( $option ) {
		return bb_get_option( $option );
	}

	function get_bloginfo( $option ) {
		if ( $option == 'wpurl' )
			return bb_get_option( 'uri' );
	}

	function update_option( $option, $value ) {
		return bb_update_option( $option, $value );
	}
}

/**
 * Instantiate our purifier plugin
 *
 * @global
 **/

if ( version_compare( phpversion(), '5.0', '>=' ) )
	$html_purifier = new PurifiedPlugin();
