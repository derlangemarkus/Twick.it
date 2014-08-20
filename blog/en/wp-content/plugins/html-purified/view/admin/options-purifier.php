<?php if (!defined ('ABSPATH') && !defined ('BBPATH')) die ('No direct access allowed'); ?>
	
<?php if (!$this->is_bbpress) : ?>
<div class="wrap">
<?php endif; ?>
	<h2><?php _e ('HTML Purifier Options', 'html-purified'); ?></h2>
	<?php $this->submenu (true); ?>
	
	<form action="<?php echo $this->url ($_SERVER['REQUEST_URI']) ?>" method="post" accept-charset="utf-8">
	<table class="form-table">
		<tr>
			<th><label for="cache"><?php _e ('Cache HTML Purifier', 'html-purified'); ?>:</label>
			</th>
			<td>
				<input type="checkbox" name="cache" id="cache"<?php if ($options['cache']) echo ' checked="checked"' ?>/>
			</td>
		</tr>
		<tr>
			<th><label for="bbcode"><?php _e ('Allow BBCode-style tags', 'html-purified'); ?></label>:</th>
			<td>
				<input type="checkbox" name="bbcode" id="bbcode"<?php if ($options['bbcode']) echo ' checked="checked"' ?>/>
				<small><?php _e ('For example, <code>[quote]thing[/quote]</code>', 'html-purified'); ?></small>
			</td>
		</tr>
		<tr>
			<th width="200"><?php _e ('Document Type', 'html-purified'); ?>:
				<br/><small><?php _e ('This should match the DOCTYPE for your theme', 'html-purified'); ?></small>
			</th>
			<td>
				<select name="encoding">
					<?php foreach ($encodings AS $key => $encoding) : ?>
						<option value="<?php echo $key ?>"<?php if ($options['encoding'] == $key) echo ' selected="selected"' ?>><?php echo $encoding; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th width="200"><?php _e ('HTML Tidy', 'html-purified'); ?>:
				<br/><small><?php _e ('Additionally run HTML Tidy', 'html-purified'); ?></small>
			</th>
			<td>
				<select name="tidy">
				<?php foreach ($tidy AS $key => $type) : ?>
					<option value="<?php echo $key ?>"<?php if ($options['tidy'] == $key) echo ' selected="selected"' ?>><?php echo $type; ?></option>
				<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<th width="200" valign="top"><?php _e ('URL Blacklist', 'html-purified'); ?>:
				<br/><small><?php _e ('Any URL matching a pattern be removed from input.', 'html-purified'); ?><br/><br/><?php _e ('Specify each pattern on a separate line.', 'html-purified'); ?></small>
			</th>
			<td>
				<textarea name="uri_blacklist" rows="4" cols="40" class="wide-text"><?php echo htmlspecialchars ($options['uri_blacklist']) ?></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input class="button-primary" type="submit" name="save-purifier" value="<?php _e ('Save', 'html-purified'); ?>"/></td>
		</tr>
	</table>
	</form>
<?php if (!$this->is_bbpress) : ?>
</div>
<?php endif; ?>