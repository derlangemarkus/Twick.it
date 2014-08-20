<?php 
/*
 * Created at 12.06.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/TwickFavoriteStub.class.php";

class TwickFavorite extends TwickFavoriteStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByUserId($inUserId) {
		return TwickFavorite::fetch(array("user_id"=>$inUserId));
	}
	
	
	public function fetchByUserAndTwickId($inUserId, $inTwickId) {
		return array_pop(TwickFavorite::fetch(array("user_id"=>$inUserId, "twick_id"=>$inTwickId)));
	}
	
	
	public function fetchByTwickId($inTwickId) {
		return TwickFavorite::fetch(array("twick_id"=>$inTwickId));
	}
	
	
	function findTwick() {
		return Twick::fetchById($this->getTwickId());
	}
	}
?>