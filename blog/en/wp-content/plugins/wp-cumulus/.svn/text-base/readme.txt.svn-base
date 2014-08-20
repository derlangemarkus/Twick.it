=== Plugin Name ===
Contributors: weefselkweekje, LukeMorton
Donate link: http://www.roytanck.com/about-my-themes/donations/
Tags: tag cloud, flash, sphere, categories, widget, tags, 3D, cloud
Requires at least: 2.3
Tested up to: 2.9
Stable tag: 1.23

WP-Cumulus displays your tags and/or categories in 3D by placing them on a rotating sphere.

== Description ==

WP-Cumulus allows you to display your site's tags, categories or both using a Flash movie that rotates them in 3D. It works just like a regular tags cloud, but is more visually exciting. Clicking the tags can be a little hard (depending on your speed setting) but does take you to the appropriate page :).

The sources code for the Flash movie are available from wordpress.org.

== Installation ==

= Installation =
1. Make sure you're running WordPress version 2.3 or better. It won't work with older versions.
1. Download the zip file and extract the contents.
1. Upload the 'wp-cumulus' folder to your plugins directory (wp-content/plugins/).
1. Activate the plugin through the 'plugins' page in WP.
1. See 'Options->WP Cumulus' to adjust things like display size, etc...

= In order to actually display the tag cloud, you have three options. =
1. Create a page or post and type [wp-cumulus] anywhere in the content. This 'tag' will be replaced by the flash movie when viewing the page. See [here](http://www.roytanck.com/2009/03/11/how-to-use-wp-cumulus-shortcodes/) for more info.
1. Add the following code anywhere in your theme to display the cloud. `<?php wp_cumulus_insert(); ?>` This can be used to add WP Cumulus to your sidebar, although it may not actually be wide enough in many cases to keep the tags readable.
1. The plugin adds a widget, so you can place it on your sidebar through 'Appearance'->'Widgets'. Open the widget to access it's own set of settings (background color, size, etc).

== Frequently Asked Questions ==

= My theme/site appears not to like this plugin. It's not displaying correctly. =
There are a number of things that may prevent WP-Cumulus from displaying or cause it to display a short message about how it needs the Flash plugin.

* In 99% of all cases where this happens the issue is caused by markup errors in the page where the plugin is used. Please validate your blog using [validator.w3.org](http://validator.w3.org) and fix any errors you may encounter.
* Older versions had issues with PHP 5.2 (or better). This has been fixed, so please upgrade to the latest version.
* The plugin requires Flash Player 9 or better and javascript. Please make sure you have both.
* There have been some cases where WordPress' Automatic Plugin Upgrade feature breaks the plugin. After upgrading the plugin the Flash movie file would be corrupt for some users. If this happens to you, please try disabling and reinstalling the plugin (through FTP).
* Please try using the 'compatibility mode' if you're using version 1.20 or better. Although it's better to fix whatever is causing the issues with the normal mode, this can be used as a workaround solution.

= Hey, but what about SEO? =
I'm not sure how beneficial tag clouds are when it comes to SEO, but just in case WP Cumulus outputs the regular tag cloud (and/or categories listing) for non-flash users. This means that search engines will see the same links. They're hidden through CSS by default, but there's an options to make them visible.

= I'd like to change something in the Flash movie, will you release the .fla? =
As of  version 1.12 the source code is available from wordpress.org under the GPL license. Click "other versions" and get the developer version.

= Some of my tags occasionally hit the sides of the movie and are cropped =
If this happens you should change the aspect for the movie to make it wider. This can be done by increasing the width, but also by decreasing the height. Both will make the movie 'more landscape' giving long tags more room.

= Some characters are not showing up =
Because of the way Flash handles text, only Latin characters are supported in the current version. This is due to a limitation where in order to be able to animate text fields smoothly the glyphs need to be embedded in the movie. The Flash movie's source code is available for download through Subversion. Doing so will allow you to create a version for your language. There's a text field in the root of the movie that you can use to embed more characters. If you change to another font, you'll need to edit the Tag class as well.

More info [here](http://www.roytanck.com/2008/08/04/how-to-add-more-characters-to-wp-cumulus/).

= When I click on tags, nothing happens. =
This is usually caused by a Flash security feature that affects movies served from another domain as the surrounding page. If your blog is http://yourblog.com, but you have http://www.yourblog.com listed as the 'WordPress address' under Settings -> General this issue can occur. In this case you should adjust this setting to match your blog's actual URL. If you haven't already, I recommend you decide on a single URL for your blog and redirect visitors using other options. This will increase your search engine ranking and in the process help solve this issue :).

= I'm not using WordPress... =
* Steve Springett has ported this to Movable Type. More info over on [his site](http://www.6000rpms.com/blog/2008/04/04/flash-tag-cloud-for-mt-4.html).
* Michael Robinson has ported WP-Cumulus to RapidWeaver, see his tutorial [here](http://pagesofinterest.net/mikes/blog_of_interest_files/tag_cloud.php).
* Amanda Fazani managed to get Cumulus working on Blogger. More info on Blogumus [here](http://www.bloggerbuster.com/2008/08/blogumus-flash-animated-label-cloud-for.html).
* Yannick Lejeune has done a [TypePad version](http://www.yannicklejeune.com/2008/09/tumulus-wp-cumu.html) based in part on Steve's work.
* Christian Philipp's created a [TYPO3 version](http://typo3.org/extensions/repository/view/t3m_cumulus_tagcloud/current/).
* Rob Antonishen did a [Serendipity version](http://spartacus.s9y.org/index.php?mode=bygroups_event_en) (search for serendipity\_event\_freetag).
* Big Bear maintains the [Joomla version](http://joomlabear.com/Joomulus/).
* Pratul Kalia and Björn Jacob have ported it to [Drupal](http://drupal.org/project/cumulus).
* Ryan Tomlinson has a [BlogEngine.NET version](http://www.99atoms.com/post/BlogCumulusNET-A-flash-based-tag-cloud.aspx).
* Colin Seymour has created a [Habari version](http://www.lildude.co.uk/projects/hb-cumulus/).
* Andreas Scherer uses [DasBlog](http://www.scherer.as/blog/).
* Jean-Yves Zinsou did an [eZ version](http://ez.no/developer/contribs/applications/ezcumulus).
* [Simple Tags](http://utilitees.silenz.org/index.php/notes/page/simple-tags-1.6.3/), an Expression Engien addon can now display tags using Cumulus. Thanks Oliver Heine.
* Catchpen ported Cumulus to [Social Web CMS](http://forums.socialwebcms.com/index.php?topic=672.0).
* Domi create a [PHP-Fusion](http://www.venue.nu/forum/viewthread.php?thread_id=672) port.
* [Bysoft](http://www.bysoft.fr/) did a [Magento](http://www.magentocommerce.com/extension/925/3d-advanced-tags-clouds-based-on-wp-cumulus--admin-manager-by-bysoft) version.
* Benjamin Anseaume created a [Sweetcron](http://www.anseaume.com/items/site/anseaume.com) version.
* I wrote [this post](http://www.roytanck.com/2008/05/19/how-to-repurpose-my-tag-cloud-flash-movie/) on how to use the flash movie in other contexts.

This list is far from complete. Chances are you'll find the port you need through search engines. If you're having trouble setting it up, please contact the author(s) of the port.

== Screenshots ==

1. The tag sphere. You can set colors that match your theme on the plugin's options page.
2. The options panel.
3. There's a separate one for the widget.

== Options ==

The options page allows you to change the Flash movie's dimensions, change the text color as well as the background.

= Width of the Flash tag cloud =
The movie will scale itself to fit inside whatever dimensions you decide to give it. If you make it really small, chances are people will not be able to read less-used tags that are further away. Anything up from 300 will work fine in most cases.

= Height of the Flash tag cloud =
Ideally, the height should be something like 3/4 of the width. This will make the rotating cloud fit nicely, while the extra width allows for the tags to be displayed without cropping. Western text is horizontal by nature, which is why the ideal aspect is slightly landscape even though the cloud is circular.

= Color of the tags =
Type the hexadecimal color value you'd like to use for the tags, but not the '#' that usually precedes those in HTML. Black (000000) will obviously work well with light backgrounds, white (ffffff) is recommended for use on dark backgrounds. Optionally, you can use the second input box to specify a different color. When two colors are available, each tag's color will be from a gradient between the two. This allows you to create a multi-colored tag cloud. The third input box lets you specify a mouseover highlight color.

= Background color =
The hex value for the background color you'd like to use. This options has no effect when 'Use transparent mode' is selected.

= Use transparent mode =
Turn on/off background transparency. Enabling this might cause issues with some (mostly older) browsers.

= Rotation speed =
Allows you to change the speed of the sphere. Options between 25 and 500 work best.

= Distribute tags evenly on sphere =
When enabled, the movie will attempt to distribute the tags evenly over the surface of the sphere.

= Display =
Choose whether to show tags only, categories only, or both mixed together. Choosing 'both' can result in 'duplicate tags' if you have categories and tags with the same name. These words will appear twice, with one linking to the tag and the other to the category overview.

= wp tag cloud parameters = 
This setting allows you to pass parameters to the wp\_tag\_cloud function, which is used to fetch the tag cloud. Use caution with this setting. Everything you enter will be passed to the function. Be sure to read the function's manual. Please also note that these parameters affect tags only. If you've chosen to show categories or both, the category 'tags' will not be affected.


== Changelog ==

= 1.23 =
* Patches a potential XSS vulnerability (thanks to MustLive for alerting me to this).
* Updates the credits to reflact that WP-Cumulus is now a team effort.
* Implements the new changelog standard in the readme file.

= 1.22 =
* Fixes some minor HTML issues in the 'compatibility mode'.
* Patches a potential XSS vulnerability (thanks to Thomas Scholz for alerting me to this).

= 1.21 =
* Adds an option to show the regular tag cloud to non-flash users (used to be hidden through CSS).
* The widget title is now optional.
* Adds support for 'target' attribute to the Flash movie.
* XML path can now be set through a flashvar.
* Fixed markup errors in the compatibility mode.
* Several minor fixes.

= 1.20 =
* Adds a 'compatibility mode' which uses a simpler, non-javascript, way of embedding the Flash.
* Adds proper shortcode support (See [here](http://www.roytanck.com/2009/03/11/how-to-use-wp-cumulus-shortcodes/) for more info)
* Adds Turkish language support to the Flash movie.
* Improves the plugin's default settings.

= 1.19 =
* Fixed the mouse pointer not changing to a hand when hovering tags.
* Flash code cleanup

= 1.18 =
* Adds the ability to override individual tag colors when using the movie outside of WordPress (since WordPress has no color setting for tags).
* Improves mouse detection in transparent mode
* Fixes a bug affecting blogs with the admin using https.

= 1.17 =
* Fixes an issue with localized style sheet point sizes (e.g. 9,55pt instead of 9.55pt)
* Adds an optional highlight color setting

= 1.16 =
* Fixes an issue with categories being rendered black when all of them have the same number of posts.
* Reduces the default font size (from the biggest possible to "medium") in that same situation.
* Significantly reduces CPU load when the cloud isn't moving.

= 1.15 =
* Adds the possibility to create a multi-colored tag cloud by entering a second tag color.

= 1.14 =
* Fixes an issue where no tags are displayed when viewing the movie locally in MSIE.
* Fixes an issue where one random tag would not be displayed.

= 1.13 =
* No longer breaks when the wp-content folder is moved to a non-standard location.

= 1.12 =
* First version hosted on WordPress.org, and released under GPL license.
* Uses the Arial font to avoid font licensing issues.

= 1.11 =
* Restores an earlier fix for IE to force loading of the Flash movie.

= 1.1 =
* Complete rewrite of the Flash movie (Actionscript 3, requires Flash Player 9 or better).
* Better mouse detection.
* Adds option to distribute the tags evenly over the sphere.
* Adds support for categories.
* Adds the ability to pass parameters to the WordPress wp_tag_cloud function.
* Several smaller enhancements.

= 1.05 =
* Fixes several issues with IE, including an issue where it was impossible to use the regular version and the widget on the same page. Thanks to Fadi for alerting me to these.

= 1.04 =
* Fixes the 'it kills my blog' error for people using PHP 5.2 or newer. Thanks to Mujahid for helping me debug this.
* Speed improvements in the Flash code.

= 1.03 =
* Removes the wp_head hook in yet another attempt to fix issues with some other plugins and themes.
* Reduces system overhead by storing less options.
* Adds setting for speed.
* Adds a widget with seperate options (size, colors, speeds, etc).
* Attemps to detect when the mouse leaves the movie, reducing the 'spinning, but not out of control' effect.
* Several minor fixes.

= 1.02 =
* Fixes issues with sites not loading after activation, reduces server load and fixes lost spaces in tags. Thanks to Dimitry for helping me debug these issues.

= 1.01 =
* Fixes an issue where the cloud would spin out of control when the browsers loses focus on OSX.

= 1.00 =
* Initial release version.
