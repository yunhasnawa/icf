<?php

namespace framework\icf\data_context;

use framework\icf\main\ICF_Object;
use \PDO;
use \PDOException;
use framework\icf\main\ICF_Globals;
use framework\icf\main\ICF_Setting;
use framework\icf\library\Base;

class Database_Access extends ICF_Object{
	
	private $_connectionAccount;
	
	private $_dataContext;
	
	protected function __construct() {
		
		$this->_connectionAccount = new Connection_Account();
		
		try{
			$this->_dataContext = new PDO(
				$this->_connectionAccount->getDsn(), 
				$this->_connectionAccount->getUsername(), 
				$this->_connectionAccount->getPassword(), 
				$this->_connectionAccount->getOptions()
			);
			
		} catch(PDOException $ex) {
			
			echo $ex->getMessage();
			
		}
	}
	
	protected static function factory()
	{
		if(empty(ICF_Globals::$DATABASE_ACCESS)) {
			
			$instance = new Database_Access();
			
		} else {
			
			$instance = ICF_Globals::$DATABASE_ACCESS;
			
		}
		
		return $instance;
	}
	
	public function executeNonUpdate($sql) {
		
		$statement = $this->_dataContext->query($sql);
		
		$result = array();
		
		$this->_showError($this->_dataContext);
		
		$rowCounter = 0;
		
		foreach($statement as $row) {
			
			$fieldCounter = 0;
			
			foreach($row as $field => $value) {
				
				if($fieldCounter % 2 == 0) {
					
					$result[$rowCounter][$field] = $value;
					
				}
				
				$fieldCounter++;
				
			}
			
			$rowCounter++;
		}
		
		return $result;
		
	}
	
	public function executeUpdate($sql) {
		
		$this->_dataContext->exec($sql);
		
		$this->_showError($this->_dataContext);
				
	}
	
	private function _showError($dataContext) {
		
		$die = ICF_Setting::DB_DIE_ON_ERROR;
		
		$errorInfo = $dataContext->errorInfo();
		
		if(!empty($errorInfo[2]) || !empty($errorInfo[1])){
			
			if($die) {
				
				die(Base::arrdeb($errorInfo));
				
			} else {
				
				Base::arrdeb($errorInfo);
				
			}
		}
		
	}
}

?>