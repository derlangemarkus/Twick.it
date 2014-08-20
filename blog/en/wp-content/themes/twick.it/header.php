<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
require_once("../../base/util/inc.php"); 
$activeTab = "blog";

setLanguage("en", true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo(HTTP_ROOT) ?>/" />
    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?> | Twick.it</title>
    <meta name="description" content="<?php wp_title('&laquo;', true, 'right'); ?>" />   
    <meta name="keywords" content="<?php echo($title) ?>" />
    <meta name="language" content="<?php echo(getLanguage()) ?>" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    
    <meta name="og_title" property="og:title" content="<?php wp_title('', true, 'right'); ?>" />
	<meta name="og_site_name" property="og:site_name" content="Twick.it" />
	<meta property="fb:admins" content="1271153241"/>
    
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php wp_head(); ?>
	
    <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="html/js/twickit/twickit_twick_js.php"></script>
	<!--[if IE]>
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/html/js/png.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo(STATIC_ROOT) ?>/interfaces/js/insert_links/twickit.js"></script>
</head>
<body>
	<?php include(DOCUMENT_ROOT . "/inc/inc_header.php"); ?>
	
    <div id="contentFrame">

			<!-- end header -->
