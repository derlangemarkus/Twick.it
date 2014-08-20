<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <base href="http://twick.it/" />
        <title>Twick.it - Die Erklärmaschine im Netz</title>
        <meta name="description" content="Twick.it - Die Erklärmaschine im Netz" />
        <meta name="keywords" content="Erklärung, Lexikon" />
        <meta name="language" content="de" />

        <meta name="robots" content="index,follow" />
        <meta name="revisit-after" content="1 days" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link title="Twick.it Search" rel="search" type="application/opensearchdescription+xml" href="interfaces/browser_plugins/twickit-search.xml" />

        <link href="html/css/twick-styles.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="http://static.twick.it/html/js/scriptaculous/lib/prototype.js"></script>

        <script type="text/javascript" src="http://static.twick.it/html/js/scriptaculous/src/scriptaculous.js?load=effects"></script>
        <!--[if IE]>
	    <script type="text/javascript" src="http://static.twick.it/html/js/png.js"></script>
		<![endif]-->
        <script type="text/javascript">
            var numberOfTopics = 6;
            var correct;

            function init() {
                $("question").update("Bitte warten... <img src='html/img/ajax-loader.gif' />")

                var theTime = new Date();
                new Ajax.Request(
                    "extern/quiz/proxy.php?nocache=" + theTime.getTime() +"&limit=" + (numberOfTopics+1),
                    {
                        method: 'GET',
                        onSuccess: function(transport) {
                            var info = transport.responseText.evalJSON(true);

                            var title = info.topics[0].topic.title;
                            title = title.replace(/\(.*\)/, "");
                            $("question").update("Welche ist die richtige Erklärung von &quot;" + title + "&quot;?");
        
                            var twicks = new Array();
                            for(var i=0; i<=numberOfTopics; i++) {
                                twicks[i] = info.topics[i].topic.twick.text;
                            }

                            correct = 1+Math.floor(Math.random() * numberOfTopics);
                            twicks[correct] = info.topics[0].topic.twick.text;
                            $("content").update("");
                            for(i=1; i<=numberOfTopics; i++) {
                                $("content").innerHTML +=
                                    '<div class="homepage-teaser" style="padding:10px;width:245px;height:140px;cursor:pointer;" id="answer' + i + '" onclick="showResult(' + i + ');"><div class="zahl">' + i + '</div><div class="text">' +
                                    twicks[i] +
                                    '</div></div>';
                            }
                            $("content").innerHTML += '<br style="clear:both;"/>';
                        }
                    }
                );
            }


            function showResult(inIndex) {
                $("answer" + correct).style.backgroundColor = '#6F6';
                $("answer" + correct).style.backgroundImage = 'none';

                if (inIndex == correct) {
                    msg = "Richtig!";
                } else {
                    msg = "Leider falsch.";
                }

                $("question").update("<a href='javascript:;' onclick='init();'>" + msg + " Noch eine Frage</a>");
                $("question").pulsate();
            }
        </script>
    <style type="text/css">
        #showTwick, #showTopic, #next {
            float:right;
            margin-top:8px;
        }
    </style>
    </head>
    <body onload="init()">
        <div class="website">
            <div class="main" id="main">
                <!-- Header | START -->
                <!-- Login-Bereich | START -->
                <div class="header-login">
                    <div class="anmelde-status">Eine Spielerei von <a href="http://twick.it">Twick.it, der Erklärmaschine</a></div>
                </div>
                <!-- Login-Bereich | ENDE -->

                <!-- Suchfeld oder Wissensbaum | START -->
                <div class="header-suchfeld" id="header-suchfeld" style="height:80px;background-position: 740px 20px;">
                    <div class="suchnavigation">
                        <br />
                        <div class="clearbox"></div>
                    </div>
                </div>
                <!-- Suchfeld oder Wissensbaum | ENDE -->

                <!-- Header | ENDE -->

                <div id="contentFrame">
                    <div class="header-ergebnisfeld" id="header-ergebnisfeld">
                        <h1 id="question">Twick.it-Quiz</h1>
                    </div>

                    <!-- Content-Bereich | START -->
                    <div class="content">

                        <!-- Linke Haelfte | START -->
                        <div id="content" class="inhalte-links" style="width:920px;background-color:#EFEFEF;">
                           
                        </div>
                        <!-- Linke Haelfte | ENDE -->


                        <div class="clearbox"></div>
                    </div>
                    <!-- Content-Bereich | ENDE -->
                </div>

                <!-- Footer | START -->
                <div class="footer">
                    <div class="print">
                        <a href='http://twick.it'>Twick.it</a>            	            </div>
                    <div class="metanavi">
                        <p>
                            <a href="http://twick.it/blog/de/faq/" title="FAQ">&gt;&nbsp;FAQ</a>
                            <a href="http://twick.it/blog/de/twick.it-charta/" title="Charta">&gt;&nbsp;Charta</a>
                        </p>
                        <p>
                            <a href="http://twick.it/blog/de/api/" title="API Dokumentation">&gt;&nbsp;API Dokumentation</a>
                            <a href="http://twick.it/blog/de/category/tipps4twicks/" title="Tipps4Twicks">&gt;&nbsp;Tipps4Twicks</a>
                        </p>
                        <p>
                            <a href="http://twick.it/blog/de/twitter/" title="Twitter">&gt;&nbsp;Twitter</a>
                            <a href="http://twick.it/support.php" title="Support">&gt;&nbsp;Support</a>
                        </p>
                        <p>
                            <a href="http://twick.it/blog/de/agb/" title="AGB">&gt;&nbsp;AGB</a>
                            <a href="http://twick.it/blog/de/impressum/" title="Impressum">&gt;&nbsp;Impressum</a>
                        </p>
                        <p>
                            <a href="http://twick.it/blog/de/presse/" title="Presse">&gt;&nbsp;Presse</a>
                            <a href="http://m.twick.it" title="Mobile Webseite">&gt;&nbsp;Mobile Webseite</a>
                        </p>
                    </div>
                </div>
                <!-- Footer | ENDE -->
            </div>

            <div class="clearbox"></div>
        </div>
		<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-9717715-1");
_gat._anonymizeIp();
pageTracker._trackPageview();
} catch(err) {}</script>

    </body>
</html>