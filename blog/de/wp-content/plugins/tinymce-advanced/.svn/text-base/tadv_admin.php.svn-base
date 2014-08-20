<?php

if ( !defined('ABSPATH') || !current_user_can('manage_options') )
	wp_die('Cheatin&#8217; uh?');

if ( isset( $_POST['tadv_uninstall'] ) ) {
	check_admin_referer( 'tadv-uninstall' );

	delete_option('tadv_options');
	delete_option('tadv_toolbars');
	delete_option('tadv_plugins');
	delete_option('tadv_btns1');
	delete_option('tadv_btns2');
	delete_option('tadv_btns3');
	delete_option('tadv_btns4');
	delete_option('tadv_allbtns');
?>
<div class="updated" style="margin-top:30px;">
<p><?php _e('All options have been removed from the database. You can', 'tadv'); ?> <a href="plugins.php"><?php _e('deactivate TinyMCE Advanced', 'tadv'); ?></a> <?php _e('or', 'tadv'); ?> <a href=""> <?php _e('reload this page', 'tadv'); ?></a> <?php _e('to reset them to the default values.', 'tadv'); ?></p>
</div>
<?php
return;
}

if ( ! isset($GLOBALS['wp_version']) || version_compare($GLOBALS['wp_version'], '2.8', '<') ) { // if less than 2.8 ?>
<div class="error" style="margin-top:30px;">
<p><?php _e('This plugin requires WordPress version 2.8 or newer. Please upgrade your WordPress installation or download an', 'tadv'); ?> <a href="http://wordpress.org/extend/plugins/tinymce-advanced/download/"><?php _e('older version of the plugin.', 'tadv'); ?></a></p>
</div>
<?php
return;
}

$update_tadv_options = false;
$imgpath = WP_PLUGIN_URL . '/tinymce-advanced/images/';

$tadv_toolbars = get_option('tadv_toolbars');
if ( ! is_array($tadv_toolbars) ) {
	@include_once( WP_PLUGIN_DIR . '/tinymce-advanced/tadv_defaults.php');
	$tadv_options = array( 'advlink' => 1, 'advimage' => 1, 'importcss' => 0, 'contextmenu' => 0, 'fix_autop' => 0 );
} else {
	$tadv_options = get_option('tadv_options');
	$tadv_toolbars['toolbar_1'] = isset($tadv_toolbars['toolbar_1']) ? (array) $tadv_toolbars['toolbar_1'] : array();
	$tadv_toolbars['toolbar_2'] = isset($tadv_toolbars['toolbar_2']) ? (array) $tadv_toolbars['toolbar_2'] : array();
	$tadv_toolbars['toolbar_3'] = isset($tadv_toolbars['toolbar_3']) ? (array) $tadv_toolbars['toolbar_3'] : array();
	$tadv_toolbars['toolbar_4'] = isset($tadv_toolbars['toolbar_4']) ? (array) $tadv_toolbars['toolbar_4'] : array();
}

if ( isset( $_POST['tadv-save'] ) ) {
	check_admin_referer( 'tadv-save-buttons-order' );

	$tb1 = $tb2 = $tb3 = $tb4 = $btns = array();
	parse_str( $_POST['toolbar_1order'], $tb1 );
	parse_str( $_POST['toolbar_2order'], $tb2 );
	parse_str( $_POST['toolbar_3order'], $tb3 );
	parse_str( $_POST['toolbar_4order'], $tb4 );

	$tadv_toolbars['toolbar_1'] = (array) $tb1['pre'];
	$tadv_toolbars['toolbar_2'] = (array) $tb2['pre'];
	$tadv_toolbars['toolbar_3'] = (array) $tb3['pre'];
	$tadv_toolbars['toolbar_4'] = (array) $tb4['pre'];

	update_option( 'tadv_toolbars', $tadv_toolbars );

	$tadv_options['advlink'] = $_POST['advlink'] ? 1 : 0;
	$tadv_options['advimage'] = $_POST['advimage'] ? 1 : 0;
	$tadv_options['contextmenu'] = $_POST['contextmenu'] ? 1 : 0;
	$tadv_options['importcss'] = $_POST['importcss'] ? 1 : 0;
	$tadv_options['fix_autop'] = $_POST['fix_autop'] ? 1 : 0;
	$update_tadv_options = true;
}

