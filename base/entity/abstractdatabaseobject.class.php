<?php
/*
 * Created at 27.09.2007
 *
 * @author Markus Moeller - Twick.it
 */
abstract class AbstractDatabaseObject {
	
	// ---------------------------------------------------------------------
	// ----- Attribute -----------------------------------------------------
	// ---------------------------------------------------------------------
	private $changed = false;
	private $databaseValues = array();

	
	// ---------------------------------------------------------------------
	// ----- Oeffentliche Methoden -----------------------------------------
	// ---------------------------------------------------------------------
	public function delete() {
		$sql = "DELETE FROM " . $this->_getDatabaseName() . " WHERE ";
		$separator = "";
		foreach($this->_getPrimaryKeyAttributes() as $key) {
			$sql .= $separator. $key . "=" . $this->_getValueForKey($key);
			$separator = " AND ";
		}		
		executeSQL($sql);
	}
	
		
	public function save() {
		if ($this->changed) {
			$values = array();
			foreach($this->databaseValues as $key=>$value) {
				if (!is_numeric($key)) {
					$values[$key] = sec_mysql_input($value);
				}
			}
			
			$primaryKeys = array();
			foreach($this->_getPrimaryKeyAttributes() as $key) {
				$primaryKeys[$key] = $this->_getValueForKey($key);
			}

			$id = saveDBObject(
				$this->_getDatabaseName(),
				$values,
				$primaryKeys
			);
	
			if (sizeof($this->_getPrimaryKeyAttributes()) == 1) {
				$tmp = $this->_getPrimaryKeyAttributes();
				$primaryKey = $tmp[0];
				if (!$this->_getValueForKey($primaryKey)) {
					$this->_setValueForKey($primaryKey, $id);
				}
			}
			return $id;
		} else {
			if (sizeof($this->_getPrimaryKeyAttributes()) == 1) {
				$tmp = $this->_getPrimaryKeyAttributes();
				$primaryKey = $tmp[0];
				return $this->_getValueForKey($primaryKey);
			}
		}
	}
	public function getDatabaseValues() {
		return $this->databaseValues;
	}
	
	
	// ---------------------------------------------------------------------
	// ----- Private Methoden ----------------------------------------------
	// ---------------------------------------------------------------------
	protected abstract function _getDatabaseName();
	
	
	protected function _getPrimaryKeyAttributes() {
		return array("id");
	}
	
	
	protected function _setDatabaseValues($inValues) {
		foreach($inValues as $key=>$value) {
			if ($value !== null) {
				$this->databaseValues[$key] = $value;
			}
		}
        $this->changed = true;
	}
	
	
	protected function _setValueForKey($inKey, $inValue) {
		if ($inValue !== $this->_getValueForKey($inKey)) {		
			$this->databaseValues[$inKey] = $inValue;
			$this->changed = true;
		}
	}
	
	
	protected function _setBooleanValueForKey($inKey, $inValue) {
		$boolean = $inValue ? 1 : 0;
		if ($boolean != $this->_getValueForKey($inKey)) {		
			$this->databaseValues[$inKey] = $boolean;
			$this->changed = true;
		}
	}
	
			
	protected function _getValueForKey($inKey) {
		return getArrayElement($this->databaseValues, $inKey);
	}
	
	

	protected function _buildSQL($inTableName, $inBindings, $inOptions) {
		$sql = "SELECT * FROM `$inTableName`";
		AbstractDatabaseObject::_addWhereClause($sql, $inBindings);
		AbstractDatabaseObject::_addOptions($sql, $inOptions);
		return $sql;
	}
	
	
	protected function _addWhereClause(&$inoutSQL, $inBindings) {
		$where = "";
		$separator = " WHERE ";
		foreach ($inBindings as $key => $value) {
            if($value === "@@null@@") {
                $where .= "$separator $key IS NULL";
            } else {
                $where .= "$separator $key='" . sec_mysql_input($value) . "'";
            }
			$separator = " AND";
		}

		if (!$where) {
			$where = " WHERE true";
		}

		$inoutSQL .= $where;
	}
	
	
    protected function _addOptions(&$inoutSQL, $inOptions) {
		if ($groupBy = getArrayElement($inOptions, "ORDER BY")) {
			$inoutSQL .= " ORDER BY " . sec_mysql_input($groupBy);
		}
		if ($groupBy = getArrayElement($inOptions, "GROUP BY")) {
			$inoutSQL .= " GROUP BY " . sec_mysql_input($groupBy);
		}
		if ($limit = getArrayElement($inOptions, "LIMIT")) {
			$inoutSQL .= " LIMIT " . sec_mysql_input($limit);
		}
		if ($offset = getArrayElement($inOptions, "OFFSET")) {
			$inoutSQL .= " OFFSET " . sec_mysql_input($offset);
		}
	}
	
	
	protected function _setDefaultOptions(&$inoutOptions, $inDefaults) {
		foreach($inDefaults as $key=>$value) {
			if (!isset($inoutOptions[$key])) {
				$inoutOptions[$key] = $value;
			}
		}		
	}
	
	
	protected function _getCachedResult($inSQL) {
		$timeout = getDBCacheTimeout();
		if ($timeout > 0) {
			$cache = new Cache();
			$cached = $cache->loadFromCache("SQL: " . $inSQL, $timeout);
			if ($cached) {
				//echo("CACHED: $inSQL<br />");
				return $cached;
			}
		} else {
			return null;
		}
	}
	
	
	protected function _setCachedResult($inSQL, $inObjects) {
		if (getDBCacheTimeout() > 0) {
			$cache = new Cache();
			$cache->saveInCache("SQL: " . $inSQL, $inObjects);
		}
	}
}
?>
