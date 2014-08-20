<?php
/**
 * nggAdminPanel - Admin Section for NextGEN Gallery
 * 
 * @package NextGEN Gallery
 * @author Alex Rabe
 * @copyright 2008-2010
 * @since 1.0.0
 */
class nggAdminPanel{
	
	// constructor
	function nggAdminPanel() {

		// Add the admin menu
		add_action( 'admin_menu', array (&$this, 'add_menu') ); 
		add_action( 'network_admin_menu', array (&$this, 'add_network_admin_menu') );
        
		// Add the script and style files
		add_action('admin_print_scripts', array(&$this, 'load_scripts') );
		add_action('admin_print_styles', array(&$this, 'load_styles') );

		add_filter('contextual_help', array(&$this, 'show_help'), 10, 2);
		add_filter('screen_meta_screen', array(&$this, 'edit_screen_meta'));
        
	}

	// integrate the menu	
	function add_menu()  {
	
		add_menu_page( _n( 'Gallery', 'Galleries', 1, 'nggallery' ), _n( 'Gallery', 'Galleries', 1, 'nggallery' ), 'NextGEN Gallery overview', NGGFOLDER, array (&$this, 'show_menu'), 'div' );
	    add_submenu_page( NGGFOLDER , __('Overview', 'nggallery'), __('Overview', 'nggallery'), 'NextGEN Gallery overview', NGGFOLDER, array (&$this, 'show_menu'));
		add_submenu_page( NGGFOLDER , __('Add Gallery / Images', 'nggallery'), __('Add Gallery / Images', 'nggallery'), 'NextGEN Upload images', 'nggallery-add-gallery', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('Manage Gallery', 'nggallery'), __('Manage Gallery', 'nggallery'), 'NextGEN Manage gallery', 'nggallery-manage-gallery', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , _n( 'Album', 'Albums', 1, 'nggallery' ), _n( 'Album', 'Albums', 1, 'nggallery' ), 'NextGEN Edit album', 'nggallery-manage-album', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('Tags', 'nggallery'), __('Tags', 'nggallery'), 'NextGEN Manage tags', 'nggallery-tags', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('Options', 'nggallery'), __('Options', 'nggallery'), 'NextGEN Change options', 'nggallery-options', array (&$this, 'show_menu'));
	    if ( wpmu_enable_function('wpmuStyle') )
			add_submenu_page( NGGFOLDER , __('Style', 'nggallery'), __('Style', 'nggallery'), 'NextGEN Change style', 'nggallery-style', array (&$this, 'show_menu'));
	    if ( wpmu_enable_function('wpmuRoles') || wpmu_site_admin() )
			add_submenu_page( NGGFOLDER , __('Roles', 'nggallery'), __('Roles', 'nggallery'), 'activate_plugins', 'nggallery-roles', array (&$this, 'show_menu'));
	    add_submenu_page( NGGFOLDER , __('About this Gallery', 'nggallery'), __('About', 'nggallery'), 'NextGEN Gallery overview', 'nggallery-about', array (&$this, 'show_menu'));
		//TODO: Remove after WP 3.1 release, not longer needed 
        if ( wpmu_site_admin() ) 
			add_submenu_page( 'ms-admin.php' , __('NextGEN Gallery', 'nggallery'), __('NextGEN Gallery', 'nggallery'), 'activate_plugins', 'nggallery-wpmu', array (&$this, 'show_menu'));

	    if ( !is_multisite() || wpmu_site_admin() ) 
            add_submenu_page( NGGFOLDER , __('Reset / Uninstall', 'nggallery'), __('Reset / Uninstall', 'nggallery'), 'activate_plugins', 'nggallery-setup', array (&$this, 'show_menu'));

		//register the column fields
		$this->register_columns();	
	}

	// integrate the network menu	
	function add_network_admin_menu()  {
	
		add_menu_page( _n( 'Gallery', 'Galleries', 1, 'nggallery' ), _n( 'Gallery', 'Galleries', 1, 'nggallery' ), 'nggallery-wpmu', NGGFOLDER, array (&$this, 'show_network_settings'), 'div' );
		add_submenu_page( NGGFOLDER , __('Network settings', 'nggallery'), __('Network settings', 'nggallery'), 'nggallery-wpmu', NGGFOLDER,  array (&$this, 'show_network_settings'));
        add_submenu_page( NGGFOLDER , __('Reset / Uninstall', 'nggallery'), __('Reset / Uninstall', 'nggallery'), 'activate_plugins', 'nggallery-setup', array (&$this, 'show_menu'));
	}