$hidden_row = 0;
$i = 0;
foreach ( $tadv_toolbars as $toolbar ) {
	$l = false;
	$i++;

	if ( empty($toolbar) ) {
		$btns["toolbar_$i"] = array();
		continue;
	}

	foreach( $toolbar as $k => $v ) {
		if ( strpos($v, 'separator') !== false ) $toolbar[$k] = 'separator';
		if ( 'layer' == $v ) $l = $k;
		if ( empty($v) ) unset($toolbar[$k]);
	}
	if ( $l ) array_splice( $toolbar, $l, 1, array('insertlayer', 'moveforward', 'movebackward', 'absolute') );

	$btns["toolbar_$i"] = $toolbar;
}
extract($btns);

if ( empty($toolbar_1) && empty($toolbar_2) && empty($toolbar_3) && empty($toolbar_4) ) {
	?><div class="error" id="message"><p><?php _e('All toolbars are empty! Default buttons loaded.', 'tadv'); ?></p></div><?php

	@include_once( WP_PLUGIN_DIR . '/tinymce-advanced/tadv_defaults.php');
	$allbtns = array_merge( $tadv_btns1, $tadv_btns2, $tadv_btns3, $tadv_btns4 );
} else {
	$allbtns = array_merge( $toolbar_1, $toolbar_2, $toolbar_3, $toolbar_4 );
}
	if ( in_array('advhr', $allbtns) ) $plugins[] = 'advhr';
	if ( in_array('insertlayer', $allbtns) ) $plugins[] = 'layer';
	if ( in_array('visualchars', $allbtns) ) $plugins[] = 'visualchars';

	if ( in_array('nonbreaking', $allbtns) ) $plugins[] = 'nonbreaking';
	if ( in_array('styleprops', $allbtns) ) $plugins[] = 'style';
	if ( in_array('emotions', $allbtns) ) $plugins[] = 'emotions';
	if ( in_array('insertdate', $allbtns) ||
		in_array('inserttime', $allbtns) ) $plugins[] = 'insertdatetime';

	if ( in_array('tablecontrols', $allbtns) ) $plugins[] = 'table';
	if ( in_array('print', $allbtns) ) $plugins[] = 'print';
	if ( in_array('iespell', $allbtns) ) $plugins[] = 'iespell';
	if ( in_array('search', $allbtns) ||
		in_array('replace', $allbtns) ) $plugins[] = 'searchreplace';

	if ( in_array('cite', $allbtns) ||
		in_array('ins', $allbtns) ||
		in_array('del', $allbtns) ||
		in_array('abbr', $allbtns) ||
		in_array('acronym', $allbtns) ||
		in_array('attribs', $allbtns) ) $plugins[] = 'xhtmlxtras';

	if ( $tadv_options['advlink'] == '1' ) $plugins[] = 'advlink';
	if ( $tadv_options['advimage'] == '1' ) $plugins[] = 'advimage';
	if ( $tadv_options['contextmenu'] == '1' ) $plugins[] = 'contextmenu';

$buttons = array( 'Kitchen Sink' => 'wp_adv', 'Quote' => 'blockquote', 'Bold' => 'bold', 'Italic' => 'italic', 'Strikethrough' => 'strikethrough', 'Underline' => 'underline', 'Bullet List' => 'bullist', 'Numbered List' => 'numlist', 'Outdent' => 'outdent', 'Indent' => 'indent', 'Allign Left' => 'justifyleft', 'Center' => 'justifycenter', 'Alligh Right' => 'justifyright', 'Justify' => 'justifyfull', 'Cut' => 'cut', 'Copy' => 'copy', 'Paste' => 'paste', 'Link' => 'link', 'Remove Link' => 'unlink', 'Insert Image' => 'image', 'More Tag' => 'wp_more', 'Split Page' => 'wp_page', 'Search' => 'search', 'Replace' => 'replace', '<!--fontselect-->' => 'fontselect', '<!--fontsizeselect-->' => 'fontsizeselect', 'Help' => 'wp_help', 'Full Screen' => 'fullscreen', '<!--styleselect-->' => 'styleselect', '<!--formatselect-->' => 'formatselect', 'Text Color' => 'forecolor', 'Back Color' => 'backcolor', 'Paste as Text' => 'pastetext', 'Paste from Word' => 'pasteword', 'Remove Format' => 'removeformat', 'Clean Code' => 'cleanup', 'Check Spelling' => 'spellchecker', 'Character Map' => 'charmap', 'Print' => 'print', 'Undo' => 'undo', 'Redo' => 'redo', 'Table' => 'tablecontrols', 'Citation' => 'cite', 'Inserted Text' => 'ins', 'Deleted Text' => 'del', 'Abbreviation' => 'abbr', 'Acronym' => 'acronym', 'XHTML Attribs' => 'attribs', 'Layer' => 'layer', 'Advanced HR' => 'advhr', 'View HTML' => 'code', 'Hidden Chars' => 'visualchars', 'NB Space' => 'nonbreaking', 'Sub' => 'sub', 'Sup' => 'sup', 'Visual Aids' => 'visualaid', 'Insert Date' => 'insertdate', 'Insert Time' => 'inserttime', 'Anchor' => 'anchor', 'Style' => 'styleprops', 'Smilies' => 'emotions', 'Insert Movie' => 'media', 'IE Spell' => 'iespell' );

