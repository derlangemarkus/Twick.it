<?php
require_once(DOCUMENT_ROOT . '/util/thirdparty/fsbb/fsbb.php');

class SpamBlocker extends formSpamBotBlocker {

    function SpamBlocker() {
    	$this->setTimeWindow(1, 60*60*24);  // 24 Std
		$this->setTrap(true, "twickit_address", "Don't enter anything in this field, please!");
    }
    
    
    function printHiddenTags() {
    	$blocker = new SpamBlocker();
    	echo($blocker->makeTags());
    }
    
    
    function check($inArray, $inMinTime=5) {
    	$blocker = new SpamBlocker();
    	$blocker->setTimeWindow($inMinTime, 60*60*3);
    	return $blocker->checkTags($inArray);
    }
}
?>