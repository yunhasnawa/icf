<?php

namespace framework\icf\pattern;

use framework\icf\main\ICF_Globals;
use framework\icf\library\Base;

/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */

class View {
	// TODO: Implement IPattern on View class
	public $windowTitle;
	public $pageTitle;
	public $date;
	public $time;

	private $_auth;
	
	private function __construct($auth)
	{
		$this->_initializeVariables($auth);
	}
	
	private function _initializeVariables($auth)
	{
		$this->windowTitle = "ICF Web Application";
		$this->pageTitle   = "ICF Web Page";
		$this->date        = date("Y-m-d");
		$this->time        = date("H:i:s");
		$this->_auth       = $auth;
	}
	
	public static function factory($auth)
	{
		if(empty(ICF_Globals::$VIEW)) {
				
			$instance = new View($auth);
				
		} else {
			
			$instance = ICF_Globals::$VIEW;
			
		}
		
		return $instance;
	}
	
	public function render($viewFileName, $parameter = '') {
		
		$viewFile = Base::site_dir("view/$viewFileName" . '.php');
		
		if(!empty($parameter)) {
		
			foreach($parameter as $varName => $value) {
				$$varName = $value;
			}
		}
		
		include $viewFile;
		// FIXME: Lack support for multi sites/subdomain
	
	}
}

?>