if ( function_exists('moxiecode_plugins_url') ) {
	if ( moxiecode_plugins_url('imagemanager') ) $buttons['MCFileManager'] = 'insertimage';
	if ( moxiecode_plugins_url('filemanager') ) $buttons['MCImageManager'] = 'insertfile';
}

$tadv_allbtns = array_values($buttons);
$tadv_allbtns[] = 'separator';
$tadv_allbtns[] = '|';

if ( get_option('tadv_plugins') != $plugins ) update_option( 'tadv_plugins', $plugins );
if ( get_option('tadv_btns1') != $toolbar_1 ) update_option( 'tadv_btns1', $toolbar_1 );
if ( get_option('tadv_btns2') != $toolbar_2 ) update_option( 'tadv_btns2', $toolbar_2 );
if ( get_option('tadv_btns3') != $toolbar_3 ) update_option( 'tadv_btns3', $toolbar_3 );
if ( get_option('tadv_btns4') != $toolbar_4 ) update_option( 'tadv_btns4', $toolbar_4 );
if ( get_option('tadv_allbtns') != $tadv_allbtns ) update_option( 'tadv_allbtns', $tadv_allbtns );

for ( $i = 1; $i < 21; $i++ )
	$buttons["s$i"] = "separator$i";

if ( isset($_POST['tadv-save']) ) {	?>
	<div class="updated" id="message"><p><?php _e('Options saved', 'tadv'); ?></p></div>
<?php } ?>

<div class="wrap" id="contain">

	<h2><?php _e('TinyMCE Buttons Arrangement', 'tadv'); ?></h2>

	<form id="tadvadmin" method="post" action="" onsubmit="">
	<p><?php _e('Drag and drop buttons onto the toolbars below.', 'tadv'); ?></p>

	<div id="tadvzones">
		<input id="toolbar_1order" name="toolbar_1order" value="" type="hidden" />
		<input id="toolbar_2order" name="toolbar_2order" value="" type="hidden" />
		<input id="toolbar_3order" name="toolbar_3order" value="" type="hidden" />
		<input id="toolbar_4order" name="toolbar_4order" value="" type="hidden" />
		<input name="tadv-save" value="1" type="hidden" />

	<div class="tadvdropzone">
	<ul style="position: relative;" id="toolbar_1" class="container">
<?php
if ( is_array($tadv_toolbars['toolbar_1']) ) {
	$tb1 = array();
	foreach( $tadv_toolbars['toolbar_1'] as $k ) {
		$t = array_intersect( $buttons, (array) $k );
		$tb1 += $t;
	}

	foreach( $tb1 as $name => $btn ) {
		if ( strpos( $btn, 'separator' ) !== false ) { ?>

	<li class="separator" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"> </div></li>
<?php	} else { ?>

	<li class="tadvmodule" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"><img src="<?php echo $imgpath . $btn . '.gif'; ?>" title="<?php echo $name; ?>" />
	<span class="descr"> <?php echo $name; ?></span></div></li>
<?php   }
	}
	$buttons = array_diff( $buttons, $tb1 );
} ?>
	</ul></div>
	<br class="clear" />

	<div class="tadvdropzone">
	<ul style="position: relative;" id="toolbar_2" class="container">
<?php
if ( is_array($tadv_toolbars['toolbar_2']) ) {
	$tb2 = array();
	foreach( $tadv_toolbars['toolbar_2'] as $k ) {
		$t = array_intersect( $buttons, (array) $k );
		$tb2 = $tb2 + $t;
	}
	foreach( $tb2 as $name => $btn ) {
		if ( strpos( $btn, 'separator' ) !== false ) { ?>

	<li class="separator" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"> </div></li>
<?php	} else { ?>

	<li class="tadvmodule" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"><img src="<?php echo $imgpath . $btn . '.gif'; ?>" title="<?php echo $name; ?>" />
	<span class="descr"> <?php echo $name; ?></span></div></li>
<?php   }
	}
	$buttons = array_diff( $buttons, $tb2 );
} ?>
	</ul></div>
	<br class="clear" />

	<div class="tadvdropzone">
	<ul style="position: relative;" id="toolbar_3" class="container">
