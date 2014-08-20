<?php
/*
 * Created at 13.07.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/NoWordStub.class.php";

class NoWord extends NoWordStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByUserIdAndWord($inUsrId, $inWord) {
		return array_pop(NoWord::fetch(array("user_id"=>$inUserId, "word"=>$inWord)));
	}
}
?>