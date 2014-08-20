=== MP3-jPlayer ===
Author URI: http://www.sjward.org
Plugin URI: http://www.sjward.org/jplayer-for-wordpress
Contributors: simon.ward
Tags: mp3, audio, player, music, jplayer, integration, music player, mp3 player, playlist, media, jquery, javascript, plugin, shortcode, widget, widgets, css, posts, page, sidebar 
Requires at least: 2.8
Tested up to: 3.0.4
Stable tag: 1.4.1

An mp3 player for pages and posts, optional widget and shortcode, template tags. HTML5 / Flash, works on iphone and ipad.


== Description ==
Version 1.4.1 makes repeat playing optional from admin, fixes the text-player buttons CSS in Opera, and fixes the initial-volume setting where the slider was being set but not the volume.

New since 1.4.0 -

* A sidebar widget
* A text based player style
* Easy play of entire folders and library
* Randomise playlists
* Show library and local folder filenames on admin page
* Set a custom stylesheet from admin
* Playlist numbering optional
* More shortcode options
* Better help on the admin page


[See a Demo here](http://sjward.org/jplayer-for-wordpress)


Features -

* No setup
* Play from your Media Library, a default folder, another domain
* Set playlists for download
* Add titles and captions
* Optional widget with playlist and page-filter control
* Optional shortcode and parameters
* A set of template-tags
* Fully CSS styleable
* Integrates Happyworm's jquery.jplayer that can use HTML5 or Flash as needed.


<br />  
The plugin plays your mp3's by looking in the page/post custom fields for any playlist you have written. The player is added automatically when it picks up a playlist to play. You can also write a playlist in the widget.


<br>
**Widget**

Drag the player widget into one of your sidebars and set it's playback mode or playlist. Use the page filter to include-only or exclude any pages and posts. You can use multiple widgets to set different playlists for different pages. 


<br />
**Writing a playlist in the custom fields**

Add tracks on page/post edit screens using the custom fields (below the content box), as follows:

1. Enter <code>mp3</code> into the left hand box, this is the 'key' that the plugin looks for when reading the custom fields and you must always add it.

2. Write the filename/URI* into the right hand box and hit 'add custom field'


Repeat the above to add more tracks, and hit the 'Update page' button when you're done.

*Use a full URI when the mp3 is not in either a) the library or b) from the default folder/uri.


<br />
**Adding Titles and captions**

1. Add a dot, then a caption in the left hand box, eg: <code>mp3.Caption</code>

2. Add the title, then an '@' before the filename, eg: <code>Title@filename</code>


<br />
**Play Order**

To control the playlist order number the left hand boxes, eg: <code>1 mp3</code> will be first on the playlist. Un-numbered tracks appear below any numbered tracks.

<br />
**Playing a folder, the library, or another playlist**

Use these special commands in the value (right) box:

<code>FEED:LIB</code> Plays the entire library
<br />

<code>FEED:DF</code> Plays all from the default folder
<br />

<code>FEED:/mytunes</code> Play all from the local folder path /mytunes
<br />

<code>FEED:ID</code> Play the list from another ID (the id to pick up is set with the shortcode)


<br />
**Shortcode**

The shortcode is optional, it lets you position the player within the content and has 7 optional attributes for controlling the position (pos), download setting (dload), autoplay (play), playlist state (list), page ID (id), shuffle tracks (shuffle), take a random selection (slice). The shortcode is:

**<code>[mp3-jplayer]</code>**


The attributes are:

pos: left, right, rel, rel-C, rel-R, absolute

dload: true, false

play: true, false

list: open, closed, hidden, radio

id: (a page ID to pick up a playlist from when using 'FEED:ID' above)

shuffle: true

slice: (the number of tracks)

<br />
eg.

**<code>[mp3-jplayer id="7" list="hidden" pos="rel-C" shuffle="true"]</code>**


<br />
**Template Tags**

**<code>mp3j_addscripts( $style )</code>**

**<code>mp3j_flag( $set )</code>**

**<code>mp3j_grab_library( $format )</code>**

**<code>mp3j_set_meta( $tracks, $captions )</code>**

**<code>mp3j_put( $mode, $position, $dload, $autoplay, $playlist )</code>**

**<code>mp3j_debug($info)</code>**

<br>
Here's a quick example to make the player move to the sidebar on the posts index page and play 5 random tracks from your library

Put this in index.php before the posts loop starts:

`<?php if ( function_exists('mp3j_flag') ) { mp3j_flag(); } ?>`

