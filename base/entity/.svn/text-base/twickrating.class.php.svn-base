<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/TwickRatingStub.class.php";

class TwickRating extends TwickRatingStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByUserAndTwickId($inUserId, $inTwickId) {
		return array_pop(TwickRating::fetch(array("user_id"=>$inUserId, "twick_id"=>$inTwickId)));
	}
	
	
	public function fetchByUserId($inUserId) {
		return TwickRating::fetch(array("user_id"=>$inUserId));
	}
	
	public function fetchByTwickId($inTwickId) {
		return TwickRating::fetch(array("twick_id"=>$inTwickId));
	}
}
?>