    // show the network page
    function show_network_settings() {
		include_once ( dirname (__FILE__) . '/style.php' );		
		include_once ( dirname (__FILE__) . '/wpmu.php' );
		nggallery_wpmu_setup();        
    }

	// load the script for the defined page and load only this code	
	function show_menu() {
		
		global $ngg;

		// check for upgrade and show upgrade screen
		if( get_option( 'ngg_db_version' ) != NGG_DBVERSION ) {
			include_once ( dirname (__FILE__) . '/functions.php' );
			include_once ( dirname (__FILE__) . '/upgrade.php' );
			nggallery_upgrade_page();
			return;			
		}
		
		// Set installation date
		if( empty($ngg->options['installDate']) ) {
			$ngg->options['installDate'] = time();
			update_option('ngg_options', $ngg->options);			
		}
		
		// Show donation message only one time.
		if (isset ( $_GET['hide_donation']) ) {
			$ngg->options['hideDonation'] = true;
			update_option('ngg_options', $ngg->options);			
		}
		
		if( !isset ( $ngg->options['hideDonation']) ||  $ngg->options['hideDonation'] !== true ) {
			if ( time() > ( $ngg->options['installDate'] + ( 60 * 60 * 24 * 30 ) ) ) {
			?>	
				<div id="donator_message">
					<p><?php echo str_replace('%s', 'http://alexrabe.de/donation', __('Thanks for using this plugin, I hope you are satisfied ! If you would like to support the further development, please consider a <strong><a href="%s">donation</a></strong>! If you still need some help, please post your questions <a href="http://wordpress.org/tags/nextgen-gallery?forum_id=10">here</a> .', 'nggallery')); ?>
						<span>
							<a href="<?php echo add_query_arg( array( 'hide_donation' => 'true') ); ?>" >
								<small><?php _e('OK, hide this message now !', 'nggallery'); ?></small>
							</a>
						<span>
					</p>
				</div>
			<?php
			}
		}
		
  		switch ($_GET['page']){
			case "nggallery-add-gallery" :
				include_once ( dirname (__FILE__) . '/functions.php' );		// admin functions
				include_once ( dirname (__FILE__) . '/addgallery.php' );    // nggallery_admin_add_gallery
				$ngg->addgallery_page = new nggAddGallery ();
				$ngg->addgallery_page->controller();
				break;
			case "nggallery-manage-gallery" :
				include_once ( dirname (__FILE__) . '/functions.php' );	// admin functions
				include_once ( dirname (__FILE__) . '/manage.php' );	// nggallery_admin_manage_gallery
				// Initate the Manage Gallery page
				$ngg->manage_page = new nggManageGallery ();
				// Render the output now, because you cannot access a object during the constructor is not finished
				$ngg->manage_page->controller();
				
				break;
			case "nggallery-manage-album" :
				include_once ( dirname (__FILE__) . '/album.php' );		// nggallery_admin_manage_album
				$ngg->manage_album = new nggManageAlbum ();
				$ngg->manage_album->controller();
				break;				
			case "nggallery-options" :
				include_once ( dirname (__FILE__) . '/settings.php' );	// nggallery_admin_options
				$ngg->option_page = new nggOptions ();
				$ngg->option_page->controller();
				break;
			case "nggallery-tags" :
				include_once ( dirname (__FILE__) . '/tags.php' );		// nggallery_admin_tags
				break;
			case "nggallery-style" :
				include_once ( dirname (__FILE__) . '/style.php' );		// nggallery_admin_style
				nggallery_admin_style();
				break;
			case "nggallery-setup" :
				include_once ( dirname (__FILE__) . '/setup.php' );		// nggallery_admin_setup
				nggallery_admin_setup();
				break;
			case "nggallery-roles" :
				include_once ( dirname (__FILE__) . '/roles.php' );		// nggallery_admin_roles
				nggallery_admin_roles();
				break;
			case "nggallery-import" :
				include_once ( dirname (__FILE__) . '/myimport.php' );	// nggallery_admin_import
				nggallery_admin_import();
				break;
			case "nggallery-about" :
				include_once ( dirname (__FILE__) . '/about.php' );		// nggallery_admin_about
				nggallery_admin_about();
				break;
            //TODO: Remove after WP 3.1 release, not longer needed   
			case "nggallery-wpmu" :
				include_once ( dirname (__FILE__) . '/style.php' );		
				include_once ( dirname (__FILE__) . '/wpmu.php' );		// nggallery_wpmu_admin
				nggallery_wpmu_setup();
				break;
			case "nggallery" :
			default :
				include_once ( dirname (__FILE__) . '/overview.php' ); 	// nggallery_admin_overview
				nggallery_admin_overview();
				break;
		}
	}
	
