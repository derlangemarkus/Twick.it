<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Twick.it-Counter</title>
<script type="text/javascript" src="html/js/scriptaculous/lib/prototype.js"></script>
<script type="text/javascript" src="html/js/scriptaculous/src/scriptaculous.js"></script>
<script type="text/javascript">
function updateCounter() {
	new Ajax.Request(
		"proxy.php", 
		{
			method: 'GET',
		  	onSuccess: function(transport) {
				$("counter").update($("tmp").innerHTML);
				$("counter").show();
				$("tmp").hide();
				var stats = transport.responseText.evalJSON(true);
				if (stats.numberOfTwicks != $("tmp").innerHTML) {
				    $("tmp").update(stats.numberOfTwicks);
				    document.title = "Twick.it-Counter (" + stats.numberOfTwicks + ")";
				    new Effect.Appear("tmp");
				    new Effect.Fade("counter");
				}
			    window.setTimeout("updateCounter()", 2000);
	  		}	
		}
	);
}
</script>
<style type="text/css">
div {
	position:absolute;
	font-size:300px;
}

body {
    background-image:url(http://twick.it/html/img/hg.jpg);
    font-family: Trebuchet MS,Arial,Tahoma,Verdana,Helvetica;
    color:#FFF;
}

br {
    clear:both;
}

a {
    color:#FFF;
}
</style>
</head>
<body onload="updateCounter()">
	Dies ist ein simples Beispiel, das den Einsatz der <a href="http://twick.it/blog/api" target="_blank">Twick.it API</a> demonstriert. <br />
    Es zeigt die Anzahl von Twicks, aktualisiert sich alle 2 Sekunden von alleine und kann <a href="counter.zip">hier heruntergeladen</a> werden.
    <br />

    <div id="tmp" style="display:none;"><span style="font-size:100px;">Bitte warten...</span></div>
	<div id="counter"><span style="font-size:100px;">Bitte warten...</span></div>
    <br />
    
</body>
</html>