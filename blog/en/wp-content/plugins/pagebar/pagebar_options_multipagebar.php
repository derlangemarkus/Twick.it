<?php if(!defined('ABSPATH')) { header("HTTP/1.1 403 Forbidden"); die("HTTP/1.1 403 Forbidden"); } ?>
<script language="javascript">

function js_multipage() {
	$j=jQuery.noConflict();
  if ($j("#cb_multipage_inherit").attr("checked"))
    $j("#tb_multipage_inherit").hide();
  else
    $j("#tb_multipage_inherit").show();
}
</script>

<table class="form-table">

<?php
	if (! $pbOptions = get_option('multipagebar')) {
		pagebar_activate();
		$pbOptions = get_option('multipagebar');
	}

?>
<tr>
		<th scope="row" valign="top"><?php echo __( 'Inherit settings', 'pagebar' )?></th>
    <td>
			<label id="lbl_multipage_inherit">
				<input type="checkbox" id="cb_multipage_inherit" name="multipage_inherit" onClick="js_multipage()" \
				<?php if (empty ($pbOptions ['inherit'])) echo  ''; else echo ' checked'; ?>>
					&nbsp;<?php echo __('Inherit basic settings from postbar', 'pagebar'); ?></label>
		</td>
  </tr>

<tbody id="tb_multipage_inherit">
<?php
  $this->pb_basicOptions($pbOptions, 'multipage');
  $this->pb_stylesheetOptions($pbOptions, 'multipage');
?>
</tbody>



  <tr>
		<th scope="row" valign="top"><?php echo __( 'All pages link', 'pagebar' )?></th>
    <td>
			<label id="lbl_multipage_all">
				<input type="checkbox" id="cb_multipage_all" name="multipage_all"
				<?php if (empty ($pbOptions ['all'])) echo  ''; else echo ' checked'; ?>>
					&nbsp;<?php echo __("Display 'All Pages' link", 'pagebar'); ?></label>
		   <?php $this->textinput("All Pages Label", "label_all", $pbOptions, "multipage"); ?>
		</td>
  </tr>





</table>
<?php $this->pb_submitButton('postbar'); ?>
