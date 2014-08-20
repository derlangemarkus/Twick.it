<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Twicktionary – Das Twick.it-Lexikon für OS X</title>
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
.twitter-share-button{padding-left:10px;}

</style>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-9717715-1']);
_gaq.push(['_gat._anonymizeIp']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
</head>
<?php
clearstatcache();
$version = '';
$size = '';
foreach (glob("*.dmg") as $filename) {
	if (!$version || $version < filemtime($filename)) {
		$version = 'v' . date("Y.m.d", filemtime($filename));
		$size = number_format(round((filesize($filename) / 1000 / 1000), 1), 1, ',', '.');
		$file = $filename;
	}
}
?>
<body>
	<div id="wrapper">
		<h1>Twicktionary – Das Twick.it-Lexikon für OS X</h1>
		
		<div id="sidebar">
			<a href="http://dict.twick.it/<?php echo $file ?>" class="button" style="width:280px">
				<img src="icon_dictionary.png" alt="" />
				Twicktionary herunterladen<br />
				<small><strong><?php echo $version ?></strong> | <?php echo $size ?> MB | Mac OS X 10.5-10.6</small>
			</a>
			<div id="sharer">
				<?php $url = "http://dict.twick.it"; ?>
				<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($url); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=400&amp;font=arial" scrolling="no" frameborder="0" style="border:none;overflow:hidden;width:80px;height:20px;float:left;margin-right:20px;" allowTransparency="true"></iframe>					
				<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo($url) ?>" data-count="horizontal" data-via="TwickIt" data-related="twickit_de" data-lang="de">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
				<div style="padding-top:2px;margin-left:1px;width:65px;display:inline-block;float:left;"><g:plusone size="small"></g:plusone></div>

			</div>
			<div class="box">
				<h3>Installation</h3>
				<ol>
					<li>DMG-Datei herunterladen und aktivieren</li>
					<li>Installationspaket mit Doppelklick starten</li>
					<li>Lexikon (Dictionary.app) starten</li>
					<li>Twicktionary im Lexikon unter Einstellungen aktivieren.</li>
				</ol>
				<h3>Deinstallation</h3>
				<p>Einfach <i>Twicktionary.dictionary</i> im Ordner <i>/Library/Dictionaries</i> oder <i>~/Library/Dictionaries</i> löschen</p>
			</div>
		</div>
		
		<p><big>Twicktionary ist ein Plugin für Apples <a href="http://www.apple.com/de/macosx/what-is-macosx/apps-and-utilities.html#dictionary">Lexikon</a> (Dictionary.app) mit allen Erklärungen aus <a href="http://twick.it/">Twick.it</a>.</big></p>
		
		<h2>Funktionen</h2>
		<ul>
			<li>Alle Themen offline verfügbar</li>
			<li>Alle Erklärungen (Twicks) zu einem Thema</li>
			<li>Verwandte Themen finden</li>
			<li>Gravatare an- und ausschaltbar</li>
			<li>Update-Check</li>
		</ul>
		
		<h2>Häufig gestellte Fragen (FAQ)</h2>
		<h3>Was kann ich mit dem Lexikon alles machen?</h3>
		<iframe title="YouTube video player" width="400" height="255" src="http://www.youtube.com/embed/dYRJsfNlyU4" frameborder="0" allowfullscreen></iframe>
		<p>Wolfgang Reszel hat ebenfalls eine gute <a href="http://www.tekl.de/deutsch/Tipps.html">Sammlung an Tipps zum Apple-Lexikon</a> zusammengestellt.</p>
		<h3>Wie deinstalliere ich Lexikon-Plugins?</h3>
		<p>Die Lexikon-Plugins werden in das Verzeichnis /Library/Dictionaries installiert. Es genügt also, dort den entsprechenden Ordner zu löschen. Dazu sollte zuvor das Lexikon-Programm beendet werden. Um auch den Papierkorb entleeren zu können ist aber ein Neustart nötig. Alternativ kann auch der Prozesses DictionaryPanel über das Dienstprogramm Aktivitätsanzeige beendet werden.</p>

<?php /*
		<h2>Changelog</h2>
		<ul>
			<li>
				<strong>v2011.01.24</strong>
				<ul>
					<li>9670 Themen mit 11467 Twicks</li>
					<li>Anführungszeichen in Twicks werden korrekt dargestellt.</li>
					<li>Twick.it-Logo verkleinert</li>
					<li>Verbesserte Update-Überprüfung</li>
				</ul>
			</li>
			<li>
				<strong>v2011.01.22</strong>
				<ul>
					<li>9590 Themen mit 11377 Twicks</li>
					<li>Erste Version</li>
				</ul>
			</li>
		</ul>
*/ ?>
		
		<div style="clear:both"></div>
	</div>
	
	<div id="copyright">
		Erstellt von Twick.it-User <a href="http://twick.it/user/simon">Simon</a>. Alle Inhalte <a href="http://creativecommons.org/licenses/by/3.0/de/">CC BY</a>. <a href="http://twick.it/blog/de/impressum/">Impressum</a>
	</div>
	<script type="text/javascript" src="http://apis.google.com/js/plusone.js">
  		{lang: 'de'}
	</script>
</body>
</html>