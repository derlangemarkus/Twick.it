<h3><?php _e('Notifications'); ?></h3>

<input type="hidden" name="ea_present" value="1" />

<table class="form-table">
	<tbody>	

<?php
	// User can subscribe to post publish events
	if ( $can_sub_publish_post ) { 
?>

		<tr>
			<th scope="row"><?php _e('Post notifications'); ?></th>
			<td>
				<div>
					<label for="ea_sub_publish_post">
						<input 
							type="checkbox" 
							name="ea_sub_publish_post" 
							<?php echo $checked_publish_post; ?> 
							id="ea_sub_publish_post" />
							<?php _e( 'Notify me when posts are published', 'swea' ); ?>
					</label></div>
			</td>
		</tr>

<?php 
	} 
?>
<?php 
	// User can subscribe to either hold comment or approve comment events
	if ( $can_sub_hold_comment || $can_sub_approve_comment ) { 
?>

		<tr>
			<th scope="row" rowspan="2"><?php _e( 'Comment notifications', 'swea' ); ?></th>
			<td>

<?php 
	// User can subscribe to holding comments
	if ( $can_sub_hold_comment ) { 
?>

				<div>
					<label for="ea_sub_hold_comment">
						<input 
							type="checkbox" 
							name="ea_sub_hold_comment" 
							<?php echo $checked_hold_comment; ?> 
							id="ea_sub_hold_comment" />
							<?php _e( 'Notify me when comments are held for moderation', 'swea' ); ?>
					</label>
				</div>				

<?php
	} 
?>
<?php 
	// User can 
	if ( $can_sub_approve_comment ) { 
?>

				<div>
					<label for="ea_sub_approve_comment">
						<input 
							type="checkbox" 
							name="ea_sub_approve_comment" 
							<?php echo $checked_approve_comment; ?> 
							id="ea_sub_approve_comment" /> 
							<?php _e( 'Notify me when comments are approved onto the site', 'swea' ); ?>
					</label>
				</div>

<?php } ?>
			</td>
		</tr>
<?php } ?>
	</tbody>
</table>