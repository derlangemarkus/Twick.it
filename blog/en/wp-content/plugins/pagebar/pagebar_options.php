<?php


if (!class_exists('PagebarOptions')) {
	class PagebarOptions {

    function PagebarOptions() {

			$page = add_action('admin_menu', array(&$this, 'adminmenu'));

			if (!empty($_POST ['pagebar2update'])) {

				$all_opts = array ("left", "center", "right", "pbText", "remove", "standard",
										 "current", "first", "last", "connect", "prev", "next",
										 "tooltipText", "tooltips", "pdisplay", "ndisplay",
										 "stylesheet", "cssFilename", "inherit");

				$additionalPostbarOpts = array("auto", "bef_loop", "aft_loop", "footer");
				$additionalCommentbarOpts = array("all", "where_all", "label_all");
				$additionalMultipagebarOpts = array("all", "label_all");

				$postbaroptions = (array_merge($all_opts, $additionalPostbarOpts));
				$commentbaroptions = (array_merge($all_opts, $additionalCommentbarOpts));
				$multipagebaroptions = (array_merge($all_opts, $additionalMultipagebarOpts));

				$pbOptionsPostbar = array();
				foreach ($postbaroptions as $param)
					$pbOptionsPostbar[$param] = (empty  ($_POST ["post_" . $param])) ?
														"" : addslashes ( $_POST ["post_" . $param] );

				$pbOptionsCommentbar = array();
				foreach ($commentbaroptions as $param)
					$pbOptionsCommentbar[$param] = (empty  ($_POST ["comment_" . $param])) ?
														"" : addslashes ( $_POST ["comment_" . $param] );

				$pbOptionsMultipagebar = array();
				foreach ($multipagebaroptions as $param)
					$pbOptionsMultipagebar[$param] = (empty  ($_POST ["multipage_" . $param])) ?
															"" : addslashes ( $_POST ["multipage_" . $param] );

				$text1 = update_option('postbar', $pbOptionsPostbar);
				$text2 = update_option('multipagebar', $pbOptionsMultipagebar);
				$text3 = update_option('commentbar', $pbOptionsCommentbar);

				$text = ($text1 || $text2 || $text3) ? __( 'Options', 'pagebar') : __( 'No options', 'pagebar');
				echo '<div id="message" class="updated fade"><p>' . $text . ' ' . __( 'updated', 'pagebar') . '</p></div>';

		} //if

	} //PagebarOptions()

	/* -------------------------------------------------------------------------- */
	function textinput($text, $var, $pbOptions, $prefix) {
		echo '<tr><th scope="row" valign="top"><label for ="' . $var . '">' . __($text, 'pagebar') . '</label></th>';
		echo  '<td><input type="text" name="' . $prefix.'_'.$var . '" value="' . $pbOptions[$var] . '"></td></tr>';
	}
	/* -------------------------------------------------------------------------- */
	function checkbox($text,$var,$pbOptions, $prefix, $onClick = '') {
		return '<label id="lbl_' . $var . '"><input type="checkbox" id="cb_' . $var . '" name="' . $prefix.'_'.$var . '"' .
		($onClick != '' ? ' onClick="' . $onClick .'" ' : '') .
		($pbOptions [$var] ? "checked" : '') . '>&nbsp;' . __($text, 'pagebar') . "</label><br/>\n";
	}
	/* -------------------------------------------------------------------------- */
	function radiobutton($name, $value, $text, $pbOptions, $prefix, $onClick = '') {
		return '<label><input type="radio" name="'. $prefix .'_'.$name.'" value="' . $value . '"' .
		($onClick != '' ? ' onClick="' . $onClick .'" ' : '') .
		 ($pbOptions[$name] == $value ? " checked " : '') .  '>&nbsp;' . __($text, 'pagebar') . "</label>\n";
	}
	/* -------------------------------------------------------------------------- */
	function pb_basicOptions($pbOptions, $prefix) {
	?>
		<tr>
			<?php
				$this->textinput ( 'Left', 'left', $pbOptions, $prefix);
				$this->textinput ( 'Center', 'center', $pbOptions, $prefix );
				$this->textinput ( 'Right', 'right', $pbOptions, $prefix );
				$this->textinput ( 'Leading text', 'pbText', $pbOptions, $prefix );
				$this->textinput ( 'Standard page', 'standard', $pbOptions, $prefix );
				$this->textinput ( 'Current Page', 'current', $pbOptions, $prefix );
				$this->textinput ( 'First page', 'first', $pbOptions, $prefix );
				$this->textinput ( 'Last page', 'last', $pbOptions, $prefix );
				$this->textinput ( 'Connector', 'connect', $pbOptions, $prefix );
			?>
		</tr>

		<tr>
			<th scope="row" valign="top"><?php echo __( 'Previous', 'pagebar' )?></th>
			<td>
				<input type="text" id="previous" name="<?php echo $prefix ?>_prev" value="<?php echo $pbOptions ["prev"]?>">
				<?php echo $this->radiobutton('pdisplay', 'auto', 'auto', $pbOptions, $prefix);     ?>&nbsp;&nbsp;
				<?php echo $this->radiobutton('pdisplay', 'always', 'always', $pbOptions, $prefix); ?>&nbsp;&nbsp;
				<?php echo $this->radiobutton('pdisplay', 'never', 'never', $pbOptions, $prefix);   ?>&nbsp;&nbsp;
			</td>
		</tr>

		<tr>
			<th scope="row" valign="top">
				<?php echo __( 'Next', 'pagebar' )?>:
			</th>
			<td>
				<input type="text" id="next" name="<?php echo $prefix ?>_next" value="<?php echo $pbOptions ["next"]?>">
				<?php echo $this->radiobutton('ndisplay', 'auto', 'auto', $pbOptions, $prefix);     ?>&nbsp;&nbsp;
				<?php echo $this->radiobutton('ndisplay', 'always', 'always', $pbOptions, $prefix); ?>&nbsp;&nbsp;
				<?php echo $this->radiobutton('ndisplay', 'never', 'never', $pbOptions, $prefix);   ?>&nbsp;&nbsp;
			</td>
		</tr>

		<tr>
			<th scope="row"><?php echo __( 'Tooltip text', 'pagebar' )?>:</th>
			<td>
				<input type="text" name="<?php echo $prefix ?>_tooltipText" value="<?php echo $pbOptions ["tooltipText"]?>">&nbsp;
				<?php echo $this->checkbox('Display', 'tooltips', $pbOptions, $prefix) ?>&nbsp;
			</td>
		</tr>
	<?php }  //pb_BasicOptions
	/* -------------------------------------------------------------------------- */
	function pb_stylesheetOptions($pbOptions, $prefix) {
	?>
		<tr>
			<th scope="row" valign="top"><?php echo __( 'Stylesheet', 'pagebar')?>:</th>
			<td>
				<label>
					<input onClick="cssSwitch();" type="radio" id="rdo_style"
					 name="<?php echo $prefix.'_'; ?>stylesheet" value="styleCss"
					 <?php
			if ($pbOptions ["stylesheet"] == "styleCss")
				echo " checked " ?>>
					 <?php echo __ ( 'style.css', 'pagebar')?>

				</label>
				<br />

				<input onClick="cssSwitch();" type="radio" id="rdo_own"
				 name="<?php echo $prefix.'_'; ?>stylesheet" value="own"
				 <?php
			if ($pbOptions ["stylesheet"] == "own")
				echo " checked "
				 ?>>

				<input type="text" id="edt_cssFile" name="<?php echo $prefix.'_'; ?>cssFilename" value="<?php echo $pbOptions ["cssFilename"]?>">
			</td>
		</tr>

	<?php }//stylesheetOptions()
	/* -------------------------------------------------------------------------- */
	function pb_submitButton($prefix) {
	?>
	<p class="submit"><input type="submit" name="pagebar2update" class="button-primary"
		value="<?php echo __( 'Update Options', 'pagebar' );?>" />&nbsp;&nbsp;<input
		type="button" name="cancel" value="<?php echo __( 'Cancel', 'pagebar' );?>"
		class="button" onclick="javascript:history.go(-1)" /></p>
	<?php } //pb_submitButton
	/* -------------------------------------------------------------------------- */
	function adminmenu() {
		global $pbOptions;
		if (function_exists('add_options_page'))
			$hook = add_options_page('Pagebar', 'Pagebar', 'manage_options', basename(__FILE__), array(&$this, 'pboptions'));

		//add contextual help
		if (function_exists('add_contextual_help')) {
		add_contextual_help(
			$hook,
			'<a href="http://www.elektroelch.de/hacks/wp/pagebar/" target="_blank">Manual</a>'
		); }

	}

	/* -------------------------------------------------------------------------- */
    function pb_load_jquery() {
		wp_enqueue_script('jquery-ui-tabs');
	}
	/* -------------------------------------------------------------------------- */

	function pboptions() {
		global $pbOptions;
	?>
	<style type="text/css">
		.ui-tabs {padding: .2em;}
		.ui-tabs-nav { padding: .2em .2em 0 .2em;  position: relative;  clear: both;}
		.ui-tabs-nav li { float: left;  margin: 0 .2em -1px 0; padding: 0; border: 1px solid #000; background-color: #ccc;}
		.ui-tabs-nav li a { display:block; text-decoration: none; padding: .5em 1em; }
		.ui-tabs-nav li.ui-tabs-selected {  padding-bottom: .1em; border-bottom: 0;  background-color: #fff;}
		.ui-tabs-panel { padding: 1em 1.4em;  display: block; border: 0; background: url(tab.png);}
		.ui-tabs-hide { display: none !important; }

		.tabs-nav {display: inline-block;}
		.tabs-nav .tabs-disabled {position: relative; filter: alpha(opacity=40); }
		.tabs-nav .tabs-disabled a span {_height: 19px; min-height: 19px; }
		#optiontabs {clear:all;}

	</style>

	<div class="wrap" id="top">
		<h2>
			<?php echo __( 'Pagebar' )?>
		</h2>

	 <script>
		$j=jQuery.noConflict();
		$j(document).ready(function(){
			$j("#optiontabs").tabs();
			js_comment();
			js_multipage();
		});
		</script>

	<form method="post" id="pagebar" action="<?php echo $_SERVER ['REQUEST_URI'];	?>">
	<?php settings_fields( 'pagebar-options' ); ?>

		<div id="optiontabs">
			<ul>
				<li><a href="#postbar"><span>Postbar</span></a></li>
				<li><a href="#multipagebar"><span>Multipagebar</span></a></li>
				<li><a href="#commentbar"><span>Commentbar</span></a></li>
			</ul>


			<div id="postbar"><br/>
				<p>
					<?php require ('pagebar_options_postbar.php'); ?>
				</p>
			</div>

			<div id="multipagebar" class="ui-tabs-hide"><br/>
				<p>
					<?php require ('pagebar_options_multipagebar.php'); ?>
				</p>
			</div>

			<div id="commentbar" class="ui-tabs-hide"><br/>
				<p>
					<?php require ('pagebar_options_commentbar.php'); ?>
				</p>
			</div>
		</div>
	</form>

	</div>



	<?php } //pboptions()
	} //if classexists
} //class

$pagebaroptions = new PagebarOptions;