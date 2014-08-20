<?php
class Badge {

    const BUBBLE = 1;
    const STAR = 2;
    const THUMB = 3;

    const OFF = 0;
    const BRONZE = 1;
    const SILVER = 2;
    const GOLD = 3;
    const DIAMOND = 4;

    private static $names =
        array(
            self::BUBBLE => "bubble",
            self::STAR => "star",
            self::THUMB => "thumb"
        );

    
    public static $levels =
        array(
            self::BUBBLE => array(0, 40, 120, 360, 1000),
            self::STAR => array(0, 25, 75, 225, 675),
            self::THUMB => array(0, 25, 75, 225, 675)
        );


    public static function reachedLevel($inId, $inCount) {
        if ($inCount > 0) {
            $levels = self::$levels[$inId];
            foreach($levels as $count=>$level) {
                if ($level == $inCount) {
                    return $count;
                }
            }
        }
        return false;
    }


    public static function getLevelName($inLevel) {
        switch($inLevel) {
            case self::OFF:
                return "off";
            case self::BRONZE:
                return "bronze";
            case self::SILVER:
                return "silver";
            case self::GOLD:
                return "gold";
            case self::DIAMOND:
                return "diamond";
        }
        return "";
    }

    
    public static function getBubble($inNumberOfTwicks) {
        return self::getBadge(self::BUBBLE, $inNumberOfTwicks);
    }

    public static function getStar($inRatingSum) {
        return self::getBadge(self::STAR, $inRatingSum);
    }

    public static function getThumb($inNumberOfRatings) {
        return self::getBadge(self::THUMB, $inNumberOfRatings);
    }

    
    public static function getBadge($inId, $inCount) {
        $name = self::$names[$inId];
        $levels = self::$levels[$inId];
        $badge = array();
        if ($inCount >= $levels[self::DIAMOND]) {
			$badge["level"] = self::DIAMOND;
            $badge["text"] = _loc("badges.$name.diamond", $levels[self::DIAMOND]);
            $badge["img"] = $name . "_diamond.png";
        } else if ($inCount >= $levels[self::GOLD]) {
			$badge["level"] = self::GOLD;
            $badge["text"] = _loc("badges.$name.gold", $levels[self::GOLD]) . " " . _loc("badges.$name.gold.more", $levels[self::DIAMOND]-$inCount);
            $badge["img"] = $name . "_gold.png";
        } else if ($inCount >= $levels[self::SILVER]) {
			$badge["level"] = self::SILVER;
            $badge["text"] = _loc("badges.$name.silver", $levels[self::SILVER]) . " " . _loc("badges.$name.silver.more", $levels[self::GOLD]-$inCount);
            $badge["img"] = $name . "_silver.png";
        } else if ($inCount >= $levels[self::BRONZE]) {
			$badge["level"] = self::BRONZE;
            $badge["text"] = _loc("badges.$name.bronze", $levels[self::BRONZE]) . " " . _loc("badges.$name.bronze.more", $levels[self::SILVER]-$inCount);
            $badge["img"] = $name . "_bronze.png";
        } else {
			$badge["level"] = self::OFF;
            $badge["text"] = _loc("badges.$name.off", $levels[self::BRONZE]-$inCount);
            $badge["img"] = $name . "_off.png";
        }
        $badge["id"] = $inId;
		$badge["name"] = $name;
        return $badge;
    }


    public static function getInfos() {
        $badges = array();
        foreach(array(self::BUBBLE, self::STAR, self::THUMB) as $id) {
            $name = self::$names[$id];
            $levels = self::$levels[$id];

            $info = array();
            $info["id"] = $id;
            $info["name"] = $name;
            $info["info"] = "badges.$name.info";

            $badge = array();
            $badge["id"] = self::DIAMOND;
            $badge["count"] = $levels[self::DIAMOND];
            $badge["text"] = _loc('badges.' . $name . '.diamond', $levels[self::DIAMOND]);
            $badge["img"] = $name . "_diamond.png";
            $info["levels"][] = $badge;

            $badge = array();
            $badge["id"] = self::GOLD;
            $badge["count"] = $levels[self::GOLD];
            $badge["text"] = _loc('badges.' . $name . '.gold', $levels[self::GOLD]);
            $badge["img"] = $name . "_gold.png";
            $info["levels"][] = $badge;

            $badge = array();
            $badge["id"] = self::SILVER;
            $badge["count"] = $levels[self::SILVER];
            $badge["text"] = _loc('badges.' . $name . '.silver', $levels[self::SILVER]);
            $badge["img"] = $name . "_silver.png";
            $info["levels"][] = $badge;

            $badge = array();
            $badge["id"] = self::BRONZE;
            $badge["count"] = $levels[self::BRONZE];
            $badge["text"] = _loc('badges.' . $name . '.bronze', $levels[self::BRONZE]);
            $badge["img"] = $name . "_bronze.png";
            $info["levels"][] = $badge;

            $badges['badges.' . $name .'.headline'] = $info;
        }
        return $badges;
    }
}
?>
