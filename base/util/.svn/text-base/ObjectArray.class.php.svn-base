<?php
class ObjectArray {
	
	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
    var $objectArray = array();
    var $originalArray = array();


	// ---------------------------------------------------------------------
	// ----- Konstruktoren -------------------------------------------------
	// ---------------------------------------------------------------------
    function ObjectArray() {
    }
 
 
 	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	function getArray() {
		return $this->originalArray;
	}
	
	
    function inArray($inObject) {
        $needle = ObjectArray::_object2String($inObject);
        return in_array($needle, $this->objectArray);
    }
 
 
 	function addObject($inObject) {
        array_push($this->objectArray, ObjectArray::_object2String($inObject));
        array_push($this->originalArray, $inObject);
    }
    
    
    function addObjects($inObjects) {
        foreach($inObjects as $object) {
        	$this->addObject($object);
        }
    }
 
 
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
    function _object2String($inObject) {
        $str = "";
        $vars = get_object_vars($inObject);
        foreach ($vars as $value) {
        	if (is_object($value)) {
        		 $str .= ObjectArray::_object2String($value);
        	} if(is_array($value)) {
        		$str .= "Array[";
        		$separator = "";
        		foreach($value as $key=>$element) {
        			$str .= "$separator$key=>"; 
					if (is_object($element)) {
						$str .= ObjectArray::_object2String($element);
					} else {
						$str .= $element;
					}
        			
        			$separator = ", ";
        		} 
        		$str .= "]";
        	}else {
            	$str .= $value;
        	}
        }
        return $str;
    }
 
 
    
}
?>