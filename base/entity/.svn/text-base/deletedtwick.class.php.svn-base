<?php
/*
 * Created at 09.08.2011
 *
 * @author Markus Moeller - Twick.it
 */

require DOCUMENT_ROOT ."/entity/stubs/DeletedTwickStub.class.php";

class DeletedTwick extends DeletedTwickStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
    public static function create($inTwick) {
        $sourceValues = $inTwick->getDatabaseValues();
        unset($sourceValues["id"]);
        unset($sourceValues["topic_id"]);

        $deleted = new DeletedTwick();
        $deleted->_setDatabaseValues($sourceValues);
        $deleted->setDeleterId(getUserId());
        $deleted->setDeleteDate(getCurrentDate());
        $deleted->save();

        return $deleted;
    }


    public function asTwick() {
        $sourceValues = $this->getDatabaseValues();
        unset($sourceValues["id"]);

        $twick = new Twick();
        $twick->_setDatabaseValues($sourceValues);

        return $twick;
    }
}
?>