<br />
Put this in sidebar.php somewhere below the opening div (note this is simplistic code, you'll need at least 5 tracks in your library for it to work):

`<?php 
if ( function_exists( 'mp3j_grab_library' ) ) { 
	$lib = mp3j_grab_library();
	$files = $lib['filenames'];
	shuffle( $files );
	$files = array_slice( $files, 0, 5 );
	mp3j_set_meta( $files );
	mp3j_put( 'feed' );
} 	
?>`


<br />
Finally, to set the smaller player stylesheet for the posts index only, put this in header.php above wp_head(): 

`<?php 
if ( function_exists('mp3j_addscripts') ) { 
	if ( is_home() ) {
		mp3j_addscripts('/wp-content/plugins/mp3-jplayer/css/mp3jplayer-blu-sidebar.css'); 
	}
}
?>`


See the help in the plugin for more info


== Installation ==

To install using Wordpress:

1. Download the zip file to your computer.
2. Log in to your Wordpress admin and go to 'plugins' -> 'Add New'.
3. Click 'Upload' at the top of the page then browse' for the zip file on your computer and hit the 'Install' button, Wordpress should install it for you.
4. Once installed go to your Wordpress 'Plugins' menu and activate MP3-jPlayer.

To Install manually:

1. Download the zip file and unzip it. 
2. Open the unzipped folder and upload the entire contents (1 folder and it's files and subfolders) to your `/wp-content/plugins` directory on the server.
3. Activate the plugin via your Wordpress 'Plugins' menu.



== Frequently Asked Questions ==

= Can the player go in the sidebar? =
Yes, by widgets or template-tags.

= Can the player go in the header/footer? =
Yes if your theme has header/footer widget areas, if it doesn't then you can use template-tags to place the player anywhere in the theme.


== Screenshots ==

1. Included player styles
2. Main admin page
3. Widget panel
3. Playlist example written into the custom fields 


== Changelog ==

= 1.4.1 =
* Added a repeat play option on settings page.
* Fixed text-player buttons css in Opera.
* Fixed initial-volume setting error where only the slider was being set and not the volume. Thanks to Darkwave for letting me know.


= 1.4.0 =
* Added a widget.
* Improvements to admin including library and default folder mp3 lists, custom stylesheet setting, and some new options.  
* Added new shortcode attributes shuffle, slice, id. New values for list
* Added a way to play whole folders, the entire library, to grab the tracks from another page.
* Added a simpler text-only player style that adopts theme link colours.
* Improved admin help.
* Some minor bug fixes.
* Some minor css improvements and fixes.

= 1.3.4 =
* Added template tags.
* Added new shortcode attributes play and list, and added more values for pos.
* Added new default position options on settings page
* Added a smaller player option

= 1.3.3 =
* Fixed the CSS that caused player to display poorly in some themes.

= 1.3.2 =
* Added the shortcode [mp3-jplayer] and attributes: pos (left, right, none), dload (true, false) which over-ride the admin-panel position and download settings on that post/page. Eg. [mp3-jplayer pos="right" dload="true"]
* Tweaked transport button graphic a wee bit.

= 1.3.1 =
* Fixed image rollover on buttons when wordpress not installed in root of site.

= 1.3.0 =
* First release on Wordpress.org
* Updated jquery.jplayer.min.js to version 1.2.0 (including the new .swf file). The plugin should now work on the iPad.
* Fixed admin side broken display of the uploads folder path that occured when a path had been specified but didn't yet exist.
* Fixed the broken link to the (new) media settings page when running in Wordpress 3.
* Changed the 'Use my media library titles...' option logic to allow any titles or captions to independently over-ride the library by default. The option is now 'Always use my media library titles...' which when ticked will give preference to library titles/captions over those in the custom fields.
* Modified the css for compatibility with Internet Explorer 6. The player should now display almost the same in IE6 as in other browsers.

= 1.2.12 = 
* Added play order setting, a 'download mp3' link option, show/hide playlist and option, a connecting state, a new style.  
* The 'Default folder' option can now be a remote uri to a folder, if it is then it doesn't get filtered from the playists when 'allow remote' is unticked. 

= 1.2.0 =
* Added playing of media library mp3's in the same way as from the default folder (ie. by entering just a filename). User does not have to specify where the tracks reside (recognises library file, default folder file, and local or remote uri's). 
* Added filter option to remove off-site mp3's from the playlists.
* The plugin now clears out it's settings from the database by default upon deactivation. This can be changed from the settings page.
* It's no longer necessary to include the file extension when writing filenames.

= 1.1.0 =
* Added captions, player status info, a-z sort option, basic player positioning, detecting of urls/default folder
* Fixed bug where using unescaped double quotes in a title broke the playlist, quotes are now escaped automatically and can be used.

= 1.0 =
* First release
