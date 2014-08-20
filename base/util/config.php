<?php
/*
 * Created at 16.05.2007
 *
 * @author Markus Moeller - Twick.it
 */
 
// Sprache
define("DEFAULT_LANGUAGE", "de");						// Standard-Sprache
global $languages;
$languages = 											// Liste aller vorhandenen Sprachen
	array(
		array("name"=>"Deutsch", "code"=>"de"),
		array("name"=>"English", "code"=>"en")
	);	
 
// Debugging
define("DISPLAY_ERRORS", 1);   	            		    // Fehleranzeige an/aus
define("ENABLE_DEBUG", false);							// Schaltet Debug-Ausgaben an/aus
define("CACHE_LOGGING", false);							// Schaltet Debug-Meldungen des Caches an/aus
define("SQL_DEBUG", false);     	               		// Ausgabe der SQL-Statements

// Datenbank
define("DB_HOSTNAME", "localhost");						// Datenbank-URL
define("DB_DATABASE", "twickit");						// Datenbank-Name
define("DB_USERNAME", "db-twick");						// Datenbank-Login
define("DB_PASSWORD", "xxxxxx");						// Datenbank-Passwort
//define("DB_USERNAME", "root");						// Datenbank-Login
//define("DB_PASSWORD", "root");						// Datenbank-Passwort

// Blog-Datenbank
define("BLOG_DB_HOSTNAME", "localhost");				// Datenbank-URL
define("BLOG_DB_DATABASE", "blog");						// Datenbank-Name
define("BLOG_DB_USERNAME", "twickitblog");				// Datenbank-Login
define("BLOG_DB_PASSWORD", "xxxxxx");					// Datenbank-Passwort
define("BLOG_DB_POST", 329);                            // Datenbank-Passwort
define("BLOG_DB_INTERNPOSTS", 544);						// Datenbank-Passwort

// Cronjobs
define("CRON_LOGIN", "twickit");						// Cronjob-Benutzername
define("CRON_PASSWORD", "xxxxxx");				    	// Cronjob-Passwort

// Twitter
define("TWITTER_SSO_CONSUMER_KEY", "xxxxxx");			// OAuth-Consumer-Key von SSO-Twitter
define("TWITTER_SSO_CONSUMER_SECRET", "xxxxxx");      	// OAuth-Consumer-Secret von SSO-Twitter
define("TWITTER_CONSUMER_KEY", "xxxxxx");				// OAuth-Consumer-Key von Twitter
define("TWITTER_CONSUMER_SECRET", "xxxxxx");			// OAuth-Consumer-Secret von Twitter
define("TWITTER_TOPIC_DE_OAUTH", "xxxxxx");				// OAuth fuer twickit_de
define("TWITTER_TOPIC_DE_OAUTH_SECRET", "xxxxxx");		// OAuth-Secret fuer twickit_de
define("TWITTER_TOPIC_EN_OAUTH", "xxxxxx");				// OAuth fuer twickit_en
define("TWITTER_TOPIC_EN_OAUTH_SECRET", "xxxxxx");		// OAuth-Secret fuer twickit_en
define("TWITTER_TWICK_DE_OAUTH", "xxxxxx");				// OAuth fuer twick_de
define("TWITTER_TWICK_DE_OAUTH_SECRET", "xxxxxx");      // OAuth-Secret fuer twick_de
define("TWITTER_TWICK_EN_OAUTH", "xxxxxx");				// OAuth fuer twick_en
define("TWITTER_TWICK_EN_OAUTH_SECRET", "xxxxxx");		// OAuth-Secret fuer twick_en
define("TWITTER_TOPIC_FAME_OAUTH", "xxxxxx");			// OAuth fuer twickit_fame
define("TWITTER_TOPIC_FAME_OAUTH_SECRET", "xxxxxx");	// OAuth-Secret fuer twickit_fame
define("TWITTER_TOPIC_PODCAST_OAUTH", "xxxxxx"); 		// OAuth fuer twickit_podcast
define("TWITTER_TOPIC_PODCAST_OAUTH_SECRET", "xxxxxx"); // OAuth-Secret fuer twickit_podcast

// Facebook
define("FACEBOOK_APP_ID", "xxxxxx");					// ID der Facebook App
define("FACEBOOK_APP_SECRET", "xxxxxx");				// Secret der Facebook App

// Mail
define("SUPPORT_MAIL_RECEIVER", "help@twick.it");		// Empfaenger fuer Support-Anfragen
define("NOSPAM_MAIL_RECEIVER", "help@twick.it");		// Empfaenger fuer falschen Spam
define("USER_MAIL_SENDER", "noreply@twick.it");			// Absender der Mails an User
define("MAIL_RECEIVER", "markus@twick.it");				// Empfaenger der Mails-Anfragen


// Sonstiges
define("MIN_TWICKS_FOR_CLOUD", 1);
define("DISABLE_CACHE", false);
define("STATIC_SUBDOMAIN", "static.");
?>