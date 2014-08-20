<?php
/*
Plugin Name: Audio
Description: HTML5 Audio (on supported browsers), Flash fallback, CSS-skin'd player, hAudio Micro-formats, attach images to MP3s (when used with Shuffle)
Author: Scott Taylor
Version: 0.5.1
Author URI: http://tsunamiorigami.com
*/

if (!class_exists('getID3')) {
	require_once('getid3/getid3/getid3.php');
}

define('A_THUMB_WIDTH', 50);
define('A_THUMB_HEIGHT', 50);

define('A_LAYOUT_LIST', 'list');
define('A_LAYOUT_PLAYER', 'player');
define('A_LAYOUT_MINI', 'mini');

$audio_layout = '';

function audio_duration_formatted($file) {
	// Initialize getID3 engine
	$getID3 = new getID3;
	$getID3->setOption(array('encoding' => 'UTF-8'));
	
	$info = $getID3->analyze($file);
	$total = explode(':', $info['playtime_string']);
	$mins = $total[0];
	$secs = $total[1];
	unset($getID3, $total, $info);
	
	return array(
		'PT' . $mins . 'M' . $secs . 'S',
		$mins . ' minutes, ' . $secs . ' seconds'
	); 
}

function audio_get_ogg_object($id) {
	$ogg = '';
	if (function_exists('shuffle_by_mime_type')):
		$oggs = get_audio($id);
		if (is_array($oggs) && count($oggs) > 0) {
			foreach ($oggs as $o):
				if ($o->post_mime_type === 'audio/ogg') {
					$ogg = $o;
					break;				
				}
			endforeach;
		}
		unset($oggs);
	endif;
	return $ogg;
}

function audio_image($id, $title) {
	if (function_exists('shuffle_by_mime_type')):
		$imgs = get_images($id);
		if (count($imgs)): 
			foreach ($imgs as $img): 
				$meta = wp_get_attachment_image_src($img->ID, array(A_THUMB_WIDTH, A_THUMB_HEIGHT), true); 
				printf('<img class="photo" src="%s" width="%d" height="%d" alt="%s" />',
					$meta[0], $meta[1], $meta[2], apply_filters('the_title_attribute', $title));
			endforeach; 
		endif;
		unset($imgs);
	endif;
}

function audio_enclosure($mime, $path, $song) {
	printf('<a type="%s" rel="enclosure" href="%s">"%s"</a>', $mime, base64_encode($path), $song); 
}

function audio_item_formatted($post) {	
	$song = apply_filters('the_title', $post->post_title);
	$artist = $post->post_excerpt;
	$album = $post->post_content;

	$parts = parse_url($post->guid);	
	$local_file = getcwd() . $parts['path'];

?><div class="haudio">
	<?php audio_image($post->ID, $song) ?>
   	<span class="fn"><?= $song ?></span> 
	<span class="contributor">
		<span class="vcard">
			<span class="fn org"><?= $artist ?></span>
		</span>
	</span>
	<span class="album"><?= $album ?></span>
	<?php $dur = audio_duration_formatted($local_file); ?>
	<abbr class="duration" title="<?= $dur[0] ?>"><?= $dur[1] ?></abbr>	
	<?php audio_enclosure($post->post_mime_type, $parts['path'], $song); ?>
	<?php 
		unset($dur);
		$ogg = audio_get_ogg_object($post->ID);
	if (!empty($ogg)):
		$parts = parse_url($ogg->guid);
		$song = apply_filters('the_title', $ogg->post_title);
		audio_enclosure($ogg->post_mime_type, $parts['path'], $song);
		unset($ogg, $parts);
	endif;
	?>
</div>
<?php
}

function the_audio($id = 0, $layout = '') {
	global $audio_layout;
	$audio_layout = $layout;
	$coerced_id = (int) $id === 0 ? get_the_id() : $id;
	
	if (empty($audio_layout)) {
		$audio_layout = A_LAYOUT_PLAYER;
	}

if ((int) $coerced_id > 0):	
	if (function_exists('shuffle_by_mime_type')):
		$audio = get_audio($coerced_id); 
	else:
		// this is functionality ported over from Shuffle
		// you should be using Shuffle!!!	
		$audio = get_posts(array(
			'post_parent'    => $coerced_id,
			'post_mime_type' => 'audio',
			'order'       	 => 'ASC',
			'orderby'     	 => 'menu_order',
			'post_type'   	 => 'attachment',
			'post_status' 	 => 'inherit',
			'numberposts' 	 => -1	
		));
	endif;
	if (count($audio) > 0): ?>
		<div class="audio-playlist<?= ' ', $audio_layout, '-playlist' ?>">
		<?php foreach ($audio as $a): audio_item_formatted($a); endforeach; ?>
		</div>
	<?php endif;
	unset($audio);
endif;
}

function audio_print_styles() {
	$local = STYLESHEETPATH . '/audio.css';
		
	if (is_file($local)) {
		wp_enqueue_style('audio-override', get_bloginfo('stylesheet_directory') . '/audio.css');	
	} else {
		wp_enqueue_style('audio', WP_PLUGIN_URL . '/audio/css/audio.css');		
	}
}
add_action('wp_print_styles', 'audio_print_styles');

function audio_print_scripts() {	
	wp_enqueue_script('base64', WP_PLUGIN_URL . '/audio/js/base64.js');
	wp_enqueue_script('jplayer', WP_PLUGIN_URL . '/audio/js/jquery.jplayer.min.js', array('jquery'));
	wp_enqueue_script('jplayer-inspector', 
		WP_PLUGIN_URL . '/audio/js/jquery.jplayer.inspector.js', array('jquery', 'jplayer'));
	wp_enqueue_script('audio', WP_PLUGIN_URL . '/audio/js/audio.js', array('jplayer', 'jplayer-inspector', 'base64'));
}
add_action('wp_print_scripts', 'audio_print_scripts');

function audio_handler($atts, $content = null ) {
   	extract(shortcode_atts(array(
      	'layout' => ''
     ), $atts));
         
     ob_start();
     the_audio(0, $layout);
     $audio = ob_get_contents();
     ob_end_clean();
     return $audio;
}
add_shortcode('audio', 'audio_handler');
?>