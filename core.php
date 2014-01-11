<?php

namespace icf;

require_once 'icf/config/Config.php';
require_once 'icf/config/Route.php';
require_once 'icf/main/ICF_Globals.php';
require_once 'icf/main/ICF_Application.php';

use icf\config\Route;
use icf\config\Config;
use icf\main\ICF_Globals;
use icf\main\ICF_Application;

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));
/**
 * Display error on browser.
 */
ini_set('display_errors', true);
/**
 * Log error on error_log.txt.
 */
ini_set('log_errors', true);
ini_set('error_log', 'log/error_log.txt');
/**
 * Activate all type of error with strict PHP convention.
 */
error_reporting(E_ALL|E_STRICT);

class Core
{
	private static $_instance;
	
	private $_config;
	private $_route;
	
	private function __construct()
	{
		$this->loadConfig();
		
		$this->loadRoute();
	}
	
	public static function getInstance()
	{
		if(Core::$_instance == null)
		{
			Core::$_instance = new Core();
		}
		
		return Core::$_instance;
	}
	
	private function loadConfig()
	{
		$this->_config = Config::get();
	}
	
	private function loadRoute()
	{		
		$this->_route = Route::get();
	}
	
	public function go()
	{
		$this->_saveSiteDir();
		
		$this->_saveBrowserUrl();
		
		$this->_executeApplication();
	}
	
	private function _saveSiteDir()
	{
		$dir = dirname(__DIR__);
		
		ICF_Globals::$SITE_DIR = $dir;
	}
	
	private function _saveBrowserUrl()
	{
		$requestUri = $_SERVER['REQUEST_URI'] == '' ? '/index.php' : $_SERVER['REQUEST_URI'];
		
		$url = $_SERVER['SERVER_NAME'] . $requestUri;
		
		ICF_Globals::$BROWSER_URL = $url;
	}
	
	private function _executeApplication()
	{
		$app = new ICF_Application(ICF_Globals::$BROWSER_URL, $this->_route);
		
		$app->execute();
	}
}

?>