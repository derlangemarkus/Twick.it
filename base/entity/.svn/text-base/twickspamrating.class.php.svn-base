<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require DOCUMENT_ROOT ."/entity/stubs/TwickSpamRatingStub.class.php";

class TwickSpamRating extends TwickSpamRatingStub {

	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function fetchByTwickId($inTwickId) {
		return TwickSpamRating::fetch(array("twick_id"=>$inTwickId));
	}
	
	
	public function fetchByTwickAndUserId($inTwickId, $inUserId) {
		return array_pop(TwickSpamRating::fetch(array("twick_id"=>$inTwickId, "user_id"=>$inUserId)));
	}

	
	function findWorst($inLimit="") {
		$worst = array();
		
		for ($i=0; $i<10; $i++) {
			$type = pow(2, $i);
			$sql = "SELECT twick_id, count(twick_id) AS c, type FROM " . TwickSpamRating::_getDatabaseName() . " WHERE type & $type GROUP BY twick_id, type ORDER BY c DESC";
			if ($inLimit) {
				$sql .= " LIMIT $inLimit";
			}
			
			$db =& DB::getInstance();
			$db->query($sql);
			while ($result = $db->getNextResult()) {
				$info = getArrayElement($worst, $result["twick_id"], array());
				$total = getArrayElement($info, "total", 0);
				$info["total"] = $total + $result["c"];
				$info[$type] = $result["c"];
				$worst[$result["twick_id"]] = $info;
			}
		}
		
		uasort($worst, array("TwickSpamRating", "_sortSpam"));
		
		return $worst;
	}
	

	function getSpamTable() {
		$binar = base_convert($this->getType(), 10, 2);
		$result = array();
		
		for($i=0; $i<strlen($binar); $i++) {
			$digit = substr($binar, $i, 1);
			if ($digit) {
				$result[pow(2, strlen($binar)-$i-1)] = 1;
			}
		}
		
		return $result;
	}
	
	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	private function _sortSpam($inObject1, $inObject2) {
		return $inObject2["total"] - $inObject1["total"];	
	}
}
?>