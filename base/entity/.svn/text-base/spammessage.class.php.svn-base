<?php
/*
 * Created at 18.04.2011
 *
 * @author Markus Moeller - Twick.it
 */

require DOCUMENT_ROOT ."/entity/stubs/SpamMessageStub.class.php";

class SpamMessage extends SpamMessageStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
    public static function create($inMessage) {
        $spam = new SpamMessage();
        $spam->setCreationDate(getCurrentDate());
        $spam->setMessageId($inMessage->getId());
        $spam->save();
        $inMessage->setDeletedReceiver(true);
        $inMessage->save();
    }
}
?>