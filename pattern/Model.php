<?php

namespace icf\pattern;

require_once 'icf/data_context/Database_Access.php';
require_once 'icf/data_context/Connection_Account.php';
require_once 'icf/main/ICF_Exception.php';

use icf\main\ICF_Setting;
use icf\main\ICF_Exception;
use icf\pattern\IPattern;
use icf\data_context\Database_Access;
use icf\library\Sql;
use icf\library\Base;
use icf\main\ICF_Globals;
  
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
	
	protected function __construct($table = '') 
	{	
		$this->table = $table;
		
		$this->databaseAccess = Database_Access::factory();
		
		$this->sql = new Sql($table);
		
		$dir = dirname(__FILE__);
		
		$backtraceData = debug_backtrace();
		
		$childFileData = $this->retrieveChildData($backtraceData);
		
		$this->validateChild($childFileData);	
	}
	
	public function validateChild($childFileData) 
	{	
		$modelDir = Base::siteDir(array(
			ICF_Setting::getInstance()->siteModuleDirectory,
			ICF_Globals::$MODULE,
			ICF_Setting::getInstance()->siteModelDirectory
		));
		
		// FIXME: Windows path compatibility issue
		
		$childArray = explode(Base::getSlash(), $childFileData['file']);

		$childFileName = $childArray[(count($childArray) - 1)];
		
		unset($childArray[(count($childArray) - 1)]);
		
		$childDir = implode(Base::getSlash(), $childArray);
		
		if($modelDir != $childDir) 
		{	
			throw new ICF_Exception(ICF_Exception::INVALID_MODEL_DIRECTORY);
		}
		elseif(strpos($childFileName, 'Model_') === false) 
		{	
			throw new ICF_Exception(ICF_Exception::INVALID_MODEL_FILE_NAME);	
		}
		elseif(strpos($childFileData['class_name'], 'Model_') === false) 
		{	
			throw new ICF_Exception(ICF_Exception::INVALID_MODEL_CLASS_NAME);	
		}
	}
	
    public function retrieveChildData($backtraceData) 
    {	
		$childFileData['file']       = $backtraceData[0]['file'];
		$childFileData['class_name'] = $backtraceData[1]['class'];
		
		return $childFileData;
	}
}

?>