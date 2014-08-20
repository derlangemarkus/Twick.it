=== Audio ===
Contributors: wonderboymusic
Tags: media, attachments, admin, audio, cms, jquery, manage, music, upload
Requires at least: 3.0
Tested up to: 3.0
Stable Tag: 0.5.1

HTML5 Audio (on supported browsers), Flash fallback, CSS-skin'd player, hAudio Micro-formats, attach images to MP3s (when used with Shuffle)

== Description ==

Audio allows you to use simple functions in your theme to display audio you have attached to Posts/Pages/Custom Post Types in your Media Library. Your player is styled 100% with CSS/images (if you want). Your audio player uses your browser's native HTML5 capabilities when available with a fallback to Flash when necessary. Allows you to play audio inline on mobile browsers that support HTML5 Audio (heeeey, WebKit!)

You can use this shortcode <code>[audio]</code> or <code>the_audio()</code> in your theme to output your item's attachments.

Read More here: http://scottctaylor.wordpress.com/2010/11/22/new-plugin-audio/

== Changelog ==
= 0.5 = 
* updates jPlayer to version 2.0
* fixed all of the PHP4 static-like method references in the getID3 library so a tornado of Errors/Notices won't be thrown in the error logs, especially when error settings are <code>error_reporting(-1)</code>

= 0.4 = 
* in lieu of handling malformed filenames, all filenames will be Base64-encoded in the enclosure portion of the hAudio markup. Users no longer have the option of setting <code>A_SECURE</code>. I also cleaned up some redundant code.

= 0.3 =
* Changed the boilerplate player markup to support any number of players on a page.
* When multiple players are present, playing one will pause all others
* Moved markup generation to JavaScript to support dynamic ID generation/management

= 0.2 =
* Added support for Ogg Vorbis - supports both when used with [Shuffle](http://wordpress.org/extend/plugins/shuffle/ "Shuffle")

= 0.1.1 = 
* Only loads ID3 tag class when not loaded by other plugin, scripts and styles loaded automatically

= 0.1 =
* Initial release

== Upgrade Notice ==