<?php
/*
Plugin Name: DoNotTrack
Plugin URI: http://blog.futtta.be/tag/privacy
Description: Stops tracking scripts from e.g. media6degrees and quantcast from being loaded 
Author: Frank Goossens (futtta)
Version: 0.1.1
Author URI: http://blog.futtta.be/
*/
        
$donottrack_plugin_url=WP_PLUGIN_URL."/donottrack/";
$donottrack_js_url=$donottrack_plugin_url."donottrack-min.js";

function init_donottrack() {
    global $donottrack_js_url;
    wp_enqueue_script( 'donottrack',$donottrack_js_url );
}    
 
add_action('init', 'init_donottrack');
?>
