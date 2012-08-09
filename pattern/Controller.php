<?php

namespace framework\icf\pattern;

use framework\icf\main\ICF_Setting;

use framework\icf\main\ICF_Object;
use framework\icf\library\Auth;

/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */

class Controller extends ICF_Object implements IPattern{
	
	protected $view;
	protected $auth;
	
	public $application;
	
	public function __construct() {
		
		parent::__construct();
		
		$this->auth = Auth::factory();
		
		$this->_initializeView();
		
		$this->application = new ICF_Object();
	}
	
	private function _initializeView()
	{
		$this->view = View::factory($this->auth);
		$this->view->pageTitle = ICF_Setting::SITE_NAME;
		$this->view->windowTitle = ICF_Setting::SITE_NAME . ' v' . ICF_Setting::SITE_VERSION;
	}
	
	public function validateChild($childFileData) {
		// TODO: Implement Controller::validateChild
	}
	
	public function retrieveChildData($backtraceData) {
		// TODO: Implement Controller::retrieveChildData
	}
}

?>