<?php

namespace framework\icf\library;

class Sql {

	const SELECT = 'select';
	
	const INSERT = 'insert';
	
	const UPDATE = 'update';
	
	const DELETE = 'delete';
	
	
	private $_tableName;
	
	private $_wheres = array(); // Filters, Deletes
	
	private $_sets = array(); // Updates
	
	private $_selects = array(); // Selects
	
	private $_values = array(); // Inserts
	
	public function __construct($table = '') {
		
		$this->_tableName = $table;
		
	}
	
	/**
	 * @param string $_tableName
	 */
	public function setTableName($tableName) {
		
		$this->_tableName = $tableName;
		
	}

	/**
	 * @param string[] $_wheres
	 */
	public function setWheres($wheres) {
		
		$this->_wheres = $this->escapeData($wheres);
		
	}

	/**
	 * @param string[] $_sets
	 */
	public function setSets($sets) {
		
		$this->_sets = $this->escapeData($sets);
		
	}

	/**
	 * @param string[] $_selects
	 */
	public function setSelects($selects) {
		
		$this->_selects = $this->escapeData($selects);
		
	}

	/**
	 * @param field_type $_values
	 */
	public function setValues($values) {
		
		$this->_values = $this->escapeData($values);
		
	}
	
	public function generate($sqlType = '', $customSql = '') {

		$sql = '';
		
		if(empty($customSql)) {
			
			if(empty($sqlType)) {
				
				$sqlType = $this->retriveType();
				
			}
			
			switch ($sqlType) {
				
				case 'insert' : $sql = $this->createInsert();
				break;
				
				case 'update' : $sql = $this->createUpdate();
				break;
				
				case 'delete' : $sql = $this->createDelete();
				break;
				
				case 'select' : $sql = $this->createSelect();
				break;
				
			}
			
		} else {
			
			$sql = $customSql;
			
		}
		
		$this->clear();
		
		return $sql;
		
	}
	
    public function createInsert() {
		
		$table  = $this->_tableName;
		$values = $this->_values;
		
		$sql = "INSERT INTO $table ";
		
		$strColumn = '';
		$strValues = '';
		
		foreach ($values as $column => $value) {
			$strColumn .= "`$column`, ";
			$strValues .= "'$value', ";
		}

		$strColumn = substr($strColumn, 0, strlen($strColumn) - 2);
		$strValues = substr($strValues, 0, strlen($strValues) - 2);
		
		$sql .= "($strColumn) VALUES ($strValues)";
		
		return $sql;
	}
	
	public function createUpdate() {
		
		$tableName = $this->_tableName;
		$sets      = $this->_sets;
		$wheres    = $this->_wheres;
		
		$sql = "UPDATE $tableName SET";
		
		$i = 0;
		
		foreach($sets as $field => $value) {
			
			$sql .= " `$field` = '$value'";
			
			$i++;
			
			if($i < count($sets)) {
				
				$sql .= ", ";
				
			}
		}
		
		$sql .= " WHERE";
		
		//$i = 0;
		
		foreach ($wheres as $field => $value) {
			
			$sql .= " $field = '$value'";
			
			//$i++;
			
			//if($i < count($sets)) {
				
				$sql .= " AND ";
				
			//}
			
		}
		
		$sql = substr($sql, 0, strlen($sql) - 4);
		
		return $sql;
	}

    public function createDelete() {
		
		$tableName = $this->_tableName;
		$wheres    = $this->_wheres;
		
		$sql = "DELETE FROM $tableName WHERE";
		
		$i = 0;
		
		foreach($wheres as $key => $val) {
			
			$sql .= " `$key` = '$val'";
			
			if($i < (count($wheres) - 1)) {
				
				$sql .= ' AND';
				
			}
			
			$i++;
			
		}
		
		return $sql;
	}
	
    public function createSelect() {
    	
    	$selects   = $this->_selects;
    	$tableName = $this->_tableName;
    	$wheres    = $this->_wheres;
    	
    	$sql = "SELECT";
    	
    	$i = 0;
    	
    	if(is_array($selects)) {
    	
	    	foreach($selects as $field) {
	    		
	    		$sql .= " `$field`";
	    		
	    		if($i < (count($selects) - 1)) {
	    			
	    			$sql .= ',';
	    			
	    		}
	    		
	    		$i++;
	    		
	    	}
    	
    	} else {
    		
    		$sql .= " $selects";
    		
    	}
    	
    	$sql .= " FROM $tableName";
    	
    	if(count($wheres) > 0) {
    		
    		$sql .= " WHERE";
    		
    		$i = 0;
    		
    		foreach ($wheres as $field => $value) {
    			
    			$sql .= " $field = '$value'";
    			
    			if($i < (count($wheres) - 1)) {
    				
    				$sql .= " AND";
    				
    			}
    			
    			$i++;
    			
    		}
    		
    	}
    	
    	return $sql;
    	
	}
	
	private function retriveType() {
		
		/*
		 * DELETE FROM table_name WHERE {wheres};
		 * INSERT INTO table_name VALUES {values};
		 * UPDATE table_name SET {sets} WHERE {wheres};
		 * SELECT {selects} FROM table_name WHERE {wheres};
		 */
		
		$type = '';
		
		if(count($this->_selects) > 0) {
			
			$type = Sql::SELECT;
			
		} else {
			
			if(count($this->_values) > 0) {
				
				$type = Sql::INSERT;
				
			} elseif(count($this->_sets) > 0) {
				
				$type = SQL::UPDATE;
				
			} else {
				
				$type = SQL::DELETE;
				
			}
			
		}
		
		return $type;
		
	}
	
	private function clear() {
		
		$this->_wheres  = array();
		$this->_selects = array();
		$this->_sets    = array();
		$this->_values  = array();
		
	}
	
	private function escapeData($data) {
		
		$secureData = '';
		
		if(!is_array($data)) {
			
			$secureData = $data;
			
		} else {

			foreach ($data as $key => $val) {
				
				$secureData[$key] = mysql_escape_string($val);
				
			}
			
		}
		
		return $secureData;
		
	}
}

?>