	function load_scripts() {
		
		// no need to go on if it's not a plugin page
		if( !isset($_GET['page']) )
			return;

		wp_register_script('ngg-ajax', NGGALLERY_URLPATH . 'admin/js/ngg.ajax.js', array('jquery'), '1.4.1');
		wp_localize_script('ngg-ajax', 'nggAjaxSetup', array(
					'url' => admin_url('admin-ajax.php'),
					'action' => 'ngg_ajax_operation',
					'operation' => '',
					'nonce' => wp_create_nonce( 'ngg-ajax' ),
					'ids' => '',
					'permission' => __('You do not have the correct permission', 'nggallery'),
					'error' => __('Unexpected Error', 'nggallery'),
					'failure' => __('A failure occurred', 'nggallery')				
		) );
		wp_register_script('ngg-progressbar', NGGALLERY_URLPATH .'admin/js/ngg.progressbar.js', array('jquery'), '2.0.1');
		wp_register_script('swfupload_f10', NGGALLERY_URLPATH .'admin/js/swfupload.js', array('jquery'), '2.2.0');
        // Package included sortable, dialog, autocomplete, tabs
        wp_register_script('jquery-ui', NGGALLERY_URLPATH .'admin/js/jquery-ui-1.8.6.min.js', array('jquery'), '1.8.6');
        // Until release of 3.1 not used, due to script conflict
        wp_register_script('jquery-ui-autocomplete', NGGALLERY_URLPATH .'admin/js/jquery.ui.autocomplete.min.js', array('jquery-ui-core'), '1.8.6');
        wp_register_script('ngg-autocomplete', NGGALLERY_URLPATH .'admin/js/ngg.autocomplete.js', array('jquery-ui'), '1.0');
				
		switch ($_GET['page']) {
			case NGGFOLDER : 
				wp_enqueue_script( 'postbox' );
				add_thickbox();
			break;	
			case "nggallery-manage-gallery" :
				wp_enqueue_script( 'postbox' );
				wp_enqueue_script( 'ngg-ajax' );
				wp_enqueue_script( 'ngg-progressbar' );
				wp_enqueue_script( 'jquery-ui-dialog' );
				add_thickbox();
			break;
			case "nggallery-manage-album" :
                // Until release of 3.1 comment out, due to script conflict
				//wp_enqueue_script( 'jquery-ui-sortable' );
                //wp_enqueue_script( 'jquery-ui-dialog' );
                wp_enqueue_script( 'ngg-autocomplete' );
			break;
			case "nggallery-options" :
				wp_enqueue_script( 'jquery-ui-tabs' );
				//wp_enqueue_script( 'ngg-colorpicker', NGGALLERY_URLPATH .'admin/js/colorpicker/js/colorpicker.js', array('jquery'), '1.0');
			break;		
			case "nggallery-add-gallery" :
				wp_enqueue_script( 'jquery-ui-tabs' );
				wp_enqueue_script( 'mutlifile', NGGALLERY_URLPATH .'admin/js/jquery.MultiFile.js', array('jquery'), '1.4.4' );
				wp_enqueue_script( 'ngg-swfupload-handler', NGGALLERY_URLPATH .'admin/js/swfupload.handler.js', array('swfupload_f10'), '1.0.3' );
				wp_enqueue_script( 'ngg-ajax' );
				wp_enqueue_script( 'ngg-progressbar' );
                wp_enqueue_script( 'jquery-ui-dialog' );
				wp_enqueue_script( 'jqueryFileTree', NGGALLERY_URLPATH .'admin/js/jqueryFileTree/jqueryFileTree.js', array('jquery'), '1.0.1' );
			break;
			case "nggallery-style" :
				wp_enqueue_script( 'codepress' );
				wp_enqueue_script( 'ngg-colorpicker', NGGALLERY_URLPATH .'admin/js/colorpicker/js/colorpicker.js', array('jquery'), '1.0');
			break;

		}
	}		
	
