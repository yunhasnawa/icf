<?php
/**
 * @author Yoppy Yunhasnawa
 * @copyright 2011
 */
namespace icf\main;

require_once 'icf/main/ICF_Object.php';
require_once 'icf/library/Base.php';

use icf\library\Base;

class ICF_Application extends ICF_Object
{
	private $_url;
	private $_controllerNamespace;
	private $_controllerName;
	private $_methodName; // $controller's method
	private $_route;
	private $_args;
	private $_subdomain;
	private $_rootUrl;
	private $_path;
	private $_moduleName;
	private $_routeAddress;

	public function __construct($url, $route)
	{
		parent::__construct();
			
		$this->_url       = strtolower($url);
		$this->_route     = $route;
		$this->_args      = array();
		$this->_subdomain = ''; // FIXME: Not all field constructed
		
		if($this->checkRoute())
		{
			$this->_requireControllerFile();
			$this->_saveGlobalVars();
		}
		else 
		{
			die('Controller not found!');
		}
	}

	public function execute()
	{
		$cn = $this->getControllerNamespace() . '\\' . $this->_controllerName;
		$mn = $this->_methodName;

		$controller = new $cn();

		$request = array(
			'post' => $_POST,
			'get'  => $_GET
		);

		$controller->$mn($this->_args, $request);
	}
	
	private function checkRoute()
	{
		$found = false;
		
		foreach ($this->_route as $moduleName => $module)
		{
			if($this->getModuleName() == $moduleName)
			{
				foreach ($module as $routeAddress => $controller)
				{
					if($this->getRouteAddress() == $routeAddress)
					{
						foreach ($controller as $controllerName => $methodName)
						{
							$this->_controllerName = $controllerName;
							$this->_methodName     = $methodName;
							
							$found = true;
							
							break;
						}
					}
				}
			}
		}
		/*
		echo 'ROUTE:'; Base::arrdeb($this->_route);
		echo 'URL:'; Base::arrdeb($this->_url);
		echo 'ROOT URL:'; Base::arrdeb($this->getRootUrl());
		echo 'PATH:'; Base::arrdeb($this->getPath());
		echo 'MODULE NAME:'; Base::arrdeb($this->getModuleName());
		echo 'ROUTE ADDRESS:'; Base::arrdeb($this->getRouteAddress());
		echo 'CN:'; Base::arrdeb($this->_controllerName);
		echo 'MN:'; Base::arrdeb($this->_methodName);
		*/
		
		return $found;
	}

	private static function _cutSubdomain($url)
	{
		$expl = explode('.', $url);

		$urlNew = '';

		if(count($expl) > 2) {

			$urlNew .= $expl[1] . '.'  . $expl[2];

			$subdomain = $expl[0];

			$this->_subdomain = $subdomain;

		} else $urlNew = $url;

		return $urlNew;
	}

	private static function _cutQueryUrl($url)
	{
		$delimiter = strpos($url, '?') !== false ? '?' : '&';
			
		$expl = explode($delimiter, $url);
			
		return $expl[0];
	}

	private static function _proccessArgs($request, $path)
	{
		$strArgs = str_replace($path, '', $request);
			
		if(!empty($strArgs)) {

			if($strArgs[0] == '/') $strArgs = substr($strArgs, 1);

			$args = explode('/', $strArgs);

			$this->_args = $args;

		}
	}
	
	private function _requireControllerFile()
	{
		$filePath = $this->getControllerFilePath();
		
		if(!is_file($filePath)) die('Sorry, controller file not found!');
		
		require_once $filePath;
	}
	
	private function _saveGlobalVars()
	{
		ICF_Globals::$CONTROLLER = $this->_controllerName;
		ICF_Globals::$METHOD     = $this->_methodName;
		ICF_Globals::$MODULE     = $this->getModuleName();
	}
	
	public function getControllerNamespace()
	{
		$setting = ICF_Setting::getInstance();
		
		return $this->getModuleName() . '\\' . $setting->siteControllerDirectory; 
	}
	
	public function getControllerFilePath()
	{
		$setting = ICF_Setting::getInstance();
		
		$filename = Base::siteDir($setting->siteModuleDirectory);
		
		$filename .= '/' . $this->getModuleName();
		$filename .= '/' . $setting->siteControllerDirectory;
		$filename .= '/' . $this->_controllerName . '.php';
		
		return $filename;
	}
	
	public function getPath()
	{
		if($this->_path == null)
		{
			$clearUrl = ICF_Application::_cutQueryUrl($this->_url);
			
			$this->_path = str_replace($this->getRootUrl(), '', $clearUrl);
		}
		
		return $this->_path;
	}
	
	public function getRootUrl()
	{
		if($this->_rootUrl == null)
		{
			$settingUrl = ICF_Setting::getInstance()->siteUrl;
			
			if(!empty($settingUrl))
			{
				$this->_rootUrl = $settingUrl;
			}	
			else 
			{
				$segments = explode('/', $this->_url);
				
				$this->_rootUrl = $segments[0];
			}
		}
		
		return $this->_rootUrl;
	}
	
	public function getModuleName()
	{
		if($this->_moduleName == null)
		{
			$segments = explode('/', $this->getPath());
			
			$segment0 = $segments[0];
			
			if(empty($segment0))
			{
				if(count($segments) > 2)
				{
					$segment0 = $segments[1];
				}
			}
			
			$this->_moduleName = $segment0;
		}
		
		return $this->_moduleName;
	}
	
	public function getRouteAddress()
	{
		if($this->_routeAddress == null)
		{
			$path = $this->getPath();
			
			$routeAddress = str_replace($this->getModuleName(), '', $path);
			$routeAddress = str_replace('//', '', $routeAddress);
			
			$this->_routeAddress = $routeAddress;
		}
		
		return $this->_routeAddress;
	}
}


?>