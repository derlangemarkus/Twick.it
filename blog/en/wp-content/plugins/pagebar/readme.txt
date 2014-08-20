=== pagebar ===
Contributors: Lutz Schroeer
Donate link: http://elektroelch.de
Tags: navigation, navi, page, comments
Requires at least: 2.7
Tested up to: 3.01
Stable tag: trunk

Pagebar adds a nice page bar to your blog posts, multipaged posts and paged comments.

== Description ==

Pagebar adds a nice page bar to your blog posts, multipaged posts and paged comments:
 <center><img src="http://elektroelch.de/hacks/wp/pagebar/wp-content/uploads/2009/04/pagebar.jpg" ></center>

== Features ==

* Optional automatic insertion if page on all post pages (blog, search, tags, ...)
* Full control of pagebar by manual insertion into the templates.
* Better pagination for multipaged posts and pages
* "Display all" link for multipaged posts.
* Extremely customizable.
* Compatible with WordPress v2.9, 3.01 and WordPress nightly.

== Installation ==

* Make sure you have PHP 5 installed, which is required for this plugin!!!

* Copy files
Unpack the archive and copy the files into a directory called "pagebar" in
your plugin directory (usually .../wp-content-plugins/). Copy the file "pagebar.css"
into your themes directory or copy the content to the theme's "style.css" file.

* Adding postbar to your blog posts
There are two ways of inserting postbar into you blog:
     - automatic
     - manual

+ Automatic installation
If you have a simple blog (e.g. the default theme) you can easily add postbar by selecting “Automagic insertion” in the options page. Then you can select where you want the postbar to appear:
     - Front of postings
     - Behind postings
     - Footer

+Manual installation
If the automatic insertion is not suitable for your blog because your theme has more than one posting loop you can add postbar manually to your blog by editing some of your themes files. Simply add the following code directly behind The Loop in your index.php and search.php:

        `if (function_exists('postbar'))
            postbar();`

Of course you may want to configure postbar to your needs using the option page and by editing the pagebar.css style file.


* Adding pagebar to your multipaged posts
This pagebar can not be displayed automatically so you have to edit the file "page.php". If your theme contains the standard navigation for multipaged posts you first have to delete the following code:

     `wp_link_pages(array('before' => '<p><strong>' .
     __('Pages:', 'kubrick') . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));`

(The code does not have to look necessarily exactly the same, this example is from the WordPress default theme.) Then you can add the multipagebar to your pages:

        `if (function_exists('multipagebar'))
            multipagebar();`
You can customize the display of your multipagebar by editing the settings in the Multipagebar tab on the pagebar option page.


* Adding pagebar to your paged comments
This pagebar can not be added automatically (there is no action indicating the end of the comment loop) so you have to edit the file "comments.php". If your theme contains the standard navigation for paged comments you first have to delete the following code:

     <div class="navigation">
       <div class="alignleft"><?php previous_comments_link() ?></div>
       <div class="alignright"><?php next_comments_link() ?></div>
     </div>

(The code does not have to look necessarily exactly the same, this example is from the WordPress default theme.) Then you can add the commentbar to your pages:

        `if (function_exists('commentbar'))
            commentbar();`



* Upgrading from earlier versions
Important: the old "pagebar()" function has been renamed to "postbar()" since this seems to describe its function better. Nevertheless the old "pagebar()" function is and will be an alias.

pagebar v2.5+ introduces a new database structure for its settings. Formerly there was only one entry in "wp_options" called "pagebar". Since there are now three different pagebars ("postbar", "commentbar" and "multipagebar"), the options are splitted into three entries ("postbar", "commentbar" and "multipagebar" respectively).<br/>
After installation (either through WordPress update or manually per FTP) pagebar copies the settings stored in "pagebar" to the new "postbar" entry and sets "commentbar" and "multipagebar" to inherit the settings so everything should look fine without manual interference. The "commentbar" and "multipagebar" have to be installed manually though.

== The option pages==
The option page is devided into three tabs (postbar, multipagebar, commentbar) for the three different pagebar types.  You need to have Javascript enabled in your browser for the option page to work! They all share some basic settings and got some specific settings, explained in the next chapters.

