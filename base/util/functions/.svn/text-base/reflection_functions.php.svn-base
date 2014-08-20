<?php
/*
 * Created at Mon Jul 09 13:57:24 CEST 2007
 *
 * @author Markus Moeller - Twick.it
 */

function getClassAsArray($inClass) {
	$result = array();
	$methods = get_class_methods($inClass);
	if ($methods) {
		foreach ($methods as $method) {
			if (strtolower($method) != "getdatabasevalues" && preg_match("/^get(.+)$/", $method, $matches)) {
				@$result[strtolower($matches[1])] = $inClass->$method();
			}
		}
	
		return $result;
	} else {
		return array();
	}
}


function getClassArrayAsArray($inClassArray) {
	$result = array();
	foreach($inClassArray as $class) {
		array_push($result, getClassAsArray($class));
	}
	return $result;
}


function copyArrayInClass(&$inClass, $inArray) {
	$methods = get_class_methods(get_class($inClass));
	foreach ($inArray as $key => $value) {
		$setter = "set" . toCamelWord($key);
		if (in_array($setter, $methods) || in_array(strtolower($setter), $methods)) {
			$inClass->$setter($inArray[$key]);
		}
	}
}


function copyArrayInClassWithSpecialChars(&$inClass, $inArray) {
	$methods = get_class_methods(get_class($inClass));
	foreach ($inArray as $key => $value) {
		$setter = "set" . toCamelWord($key);
		if (in_array($setter, $methods) || in_array(strtolower($setter), $methods)) {
			$inClass->$setter(htmlspecialchars($inArray[$key]));
		}
	}
}


function copyClassInClass($inSourceClass, &$inDestClass) {
	$sourceMethods = get_class_methods(get_class($inSourceClass));
	$destMethods = get_class_methods(get_class($inDestClass));
	foreach ($sourceMethods as $method) {
		if (strtolower($method) != "getdatabasevalues" && preg_match("/^get(.+)$/", $method, $matches)) {
			$setter = "set" . toCamelWord($matches[1]);
			$getter = "get" . toCamelWord($matches[1]);
			if (in_array($setter, $destMethods) || in_array(strtolower($setter), $destMethods)) {
				@$inDestClass->$setter($inSourceClass->$getter);
			}
		}
	}
}


function getArrayElement($inArray, $inKey, $inDefault="") {
	return isset($inArray[$inKey]) ? $inArray[$inKey] : $inDefault;
}

?>