<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");

setcookie("poll", 1);
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
                            Vielen Dank, dass du dir Zeit genommen hast, uns ein wenig weiter zu helfen.
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
