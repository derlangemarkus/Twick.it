<?php if (!defined ('ABSPATH') && !defined ('BBPATH')) die ('No direct access allowed'); ?>
	
<?php if (!$this->is_bbpress) : ?>
<div class="wrap">
<?php endif; ?>
	<h2><?php _e ('General Options', 'html-purified'); ?></h2>
	
	<?php $this->submenu (true); ?>
	
	<form style="clear: both" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
		
	<table class="form-table">
		<tr>
			<th width="200"><?php _e ('HTML Filter', 'html-purified'); ?>:</th>
			<td>
				<select name="filter">
					<?php foreach ($filters AS $key => $filter) : ?>
						<option value="<?php echo $key ?>"<?php if ($options['filter'] == $key) echo ' selected="selected"' ?>><?php echo $filter; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th width="200"><label for="force_filter"><?php _e ('Filter admin users', 'html-purified'); ?>:</label>
			</th>
			<td>
				<input type="checkbox" name="force_filter" id="force_filter"<?php if ($options['force_filter']) echo ' checked="checked"' ?>/>
				<small><?php _e ('Also pass data for admin users through HTML filter.  Be careful!', 'html-purified'); ?></small>
			</td>
		</tr>
		<tr>
			<th width="200"><label for="auto_php"><?php _e ('Auto-escape PHP', 'html-purified'); ?>:</label>
			</th>
			<td>
				<input type="checkbox" name="auto_php" id="auto_php"<?php if ($options['auto_php']) echo ' checked="checked"' ?>/>
				<small><?php _e ('Automatically escapes PHP code inserted', 'html-purified'); ?></small>
			</td>
		</tr>
		<tr>
			<th width="200"><label for="back_tick"><?php _e ('Back-tick escaping', 'html-purified'); ?>:</label>
			</th>
			<td>
				<input type="checkbox" name="back_tick" id="back_tick"<?php if ($options['back_tick']) echo ' checked="checked"' ?>/>
				<small><?php _e ('Anything between the back-tick will be escaped', 'html-purified'); ?></small>
			</td>
		</tr>
		<tr>
			<th width="200"><label for="footer_message"><?php _e ('Add message to site footer', 'html-purified'); ?>:</label>
			</th>
			<td>
				<input type="checkbox" name="footer_message" id="footer_message"<?php if ($options['footer_message']) echo ' checked="checked"' ?>/>
			</td>
		</tr>
		<tr>
			<th width="200" valign="top"><?php _e ('Allowed tags', 'html-purified'); ?>:
				<br/><small><?php _e ('HTML tags allowed in comments', 'html-purified'); ?>
				<br/><br/><?php _e ('Separate tags with a new line.', 'html-purified'); ?><br/><br/><?php _e ('Tag attributes can specified as', 'html-purified'); ?> <code>img[src|alt]</code></small>
			</th>
			<td>
				<textarea name="allowed_tags" rows="14" cols="40" class="wide-text"><?php echo htmlspecialchars ($this->get_allowed_tags ()) ?></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input class="button-primary" type="submit" name="save-general" value="<?php _e ('Save', 'html-purified'); ?>"/></td>
		</tr>
	</table>
	</form>
<?php if (!$this->is_bbpress) : ?>
</div>
<?php endif; ?>