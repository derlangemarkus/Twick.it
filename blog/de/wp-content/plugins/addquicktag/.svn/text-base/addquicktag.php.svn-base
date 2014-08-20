<?php
/**
 * @package AddQuicktag
 * @author Roel Meurders, Frank B&uuml;ltge
 * @version 1.6.3
 */
 
/**
Plugin Name: AddQuicktag
Plugin URI:  http://bueltge.de/wp-addquicktags-de-plugin/120/
Description: Allows you to easily add custom Quicktags to the editor. You can also export and import your Quicktags.
Author:      Roel Meurders, Frank B&uuml;ltge
Author URI:  http://bueltge.de/
Version:     1.6.3
License:     GNU General Public License
Last Change: 16.06.2009 13:00:47

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.


	WP-AddQuicktag for WordPress is in originally by 
	(C) 2005 Roel Meurders - GNU General Public License

	AddQuicktag is an newer version with more functions and worked in WP 2.1
	(C) 2007 Frank Bueltge

	This Wordpress plugin is released under a GNU General Public License. A complete version of this license
	can be found here: http://www.gnu.org/licenses/gpl.txt

	This Wordpress plugin is released "as is". Without any warranty. The authors cannot
	be held responsible for any damage that this script might cause.
*/


if ( !function_exists ('add_action') ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

if ( function_exists('add_action') ) {
	// Pre-2.6 compatibility
	if ( !defined('WP_CONTENT_URL') )
		define( 'WP_CONTENT_URL', get_option('url') . '/wp-content');
	if ( !defined('WP_CONTENT_DIR') )
		define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	if ( !defined('WP_CONTENT_FOLDER') )
		define( 'WP_CONTENT_FOLDER', str_replace(ABSPATH, '/', WP_CONTENT_DIR) );

	// plugin definitions
	define( 'FB_WPAQ_BASENAME', plugin_basename( __FILE__ ) );
	define( 'FB_WPAQ_BASEFOLDER', plugin_basename( dirname( __FILE__ ) ) );
	define( 'FB_WPAQ_TEXTDOMAIN', 'addquicktag' );
}

// send file for save
if ( isset( $_GET['export'] ) ) {
	wpaq_export();
	die();
}

/**
 * active for multilanguage
 *
 * @package AddQuicktag
 */
function wpaq_textdomain() {

	if ( function_exists('load_plugin_textdomain') ) {
		if ( !defined('WP_PLUGIN_DIR') ) {
			load_plugin_textdomain( FB_WPAQ_TEXTDOMAIN, str_replace( ABSPATH, '', dirname(__FILE__) ) . '/languages' );
		} else {
			load_plugin_textdomain( FB_WPAQ_TEXTDOMAIN, false, dirname( plugin_basename(__FILE__) ) . '/languages' );
		}
	}
}


/**
 * install options in table _options
 *
 * @package AddQuicktag
 */
function wpaq_install() {
	
	$rmnlQuicktagSettings = array(
																'buttons' => array(
																									array(
																												'text'  => 'Example',
																												'title' => 'Example Title',
																												'start' => '<example>',
																												'end'   => '</example>'
																												)
																									)
																);
	add_option('rmnlQuicktagSettings', $rmnlQuicktagSettings);
}


/**
 * install options in table _options
 *
 * @package AddQuicktag
 */
function wpaq_reset() {
	
	$rmnlQuicktagSettings = array(
																'buttons' => array(
																									array(
																												'text'  => 'Reset',
																												'title' => 'Reset Title',
																												'start' => '<reset>',
																												'end'   => '</reset>'
																												)
																									)
																);
	update_option('rmnlQuicktagSettings', $rmnlQuicktagSettings);
}


/**
 * uninstall options in table _options
 *
 * @package AddQuicktag
 */
function wpaq_uninstall() {
	
	delete_option('rmnlQuicktagSettings');
}


/**
 * export options in file 
 *
 * @package AddQuicktag
 */
function wpaq_export() {
	global $wpdb;

	$filename = 'wpaq_export-' . date('Y-m-d_G-i-s') . '.wpaq';
		
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=" . urlencode($filename));
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header('Content-Type: text/wpaq; charset=' . get_option('blog_charset'), true);
	flush();
		
	$wpaq_data = mysql_query("SELECT option_value FROM $wpdb->options WHERE option_name = 'rmnlQuicktagSettings'");
	$wpaq_data = mysql_result($wpaq_data, 0);
	echo $wpaq_data;
	flush();
}

/**
 * import options in table _options
 *
 * @package AddQuicktag
 */
function wpaq_import() {
	
	if ( !current_user_can('manage_options') )
		wp_die( __('Options not update - you don&lsquo;t have the privilidges to do this!', 'secure_wp') );

	//cross check the given referer
	check_admin_referer('rmnl_nonce');

	// check file extension
	$str_file_name = $_FILES['datei']['name'];
	$str_file_ext  = explode(".", $str_file_name);

	if ($str_file_ext[1] != 'wpaq') {
		$addreferer = 'notexist';
	} elseif (file_exists($_FILES['datei']['name'])) {
		$addreferer = 'exist';
	} else {
		// path for file
		$str_ziel = WP_CONTENT_DIR . '/' . $_FILES['datei']['name'];
		// transfer
		move_uploaded_file($_FILES['datei']['tmp_name'], $str_ziel);
		// access authorisation
		chmod($str_ziel, 0644);
		// SQL import
		ini_set('default_socket_timeout', 120);
		$import_file = file_get_contents($str_ziel);
		wpaq_reset();
		$import_file = unserialize($import_file);
		update_option('rmnlQuicktagSettings', $import_file);
		unlink($str_ziel);
		$addreferer = 'true';
	}

	$referer = str_replace('&update=true&update=true', '', $_POST['_wp_http_referer'] );
	wp_redirect($referer . '&update=' . $addreferer );
}

/**
 * options page in backend of WP
 *
 * @package AddQuicktag
 */
function wpaq_options_page() {
	global $wp_version;
	
	if ($_POST['wpaq']) {
		if ( current_user_can('edit_plugins') ) {
			check_admin_referer('rmnl_nonce');

			$buttons = array();
			for ($i = 0; $i < count($_POST['wpaq']['buttons']); $i++){
				$b = $_POST['wpaq']['buttons'][$i];
				if ($b['text'] != '' && $b['start'] != '') {
					$b['text']  = $b['text'];
					$b['title'] = $b['title'];
					$b['start'] = stripslashes($b['start']);
					$b['end']   = stripslashes($b['end']);
					$buttons[]  = $b;
				}
			}
			$_POST['wpaq']['buttons'] = $buttons;
			update_option('rmnlQuicktagSettings', $_POST['wpaq']);
			$message = '<br class="clear" /><div class="updated fade"><p><strong>' . __('Options saved.', FB_WPAQ_TEXTDOMAIN ) . '</strong></p></div>';

		} else {
			wp_die('<p>'.__('You do not have sufficient permissions to edit plugins for this blog.', FB_WPAQ_TEXTDOMAIN ).'</p>');
		}
	}

	// Uninstall options
	if ( ($_POST['action'] == 'uninstall') ) {
		if ( current_user_can('edit_plugins') ) {

			check_admin_referer('rmnl_nonce');
			wpaq_uninstall();
			$message_export = '<br class="clear" /><div class="updated fade"><p>';
			$message_export.= __('AddQuicktag options have been deleted!', FB_WPAQ_TEXTDOMAIN );
			$message_export.= '</p></div>';

		} else {
			wp_die('<p>'.__('You do not have sufficient permissions to edit plugins for this blog.', FB_WPAQ_TEXTDOMAIN ).'</p>');
		}
	}
	
	$string1 = __('Add or delete Quicktag buttons', FB_WPAQ_TEXTDOMAIN );
	$string2 = __('Fill in the fields below to add or edit the quicktags. Fields with * are required. To delete a tag simply empty all fields.', FB_WPAQ_TEXTDOMAIN );
	$field1  = __('Button Label*', FB_WPAQ_TEXTDOMAIN );
	$field2  = __('Title Attribute', FB_WPAQ_TEXTDOMAIN );
	$field3  = __('Start Tag(s)*', FB_WPAQ_TEXTDOMAIN );
	$field4  = __('End Tag(s)', FB_WPAQ_TEXTDOMAIN );
	$button1 = __('Update Options &raquo;', FB_WPAQ_TEXTDOMAIN );

	// Export strings
	$button2 = __('Export &raquo;', FB_WPAQ_TEXTDOMAIN );
	$export1 = __('Export/Import AddQuicktag buttons options', FB_WPAQ_TEXTDOMAIN );
	$export2 = __('You can save a .wpaq file with your options.', FB_WPAQ_TEXTDOMAIN );
	$export3 = __('Export', FB_WPAQ_TEXTDOMAIN );

	// Import strings
	$button3 = __('Upload file and import &raquo;', FB_WPAQ_TEXTDOMAIN );
	$import1 = __('Import', FB_WPAQ_TEXTDOMAIN );
	$import2 = __('Choose a Quicktag (<em>.wpaq</em>) file to upload, then click <em>Upload file and import</em>.', FB_WPAQ_TEXTDOMAIN );
	$import3 = __('Choose a file from your computer: ', FB_WPAQ_TEXTDOMAIN );

	// Uninstall strings
	$button4    = __('Uninstall Options &raquo;', FB_WPAQ_TEXTDOMAIN );
	$uninstall1 = __('Uninstall options', FB_WPAQ_TEXTDOMAIN );
	$uninstall2 = __('This button deletes all options of the WP-AddQuicktag plugin. <strong>Attention: </strong>You cannot undo this!', FB_WPAQ_TEXTDOMAIN );

	// Info
	$info0   = __('About the plugin', FB_WPAQ_TEXTDOMAIN );
	$info1   = __('Further information: Visit the <a href=\'http://bueltge.de/wp-addquicktags-de-plugin/120\'>plugin homepage</a> for further information or to grab the latest version of this plugin.', FB_WPAQ_TEXTDOMAIN );
	$info2   = __('You want to thank me? Visit my <a href=\'http://bueltge.de/wunschliste/\'>wishlist</a> or donate.', FB_WPAQ_TEXTDOMAIN );
	
	// message for import, after redirect
	if ( strpos($_SERVER['REQUEST_URI'], 'addquicktag.php') && $_GET['update'] && !$_POST['uninstall'] ) {
		$message_export = '<br class="clear" /><div class="updated fade"><p>';
		if ( $_GET['update'] == 'true' ) {
			$message_export .= __('AddQuicktag options imported!', FB_WPAQ_TEXTDOMAIN );
		} elseif( $_GET['update'] == 'exist' ) {
			$message_export .= __('File is exist!', FB_WPAQ_TEXTDOMAIN );
		} elseif( $_GET['update'] == 'notexist' ) {
			$message_export .= __('Invalid file extension!', FB_WPAQ_TEXTDOMAIN );
		}
		$message_export .= '</p></div>';
	}
	
	$o = get_option('rmnlQuicktagSettings');
	
	?>
	<div class="wrap">
		<h2><?php _e('WP-Quicktag Management', FB_WPAQ_TEXTDOMAIN ); ?></h2>
		<?php echo $message . $message_export; ?>
		<br class="clear" />
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
				<h3><?php echo $string1; ?></h3>
				<div class="inside">
					<br class="clear" />
					<form name="form1" method="post" action="">
						<?php wp_nonce_field('rmnl_nonce'); ?>
						<table summary="rmnl" class="widefat">
							<thead>
								<tr>
									<th scope="col"><?php echo $field1; ?></th>
									<th scope="col"><?php echo $field2; ?></th>
									<th scope="col"><?php echo $field3; ?></th>
									<th scope="col"><?php echo $field4; ?></th>
								</tr>
							</thead>
							<tbody>
	<?php
		for ($i = 0; $i < count($o['buttons']); $i++) {
			$class = ( ' class="alternate"' == $class ) ? '' : ' class="alternate"';
			$b          = $o['buttons'][$i];
			$b['text']  = htmlentities(stripslashes($b['text']), ENT_COMPAT, get_option('blog_charset'));
			$b['title'] = htmlentities(stripslashes($b['title']), ENT_COMPAT, get_option('blog_charset'));
			$b['start'] = htmlentities($b['start'], ENT_COMPAT, get_option('blog_charset'));
			$b['end']   = htmlentities($b['end'], ENT_COMPAT, get_option('blog_charset'));
			$nr         = $i + 1;
			echo '
					<tr valign="top"' . $class . '>
						<td><input type="text" name="wpaq[buttons][' . $i . '][text]" value="' . $b['text'] . '" style="width: 95%;" /></td>
						<td><input type="text" name="wpaq[buttons][' . $i . '][title]" value="' . $b['title'] . '" style="width: 95%;" /></td>
						<td><textarea class="code" name="wpaq[buttons][' . $i . '][start]" rows="2" cols="25" style="width: 95%;">' . $b['start'] . '</textarea></td>
						<td><textarea class="code" name="wpaq[buttons][' . $i . '][end]" rows="2" cols="25" style="width: 95%;">' . $b['end'] . '</textarea></td>
					</tr>
			';
		}
		?>
								<tr valign="top" class="alternate">
									<td><input type="text" name="wpaq[buttons][<?php echo $i; ?>][text]" value="" style="width: 95%;" /></td>
									<td><input type="text" name="wpaq[buttons][<?php echo $i; ?>][title]" value="" style="width: 95%;" /></td>
									<td><textarea class="code" name="wpaq[buttons][<?php echo $i; ?>][start]" rows="2" cols="25" style="width: 95%;"></textarea></td>
									<td><textarea class="code" name="wpaq[buttons][<?php echo $i; ?>][end]" rows="2" cols="25" style="width: 95%;"></textarea></td>
								</tr>
							</tbody>
						</table>
						<p><?php echo $string2; ?></p>
						<p class="submit">
							<input class="button button-primary" type="submit" name="Submit" value="<?php _e( $button1 ); ?>" />
						</p>
					</form>
		
				</div>
			</div>
		</div>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox closed">
				<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
				<h3><?php echo $export1; ?></h3>
				<div class="inside">
					
					<h4><?php echo $export3; ?></h4>
					<form name="form2" method="get" action="">
						<p><?php echo $export2; ?></p>
						<p id="submitbutton">
							<input class="button" type="submit" name="submit" value="<?php echo $button2; ?>" />
							<input type="hidden" name="export" value="true" />
						</p>
					</form>
					
					<h4><?php echo $import1; ?></h4>
					<form name="form3" enctype="multipart/form-data" method="post" action="admin-post.php">
						<?php wp_nonce_field('rmnl_nonce'); ?> 
						<p><?php echo $import2; ?></p>
						<p>
							<label for="datei_id"><?php echo $import3; ?></label>
							<input name="datei" id="datei_id" type="file" />
						</p>
						<p id="submitbutton">
							<input class="button" type="submit" name="Submit_import" value="<?php echo $button3; ?>" />
							<input type="hidden" name="action" value="wpaq_import" />
						</p>
					</form>
					
				</div>
			</div>
		</div>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox closed">
				<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
				<h3><?php echo $uninstall1; ?></h3>
				<div class="inside">
					
					<form name="form4" method="post" action="">
						<?php wp_nonce_field('rmnl_nonce'); ?>
						<p><?php echo $uninstall2; ?></p>
						<p id="submitbutton">
							<input class="button" type="submit" name="Submit_uninstall" value="<?php _e($button4); ?>" /> 
							<input type="hidden" name="action" value="uninstall" />
						</p>
					</form>
					
				</div>
			</div>
		</div>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox" >
				<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
				<h3><?php echo $info0; ?></h3>
				<div class="inside">
					<p>
					<span style="float: left;">
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="6069955">
						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypal.com/de_DE/i/scr/pixel.gif" width="1" height="1">
						</form>
					</span>
					<?php echo $info1; ?><br />&copy; Copyright 2007 - <?php _e( date("Y") ); ?> <a href="http://bueltge.de">Frank B&uuml;ltge</a> | <?php echo $info2; ?></p>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
		<!--
		<?php if ( version_compare( $wp_version, '2.7alpha', '<' ) ) { ?>
		jQuery('.postbox h3').prepend('<a class="togbox">+</a> ');
		<?php } ?>
		jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
		jQuery('.postbox .handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
		jQuery('.postbox.close-me').each(function() {
			jQuery(this).addClass("closed");
		});
		//-->
		</script>
		
	</div>
<?php
} //End function wpaq_options_page


// only for post.php, page.php, post-new.php, page-new.php, comment.php
if (strpos($_SERVER['REQUEST_URI'], 'post.php') || strpos($_SERVER['REQUEST_URI'], 'post-new.php') || strpos($_SERVER['REQUEST_URI'], 'page-new.php') || strpos($_SERVER['REQUEST_URI'], 'page.php') || strpos($_SERVER['REQUEST_URI'], 'comment.php')) {
	add_action('admin_footer', 'wpaq_addsome');
	
	/**
	 * add quicktags to editor
	 *
	 * @package AddQuicktag
	 */
	function wpaq_addsome() {
		$o = get_option('rmnlQuicktagSettings');
		if (count($o['buttons']) > 0) {
				?>
				<script type="text/javascript">
					//<![CDATA[
					if ( wpaqToolbar = document.getElementById("ed_toolbar") ) {
						<?php
						for ($i = 0; $i < count($o['buttons']); $i++) :
							$b     = $o['buttons'][$i];
							if ( version_compare(phpversion(), '5.0.0', '>=') )
								$text = html_entity_decode( stripslashes($b['text']), ENT_COMPAT, get_option('blog_charset') );
							else
								$text = wpaq_html_entity_decode_php4( stripslashes($b['text']) );
							$text = str_replace('"', '\"', $text);
							$id    = strtolower($text);
							$title = stripslashes($b['title']);
							if ($title == '')
								$title = strlen($text);
							$title = preg_replace('![\n\r]+!', "\n", $title);
							$title = str_replace("'", "\'", $title);
							$title = str_replace('"', '\"', $title);
							$start = preg_replace('![\n\r]+!', "\\n", $b['start']);
							$start = str_replace("'", "\'", $start);
							$start = str_replace('"', '\"', $start);
							$end   = preg_replace('![\n\r]+!', "\\n", $b['end']);
							$end   = str_replace("'", "\'", $end);
							$end   = str_replace('"', '\"', $end);
						?>
						var wpaqNr, wpaqBut;
						wpaqNr = edButtons.length;
						edButtons[wpaqNr] = new edButton("ed_"+wpaqNr, "<?php echo $text; ?>", "<?php echo $start; ?>", "<?php echo $end; ?>", "");
						var wpaqBut = wpaqToolbar.lastChild;
						while (wpaqBut.nodeType != 1) {
							wpaqBut = wpaqBut.previousSibling;
						}
						wpaqBut = wpaqBut.cloneNode(true);
						wpaqBut.id = "ed_"+wpaqNr;
						wpaqBut._idx = wpaqNr; //store our current index at element itself
						wpaqBut.value = "<?php echo $text; ?>";
						wpaqBut.title = "<?php echo $title; ?>";
						wpaqBut.onclick = function() {edInsertTag(edCanvas, this._idx); return false; }
						wpaqToolbar.appendChild(wpaqBut);
						<?php endfor; ?>
					}
					//]]>
				</script>
				<?php
		}
	} //End wpaq_addsome
} // End if


/**
 * code to utf-8 in PHP 4
 *
 * @package AddQuicktag
 */
function wpaq_code_to_utf8($num) {
	
	if ($num <= 0x7F) {
		return chr($num);
	} elseif ($num <= 0x7FF) {
		return chr(($num >> 0x06) + 0xC0) . chr(($num & 0x3F) + 128);
	} elseif ($num <= 0xFFFF) {
		return chr(($num >> 0x0C) + 0xE0) . chr((($num >> 0x06) & 0x3F) + 0x80) . chr(($num & 0x3F) + 0x80);
	} elseif ($num <= 0x1FFFFF) {
		return chr(($num >> 0x12) + 0xF0) . chr((($num >> 0x0C) & 0x3F) + 0x80) . chr((($num >> 0x06) & 0x3F) + 0x80) . chr(($num & 0x3F) + 0x80);
	}

	return '';
}


/**
 * html_entity_decode for PHP 4
 *
 * @package AddQuicktag
 */
function wpaq_html_entity_decode_php4($str) {
	$htmlentities = array (
		"&Aacute;" => chr(195).chr(129),
		"&aacute;" => chr(195).chr(161),
		"&Acirc;" => chr(195).chr(130),
		"&acirc;" => chr(195).chr(162),
		"&acute;" => chr(194).chr(180),
		"&AElig;" => chr(195).chr(134),
		"&aelig;" => chr(195).chr(166),
		"&Agrave;" => chr(195).chr(128),
		"&agrave;" => chr(195).chr(160),
		"&alefsym;" => chr(226).chr(132).chr(181),
		"&Alpha;" => chr(206).chr(145),
		"&alpha;" => chr(206).chr(177),
		"&amp;" => chr(38),
		"&and;" => chr(226).chr(136).chr(167),
		"&ang;" => chr(226).chr(136).chr(160),
		"&Aring;" => chr(195).chr(133),
		"&aring;" => chr(195).chr(165),
		"&asymp;" => chr(226).chr(137).chr(136),
		"&Atilde;" => chr(195).chr(131),
		"&atilde;" => chr(195).chr(163),
		"&Auml;" => chr(195).chr(132),
		"&auml;" => chr(195).chr(164),
		"&bdquo;" => chr(226).chr(128).chr(158),
		"&Beta;" => chr(206).chr(146),
		"&beta;" => chr(206).chr(178),
		"&brvbar;" => chr(194).chr(166),
		"&bull;" => chr(226).chr(128).chr(162),
		"&cap;" => chr(226).chr(136).chr(169),
		"&Ccedil;" => chr(195).chr(135),
		"&ccedil;" => chr(195).chr(167),
		"&cedil;" => chr(194).chr(184),
		"&cent;" => chr(194).chr(162),
		"&Chi;" => chr(206).chr(167),
		"&chi;" => chr(207).chr(135),
		"&circ;" => chr(203).chr(134),
		"&clubs;" => chr(226).chr(153).chr(163),
		"&cong;" => chr(226).chr(137).chr(133),
		"&copy;" => chr(194).chr(169),
		"&crarr;" => chr(226).chr(134).chr(181),
		"&cup;" => chr(226).chr(136).chr(170),
		"&curren;" => chr(194).chr(164),
		"&dagger;" => chr(226).chr(128).chr(160),
		"&Dagger;" => chr(226).chr(128).chr(161),
		"&darr;" => chr(226).chr(134).chr(147),
		"&dArr;" => chr(226).chr(135).chr(147),
		"&deg;" => chr(194).chr(176),
		"&Delta;" => chr(206).chr(148),
		"&delta;" => chr(206).chr(180),
		"&diams;" => chr(226).chr(153).chr(166),
		"&divide;" => chr(195).chr(183),
		"&Eacute;" => chr(195).chr(137),
		"&eacute;" => chr(195).chr(169),
		"&Ecirc;" => chr(195).chr(138),
		"&ecirc;" => chr(195).chr(170),
		"&Egrave;" => chr(195).chr(136),
		"&egrave;" => chr(195).chr(168),
		"&empty;" => chr(226).chr(136).chr(133),
		"&emsp;" => chr(226).chr(128).chr(131),
		"&ensp;" => chr(226).chr(128).chr(130),
		"&Epsilon;" => chr(206).chr(149),
		"&epsilon;" => chr(206).chr(181),
		"&equiv;" => chr(226).chr(137).chr(161),
		"&Eta;" => chr(206).chr(151),
		"&eta;" => chr(206).chr(183),
		"&ETH;" => chr(195).chr(144),
		"&eth;" => chr(195).chr(176),
		"&Euml;" => chr(195).chr(139),
		"&euml;" => chr(195).chr(171),
		"&euro;" => chr(226).chr(130).chr(172),
		"&exist;" => chr(226).chr(136).chr(131),
		"&fnof;" => chr(198).chr(146),
		"&forall;" => chr(226).chr(136).chr(128),
		"&frac12;" => chr(194).chr(189),
		"&frac14;" => chr(194).chr(188),
		"&frac34;" => chr(194).chr(190),
		"&frasl;" => chr(226).chr(129).chr(132),
		"&Gamma;" => chr(206).chr(147),
		"&gamma;" => chr(206).chr(179),
		"&ge;" => chr(226).chr(137).chr(165),
		"&harr;" => chr(226).chr(134).chr(148),
		"&hArr;" => chr(226).chr(135).chr(148),
		"&hearts;" => chr(226).chr(153).chr(165),
		"&hellip;" => chr(226).chr(128).chr(166),
		"&Iacute;" => chr(195).chr(141),
		"&iacute;" => chr(195).chr(173),
		"&Icirc;" => chr(195).chr(142),
		"&icirc;" => chr(195).chr(174),
		"&iexcl;" => chr(194).chr(161),
		"&Igrave;" => chr(195).chr(140),
		"&igrave;" => chr(195).chr(172),
		"&image;" => chr(226).chr(132).chr(145),
		"&infin;" => chr(226).chr(136).chr(158),
		"&int;" => chr(226).chr(136).chr(171),
		"&Iota;" => chr(206).chr(153),
		"&iota;" => chr(206).chr(185),
		"&iquest;" => chr(194).chr(191),
		"&isin;" => chr(226).chr(136).chr(136),
		"&Iuml;" => chr(195).chr(143),
		"&iuml;" => chr(195).chr(175),
		"&Kappa;" => chr(206).chr(154),
		"&kappa;" => chr(206).chr(186),
		"&Lambda;" => chr(206).chr(155),
		"&lambda;" => chr(206).chr(187),
		"&lang;" => chr(226).chr(140).chr(169),
		"&laquo;" => chr(194).chr(171),
		"&larr;" => chr(226).chr(134).chr(144),
		"&lArr;" => chr(226).chr(135).chr(144),
		"&lceil;" => chr(226).chr(140).chr(136),
		"&ldquo;" => chr(226).chr(128).chr(156),
		"&le;" => chr(226).chr(137).chr(164),
		"&lfloor;" => chr(226).chr(140).chr(138),
		"&lowast;" => chr(226).chr(136).chr(151),
		"&loz;" => chr(226).chr(151).chr(138),
		"&lrm;" => chr(226).chr(128).chr(142),
		"&lsaquo;" => chr(226).chr(128).chr(185),
		"&lsquo;" => chr(226).chr(128).chr(152),
		"&macr;" => chr(194).chr(175),
		"&mdash;" => chr(226).chr(128).chr(148),
		"&micro;" => chr(194).chr(181),
		"&middot;" => chr(194).chr(183),
		"&minus;" => chr(226).chr(136).chr(146),
		"&Mu;" => chr(206).chr(156),
		"&mu;" => chr(206).chr(188),
		"&nabla;" => chr(226).chr(136).chr(135),
		"&nbsp;" => chr(194).chr(160),
		"&ndash;" => chr(226).chr(128).chr(147),
		"&ne;" => chr(226).chr(137).chr(160),
		"&ni;" => chr(226).chr(136).chr(139),
		"&not;" => chr(194).chr(172),
		"&notin;" => chr(226).chr(136).chr(137),
		"&nsub;" => chr(226).chr(138).chr(132),
		"&Ntilde;" => chr(195).chr(145),
		"&ntilde;" => chr(195).chr(177),
		"&Nu;" => chr(206).chr(157),
		"&nu;" => chr(206).chr(189),
		"&Oacute;" => chr(195).chr(147),
		"&oacute;" => chr(195).chr(179),
		"&Ocirc;" => chr(195).chr(148),
		"&ocirc;" => chr(195).chr(180),
		"&OElig;" => chr(197).chr(146),
		"&oelig;" => chr(197).chr(147),
		"&Ograve;" => chr(195).chr(146),
		"&ograve;" => chr(195).chr(178),
		"&oline;" => chr(226).chr(128).chr(190),
		"&Omega;" => chr(206).chr(169),
		"&omega;" => chr(207).chr(137),
		"&Omicron;" => chr(206).chr(159),
		"&omicron;" => chr(206).chr(191),
		"&oplus;" => chr(226).chr(138).chr(149),
		"&or;" => chr(226).chr(136).chr(168),
		"&ordf;" => chr(194).chr(170),
		"&ordm;" => chr(194).chr(186),
		"&Oslash;" => chr(195).chr(152),
		"&oslash;" => chr(195).chr(184),
		"&Otilde;" => chr(195).chr(149),
		"&otilde;" => chr(195).chr(181),
		"&otimes;" => chr(226).chr(138).chr(151),
		"&Ouml;" => chr(195).chr(150),
		"&ouml;" => chr(195).chr(182),
		"&para;" => chr(194).chr(182),
		"&part;" => chr(226).chr(136).chr(130),
		"&permil;" => chr(226).chr(128).chr(176),
		"&perp;" => chr(226).chr(138).chr(165),
		"&Phi;" => chr(206).chr(166),
		"&phi;" => chr(207).chr(134),
		"&Pi;" => chr(206).chr(160),
		"&pi;" => chr(207).chr(128),
		"&piv;" => chr(207).chr(150),
		"&plusmn;" => chr(194).chr(177),
		"&pound;" => chr(194).chr(163),
		"&prime;" => chr(226).chr(128).chr(178),
		"&Prime;" => chr(226).chr(128).chr(179),
		"&prod;" => chr(226).chr(136).chr(143),
		"&prop;" => chr(226).chr(136).chr(157),
		"&Psi;" => chr(206).chr(168),
		"&psi;" => chr(207).chr(136),
		"&radic;" => chr(226).chr(136).chr(154),
		"&rang;" => chr(226).chr(140).chr(170),
		"&raquo;" => chr(194).chr(187),
		"&rarr;" => chr(226).chr(134).chr(146),
		"&rArr;" => chr(226).chr(135).chr(146),
		"&rceil;" => chr(226).chr(140).chr(137),
		"&rdquo;" => chr(226).chr(128).chr(157),
		"&real;" => chr(226).chr(132).chr(156),
		"&reg;" => chr(194).chr(174),
		"&rfloor;" => chr(226).chr(140).chr(139),
		"&Rho;" => chr(206).chr(161),
		"&rho;" => chr(207).chr(129),
		"&rlm;" => chr(226).chr(128).chr(143),
		"&rsaquo;" => chr(226).chr(128).chr(186),
		"&rsquo;" => chr(226).chr(128).chr(153),
		"&sbquo;" => chr(226).chr(128).chr(154),
		"&Scaron;" => chr(197).chr(160),
		"&scaron;" => chr(197).chr(161),
		"&sdot;" => chr(226).chr(139).chr(133),
		"&sect;" => chr(194).chr(167),
		"&shy;" => chr(194).chr(173),
		"&Sigma;" => chr(206).chr(163),
		"&sigma;" => chr(207).chr(131),
		"&sigmaf;" => chr(207).chr(130),
		"&sim;" => chr(226).chr(136).chr(188),
		"&spades;" => chr(226).chr(153).chr(160),
		"&sub;" => chr(226).chr(138).chr(130),
		"&sube;" => chr(226).chr(138).chr(134),
		"&sum;" => chr(226).chr(136).chr(145),
		"&sup1;" => chr(194).chr(185),
		"&sup2;" => chr(194).chr(178),
		"&sup3;" => chr(194).chr(179),
		"&sup;" => chr(226).chr(138).chr(131),
		"&supe;" => chr(226).chr(138).chr(135),
		"&szlig;" => chr(195).chr(159),
		"&Tau;" => chr(206).chr(164),
		"&tau;" => chr(207).chr(132),
		"&there4;" => chr(226).chr(136).chr(180),
		"&Theta;" => chr(206).chr(152),
		"&theta;" => chr(206).chr(184),
		"&thetasym;" => chr(207).chr(145),
		"&thinsp;" => chr(226).chr(128).chr(137),
		"&THORN;" => chr(195).chr(158),
		"&thorn;" => chr(195).chr(190),
		"&tilde;" => chr(203).chr(156),
		"&times;" => chr(195).chr(151),
		"&trade;" => chr(226).chr(132).chr(162),
		"&Uacute;" => chr(195).chr(154),
		"&uacute;" => chr(195).chr(186),
		"&uarr;" => chr(226).chr(134).chr(145),
		"&uArr;" => chr(226).chr(135).chr(145),
		"&Ucirc;" => chr(195).chr(155),
		"&ucirc;" => chr(195).chr(187),
		"&Ugrave;" => chr(195).chr(153),
		"&ugrave;" => chr(195).chr(185),
		"&uml;" => chr(194).chr(168),
		"&upsih;" => chr(207).chr(146),
		"&Upsilon;" => chr(206).chr(165),
		"&upsilon;" => chr(207).chr(133),
		"&Uuml;" => chr(195).chr(156),
		"&uuml;" => chr(195).chr(188),
		"&weierp;" => chr(226).chr(132).chr(152),
		"&Xi;" => chr(206).chr(158),
		"&xi;" => chr(206).chr(190),
		"&Yacute;" => chr(195).chr(157),
		"&yacute;" => chr(195).chr(189),
		"&yen;" => chr(194).chr(165),
		"&yuml;" => chr(195).chr(191),
		"&Yuml;" => chr(197).chr(184),
		"&Zeta;" => chr(206).chr(150),
		"&zeta;" => chr(206).chr(182),
		"&zwj;" => chr(226).chr(128).chr(141),
		"&zwnj;" => chr(226).chr(128).chr(140),
		"&gt;" => ">",
		"&lt;" => "<"
	);

	$return = strtr($str, $htmlentities);
	$return = preg_replace("~&#x([0-9a-f]+);~ei", "wpaq_code_to_utf8(hexdec(\\1))", $return);
	$return = preg_replace("~&#([0-9]+);~e", "wpaq_code_to_utf8(\\1)", $return);

	return $return;
}


/**
 * hook in WP
 *
 * @package AddQuicktag
 */
if ( function_exists('register_activation_hook') )
	register_activation_hook(__FILE__, 'wpaq_install');
if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__, 'wpaq_uninstall');
if ( is_admin() ) {
	add_action('init', 'wpaq_textdomain');
	add_action('admin_menu', 'wpaq_add_settings_page');
	add_action('in_admin_footer', 'wpaq_admin_footer');
	add_action('admin_post_wpaq_import', 'wpaq_import' );
}


/**
 * Add action link(s) to plugins page
 * Thanks Dion Hulse -- http://dd32.id.au/wordpress-plugins/?configure-link
 *
 * @package AddQuicktag
 */
function wpaq_filter_plugin_actions($links, $file){
	static $this_plugin;

	if( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=addquicktag/addquicktag.php">' . __('Settings') . '</a>';
		$links = array_merge( array($settings_link), $links); // before other links
	}
	return $links;
}


/**
 * @version WP 2.7
 * Add action link(s) to plugins page
 *
 * @package Secure WordPress
 *
 * @param $links, $file
 * @return $links
 */
function wpaq_filter_plugin_actions_new($links, $file) {
	
	/* create link */
	if ( $file == FB_WPAQ_BASENAME ) {
		array_unshift(
			$links,
			sprintf( '<a href="options-general.php?page=%s">%s</a>', FB_WPAQ_BASENAME, __('Settings') )
		);
	}
	
	return $links;
}


/**
 * Images/ Icons in base64-encoding
 * @use function wpag_get_resource_url() for display
 *
 * @package AddQuicktag
 */
if( isset($_GET['resource']) && !empty($_GET['resource'])) {
	# base64 encoding performed by base64img.php from http://php.holtsmark.no
	$resources = array(
		'addquicktag.gif' =>
		'R0lGODlhCwAJALMPAPL19Y2cnLzNzZempsXV1VpfX6WysrS/v5'.
		'+trXmDg9Xh4drr66W5uay6urnHx////yH5BAEAAA8ALAAAAAAL'.
		'AAkAAARA8D0gmBMESMUIK0XAVNzQOE6QCIJhIMOANMRCHG+MuI'.
		'5yG4PAzjDyORqyxKwh8AlUAEUiQVswqBINIHEIHCSPCAA7'.
		'');
	
	if(array_key_exists($_GET['resource'], $resources)) {

		$content = base64_decode($resources[ $_GET['resource'] ]);

		$lastMod = filemtime(__FILE__);
		$client = ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false );
		// Checking if the client is validating his cache and if it is current.
		if (isset($client) && (strtotime($client) == $lastMod)) {
			// Client's cache IS current, so we just respond '304 Not Modified'.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 304);
			exit;
		} else {
			// Image not cached or cache outdated, we respond '200 OK' and output the image.
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', $lastMod).' GMT', true, 200);
			header('Content-Length: '.strlen($content));
			header('Content-Type: image/' . substr(strrchr($_GET['resource'], '.'), 1) );
			echo $content;
			exit;
		}
	}
}