<?php
if ( is_array($tadv_toolbars['toolbar_3']) ) {
	$tb3 = array();
	foreach( $tadv_toolbars['toolbar_3'] as $k ) {
		$t = array_intersect( $buttons, (array) $k );
		$tb3 += $t;
	}
	foreach( $tb3 as $name => $btn ) {
		if ( strpos( $btn, 'separator' ) !== false ) { ?>

	<li class="separator" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"> </div></li>
<?php	} else { ?>

	<li class="tadvmodule" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"><img src="<?php echo $imgpath . $btn . '.gif'; ?>" title="<?php echo $name; ?>" />
	<span class="descr"> <?php echo $name; ?></span></div></li>
<?php   }
	}
	$buttons = array_diff( $buttons, $tb3 );
} ?>
	</ul></div>
	<br class="clear" />

	<div class="tadvdropzone">
	<ul style="position: relative;" id="toolbar_4" class="container">
<?php
if ( is_array($tadv_toolbars['toolbar_4']) ) {
	$tb4 = array();
	foreach( $tadv_toolbars['toolbar_4'] as $k ) {
		$t = array_intersect( $buttons, (array) $k );
		$tb4 += $t;
	}
	foreach( $tb4 as $name => $btn ) {
		if ( strpos( $btn, 'separator' ) !== false ) { ?>

	<li class="separator" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"> </div></li>
<?php	} else { ?>

	<li class="tadvmodule" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"><img src="<?php echo $imgpath . $btn . '.gif'; ?>" title="<?php echo $name; ?>" />
	<span class="descr"> <?php echo $name; ?></span></div></li>
<?php   }
	}
	$buttons = array_diff( $buttons, $tb4 );
} ?>
	</ul></div>
	<br class="clear" />
	</div>

	<div id="tadvWarnmsg">&nbsp;
	<span id="too_long" style="display:none;"><?php _e('Adding too many buttons will make the toolbar too long and will not display correctly in TinyMCE!', 'tadv'); ?></span>
	</div>

	<div id="tadvpalettediv">
	<ul style="position: relative;" id="tadvpalette">
