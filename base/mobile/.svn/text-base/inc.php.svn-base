<?php
require_once("../util/inc.php");

includeLanguageFile("mobile/lang");

function truncateLink($inText, $inLength=40) {
	if (strlen($inText)<=$inLength) {
		$result = $inText;
	} else {
		$parts = explode("/", $inText);

		$last = array_pop($parts);		
		$short = "";
		while(strlen($short) <= 40-strlen($last) && sizeof($parts)) {
			$short .= array_shift($parts) . "/";
		}
		$result = $short . ".../$last";
	}
    return str_replace(array("&", ".", "-", "_"), array("&<wbr />", ".<wbr />", "-<wbr />", "_<wbr />"), $result);
}


function showTwick($inTwick, $inReferrer, $inId, $inAbout=false) {
	$twickUser = $inTwick->findUser();
	$user = getUser();
	$rating = $inTwick->getRatingSumCached();
	$ratingCount = $inTwick->getRatingCountCached();
	$shortLink = truncateLink($inTwick->getLink());
	
	if ($ratingCount == 1) {
		if ($rating == 1) {
			$ratingText = _loc('twick.points.1.1');
		} else {
			$ratingText = _loc('twick.points.-1.1');
		}
	} else {
		if ($rating == 1) {
			$ratingText = _loc('twick.points.1.n', array($rating, $ratingCount));
		} else {
			$ratingText = _loc('twick.points.n.n', array($rating, $ratingCount));
		}
	}
    $geo = "";
    if(isGeo()) {
        $topic = Topic::fetchById($inTwick->getTopicId());
        if ($topic->hasCoordinates()) {
            $map = "http://maps.google.de/maps?z=12&q=" . $topic->getLatitude() . "," . $topic->getLongitude();
            $geo = "&nbsp;<a href='$map' target='_blank'><img src='http://static.twick.it/html/img/world.png' style='width:16px;height:16px;'/></a>";
        } else {
			$geo = "&nbsp;<a href='http://twick.it/admin/geo.php?id=" . $topic->getId() . "' target='_blank'><img src='http://static.twick.it/html/img/world_off.png' style='width:16px;height:16px;'/></a>";
		}
    }
	?>
	<tr class="class_twick">
		<?php if($twickUser->getDeleted() || $twickUser->isAnonymous()) { ?>
		<td valign="top" class="class_left<?php if(!$user) { ?> class_bottom_left<?php } ?>"><a name="<?php echo($inTwick->getId()) ?>"></a><img src="<?php echo($twickUser->getAvatarUrl(20)) ?>" /></td>
		<td class="class_right<?php if(!$user) { ?> class_bottom_right<?php } ?>"><b><?php echo($twickUser->getLogin()) ?></b><?php if ($inAbout) { ?> <?php loc('mobile.twick.about')?> &quot;<a href="topic.php?search=<?php echo(urlencode($inTwick->getTitle())) ?>"><?php echo($inTwick->getTitle()) ?></a>&quot;<?php } echo($geo); ?> (<span id="rating<?php echo($inTwick->getId()) ?>" style="font-size:10px;color:<?php echo($rating < 0 ? "#F33" : "#333") ?>"><?php echo($ratingText) ?></span>)<br /><?php if($inTwick->getAcronym()) { ?><?php loc('mobile.twick.accronym') ?>: &quot;<i><?php echo($inTwick->getAcronym()) ?></i>&quot;. <?php } ?>
		<?php } else { ?>
		<td valign="top" class="class_left<?php if(!$user) { ?> class_bottom_left<?php } ?>"><a name="<?php echo($inTwick->getId()) ?>"></a><a href="user.php?name=<?php echo($twickUser->getLogin()) ?>"><img src="<?php echo($twickUser->getAvatarUrl(20)) ?>" /></a></td>
		<td class="class_right<?php if(!$user) { ?> class_bottom_right<?php } ?>"><a href="user.php?name=<?php echo($twickUser->getLogin()) ?>" style="font-weight:bold;"><?php echo($twickUser->getLogin()) ?></a><?php if ($inAbout) { ?> <?php loc('mobile.twick.about')?> &quot;<a href="topic.php?search=<?php echo(urlencode($inTwick->getTitle())) ?>"><?php echo($inTwick->getTitle()) ?></a>&quot;<?php } echo($geo); ?> (<span id="rating<?php echo($inTwick->getId()) ?>" style="font-size:10px;color:<?php echo($rating < 0 ? "#F33" : "#333") ?>"><?php echo($ratingText) ?></span>)<br /><?php if($inTwick->getAcronym()) { ?><?php loc('mobile.twick.accronym') ?>: &quot;<i><?php echo($inTwick->getAcronym()) ?></i>&quot;. <?php } ?>
		<?php }  ?>
		<?php echo($inTwick->getText()) ?>
		<?php if($inTwick->getLink()) { ?> 	&raquo;&nbsp;<a href="<?php echo($inTwick->getLink(true)) ?>"><?php echo($shortLink) ?></a><?php } ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
	<?php 
	if($user) {
		if($user->getId() == $inTwick->getUserId()) {
			?><a class="class_rate class_rate_bad class_bottom_left" style="font-size:14px;" href="delete.php?id=<?php echo($inTwick->getId()) ?>&secret=<?php echo($user->getSecret()) ?>"><?php loc('mobile.twick.delete') ?></a><a class="class_rate class_rate_good class_bottom_right" style="font-size:14px;" href="edit.php?id=<?php echo($inTwick->getId()) ?>&secret=<?php echo($user->getSecret()) ?>"><?php loc('mobile.twick.edit') ?></a><br /><br /><?php
		} else { 
			$classGood = "class_rate_good";
			$classBad = "class_rate_bad";
			$ratingObject = TwickRating::fetchByUserAndTwickId($user->getId(), $inTwick->getId());
			if($ratingObject) {
				$newCount = $ratingCount;
				if($ratingObject->getRating() < 0) {
					$classBad = "class_rate_bad_active";
					$newSumBad = $rating;
					$newSumGood = $rating+2;
				} else {
					$classGood = "class_rate_good_active";
					$newSumBad = $rating-2;
					$newSumGood = $rating;
				}
			} else {
				$newCount = $ratingCount+1;
				$newSumBad = $rating-1;
				$newSumGood = $rating+1;
			}
			
			
			?><a id="minus<?php echo($inTwick->getId()) ?>" class="class_rate <?php echo($classBad) ?> class_bottom_left" href="action/rate.php?x=<?php echo($inId) ?>&id=<?php echo($inTwick->getId()) ?>&rating=-1&secret=<?php echo($user->getSecret()) ?>&r=<?php echo($inReferrer) ?>" onclick="return rateTwick(<?php echo($inTwick->getId()) ?>, <?php echo($newSumBad) ?>, <?php echo($newCount) ?>, -1);">-</a><a id="plus<?php echo($inTwick->getId()) ?>" class="class_rate <?php echo($classGood) ?> class_bottom_right" href="action/rate.php?x=<?php echo($inId) ?>&id=<?php echo($inTwick->getId()) ?>&rating=1&secret=<?php echo($user->getSecret()) ?>&r=<?php echo($inReferrer) ?>" onclick="return rateTwick(<?php echo($inTwick->getId()) ?>, <?php echo($newSumGood) ?>, <?php echo($newCount) ?>, +1);">+</a><br /><br /><?php
		} 
	} else { 
        ?><br /><?php
	} 
	?>
		</td>
	</tr>
	<?php 
}
?>