-- Shared basic settings --

+ Left
Number of links displayed on the left of the bar. If this number is 0 no left links are displayed at all.

+ Center
The number of links displayed in the middle of the bar. This should be an odd number. If an even number is entered, pagebar will display one more link than entered. If this number is 0 no left links are displayed at all.

+Right
Number of links displayed on the right of the bar. if this number is 0 no right links are displayed at all.

+ Leading text
Text to be displayed in front of the bar. A space is automatically added after the text. You can use the tokens in this field.

+ Standard page
Text to be displayed on all pages but the current. You can use the tokens.

+ Current page
Text to be displayed on the current page. You can use the tokens.

+ First page
Text to be displayed for the first page.

+ Last page
Text to be displayed for the last page.

+ Connector
Text to be displayed between the left/center and center/right area. If left empty, "..." is displayed.

+ Previous
Text to be displayed for the link to the previous page. If left empty, "&lt;" is displayed. You can additionally define if the Previous link is always displayed, never displayed or if it is done automatically.

+ Next
Text to be displayed for the link to the previous page. If left empty, "&gt;" is displayed. You can additionally define if the Next link is always displayed, never displayed or if it is done automatically.

+ Tooltip text
Text to display in tooltips. You can use the tokens.

+ Display
Actually display tooltips?</td>

+ Stylesheet
You can define the necessary CSS definitions in two places:
	- in the style.css file of the current theme
	- in a seperate file in the current theme's directory. The name of the file can be defined here.


-- Specific pagebar settings --

+ Automatic insertion
If you would like to get pagebar inserted in the blog automatically you need to select this option and additionally the position where to insert pagebar (see next section).

+ Positioning
If you have selected automatic insertion you can select where to insert the pagebar:
     - Front of postings -> Front of first posting
     - Behind postings -> After the last posting
     - Footer -> In the footer (footer.php)
(If "Automatic insertion" is not selected these options are disbled.)

+ Integration
You can remove the standard wordpress navigation manually or by setting the "remove old navigation" checkbox.
Remove&nbsp;standard navigation:  Remove the standard navigation text of Wordpress. This only works if the author of your currently used theme hasn't changed the CSS class of the standard navigation (".navigation" that is).
(If "Automatic insertion" is not selected these options are disabled.)

-- Specific multipagebar settings --

+ Inherit settings
If you check this option all basic options will be inherited from the postbar settings. Additionally all these options are removed from the multipagebar settings tab.

+ All pages link
pagebar gives you the possibility to display all parts of a multipaged post. Checking this setting will add a link behind the pagebar allowing the user to display all parts.

+ All pages label
Text display for the "All pages link".


-- Specific commentbar options --

+Inherit&nbsp;settings
If you check this option all basic options will be inherited from the postbar settings. Additionally all these options are removed from the commentbar settings tab.


-- Tokens --
Tokens can be used in any display area of pagebar. If it makes sense where you want to use it, you have to decide by yourself.
{page}    -> Page number
{total}   -> Total number of pages
{current} -> Current page number


== Frequently Asked Questions ==
= How do I center pagebar? =
Simply edit style.css, pagebar.css, or whatever CSS file your defintions are stored:

   .pagebar {
   ...
     text-align: center;
   ...
   }

== Credits ==
+ Lester Chan for his initial idea for this plugin.
+ Lise of liseweb.fr for her French translation.
+ Michael Preu&szlig; for his " rel = nofollow " suggestion and for telling me not to include it!
+ Monika TS for making me aware of the multiple loops problem.
+ Mike of trash-wissen..de for pointing out the feed problem.
+ Joern of diekretschmars.de for his various comments and ideas.
+ Marco of mafia-daily.com for pointing out problem with theme editor.
+ Thomas (koehntopp.com) for his bug report on name collisions.

