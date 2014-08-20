<?php
$offset = getArrayElement($_GET, "offset", 0);
$sort = getArrayElement($_GET, "sort", "rating_sum");
$direction = getArrayElement($_GET, "direction", "DESC");

if ($sort == "") {
	$sort = "rating_sum";
}
if ($direction == "") {
	$direction = "DESC";
}


if ($direction != "DESC" && $direction != "ASC") {
	$direction = "ASC";
}
$otherDirection = $direction == "DESC" ? "ASC" : "DESC";

$twicks = $user->findTwicks(false, array("ORDER BY"=>"$sort $direction", "LIMIT"=>$LIMIT+1, "OFFSET"=>$offset));
?>
<div class="teekesselchen"><span>
<?php loc('user.sort.title') ?> &nbsp;&nbsp;&nbsp;
<?php
$separator = "";
foreach(array("rating_sum"=>_loc('user.sort.rating'), "title"=>_loc('user.sort.topic'), "creation_date"=>_loc('user.sort.time')) as $key=>$value) {
    echo($separator);
    if ($sort == $key) {
    ?><a style="font-weight:bold;" href="<?php echo($user->getUrl()) ?>/twicks?direction=<?php echo($otherDirection) ?>&sort=<?php echo($key) ?>"><?php echo($value) ?> <img src="<?php echo(STATIC_ROOT) ?>/html/img/<?php echo($direction) ?>.gif" alt="" width="8" height="8"/></a><?php
    } else {
    ?><a href="<?php echo($user->getUrl()) ?>/twicks?direction=<?php echo($direction) ?>&sort=<?php echo($key) ?>"><?php echo($value) ?></a><?php
    }
    $separator = "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
}
?>
</span><div class="clearbox"></div></div>


<?php if (sizeof($twicks)) { ?>
    <div id="userTwicks">
        <div class="dummy-container">
        <?php
        $counter = 1;
        foreach($twicks as $twick) {
            if ($counter <= $LIMIT) {
                $twick->display(false, 4, false, false, "&userId=" . $user->getId() . "&offset=$offset&sort=$sort&direction=$direction");
            }
            $counter++;
        }
        ?>
        </div>
    </div>

    <?php if ($counter > $LIMIT) { ?>
    <div class="haupt-buttonfeld">
        <a id="userTwicksMoreLink" href="javascript:;" onclick="showMore('userTwicks', '<?php echo($_SERVER["QUERY_STRING"]) ?>', <?php echo($LIMIT) ?>);"><?php loc('user.more') ?></a>
        <img src="<?php echo(STATIC_ROOT) ?>/html/img/ajax-loader.gif" id="userTwicksMoreLinkWait" style="display:none;width:16px;height:11px;"/>
    </div>
    <script type="text/javascript">
		// showMore('userTwicks', '<?php echo($_SERVER["QUERY_STRING"]) ?>', <?php echo($LIMIT) ?>);
		var scrollBlock = false;
		function checkScroll() {
			var element = $$("body");
			element = element[0];
			var height = element.scrollHeight;
			var scroll = element.scrollTop;

			var diff = height - scroll;
			
			if(diff <= 1200 && scrollBlock == false) {
				scrollBlock = true;
				showMore('userTwicks', '<?php echo($_SERVER["QUERY_STRING"]) ?>', <?php echo($LIMIT) ?>);
				scrollBlock = false;
			}
		}

		Event.observe(
			window,
			'scroll',
			function() {
				checkScroll();
			}
		);
    </script>
    <?php } ?>
<?php } else { ?>
    <?php if($user->isTwickit()) { ?>
        <!-- Sprechblase | START -->
        <div class="sprechblase">
            <h2>&nbsp;<span>&nbsp;</span></h2>
            <div class="sprechblase-main">
                <div class="sprechblase-achtung">&nbsp;</div>
                <div class="sprechblase-rechts">
                    <div class="blase-header" id="eingabeblase-head">
                        <div class="kurzerklaerung"><h1 style="font-size:20px;"><?php loc('user.twickit.title') ?></h1></div>
                    </div>
                    <div class="blase-body">
                        <div class="twick-link">
                            <?php loc('user.twickit.text') ?><br />
                            <br />
                            <a href='write_message.php?receiver=<?php echo($user->getLogin()) ?>'class="teaser-link"><img width="15" height="9" src="html/img/pfeil_weiss.gif"><?php loc('user.twickit.write') ?></a>
                        </div>
                    </div>
                    <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
                </div>
                <div class="clearbox">&nbsp;</div>
            </div>
        </div>
        <!-- Sprechblase | ENDE -->
    <?php } else { ?>
        <!-- Sprechblase | START -->
        <div class="sprechblase">
            <h2>&nbsp;<span>&nbsp;</span></h2>
            <div class="sprechblase-main">
                <div class="sprechblase-achtung">&nbsp;</div>
                <div class="sprechblase-rechts">
                    <div class="blase-header" id="eingabeblase-head">
                        <div class="kurzerklaerung"><span><?php loc('user.noTwicks.title') ?></span></div>
                    </div>
                    <div class="blase-body">
                        <div class="twick-link">
                            <?php loc('user.noTwicks.text', "<a href='" . $user->getUrl() ."'>$displayName</a>") ?>
                            <br />
                        </div>
                    </div>
                    <div class="blase-footer" id="eingabeblase-footer">&nbsp;</div>
                </div>
                <div class="clearbox">&nbsp;</div>
            </div>
        </div>
        <!-- Sprechblase | ENDE -->
    <?php } ?>
<?php } ?>
