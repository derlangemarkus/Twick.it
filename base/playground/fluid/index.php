<?php require_once("../../util/inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Twick.it-App für OS X</title>
<link rel="shortcut icon" href="http://twick.it/favicon.ico" type="image/x-icon"/>
<style type="text/css">

body {
    background-image:url(http://twick.it/html/img/hg.jpg);
    font-family: Trebuchet MS,Arial,Tahoma,Verdana,Helvetica;
    color:#FFF;
	margin: 0;
	padding: 0;
	font-size: 90%;
	line-height: 180%;
}

#wrapper {
	width: 720px;
	margin: 0 auto;
	padding: 10px 20px;
	background: rgba(0,0,0,0.25);
	-moz-border-radius-bottomleft: 10px;
	-moz-border-radius-bottomright: 10px;
	-webkit-border-bottom-left-radius: 10px;
	-webkit-border-bottom-right-radius: 10px;
	text-shadow: 0px 1px 2px rgba(0,0,0,1);
}

#copyright {
	width: 720px;
	margin: 0 auto;
	color: rgba(0,0,0,0.5);
	font-size: 12px;
}
#copyright a {
	color: rgba(0,0,0,0.5);
}

#sidebar {
	float:right;
	width: 300px;
	margin: 0 0 20px 20px;
}
#sharer {
	margin: 20px 0;
}
.box {
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	background: rgba(255, 255, 255, 0.5);
	padding: 10px;
	color: rgba(0,0,0,0.75);
	text-shadow: 0px 1px 2px rgba(255,255,255,1);
}
.box h3 {
	margin: 3px 0;
	text-shadow: 0px 1px 2px rgba(255,255,255,1);
}

h1 {
	text-shadow: 1px 2px 2px rgba(0,0,0,0.75);
	margin-bottom: 25px;
	font-size: 200%;
}

h2 {
	color: rgba(0,0,0,0.9);
	text-shadow: 0px 0px 15px rgba(255,255,255,1);
	font-size: 130%;
}

h3 {
	color: rgba(0,0,0,0.9);
	text-shadow: 0px 0px 5px rgba(255,255,255,1);
	font-size: 110%;
	font-weight: bold;
}

a {
    color:#FFF;
}

li {
	line-height: 150%;
}

big {
	font-size: 120%;
	text-shadow: 0px 1px 2px rgba(0,0,0,1);
}

a.button {
background: #222 url(alert-overlay.png) repeat-x;
display: inline-block;
padding: 8px 10px 6px;
color: #fff;
text-decoration: none;
font-weight: bold;
line-height: 1.5;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
-moz-box-shadow: 0 0px 15px rgba(255,255,255,1);
-webkit-box-shadow: 0 0px 15px rgba(255,255,255,1);
text-shadow: 0 -1px 1px rgba(0,0,0,0.25);
border-bottom: 1px solid rgba(0,0,0,0.25);
position: relative;
cursor: pointer;
font-size: 16px;
}
a.button:hover { background-color: #111; color: #fff; }
a.button:active	{ top: 1px; left: 1px;}
a.button img { 
	float: left;
	display: block;
	padding: 0 10px 0 0;
	border: none;
}
a.button small {
	color: #aaa;
	font-weight: normal;
	font-size: 70%;
	white-space: nowrap;
}

</style>
</head>
<body>
	<div id="wrapper">
		<h1>Twick.it für Mac OS X</h1>
		
		<div id="sidebar">
			<a href="http://fluidapp.com/" target="_blank" class="button" style="width:280px">
				<img src="fluid.jpg" alt="" />
                Fluid kostenlos herunterladen<br />
                <small>Hier geht es zu fluidapp.com</small>
			</a>
			<div id="sharer">
				<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Ftwick.it%2Fplayground%2Ffluid%2F&amp;layout=button_count&amp;show_faces=false&amp;width=160&amp;font=arial" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:160px;height:23px;" allowtransparency="true"></iframe>
				<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://twick.it/playground/fluid/Twick.it.zip" data-count="horizontal" data-via="TwickIt" data-related="twickit_de" data-lang="de">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
			</div>
			<div class="box">
				<h3>Installation</h3>
				<ol>
					<li>Fluid herunterladen und öffnen</li>
                    <li>Die URL http://m.twick.it umwandeln und unter <i>Applications</i> ablegen</li>
                    <li>Twick.it aus dem Programme-Ordner starten</li>
                    <li>Über den Menüpunkt <i>Twick.it &gt; Covert to MenuExtra SSB</i> im Statusmenü verankern</li>
				</ol>
				<h3>Deinstallation</h3>
				<p>Einfach <i>Twick.it-App</i> im Ordner <i>/Applications</i> löschen</p>
			</div>
		</div>
		
		
		<h2>Funktionen</h2>
		Mit Fluid kannst du Twick.it zu einem Programm für Mac OS X umwandeln. 
        Mit dem Programm hast du dann jederzeit Zugriff auf Twick.it. Dazu einfach auf das Icon
        oben rechts in der Status-Leiste klicken und Twick.it nutzen.<br />
		
		<h2>Und so sieht's dann aus</h2>
		<iframe title="YouTube video player" width="400" height="255" src="http://www.youtube.com/embed/ynlxkS0ACX0" frameborder="0" allowfullscreen></iframe>
		
		<div style="clear:both"></div>
	</div>
	
	<div id="copyright">
		Mit Unterstützung von Twick.it-User <a href="http://twick.it/user/simon">Simon</a>. Alle Inhalte <a href="http://creativecommons.org/licenses/by/3.0/de/">CC BY</a>. <a href="http://twick.it/blog/de/impressum/">Impressum</a>
	</div>
</body>
</html>