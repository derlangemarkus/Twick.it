<?php 

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

class nggManageAlbum {
	
	/**
	 * The selected album ID
	 *
	 * @since 1.3.0
	 * @access privat
	 * @var int
	 */
	var $currentID = 0;
	
	/**
	 * The array for the galleries
	 *
	 * @since 1.3.0
	 * @access privat
	 * @var array
	 */
	var $galleries = false;	

	/**
	 * The array for the albums
	 *
	 * @since 1.3.0
	 * @access privat
	 * @var array
	 */
	var $albums = false;	

	/**
	 * The amount of all galleries
	 *
	 * @since 1.4.0
	 * @access privat
	 * @var int
	 */
	var $num_galleries = false;
	
	/**
	 * The amount of all albums
	 *
	 * @since 1.4.0
	 * @access privat
	 * @var int
	 */
	var $num_albums = false;

	/**
	 * PHP4 compatibility layer for calling the PHP5 constructor.
	 * 
	 */
	function nggManageAlbum() {
		return $this->__construct();
	}

	/**
	 * Init the album output
	 * 
	 */	
	function __construct() {
		return true;
	}
	
	function controller() {
		global $nggdb;

		$this->currentID = isset($_POST['act_album']) ? (int) $_POST['act_album'] : 0 ;

		if (isset ($_POST['update']) || isset( $_POST['delete'] ) || isset( $_POST['add'] ) )
			$this->processor();
		
		if (isset ($_POST['update_album']) )
			$this->update_album();	
		
		// get first all galleries & albums
		$this->albums = $nggdb->find_all_album();
		$this->galleries  = $nggdb->find_all_galleries();	
		$this->num_albums  = count( $this->albums );
		$this->num_galleries  = count( $this->galleries );	
		$this->output();	
	
	}
	
	function processor() {
		global $wpdb;
		
		check_admin_referer('ngg_album');
	
		if ( isset($_POST['add']) && isset ($_POST['newalbum']) ) { 
			
			if (!nggGallery::current_user_can( 'NextGEN Add/Delete album' ))
				wp_die(__('Cheatin&#8217; uh?'));			
			
			$result = nggdb::add_album( $_POST['newalbum'] );
            $this->currentID = ($result) ? $result : 0 ;
			
			if ($result) 
				nggGallery::show_message(__('Update Successfully','nggallery'));
		} 
		
		if ( isset($_POST['update']) && ($this->currentID > 0) ) {
            
            $gid = '';
            
			// get variable galleryContainer 
			parse_str($_POST['sortorder']); 
			if ( is_array($gid) ){ 
				$serial_sort = serialize($gid); 
				$wpdb->query("UPDATE $wpdb->nggalbum SET sortorder = '$serial_sort' WHERE id = $this->currentID ");
			} else {
				$wpdb->query("UPDATE $wpdb->nggalbum SET sortorder = '0' WHERE id = $this->currentID ");
			}
			nggGallery::show_message(__('Update Successfully','nggallery'));

		}
		
		if ( isset($_POST['delete']) ) {
			
			if (!nggGallery::current_user_can( 'NextGEN Add/Delete album' ))
				wp_die(__('Cheatin&#8217; uh?'));
				
			$result = nggdb::delete_album( $this->currentID );
            
            $this->currentID = 0;
            
			if ($result) 
				nggGallery::show_message(__('Album deleted','nggallery'));
		}
		
	}

	function update_album() {
		global $wpdb, $nggdb;
		
		check_admin_referer('ngg_thickbox_form');
		
		if (!nggGallery::current_user_can( 'NextGEN Edit album settings' )) 
			wp_die(__('Cheatin&#8217; uh?'));
		
		$name = $_POST['album_name'];
		$desc = $_POST['album_desc'];
		$prev = (int) $_POST['previewpic'];
		$link = (int) $_POST['pageid'];
        
		// slug must be unique, we use the title for that
        $slug = nggdb::get_unique_slug( sanitize_title( $name ), 'album' );
        
		$result = $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->nggalbum SET slug= '%s', name= '%s', albumdesc= '%s', previewpic= %d, pageid= %d WHERE id = '%d'" , $slug, $name, $desc, $prev, $link, $this->currentID ) );
        
		//hook for other plugin to update the fields
		do_action('ngg_update_album', $this->currentID, $_POST);        
        
		if ($result)
			nggGallery::show_message(__('Update Successfully','nggallery'));
	}
	
