<?php
apc_clear_cache();
function xsc($text) {
   return str_replace('&#039;', '&apos;', htmlspecialchars($text, ENT_QUOTES, 'UTF-8', true));
}

// Hässliches Zeugs, das dafür sorgt, dass auf Twick.it-Core-Bibliothek
// zugegriffen werden kann.
define("DOCUMENT_ROOT", "/var/www/vhosts/twick.it/httpdocs/base");
define("HTTP_ROOT", "http://twick.it/");
require_once("../../../httpdocs/base/util/inc.php");

// Das hier könnte länger dauern
ini_set("max_execution_time", 6000000);

// Ergebnisse der DB-Abfrage 1 Std cachen
setDBCacheTimeout(3600); 

$LIMIT = 20;
$offset = getArrayElement($_GET, "offset", 0);
$twickCounter = getArrayElement($_GET, "twickCounter", 0);
$version = 'v' . date('Y.m.d');



function findGrammarCases($inTitle) {
    try {
        $url = "http://de.wiktionary.org/w/api.php?action=query&prop=revisions&titles=" . urlencode($inTitle) . "&rvprop=content&format=json";
        $old = ini_set('default_socket_timeout', 2);
        ini_set("user_agent", "Twick.it");
        if ($stream = fopen($url, 'r')) {
            ini_set('default_socket_timeout', $old);
            stream_set_timeout($stream, 2);
            $content = stream_get_contents($stream);
            fclose($stream);
        }

        $fields =
            array(
                "Nominativ Singular", "Nominativ Plural",
                "Genitiv Singular", "Genitiv Plural",
                "Dativ Singular", "Dativ Plural",
                "Akkusativ Singular", "Akkusativ Plural",

                "Gegenwart_ich", "Gegenwart_du", "Gegenwart_er, sie, es",
                "1.Vergangenheit_ich", "Partizip II", "Konjunktiv II_ich",
                "Befehl_du", "Befehl_ihr",

                "1. Steigerung", "2. Steigerung"
            );

        $result = array();

        if($content) {
            $content = json_decode($content);
            foreach($content->query->pages as $page) {
                if($page->revisions) {
                    foreach($page->revisions as $revision) {
                        $revision = (array) $revision;
                        $text = array_pop($revision);
                        foreach($fields as $field) {
                            if(preg_match('/\|\s*' . $field . '\s*=\s*(.+)\n/im', $text, $matches)) {
                                $cases = trim($matches[1]);
                                foreach(preg_split('/<br.*>/', $cases) as $case) {
                                    foreach(getMultiMeanings($case) as $word) {
                                        $word = preg_replace('/^(\(?der|die|das|den|des|dem|am\)?)\s/', "", $word);
                                        $word = str_replace("!", "", $word);
                                        $word = preg_replace('/{{.+}}/', "", $word);
                                        $word = trim($word);
                                        if(!in_array($word, $result) && $word != "—") {
                                            $result[] = $word;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        return $result;
    } catch(Exception $e) {
        #print_r($content);
        #print_r($e);
        return array();
    }
}


function getMultiMeanings($inWord) {
    if(contains($inWord, "(")) {
        $result = array();
        $result[] = str_replace(")", "", str_replace("(", "", $inWord));
        $result[] = substringBefore($inWord, "(") . substringAfter($inWord, ")");
        return $result;
    } else {
        return array($inWord);
    }
}



// Alles sammeln, um es später in eine Datei zu schreiben.
ob_start();
$fp = fopen("output/Twicktionary.xml", $offset ? "a" : "w");

if(!$offset) {
echo("<" . "?xml version=\"1.0\" encoding=\"utf-8\"?" . ">");
?>
<d:dictionary xmlns="http://www.w3.org/1999/xhtml" xmlns:d="http://www.apple.com/DTDs/DictionaryService-1.0.rng">

<?php
}

$topicCounter = $offset;
$topics = Topic::fetchAll(array("LIMIT"=>$LIMIT, "OFFSET"=>$offset, 'ORDER BY'=>'id ASC'));
foreach($topics as $topic) {
	$topicCounter++;
    $relateds = $topic->findRelatedTopics();
    $twicks = $topic->findTwicks();
?>
<!-- Thema <?php echo $topicCounter ?> -->
<d:entry id="<?php echo $topic->getId() ?>" d:title="<?php echo xsc($topic->getTitle()) ?>" d:parental-control="1">
    <?php
    $searchIndexes = array();
    $searchIndexes[] = $topic->getTitle();
    foreach ($twicks as $twick) {
        if($twick->getAcronym() && trim($twick->getAcronym()) != "" && !in_array(trim($twick->getAcronym()), $searchIndexes)) {
            $searchIndexes[] = trim($twick->getAcronym());
        }
    }

    foreach(findGrammarCases(getCoreTitle($topic->getTitle())) as $case) {
        if(trim($case) == "" || !in_array(trim($case), $searchIndexes)) {
            $searchIndexes[] = trim($case);
        }
    }

    foreach($searchIndexes as $otherIndex) {
        if(in_array($otherIndex, array("", "-", "–"))) {
    		continue;
    	}
        ?><d:index d:value="<?php echo xsc($otherIndex) ?>" d:title="<?php echo xsc($topic->getTitle()) ?>"/><?php
    }
    ?>
	<h1><?php echo xsc($topic->getTitle()) ?></h1>
	<table cellpadding="0" cellspacing="0">
        <?php 
		foreach ($twicks as $twick) {
			$twickCounter++;
			$user = $twick->findUser();
            $mp3 = $twick->getMp3Url();
		?>
		<tr>
            <td width="66" valign="top">
                <img src="<?php xecho($user->getAvatarUrl(64)) ?>" alt="<?php echo xsc($user->getLogin()) ?>" class="gravatar" />
            </td>
			<td valign="top">
                Erklärt von <a href="<?php xecho($user->getLink()) ?>"><?php echo xsc($user->getLogin()) ?></a>:<br />
				<?php if ($twick->getAcronym()) { ?>
					Kurz für: <i><?php echo xsc($twick->getAcronym()) ?></i>.
				<?php } ?>
				<?php echo xsc($twick->getText()) ?>
            	<?php if ($twick->getLink()) { ?><a href="<?php xecho($twick->getLink()) ?>">Mehr Infos</a><?php } ?><br />
                <?php if ($mp3) { ?><audio src="<?php echo($mp3) ?>" controls="controls"></audio><br /><?php } ?>
			</td>
		</tr>
        <tr>
            <td colspan="2" class="line"> </td>
        </tr>
		<?php 
			// In Datei schreiben...
			fwrite($fp, ob_get_contents());
			ob_clean();
		}
		?>
	</table>
    <?php if ($topic->hasCoordinates()) { ?>
    <h2>Karte</h2>
    <a href="http://maps.google.de/maps?q=<?php echo($topic->getLatitude()) ?>,<?php echo($topic->getLongitude()) ?>" class="map"><img src="http://maps.google.com/maps/api/staticmap?zoom=5&amp;size=228x150&amp;markers=<?php echo($topic->getLatitude()) ?>,<?php echo($topic->getLongitude()) ?>&amp;sensor=false" /></a>
    <a href="http://maps.google.de/maps?q=<?php echo($topic->getLatitude()) ?>,<?php echo($topic->getLongitude()) ?>" class="map"><img src="http://maps.google.com/maps/api/staticmap?zoom=12&amp;size=228x150&amp;markers=<?php echo($topic->getLatitude()) ?>,<?php echo($topic->getLongitude()) ?>&amp;sensor=false" /></a>
    <?php } ?>
    <?php if ($relateds) { ?>
        <h2>Verwandte Themen</h2>
        <?php 
		$rels = array();
		foreach($relateds as $related) { 
			$rels[] = '<a href="x-dictionary:r:' . $related->getId() . '">' . xsc($related->getTitle()) . '</a>';
		}
		echo implode(', ', $rels);
		?>
    <?php } ?>
	<div class="copyright">© 2010-<?php echo(date("Y")) ?> <a href="http://twick.it/">Twick.it</a> | <a href="http://creativecommons.org/licenses/by/3.0/de/"><img src="Images/cc-by.png" style="vertical-align:text-bottom" alt="CC-BY" /></a> | Version <?php echo $version ?>
		<script id="u2" charset="utf-8" src="u.js"></script>
		<span id ="u"></span>
	</div>
</d:entry>
<?php 
}

#$topics = array();

if(!$topics) {
	?>
	<d:entry id="front_back_matter" d:title="Front/Back Matter">
		<h1><b>Twicktionary</b></h1>
		<a href="http://twick.it/" style="float:right;"><img src="Images/logo_twickit.jpg" alt="" style="width:300px;" /></a>
		<h2>Das Twick.it-Lexikon für Mac OS X</h2>
		<p>Enthält <b><?php echo xsc($topicCounter) ?> Themen</b> mit <b><?php echo xsc($twickCounter) ?> Twicks (Erklärungen)</b>.</p>
		<p>Mehr Infos unter <a href="http://dict.twick.it/">dict.twick.it</a>.</p>
		<p>
			Version <?php echo $version ?><script id="u1" charset="utf-8" src="u.js"></script>
			<span id ="u"><img src="Images/progress_indicator.gif" valign="middle" alt="" /> Überprüfe auf neue Updates…</span>
		</p>
		<p>
			<a href="http://creativecommons.org/licenses/by/3.0/de/" style="float:left;margin-right: 10px;"><img src="Images/cc-by_big.png" /></a>Lizenz: creative commons Namensnennenung 3.0 Deutschland
		</p>
	</d:entry>
	</d:dictionary><?php
}

// In Datei schreiben...
fwrite($fp, ob_get_contents());
fclose($fp);
ob_end_clean();

if ($topics) {
	sleep(1);
	$url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . "?twickCounter=$twickCounter&offset=" . $offset+=$LIMIT;
	echo("<html>
			<head>
			<title>Weiterleitung ($twickCounter)...</title>
			<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
			<meta http-equiv='refresh' content='1;URL=" . $url . "'>
			</head>
			<body bgcolor='#FFFFFF'>" .
			"</body>
			</html>\n");
	exit;
}
?>