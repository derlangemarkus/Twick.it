<?php if(!defined('ABSPATH')) { header("HTTP/1.1 403 Forbidden"); die("HTTP/1.1 403 Forbidden"); } ?>
<script language="javascript">

function js_comment() {
	$j=jQuery.noConflict();
  if ($j("#cb_comment_inherit").attr("checked"))
    $j("#comment_inherit").hide();
  else
    $j("#comment_inherit").show();
}



function js_comment_all() {
	$j=jQuery.noConflict();
  if ($j("#cb_comment_all").attr("checked")) {
    $j("#comment_label_all").attr("disabled", "");
		$j("#comment_label_all").css('color', '#000');
	}

  else {
    $j("#comment_label_all").attr("disabled", "disabled");
		$j("#comment_label_all").css('color', '#ff0000');
	}
}

</script>


<table class="form-table">

<?php
	if (! $pbOptions = get_option('commentbar')) {
		pagebar_activate();
		$pbOptions = get_option('commentbar');
	}

?>

  <tr>
		<th scope="row" valign="top"><?php echo __( 'Inherit settings', 'pagebar' )?></th>
    <td>
	<label id="lbl_comment_inherit">
		<input type="checkbox" id="cb_comment_inherit" name="comment_inherit" onClick="js_comment()"
		<?php if (empty ($pbOptions ['inherit'])) echo  ''; else echo ' checked'; ?>>
			&nbsp;Inherit basic settings from postbar</label>
		</td>
  </tr>

<tbody id="comment_inherit">
	<?php $this->pb_basicOptions($pbOptions, 'comment'); ?>
	<?php $this->pb_stylesheetOptions($pbOptions, 'comment'); ?>
</tbody>

</table>
<?php $this->pb_submitButton('commentbar'); ?>