	function output() {
		
	global $wpdb, $nggdb;

	//TODO:Code MUST be optimized, how to flag a used gallery better ?
	$used_list = $this->get_used_galleries();
	
?>

<script type="text/javascript">

jQuery(document).ready(
	function()
	{
        jQuery("#previewpic").nggAutocomplete( {
            type: 'image',domain: "<?php echo site_url(); ?>/"
        });
        
		jQuery('#selectContainer').sortable( {
			items: '.groupItem',
			placeholder: 'sort_placeholder',
			opacity: 0.7,
			tolerance: 'intersect',
			distance: 2,
			forcePlaceholderSize: true ,
			connectWith: ['#galleryContainer'] 
		} );

		jQuery('#galleryContainer').sortable( {
			items: '.groupItem',
			placeholder: 'sort_placeholder',
			opacity: 0.7,
			tolerance: 'intersect',
			distance: 2,
			forcePlaceholderSize: true ,
			connectWith: ['#selectContainer', '#albumContainer'] 
		} );

		jQuery('#albumContainer').sortable( {
			items: '.groupItem',
			placeholder: 'sort_placeholder',
			opacity: 0.7,
			tolerance: 'intersect',
			distance: 2,
			forcePlaceholderSize: true ,
			connectWith: ['#galleryContainer']
		} );
		
		jQuery('a.min').bind('click', toggleContent);

		// Hide used galleries
		jQuery('a#toggle_used').click(function()
			{
				jQuery('#selectContainer div.inUse').toggle();
				return false;
			}
		);	
			
		// Maximize All Portlets (whole site, no differentiation)
		jQuery('a#all_max').click(function()
			{
				jQuery('div.itemContent:hidden').show();
				return false;
			}
		);

		// Minimize All Portlets (whole site, no differentiation)
		jQuery('a#all_min').click(function()
			{
				jQuery('div.itemContent:visible').hide();
				return false;
			}
		);
	   // Auto Minimize if more than 4 (whole site, no differentiation)
	   if(jQuery('a.min').length > 4)
	   {
	   		jQuery('a.min').html('[+]');
	   		jQuery('div.itemContent:visible').hide();
	   		jQuery('#selectContainer div.inUse').toggle();
	   };
	}
);

var toggleContent = function(e)
{
	var targetContent = jQuery('div.itemContent', this.parentNode.parentNode);
	if (targetContent.css('display') == 'none') {
		targetContent.slideDown(300);
		jQuery(this).html('[-]');
	} else {
		targetContent.slideUp(300);
		jQuery(this).html('[+]');
	}
	return false;
}

function ngg_serialize(s)
{
	//serial = jQuery.SortSerialize(s);
	serial = jQuery('#galleryContainer').sortable('serialize');
	jQuery('input[name=sortorder]').val(serial);
}

function showDialog() {
	jQuery( "#editalbum").dialog({
		width: 640,
        resizable : false,
		modal: true,
        title: '<?php echo esc_js( __('Edit Album', 'nggallery') ); ?>'        
	});
    jQuery('#editalbum .dialog-cancel').click(function() { jQuery( "#editalbum" ).dialog("close"); });
}

</script>

<div class="wrap album" id="wrap" >
    <?php screen_icon( 'nextgen-gallery' ); ?>
	<h2><?php esc_html_e('Manage Albums', 'nggallery') ?></h2>
	<form id="selectalbum" method="POST" onsubmit="ngg_serialize()" accept-charset="utf-8">
		<?php wp_nonce_field('ngg_album') ?>
		<input name="sortorder" type="hidden" />
		<div class="albumnav tablenav">
			<div class="alignleft actions">
				<?php esc_html_e('Select album', 'nggallery') ?>
				<select id="act_album" name="act_album" onchange="this.form.submit();">
					<option value="0" ><?php esc_html_e('No album selected', 'nggallery') ?></option>
					<?php
						if( is_array($this->albums) ) {
							foreach($this->albums as $album) {
								$selected = ($this->currentID == $album->id) ? 'selected="selected" ' : '';
								echo '<option value="' . $album->id . '" ' . $selected . '>' . $album->id . ' - ' . $album->name . '</option>'."\n";
							}
						}
					?>
				</select>
				<?php if ($this->currentID > 0){ ?>
					<input class="button-primary" type="submit" name="update" value="<?php esc_attr_e('Update', 'nggallery'); ?>"/>
					<?php if(nggGallery::current_user_can( 'NextGEN Edit album settings' )) { ?>
					<input class="button-secondary" type="submit" name="showThickbox" value="<?php esc_attr_e( 'Edit album', 'nggallery'); ?>" onclick="showDialog(); return false;" />
					<?php } ?>
					<?php if(nggGallery::current_user_can( 'NextGEN Add/Delete album' )) { ?>
					<input class="button-secondary action "type="submit" name="delete" value="<?php esc_attr_e('Delete', 'nggallery'); ?>" onclick="javascript:check=confirm('<?php esc_js('Delete album ?','nggallery'); ?>');if(check==false) return false;"/>
					<?php } ?>
				<?php } else { ?>
					<?php if(nggGallery::current_user_can( 'NextGEN Add/Delete album' )) { ?>
					<span><?php esc_html_e('Add new album', 'nggallery'); ?>&nbsp;</span>
					<input class="search-input" id="newalbum" name="newalbum" type="text" value="" />			
					<input class="button-secondary action" type="submit" name="add" value="<?php esc_attr_e('Add', 'nggallery'); ?>"/>
					<?php } ?>
				<?php } ?>	
			</div>
		</div>
	</form>
	
	<br class="clear"/>
	
	<div>
		<div style="float:right;">
		  <a href="#" title="<?php esc_attr_e('Show / hide used galleries','nggallery'); ?>" id="toggle_used"><?php esc_html_e('[Show all]', 'nggallery'); ?></a>
		| <a href="#" title="<?php esc_attr_e('Maximize the widget content','nggallery'); ?>" id="all_max"><?php esc_html_e('[Maximize]', 'nggallery'); ?></a>
		| <a href="#" title="<?php esc_attr_e('Minimize the widget content','nggallery'); ?>" id="all_min"><?php esc_html_e('[Minimize]', 'nggallery'); ?></a>
		</div>
		<?php esc_html_e('After you create and select a album, you can drag and drop a gallery or another album into your new album below','nggallery'); ?>
	</div>

	<br class="clear" />
	
	<div class="container">
		
		<!-- /#album container -->
		<div class="widget widget-right">
			<div class="widget-top">
				<h3><?php esc_html_e('Select album', 'nggallery'); ?></h3>
			</div>
			<div id="albumContainer" class="widget-holder">
			<?php 
			if( is_array( $this->albums ) ) {
				foreach($this->albums as $album) {
					$this->get_container('a' . $album->id);
				}
			}
		?> 
			</div>			
		</div>
		
		<!-- /#select container -->
		<div class="widget widget-right">
			<div class="widget-top">
				<h3><?php esc_html_e('Select gallery', 'nggallery'); ?></h3>
			</div>
			<div id="selectContainer" class="widget-holder">
		<?php
		
		if( is_array( $this->galleries ) ) {
			//get the array of galleries	
			$sort_array =  $this->currentID > 0 ? (array) $this->albums[$this->currentID]->galleries : array() ;
			foreach($this->galleries as $gallery) {
				if (!in_array($gallery->gid, $sort_array)) {
					if (in_array($gallery->gid,$used_list))
						$this->get_container($gallery->gid,true);
					else
						$this->get_container($gallery->gid,false);
				}
			}
		}
		?>
			</div>
		</div>
		
		<!-- /#target-album -->
		<div class="widget target-album widget-liquid-left">

		<?php
			if ($this->currentID > 0){			
				$album = $this->albums[$this->currentID];
				?>
				<div class="widget-top">
					<h3><?php esc_html_e('Album ID', 'nggallery');  ?> <?php echo $album->id . ' : ' . $album->name; ?> </h3>
				</div>
				<div id="galleryContainer" class="widget-holder target">
				<?php
				$sort_array = (array) $this->albums[$this->currentID]->galleries;
				foreach($sort_array as $galleryid) {
					$this->get_container($galleryid, false);
				}
			} 
			else
			{	
				?>
				<div class="widget-top">
					<h3><?php esc_html_e('No album selected!', 'nggallery'); ?></h3>
				</div>
				<div class="widget-holder target">
				<?php
			}
		?> 
			</div>
		</div><!-- /#target-album -->

	</div><!-- /#container -->
</div><!-- /#wrap -->

<!-- #editalbum -->
<div id="editalbum" style="display: none;" >
	<form id="form-edit-album" method="POST" accept-charset="utf-8">
	<?php wp_nonce_field('ngg_thickbox_form') ?>
	<input type="hidden" id="current_album" name="act_album" value="<?php echo $this->currentID; ?>" />
	<table width="100%" border="0" cellspacing="3" cellpadding="3" >
	  	<tr>
	    	<th>
	    		<?php esc_html_e('Album name:', 'nggallery'); ?><br />
				<input class="search-input" id="album_name" name="album_name" type="text" value="<?php echo esc_attr( $album->name ); ?>" style="width:95%" />
	    	</th>
	  	</tr>
	  	<tr>
	    	<th>
	    		<?php esc_html_e('Album description:', 'nggallery'); ?><br />
	    		<textarea class="search-input" id="album_desc" name="album_desc" cols="50" rows="2" style="width:95%" ><?php echo esc_attr( $album->albumdesc ); ?></textarea>
	    	</th>
	  	</tr>
	  	<tr>
	    	<th>
	    		<?php esc_html_e('Select a preview image:', 'nggallery'); ?><br />
					<select id="previewpic" name="previewpic" style="width:95%" >
                        <?php if ($album->previewpic == 0) ?>
		                <option value="0"><?php esc_html_e('No picture', 'nggallery'); ?></option>
						<?php
                            if ($album->previewpic == 0)
                                echo '<option value="0" selected="selected">' . __('No picture', 'nggallery') . '</option>';
                            else {
                                $picture = nggdb::find_image($album->previewpic);
                                echo '<option value="' . $picture->pid . '" selected="selected" >'. $picture->pid . ' - ' . ( empty($picture->alltext) ? $picture->filename : $picture->alltext ) .' </option>'."\n";
                            }
						?>
					</select>
	    	</th>
	  	</tr>
        <tr>
            <th>
                <?php esc_html_e('Page Link to', 'nggallery')?><br />
                    <select name="pageid" style="width:95%">
                        <option value="0" ><?php esc_html_e('Not linked', 'nggallery') ?></option>
                        <?php 
                        if (!isset($album->pageid))
                            $album->pageid = 0;
                        parent_dropdown($album->pageid); ?>
                    </select>
            </th>
        </tr>
        
        <?php do_action('ngg_edit_album_settings', $this->currentID); ?>
        
	  	<tr align="right">
	    	<td class="submit">
	    		<input type="submit" class="button-primary" name="update_album" value="<?php esc_attr_e('OK', 'nggallery'); ?>" />
	    		&nbsp;
	    		<input class="button-secondary dialog-cancel" type="reset" value="<?php esc_attr_e('Cancel', 'nggallery'); ?>"/>
	    	</td>
		</tr>
	</table>
	</form>
</div>
<!-- /#editalbum -->

<?php
		
	}
	
