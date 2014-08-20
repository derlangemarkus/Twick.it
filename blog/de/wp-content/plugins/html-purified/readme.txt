=== HTML Purified ===
Contributors: johnny5
Donate link: http://urbangiraffe.com/about/support/
Tags: xhtml, xss, spam, security, comments
Requires at least: 2.9
Tested up to: 3.1
Stable tag: 0.5

HTML Purified replaces the default comments filters with the more secure HTML Purifier.

== Description ==

HTML Purified replaces the default WordPress comments filters with HTML Purifier, a super HTML filtering
library.

> HTML Purifier is a standards-compliant HTML filter library written in PHP. HTML Purifier will
> not only remove all malicious code (better known as XSS) with a thoroughly audited, secure yet
> permissive whitelist, it will also make sure your documents are standards compliant, something
> only achievable with a comprehensive knowledge of W3C's specifications.

An additional feature of HTML Purifier is that it will produce valid well-formed XHTML code, something
which KSES does not do.

Features:

* Configurable KSES or HTML Purifier
* Configurable list of HTML elements and attributes for both KSES and HTML purifier
* Additionally process comments with HTML Tidy
* URL blacklist
* Fully localized (and awaiting translations)
* Automatically escape PHP or anything inside backticks

HTML Purifier is available in:

* English
* Spanish (thanks to José Cuesta
* Belorussian (thanks to Marcis Gasuns)
* Russian (thanks to Ilyuha)
* Uzbekistan (thanks to Alexandra Bolshova)
* Dutch (thanks to Pieter)
* German (thanks to Andreas Beraz)

== Installation ==

The plugin is simple to install:

1. Download `html-purified.zip`
1. Unzip
1. Upload html-purified directory to your `/wp-content/plugins` directory
1. Go to the plugin management page and enable the plugin
1. Configure the options from the `Options/HTML Purified` page

You can find full details of installing a plugin on the [plugin installation page](http://urbangiraffe.com/articles/how-to-install-a-wordpress-plugin/).

== Frequently Asked Questions ==

= Why would I want to replace the default WordPress filter? =

There is nothing fundamentally wrong with the way WordPress filters comments, and in fact there has been no security alert related to this. However, this doesn't detract from the desire to make things better, and the fact that HTML Purifier is much more thorough and exhaustive.

= Does this plugin also protect posts? =

Not currently, no, but it is planned for a future version

== Screenshots ==

1. Main options page allowing specific HTML tags
2. Specific configuration options for HTML Purifier

== Documentation ==

Full documentation can be found on the [HTML Purified](http://urbangiraffe.com/plugins/html-purified/) page.

== Changelog ==

= 0.2   = 
* Initial released version

= 0.2.1 = 
* Change cache directory
* Allow no tag
* Update HTML purifier to 2.0.1

= 0.2.2 = 
* Update HTML purifier to 2.1.1

= 0.2.4 = 
* Fix cache directory write error

= 0.2.5 = 
* Add Spanish localization

= 0.2.6 = 
* Add auto-escape PHP option
* Update to HTML purifier 2.1.2

= 0.2.7 = 
* Add option for bbcode-style tags
* Update to HTML Purifier 2.1.3

= 0.2.8 = 
* Now works in bbPress!

= 0.2.9 = 
* Update plugin library

= 0.3.0 = 
* HTML Purifier PHP4 2.1.5, PHP5 3.1.1 - WP 2.5.1

= 0.3.1 = 
* WP 2.6

= 0.3.2 = 
* Update base library

= 0.3.3 = 
* bbPress working again
* Clean up code

= 0.3.4 = 
* WP 2.8
* Support for syntaxhighlighter
* Fixes to backticks

= 0.3.5 =
* Add Uzbekistan
* Add Russian

= 0.4 =
* PHP5 only
* Update to HTML Purifier 4.2.0
* Add German
* Add Dutch
