<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Twick.it</title>
	<meta property="og:title" content="<?php loc('404.title') ?>" />
    <meta name="description" content="<?php loc('404.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
	<style type="text/css">
		body {
			margin: 0;
			padding: 0;
			background-color: #ffffff;
			color: 000000;
        } 
		
		img {
			position: absolute;
			margin-left: -400px;
			margin-top: -350px;
			left: 50%;
			top: 50%;
			background-color: #ffffff;
			color: #000000;
			border:0px;
        } 
		a {
			text-decoration: none:
		}
	</style>
	<script type="text/javascript">
		function center() {
		}
	</script>
</head>

<body onload="center()">
	<a href="http://twick.it"><img src="html/img/logo_gross.jpg" id="logo"/></a>
	

</body>
</html>
