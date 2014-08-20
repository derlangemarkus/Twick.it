<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
function _calculateCloudFontSize($inKeywords) {
	global $t_min, $t_max;
	$styles = 
		array (
			"12", 
			"14",
			"16",
			"18",
			"20",
			"22"
		);
	
	if ($inKeywords > $t_min) {
		if ($t_max == $t_min) {
			return $styles[0];
		} else {
			return $styles[ceil((sizeof($styles) * ($inKeywords - $t_min)) / ($t_max - $t_min))-1];
		}
	} else {
		return $styles[0];
	}
}

$keywordsByCount = array_values($keywords);

$t_min = $keywordsByCount[sizeof($keywordsByCount)-1];
$t_max = $keywordsByCount[0]; 
 
ksort($keywords);

$tags = "";
$html = "";
foreach($keywords as $term=>$count) {
	$style = _calculateCloudFontSize($count);
	$tags .= " <a href='" . HTTP_ROOT . "/find_topic.php?tag=1%26search=" . urlencode(urlencode($term)) . "' style='$style'>" . htmlspecialchars($term) . "</a> ";
	$html .= " <a href='" . HTTP_ROOT . "/find_topic.php?tag=1&search=" . urlencode($term) . "' style='padding-right:8px;font-size:{$style}px'>" . htmlspecialchars($term) . "</a> ";
	//$html .= " <a href='javascript:;' onclick='updateContent(\"$term\");try{magicTree.onClick(\"$term\");} catch(e) {}' style='padding-right:8px;font-size:{$style}px'>" . htmlspecialchars($term) . "</a> ";
}

$is3dCloud = (getArrayElement($_COOKIE, "cloud", "2d") == "3d");
?>

<p id="tagcloud3d" <?php if(!$is3dCloud) { ?>style="display:none;"<?php } ?>>
	<embed style="display:block;" id="tagcloud" height="150" width="170" flashvars="tcolor=0x000000&mode=tags&distr=true&tspeed=300&tagcloud=<tags><?php echo($tags) ?></tags>" wmode="transparent" quality="high" bgcolor="#ffffff" name="tagcloud" src="html/swf/tagcloud.swf" type="application/x-shockwave-flash"/>
	<a href="javascript:;" onclick="$('tagcloud3d').hide(); $('tagcloud2d').show();$('tagcloud2ddiv').show(); $('tagcloud2dLink').show(); document.cookie='cloud=2d;expires=' + inOneYear + ';';" class="teaser-link" title="2D"><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/>2D</a><br />
</p>
<p id="tagcloud2d" <?php if($is3dCloud) { ?>style="display:none;"<?php } ?>>
	<div id="tagcloud2ddiv" style="width: 210px; margin-bottom: 5px;<?php if($is3dCloud) { ?>display:none;<?php } ?>"><?php echo($html) ?></div>
	<a href="javascript:;" onclick="$('tagcloud2d').hide(); $('tagcloud2ddiv').hide(); $('tagcloud2dLink').hide(); $('tagcloud3d').show();document.cookie='cloud=3d;expires=' + inOneYear + ';';" class="teaser-link" id="tagcloud2dLink" title="3D" <?php if($is3dCloud) { ?>style="display:none;"<?php } ?>><img src="<?php echo(STATIC_ROOT) ?>/html/img/pfeil_weiss.gif" width="15" height="9"/>3D</a>
</p>