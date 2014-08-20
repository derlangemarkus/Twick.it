<?php
/*
 * Created at 26.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/BlockedMailStub.class.php";

class BlockedMail extends BlockedMailStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByMail($inMail) {
		return array_pop(BlockedMail::fetch(array("mail"=>$inMail)));
	}
	
	
	public function fetchByDomain($inMail) {
		return array_pop(BlockedMail::fetch(array("mail"=>substringAfter($inMail, "@"))));
	}

	
	public static function isBlocked($inMail) {
		$blocked = BlockedMail::fetchByMail($inMail);
		if (!$blocked) {
			$blocked = BlockedMail::fetchByDomain($inMail);
		}
		return $blocked;		
	}
}
?>