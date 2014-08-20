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
        <script type="text/javascript" src="html/js/twickit/twickit_twick_js.php"></script>
        <!--[if IE]>
        <script type="text/javascript" src="http://static.twick.it/html/js/png.js"></script>
	<![endif]-->
        <script type="text/javascript">
            function nextTopic() {
                $("tags").update("<img src='html/img/ajax-loader.gif' /><br /><br />Bitte warten...")
                $("twick").hide();
                $("topic").hide();
                $("next").hide();

                var theTime = new Date();
                new Ajax.Request(
                "http://twick.it/extern/find-the-topic/proxy.php?nocache=" + theTime.getTime(),
                {
                    method: 'GET',
                    onSuccess: function(transport) {
                        var info = transport.responseText.evalJSON(true);

                        // Tags
                        var separator = "";
                        var t = "";
                        var tags = info.topics[0].topic.tags;
                        for(var i=0; i<tags.length; i++) {
                            t += separator + tags[i].tag;
                            separator = ", ";
                        }
                        $("tags").update("<h2>OK, hier ist der erste Tipp - die Tag-Cloud:</h2>" + t);

                        // Twick
                        $("twick").update("<h2>Und jetzt ein Twick:</h2><a href='" + info.topics[0].topic.twick.user.url + "' target='_blank'>" + info.topics[0].topic.twick.user.name + "</a>: <i>&quot;" + info.topics[0].topic.twick.text + "&quot;</i>");

                        // Topic
                        $("topic").update("<h2>Das gesuchte Thema lautet:</h2><a href='" + info.topics[0].topic.twick.url + "' target='_blank'><br />" + info.topics[0].topic.title + "</a>");

                        $("showTwick").show();
                    }
                }
            );
            }



            function showTwick() {
                $("twick").show();
                $("showTwick").hide();
                $("showTopic").show();
            }


            function showTopic() {
                $("topic").show();
                $("showTopic").hide();
                $("next").show();
            }

        </script>
    <style type="text/css">
        #showTwick, #showTopic, #next {
            float:right;
            margin-top:8px;
        }
    </style>
    </head>
    <body onload="nextTopic()">
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
                        <h1>Wir zeigen Tag-Cloud und einen Twick. Errätst du das Thema?</h1>
                    </div>

                    <!-- Content-Bereich | START -->
                    <div class="content">

                        <!-- Linke Haelfte | START -->
                        <div class="inhalte-links" style="width:920px;background-color:#EFEFEF;">
                            <div class="homepage-teaser" style="padding:10px;width:245px;height:140px;">
                                <div class="text" id="tags"></div>
                                <a href="javascript:;" onclick="showTwick()" id="showTwick" style="display:none">Zeige Twick &raquo;</a>
                            </div>

                            <div class="homepage-teaser" style="padding:10px;width:245px;height:140px;">
                                <div class="text" id="twick"></div>
                                <a href="javascript:;" onclick="showTopic()" id="showTopic" style="display:none">Auflösen &raquo;</a>
                            </div>

                            <div class="homepage-teaser" style="padding:10px;width:245px;height:140px;">
                                <div class="text" id="topic"></div>
                                <br />
                                <a href="javascript:;" onclick="nextTopic()" id="next" style="display:none">Noch mal &raquo;</a>
                            </div>

                            <br style="clear:both;"/>
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
    </body>
</html>