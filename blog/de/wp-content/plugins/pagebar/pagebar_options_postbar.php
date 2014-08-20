<?php if(!defined('ABSPATH')) { header("HTTP/1.1 403 Forbidden"); die("HTTP/1.1 403 Forbidden"); } ?>
<script type="text/javascript">

function autoSwitch(id) {
var elements = ['footer', 'bef_loop', 'aft_loop', 'remove'];
   $j=jQuery.noConflict();
   if ($j('#cb_auto:checked').val() == null) {
      color = '#ccc';
      dis = "disabled";
   } else {
      color = '#000';
      dis = "";
   }
   for (i=0;i<=elements.length;i++) {
      $j('#lbl_' + elements[i]).css( { color: color} );
      $j("#cb_"+elements[i]).attr("disabled",dis);
   }
   $j('#pos').css( { color: color});
   $j('#integrate').css( { color: color});
}

function cssSwitch(id){
//   $j=jQuery.noConflict();
//    // double check for undefined and null for compatibilty with
//    // WP 2.3 and 2.5
//   if ( ($j('#rdo_style:checked').val() !== undefined) &&
//        ($j('#rdo_style:checked').val() !== null   )) {
//
//
//      $j("#edt_cssFile").attr("disabled","disabled");
//      $j("#edt_cssFile").css({color: '#ccc'});
//   } else {
//      $j("#edt_cssFile").attr("disabled",'');
//      $j("#edt_cssFile").css({color: '#000'});
//   }
}
</script>

<table class="form-table">

<?php $this->pb_basicOptions($pbOptions, 'post'); ?>


	<tr>
		<th scope="row" width="33%"><?php echo __( 'Automagic insertion', 'pagebar' )?>:</th>
		<td>
    <?php echo $this->checkbox ('Insert postbar automagic into blog', 'auto', $pbOptions, "post", "autoSwitch('position');"); ?>
		</td>
	</tr>


	<tr>
		<th scope="row" valign="top"><?php echo __( 'Positioning', 'pagebar' ) . ':'?></th>
   		<td>
        <?php echo
					$this->checkbox ('Front of postings', 'bef_loop', $pbOptions, "post" ) ,
					$this->checkbox ('Behind postings', 'aft_loop', $pbOptions, "post" ) ,
					$this->checkbox ('Footer', 'footer', $pbOptions, "post" );
				?>
      </td>
	</tr>

	<tr>
		<th scope="row" valign="top"><?php echo __( 'Integration', 'pagebar' )?>:</th>

		<td>
      <?php echo $this->checkbox ('Remove standard navigation', 'remove', $pbOptions, "post") ?>
		</td>
	</tr>

<?php $this->pb_stylesheetOptions($pbOptions, 'post') ?>

</table>


<?php $this->pb_submitButton('pagebar'); ?>

<script type="text/javascript">
autoSwitch(); cssSwitch();
</script>