	function load_styles() {
        // load the icon for the navigation menu
        wp_enqueue_style( 'nggmenu', NGGALLERY_URLPATH .'admin/css/menu.css', array() );
		wp_register_style( 'nggadmin', NGGALLERY_URLPATH .'admin/css/nggadmin.css', false, '2.8.1', 'screen' );
		wp_register_style( 'ngg-jqueryui', NGGALLERY_URLPATH .'admin/css/jquery.ui.css', false, '1.8.5', 'screen' );
        
        // no need to go on if it's not a plugin page
		if( !isset($_GET['page']) )
			return;

		switch ($_GET['page']) {
			case NGGFOLDER :
				wp_enqueue_style( 'thickbox' );	
			case "nggallery-about" :
				wp_enqueue_style( 'nggadmin' );
                wp_admin_css( 'css/dashboard' );
			break;
			case "nggallery-add-gallery" :
				wp_enqueue_style( 'ngg-jqueryui' );
				wp_enqueue_style( 'jqueryFileTree', NGGALLERY_URLPATH .'admin/js/jqueryFileTree/jqueryFileTree.css', false, '1.0.1', 'screen' );
			case "nggallery-options" :
				wp_enqueue_style( 'nggtabs', NGGALLERY_URLPATH .'admin/css/jquery.ui.tabs.css', false, '2.5.0', 'screen' );
				wp_enqueue_style( 'nggadmin' );
            break;    
			case "nggallery-manage-gallery" :
			case "nggallery-roles" :
			case "nggallery-manage-album" :
				wp_enqueue_style( 'ngg-jqueryui' );
				wp_enqueue_style( 'nggadmin' );
				wp_enqueue_style( 'thickbox' );			
			break;
			case "nggallery-tags" :
				wp_enqueue_style( 'nggtags', NGGALLERY_URLPATH .'admin/css/tags-admin.css', false, '2.6.1', 'screen' );
				break;
			case "nggallery-style" :
				wp_admin_css( 'css/theme-editor' );
				wp_enqueue_style('nggcolorpicker', NGGALLERY_URLPATH.'admin/js/colorpicker/css/colorpicker.css', false, '1.0', 'screen');
				wp_enqueue_style('nggadmincp', NGGALLERY_URLPATH.'admin/css/nggColorPicker.css', false, '1.0', 'screen');
			break;
		}	
	}
	
