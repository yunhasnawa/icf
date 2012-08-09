<?php

namespace framework\icf\main;

use framework\icf\library\Base;

class ICF_Object {
	
	private $_className;
	private $_childName;
	
	protected function __construct()
	{
		$this->_retriveClassName();
	}
	
	public function getChildName()
	{
		return $this->_childName;
	}
	
	public function getClassName()
	{
		return $this->_className;
	}
	
	public function _retriveClassName()
	{
		$debug = debug_backtrace();
		
		$last = end($debug);
		
		if(isset($last['class']))
			$this->_className = $last['class'];
		else
			$this->_className = __CLASS__;
		
		if($this->_className == __CLASS__)
			$this->_childName = false;
		else 
			$this->_childName = $this->_className;
		
		unset($debug);
	}
	
	public function toString()
	{
		return $this->getClassName();
	}
	
}

?>