	/**
	 * Create the album or gallery container
	 * 
	 * @param integer $id (the prefix 'a' indidcates that you look for a album 
	 * @param bool $used (object will be hidden)
	 * @return $output
	 */
	function get_container($id = 0, $used = false) {
		global $wpdb, $nggdb;
		
		$obj =  array();
		$preview_image = '';
        $class = '';
		
		// if the id started with a 'a', then it's a sub album
		if (substr( $id, 0, 1) == 'a') {
			
			if ( !$album = $this->albums[ substr( $id, 1) ] )
				return;
	
			$obj['id']   = $album->id;
			$obj['name'] = $obj['title'] = $album->name;
			$class = 'album_obj';

			// get the post name
			$post = get_post($album->pageid);
			$obj['pagenname'] = ($post == null) ? '---' : $post->post_title;
			
			// for speed reason we limit it to 50
			if ( $this->num_albums < 50 ) {	
				if ($album->previewpic != 0) {
					$image = $nggdb->find_image( $album->previewpic ); 
    				$preview_image = ( !is_null($image->thumbURL) )  ? '<div class="inlinepicture"><img src="' . $image->thumbURL . '" /></div>' : '';
                }
			}
			
			// this indicates that we have a album container
			$prefix = 'a';
		
		} else {
			if ( !$gallery = $nggdb->find_gallery( $id ) )
				return;

			$obj['id']    = $gallery->gid;
			$obj['name']  = $gallery->name;
			$obj['title'] = $gallery->title;
		
			// get the post name
			$post = get_post($gallery->pageid);
			$obj['pagenname'] = ($post == null) ? '---' : $post->post_title;	

			// for spped reason we limit it to 50
			if ( $this->num_galleries < 50 ) {
				// set image url
				$image = $nggdb->find_image( $gallery->previewpic );
				$preview_image = isset($image->thumbURL) ? '<div class="inlinepicture"><img src="' . $image->thumbURL . '" /></div>' : '';
			}
			
			$prefix = '';
		}

		// add class if it's in use in other albums
		$used = $used ? ' inUse' : '';		
		
		echo '<div id="gid-' . $prefix . $obj['id'] . '" class="groupItem' . $used . '">
				<div class="innerhandle">
					<div class="item_top ' . $class . '">
						<a href="#" class="min" title="close">[-]</a>
						ID: ' . $obj['id'] . ' | ' . wp_html_excerpt( nggGallery::i18n( $obj['title'] ) , 25) . '
					</div>
					<div class="itemContent">
							' . $preview_image . '
							<p><strong>' . __('Name', 'nggallery') . ' : </strong>' . nggGallery::i18n( $obj['name'] ) . '</p>
							<p><strong>' . __('Title', 'nggallery') . ' : </strong>' . nggGallery::i18n( $obj['title'] ) . '</p>
							<p><strong>' . __('Page', 'nggallery'). ' : </strong>' . nggGallery::i18n( $obj['pagenname'] ) . '</p>
							' . apply_filters('ngg_display_album_item_content', '', $obj['id']) . '
						</div>
				</div>
			   </div>'; 
	}
	
	/**
	 * get all used galleries from all albums
	 * 
	 * @return array $used_galleries_ids
	 */
	function get_used_galleries() {
		
		$used = array();
		
		if ($this->albums) {
			foreach($this->albums as $key => $value) {
				$sort_array = $this->albums[$key]->galleries;
				foreach($sort_array as $galleryid) {
					if (!in_array($galleryid, $used))
						$used[] = $galleryid;
				}
			}
		}
		
		return $used;
	}

	/**
	 * PHP5 style destructor
	 *
	 * @return bool Always true
	 */
	function __destruct() {
		return true;
	}
	
}
?>