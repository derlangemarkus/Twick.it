<?php
/*
 * Created at 02.06.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/BlockedUserStub.class.php";

class BlockedUser extends BlockedUserStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByMyUserId($inUserId) {
		return BlockedUser::fetch(array("my_user_id"=>$inUserId));
	}
	
	
	public function fetchByUserIds($inMyUserId, $inUserId) {
		return array_pop(BlockedUser::fetch(array("my_user_id"=>$inMyUserId, "user_id"=>$inUserId)));
	}
	

	function isUserBlocked($inUserId) {
		return isLoggedIn() && BlockedUser::fetchByUserIds(getUserId(), $inUserId);
	}
	
	
	function findUser() {
		return User::fetchById($this->getUserId()); 
	}
}
?>