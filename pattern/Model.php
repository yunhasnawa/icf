<?php

namespace framework\icf\pattern;

use framework\icf\main\ICF_Setting;
use framework\icf\main\ICF_Exception;
use framework\icf\pattern\IPattern;
use framework\icf\data_context\Database_Access;
use framework\icf\library\Sql;
use framework\icf\library\Base;
  
class Model extends Database_Access implements IPattern {
	
	/**
	 * @var Database_Access
	 */
	protected $databaseAccess;
	protected $table;
	
	/**
	 * @var Sql
	 */
	protected $sql;
	
	protected function __construct($table = '') {
		
		$this->table = $table;
		
		$this->databaseAccess = Database_Access::factory();
		
		$this->sql = new Sql($table);
		
		$dir = dirname(__FILE__);
		
		$backtraceData = debug_backtrace();
		
		$childFileData = $this->retrieveChildData($backtraceData);
		
		$this->validateChild($childFileData);
		
	}
	
	public function validateChild($childFileData) {
		
		$modelDir = Base::site_dir(ICF_Setting::SITE_MODEL_DIRECTORY);
		
		// FIXME: Windows path compatibility issue
		//Base::arrdeb($childFileData);
		$childArray = explode(SLASH, $childFileData['file']);

		$childFileName = $childArray[(count($childArray) - 1)];
		
		unset($childArray[(count($childArray) - 1)]);
		//Base::arrdeb($childArray);
		$childDir = implode(SLASH, $childArray);
		//Base::arrdeb($modelDir . ' vs ' . $childDir);
		if($modelDir != $childDir) {
			
			throw new ICF_Exception(ICF_Exception::INVALID_MODEL_DIRECTORY);
		
		} elseif(strpos($childFileName, 'Model_') === false) {
			
			throw new ICF_Exception(ICF_Exception::INVALID_MODEL_FILE_NAME);
			
		} elseif(strpos($childFileData['class_name'], 'Model_') === false) {
			
			throw new ICF_Exception(ICF_Exception::INVALID_MODEL_CLASS_NAME);
			
		}
		
	}
	
    public function retrieveChildData($backtraceData) {
		
		$childFileData['file']       = $backtraceData[0]['file'];
		$childFileData['class_name'] = $backtraceData[1]['class'];
		
		return $childFileData;
	}
	
}

?>