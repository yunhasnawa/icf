<?php

namespace ICF\Core;

use ICF\Component\View;
class Page
{
	private $pageData;
	private $uri;
	private $controller;
	private $html;
	
	public function __construct(array $pageData)
	{
		$this->pageData = $pageData;
		
		$this->retrieveUri();
		$this->retrieveController();
		$this->retrieveHtml();
	}
	
	private function retrieveUri()
	{
		$this->uri = $this->pageData['uri'];
	}
	
	private function retrieveController()
	{
		$this->controller = $this->pageData['controller'];
	}
	
	private function retrieveHtml()
	{
		$this->html = $this->pageData['html'];
	}
	
	private function controllerFilePath($applicationPath)
	{
		$controllerPath = $applicationPath . "/controller";
		
		$controllerFilePath = "$controllerPath/{$this->controller}.php";
		
		return $controllerFilePath;
	}
	
	// Getters
	
	public function getUri()
	{
		return $this->uri;
	}
	
	public function getClass()
	{
		return $this->class;
	}
	
	public function getHtml()
	{
		return $this->html;
	}
	
	// Privates
	
	private function cleanUri()
	{
		$explode = explode('.', $this->getUri());
	
		$clean = $explode[0];
	
		return $clean;
	}
	
	private function extractMethodName($validUri)
	{	
		//echo "$validUri</br>";
		$methodName = null;
		
		$replace = str_replace(($this->cleanUri() . '/'), '', $validUri);
		
		if(!empty($replace))
		{
			$methodName = $replace;
		}
	
		return $methodName;
	}
	
	// Publics
	public function open(Application $application)
	{
		$controllerNamespace = $application->getNamespace() . '\\Controller\\';
		
		$controllerName = $controllerNamespace . $this->controller;
		
		$controller = new $controllerName($application, $this);
		
		$methodName = $this->extractMethodName($application->getCurrentUri());
		
		if($methodName != null)
		{
			if(method_exists($controller, $methodName))
			{
				$controller->$methodName();
			}
			else 
			{
				View::render404();
			}
		}
		else 
		{
			$controller->initialize();
		}
	}
	
	public function isValidUri($uri)
	{
		$explode = explode('/', $uri);
	
		$count = count($explode);
	
		if($count > 2 && $count < 5)
		{
			$firstSegments = implode('/', array($explode[0]. $explode[1], $explode[2]));
			$firstSegments = "/$firstSegments";
				
			if($firstSegments == $this->cleanUri())
			{
				return true;
			}
		}
	
		return false;
	}
}

?>