	function show_help($help, $screen) {
		
		// since WP3.0 it's an object
		if ( is_object($screen) )
			$screen = $screen->id;
		
		$link = '';
		// menu title is localized...
		$i18n = strtolower  ( _n( 'Gallery', 'Galleries', 1, 'nggallery' ) );

		switch ($screen) {
			case 'toplevel_page_' . NGGFOLDER :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Introduction</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-setup" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Setup</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-about" :
				$link  = __('<a href="http://alexrabe.de/wordpress-plugins/nextgen-gallery/languages/" target="_blank">Translation by alex rabe</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-roles" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Roles / Capabilities</a>', 'nggallery');
			break;
			case "{$i18n}_page_nggallery-style" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Styles</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/templates/" target="_blank">' . __('Templates', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-gallery" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Gallery management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/gallery-page/" target="_blank">' . __('Gallery example', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-manage-gallery" :
			case "nggallery-manage-gallery":
			case "nggallery-manage-images":
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Gallery management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/gallery-tags/" target="_blank">' . __('Gallery tags', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-manage-album" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Album management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/album/" target="_blank">' . __('Album example', 'nggallery') . '</a>';
				$link .= ' | <a href="http://nextgen-gallery.com/albumtags/" target="_blank">' . __('Album tags', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-tags" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-introduction/" target="_blank">Gallery tags</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/related-images/" target="_blank">' . __('Related images', 'nggallery') . '</a>';
				$link .= ' | <a href="http://nextgen-gallery.com/gallery-tags/" target="_blank">' . __('Gallery tags', 'nggallery') . '</a>';
				$link .= ' | <a href="http://nextgen-gallery.com/albumtags/" target="_blank">' . __('Album tags', 'nggallery') . '</a>';
			break;
			case "{$i18n}_page_nggallery-options" :
				$link  = __('<a href="http://dpotter.net/Technical/2008/03/nextgen-gallery-review-image-management/" target="_blank">Image management</a>', 'nggallery');
				$link .= ' | <a href="http://nextgen-gallery.com/custom-fields/" target="_blank">' . __('Custom fields', 'nggallery') . '</a>';
			break;
		}
		
		if ( !empty($link) ) {
			$help  = '<h5>' . __('Get help with NextGEN Gallery', 'nggallery') . '</h5>';
			$help .= '<div class="metabox-prefs">';
			$help .= $link;
			$help .= "</div>\n";
			$help .= '<h5>' . __('More Help & Info', 'nggallery') . '</h5>';
			$help .= '<div class="metabox-prefs">';
			$help .= __('<a href="http://wordpress.org/tags/nextgen-gallery?forum_id=10" target="_blank">Support Forums</a>', 'nggallery');
			$help .= ' | <a href="http://alexrabe.de/wordpress-plugins/nextgen-gallery/faq/" target="_blank">' . __('FAQ', 'nggallery') . '</a>';
			$help .= ' | <a href="http://code.google.com/p/nextgen-gallery/issues/list" target="_blank">' . __('Feature request', 'nggallery') . '</a>';
			$help .= ' | <a href="http://alexrabe.de/wordpress-plugins/nextgen-gallery/languages/" target="_blank">' . __('Get your language pack', 'nggallery') . '</a>';
			$help .= ' | <a href="http://code.google.com/p/nextgen-gallery/" target="_blank">' . __('Contribute development', 'nggallery') . '</a>';
			$help .= ' | <a href="http://wordpress.org/extend/plugins/nextgen-gallery" target="_blank">' . __('Download latest version', 'nggallery') . '</a>';
			$help .= "</div>\n";
		} 
		
		return $help;
	}
	
	function edit_screen_meta($screen) {

		// menu title is localized, so we need to change the toplevel name
		$i18n = strtolower  ( _n( 'Gallery', 'Galleries', 1, 'nggallery' ) );
		
		switch ($screen) {
			case "{$i18n}_page_nggallery-manage-gallery" :
				// we would like to have screen option only at the manage images / gallery page
				if ( isset ($_POST['sortGallery']) )
					$screen = $screen;
				else if ( ($_GET['mode'] == 'edit') || isset ($_POST['backToGallery']) )
					$screen = 'nggallery-manage-images';
				else if ( ($_GET['mode'] == 'sort') )
					$screen = $screen;
				else
					$screen = 'nggallery-manage-gallery';	
			break;
		}

		return $screen;
	}

	function register_column_headers($screen, $columns) {
		global $_wp_column_headers, $wp_list_table;
	
		if ( !isset($_wp_column_headers) )
			$_wp_column_headers = array();
	
		$_wp_column_headers[$screen] = $columns;
        
        //TODO: Deprecated in 3.1, see http://core.trac.wordpress.org/ticket/14579
       	//$wp_list_table = new _WP_List_Table_Compat($screen);
       	//$wp_list_table->_columns = $columns;
	}

	function register_columns() {
		include_once ( dirname (__FILE__) . '/manage-images.php' );
		
		$this->register_column_headers('nggallery-manage-images', ngg_manage_image_columns() );
		
		include_once ( dirname (__FILE__) . '/manage-galleries.php' );
		
		$this->register_column_headers('nggallery-manage-galleries', ngg_manage_gallery_columns() );	
	}

	/**
	 * Read an array from a remote url
	 * 
	 * @param string $url
	 * @return array of the content
	 */
	function get_remote_array($url) {
		if ( function_exists('wp_remote_request') ) {
					
			$options = array();
			$options['headers'] = array(
				'User-Agent' => 'NextGEN Gallery Information Reader V' . NGGVERSION . '; (' . get_bloginfo('url') .')'
			 );
			 
			$response = wp_remote_request($url, $options);
			
			if ( is_wp_error( $response ) )
				return false;
		
			if ( 200 != $response['response']['code'] )
				return false;
		   	
			$content = unserialize($response['body']);
	
			if (is_array($content)) 
				return $content;
		}
		
		return false;	
	}

}

function wpmu_site_admin() {
	// Check for site admin
	if ( function_exists('is_super_admin') )
		if ( is_super_admin() )
			return true;
			
	return false;
}

function wpmu_enable_function($value) {
	if (is_multisite()) {
		$ngg_options = get_site_option('ngg_options');
		return $ngg_options[$value];
	}
	// if this is not WPMU, enable it !
	return true;
}

?>