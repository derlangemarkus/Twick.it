<?php
/*
 * Created at 25.06.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/TagStub.class.php";

class Tag extends TagStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByEntity($inEntity) {
		return Tag::fetch(array("entity"=>strtolower(get_class($inEntity)), "foreign_id"=>$inEntity->getId()));
	}
	
	
	public function updateStemming() {
		$this->setStemming(StemmingFactory::stem($this->getTitle()));
	} 

}
?>