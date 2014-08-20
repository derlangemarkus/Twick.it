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
        <title>Umfrage | <?php loc('core.titleClaim') ?></title>
        <meta property="og:title" content="Umfrage" />
        <meta name="description" content="Umfrage | <?php loc('core.titleClaim') ?>" />
        <meta name="keywords" content="<?php loc('core.keywords') ?>" />
        <?php include("inc/inc_global_header.php"); ?>
        <style type="text/css">
            #umfrage td, #umfrage th {
                font-size: 16px;
                padding: 10px;
            }

            #umfrage .grau {
                background-color:#DDD;
            }

            #umfrage .header th{
                background-color:#666;
                color:#FFF!important;
            }
        </style>
    </head>

    <body>
        <?php include("inc/inc_header.php"); ?>

        <div id="contentFrame">

            <!-- Ergebnis-Feld -->
            <div class="header-ergebnisfeld" id="header-ergebnisfeld">
                <h1>Umfrage</h1>
            </div>

            <!-- Content-Bereich | START -->
            <div class="content">

                <!-- Linke Haelfte | START -->
                <div class="inhalte-links">
                    <!-- Kasten | START -->
                    <div class="blog-kasten">
                        <div class="blog-head"><h1>Deine Meinung zählt</h1></div>
                        <div class="blog-body">
                            <?php if(getArrayElement($_COOKIE, "poll")) { ?>
                            <?php } ?>
                            <form id="umfrageform" action="action/save_poll.php" method="post">
                            <table id="umfrage" cellspacing="0" cellpadding="0">
                                <tr class="header">
                                    <th style="text-align:left;">Würdest du mehr Twicks schreiben, wenn...</th>
                                    <th style="width:60px">Nö</th>
                                    <th style="width:60px">Vielleicht</th>
                                    <th style="width:60px">Auf jeden Fall!!!</th>
                                </tr>
                                <tr>
                                    <td>damit automatisch an einem monatlichen Gewinnspiel teilnehmen kannst? Jeden Monat werden Amazon-Gutscheine im Wert von 200 Euro verlost.</td>
                                    <th><input type="radio" name="gewinnspiel" value="0" /></th>
                                    <th><input type="radio" name="gewinnspiel" value="1" /></th>
                                    <th><input type="radio" name="gewinnspiel" value="2" /></th>
                                </tr>
                                <tr class="grau">
                                    <td>für jede Erklärung, die positiv bewertet wird, 50 Cent bekommst?</td>
                                    <th><input type="radio" name="cent" value="0" /></th>
                                    <th><input type="radio" name="cent" value="1" /></th>
                                    <th><input type="radio" name="cent" value="2" /></th>
                                </tr>
                                <tr>
                                    <td>einmal im Jahr eine Weltreise gewinnen kannst? Deine Chancen erhöhen sich, je mehr Twicks du schreibst.</td>
                                    <th><input type="radio" name="weltreise" value="0" /></th>
                                    <th><input type="radio" name="weltreise" value="1" /></th>
                                    <th><input type="radio" name="weltreise" value="2" /></th>
                                </tr>
                                <tr class="grau">
                                    <td>dein Name in den Suchmaschinen an 1. Stelle erscheint?</td>
                                    <th><input type="radio" name="seo" value="0" /></th>
                                    <th><input type="radio" name="seo" value="1" /></th>
                                    <th><input type="radio" name="seo" value="2" /></th>
                                </tr>
                                <tr>
                                    <td>wenn eine größere Community mitmacht und Medien wie die Tagesschau darüber berichten?</td>
                                    <th><input type="radio" name="tagesschau" value="0" /></th>
                                    <th><input type="radio" name="tagesschau" value="1" /></th>
                                    <th><input type="radio" name="tagesschau" value="2" /></th>
                                </tr>
                                <tr class="grau">
                                    <td>tolle Gadgets für deine Nutzerseite erhältst?</td>
                                    <th><input type="radio" name="gadgets" value="0" /></th>
                                    <th><input type="radio" name="gadgets" value="1" /></th>
                                    <th><input type="radio" name="gadgets" value="2" /></th>
                                </tr>
                                <tr>
                                    <td>dafür Administrator-Rechte erhältst?</td>
                                    <th><input type="radio" name="adminrechte" value="0" /></th>
                                    <th><input type="radio" name="adminrechte" value="1" /></th>
                                    <th><input type="radio" name="adminrechte" value="2" /></th>
                                </tr>
                                <tr class="grau">
                                    <td>du neue Themen vorgeschlagen bekommst, die dich interessieren?</td>
                                    <th><input type="radio" name="vorschlag" value="0" /></th>
                                    <th><input type="radio" name="vorschlag" value="1" /></th>
                                    <th><input type="radio" name="vorschlag" value="2" /></th>
                                </tr>
                                <tr>
                                    <td>berühmte Stars mitmachen würden?</td>
                                    <th><input type="radio" name="stars" value="0" /></th>
                                    <th><input type="radio" name="stars" value="1" /></th>
                                    <th><input type="radio" name="stars" value="2" /></th>
                                </tr>
                                <tr class="grau">
                                    <td>damit kranken Kindern helfen kannst?</td>
                                    <th><input type="radio" name="kinder" value="0" /></th>
                                    <th><input type="radio" name="kinder" value="1" /></th>
                                    <th><input type="radio" name="kinder" value="2" /></th>
                                </tr>
                                <tr>
                                    <td>es zu deinem Spezial-Thema eine Mailing-Liste gäbe?</td>
                                    <th><input type="radio" name="mailing" value="0" /></th>
                                    <th><input type="radio" name="mailing" value="1" /></th>
                                    <th><input type="radio" name="mailing" value="2" /></th>
                                </tr>
                                <tr class="header">
                                    <th style="text-align:left;"></th>
                                    <th style="width:60px">Nö</th>
                                    <th style="width:60px">Vielleicht</th>
                                    <th style="width:60px">Auf jeden Fall!!!</th>
                                </tr>
                                <tr>
                                    <td>Was würde dich sonst noch motivieren? Möchtest du uns noch was sagen?</td>
                                    <td colspan="3"><textarea name="text" style="width:280px;height:100px;"></textarea></td>
                                </tr>
                                <tr>
                                    <td>Wenn du eine Weihnachtsüberraschung gewinnen möchtest, dann verrate uns deine E-Mail-Adresse. Diese wird nicht weitergegeben und dient nur zur Gewinnbenachrichtigung. Wenn du nix gewinnen möchtest, lass das Feld einfach leer.</td>
                                    <td colspan="3"><input type="text" name="mail" style="width:280px;" /></td>
                                </tr>
                            </table>
                            </form>

                            <div class="haupt-buttonfeld" style="border:none;">
                                <a id="userTwicksMoreLink" href="javascript:;" onclick="$('umfrageform').submit()">Absenden</a>
                            </div>
                        </div>
                        <div class="blog-footer">
                        </div>
                    </div>
                    <!-- Kasten | ENDE -->

                </div>
                <!-- Linke Haelfte | ENDE -->


                <!-- Rechte Haelfte | START -->
                <div class="inhalte-rechts">

                    <!-- Zufaelliger Artikel | START -->
                    <div class="teaser">
                        <div class="teaser-head"><h2><?php loc('404.random.title') ?></h2></div>
                        <div class="teaser-body">
                            <div>
                                <a href="random.php"><?php loc('404.random.text') ?></a><br />
                            </div>
                        </div>
                        <div class="teaser-footer"></div>
                    </div>
                    <!-- Zufaelliger Artikel | ENDE -->

                    <?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>

                    <br /></div>
                <!-- Rechte Haelfte | ENDE -->

                <div class="clearbox"></div>
            </div>
            <!-- Content-Bereich | ENDE -->

        </div>

        <?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

    </body>
</html>