== Changelog ==
= 2.59 =
+ Added Dutch language file (thanks to Rene of WordPress Plugin Guide - http://wppg.me)
* Fixed some security issues (thanks to Rene - https://www.reneschmidt.de/)

= 2.58 =
* Fixed: Problems with custom taxonomies in WP3.0

= 2.57 =
* Fixed: Name collisions with other plugins (added 'pagebar_' to all global functions).

= 2.56 =
* Fixed: Theme editor problem in WordPress v2.9

= 2.55 =
* Fixed: function name collision with <a href="http://wordpress.org/extend/plugins/yet-another-related-posts-plugin/">YARPP</a>.
* Fixed: $_POST parameter collision with <a href="http://firestats.cc/">FireStat</a>.
* Added: contextual help

= 2.54 =
* Removed "display all comments" feature. "Break comments into pages" can be de-selected again.
* Fixed: settings where not correctly inherited by multipagebar and commentbar.
* Fixed: commentbar was displayed if only one page was present.

= 2.53 =
* Fixed: commentbar/multipagebar "all" link was not working correctly
* Fixed: Now compatible with PHP4

= 2.52 =
*fixed: non administrators could change settings

= 2.51 =
* Fixed: Function wp_remove_nav was missing.

= 2.50 =
* Total rewrite of code (introcduced classes)
* Added pagebar for paged comments (commentbar)
* Added pagebar for multipaged posts (multipagebar)
* Prevention of updates if WP &lt; v2.7 or PHP &lt; v5.0

= 2.22 = Added Belarussian translation. Thanks to Ilya of www.fatcow.com

= 2.21 =
* Fixed: {page} was not evaluated in "leading text" part (Thanks to Puh of http://blog.1n8.de/)

= 2.20 =
* Added: French language pack (Thanks to Lise of http://liseweb.fr/)
* Fixed: The label "Postitioning" could not be i18n-ized

= 2.19 =
* Fixed: own stylesheet textfield accessibilty restored

= 2.18 =
* Fixed: a debugging output was displaying
* Fixed: WP's new "auto update" feature created a directory called "pagebar". The
         plugin should now work with both directory names ("pagebar2" and "pagebar").

= 2.17 =
* Fixed: options are displayed correctly with short_open_tag turned off.

= 2.16 =
* Added: Detects installation directory

= 2.15 =
* Added: Support for internationalisation (i18n)
* Added: German language files
* Fixed: Hopefully last validation error in tooltips (Thanks again to mike of www.trash-wissen.de)

= 2.01 =
* Fixed: Standard navigation was not displayed on single post pages (thanks to Joern of diekretschmars.de)
* Fixed: Removed surplus double quote from title tags (thanks again to Joern)

= 2p4 =
* Fixed: previous and next links didn't display tooltips
* Fixed: custom stylesheet wasn't found in theme directory (thanks to Ufuk of www.ufukeskici.com)

= 2p3 =
* Fixed: Now works (again) with non-US-ASCII characters
* Fixed: Pagebar no longer appears in feeds (thanks to Mike of www.trash-wissen.de)

= 2p2 =
* Fixed: Unneccessary semicolon caused pagebar to be displayed on top of the postings every time
* Fixed: Missing type declaration in <style> declaration
* Fixed: Option page will no longer be available for non-admin users
* Thanks to Monika TS, A. Berger

= 2p1 =
* Total rewrite of code.
* Added GUI option page
* automatic insertion of pagebar instead of manuualy insertion
* much more options to modify pagebar
* much more...

= 1.3.2 =
* Added support for Simple Tagging module (http://http://trac.herewithme.fr/project/simpletagging/)
  (Thanks to CodeOne [http://coderone.de] and J.P. Jarolim)

= 1.3.1a =
* Fixed: Security problem concenring XSS (http://www.buayacorp.com/archivos/problemas-de-seguridad-con-wordpress-2x-y-el-plugin-pagebar/)

= 1.3.1 =
* Fixed: Works again with category pages
* Fixed: Wrong homepage URL

= 1.3 =
* Fixed: Compatibility with Wordpress v2.1
* Fixed: Corrected README (thanks to Alexander Geschonneck)

= 1.2 =
* Added: Previous and next strings definable
* Added: Ability to suppress direction links

= 1.1.1 =
* Fixed: some minor HTML bugs
* Fixed: should now be XHTML compliant (thanks to R. Borges for the error report)

= 1.1 =
* Added: direction arrows
* Added: tooltips
* Attention: parameter calls changed!

= 1.0 =
* Initial version.
