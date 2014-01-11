<?php

namespace icf\pattern;

require_once 'icf/main/ICF_Object.php';
require_once 'icf/pattern/IPattern.php';
require_once 'icf/main/ICF_Setting.php';
require_once 'icf/library/Auth.php';
require_once 'icf/pattern/View.php';

use icf\main\ICF_Object;
use icf\pattern\IPattern;
use icf\library\Auth;
use icf\main\ICF_Setting;
use icf\pattern\View;

/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */

class Controller extends ICF_Object implements IPattern
{
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
		$this->view->pageTitle = ICF_Setting::getInstance()->siteName;
		$this->view->windowTitle = ICF_Setting::getInstance()->siteName . ' v' . ICF_Setting::getInstance()->siteName;
	}
	
	public function validateChild($childFileData) 
	{
		// TODO: Implement Controller::validateChild
	}
	
	public function retrieveChildData($backtraceData) 
	{
		// TODO: Implement Controller::retrieveChildData
	}
}

?>