/**
 * Display Images/ Icons in base64-encoding
 * @return $resourceID
 *
 * @package AddQuicktag
 */
function wpag_get_resource_url($resourceID) {
	
	return trailingslashit( get_bloginfo('url') ) . '?resource=' . $resourceID;
}


/**
 * settings in plugin-admin-page
 *
 * @package AddQuicktag
 */
function wpaq_add_settings_page() {
	global $wp_version;
	
	if ( function_exists('add_options_page') && current_user_can('manage_options') ) {
		$plugin = plugin_basename(__FILE__);
		$menutitle = '';
		if ( version_compare( $wp_version, '2.6.999', '>' ) ) {
			$menutitle = '<img src="' . wpag_get_resource_url('addquicktag.gif') . '" alt="" />' . ' ';
		}
		$menutitle .= __('AddQuicktag', FB_WPAQ_TEXTDOMAIN );

		add_options_page( __('WP-Quicktag &ndash; AddQuicktag', FB_WPAQ_TEXTDOMAIN ), $menutitle, 9, $plugin, 'wpaq_options_page');
		
		if ( version_compare( $wp_version, '2.7alpha', '<' ) ) {
			add_filter('plugin_action_links', 'wpaq_filter_plugin_actions', 10, 2);
		} else {
			add_filter( 'plugin_action_links_' . $plugin, 'wpaq_filter_plugin_actions_new', 10, 2 );
			if ( version_compare( $wp_version, '2.8alpha', '>' ) )
				add_filter( 'plugin_row_meta', 'wpaq_filter_plugin_actions_new', 10, 2 );
		}
	}
}


/**
 * credit in wp-footer
 *
 * @package AddQuicktag
 */
function wpaq_admin_footer() {
	if( basename($_SERVER['REQUEST_URI']) == 'addquicktag.php') {
		$plugin_data = get_plugin_data( __FILE__ );
		printf('%1$s plugin | ' . __('Version') . ' %2$s | ' . __('Author') . ' %3$s<br />', $plugin_data['Title'], $plugin_data['Version'], $plugin_data['Author']);
	}
}
?>