<?php
if ( is_array($buttons) ) {
	foreach( $buttons as $name => $btn ) {
		if ( strpos( $btn, 'separator' ) !== false ) { ?>

	<li class="separator" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"> </div></li>
<?php	} else { ?>

	<li class="tadvmodule" id="pre_<?php echo $btn; ?>">
	<div class="tadvitem"><img src="<?php echo $imgpath . $btn . '.gif'; ?>" title="<?php echo $name; ?>" />
	<span class="descr"> <?php echo $name; ?></span></div></li>
<?php   }
	}
} ?>
	</ul>
	</div>

	<table class="clear" style="margin:10px 0"><tr><td style="padding:2px 12px 8px;">
		Also enable:
		<label for="advlink" class="tadv-box"><?php _e('Advanced Link', 'tadv'); ?> &nbsp;
		<input type="checkbox" class="tadv-chk"  name="advlink" id="advlink" <?php if ( $tadv_options['advlink'] == '1' ) echo ' checked="checked"'; ?> /></label> &bull;

		<label for="advimage" class="tadv-box"><?php _e('Advanced Image', 'tadv'); ?> &nbsp;
		<input type="checkbox" class="tadv-chk"  name="advimage" id="advimage" <?php if ( $tadv_options['advimage'] == '1' ) echo ' checked="checked"'; ?> /></label> &bull;
		<label for="contextmenu" class="tadv-box"><?php _e('Context Menu', 'tadv'); ?> &nbsp;

		<input type="checkbox" class="tadv-chk"  name="contextmenu" id="contextmenu" <?php if ( $tadv_options['contextmenu'] == '1' ) echo ' checked="checked"'; ?> /></label>
		<?php _e('(to show the context menu in Firefox and use the spellchecker, hold down the Ctrl key).', 'tadv'); ?>
		</td></tr>

		<tr><td style="border:1px solid #CD0000;padding:2px 12px 8px;">
		<p style="font-weight:bold;color:#CD0000;"><?php _e('Advanced', 'tadv'); ?></p><?php

		if ( function_exists('mceopt_admin') )
			echo '<p><a href="' . admin_url('options-general.php?page=tinymce-options/tinymce-options.php') . '">' . __('Manage TinyMCE Options', 'tadv') . '</a></p>'; ?>

		<p><label for="importcss" class="tadv-box"><?php _e('Import the current theme CSS classes', 'tadv'); ?> &nbsp;
		<input type="checkbox" class="tadv-chk"  name="importcss" id="importcss" <?php if ( $tadv_options['importcss'] == '1' ) echo ' checked="checked"'; ?> /></label></p>
		<p style="font-size:11px;"><?php _e('Custom CSS styles can be added in', 'tadv'); ?> <a href="plugin-editor.php?file=tinymce-advanced/css/tadv-mce.css&amp;plugin=tinymce-advanced/tinymce-advanced.php"> <?php _e('/wp-content/plugins/tinymce-advanced/css/tadv-mce.css.', 'tadv'); ?></a> <?php _e('They will be imported and used in TinyMCE. Only CSS classes will be used, also <strong>div.my-class</strong> would not work, but <strong>.my-class</strong> will.', 'tadv'); ?></p>
		<p><label for="fix_autop" class="tadv-box"><?php _e('Stop removing the &lt;p&gt; and &lt;br /&gt; tags when saving and show them in the HTML editor', 'tadv'); ?> &nbsp;
		<input type="checkbox" class="tadv-chk"  name="fix_autop" id="fix_autop" <?php if ( $tadv_options['fix_autop'] == '1' ) echo ' checked="checked"'; ?> /></label></p>
		<p style="font-size:11px;"><?php _e('This will make it possible to use more advanced HTML without the back-end filtering affecting it much. It also preserves empty new lines in the editor by padding them with &lt;br /&gt; tags.', 'tadv'); ?></p>
		</td></tr>
<?php
	$mce_locale = ( '' == get_locale() ) ? 'en' : strtolower( substr(get_locale(), 0, 2) );
	if ( $mce_locale != 'en' ) {
		if ( ! @file_exists(WP_PLUGIN_DIR . '/tinymce-advanced/mce/advlink/langs/' . $mce_locale . '_dlg.js') ) { ?>
		<tr><td style="padding:2px 12px 8px;">
		<p style="font-weight:bold;"><?php _e('Language Settings', 'tadv'); ?></p>
		<p><?php _e('Your WordPress language is set to', 'tadv'); ?> <strong><?php echo get_locale(); ?></strong>. <?php _e('However there is no matching language installed for TinyMCE plugins. This plugin includes several translations: German, French, Italian, Spanish, Portuguese, Russian, Japanese and Chinese. More translations are available at the', 'tadv'); ?> <a href="http://services.moxiecode.com/i18n/"><?php _e('TinyMCE web site.', 'tadv'); ?></a></p>
		</td></tr>
<?php	}
	} // end mce_locale
?>
	</table>

<p>
	<?php wp_nonce_field( 'tadv-save-buttons-order' ); ?>
	<input class="button tadv_btn" type="button" class="tadv_btn" value="<?php _e('Remove Settings', 'tadv'); ?>" onclick="document.getElementById('tadv_uninst_div').style.display = 'block';" />
	<input class="button-primary tadv_btn" type="button" value="<?php _e('Save Changes', 'tadv'); ?>" onclick="tadvSortable.serialize();" />
</p>
</form>

<div id="tadvWarnmsg2">&nbsp;
	<span id="sink_err" style="display:none;"><?php _e('The Kitchen Sink button shows/hides the next toolbar row. It will not work at the current place.', 'tadv'); ?></span>
</div>

<div id="tadv_uninst_div" style="">
<form method="post" action="">
<?php wp_nonce_field('tadv-uninstall'); ?>
<div><?php _e('Remove all saved settings from the database?', 'tadv'); ?>
<input class="button tadv_btn" type="button" name="cancel" value="<?php _e('Cancel', 'tadv'); ?>" onclick="document.getElementById('tadv_uninst_div').style.display = 'none';" style="margin-left:20px" />
<input class="button tadv_btn" type="submit" name="tadv_uninstall" value="<?php _e('Continue', 'tadv'); ?>" /></div>
</form>
</div>
</div>

<?php
	if ( $update_tadv_options )
		update_option( 'tadv_options', $tadv_options );
